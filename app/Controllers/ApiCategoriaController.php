<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class ApiCategoriaController extends ResourceController
{
    use ResponseTrait;

    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $filtros = [
            "sistema" => get_sistema_api(),
            "status" => ATIVO
        ];

        $data = $this->categoriaModel->getAll($filtros);

        return $this->respond($data, 200);
    }
}
