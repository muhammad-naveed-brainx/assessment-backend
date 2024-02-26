<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feedback extends Model
{
    use HasFactory;
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:M j, Y h:i A',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'category',
        'description',
    ];

    /**
     * Get the feedback category.
     */
    protected function category(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                // Map category values to their corresponding human-readable labels
                $categoryMapping = [
                    'bug' => 'Bug Report',
                    'feature' => 'Feature Request',
                    'improvement' => 'Improvement',
                    'other' => 'Other'
                ];
                return $categoryMapping[$value] ?? 'Other';
             },
        );
    }

    /**
     * Get the user that owns the feedback.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the comments associated with the feedback.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
