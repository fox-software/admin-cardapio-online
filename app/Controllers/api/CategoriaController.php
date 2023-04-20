<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class CategoriaController extends BaseController
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $data = $this->categoriaModel->where("sistema_id", get_sistema_api())->findAll();

        return $this->response->setJSON($data);
    }
}
