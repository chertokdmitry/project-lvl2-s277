<?php
namespace Diff\Tests;

use \Diff\Gendiff;
use PHPUnit\Framework\TestCase;

class Tests extends TestCase
{
    public function testPretty()
    {
            $file1 = __DIR__ . "/fixtures/beforeast.json";
            $file2 = __DIR__ . "/fixtures/afterast.json";
            $type = "pretty";

            $result= "fixtures/result.txt";

            $diff = \Diff\Gendiff\genDiff($file1, $file2, $type);
            $this->assertEquals($diff, $result);
    }
}
