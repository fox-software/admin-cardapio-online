<?php

namespace App\Controllers;

use App\Models\PedidoModel;

class PedidoController extends BaseController
{
    protected $pedidoModel;
    protected $usuarioSistemaModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
    }

    public function index()
    {
        $filtros = $this->request->getVar();

        $data = [
            "page_title" => "pedidos",
            "pedidos" => $this->pedidoModel->getAll($filtros),
            "filtros" => $filtros
        ];

        return view('page/pedidos', $data);
    }
}
