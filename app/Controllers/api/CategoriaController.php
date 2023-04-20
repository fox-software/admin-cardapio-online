<?php

namespace App\Controllers\Api;

header("Access-Control-Allow-Origin: *");

use App\Models\CategoriaModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class CategoriaController extends ResourceController
{
    use ResponseTrait;

    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $data = $this->categoriaModel->where("sistema_id", get_sistema_api())->findAll();

        return $this->respond($data);
    }
}
