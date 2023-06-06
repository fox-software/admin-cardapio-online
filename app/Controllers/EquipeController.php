<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

use App\Libraries\UolBrasileirao;

use App\Models\EquipeModel;

class EquipeController extends ResourceController
{
    protected $equipeModel;

    public function __construct()
    {
        $this->equipeModel = new EquipeModel();
    }

    public function cadastrar()
    {
        $brasileirao = new UolBrasileirao(BRASILEIRAO, 2023);

        $dados = $brasileirao->equipes();

        foreach ($dados as $value) {
            $dados = $this->equipeModel->add($value);
        }

        return $this->respond($dados);
    }
}
