<?php

namespace App\Controllers;
use Framework\Database;
use PDO;

class CartController
{
  protected $db;
  public function __construct()
  {
    $config = require basePath("Config/db.php");

    $this->db = new Database($config);
  }

  public function index()
{
    //inspectAndDie($_SESSION['cart']);
    // Check if cart exists in session
    if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        // Get product IDs from session
        $product_ids = array_keys($_SESSION['cart']);


      //inspect($product_ids);
        // Fetch products from database
        $products = []; // Array to store fetched products
        foreach($product_ids as $product_id) {
          // Prepare and execute the SQL statement
          $stmt = $this->db->prepareAndExecute("SELECT * FROM products WHERE id = :id", [':id' => $product_id]);
          
          // Fetch the product details
          $product = $stmt->fetch(PDO::FETCH_ASSOC);
          
          // If product exists, add it to the products array
          if($product) {
              $products[] = $product;
          }
        }


        // Get total price of cart
        $totalPrice = 0;
        foreach ($products as $product) {
            // Ensure 'price' attribute is numeric before adding to total price
            if (is_numeric($product['price'])) {
                $totalPrice += (float)$product['price'];
            }
        }
      
        
        // Now $products array contains the details of products in the cart
        // You can pass $products array to the view for display
      
        loadView("/cart", ['products' => $products, 'totalPrice'=> $totalPrice]);
    } else {
        // No items in cart, display empty cart message
        $_SESSION['error_message'] = 'Cart is currently empty.';
        loadView("/cart", ['products' => []]);
    }
}




  
  public function addToCart()
  {
   

    if (isset($_POST['add-to-cart'])) {
        $productId = $_POST['product_id'];

        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['error_message'] = 'Product Already in Cart';
            redirect('/products');
        } else {
            // Add the product to the cart
            $_SESSION['cart'][$productId] = [
                'id' => $productId
                // You can include other product details here if needed
            ];
            redirect('/cart');
        }
    }
  }

  public function removeFromCart()
    {
        // Check if product ID is provided and is numeric
        if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
            $productId = $_POST['product_id'];

            // Check if the product exists in the cart
            if (isset($_SESSION['cart'][$productId])) {
                // Remove the product from the cart
                unset($_SESSION['cart'][$productId]);
            }
        }
        $_SESSION['success_message'] = 'Item removed from cart successfully.';
        redirect('/cart');

        // Redirect back to the cart page or any other appropriate action
        // header('Location: /cart');
        // exit;
    }

  public function clearCart()
    {
        // Unset the cart session variable
        unset($_SESSION['cart']);

        $_SESSION['success_message'] = 'Cart cleared successfully.';
        redirect('/cart');
        exit;
    }
}