<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id', 'status'];

    const PENDING_STATUS = 1;
    const PROGRESS_STATUS = 2;
    const BLOCKED_STATUS = 3;
    const COMPLETED_STATUS = 4;

    /**
     * Get the user that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusName()
    {
        switch ($this->status) {
            case TASK::PENDING_STATUS:
                return 'Pending';
            break;
            case TASK::PROGRESS_STATUS:
                return 'In Progress';
            break;
            case TASK::BLOCKED_STATUS:
                return 'Blocked';
            break;
            case TASK::COMPLETED_STATUS:
                return 'Completed';
            break;
            default:
                return 'Pending';
            break;
        }
    }

    /**
     * Get all of the comments for the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all of the comments for the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
