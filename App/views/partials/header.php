<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,100;1,400&display=swap"
    rel="stylesheet">
  <script src="https://kit.fontawesome.com/9afaec21b5.js"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/custom.css">

  <title>Skateshop</title>
</head>

<body>
  <nav class="navbar navbar-custom navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Skateshop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page"
              href="/products">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/products/create">Add
              Product</a>

          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/cart">
              <i class="fa fa-solid fa-basket-shopping"></i> Cart
              <?php 
              if(isset($_SESSION['cart'])) {
                $count = count($_SESSION['cart']);
                echo "<span id=\"cart_count\">$count</span>";
              } else {
                echo "<span id=\"cart_count\">0</span>";
              }
              ?>
            </a>

          </li>
        </ul>

      </div>
    </div>
  </nav>