<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TempUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'temp_token',
        'first_name',
        'last_name',
        'gender',
        'phone_number',
        'country',
        'city',
        'region',
        'email',
        'password',
    ];

    public function certificates() : HasMany
    {
        return $this->hasMany(TempCertificate::class);
    }
}
