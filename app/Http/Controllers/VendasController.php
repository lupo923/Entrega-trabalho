<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Vendas;
use Illuminate\Support\Facades\Session;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class VendasController extends Controller
{
    public function index()
    {
        $vendas = Produto::select("produto.id", "produto.nome", "produto.quantidade", "produto.preco",
                                   "categoria.nome AS cat", "marca.nome as marca", "produto.descricao", "produto.imagem")
                         ->join("categoria", "categoria.id", "=", "produto.id_categoria")
                         ->join("marca", "marca.id", "=", "produto.id_marca")
                         ->orderBy("produto.id")
                         ->get();

        $categorias = Categoria::all()->toArray();  
        $marcas = Marca::all()->toArray();   

        return view("Vendas.index", ["vendas" => $vendas, 'categorias' => $categorias, 'marcas' => $marcas]);
    }

    public function comprar($id)
    {    
        $produto = Produto::find($id)->toArray();
        $categorias = Categoria::all()->toArray();  
        $marcas = Marca::all()->toArray();            
        return view("Vendas.comprar", ['produto' => $produto, 'categorias' => $categorias, 'marcas' => $marcas]);             
    }

    public function adicionarAoCarrinho($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return redirect()->route('vendas.index')->with('error', 'Produto não encontrado!');
        }

        $carrinho = session('carrinho', []);
        $produtoNoCarrinho = false;

        foreach ($carrinho as $key => $item) {
            if ($item['id'] == $produto->id) {
                $carrinho[$key]['quantidade'] += 1;
                $produtoNoCarrinho = true;
                break;
            }
        }    

        if (!$produtoNoCarrinho) {
            $novoItem = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'preco' => $produto->preco,
                'imagem' => $produto->imagem,
                'quantidade' => 1,
            ];
            $carrinho[] = $novoItem;
        }

        session(['carrinho' => $carrinho]);

        return redirect()->route('exibir-carrinho')->with('success', 'Produto adicionado ao carrinho!');
    }

    public function removeItemParcial($id)
    {
        $produto = Produto::find($id);
        $carrinho = session('carrinho', []);

        foreach ($carrinho as $key => $item) {
            if ($item['id'] == $produto->id) {
                $carrinho[$key]['quantidade'] -= 1;   

                if ($carrinho[$key]['quantidade'] <= 0) {
                    unset($carrinho[$key]);
                }
                break;
            }
        }  

        session(['carrinho' => $carrinho]);
        return redirect()->route('exibir-carrinho')->with('success', 'Item parcialmente removido');
    }

    public function excluiItem($id)
    {
        $produto = Produto::find($id);
        $carrinho = session('carrinho', []);

        foreach ($carrinho as $key => $item) {
            if ($item['id'] == $produto->id) { 
                unset($carrinho[$key]);                
                break;
            }
        }  

        session(['carrinho' => $carrinho]);
        return redirect()->route('exibir-carrinho')->with('success', 'Item removido');
    }

    public function exibirCarrinho()
    {
        $carrinho = Session::get('carrinho', []);
        $categorias = Categoria::all()->toArray();  
        $marcas = Marca::all()->toArray();  
        
        return view('vendas.carrinho', ['carrinho' => $carrinho, 'categorias' => $categorias, 'marcas' => $marcas]);
    }

    public function finalizarCompra(Request $request): RedirectResponse
    {        
        $carrinho = session()->get('carrinho');

        $this->authenticate();

        if (!empty($carrinho)) {
            foreach ($carrinho as $item) {                
                $venda = new Vendas();
                $venda->email = $request->input("email");
                $venda->codigo_produto = $item['id'];
                $venda->quantidade = $item['quantidade'];
                $venda->save();
                // Armazena a preferência em uma variável
                $redirectResponse = $this->createPaymentPreference();
                // Redireciona após criar a preferência de pagamento
                if ($redirectResponse) {
                    return $redirectResponse; // Retorna o redirecionamento
                }
            }

            session()->forget('carrinho');
        }
        
        return redirect("/vendas");         
    }

    protected function authenticate()
    {
        $mpAccessToken = 'APP_USR-386198155993034-102818-faf7a3eca08646ea58e10e12ef7d0f45-2062533551';
        MercadoPagoConfig::setAccessToken($mpAccessToken);
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    protected function createPreferenceRequest($items, $payer): array
    {
        $paymentMethods = [
            "excluded_payment_methods" => [],
            "installments" => 12,
            "default_installments" => 1
        ];

        $backUrls = [
            'success' => route('mercadopago.success'),
            'failure' => route('mercadopago.failed')
        ];

        return [
            "items" => $items,
            "payer" => $payer,
            "payment_methods" => $paymentMethods,
            "back_urls" => $backUrls,
            "statement_descriptor" => "NAME_DISPLAYED_IN_USER_BILLING",
            "external_reference" => "1234567890",
            "expires" => false,
            "auto_return" => 'approved',
        ];
    }

    public function createPaymentPreference(): RedirectResponse
{
    // Obtém o carrinho da sessão
    $carrinho = session()->get('carrinho');

    // Verifica se o carrinho está vazio
    if (empty($carrinho)) {
        return redirect()->route('vendas.index')->with('error', 'Carrinho vazio. Adicione produtos antes de prosseguir.');
    }

    // Cria os itens a partir do carrinho
    $items = array_map(function($item) {
        return [
            "id" => $item['id'], // ID do produto
            "title" => $item['nome'], // Nome do produto
            "description" => "Descrição do " . $item['nome'], // Descrição do produto
            "currency_id" => "BRL", // Moeda
            "quantity" => $item['quantidade'], // Quantidade
            "unit_price" => (float) $item['preco'], // Preço unitário como float
        ];
    }, $carrinho);

    // Define os dados do pagador
    $payer = [
        "name" => 'Caruso', // Substitua por dados reais se disponíveis
        "surname" => 'Gabriel',
        "email" => 'gabriel@hotmail.com',
    ];

    // Cria a requisição de preferência
    $request = $this->createPreferenceRequest($items, $payer);

    // Log da requisição para diagnóstico
    \Log::info('Requisição de preferência de pagamento:', $request);

    $client = new PreferenceClient();

    try {
        $preference = $client->create($request);
        return redirect($preference->init_point); // Redireciona para a URL de pagamento
    } catch (MPApiException $error) {
        
        // Caso ocorra um erro, redirecione para a página de vendas com uma mensagem de erro
        return redirect()->route('vendas.index')->with('error', 'Erro ao criar a preferência de pagamento.');
    }
}

    
}
