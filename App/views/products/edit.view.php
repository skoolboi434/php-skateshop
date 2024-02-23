<?= loadPartial("header"); ?>
<section class="edit-product-container mb-5">
  <div class="container">
    <div class="heading-container my-5">
      <h3 class="heading">Edit Product Product</h3>
    </div>

    <?php loadPartial('errors', ['errors' => $errors ?? []]); ?>

    <div class="form-container">
      <form method="POST" action="/products/<?= $product->id ?>"
        enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group mb-3">
          <input type="text" class="form-control" name="name"
            placeholder="Product Name" value="<?= $product->name ?? '' ?>">
        </div>
        <div class="form-group mb-3">
          <input type="text" class="form-control" name="brand"
            placeholder="Product Brand" value="<?= $product->brand ?? '' ?>">
        </div>
        <div class="form-group mb-3">
          <input type="text" class="form-control" name="category"
            placeholder="Category" value="<?= $product->category ?? '' ?>">
        </div>
        <div class="form-group mb-3">
          <input type="text" class="form-control" name="price"
            placeholder="Price" value="<?= $product->price ?? '' ?>">
        </div>
        <div class="form-group mb-3">
          <input type="text" class="form-control" name="size" placeholder="Size"
            value="<?= $product->size ?? '' ?>">
        </div>
        <div class="form-group mb-3">
          <input type="text" class="form-control" name="qty"
            placeholder="Quantity" value="<?= $product->qty ?? '' ?>">
        </div>
        <div class="form-group mb-3">
          <textarea class="form-control" name="description" cols="30" rows="10"
            placeholder="Enter Description"><?= $product->description ?? '' ?></textarea>
        </div>
        <div class="form-group mb-3">
          <input type="file" class="form-control" name="featured_image"
            id="uploadImage" value="<?= $product->featured_image ?? '' ?>" />
        </div>
        <div class="btn-container">
          <button type="submit"
            class="btn btn-success d-block w-100 mb-3">Update
            Product</button>
          <a href="/products/<?= $product->id ?>"
            class="btn btn-danger d-block w-100">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
<?= loadPartial("footer"); ?>