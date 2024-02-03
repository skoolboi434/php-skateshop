<?php

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
 * @return string
 */

function loadView($name)
{
  require basePath("App/views/{$name}.view.php");
}

/**
 * Load partial
 * 
 * @param string $name
 * @return string
 */

function loadPartial($name)
{
  require basePath("App/views/partials/{$name}.php");
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
  echo "</pre>";

}