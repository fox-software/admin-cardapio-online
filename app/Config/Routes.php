<?php

namespace Config;

use App\Controllers\ApiCartaoController;
use App\Controllers\ApiCategoriaController;
use App\Controllers\ApiEnderecoController;
use App\Controllers\ApiPagamentoController;
use App\Controllers\ApiPedidoController;
use App\Controllers\ApiProdutoController;
use App\Controllers\ApiSistemaController;
use App\Controllers\ApiUsuarioController;


use App\Controllers\CategoriaController;
use App\Controllers\ConfiguracaoController;
use App\Controllers\DashboardController;
use App\Controllers\FormaPagamentoController;
use App\Controllers\LoginController;
use App\Controllers\PainelController;
use App\Controllers\PedidoController;
use App\Controllers\ProdutoController;
use App\Controllers\UsuarioController;

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

$routes->group('admin', ['filter' => 'authAdmin'], function ($routes) {

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
        $routes->get('', [CategoriaController::class, "index"]);
        $routes->post('cadastrar', [CategoriaController::class, "cadastrar"]);
        $routes->get('(:num)/status', [CategoriaController::class, "status"]);
        $routes->post('(:num)/editar', [CategoriaController::class, "editar"]);
    });

    $routes->group('produtos', function ($routes) {
        $routes->get('', [ProdutoController::class, "index"]);
        $routes->post('cadastrar', [ProdutoController::class, "cadastrar"]);
        $routes->get('(:num)/status', [ProdutoController::class, "status"]);
        $routes->post('(:num)/editar', [ProdutoController::class, "editar"]);
    });

    $routes->group('usuarios', function ($routes) {
        $routes->get('', [UsuarioController::class, "index"]);
        $routes->get('(:num)/status', [UsuarioController::class, "status"]);
    });

    $routes->group('pedidos', function ($routes) {
        $routes->get('', [PedidoController::class, "index"]);
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

    $routes->group('usuarios', function ($routes) {
        $routes->get('', [ApiUsuarioController::class, "index"]);
        $routes->post('login', [ApiUsuarioController::class, "login"]);
        $routes->post('cadastrar', [ApiUsuarioController::class, "cadastrar"]);
        $routes->post('logout', [ApiUsuarioController::class, "logout"]);
        $routes->get('status', [ApiUsuarioController::class, "status"]);
        $routes->get('endereco/(:num)', [ApiUsuarioController::class, "endereco"]);
    });

    $routes->group('sistema', function ($routes) {
        $routes->get('', [ApiSistemaController::class, "index"]);
        $routes->get('pagamentos', [ApiSistemaController::class, "formaPagamentos"]);
    });


    $routes->get('produtos', [ApiProdutoController::class, "index"]);
    $routes->get('categorias', [ApiCategoriaController::class, "index"]);
    
    
    $routes->group('', ['filter' => 'authApi'], function ($routes) {
        $routes->group('enderecos', function ($routes) {
            $routes->get('', [ApiEnderecoController::class, "index"]);
            $routes->post('cadastrar', [ApiEnderecoController::class, "cadastrar"]);
            $routes->post('editar', [ApiEnderecoController::class, "editar"]);
            $routes->post('(:num)/status', [ApiEnderecoController::class, "status"]);
            $routes->post('(:num)/principal', [ApiEnderecoController::class, "principal"]);
        });

        $routes->group('cartoes', function ($routes) {
            $routes->get('', [ApiCartaoController::class, "index"]);
            $routes->post('cadastrar', [ApiCartaoController::class, "cadastrar"]);
            $routes->post('editar', [ApiCartaoController::class, "editar"]);
            $routes->post('(:num)/status', [ApiCartaoController::class, "status"]);
            $routes->post('(:num)/principal', [ApiCartaoController::class, "principal"]);
        });

        $routes->group('pedidos', function ($routes) {
            $routes->get('', [ApiPedidoController::class, "index"]);
            $routes->get('detalhes/(:num)', [ApiPedidoController::class, "detalhes"]);
            $routes->post('cadastrar', [ApiPedidoController::class, "cadastrar"]);
        });

        $routes->group('pagamentos', function ($routes) {
            $routes->post('cartao-credito', [ApiPagamentoController::class, "checkoutCreditCard"]);
        });
    });
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
