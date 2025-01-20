<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'referencia',
        'nome',
        'quantidade',
        'industria',
        'dosagem',
        'forma',
        'preco',
        'descricao',
        'imagem',
    ];

    protected $primaryKey = 'referencia';
    public $incrementing = false;
    protected $keyType = 'integer';

}
