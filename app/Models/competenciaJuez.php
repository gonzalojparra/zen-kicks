<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenciaJuez extends Model
{
    use HasFactory;
    protected $table = 'competencia_juez';

    protected $fillable = [
        'id_juez',
        'id_competencia',
        'inscripto',
        // Agrega aquí los nombres de los campos adicionales
    ];
}