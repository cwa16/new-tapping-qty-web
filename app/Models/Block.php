<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'blocks';

    protected $fillable = [
        'block_code',
        'block_name',
        'year_planting',
        'clone',
        'dept',
    ];
}
