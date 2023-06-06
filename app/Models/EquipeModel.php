<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipeModel extends Model
{
  protected $table = 'equipes';
  protected $primaryKey = 'id';
  protected $allowedFields = ['id', 'nome', 'nome_comum', 'sigla', 'tipo', 'brasao'];

  public function getEquipe($equipe)
  {
    return $this->select('id, nome, nome_comum, sigla, brasao')->find($equipe);
  }

  public function add($params)
  {
    $dados = (array) $params;

    if (!$this->find($dados["id"])) {
      $this->insert(
        [
          'id' => $dados["id"],
          'nome' => $dados["nome"],
          'nome_comum' => $dados["nome-comum"],
          'sigla' => $dados["sigla"],
          'tipo' => $dados["tipo"],
          'brasao' => $dados["brasao"]
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
