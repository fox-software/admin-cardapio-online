<?php

namespace App\Models;

use CodeIgniter\Model;

class RegiaoModel extends Model
{
  protected $table = 'regioes';
  protected $primaryKey = 'id';
  protected $allowedFields = ['cep', 'frete', 'sistema_id', 'status'];
  protected $validationRules = [];

  public function getAll($filtros = [])
  {
    $resultado = $this->where("sistema_id", session()->get("sistema")["id"]);

    if (!empty($filtros["search"])) {
      $resultado->like(["cep" => $filtros["search"]]);
    }

    if (!empty($filtros["status"])) {
      $resultado->where("status", $filtros["status"]);
    }

    return $resultado->findAll();
  }
}
