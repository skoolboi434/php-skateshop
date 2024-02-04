<?php


namespace Traits;

use PDO;

trait BrandTrait
{
  public function getUniqueBrands($db)
  {
    return $db->query("SELECT DISTINCT brand FROM products")->fetchAll(PDO::FETCH_OBJ);
  }
}