<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

use App\Libraries\UolBrasileirao;

use App\Models\RodadaModel;

class RodadaController extends ResourceController
{
    protected $rodadaModel;

    public function __construct()
    {
        $this->rodadaModel = new RodadaModel();
    }

    public function index()
    {
        $dados = $this->rodadaModel->getRodadasEquipe(CORINTHIANS);

        return $this->respond($dados);
    }

    public function cadastrar()
    {
        $brasileirao = new UolBrasileirao(BRASILEIRAO, 2023);

        $dados = $brasileirao->rodadas();
        $campeonato = $dados["campeonato"];
        $temporada = $dados["temporada"];

        foreach ($dados["rodadas"] as $value) {
            $dados = $this->rodadaModel->add($campeonato, $temporada, $value);
        }

        return $this->respond($dados);
    }
}
