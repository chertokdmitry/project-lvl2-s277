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
        $result = "{
    common:  {
      setting1: Value 1
    - setting2: 200
      setting3: 1
    - setting6: {
      key: value
      }
    + setting4: blah blah
    + setting5: {
      key5: value5
      }
    }
    group1:  {
    - baz: bas
    + baz: bars
      foo: bar
    }
  - group2:  {
        abc: 12345
    }
  + group3:  {
        fee: 100500
    }
}";

        $diff = \Diff\Gendiff\genDiff($file1, $file2, $type);
        $this->assertEquals($diff, $result);
    }
}
