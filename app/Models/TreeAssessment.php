<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeAssessment extends Model
{
    /** @use HasFactory<\Database\Factories\TreeAssessmentFactory> */
    use HasFactory;

    public function tree()
    {
        return $this->belongsTo(Tree::class);
    }
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function assessmentDetail()
    {
        return $this->belongsTo(AssessmentDetail::class);
    }
}
