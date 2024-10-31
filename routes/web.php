<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ComprasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CorController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\AuthController;


Route::group(['prefix' => 'marca'], function(){
    Route::get('/',[MarcaController::class,'index']);
    Route::get('/novo',[MarcaController::class,'inserir']);    
    Route::post('/novo',[MarcaController::class,'salvar_novo']);        
    Route::get('/excluir/{id}',[MarcaController::class,'excluir']);
    Route::get('/update/{id}',[MarcaController::class,'alterar']);
    Route::post('/update',[MarcaController::class,'salvar_update']);
});

Route::group(['prefix' => 'categoria'], function(){
    Route::get('/',[CategoriaController::class,'index']);
    Route::get('/novo',[CategoriaController::class,'inserir']);    
    Route::post('/novo',[CategoriaController::class,'salvar_novo']);   
    Route::get('/excluir/{id}',[CategoriaController::class,'excluir']);
    Route::get('/update/{id}',[CategoriaController::class,'alterar']);
    Route::post('/update',[CategoriaController::class,'salvar_update']);
});

Route::group(['prefix' => 'cor'], function(){
    Route::get('/',[CorController::class,'index']);
    Route::get('/novo',[CorController::class,'inserir']);    
    Route::post('/novo',[CorController::class,'salvar_novo']);   
    Route::get('/excluir/{id}',[CorController::class,'excluir']);
    Route::get('/update/{id}',[CorController::class,'alterar']);
    Route::post('/update',[CorController::class,'salvar_update']);
});

Route::group(['prefix' => 'produto'], function(){
    Route::get('/',[ProdutoController::class,'index']);
    Route::get('/novo',[ProdutoController::class,'inserir']);   
    Route::post('/novo',[ProdutoController::class,'salvar_novo']);
    Route::get('/excluir/{id}',[ProdutoController::class,'excluir']);
    Route::get('/update/{id}',[ProdutoController::class,'alterar']);
    Route::post('/update',[ProdutoController::class,'salvar_update']);
});



Route::group(['prefix' => 'vendas'], function(){
    Route::get('/',[VendasController::class,'index']); 
    Route::get('/comprar/{id}',[VendasController::class,'comprar']);    
    Route::get('/marca/{id}',[VendasController::class,'searchMarca']);
    Route::get('/categoria/{id}', [VendasController::class, 'searchCategoria']);   
    Route::get('/carrinho/{id}', [VendasController::class, 'adicionarAoCarrinho'])->name('adicionar-ao-carrinho');
    Route::get('/exibir-carrinho', [VendasController::class, 'exibirCarrinho'])->name('exibir-carrinho');  
    Route::get('/carrinho/remover/{id}', [VendasController::class, 'removeItemParcial'])->name('remover-do-carrinho'); 
    Route::get('/carrinho/excluir/{id}', [VendasController::class, 'excluiItem'])->name('excluir-item'); 
    Route::post('/finalizar-compra', [VendasController::class, 'finalizarCompra']); 
    Route::get('/mercadopago/success', [VendasController::class, 'index'])->name('mercadopago.success');
    Route::get('/mercadopago/failed', [VendasController::class, 'index'])->name('mercadopago.failed');

});

Route::group(['prefix' => 'compras'], function(){
    Route::get('/',[ComprasController::class,'index']);    
});

Route::get('/register', function(){
    return view("login.register");
})->name('register');

Route::group(['prefix' => 'login'], function(){
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']); 
});



Route::get('/', [MarcaController::class,'index']);







