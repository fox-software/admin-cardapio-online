<?php

namespace App\Models;

use CodeIgniter\Model;

class CampeonatoModel extends Model
{
  protected $table = 'campeonatos';
  protected $primaryKey = 'id';
  protected $allowedFields = ['id', 'nome_completo', 'nome_comum', 'temporada'];

  public function add($params)
  {
    $dados = (array) $params;

    if (!$this->where(["id" => $dados["campeonato"], "temporada" => $dados["temporada"]])->first()) {
      $this->insert(
        [
          'id' => $dados["campeonato"],
          'temporada' => $dados["temporada"],
          'nome_completo' => $dados["nome-completo"],
          'nome_comum' => $dados["nome-comum"],
        ]
      );

      return [
        "salvar" => true,
        "message" => "Sucesso ao salvar!"
      ];
    }

    return [
      "salvar" => false,
      "message" => "Sucesso!"
    ];
  }
}
