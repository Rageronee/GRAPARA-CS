<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'sla_minutes'];

    public function queues()
    {
        return $this->hasMany(Queue::class, 'category_id');
    }
}
