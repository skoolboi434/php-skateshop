<?php

namespace App\Controllers;

use Framework\Database;

use Traits\BrandTrait;

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

  use BrandTrait;

  public function index()
  {
    $brands = $this->getUniqueBrands($this->db);

    $products = $this->db->query("SELECT * FROM products LIMIT 8")->fetchAll();
    loadView("home", ["products" => $products, "brands" => $brands]);
  }

}