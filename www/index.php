<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/pecee/simple-router/helpers.php';
require_once __DIR__ . '/engine/websun.php';
require_once __DIR__ . '/engine/Template.php';

$dotenv = \Dotenv\Dotenv::create(__DIR__, '_env');
$dotenv->load();

use Arris\DB;

DB::init(NULL, [
    'hostname' => getenv('DB_HOST'),
    'database' => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'port' => getenv('DB_PORT'),
    'charset' => 'utf8',
    'charset_collate' => 'utf8_general_ci',
]);

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::setDefaultNamespace('Gatehouse\Controllers');

SimpleRouter::get('/', 'Page@page_welcome');

SimpleRouter::group([
    'prefix'    =>  '/places'
], function () {
    SimpleRouter::get('/', 'Allotment@page_list');
    SimpleRouter::get('/add', 'Allotment@form_add');
    SimpleRouter::get('/edit', 'Allotment@form_edit');
    SimpleRouter::post('/callback_add', 'Allotment@callback_add');
    SimpleRouter::post('/callback_edit', 'Allotment@callback_edit');
    SimpleRouter::get('/callback_delete', 'Allotment@callback_delete');
});

SimpleRouter::group([
    'prefix'    =>  '/transport'
], function () {
    SimpleRouter::get('/', 'Transport@page_list');
    SimpleRouter::get('/add', 'Transport@form_add');
    SimpleRouter::get('/edit', 'Transport@form_edit');
    SimpleRouter::post('/callback_add', 'Transport@callback_add');
    SimpleRouter::post('/callback_edit', 'Transport@callback_edit');
    SimpleRouter::get('/callback_delete', 'Transport@callback_delete');
});

SimpleRouter::error(function (Pecee\Http\Request $request, \Exception $exception){
    d($exception);
    d($request);
    dd('');
});

SimpleRouter::start();

