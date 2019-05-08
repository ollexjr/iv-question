<?php
namespace JDI\Tests;

use JDI\Helper\PathBuilder;
use PHPUnit\Framework\TestCase;

class PathBuilderTest extends TestCase
{
  public function testUrl()
  {
    $this->assertEquals('', PathBuilder::url(''));
    $this->assertEquals('abc', PathBuilder::url('abc'));
    $this->assertEquals('/', PathBuilder::url('/', ''));
    $this->assertEquals('/test', PathBuilder::url('/', '/test'));
    $this->assertEquals('/c/4/ab', PathBuilder::url('/', 'c', 4, 'ab'));
    $this->assertEquals('/test', PathBuilder::url('/', '', '/test', ''));
    $this->assertEquals('//cdn.domain.tld/test', PathBuilder::url('//cdn.domain.tld', '', '/test', ''));
    $this->assertEquals('/test/subdir/test/', PathBuilder::url('/test/', '/subdir/test/'));
    $this->assertEquals('/test/subdir/test/', PathBuilder::url('/test', '/subdir/test', '/'));
    $this->assertEquals('test/subdir/test/', PathBuilder::url('test', '/subdir/test/'));
    $this->assertEquals('test/subdir//test/', PathBuilder::url('test', '/subdir//test/'));
  }

  public function testBuildPathBuilder()
  {
    $this->assertEquals("a" . DIRECTORY_SEPARATOR . "b", PathBuilder::system("a", "b"));
    $this->assertEquals("a" . DIRECTORY_SEPARATOR . "b", PathBuilder::system("a", "b"));
  }

  public function testBuildWindowsPathBuilder()
  {
    $this->assertEquals("a\\b", PathBuilder::windows("a", "b"));
  }

  public function testBuildUnixPathBuilder()
  {
    $this->assertEquals("a/b", PathBuilder::unix("a", "b"));
  }

  public function testBuildUrlPathBuilder()
  {
    $this->assertEquals("a/b", PathBuilder::url("a", "b"));
  }

  public function testBuildCustomPathBuilder()
  {
    $this->assertEquals("a|b", PathBuilder::custom("|", ["a", "b"]));
    $this->assertEquals("a|b", PathBuilder::custom("|", [0 => "a", 1 => "b"]));
  }

  public function baseNameProvider()
  {
    return [
      ['/', '/'],
      ['C:\\', 'C:'],
      ['/test/dir/123/file1', 'file1'],
      ['test/dir/123/file2', 'file2'],
      ['/file3', 'file3'],
      ['//test//dir1//file4', 'file4'],
      ['/test/dir2/dir5/', 'dir5'],
      ['C:\\Program Files\\Test Dir\\file6', 'file6'],
      ['C:\\test\\dir2/file7', 'file7'],
    ];
  }
}
