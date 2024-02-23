<?php

loadPartial('header'); 


?>
<div class="container mb-5 pt-5">
  <?php loadPartial("message"); ?>
  <div class="row">
    <div class="col-md-7">
      <div class="shopping-cart">
        <h6>My Cart</h6>
        <hr>

        <form action="/cart/remove" method="POST" class="cart-items">
          <div class="border rounded">
            <?php foreach ($products as $product): ?>
            <div class="row mb-3">
              <div class="col-md-3">
                <img src="../uploads/<?= $product['featured_image'] ?>"
                  alt="<?= $product['name'] ?>" class="img-fluid">
              </div>
              <div class="col-md-6">
                <h5 class="pt-2"><?= $product['name'] ?></h5>
                <h5 class="pt-2 price">$<?= $product['price'] ?></h5>
                <form action="/cart/remove" method="POST">
                  <input type="hidden" name="product_id"
                    value="<?= $product['id'] ?>">
                  <button class="btn btn-danger" type="submit">Remove</button>
                </form>
              </div>
              <div class="col-md-3 py-5">
                <div>
                  <button type="button"
                    class="btn bg-light border rounded-circle">-</button>
                  <input type="text" name="" id="" value="1"
                    class="form-control w-25 d-inline">
                  <button type="button"
                    class="btn bg-light border rounded-circle">+</button>
                </div>
              </div>
            </div>
            <?php endforeach ?>



          </div>
        </form>
      </div>
    </div>
    <div class="col-md-5 border rounded mt-5 bg-white h-25 pb-2">
      <div class="pt-4">
        <h6>Cart Details</h6>
        <hr>
        <div class="row price-details">
          <div class="col-md-6">
            <?php
            $total = 0;
            if(isset($_SESSION['cart'])) {
              $count = count($_SESSION['cart']);

              echo "<h6>Cart Count ($count items)</h6>";

            } else {
              echo "<h6>Cart Count (0 items)</h6>";
            }
            
            ?>
            <h6>Shipping</h6>
            <hr>
            <h6>Amount Payable</h6>
          </div>
          <div class="col-md-6">
            <?php if (isset($totalPrice)): ?>
            <h6>Total Price:
              $<?= number_format($totalPrice, 2) ?>
            </h6>
            <h6 class="text-success">Free</h6>
            <hr>
            <p>$<?= number_format($totalPrice, 2) ?>
            </p>
            <?php endif; ?>
          </div>

        </div>
      </div>
      <form action="/cart/clear" method="post">
        <button class="btn btn-danger" type="submit">Clear Cart</button>
      </form>
    </div>

  </div>
</div>
<?= loadPartial("footer"); ?>