<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes, HasFactory;

    const PENDING = 'pending';   // в ожидании
    const IN_DEVELOPMENT = 'in_development'; // в разработке
    const IN_TESTING = 'in_testing'; // на тестировании
    const IN_REVIEW = 'in_review';  // на проверке
    const COMPLETED = 'completed'; // выполнено

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text',
        'status',
        'project_id',
        'user_id',
        'is_completed',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
