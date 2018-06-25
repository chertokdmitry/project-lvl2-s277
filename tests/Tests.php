<?php
namespace Diff\Tests;

$autoloadPath1 = __DIR__ . '/../../../autoload.php';
$autoloadPath2 = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}

use \Diff\Gendiff;
use PHPUnit\Framework\TestCase;

class Tests extends TestCase
{
    public function testPretty()
    {
            $file1 = "fixtures/before.json";
            $file2 = "fixtures/after.json";
            $type = "pretty";

            $result= "fixtures/result.txt";

            $diff = \Diff\Gendiff\genDiff($file1, $file2, $type);
            $this->assertEquals($diff, $result);
    }
}
