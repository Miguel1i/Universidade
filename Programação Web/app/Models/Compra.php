<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';

    protected $fillable = [
        'user_email',
        'total',
        'data',
    ];

    public $timestamps = false;

    public $incrementing = true;

    protected $keyType = 'int';




}
