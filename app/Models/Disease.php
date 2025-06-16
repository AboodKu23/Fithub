<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disease extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function trainees(): BelongsToMany
    {
        return $this->belongsToMany(Trainee::class, 'trainee_diseases', 'disease_id', 'trainee_id');
    }
}
