<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\CartaoModel;
use App\Models\UsuarioModel;

class CartaoController extends ResourceController
{
    use ResponseTrait;

    protected $cartaoModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->cartaoModel = new CartaoModel();
    }

    public function cadastrar()
    {
        $data = $this->request->getVar();

        $usuario_id = $this->usuarioModel->getAuthenticatedUser();

        $data->cpf = only_numbers($data->cpf);
        $data->usuario_id = $usuario_id;

        $resultado = $this->cartaoModel->cadastrar($data);

        return $this->respond($resultado);
    }
}
