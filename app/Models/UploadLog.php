<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadLog extends Model
{
    public function assessment_details()
    {
        return $this->belongsTo(AssessmentDetail::class, 'assessment_code', 'assessment_code');
    }
}
