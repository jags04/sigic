<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoComplemantaria extends Model
{
    //
    protected $table = 'planta_info_comp';
    protected $fillable = [
        "fecha" , "mobra" , "cinstalada" , "coperativa" , "produccion" , "inventario" ,"pprincipal" , "ncritico" , "observacion" , "planta_id"
    ];
}
