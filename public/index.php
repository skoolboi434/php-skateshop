<?php

session_start();

use Framework\Router;

require __DIR__ . "/../vendor/autoload.php";
require("../helpers.php");

// Instantiing the router
$router = new Router();

// Get routes
$routes = require basePath("routes.php");

// Get current URI and HTTP method
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);


// Route the request
$router->route($uri);