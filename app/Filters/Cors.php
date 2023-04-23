<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    header('Access-Control-Allow-Origin: https://app-cardapio-online.vercel.app');
    
    header("Access-Control-Allow-Headers: Content-Type, Accept, Authorization, Sistema");

    header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS");

    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "OPTIONS") {
      header("HTTP/1.1 200 OK CORS");
      die();
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
  }
}
