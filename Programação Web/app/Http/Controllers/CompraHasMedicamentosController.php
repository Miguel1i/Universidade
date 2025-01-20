<?php

namespace App\Http\Controllers;

use App\Models\CompraHasMedicamento;
use Illuminate\Http\Request;

class CompraHasMedicamentosController extends Controller
{
    public function addOrCreate(Request $request)
    {
        $items = json_decode($request['items']);
        $compraId = $request['compra_id'];

        $validate = null;
        foreach ($items as $item) {
            $validate = CompraHasMedicamento::createByCompositeKey(
                $item->medicamento->referencia,
                $item->quantidade,
                $compraId
            );
            MedicamentoController::updateStock($item->medicamento->referencia, $item->quantidade);
        }

        if (!$validate) {
            return redirect('status')->with('error', 'Erro ao realizar compra');
        }

        return redirect('status')->with('success', 'Compra realizada com sucesso');
    }
}
