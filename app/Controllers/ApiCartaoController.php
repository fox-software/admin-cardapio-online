<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\CartaoModel;
use App\Models\UsuarioModel;

class ApiCartaoController extends ResourceController
{
    use ResponseTrait;

    protected $cartaoModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->cartaoModel = new CartaoModel();
    }

    public function index()
    {
        $usuario_id = $this->usuarioModel->getAuthenticatedUser();

        $data = $this->cartaoModel->getByUserId($usuario_id);

        return $this->respond($data);
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

    public function editar()
    {
        $data = $this->request->getVar();

        $resultado = $this->cartaoModel->editar($data);

        return $this->respond($resultado);
    }

    public function status($cartaoId)
    {
        $resultado = $this->cartaoModel->setStatus($cartaoId);

        return $this->respond($resultado);
    }

    public function principal($cartaoId)
    {
        $usuario_id = $this->usuarioModel->getAuthenticatedUser();

        $resultado = $this->cartaoModel->setPrincipal($usuario_id, $cartaoId);

        return $this->respond($resultado);
    }
}
