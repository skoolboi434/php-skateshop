<?php

namespace App\Controllers;

use Framework\Database;
use PDO;

class HomeController
{
  protected $db;
  public function __construct()
  {
    $config = require basePath("Config/db.php");

    $this->db = new Database($config);
  }

  /**
   * Show latest products
   * @return void
   */

  public function index()
  {
    $brands = $this->getUniqueBrands();

    $products = $this->db->query("SELECT * FROM products LIMIT 8")->fetchAll();
    loadView("home", ["products" => $products, "brands" => $brands]);
  }

  /**
   * Get list of brands
   * 
   */

  public function getUniqueBrands()
  {
    $brands = $this->db->query("SELECT DISTINCT brand FROM products")->fetchAll(PDO::FETCH_OBJ);

    return $brands;
  }
}