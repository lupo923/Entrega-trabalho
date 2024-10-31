<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use App\Models\Vendas;

use Illuminate\Http\Request;

class ComprasController extends Controller
{
        public function index(){        
        
           $compras = vendas::select("vendas.id",
                                     "vendas.email",
                                       "produto.nome",
                                       "vendas.quantidade")
                                    ->join("produto","produto.id", "=", "vendas.codigo_produto")                                    
                                    ->orderBy("produto.id") 
                                    ->get();

                          

        return view("Compras.index",["compras"=>$compras]);
    }
}
