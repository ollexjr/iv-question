<?php

use JDI\Helper\PathBuilder;

require 'vendor/autoload.php';

$startTime = microtime(true);

for($i = 0; $i < 10000; $i++)
{
  PathBuilder::system('Users', 'Tester', 'Library', 'Applications', 1, 2, 'Image.jpg');
  PathBuilder::custom('/', ['a', 'b', 'c', 'd', 'efg', 'hi']);
  PathBuilder::custom('/', ['/', 'abc', '', '', 'defg', 'hi', '/']);
  PathBuilder::custom('/', ['|', 'abc', '', '', 'defg', 'hi', 'ending/']);
}

echo "Processed in " . ((microtime(true) - $startTime) * 1000) . " ms\n";
