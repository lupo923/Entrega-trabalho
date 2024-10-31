<?php
namespace App\Classes;
session_start();
class Carrinho
{
    private $id;
    private $nome;
    private $preco;
    private $imagem;
    public $carrinho;

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function setPreco($preco)
    {
        $this->preco = $preco;
    }
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function getPreco()
    {
        return $this->preco;
    }
    public function getImagem()
    {
        return $this->imagem;
    }

    public function addCarrinho()
{
    if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
        // Se o carrinho estiver vazio, adiciona o primeiro item
        $novo = array(
            "quantidade" => 1,
            "nome" => $this->nome,
            "valor" => $this->preco,
            "imagem" => $this->imagem,
            "id" => $this->id
        );
        $_SESSION['carrinho'][] = $novo;
    } else {
        $achou = false;
        foreach ($_SESSION['carrinho'] as &$item) {
            if ($item['nome'] == $this->nome) {
                // Se o item já estiver no carrinho, incrementa a quantidade
                $item['quantidade'] += 1;
                $achou = true;
                break;
            }
        }

        if (!$achou) {
            // Se o item não estiver no carrinho, adiciona um novo
            $add = array(
                'quantidade' => 1,
                'nome' => $this->nome,
                'valor' => $this->preco,
                "imagem" => $this->imagem,
                "id" => $this->id
            );
            $_SESSION['carrinho'][] = $add;
        }
    }

    return $_SESSION['carrinho'];
}


    public function removeCarrinho($id)
    {
        $carrinho = @$_SESSION['carrinho'];
        for ($i = 0; $i < count($carrinho); $i++) {
            if ($carrinho[$i]['nome'] == $this->nome) {
                $carrinho[$i]['quantidade'] = $carrinho[$i]['quantidade'] - 1;
                if ($carrinho[$i]['quantidade'] < 1) {
                    unset($carrinho[$i]);
                }
            }
        }
        $novo_carrinho = array();
        foreach ($carrinho as $item) {
            $novo_carrinho[] = $item;
        }
        $_SESSION['carrinho'] = $novo_carrinho;
        return $_SESSION['carrinho'];
    }

    public function limpaItemCarrinho($id)
    {
        $carrinho = @$_SESSION['carrinho'];
        for ($i = 0; $i < count($carrinho); $i++) {
            if ($carrinho[$i]['id'] == $this->id) {

                unset($carrinho[$i]);

            }
        }
        $novo_carrinho = array();
        foreach ($carrinho as $item) {
            $novo_carrinho[] = $item;
        }
        $_SESSION['carrinho'] = $novo_carrinho;
        return $_SESSION['carrinho'];

    }
}




?>