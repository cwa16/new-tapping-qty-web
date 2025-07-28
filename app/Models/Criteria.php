<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criteria extends Model
{
    /** @use HasFactory<\Database\Factories\CriteriaFactory> */
    use HasFactory;

    public function treeAssessments(): HasMany
    {
        return $this->hasMany(TreeAssessment::class);
    }
}
