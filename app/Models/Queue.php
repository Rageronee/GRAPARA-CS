<?php

namespace App\Models;

use App\Enums\QueueStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'user_id', // Authenticated customer ID
        'customer_name',
        'customer_phone',
        'status',
        'service_id',
        'served_by_user_id',
        'counter_id',
        'category_id', // New categorization
        'issue_detail', // Complaint details
        'staff_response', // CS feedback
        'called_at',
        'served_at',
        'completed_at',
        'rating',
        'feedback'
    ];

    protected $casts = [
        'status' => QueueStatus::class,
        'called_at' => 'datetime',
        'served_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function server() // The CS/User who served this queue
    {
        return $this->belongsTo(User::class, 'served_by_user_id');
    }

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }

    public function category()
    {
        return $this->belongsTo(ComplaintCategory::class);
    }

    public function logs()
    {
        return $this->hasMany(QueueLog::class);
    }

    public function scopeWaiting($query)
    {
        // Use Enum for strict query
        return $query->where('status', QueueStatus::WAITING);
    }
}
