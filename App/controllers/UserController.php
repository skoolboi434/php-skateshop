<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

use PDO;

class UserController
{
  protected $db;

  public function __construct()
  {
    $config = require basePath("config/db.php");
    $this->db = new Database($config);
  }

  /**
   * Show login page
   * 
   * @return void
   */

  public function login()
  {
    loadView('users/login');
  }

  /**
   * Show register page
   * 
   * @return void
   */

  public function create()
  {
    loadView('/users/create');
  }

  /**
   * Store user in database
   * 
   * @return void
   */

  public function store()
  {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['password_confirmation'];

    $errors = [];

    // Validation
    if(!Validation::email($email)){
      $errors['email'] = 'Please enter a valid email address';
    }

    if(!Validation::string($name, 2, 50)){
      $errors['username'] = 'Username must be between 2 and 50 characters';
    }

    if(!Validation::string($password, 6, 50)){
      $errors['password'] = 'Password must be at least 6 characters';
    }

    if(!Validation::match($password, $passwordConfirmation)){
      $errors['password_confirmation'] = 'Passwords do not match';
    }

    if(!empty($errors)) {
      loadView('users/create', ['errors'=> $errors, 'user' => ['username' => $name, 'email' => $email]]);
      exit;
    }

    // Check if email exists
    $params = ['email' => $email];

    $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

    if($user) {
      $errors['email'] = 'That email already exists';
      loadView('users/create', ['errors' => $errors]);
      exit;
    }

    // Create user account
    $params = [
      'username' => $name,
      'email'=> $email,
      'password' => password_hash($password, PASSWORD_DEFAULT),
    ];

    $this->db->query('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)', $params);

    // Get new user ID
    $userId = $this->db->conn->lastInsertId();

    Session::set('user', [
      'id'=> $userId,
      'name'=> $name,
      'email'=> $email,

    ]);

    
    redirect('/');
    
  }

  /**
   * Logout a user and clear session
   * 
   * @return void
   */

   public function logout() {
    Session::clearAll();

    $params = session_get_cookie_params();

    setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

    $_SESSION['success_message'] = 'You have logged out successfully.';

    redirect('/');
    
   }
}