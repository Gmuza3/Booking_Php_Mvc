<?php

require_once '../vendor/autoload.php';

use App\router\Routers;
use App\controller\authcontroller;
use App\helpers\authMiddleware\AuthMiddleware;
use App\model\database\Database;


$database = new Database();

$router = new Routers($database);

$uri = $_SERVER['REQUEST_URI'];


$authFreeRoutes = [
    '/booking/login',
    '/booking/register',
    '/booking/logOut'
];

AuthMiddleware::check($uri, $authFreeRoutes);

$router->get('/booking', [authcontroller::class, 'index']);

$router->get('/booking/login', [authcontroller::class, 'login']);
$router->post('/booking/login', [authcontroller::class, 'login']);


$router->get('/booking/register', [authcontroller::class, 'register']);
$router->post('/booking/register', [authcontroller::class, 'register']);


$router->get('/booking/logout', [authcontroller::class, 'logOut']);

$router->get('/booking/service', [authcontroller::class, 'service']);

$router->post('/booking/book', [authcontroller::class, 'newBookings']);
$router->get('/booking/book', [authcontroller::class, 'newBookings']);

$router->get('/booking/profile', [authcontroller::class, 'profile']);

$router->post('/booking/profile/update', [authcontroller::class, 'updateProfile']);


$router->get('/booking/dashboard', [authcontroller::class, 'dashbord']);

$router->post('/booking/admin', [authcontroller::class, 'admin']);

$router->resolve();

