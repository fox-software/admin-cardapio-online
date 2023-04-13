<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\ProdutoModel;
use Exception;

class ProdutoController extends BaseController
{
    protected $produtoModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $filtros = $this->request->getVar();

        $data = [
            "page_title" => "produtos",
            "produtos" => $this->produtoModel->getAll($filtros),
            "categorias" => $this->categoriaModel->getAll(["status" => "A"]),
            "filtros" => $filtros
        ];

        return view('page/produtos', $data);
    }

    public function cadastrar()
    {
        $dados = $this->request->getVar();
        $img = $this->request->getFile('foto');

        if (isset($img) && $img->isValid()) {
            $fileName = $img->getRandomName();

            $img->move(ROOTPATH . 'public/uploads', $fileName);
            $dados["foto"] = base_url("uploads/$fileName");
        }

        try {
            $this->produtoModel->insert($dados);

            toast(TOAST_SUCCESS, "Sucesso", "Produto salvo com sucesso!");

            return redirect()->to("admin/produtos");
        } catch (Exception $e) {
            toast(TOAST_SUCCESS, "Erro", $e->getMessage());
            return redirect()->to("admin/produtos");
        }
    }

    public function status(int $id)
    {
        $dados = $this->request->getVar();

        $produto = $this->produtoModel->find($id);
        $novo_status = $produto["status"] == "A" ? "I" : "A";

        try {
            $this->produtoModel->update($produto["id"], ["status" => $novo_status]);
            toast(TOAST_SUCCESS, "Sucesso", "Produto salvo com sucesso!");
        } catch (Exception $e) {
            toast(TOAST_SUCCESS, "Falha", $e->getMessage());
        }

        if (!empty($dados)) {
            return redirect()->to("admin/" . $dados["redirect"]);
        }

        return redirect()->to("admin/produtos");
    }

    public function editar(int $id)
    {
        $dados = $this->request->getVar();
        $img = $this->request->getFile('foto');

        if (isset($img) && $img->isValid()) {
            $fileName = $img->getRandomName();

            $img->move(ROOTPATH . 'public/uploads', $fileName);
            $dados["foto"] = base_url("uploads/$fileName");
        }

        $produto = $this->produtoModel->find($id);

        try {
            $this->produtoModel->update($produto["id"], $dados);
            toast(TOAST_SUCCESS, "Sucesso", "Produto salvo com sucesso!");
            return redirect()->to("admin/produtos");
        } catch (Exception $e) {
            toast(TOAST_SUCCESS, "Falha", $e->getMessage());
            return redirect()->to("admin/produtos");
        }
    }
}
