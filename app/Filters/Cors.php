<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
      $origin = $_SERVER['HTTP_ORIGIN'];
    } else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
      $origin = $_SERVER['HTTP_REFERER'];
    } else {
      $origin = $_SERVER['REMOTE_ADDR'];
    }
    $allowed_domains = array(
      'https://app-cardapio-online.vercel.app',
      'http://localhost:8100',
    );


    if (in_array($origin, $allowed_domains)) {
      header('Access-Control-Allow-Origin: ' . $origin);
    }
    
    header('Access-Control-Allow-Origin: https://app-cardapio-online.vercel.app');
    header("Access-Control-Allow-Headers: Content-Type, Accept, Authorization, sistema");
    // header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PATCH, OPTIONS");
    // header("Access-Control-Allow-Credentials: true");
    // header("Access-Control-Max-Age: 3600");
    // header('content-type: application/json; charset=utf-8');
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
