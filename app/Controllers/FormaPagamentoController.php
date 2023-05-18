<?php

namespace App\Controllers;

use App\Models\FormaPagamentoModel;
use App\Models\FormaPagamentoSistemaModel;
use Exception;

class FormaPagamentoController extends BaseController
{
    protected $formaPagamentoModel;
    protected $formaPagamentoSistemaModel;

    public function __construct()
    {
        $this->formaPagamentoModel = new FormaPagamentoModel();
        $this->formaPagamentoSistemaModel = new FormaPagamentoSistemaModel();
    }

    public function index()
    {
        $data = [
            "page" => "forma_de_pagamentos",
            "page_title" => "Forma de pagamentos",
            "pagamentos" => $this->formaPagamentoModel->getAll(),
        ];

        return view('page/' . $data["page"], $data);
    }

    public function status(int $formaPagamentoId)
    {
        $pagamento = $this->formaPagamentoModel->getById($formaPagamentoId);
        $novo_status = $pagamento["status"] == ATIVO ? INATIVO : ATIVO;

        try {
            $this->formaPagamentoSistemaModel->setStatus($pagamento["forma_pagamentos_sistemas_id"], $novo_status);
            toast(TOAST_SUCCESS, "Sucesso", "Forma de Pagamento salvo com sucesso!");
            return redirect()->to("admin/forma_de_pagamentos");
        } catch (Exception $e) {
            toast(TOAST_ERROR, "Erro", $e->getMessage());
            return redirect()->to("admin/forma_de_pagamentos");
        }
    }
    public function adicionar(int $formaPagamentoId)
    {
        $dados = [
            "sistema_id" => session()->get("sistema")["id"],
            "forma_pagamento_id" => $formaPagamentoId
        ];

        try {
            $this->formaPagamentoSistemaModel->add($dados);
            toast(TOAST_SUCCESS, "Sucesso", "Forma de Pagamento salvo com sucesso!");
            return redirect()->to("admin/forma_de_pagamentos");
        } catch (Exception $e) {
            toast(TOAST_ERROR, "Erro", $e->getMessage());
            return redirect()->to("admin/forma_de_pagamentos");
        }
    }
}
