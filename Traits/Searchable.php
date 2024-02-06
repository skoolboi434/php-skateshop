<?php

namespace Traits;

trait Searchable
{
  public function search($query)
  {
    // Implement your search logic here
    // For example, querying the database based on the given search query
    $likeQuery = '%' . $query . '%';
    return $this->db->query("
        SELECT * 
        FROM products 
        WHERE name LIKE :query 
            OR brand LIKE :query 
            OR category LIKE :query 
            OR description LIKE :query
            OR size LIKE :query
    ", ['query' => $likeQuery])->fetchAll();
  }
}