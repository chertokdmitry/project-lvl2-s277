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
";

        $diff = \Diff\Gendiff\genDiff($file1, $file2, $type);
        $this->assertEquals($diff, $result);
    }

    public function testPlain()
    {
        $file1 = __DIR__ . "/fixtures/beforeast.json";
        $file2 = __DIR__ . "/fixtures/afterast.json";
        $type = "plain";
        $result = "
 Property 'common.setting2' was removed
 Property 'common.setting6' was removed
 Property 'common.setting4' was added with value 'blah blah'
 Property 'common.setting5' was added with value 'complex value'
 Property 'group1.baz' was changed. From 'bas' to 'bars'
 Property 'group2' was removed
 Property 'group3' was added with value 'complex value'";

        $diff = \Diff\Gendiff\genDiff($file1, $file2, $type);
        $this->assertEquals($diff, $result);
    }

    public function testJson()
    {
        $file1 = __DIR__ . "/fixtures/beforeast.json";
        $file2 = __DIR__ . "/fixtures/afterast.json";
        $type = "json";
        $result = '{
  "common": {"status": "same", "value":  {
    "setting1": {"status": "same", "value": "Value 1"},
    "setting2": {"status": "deleted", "value": "200"},
    "setting3": {"status": "same", "value": "1"},
    "setting6": {"status": "deleted", "value": {
      "key": "value"
      },
    "setting4": {"status": "added", "value": "blah blah"},
    "setting5": {"status": "added", "value": {
      "key5": "value5"
      },
    }
  "group1": {"status": "same", "value":  {
    "baz": {"status": "changed", "oldvalue": "bas", "value": "bars"},
    "foo": {"status": "same", "value": "bar"},
    }
  "group2": {"status": "deleted", "value":  {
        "abc": "12345"
    }
  "group3": {"status": "added", "value":  {
        "fee": "100500
        "';

        $diff = \Diff\Gendiff\genDiff($file1, $file2, $type);
        $this->assertEquals($diff, $result);
    }
}
