<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\PedidoModel;
use App\Models\PedidoProdutoModel;
use App\Models\ProdutoModel;
use App\Models\UsuarioModel;

class PedidoController extends ResourceController
{
    use ResponseTrait;

    protected $pedidoModel;
    protected $produtoModel;
    protected $usuarioModel;
    protected $pedidoProdutoModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->produtoModel = new ProdutoModel();
        $this->pedidoProdutoModel = new PedidoProdutoModel();
    }

    public function index()
    {
        $usuario_id = $this->usuarioModel->getAuthenticatedUser();

        $data = $this->pedidoModel->where(["sistema_id" => get_sistema(), "usuario_id" => $usuario_id])
            ->orderBy("created_at", "DESC")
            ->findAll();

        return $this->respond($data);
    }

    public function detalhes($pedidoId)
    {
        $data = $this->pedidoModel->find($pedidoId);

        $data["produtos"] = $this->pedidoProdutoModel
            ->select("produtos.*")
            ->join("produtos", "produtos.id = pedidos_produtos.produto_id")
            ->where("pedido_id", $pedidoId)
            ->findAll();

        for ($i = 0; $i < count($data["produtos"]); $i++) {
            $data["produtos"][$i]["total"] = $data["produtos"][$i]["quantidade"] * $data["produtos"][$i]["preco"];
        }

        return $this->respond($data);
    }

    public function cadastrar()
    {
        $data = $this->request->getVar();

        if (!$data->comprovante == NULL) {
            $comprovante = md5(time() . uniqid()) . "_comprovante.jpg";
            $decoded = base64_decode($data->comprovante);
            if (!file_put_contents("uploads/" . $comprovante, $decoded)) {
                $data->comprovante = null;
            } else {
                $data->comprovante = base_url("uploads/$comprovante");
            }
        }

        $usuario_id = $this->usuarioModel->getAuthenticatedUser();

        $pedido = $this->pedidoModel->cadastrar($usuario_id, $data);

        return $this->respond($pedido);
    }
}
