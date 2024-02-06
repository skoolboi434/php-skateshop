<?php

namespace Traits;

trait Searchable
{
  public function search($query)
  {
    // Implement your search logic here
    // For example, querying the database based on the given search query
    return $this->db->query("SELECT * FROM products WHERE name LIKE :query", ['query' => "%" . (string) $query . "%"])->fetchAll();
  }
}