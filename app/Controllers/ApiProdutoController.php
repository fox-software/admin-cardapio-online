<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class ApiProdutoController extends ResourceController
{
    use ResponseTrait;

    protected $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
    }

    public function getProdutos(int $sistemaId)
    {
        session()->set('sistema_api', $sistemaId);

        $data = $this->produtoModel
            ->select("produtos.*")
            ->join("categorias", "categorias.id = produtos.categoria_id")
            ->where("categorias.sistema_id", $sistemaId)
            ->where("produtos.status", ATIVO)
            ->findAll();

        return $this->respond($data);
    }
}
