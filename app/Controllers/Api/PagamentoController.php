<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Libraries\Pagarme;

use App\Models\UsuarioModel;

class PagamentoController extends ResourceController
{
  use ResponseTrait;

  protected $usuarioModel;
  protected $pagarme;

  public function __construct()
  {
    $this->usuarioModel = new UsuarioModel();
    $this->pagarme = new Pagarme();
  }

  public function checkoutCreditCard()
  {
    $data = $this->request->getVar();

    $usuario_id = $this->usuarioModel->getAuthenticatedUser();

    $usuario = $this->usuarioModel->getUserCompleteById($usuario_id);

    $responseUsuarioPagarme = $this->pagarme->criarUsuarioPagarme($usuario_id, $usuario);

    if (empty($responseUsuarioPagarme)) throw new \Exception("Não foi possível criar um cliente no gateway, entre em contato com o suporte");

    $responseCartaoPagarme = $this->pagarme->criarCartaoUsuarioPagarme($responseUsuarioPagarme["data"]["customer"]->id, $data->cartao);

    if (!$responseCartaoPagarme["success"]) {
      throw new \Exception($responseCartaoPagarme["message"]);
    }

    return $this->respond($responseCartaoPagarme);
  }
}
