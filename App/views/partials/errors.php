<?php if (isset($errors)): ?>
<?php foreach ($errors as $error): ?>
<div class="alert alert-danger my-3">
  <?= $error ?>
</div>
<?php endforeach; ?>
<?php endif; ?>