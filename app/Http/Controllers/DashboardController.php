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

        // 1. Check for PERSISTENT ACTIVE TICKET (Calling/Serving by this user)
        // This ensures if they refresh, they don't lose the ticket.
        $activeQueue = Queue::where('served_by_user_id', $user->id)
            ->whereIn('status', ['calling', 'serving'])
            ->first();

        // If we found an active queue in DB but nothing in session, re-flash it so the view sees it
        if ($activeQueue && !session('queue')) {
            session()->now('queue', $activeQueue);
        }

        if ($user->hasRole('admin')) {
            // Admin Dashboard Data

            // 1. Stats Cards
            $stats = [
                'total_today' => Queue::whereDate('created_at', Carbon::today())->count(),
                // Pending is ANYONE waiting, not just complaints
                'pending_complaints' => Queue::where('status', 'waiting')->count(),
                'staff_active' => User::whereIn('role', ['cs', 'manager'])->count(),
                'completed_today' => Queue::whereDate('completed_at', Carbon::today())->count(),
            ];

            // 2. Incoming Reports (Recent tickets - SHOW ALL Waiting)
            $incomingReports = Queue::where('status', 'waiting')
                ->orderBy('created_at', 'asc') // FIFO (First In First Out)
                ->take(10)
                ->get();

            // 3. Live Queue Status (Active counters)
            $liveStatus = Service::with([
                'queues' => function ($q) {
                    $q->where('status', 'calling')->orWhere('status', 'waiting');
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
                    'servedTickets as total_served' => function ($q) {
                        $q->where('status', 'completed');
                    }
                ])
                ->get()
                ->map(function ($staff) {
                    // Calculate Average Serve Time (in minutes)
                    $tickets = Queue::where('served_by_user_id', $staff->id)
                        ->whereNotNull('called_at')
                        ->whereNotNull('completed_at')
                        ->get();

                    $totalDuration = 0;
                    foreach ($tickets as $t) {
                        $totalDuration += Carbon::parse($t->completed_at)->diffInMinutes(Carbon::parse($t->called_at));
                    }

                    $staff->avg_serve_time = $tickets->count() > 0 ? round($totalDuration / $tickets->count(), 1) : 0;
                    $staff->status_label = $tickets->where('created_at', '>=', Carbon::today())->count() > 0 ? 'Active' : 'Offline';
                    return $staff;
                });

            return view('admin.dashboard', compact('stats', 'incomingReports', 'liveStatus', 'historyLogs', 'staffStats'));

        } elseif ($user->hasRole('cs')) {
            // CS View
            $complaints = Queue::where('status', 'waiting')
                ->orderBy('service_id', 'desc') // Tech > Regular
                ->orderBy('created_at', 'asc')
                ->get();

            // Fetch History for Active Customer (If serving)
            $activeQueue = session('queue') ?? Queue::where('served_by_user_id', $user->id)
                ->whereIn('status', ['calling', 'serving'])
                ->first();

            $customerHistory = [];
            if ($activeQueue) {
                // Find by User ID or Name
                $query = Queue::where('id', '!=', $activeQueue->id)
                    ->where('status', 'completed');

                if ($activeQueue->user_id) {
                    $query->where('user_id', $activeQueue->user_id);
                } else {
                    $query->where('customer_name', $activeQueue->customer_name);
                }

                $customerHistory = $query->orderBy('created_at', 'desc')->take(5)->get();
            }

            return view('cs.dashboard', compact('complaints', 'activeQueue', 'customerHistory'));
        } elseif ($user->hasRole('manager')) {
            return view('manager.dashboard');
        // Customer Role: Check for Unrated Tickets
        $unratedTicket = Queue::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereNull('rating')
            ->orderBy('completed_at', 'desc')
            ->first();

        if ($unratedTicket) {
             session()->now('rating_request', $unratedTicket);
             return view('welcome');
        }

        return redirect('/');
    }
}
