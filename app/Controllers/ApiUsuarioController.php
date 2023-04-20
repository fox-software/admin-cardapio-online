<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\UsuarioModel;
use App\Models\EnderecoModel;

class ApiUsuarioController extends ResourceController
{
    use ResponseTrait;

    protected $usuarioModel;
    protected $enderecoModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->enderecoModel = new EnderecoModel();
    }

    public function index()
    {
        $usuario_id = $this->usuarioModel->getAuthenticatedUser();

        $usuario = $this->usuarioModel->find($usuario_id);

        return $this->respond($usuario);
    }

    public function status()
    {
        $usuario_id = $this->usuarioModel->getAuthenticatedUser();

        $usuario = $this->usuarioModel
            ->select("usuarios.*, usuarios_sistemas.sistema_id, usuarios_sistemas.status")
            ->join("usuarios_sistemas", "usuario_id = usuarios.id")
            ->find($usuario_id);

        return $this->respond($usuario["status"] == ATIVO ? true : false);
    }

    public function cadastrar()
    {
        $data = $this->usuarioModel->cadastrar($this->request->getVar());

        return $this->respond($data);
    }

    public function endereco($cep)
    {
        $endereco = buscar_endereco($cep);

        return $this->respond([
            "cidade" => $endereco["cidade"],
            "bairro" => $endereco["bairro"],
            "logradouro" => $endereco["tipo_logradouro"] . " " . $endereco["logradouro"],
            "estado" => $endereco["uf"],
        ]);
    }
}
