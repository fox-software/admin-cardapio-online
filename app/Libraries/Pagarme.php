<?php

namespace App\Libraries;

use Exception;
use GuzzleHttp\Client;

class Pagarme
{
    private $http;
    private $requestOptions;

    protected $API_KEY_PAGARME;
    protected $SECRET_KEY_PAGARME;

    public function __construct()
    {
        $this->API_KEY_PAGARME = getenv('API_KEY_PAGARME');
        $this->SECRET_KEY_PAGARME = getenv('SECRET_KEY_PAGARME');

        $this->http = new Client(['base_uri' => "https://api.pagar.me/1/"]);

        $this->requestOptions = [
            'body' => json_encode([]),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ];
    }

    public function criarPagamentoCartaoCredito($usuario, $dados)
    {
        $dadosPagamento = $this->dadosPagamentoCartaoCredito($usuario, $dados);

        try {
            $this->requestOptions["body"] = json_encode($dadosPagamento);

            $response = $this->http->request('POST', 'transactions', $this->requestOptions);

            if ($response->getStatusCode() != 200)
                throw new Exception("A requisição falhou");

            $response = json_decode($response->getBody());

            if (empty($response->id) || (!empty($response->status) != "pending"))
                throw new Exception("Não foi possível efetuar o pagamento houve uma falha com o Gateway de pagamento");

            return [
                "success" => true,
                "data" => ["response" => $response]
            ];
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    private function dadosPagamentoCartaoCredito($usuario, $dados)
    {
        $data = [
            "api_key" => $this->API_KEY_PAGARME,
            "amount" => only_numbers($dados->total),
            "card_number" => only_numbers($dados->cartao->numero),
            "card_cvv" => $dados->cartao->cvv,
            "card_expiration_date" => only_numbers($dados->cartao->validade),
            "card_holder_name" => $dados->cartao->titular,
            "customer" => [
                "external_id" => $usuario["id"],
                "name" => $usuario["nome"] . " " . $usuario["sobrenome"],
                "type" => "individual",
                "country" => "br",
                "email" => $usuario["email"],
                "documents" => [
                    [
                        "type" => "cpf",
                        "number" =>  only_numbers($usuario["cpf"])
                    ]
                ],
                "phone_numbers" => ["+55 " . only_numbers($usuario["telefone"])],
            ],
            "billing" => [
                "name" => $usuario["nome"] . " " . $usuario["sobrenome"],
                "address" => [
                    "country" => "br",
                    "state" => $dados->endereco->estado,
                    "city" => $dados->endereco->cidade,
                    "neighborhood" => $dados->endereco->bairro,
                    "street" => $dados->endereco->endereco,
                    "street_number" => $dados->endereco->numero,
                    "zipcode" => $dados->endereco->cep
                ]
            ],
            "shipping" => [
                "name" => $usuario["nome"] . " " . $usuario["sobrenome"],
                "fee" => only_numbers($dados->frete),
                "delivery_date" => date("Y-m-d"),
                "expedited" => true,
                "address" => [
                    "country" => "br",
                    "state" => $dados->endereco->estado,
                    "city" => $dados->endereco->cidade,
                    "neighborhood" => $dados->endereco->bairro,
                    "street" => $dados->endereco->endereco,
                    "street_number" => $dados->endereco->numero,
                    "zipcode" => $dados->endereco->cep
                ]
            ],
        ];

        $data["items"] = [];
        for ($i = 0; $i < count($dados->carrinho); $i++) {
            array_push($data["items"], [
                "id" => $dados->carrinho[$i]->produto_id,
                "title" => $dados->carrinho[$i]->nome,
                "quantity" => $dados->carrinho[$i]->quantidade,
                "unit_price" => only_numbers($dados->carrinho[$i]->preco),
                "tangible" => true
            ]);
        }

        return $data;
    }
}
