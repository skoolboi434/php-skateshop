<?= loadPartial("header"); ?>

<div class="container">
  <div class="heading-container my-5">
    <?php loadPartial('search'); ?>
  </div>

  <div class="row">
    <?php foreach ($results as $result): ?>
      <div class="col-md-3 mb-4">
        <div class="product-card">
          <div class="img-container mb-3">
            <a href="/product/<?= $result->id ?>">
              <img
                src="<?php echo BASE_URL; ?>/uploads/<?= $result->featured_image ?>"
                class="img-fluid" alt="<?= $result->name ?>">
            </a>
          </div>
          <div class="product-info">
            <h4 class="product-brand">
              <?= $result->brand; ?>
            </h4>
            <p class="product-title">
              <?= $result->name; ?>
            </p>
            <span class="deck-size d-block mb-2">
              <?= $result->size; ?>"
            </span>
            <span class="price"><strong>
                <?= formatPrice($result->price); ?>
              </strong></span>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
<?= loadPartial("footer"); ?>