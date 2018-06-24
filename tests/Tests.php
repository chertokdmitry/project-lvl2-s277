<?php

namespace Diff\Tests;

require '../src/Gendiffplain.php';
require '../src/Parser.php';
require '../src/Differ.php';

use \Diff\Gendiffplain;
use \Diff\Parser;
use PHPUnit\Framework\TestCase;

class TestsDiff extends TestCase
{
    public function testJson()
    {
            $file1 = "fixtures/before.json";
            $file2 = "fixtures/after.json";
            $type = "json";

            $result = 'a:5:{i:0;s:17:"  host: hexlet.io";i:1;s:13:"+ timeout: 20";i:2;s:13:"- timeout: 50";i:3;s:22:"- proxy: 123.234.53.22";i:4;s:12:"+ verbose: 1";}';

            $diff = \Diff\Gendiffplain\genDiffPlain($file1, $file2, $type);
            $this->assertEquals($diff, $result);
    }
}
