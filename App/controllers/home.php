<?php

$config = require basePath("Config/db.php");

$db = new Database($config);

$products = $db->query("SELECT * FROM products LIMIT 8")->fetchAll();


loadView("home", ["products" => $products]);