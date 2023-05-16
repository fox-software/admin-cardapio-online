<?php

namespace App\Controllers;

use Exception;

use App\Models\RegiaoModel;

class RegiaoController extends BaseController
{
    protected $regiaoModel;

    public function __construct()
    {
        $this->regiaoModel = new RegiaoModel();
    }

    public function index()
    {
        $filtros = $this->request->getVar();

        $data = [
            "page_title" => "regioes",
            "regioes" => $this->regiaoModel->getAll($filtros),
            "search" => !empty($filtros["search"]) ? $filtros["search"] : ""
        ];

        return view('page/regioes', $data);
    }

    public function cadastrar()
    {
        $dados = $this->request->getVar();
        $dados["sistema_id"] = session()->get("sistema")["id"];

        $dados["cep"] = only_numbers($dados["cep"]);

        try {
            $this->regiaoModel->insert($dados);
            toast(TOAST_SUCCESS, "Sucesso", "Região salva com sucesso!");
            return redirect()->to("admin/regioes");
        } catch (Exception $e) {
            toast(TOAST_ERROR, "Falha", $e->getMessage());
            return redirect()->to("admin/regioes");
        }
    }

    public function status(int $regiao_id)
    {
        $regiao = $this->regiaoModel->find($regiao_id);
        $novo_status = $regiao["status"] == ATIVO ? INATIVO : ATIVO;

        try {
            $this->regiaoModel->update($regiao["id"], ["status" => $novo_status]);
            toast(TOAST_SUCCESS, "Sucesso", "Região salva com sucesso!");
            return redirect()->to("admin/regioes");
        } catch (Exception $e) {
            toast(TOAST_ERROR, "Falha", $e->getMessage());
            return redirect()->to("admin/regioes");
        }
    }

    public function editar(int $regiao_id)
    {
        $dados = $this->request->getVar();
        $regiao = $this->regiaoModel->find($regiao_id);

        $dados["cep"] = only_numbers($dados["cep"]);

        try {
            $this->regiaoModel->update($regiao["id"], $dados);
            toast(TOAST_SUCCESS, "Sucesso", "Região salva com sucesso!");
            return redirect()->to("admin/regioes");
        } catch (Exception $e) {
            toast(TOAST_ERROR, "Falha", $e->getMessage());
            return redirect()->to("admin/regioes");
        }
    }
}
