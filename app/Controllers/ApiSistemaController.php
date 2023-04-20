<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\SistemaModel;
use App\Models\FormaPagamentoModel;

class ApiSistemaController extends ResourceController
{
    use ResponseTrait;

    protected $sistemaModel;
    protected $formaPagamentoModel;

    public function __construct()
    {
        $this->sistemaModel = new SistemaModel();
        $this->formaPagamentoModel = new FormaPagamentoModel();
    }

    public function getSistema(int $sistemaId)
    {
        session()->set('sistema_api', $sistemaId);

        $data = $this->sistemaModel->find(get_sistema_api());
        $data["aberto"] = get_status_sistema($data["aberto"], $data["fechado"]);

        return $this->respond($data);
    }

    public function formaPagamentos()
    {
        $data = $this->formaPagamentoModel
            ->select("forma_pagamentos.*")
            ->join("forma_pagamentos_sistemas", "forma_pagamentos_sistemas.forma_pagamento_id = forma_pagamentos.id")
            ->where("sistema_id", get_sistema_api())
            ->where("status", ATIVO)
            ->orderBy("forma_pagamentos.id")
            ->findAll();

        return $this->respond($data);
    }
}
