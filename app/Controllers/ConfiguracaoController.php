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

        $validate = $this->validate([
            'foto' => [
                'uploaded[foto]',
                'mime_in[foto,image/jpg,image/jpeg,image/png]',
                'max_size[foto,1024]',
            ]
        ]);

        $img = $this->request->getFile('foto');

        if (isset($img) && $img->isValid()) {
            if (!$validate) {
                toast(TOAST_ERROR, "Falha", 'Tipo de arquivo não permitido!');
                return redirect()->to("admin/configuracao");
            } else {
                // $fileName = $img->getRandomName();
                // $ext = pathinfo($img->getName(), PATHINFO_EXTENSION);

                $fileName = date("Y-m-d_H-i-s") . '_' . $img->getName();
                $img->move(ROOTPATH . 'public/assets/uploads', $fileName);
                $dados["foto"] = base_url("assets/uploads/$fileName");
            }
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
