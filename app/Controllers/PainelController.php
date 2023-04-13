<?php

namespace App\Controllers;

use App\Models\PedidoModel;

class PainelController extends BaseController
{
    protected $pedidoModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
    }

    public function index()
    {
        $data = [
            "page_title" => "painel"
        ];

        return view('page/painel', $data);
    }

    public function kanban()
    {
        $fazer = $this->pedidoModel->kanban(PENDENTE);
        $fazendo = $this->pedidoModel->kanban(ENTREGA);
        $feito = $this->pedidoModel->kanban(RECEBIDO);

        $data = [
            "fazer" => $fazer,
            "fazendo" => $fazendo,
            "feito" => $feito,
        ];

        return $this->response->setJSON($data);
    }

    public function status($pedidoId, $status)
    {
        $resultado = $this->pedidoModel->setStatus($pedidoId, $status);

        return $resultado;
    }
}
