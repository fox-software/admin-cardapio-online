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

    public function getCategorias(int $sistemaId)
    {
        session()->set('sistema_api', $sistemaId);

        $data = $this->categoriaModel->where("sistema_id", $sistemaId)->findAll();

        return $this->respond($data, 200);
    }
}
