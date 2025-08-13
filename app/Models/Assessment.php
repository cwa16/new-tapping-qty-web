<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_inspeksi',
        'dept',
        'nama_inspektur',
        'nik_penyadap',
        'nama_penyadap',
        'status',
        'kemandoran',
        'blok',
        'task',
        'tahun_tanam',
        'clone',
        'panel_sadap',
        'jenis_kulit_pohon',
        'item1_1',
        'item1_2',
        'item1_3',
        'item2_1',
        'item2_2',
        'item2_3',
        'item3_1',
        'item3_2',
        'item3_3',
        'item3_4',
        'item3_5',
        'item3_6',
        'item3_7',
        'item4_1',
        'item4_2',
        'item5_1',
        'item5_2',
        'item6_1',
        'item6_2',
        'item6_3',
        'item7_1',
        'item7_2',
        'item7_3',
        'item8',
        'item9',
        'item10',
        'nilai',
        'kelas_perawan',
        'kelas_pulihan',
        'kelas_nta'
    ];
}
