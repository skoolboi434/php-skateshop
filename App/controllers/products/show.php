<?php

$config = require basePath("Config/db.php");

$db = new Database($config);

$id = $_GET['id'] ?? '';

$params = [
  'id' => $id
];

$product = $db->query("SELECT * FROM products WHERE id = :id ", $params)->fetch();

inspect($product);

loadView("products/show");