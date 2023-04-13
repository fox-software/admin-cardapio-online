<?php

namespace App\Models;

use CodeIgniter\Model;

class CartaoModel extends Model
{
  protected $table = 'cartoes';
  protected $primaryKey = 'id';
  protected $allowedFields = ['usuario_id', 'titular', 'validade', 'cpf', 'cvv', 'numero', 'status'];
  protected $validationRules = [];

  public function cadastrar($data)
  {
    $resultado = $this->insert($data);

    if (!$resultado) {
      return [
        "status" => $resultado,
        "message" => "Ocorreu uma falha ao salvar!"
      ];
    }

    return [
      "status" => $resultado,
      "message" => "Cartão salvo com sucesso!"
    ];
  }
}
