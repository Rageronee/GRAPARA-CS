<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Queue;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 1. Check for PERSISTENT ACTIVE TICKET
        $activeQueue = Queue::where('served_by_user_id', $user->id)
            ->whereIn('status', ['calling', 'serving'])
            ->first();

        // If we found an active queue in DB but nothing in session, re-flash it so the view sees it
        if ($activeQueue && !session('queue')) {
            session()->now('queue', $activeQueue);
        }

        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            // Admin Dashboard Data

            // Filter Logic
            $filter = request('filter', 'today');
            $dateQuery = match ($filter) {
                'week' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
                'month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
                default => [Carbon::today(), Carbon::today()->endOfDay()] // 'today'
            };

            // 1. Stats Cards (Filtered)
            $stats = [
                'total_today' => Queue::whereBetween('created_at', $dateQuery)->count(),
                'pending_complaints' => Queue::where('status', 'waiting')->count(),
                'staff_active' => User::whereIn('role', ['cs', 'manager'])->count(),
                'completed_today' => Queue::whereBetween('completed_at', $dateQuery)->count(),
            ];

            // 2. Incoming Reports (Top 5 Priority > Oldest) - DISPLAY ONLY
            $incomingReports = Queue::where('status', 'waiting')
                ->orderBy('service_id', 'desc') // Priority Services First
                ->orderBy('created_at', 'asc') // First In First Out
                ->take(5)
                ->get();

            // 3. Live Queue Status (Active counters)
            $liveStatus = Service::with([
                'queues' => function ($q) {
                    $q->where('status', 'calling')->orWhere('status', 'serving');
                }
            ])->get();

            // 4. History / Logs
            $historyLogs = Queue::where('status', 'completed')
                ->whereNotNull('staff_response')
                ->orderBy('completed_at', 'desc')
                ->take(10)
                ->with(['server', 'service'])
                ->get();

            // 5. Staff Performance Metrics (For Admin Assessment)
            $staffStats = User::whereIn('role', ['cs', 'manager'])
                ->withCount([
                    'servedTickets as total_served' => function ($q) use ($dateQuery) {
                        $q->where('status', 'completed')->whereBetween('completed_at', $dateQuery);
                    }
                ])
                ->get()
                ->map(function ($staff) use ($dateQuery) {
                    // Calculate Average Serve Time (in minutes) based on Filter
                    $tickets = Queue::where('served_by_user_id', $staff->id)
                        ->whereNotNull('completed_at')
                        ->whereBetween('completed_at', $dateQuery)
                        ->get();

                    $totalDuration = 0;
                    foreach ($tickets as $t) {
                        if ($t->called_at) {
                            $totalDuration += Carbon::parse($t->completed_at)->diffInMinutes(Carbon::parse($t->called_at));
                        }
                    }

                    $staff->avg_serve_time = $tickets->count() > 0 ? round($totalDuration / $tickets->count(), 1) : 0;
                    $staff->status_label = Queue::where('served_by_user_id', $staff->id)->whereIn('status', ['calling', 'serving'])->exists() ? 'Active' : 'Offline';

                    // Add Average Rating
                    $staff->avg_rating = $tickets->whereNotNull('rating')->avg('rating') ?? 0;

                    return $staff;
                });

            $viewName = $user->hasRole('manager') ? 'manager.dashboard' : 'admin.dashboard';
            return view($viewName, compact('stats', 'incomingReports', 'liveStatus', 'historyLogs', 'staffStats', 'filter'));
        }

        if ($user->hasRole('cs')) {
            // ... CS Logic (Same as before) ...
            $complaints = Queue::where('status', 'waiting') // Removed service_id restriction to show all ticket types
                ->orderBy('created_at', 'asc')
                ->get();

            // Fetch active ticket history if exists
            $customerHistory = null;
            if ($activeQueue) {
                // Find history for this customer (by name or phone, or user_id)
                $query = Queue::where('status', 'completed')->whereNotNull('staff_response');

                if ($activeQueue->user_id) {
                    $query->where('user_id', $activeQueue->user_id);
                } else {
                    $query->where('customer_name', $activeQueue->customer_name);
                }

                // Get ALL history, we will limit in View (implied by "View All" button request)
                // But for performance, let's take 20.
                $customerHistory = $query->orderBy('created_at', 'desc')->take(20)->get();
            }

            // Personalized Daily Stats
            $todayTickets = Queue::where('served_by_user_id', $user->id)
                ->whereDate('completed_at', now()->today())
                ->get();

            $myDailyStats = [
                'total_served' => $todayTickets->count(),
                'avg_rating' => $todayTickets->whereNotNull('rating')->avg('rating') ?? 0,
                'avg_time' => 0 // Placeholder, could be calculated if needed
            ];

            return view('cs.dashboard', compact('complaints', 'myDailyStats', 'customerHistory'));
        }

        // Customer Role: Check for Unrated Tickets
        return redirect('/');
    }
    // Landing Page Logic (Home)
    public function landing()
    {
        $user = Auth::user();

        // 1. If Guest, just show welcome
        if (!$user) {
            return view('welcome');
        }

        // 2. If Staff (Admin/CS/Manager), redirect to Dashboard
        if (in_array($user->role, ['admin', 'cs', 'manager'])) {
            return redirect()->route('dashboard');
        }

        return view('welcome');
    }

    // AJAX Endpoint for Smooth Polling
    public function updates()
    {
        if (!Auth::check() || !Auth::user()->hasRole('cs')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = Auth::user();

        // 1. Re-check Active Queue
        $activeQueue = Queue::where('served_by_user_id', $user->id)
            ->whereIn('status', ['calling', 'serving'])
            ->first();

        // Ensure session is synced for the view rendering
        if ($activeQueue) {
            session()->now('queue', $activeQueue);
        }

        // 2. Fetch Waiting Queues
        $complaints = Queue::where('status', 'waiting')
            ->orderBy('created_at', 'asc')
            ->get();

        // 3. Fetch Customer History if Active
        $customerHistory = null;
        if ($activeQueue) {
            $query = Queue::where('status', 'completed')->whereNotNull('staff_response');
            if ($activeQueue->user_id) {
                $query->where('user_id', $activeQueue->user_id);
            } else {
                $query->where('customer_name', $activeQueue->customer_name);
            }
            $customerHistory = $query->orderBy('created_at', 'desc')->take(20)->get();
        }

        // 4. Calculate Stats
        $todayTickets = Queue::where('served_by_user_id', $user->id)
            ->whereDate('completed_at', now()->today())
            ->get();

        $stats = [
            'total_served' => $todayTickets->count(),
            'avg_rating' => $todayTickets->whereNotNull('rating')->avg('rating') ?? 0,
        ];

        // 5. Render Partials
        $html_queue = view('components.cs.queue-list', compact('complaints'))->render();
        $html_active = view('components.cs.active-ticket', compact('customerHistory'))->render();

        return response()->json([
            'stats' => $stats,
            'html_queue' => $html_queue,
            'html_active' => $html_active,
        ]);
    }
}
