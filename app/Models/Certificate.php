<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'trainer_id',
        'certificate_name',
        'issuing_organization',
        'issue_date',
        'verification_status',
        'expiry_date',
        'certificate_file',
        'verified_by',
        'verified_at'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'verified_at' => 'date',
       // 'verification_status' => \App\Enums\VerificationStatusEnum::class, // Assuming Enum
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'id');
    }

    public function verifiedBy() : BelongsTo
    {
        return $this->belongsTo(Admin::class, 'verified_by', 'id');
    }
}
