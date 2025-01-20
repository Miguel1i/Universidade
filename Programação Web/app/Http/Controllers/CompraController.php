<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Models\CarrinhoHasMedicamento;
use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    public function pagamento(Request $request)
    {
        $userEmail = Auth::user()->email;
        $total = $request->input('total');
        $produtos = $request->input('items');

        $compra = Compra::create([
            'total' => $total,
            'data' => now(),
            'user_email' => $userEmail,
        ]);

        CarrinhoHasMedicamento::where('user_email', $userEmail)->delete();

        return redirect()->route('compra.addOrCreate', [
            'items' => $produtos,
            'compra_id' => $compra->id,
        ]);
    }
}
