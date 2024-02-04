<?php

namespace App\Controllers;

use Framework\Database;

class ProductController
{
  protected $db;
  public function __construct()
  {
    $config = require basePath("Config/db.php");

    $this->db = new Database($config);
  }

  /**
   * Show all listings 
   * @return void
   */

  public function index()
  {
    $products = $this->db->query("SELECT * FROM products")->fetchAll();
    loadView("home", ["products" => $products]);
  }

  /**
   * Add product
   * @return void
   */

  public function create()
  {
    loadView("products/create");
  }

  /**
   * Show single product listing
   * @return void
   */

  public function show($params)
  {
    $id = $params['id'] ?? '';

    $params = [
      'id' => $id
    ];

    $product = $this->db->query("SELECT * FROM products WHERE id = :id ", $params)->fetch();

    // Check if product exists
    if (!$product) {
      ErrorController::notFound('Product not found');
      return;
    }
    loadView("products/show", ["product" => $product]);
  }
}