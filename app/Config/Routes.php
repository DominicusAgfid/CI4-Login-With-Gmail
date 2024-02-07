<?php

use CodeIgniter\Router\RouteCollection;

$routes->setAutoRoute(true);

/**
 * @var RouteCollection $routes
 */
$routes->add('/', 'Login::index');
$routes->add('/login/proses', 'Login::proses');
$routes->add('/login/keluar', 'Login::keluar');
