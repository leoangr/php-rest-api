<?php 
require 'vendor/autoload.php';

$router = new AltoRouter();

// Jika berada di subfolder, atur basePath
$router->setBasePath('/project-portofolio-website/api-public');

$router->map('GET', '/', function () {
    if (!defined('ROUTE_LOADED')) {
        define('ROUTE_LOADED', true);
    }
    require __DIR__ . '/pages/home.php';
});

$router->map('GET', '/produk', function () {
    if (!defined('ROUTE_LOADED')) {
        define('ROUTE_LOADED', true);
    }
    require __DIR__ . '/api/get-data.php';
});

$router->map('GET', '/produk/[i:get_id]', function ( $get_id ) {
    if (!defined('ROUTE_LOADED')) {
        define('ROUTE_LOADED', true);
    }
    require __DIR__ . '/api/get-data.php';
});

$router->map('POST', '/add-produk', function () {
    if (!defined('ROUTE_LOADED')) {
        define('ROUTE_LOADED', true);
    }
    require __DIR__ . '/api/add-data.php';
});

$router->map('PUT', '/update-produk/[i:get_id]', function ( $get_id ) {
    if (!defined('ROUTE_LOADED')) {
        define('ROUTE_LOADED', true);
    }
    require __DIR__ . '/api/update-data.php';
});

$router->map('DELETE', '/delete-produk/[i:get_id]', function ( $get_id ) {
    if (!defined('ROUTE_LOADED')) {
        define('ROUTE_LOADED', true);
    }
    require __DIR__ . '/api/delete-data.php';
});

$match = $router->match();

// call closure or throw 404 status
if ($match !== false) {
    call_user_func_array($match['target'], $match['params'] ?? []);
} else {
    http_response_code(404);
    require __DIR__ . '/pages/404.php';
}