<?php
namespace JDI\Helper;

use function implode;

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
  public static function custom($separator, array $pathComponents)
  {
    // Empty String and Null array items are ignored
    // Leading Separator is allowed
    // Trailing Separator is allowed
    // The separator should not appear multiple times between path components, but inside a component is valid
    return implode($separator, $pathComponents);
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
