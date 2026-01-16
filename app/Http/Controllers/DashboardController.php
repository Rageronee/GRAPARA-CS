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

            return view('admin.dashboard', compact('stats', 'incomingReports', 'liveStatus', 'historyLogs'));

        } elseif ($user->hasRole('cs')) {
            // CS View
            // Fetch ALL waiting tickets (FIFO), regardless of service type
            // Or maybe filter by what CS can handle? For now, show ALL.
            $complaints = Queue::where('status', 'waiting')
                ->orderBy('created_at', 'asc')
                ->get();

            return view('cs.dashboard', compact('complaints'));
        } elseif ($user->hasRole('manager')) {
            return view('manager.dashboard');
        } else {
            return view('customer.dashboard');
        }
    }
}
