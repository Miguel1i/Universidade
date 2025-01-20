<?php

namespace App\Http\Controllers;

use App\Models\CarrinhoHasMedicamento;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CarrinhoHasMedicamentosController extends Controller
{


    public function addOrCreate(Request $request)

    {
        $userEmail = $request['user_email'];
        $referencia = $request['referencia'];
        $quantidade = $request['quantidade'];



        $validate = CarrinhoHasMedicamento::updateOrCreateByCompositeKey(
            $userEmail,
            $referencia,
            $quantidade
        );

        if (!$validate) {
            return redirect()->back()->with('error', 'Quantidade indisponível');
        }

        return redirect()->back()->with('success', 'Item adicionado ao carrinho com sucesso');
    }

    public function updateQuantity(Request $request)
    {

        $referencia = $request->input('medicamento_referencia');
        $quantidade = $request->input('quantidade');
        $action = $request->input('action');

        $quantidadeCarrinho = $quantidade;

        if ($action === 'increase' ) {
            $quantidadeCarrinho += 1;
        } elseif ($action === 'decrease' && $quantidade > 1) {
            $quantidadeCarrinho -= 1;
        } else {
            $quantidadeCarrinho = max($quantidade, 1);
        }


        $validate = CarrinhoHasMedicamento::updateOrCreateByCompositeKey(
            Auth::user()->email,
            $referencia,
            $quantidadeCarrinho
        );

        if (!$validate) {
            return redirect()->back()->with('error', 'Quantidade indisponível');
        } else{
            return redirect()->back();
        }

    }


    public function removeItem(Request $request)
    {
        $referencia = $request->input('medicamento_referencia');

        CarrinhoHasMedicamento::deleteByCompositeKey(Auth::user()->email, $referencia);


        return redirect()->back();
    }

    public function index(string $view) {

        $carrinho = CarrinhoHasMedicamento::where('user_email', Auth::user()->email)->get();

        $items = [];

        $total = 0;
        foreach ($carrinho as $item) {
            $medicamento = Medicamento::where('referencia', $item->medicamento_referencia)->firstOrFail();
            if ($medicamento) {
                $items[] = [
                    'medicamento' => $medicamento,
                    'quantidade' => $item->quantidade
                ];
                $total += $medicamento->preco * $item->quantidade;
            }
        }

        return view($view, [
            'items' => $items,
            'total' => $total
        ]);
    }
}
