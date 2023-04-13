<?php

namespace App\Models;

use CodeIgniter\Model;

class SistemaModel extends Model
{
  protected $table = 'sistemas';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'nome_fantasia', 'razao_social', 'cnpj', 'email', 'telefone', 'foto',
    'cep', 'endereco', 'numero', 'cidade', 'estado',
    'taxa_entrega', 'tempo_entrega_min', 'tempo_entrega_max', 'pix',
    'aberto', 'fechado',
    'status'
  ];
  protected $validationRules = [
    'nome_fantasia' => 'required',
  ];

  public function getAll()
  {
    $resultado = $this->where("status", "A");

    return $resultado->findAll();
  }

  /* Retorna uma empresa pelo seu e-mail */
  public function getByEmail(string $email)
  {
    $resultado = $this->where("email", $email)->first();

    return $resultado;
  }
}
