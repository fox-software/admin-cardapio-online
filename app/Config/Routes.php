<?php

namespace Config;

use App\Controllers\Api\AutenticacaoController;
use App\Controllers\Api\CartaoController;
use App\Controllers\Api\CategoriaController;
use App\Controllers\Api\EnderecoController;
use App\Controllers\Api\PagamentoController;
use App\Controllers\Api\PedidoController;
use App\Controllers\Api\ProdutoController;
use App\Controllers\Api\SistemaController;
use App\Controllers\Api\UsuarioController;

use App\Controllers\CategoriaController as CategoriaAdminController;
use App\Controllers\ProdutoController as ProdutoAdminController;
use App\Controllers\ConfiguracaoController;
use App\Controllers\DashboardController;
use App\Controllers\FormaPagamentoController;
use App\Controllers\LoginController;
use App\Controllers\PainelController;
use App\Controllers\UsuarioController as UsuarioAdminController;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController(LoginController::class);
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route ADMIN
 * --------------------------------------------------------------------
 */
$routes->get('/', [LoginController::class, "index"]);
$routes->post('/login', [LoginController::class, "login"]);
$routes->get('/logout', [LoginController::class, "logout"]);

$routes->group('admin', ['filter' => 'authGuard'], function ($routes) {

    $routes->group('dashboard', function ($routes) {
        $routes->get('', [DashboardController::class, "index"]);
        $routes->get('graphic/(:num)', [DashboardController::class, "graphic"]);
    });

    $routes->group('painel', function ($routes) {
        $routes->get('', [PainelController::class, "index"]);
        $routes->get('kanban', [PainelController::class, "kanban"]);
        $routes->get('pedido/(:num)/status/(:any)', [PainelController::class, "status"]);
    });

    $routes->group('forma_de_pagamentos', function ($routes) {
        $routes->get('', [FormaPagamentoController::class, "index"]);
        $routes->get('(:num)/status', [FormaPagamentoController::class, "status"]);
        $routes->get('(:num)/adicionar', [FormaPagamentoController::class, "adicionar"]);
    });

    $routes->group('categorias', function ($routes) {
        $routes->get('', [CategoriaAdminController::class, "index"]);
        $routes->post('cadastrar', [CategoriaAdminController::class, "cadastrar"]);
        $routes->get('(:num)/status', [CategoriaAdminController::class, "status"]);
        $routes->post('(:num)/editar', [CategoriaAdminController::class, "editar"]);
    });

    $routes->group('produtos', function ($routes) {
        $routes->get('', [ProdutoAdminController::class, "index"]);
        $routes->post('cadastrar', [ProdutoAdminController::class, "cadastrar"]);
        $routes->get('(:num)/status', [ProdutoAdminController::class, "status"]);
        $routes->post('(:num)/editar', [ProdutoAdminController::class, "editar"]);
    });

    $routes->group('usuarios', function ($routes) {
        $routes->get('', [UsuarioAdminController::class, "index"]);
        $routes->get('(:num)/status', [UsuarioAdminController::class, "status"]);
    });

    $routes->group('configuracao', function ($routes) {
        $routes->get('', [ConfiguracaoController::class, "index"]);
        $routes->post('(:num)/editar', [ConfiguracaoController::class, "editar/$1"]);
    });
});

/*
 * --------------------------------------------------------------------
 * Route API
 * --------------------------------------------------------------------
 */

$routes->group('api', ['filter' => 'cors'], function ($routes) {

    $routes->post('login', [AutenticacaoController::class, "login"]);
    $routes->post('logout', [AutenticacaoController::class, "logout"]);

    $routes->group('usuarios', function ($routes) {
        $routes->get('', [UsuarioController::class, "index"]);
        $routes->get('status', [UsuarioController::class, "status"]);
        $routes->post('cadastrar', [UsuarioController::class, "cadastrar"]);
        $routes->get('endereco/(:num)', [UsuarioController::class, "endereco/$1"]);
    });

    $routes->group('sistema', function ($routes) {
        $routes->get('', [SistemaController::class, "index"]);
        $routes->get('pagamentos', [SistemaController::class, "formaPagamentos"]);
    });

    $routes->group('pedidos', function ($routes) {
        $routes->get('', [PedidoController::class, "index"]);
        $routes->get('detalhes/(:num)', [PedidoController::class, "detalhes"]);
        $routes->post('cadastrar', [PedidoController::class, "cadastrar"]);
    });

    $routes->group('enderecos', function ($routes) {
        $routes->get('', [EnderecoController::class, "index"]);
        $routes->post('editar', [EnderecoController::class, "editar"]);
        $routes->post('cadastrar', [EnderecoController::class, "cadastrar"]);
    });

    $routes->group('pagamentos', function ($routes) {
        $routes->post('cartao-credito', [PagamentoController::class, "checkoutCreditCard"]);
    });

    $routes->group('cartoes', function ($routes) {
        $routes->post('cadastrar', [CartaoController::class, "cadastrar"]);
    });

    $routes->get('categorias', [CategoriaController::class, "index"]);

    $routes->get('produtos', [ProdutoController::class, "index"]);
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
