<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

use App\Models\UsuarioModel;

class AuthApi implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    $key = getenv('JWT_SECRET');
    $header = $request->getHeader("Authorization");
    $token = null;

    // extract the token from the header
    if (!empty($header)) {
      if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
        $token = $matches[1];
      }
    }

    // check if token is null or empty
    if (is_null($token) || empty($token)) {
      log_message('info', 'JWT token not provided');
      $response = service('response');
      $response->setBody('Access denied - JWT token not provided');
      $response->setStatusCode(401);
      return $response;
    }

    try {
      $decoded_obj = JWT::decode($token, new Key($key, 'HS256'));
      $decoded = (array) $decoded_obj;

      $model = new UsuarioModel();
      $usuario = $model->select(['id', 'nome', 'sobrenome', 'email'])->where('id', $decoded['usuario_id'])->first();

      $request->setGlobal('post', $usuario);
    } catch (Exception $ex) {
      log_message('info', 'JWT Failed ' . $ex);
      $response = service('response');
      $response->setBody('Access denied - JWT Failed');
      $response->setStatusCode(401);
      return $response;
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    //
  }
}
