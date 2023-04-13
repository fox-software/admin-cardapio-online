<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\PedidoModel;
use App\Models\ProdutoModel;
use App\Models\UsuarioModel;

class DashboardController extends BaseController
{
    protected $usuarioModel;
    protected $categoriaModel;
    protected $produtoModel;
    protected $pedidoModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->categoriaModel = new CategoriaModel();
        $this->produtoModel = new ProdutoModel();
        $this->pedidoModel = new PedidoModel();
    }

    public function index()
    {
        $data = [
            "page_title" => "dashboard",
            "total_usuarios" => count($this->usuarioModel->getAll(["status" => "A"])),
            "total_categorias" => count($this->categoriaModel->getAll(["status" => "A"])),
            "total_produtos" => count($this->produtoModel->getAll(["status" => "A"])),
            "total_pedidos" => count($this->pedidoModel->getAll(["status" => "A"])),
            "estoque_produtos" => $this->produtoModel->getStockProducts(),

            "porcentagem_pedidos" => $this->pedidoModel->getPorcentagem(2023),
        ];

        return view('page/dashboard', $data);
    }

    public function graphic($ano)
    {
        $data = [
            "chart" => [
                "chart_clientes" => $this->usuarioModel->getAllForChart($ano),
                "chart_pedidos" => $this->pedidoModel->getAllForChart($ano),
            ],
            "soma_total_pedidos" => $this->pedidoModel->getTotal($ano),
            "porcentagem_pedidos" => $this->pedidoModel->getPorcentagem($ano),
        ];

        return $this->response->setJSON($data);
    }
}
