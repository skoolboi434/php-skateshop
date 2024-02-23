<h3 id="brand-heading">Search:
  <?php
  if (isset($_POST['search'])) {
    $searchQuery = htmlspecialchars($_POST['keyword'], ENT_QUOTES, 'UTF-8');
    echo $searchQuery;
  } else {
    echo 'No results found';
  }
  ?>
</h3>