<?php

namespace App\Controllers;

use App\Models\SistemaModel;

class ConfiguracaoController extends BaseController
{
    protected $sistemaModel;

    public function __construct()
    {
        $this->sistemaModel = new SistemaModel();
    }

    public function index()
    {
        $sistema = $this->sistemaModel->find(session()->get("sistema")["id"]);

        $data = [
            "page_title" => "configurações",
            "sistema" => $sistema
        ];

        return view('page/configuracao', $data);
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

        try {
            $this->sistemaModel->update($id, $dados);

            $sistema = $this->sistemaModel->find($id);

            session()->set('sistema', $sistema);

            toast(TOAST_SUCCESS, "Sucesso", "Configuração salva com sucesso!");

            return redirect()->to('admin/configuracao');
        } catch (\Exception $e) {
            toast(TOAST_ERROR, "Erro", $e->getMessage());
            return redirect()->to('admin/configuracao');
        }
    }
}
