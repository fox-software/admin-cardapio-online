<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

use App\Libraries\UolBrasileirao;

use App\Models\CampeonatoModel;

class CampeonatoController extends ResourceController
{
    protected $campeonatoModel;

    public function __construct()
    {
        $this->campeonatoModel = new CampeonatoModel();
    }

    public function cadastrar()
    {
        $brasileirao = new UolBrasileirao(BRASILEIRAO, 2022);

        $dados = (array) $brasileirao->campeonato();

        $dados = $this->campeonatoModel->add($dados);

        return $this->respond($dados);
    }
}
