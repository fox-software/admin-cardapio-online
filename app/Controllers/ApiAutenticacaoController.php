<?php

namespace App\Controllers;

use App\Models\EnderecoModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\UsuarioModel;

class ApiAutenticacaoController extends ResourceController
{
    use ResponseTrait;

    protected $usuarioModel;
    protected $enderecoModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->enderecoModel = new EnderecoModel();
    }

    public function login()
    {
        $email = $this->request->getVar('email');
        $senha = $this->request->getVar('senha');

        $usuario = $this->usuarioModel->getByEmail($email);

        if (is_null($usuario)) {
            return $this->respond(['status' => false, 'message' => 'E-mail ou senha inválidos.'], 400);
        }

        $pwd_verify = password_verify($senha, $usuario['senha']);

        if (!$pwd_verify) {
            return $this->respond(['status' => false, 'message' => 'E-mail ou senha inválidos.'], 400);
        }

        $response = [
            'message' => 'Login bem-sucedido',
            'authorization' => $this->usuarioModel->createToken($usuario["id"], $usuario["sistema_id"])
        ];

        return $this->respond($response, 200);
    }

    public function logout()
    {
        return $this->respond(['status' => TRUE, 'message' => 'Logout efetuado'], 200);
    }
}
