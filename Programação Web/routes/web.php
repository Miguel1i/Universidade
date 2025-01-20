<?php
use App\Http\Controllers\CarrinhoHasMedicamentosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CompraHasMedicamentosController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Middleware\IsAdmin;

// Página inicial
Route::get('/', [MedicamentoController::class, 'index'])->name('home');

// Autenticação
Route::prefix('auth')->group(function () {
    Route::get('login', function () {
        return view('login');
    })->name('login');

    Route::post('login', [UserController::class, 'login']);
    Route::get('register', function () {
        return view('register');
    });
    Route::post('register', [UserController::class, 'register']);
    Route::get('logout', [UserController::class, 'logout']);
});

// Medicamentos
Route::get('/medicamentos/{referencia}', [MedicamentoController::class, 'show']);
Route::get('/medicamentos', [MedicamentoController::class, 'index']);
Route::delete('/medicamentos/{referencia}', [MedicamentoController::class, 'destroy'])->name('medicamentos.destroy');
Route::post('/medicamentos/create', [MedicamentoController::class, 'store'])->middleware(['auth', IsAdmin::class]);
Route::patch('/medicamentos/{referencia}', [MedicamentoController::class, 'update'])->name('medicamentos.update');

// Admin
Route::get('dashboard', function () {
    return (new MedicamentoController)->index(request(), 20, 'dashboard');
})->middleware(['auth', IsAdmin::class]);

// Carrinho
Route::prefix('/carrinho')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return (new CarrinhoHasMedicamentosController)->index('cart');
    })->name('carrinho.index');
    Route::post('{referencia}', [CarrinhoController::class, 'add'])->name('carrinho.add');
    Route::get('addOrCreate', [CarrinhoHasMedicamentosController::class, 'addOrCreate'])->name('carrinho.addOrCreate');
});
Route::post('/update', [CarrinhoHasMedicamentosController::class, 'updateQuantity'])->name('carrinho.update');
Route::post('/remove', [CarrinhoHasMedicamentosController::class, 'removeItem'])->name('carrinho.remove');


// Checkout
Route::prefix('checkout')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return (new CarrinhoHasMedicamentosController)->index('checkout');
    })->name('checkout.index');
    Route::post('pagamento', [CompraController::class, 'pagamento'])->name('compra.pagamento');
    Route::get('addOrCreate', [CompraHasMedicamentosController::class, 'addOrCreate'])->name('compra.addOrCreate');
});

// Status
Route::get('status', function () {
    return view('status');
})->middleware('auth')->name('status');

// Perfil
Route::prefix('perfil')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'show'])->name('perfil.show');
    Route::put('update', [UserController::class, 'update'])->name('perfil.update');
    Route::post('delete_foto', [UserController::class, 'deletePhoto']);
});

// Password
Route::prefix('password')->group(function () {
    Route::get('forgot', function () {
        return view('forgot');
    });
    Route::post('forgot', [UserController::class, 'forgot']);
});
