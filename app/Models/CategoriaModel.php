<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
  protected $table = 'categorias';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nome', 'descricao', 'sistema_id', 'status'];
  protected $validationRules    = [
    'nome' => 'required',
  ];

  public function getAll($filtros = [])
  {
    $resultado = $this->where("sistema_id", session()->get("sistema")["id"]);

    if (!empty($filtros["search"])) {
      $resultado->like(["nome" => $filtros["search"]]);
      $resultado->orLike(["descricao" => $filtros["search"]]);
    }
    
    if (!empty($filtros["status"])) {
      $resultado->where("status", $filtros["status"]);
    }

    return $resultado->findAll();
  }
}
