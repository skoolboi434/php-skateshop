<?= loadPartial("header"); ?>

<div class="product-details container my-3">
  <div class="row">
    <div class="col-md-6">
      <div class="img-container">
        <img src="/imgs/<?= $product->featured_image ?>" class="img-fluid"
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
      <button class="btn btn-primary" name='add-to-cart'>Add To Cart</button>
    </div>
  </div>
</div>
<?= loadPartial("footer"); ?>