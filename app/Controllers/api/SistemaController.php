<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\SistemaModel;
use App\Models\FormaPagamentoModel;

class SistemaController extends ResourceController
{
    use ResponseTrait;

    protected $sistemaModel;
    protected $formaPagamentoModel;

    public function __construct()
    {
        $this->sistemaModel = new SistemaModel();
        $this->formaPagamentoModel = new FormaPagamentoModel();
    }

    public function index()
    {
        $data = $this->sistemaModel->find(get_sistema());
        $data["aberto"] = get_status_sistema($data["aberto"], $data["fechado"]);

        return $this->respond($data);
    }

    public function formaPagamentos()
    {
        $data = $this->formaPagamentoModel
            ->select("forma_pagamentos.*")
            ->join("forma_pagamentos_sistemas", "forma_pagamentos_sistemas.forma_pagamento_id = forma_pagamentos.id")
            ->where("sistema_id", get_sistema())
            ->where("status", "A")
            ->orderBy("forma_pagamentos.id")
            ->findAll();

        return $this->respond($data);
    }
}
