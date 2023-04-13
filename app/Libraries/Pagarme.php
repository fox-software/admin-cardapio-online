<?php

namespace App\Libraries;

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

    public function criarUsuarioPagarme($usuarioID, $usuario)
    {
        try {
            $dadosUsuario = [
                "api_key" => $this->API_KEY_PAGARME,
                "external_id" => $usuarioID,
                "name" => $usuario["nome"],
                "type" => "individual",
                "country" => "br",
                "email" => $usuario["email"],
                "documents" => [
                    [
                        "type" => "cpf",
                        "number" => $usuario['cpf'],
                    ]
                ],
                "phone_numbers" => [
                    "+55" . $usuario["telefone"],
                ],
                "birthday" => "1998-07-03"
            ];

            $this->requestOptions["body"] = json_encode($dadosUsuario);

            $response = $this->http->request('POST', 'customers', $this->requestOptions);

            if ($response->getStatusCode() != 200) throw new \Exception("A requisição falhou, não foi possível criar um cliente");

            $response = json_decode($response->getBody());

            if (empty($response->id)) throw new \Exception("Não foi possível criar o cliente");

            return [
                "success" => true,
                "data" => ["customer" => $response]
            ];
        } catch (\Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function criarCartaoUsuarioPagarme($usuarioID, $cartao)
    {
        try {
            $this->requestOptions["body"] = json_encode([
                "api_key" => $this->API_KEY_PAGARME,
                "customer_id" => $usuarioID,
                "holder_name" => $cartao->titular,
                "number" => $cartao->numero,
                "expiration_date" => $cartao->mes_expiracao . $cartao->ano_expiracao,
                "cvv" => $cartao->cvv,
            ]);

            $response = $this->http->request('POST', "cards", $this->requestOptions);

            if ($response->getStatusCode() != 200) throw new \Exception("A requisição falhou, não foi possível processar o cartão");

            $response = json_decode($response->getBody());

            if (empty($response->id)) throw new \Exception("Não foi possível processar o cartão");

            return [
                "success" => true,
                "data" => [
                    "card" => $response,
                    "cardToken" => $response->id
                ]
            ];
        } catch (\Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}
