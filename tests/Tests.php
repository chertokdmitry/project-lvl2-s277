<?php
namespace Tests;

include(__DIR__ . '/../src/Lib.php');

use PHPUnit\Framework\TestCase;

class TestsDiff extends TestCase
{
    public function testGenDiff()
    {
            $resultTrue = ['  host: hexlet.io', '+ timeout: 20', '- timeout: 50', '- proxy: 123.234.53.22', '+ verbose: 1'];
            $resultFalse = ['  host: hexlet.io'];

            $diff = \Gendiff\genDiff("before.json", "after.json", "json");

            $this->assertEquals($diff, $resultTrue);
            $this->assertNotEquals($diff, $resultFalse);
    }
}

$test = new TestsDiff;
$result = $test->testGenDiff();
