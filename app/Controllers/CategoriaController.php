<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use Exception;

class CategoriaController extends BaseController
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $filtros = $this->request->getVar();

        $data = [
            "page_title" => "categorias",
            "categorias" => $this->categoriaModel->getAll($filtros),
            "search" => !empty($filtros["search"]) ? $filtros["search"] : ""
        ];

        return view('page/categorias', $data);
    }

    public function cadastrar()
    {
        $data = $this->request->getVar();
        $data["sistema_id"] = session()->get("sistema")["id"];

        try {
            $this->categoriaModel->insert($data);
            toast(TOAST_SUCCESS, "Sucesso", "Categoria salva com sucesso!");
            return redirect()->to("admin/categorias");
        } catch (Exception $e) {
            toast(TOAST_SUCCESS, "Falha", $e->getMessage());
            return redirect()->to("admin/categorias");
        }
    }

    public function status(int $categoria_id)
    {
        $categoria = $this->categoriaModel->find($categoria_id);
        $novo_status = $categoria["status"] == "A" ? "I" : "A";

        try {
            $this->categoriaModel->update($categoria["id"], ["status" => $novo_status]);
            toast(TOAST_SUCCESS, "Sucesso", "Categoria salva com sucesso!");
            return redirect()->to("admin/categorias");
        } catch (Exception $e) {
            toast(TOAST_SUCCESS, "Falha", $e->getMessage());
            return redirect()->to("admin/categorias");
        }
    }

    public function editar(int $categoria_id)
    {
        $dados = $this->request->getVar();
        $categoria = $this->categoriaModel->find($categoria_id);

        try {
            $this->categoriaModel->update($categoria["id"], $dados);
            toast(TOAST_SUCCESS, "Sucesso", "Categoria salva com sucesso!");
            return redirect()->to("admin/categorias");
        } catch (Exception $e) {
            toast(TOAST_SUCCESS, "Falha", $e->getMessage());
            return redirect()->to("admin/categorias");
        }
    }
}
