<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

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
    loadView("products/index", ["products" => $products]);
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

  /**
   * Show products by brand
   */

  public function brands($params)
  {
    $brand = $params['brand'] ?? '';

    $params = [
      'brand' => $brand
    ];

    $products = $this->db->query("SELECT * FROM products WHERE brand = :brand ", $params)->fetchAll();

    //loadView("products/brands", ["products" => $products, "brand" => $brand]);
  }

  /**
   * Store Data in Database
   * 
   * @return void
   */

  public function store()
  {
    $allowedFields = [
      'name',
      'brand',
      'category',
      'price',
      'size',
      'qty',
      'description',
      'featured_image'
    ];

    $newProductData = array_intersect_key($_POST, array_flip($allowedFields));

    $newProductData = array_map('sanitize', $newProductData);

    $requiredFields = [
      'name',
      'brand',
      'category',
      'price',
      'size',
      'qty',
      'featured_image'
    ];

    $errors = [];

    // Validate and process the uploaded image
    if (!empty($_FILES['featured_image']['tmp_name'])) {
      $uploadDir = __DIR__ . '/../../Public/uploads/';
      $uploadPath = '/uploads/' . basename($_FILES['featured_image']['name']);

      // Ensure the target directory exists, create it if not
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
      }

      // Check if the file is an image
      $imageFileType = strtolower(pathinfo($uploadPath, PATHINFO_EXTENSION));
      if (!getimagesize($_FILES['featured_image']['tmp_name'])) {
        $errors['featured_image'] = 'Uploaded file is not an image.';
      }

      // Check file size (adjust max size as needed)
      elseif ($_FILES['featured_image']['size'] > 5000000) {
        $errors['featured_image'] = 'File is too large. Max size is 5MB.';
      }

      // Check if the file type is allowed
      elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $errors['featured_image'] = 'Only JPG, JPEG, PNG, and GIF files are allowed.';
      }

      // Move the uploaded file to the specified directory
      elseif (empty($errors)) {
        $uploadedFileName = basename($_FILES['featured_image']['name']);
        if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadDir . $uploadedFileName)) {
          $newProductData['featured_image'] = $uploadedFileName;
        } else {
          $errors['featured_image'] = 'Failed to upload image.';
        }
      }

    }





    foreach ($requiredFields as $field) {
      if (empty($newProductData[$field]) || !Validation::string($newProductData[$field])) {
        $errors[$field] = ucfirst($field) . ' is required';
      }
      ;
    }

    if (!empty($errors)) {
      // Reload view with errors
      loadView('products/create', ['errors' => $errors, 'product' => $newProductData]);
    } else {
      // Submit Data

      $fields = [];

      foreach ($newProductData as $field => $value) {
        $fields[] = $field;
      }

      $fields = implode(', ', $fields);

      $values = [];

      foreach ($newProductData as $field => $value) {
        // Convert empty strings to null
        if (empty($newProductData[$field])) {
          $newProductData[$field] = null;
        }

        $values[] = ':' . $field;
      }


      $values = implode(', ', $values);

      $query = "INSERT INTO products ({$fields}) VALUES ({$values})";

      $this->db->query($query, $newProductData);

      redirect("/products");
    }
  }
}