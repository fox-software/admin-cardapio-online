<?php

namespace App\Models;

use CodeIgniter\Model;

class EnderecoModel extends Model
{
  protected $table = 'enderecos';
  protected $primaryKey = 'id';
  protected $allowedFields = ['usuario_id', 'cep', 'endereco', 'numero', 'bairro', 'cidade', 'estado', 'complemento', 'status'];
  protected $validationRules = [];

  public function getByUserId($usuario_id)
  {
    $resultado = $this->where([
      "status" => ATIVO,
      "usuario_id" => $usuario_id
    ])->first();

    if (!isset($resultado["id"])) return [];

    return $resultado;
  }

  public function getByCep($cep)
  {
    $resultado = $this->where([
      "status" => ATIVO,
      "cep" => $cep
    ]);

    return $resultado->first();
  }

  public function cadastrar($usuario_id, $data)
  {
    $data->usuario_id = $usuario_id;

    $resultado = $this->insert($data);

    if (!$resultado) {
      return [
        "status" => $resultado,
        "message" => "Ocorreu uma falha ao salvar!"
      ];
    }

    return [
      "status" => $resultado,
      "message" => "Endereço salvo com sucesso!"
    ];
  }

  public function editar($usuario_id, $data)
  {
    $endereco_id = $this->where("usuario_id", $usuario_id)->first()["id"];

    $resultado = $this->update($endereco_id, $data);

    if (!$resultado) {
      return [
        "status" => $resultado,
        "message" => "Ocorreu uma falha ao salvar!"
      ];
    }

    return [
      "status" => $resultado,
      "message" => "Endereço salvo com sucesso!"
    ];
  }
}
