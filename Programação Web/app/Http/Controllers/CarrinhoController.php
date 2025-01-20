<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{

    public function add(Request $request)
    {
        $userEmail = Auth::user()->email;
        $referencia = $request->referencia;
        $quantidade = $request->input('quantidade');


        Carrinho::firstOrCreate(['user_email' => $userEmail]);


        return redirect()->route('carrinho.addOrCreate', [
            'user_email' => $userEmail,
            'referencia' => $referencia,
            'quantidade' => $quantidade
        ]);

    }
}
