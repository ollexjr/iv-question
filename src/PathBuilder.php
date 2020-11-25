<?php

namespace JDI\Helper;

use phpDocumentor\Reflection\Types\Boolean;

class PathBuilder
{
  /**
   * Concatenate a path with a custom separator
   *
   * @param string   $separator
   * @param string[] $pathComponents
   *
   * @return string
   */

   // perf:
   // looped.php Processed in 8058.6869716644 ms
  public static function custom($separator, array $pathComponents): string
  {

    // if the array as one value, then just return the first element
    if (sizeof($pathComponents) == 1) {
      return $pathComponents[0];
    }

    // scan array and discard anything but strings and numeric values
    $pathComponents =  array_values(array_filter($pathComponents, function($e){
      // if a string, and not an empty string, then it's valid.
      if (is_string($e) && $e != '') {
        return true;
      }
      // also allow integers
      return is_integer($e);
    }));

    // cache array size
    $arraySize = sizeof($pathComponents);

    // walk the array and normalize each segment
    array_walk($pathComponents, function(&$v, $k) use ($separator, $arraySize) {
      // cache isString
      $valueIsString = is_string($v);

      // php likes to think some integers match single quoted strings ('') 
      // so we also assert that it's a string
      if ($valueIsString && $v == '/' && $k > 1) {
        // if it's a seperator, and it's not the first in the queue, then we remove it
        $v = null;
        return;
      }

      // if a string, and not the first index, then we can trim unwanted characters
      if ($valueIsString && $k > 0) {
          $v = ltrim($v, $separator);
      }

      // if a string, and not the last index, then we can trim unwanted characters
      if ($valueIsString && $k < ($arraySize -1)) {
        $v = rtrim($v, $separator);
      }
    });

    // join array with seperator
    return join($separator, $pathComponents);
  }

  /**
   * Concatenate any number of path sections and correctly
   * handle directory separators
   *
   * @param array $parts
   *
   * @return string
   */
  public static function system(...$parts)
  {
    return static::custom(DIRECTORY_SEPARATOR, $parts);
  }

  /**
   * Concatenate a path with windows style path separators
   *
   * @param array $parts
   *
   * @return string
   */
  public static function windows(...$parts)
  {
    return static::custom('\\', $parts);
  }

  /**
   * Concatenate a path with unix style path separators
   *
   * @param array $parts
   *
   * @return string
   */
  public static function unix(...$parts)
  {
    return static::custom('/', $parts);
  }

  /**
   * Concatenate a path with unix style path separators
   *
   * @param array $parts
   *
   * @return string
   */
  public static function url(...$parts)
  {
    return static::custom('/', $parts);
  }
}
