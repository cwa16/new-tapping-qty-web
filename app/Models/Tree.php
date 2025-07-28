<?php

namespace App\Models;

use App\Models\TreeAssessment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tree extends Model
{
    /** @use HasFactory<\Database\Factories\TreeFactory> */
    use HasFactory;

    public function treeAssessments(): HasMany
    {
        return $this->hasMany(TreeAssessment::class);
    }
}
