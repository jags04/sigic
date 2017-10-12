<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    //
    protected $table = 'produccion';

    protected $fillable = [
        'rif', 'producto', 'medida', 'produccion', 'fecha'
    ];
}
