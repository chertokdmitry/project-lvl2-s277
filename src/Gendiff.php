<?php
namespace Diff\Gendiff;

use Diff\Mainview;
use Diff\Parser;
use Diff\Differast;


function genDiff($file1, $file2, $format)
{
    $dataBefore = file_get_contents($file1);
    $dataAfter = file_get_contents($file2);

    $path_parts = pathinfo($file1);

    if ($path_parts['extension'] == 'json') {
        $before = Parser\getData($dataBefore, 'json');
        $after = Parser\getData($dataAfter, 'json');
    }

    if ($path_parts['extension'] == 'yaml') {
        $before = Parser\getData($dataBefore, 'yaml');
        $after = Parser\getData($dataAfter, 'yaml');
    }

    if ($format == "pretty") {
        $data = Differast\diffAst($before, $after);
        $result = Mainview\viewDiff($data, $format);
        $resultFix = $result . "    }\n}\n";
        print_r($resultFix);
    }

    if ($format == "plain") {
        $data = Differast\diffAst($before, $after);
        $result = Mainview\viewDiff($data, $format);
        print_r($result);
    }

    if ($format == "json") {
        $data = Differast\diffAst($before, $after);
        $result = Mainview\viewDiff($data, $format);
        $resultForJson = $result . "    }\n}\n";
        //$json = json_encode($resultForJson, JSON_FORCE_OBJECT);
        print_r($resultForJson);
    }
    return $result;
}
