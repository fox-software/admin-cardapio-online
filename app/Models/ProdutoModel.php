<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
  protected $table = 'produtos';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nome', 'foto', 'descricao', 'preco', 'categoria_id', 'quantidade', 'status'];
  protected $validationRules    = [
    'nome' => 'required',
  ];

  public function getAll($filtros = [])
  {
    $resultado = $this
      ->select("produtos.*, categorias.nome AS categoria_nome")
      ->join("categorias", "categorias.id = produtos.categoria_id")
      ->where("sistema_id", session()->get("sistema")["id"]);

    if (!empty($filtros["search"])) {
      $resultado->like(["produtos.nome" => $filtros["search"]]);
      $resultado->orLike(["produtos.descricao" => $filtros["search"]]);
    }

    if (!empty($filtros["categoria_id"])) {
      $resultado->where(["categorias.id" => $filtros["categoria_id"]]);
    }

    if (!empty($filtros["status"])) {
      $resultado->where(["produtos.status" => $filtros["status"]]);
    }

    return $resultado->findAll();
  }

  public function getStockProducts($stockLimit = 10, $limit = 5)
  {
    $resultado = $this
      ->select("produtos.*, categorias.nome AS categoria_nome")
      ->join("categorias", "categorias.id = produtos.categoria_id")
      ->where([
        "sistema_id" => session()->get("sistema")["id"],
        "quantidade <=" => $stockLimit
      ])
      ->orderBy("quantidade", "ASC")
      ->limit($limit);

    return $resultado->findAll();
  }
}
