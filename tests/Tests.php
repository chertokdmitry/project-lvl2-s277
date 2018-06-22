<?php
namespace Test;

use Gendiff;
use PHPUnit\Framework\TestCase;

class TestsDiff extends TestCase
{
    public function testJson()
    {
            $file1 = "fixtures/before.json";
            $file2 = "fixtures/after.json";
            $type = "json";

            $result = file_get_contents("fixtures/resultTrueJson.txt");
            $resultInArray = unserialize($result);

            $diff = Gendiff\genDiff($file1, $file2, $type);
            $this->assertEquals($diff, $resultInArray);
    }
}
