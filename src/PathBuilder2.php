<?php

namespace JDI\Helper;

use phpDocumentor\Reflection\Types\Boolean;

class PathBuilder2
{
  /**
   * Concatenate a path with a custom separator
   *
   * @param string   $separator
   * @param string[] $pathComponents
   *
   * @return string
   */

   // possibly a very slightly faster variant
  public static function custom($separator, array $pathComponents): string
  {

    // if the array as one value, then just return the first element
    if (sizeof($pathComponents) == 1) {
      return $pathComponents[0];
    }

    // use array copying instead
    $i = 0;
    $buffer = [];
    foreach ($pathComponents as $k => $v) {
      if (is_string($v) && \strlen($v) != '') {
        $buffer[$i++] = $v;
        continue;
      }
      // also allow integers
      if (is_integer($v)) {
        $buffer[$i++] = $v;
      }
    }

    // cache array size
    $arraySize = sizeof($buffer);

    // walk the array and normalize each segment
    array_walk($buffer, function(&$v, $k) use ($separator, $arraySize) {
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
    return join($separator, $buffer);
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
