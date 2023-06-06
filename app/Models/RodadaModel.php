<?php

namespace App\Models;

use CodeIgniter\Model;

class RodadaModel extends Model
{
  protected $table = 'rodadas';
  protected $primaryKey = 'id';
  protected $allowedFields = ['id', 'campeonato_id', 'temporada', 'time1', 'time2', 'placar1', 'placar2', 'penalti1', 'penalti2', 'data', 'horario', 'estadio', 'local'];

  public function getRodadasEquipe($equipe)
  {
    $equipeModel = new EquipeModel();

    $resultado =  $this
      ->where("time1", $equipe)
      ->orWhere("time2", $equipe)
      ->orderBy("id")
      ->orderBy("data")
      ->orderBy("horario")
      ->findAll();

    for ($i = 0; $i < count($resultado); $i++) {
      $resultado[$i]["time1"] = $equipeModel->getEquipe($resultado[$i]["time1"]);
      $resultado[$i]["time2"] = $equipeModel->getEquipe($resultado[$i]["time2"]);
    }

    return $resultado;
  }


  public function add($campeonato, $temporada, $params)
  {
    $dados = (array) $params;

    if (!$this->where([
      "id" => $dados["rodada"],
      'campeonato_id' => $campeonato,
      'temporada' => $temporada,
      'time1' => $dados["time1"],
      'time2' => $dados["time2"],
    ])->first()) {
      $this->insert(
        [
          'id' => $dados["rodada"],
          'campeonato_id' => $campeonato,
          'temporada' => $temporada,
          'time1' => $dados["time1"],
          'time2' => $dados["time2"],
          'placar1' => $dados["placar1"],
          'placar2' => $dados["placar2"],
          'penalti1' => $dados["penalti1"],
          'penalti2' => $dados["penalti2"],
          'data' => $dados["data"],
          'horario' => $dados["horario"],
          'estadio' => $dados["estadio"],
          'local' => $dados["local"],
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
