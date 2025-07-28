<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Tapper extends Model
{
    use HasFactory;

    public function assessmentDetails(): HasMany
    {
        return $this->hasMany(AssessmentDetail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
