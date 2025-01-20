<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraHasMedicamento extends Model
{
    use HasFactory;

    protected $table = 'compras_has_medicamento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'compra_id',
        'medicamento_referencia',
        'quantidade',
    ];

    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    public static function createByCompositeKey($referencia, $quantidade, $compraId)
    {
        $compraHasMedicamento = new CompraHasMedicamento();
        $compraHasMedicamento->compra_id = $compraId;
        $compraHasMedicamento->medicamento_referencia = $referencia;
        $compraHasMedicamento->quantidade = $quantidade;

        return $compraHasMedicamento->save();
    }
}
