<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trainer extends Model
{
    use HasFactory;

    protected $table = 'trainers';

    protected $fillable = [
        'trainer_id',
        'Bio',
        'experience_years',
        'subscriber_count',
        'rating',
        'rating_weight_subscribers',
        'rating_weight_certificates',
        'rating_weight_trainee_feedback',
        'last_rating_calculated_at',
    ];

    protected $casts = [
        'overall_rating' => 'decimal:2',
        'rating_weight_subscribers' => 'decimal:2',
        'rating_weight_certificates' => 'decimal:2',
        'rating_weight_trainee_feedback' => 'decimal:2',
        'last_rating_calculated_at' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'trainer_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function subscriptionRequests(): HasMany
    {
        return $this->hasMany(SubscriptionRequests::class,'trainer_id','id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class,'trainer_id','id');
    }

    public function Posts(): HasMany
    {
        return $this->hasMany(Post::class,'publisher_id','id');
    }

    public function verifiedCertificates()
    {
        return $this->certificates()->where('verification_status', 'Verified');
    }
}
