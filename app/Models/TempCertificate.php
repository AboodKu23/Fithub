<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TempCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_name',
        'issuing_organization',
        'issue_date',
        'expiry_date',
        'certificate_file',
        'temp_user_token',
    ];

    public function tempUser() : BelongsTo
    {
        return $this->belongsTo(TempUser::class, 'temp_user_token', 'temp_token');
    }
}
