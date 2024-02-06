<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

use Traits\Searchable;


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

    $products = $this->db->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
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



    loadView("/products/brands", ["products" => $products, "brand" => $brand]);
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

      // Set flash message
      $_SESSION['success_message'] = 'Product added successfully';

      redirect("/products");
    }
  }

  /**
   * Delete a product
   * 
   * @param array $params
   * @return void
   */

  public function destroy($params)
  {
    $id = $params["id"];

    $params = [
      "id" => $id
    ];

    $product = $this->db->query('SELECT * FROM products WHERE id = :id', $params)->fetch();

    if (!$product) {
      ErrorController::notFound('Product not found');
      return;
    }

    $this->db->query('DELETE FROM products WHERE id = :id', $params);

    // Set flash message
    $_SESSION['success_message'] = 'Product deleted successfully';

    redirect('/products');
  }

  /**
   * Show product edit form
   * @param array $params
   * @return void
   */

  public function edit($params)
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
    loadView("products/edit", ["product" => $product]);
  }

  /**
   * Update a product
   * 
   * @param array $params
   * @return void
   */

  public function update($params)
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

    $updateValues = [];

    $updateValues = array_intersect_key($_POST, array_flip($allowedFields));

    $updateValues = array_map('sanitize', $updateValues);

    $requiredFields = [
      'name',
      'brand',
      'category',
      'price',
      'size',
      'qty',
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
          $updateValues['featured_image'] = $uploadedFileName;
        } else {
          $errors['featured_image'] = 'Failed to upload image.';
        }
      }

    }

    foreach ($requiredFields as $field) {
      if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
        $errors[$field] = ucfirst($field) . ' is required';
      }
    }

    if (!empty($errors)) {
      loadView('products/edit', [
        'product' => $product,
        'errors' => $errors
      ]);
      exit;
    } else {
      // Submit to DB
      $updateFields = [];

      foreach (array_keys($updateValues) as $field) {
        $updateFields[] = "{$field} = :{$field}";
      }

      $updateFields = implode(", ", $updateFields);

      $updateQuery = "UPDATE products SET $updateFields WHERE id = :id";

      $updateValues['id'] = $id;

      $this->db->query($updateQuery, $updateValues);

      $_SESSION['success_message'] = 'Product Updated';

      redirect('/products/' . $id);


    }


  }

  /**
   * Search for products
   */

  use Searchable;

  public function performSearch($keyword)
  {
    if (isset($_POST['search'])) {
      $keyword = $_POST['keyword'];
      // Perform the search using the search method from the Searchable trait
      $results = $this->search($keyword);
      // Pass the search results to the view

      loadView('/products/search', ['results' => $results]);
    } else {
      // Handle other requests (e.g., displaying the search form)
      loadView('search_form');
    }
  }
}