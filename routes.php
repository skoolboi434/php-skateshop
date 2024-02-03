<? 

$router->get('/', 'App/controllers/home.php');
$router->get('/products', 'App/controllers/products/index.php');
$router->get('/products/create', 'App/controllers/products/create.php');