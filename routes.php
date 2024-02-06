<?

$router->get('/', 'HomeController@index');
$router->get('/products', 'ProductController@index');
$router->get('/products/create', 'ProductController@create');
$router->get('/products/edit/{id}', 'ProductController@edit');
$router->get('/products/{id}', 'ProductController@show');
$router->get('/products/brands/{brand}', 'ProductController@brands');

$router->post('/products', 'ProductController@store');
$router->post('/products/search', 'ProductController@performSearch');

$router->put('/products/{id}', 'ProductController@update');

$router->delete('/products/{id}', 'ProductCOntroller@destroy');