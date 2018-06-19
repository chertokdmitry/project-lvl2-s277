<?php
namespace Gendiff\Testdiff;

use PHPUnit\Framework\TestCase;

class TestSolution extends TestCase
{
    public function testJson($data1, $data2)
    {
            $this->assertEquals($data1, $data2);
    }
}

$test = new TestSolution();
$result = $test->testJson();
