@extends('TemplateAdmin.index')
@section('contents')
    <h1 class="h3 mb-4 text-gray-800">Cadastro de produtos</h1>
    
    <div class="card">
        <div class="card-header">
           Categorias
        </div>
        <div class="card-body">            
            <table class="table table-bordered dataTable">
                <thead>
                    <td>ID</td>
                    <td>E-mail</td>   
                    <td>Produto</td>   
                    <td>Quantidade</td>  
                </thead>            
                <tbody>
                    @foreach($compras as $dados)
                        <tr>
                            <td>{{$dados["id"]}}</td>
                            <td>{{$dados["email"]}}</td>
                            <td>{{$dados["nome"]}}</td>
                            <td>{{$dados["quantidade"]}}</td>
                        </tr>
                    @endforeach                  
                </tbody>
            </table>
        </div>
    </div>
@endsection