<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueLog extends Model
{
    use HasFactory;

    protected $fillable = ['queue_id', 'actor_id', 'action', 'payload'];

    protected $casts = [
        'payload' => 'array',
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
