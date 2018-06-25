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

    // if ($format == "json") {

    //     $resultForJson = $result . "    }\n}\n";
    //     $json = json_encode($resultForJson, JSON_FORCE_OBJECT);
    // }
    $data = Differast\diffAst($before, $after);
    $result = Mainview\viewDiff($data, $format);

    return $result;
}
