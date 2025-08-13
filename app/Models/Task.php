<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    // mass assignable fields
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'is_completed',
    ];

    // casts ensure boolean/date behavior when reading/writing
    protected $casts = [
        'is_completed' => 'boolean',
        'due_date' => 'date',
        'deleted_at' => 'datetime',
    ];

    // Task belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope to get tasks that will expire soon (for cleanup)
    public function scopeExpiredTrash($query)
    {
        return $query->onlyTrashed()
                    ->where('deleted_at', '<', now()->subDays(30));
    }
}