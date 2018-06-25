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

            $resultFile = __DIR__ . "/fixtures/result.txt";
            $result = file_get_contents($resultFile);

            $diff = \Diff\Gendiff\genDiff($file1, $file2, $type);
            $this->assertEquals($diff, $result);
    }
}
