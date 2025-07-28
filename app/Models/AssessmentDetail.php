<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AssessmentDetail extends Model
{
    /** @use HasFactory<\Database\Factories\AssessmentDetailFactory> */
    use HasFactory;

    protected $primaryKey = 'assessment_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'assessment_code',
        'nik_penyadap',
        'blok',
        'task',
        'kemandoran',
        'no_hancak',
        'tahun_tanam',
        'clone',
        'sistem_sadap',
        'panel_sadap',
        'jenis_kulit_pohon',
        'tanggal_inspeksi',
        'inspection_by',
    ];

    public function tapper()
    {
        return $this->belongsTo(Tapper::class, 'nik_penyadap', 'nik');
    }

    public function treeAssessments()
    {
        return $this->hasMany(TreeAssessment::class, 'assessment_code', 'assessment_code');
    }



    public function getRouteKey()
    {
        return (string) $this->getAttribute($this->getRouteKeyName());
    }
}
