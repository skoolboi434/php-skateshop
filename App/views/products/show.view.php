<?= loadPartial("header"); ?>

<div class="product-details container my-5">
  <?php loadPartial("message"); ?>
  <div class="btn-container mb-5 d-flex justify-content-end">
    <a href="/products/edit/<?= $product->id ?>"
      class="btn btn-primary d-block me-2">Edit</a>
    <form action="" method="post">
      <input type="hidden" name="_method" value="DELETE">
      <button type="submit" class="btn btn-danger">Delete</button>
    </form>
  </div>
  <form action="/cart" method="POST">
    <div class="row">
      <div class="col-md-6">
        <div class="img-container">
          <img src="/uploads/<?= $product->featured_image ?>" class="img-fluid"
            alt="<?= $product->name ?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="product-info">
          <h3 class='heading'>
            <?= $product->name ?>
          </h3>
          <hr>
          <p class="price">Price:
            <?= formatPrice($product->price) ?>
          </p>
          <p class="size">Size:
            <?= $product->size ?>
          </p>
          <p class="description">
            <?= $product->description ?>
          </p>
        </div>

        <input type="number" name="quantity" value="1" min="1"
          max="<?=$product->qty?>" placeholder="Quantity" required>
        <input type="hidden" name="product_id" value="<?=$product->id?>">
        <input type="submit" class="btn btn-primary" name='add-to-cart'
          value="Add To Cart">
        <input type="hidden" name="product_id" value="<?= $product->id ?>">
      </div>
  </form>
</div>
</div>
<?= loadPartial("footer"); ?>