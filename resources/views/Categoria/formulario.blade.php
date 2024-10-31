@extends('TemplateAdmin.index')
@section('contents')

@php
    $titulo = "Inclusão de uma nova categoria";
    $endpoint = "/categoria/novo";
    $input_nome = "";    
    $input_id = "";

    if(isset($categoria)){
        $titulo = "Alteração da categoria";
        $endpoint = "/categoria/update";
        $input_nome = $categoria['nome'];        
        $input_id = $categoria["id"];
    }
@endphp

<h1 class="h3 mb-4 text-gray-800">{{$titulo}}</h1>
<div class="card">
        <div class="card-header">
            Alterar categoria
        </div>
        <div class="card-body">
            <form method="post" action="{{$endpoint}}">
                @CSRF
                <input type="hidden" name="id" value="{{$input_id}}">
                <label class="form-label">Nome da categoria</label>
                <input class="form-control" name="nome" placeholder="Digite o nome da categoria" value="{{$input_nome}}"> 

                <label class="form-label">Situação</label>
                <select class="form-control" name='situacao'>           
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