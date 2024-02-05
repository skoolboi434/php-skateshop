<?= loadPartial("header"); ?>

<div class="container">
  <div class="heading-container my-5">
    <h3>Brand:
      <?php echo $brand; ?>
    </h3>
  </div>

  <div class="row">
    <?php foreach ($products as $product): ?>
      <div class="col-md-3 mb-4">
        <div class="product-card">
          <div class="img-container mb-3">
            <a href="/product/<?= $product->id ?>">
              <img src="../imgs/<?= $product->featured_image ?>" class="img-fluid"
                alt="<?= $product->name ?>">
            </a>
          </div>
          <div class="product-info">
            <h4 class="product-brand">
              <?= $product->brand; ?>
            </h4>
            <p class="product-title">
              <?= $product->name; ?>
            </p>
            <span class="deck-size d-block mb-2">
              <?= $product->size; ?>"
            </span>
            <span class="price"><strong>
                <?= formatPrice($product->price); ?>
              </strong></span>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
<?= loadPartial("footer"); ?>