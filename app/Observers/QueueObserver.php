<?php

namespace App\Observers;

use App\Models\Queue;
use App\Models\QueueLog;
use Illuminate\Support\Facades\Auth;

class QueueObserver
{
    /**
     * Handle the Queue "created" event.
     */
    public function created(Queue $queue): void
    {
        QueueLog::create([
            'queue_id' => $queue->id,
            'actor_id' => Auth::id(), // Might be null if guest, but logic allows guest
            'action' => 'created',
            'payload' => [
                'ticket_number' => $queue->ticket_number,
                'status' => $queue->status->value,
            ],
        ]);
    }

    /**
     * Handle the Queue "updated" event.
     */
    public function updated(Queue $queue): void
    {
        if ($queue->isDirty('status')) {
            $oldStatus = $queue->getOriginal('status');
            $newStatus = $queue->status;

            QueueLog::create([
                'queue_id' => $queue->id,
                'actor_id' => Auth::id(),
                'action' => 'status_change',
                'payload' => [
                    'from' => $oldStatus instanceof \App\Enums\QueueStatus ? $oldStatus->value : $oldStatus,
                    'to' => $newStatus->value,
                    'note' => 'Status changed via system/staff action.',
                ],
            ]);
        }
    }
}
