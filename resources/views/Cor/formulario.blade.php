@extends('TemplateAdmin.index')
@section('contents')

@php
    $titulo = "Cadastro de Cor";
    $endpoint = "/cor/novo";
    $input_id = "";
    $input_cor = "";    
    $input_situacao = "";    


    if(isset($cor)){
        $titulo = "Alteração de cor";
        $endpoint = "/cor/update";
        $input_id = $cor["id"];
        $input_cor = $cor["nome"];        
        $input_situacao = $cor["id"];        
    }
@endphp
<h1 class="h3 mb-4 text-gray-800">{{$titulo}}</h1>
<div class="card">        
        <div class="card-body">
            <form method="post" action="{{$endpoint}}">
                @CSRF
                <input type="hidden" name="id" value="{{$input_id}}">
                <label class="form-label">Nome da cor</label>
                <input class="form-control" name="cor" value="{{$input_cor}}" placeholder="Digite o nome da cor"> 

                <label class="form-label">Situação</label>
                <select class="form-control" name='situacao' value="{{$input_situacao}}">           
                <option value="1" selected>Ativo</option>
                <option value="0">Inativo</option>                       
                </select>  
                <br/>
                <input type="submit" class="btn btn-success" value="Salvar">
            </form>  
        </div>
</div>  
@endsection

<!-- 
    php artisan make:migration create_table_marca 
-->