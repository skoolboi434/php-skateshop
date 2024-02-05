<?php




use Framework\Router;

require __DIR__ . "/../vendor/autoload.php";
require("../helpers.php");


// Custom Autoloader

// spl_autoload_register(function ($class) {
//   $path = basePath("Framework/" . $class . ".php");
//   if (file_exists($path)) {
//     require($path);
//   }
// });

// Instantiing the router
$router = new Router();

// Get routes
$routes = require basePath("routes.php");

// Get current URI and HTTP method
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);


// Route the request
$router->route($uri);