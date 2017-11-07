<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoligonoAmbito extends Model
{
    //
    protected $table = 'ambitos_poligonos';

    protected $fillable = [
        'coordenadas'
    ];
}
