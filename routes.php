<?

$router->get('/', 'HomeController@index');
$router->get('/products', 'ProductController@index');
$router->get('/products/create', 'ProductController@create');
$router->get('/product/{id}', 'ProductController@show');
$router->get('/products/{brand}', 'ProductController@brands');