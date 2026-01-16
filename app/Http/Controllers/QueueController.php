<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Service;
use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QueueController extends Controller
{
    // Customer: Get a ticket
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'customer_name' => 'nullable|string',
            'customer_phone' => 'nullable|string',
            'issue_detail' => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);

        $count = Queue::where('service_id', $service->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $number = $count + 1;
        $ticketNumber = $service->code . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        $queue = Queue::create([
            'ticket_number' => $ticketNumber,
            'service_id' => $service->id,
            'user_id' => Auth::id(), // Link to registered user
            'customer_name' => $request->customer_name ?: (Auth::check() ? Auth::user()->name : 'Guest'),
            'customer_phone' => $request->customer_phone,
            'issue_detail' => $request->issue_detail,
            'status' => 'waiting',
        ]);

        if (Auth::check() && Auth::user()->role === 'customer') {
            return redirect('/')->with('message', 'Tiket Antrian ' . $ticketNumber . ' Berhasil Dibuat!');
        }

        return redirect()->route('queue.show', $queue->id);
    }

    public function show(Queue $queue)
    {
        return view('queue.ticket', compact('queue'));
    }

    // CS: Call Next (FIFO)
    public function next(Request $request)
    {
        $user = Auth::user();
        $serviceId = $request->input('service_id');

        $queue = Queue::where('status', 'waiting')
            ->where('service_id', $serviceId)
            ->orderBy('created_at', 'asc')
            ->first();

        if (!$queue) {
            return back()->with('error', 'Antrian kosong untuk layanan ini.');
        }

        $queue->update([
            'status' => 'calling',
            'served_by_user_id' => $user->id,
            'called_at' => now(),
        ]);

        return back()->with('queue', $queue)->with('message', 'Memanggil nomor ' . $queue->ticket_number);
    }

    // CS: Auto Call Logic (Priority > Time)
    // CS: Auto Call Logic (Priority > Time)
    public function callAuto(Request $request)
    {
        try {
            $user = Auth::user();

            // Logic: Prioritize Service 3 (Tech) > 2 (Teller) > 1 (CS), then Oldest First
            $queue = Queue::where('status', 'waiting')
                ->orderBy('service_id', 'desc')
                ->orderBy('created_at', 'asc')
                ->first();

            if (!$queue) {
                return back()->with('error', 'Tidak ada antrian menunggu saat ini.');
            }

            $queue->update([
                'status' => 'calling',
                'served_by_user_id' => $user->id,
                'called_at' => now(),
            ]);

            return back()->with('queue', $queue)->with('message', 'Auto-Call Berhasil: ' . $queue->ticket_number);
        } catch (\Exception $e) {
            return back()->with('error', 'Auto Call Gagal: ' . $e->getMessage());
        }
    }

    // ADMIN/CS: Direct Call Specific Ticket (Cherry Picking)
    public function callSpecific(Queue $queue)
    {
        $user = Auth::user();

        if ($queue->status !== 'waiting') {
            return back()->with('error', 'Tiket ini tidak dalam status menunggu.');
        }

        $queue->update([
            'status' => 'calling',
            'served_by_user_id' => $user->id,
            'called_at' => now(),
        ]);

        return back()->with('queue', $queue)->with('message', 'Melayani tiket khusus ' . $queue->ticket_number);
    }

    // CS: Complete & Respond
    public function complete(Request $request, Queue $queue)
    {
        $request->validate([
            'staff_response' => 'nullable|string'
        ]);

        $queue->update([
            'status' => 'completed',
            'staff_response' => $request->staff_response,
            'served_at' => $queue->served_at ?? now(),
            'completed_at' => now(),
        ]);

        return back()->with('message', 'Tiket ' . $queue->ticket_number . ' selesai.');
    }

    // User: Cancel Ticket (Batalkan)
    public function cancel(Queue $queue)
    {
        if (Auth::id() !== $queue->user_id)
            return back()->with('error', 'Akses ditolak.');
        if ($queue->status !== 'waiting')
            return back()->with('error', 'Tiket sudah diproses.');

        $queue->update([
            'status' => 'skipped',
            'completed_at' => now(),
            'staff_response' => 'Dibatalkan oleh pengguna.'
        ]);

        return back()->with('message', 'Tiket berhasil dibatalkan.');
    }

    // API/Ajax for User History
    public function history()
    {
        if (!Auth::check())
            return response()->json([]);

        // Prioritize User ID, fallback to name match
        $query = Queue::query();
        if (Auth::id()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('customer_name', Auth::user()->name);
        }

        $queues = $query->orderBy('created_at', 'desc')
            ->with('service')
            ->take(10)
            ->get();

        return response()->json($queues);
    }
}
