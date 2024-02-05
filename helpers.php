<?php

define('BASE_URL', 'http://localhost:9000');

/**
 * Get the base path
 * 
 * @param string $path
 * @return string
 */

function basePath($path = '')
{
  return __DIR__ . '/' . $path;
}

/**
 * Load view
 * 
 * @param string $name
 * @param array $data
 * @return void
 */

function loadView($name, $data = [])
{
  $viewPath = basePath("App/views/{$name}.view.php");

  if (file_exists($viewPath)) {
    extract($data);
    require $viewPath;
  } else {
    echo "View '{$name} not found!";
  }
}

/**
 * Load partial
 * 
 * @param string $name
 * @param array $data
 * @return void
 */

function loadPartial($name, $data = [])
{
  $partialPath = basePath("App/views/partials/{$name}.php");
  if (file_exists($partialPath)) {
    extract($data);
    require $partialPath;
  } else {
    echo "Partial '{$name} not found'";
  }
}

/**
 * Inspect a valuse(s)
 * 
 * @param mixed $value
 * @return void
 */

function inspect($value)
{
  echo "<pre>";
  var_dump($value);
  echo "</pre>";
}

/**
 * Inspect a valuse(s) and die
 * 
 * @param mixed $value
 * @return void
 */

function inspectAndDie($value)
{
  echo "<pre>";
  die(var_dump($value));


}

/**
 * Format Price
 * 
 * @param string $price
 * @return string Formatted Salary
 */

function formatPrice($price)
{
  return '$' . number_format(floatval($price), 2, '.', '') . '';
}

/**
 * Sanitize Data
 * 
 * @param string $dirty
 * @return string
 */

function sanitize($dirty)
{
  return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Redirect to given URL
 * @param string $url
 * @return void
 */

function redirect($url)
{
  header("Location: {$url}");
}