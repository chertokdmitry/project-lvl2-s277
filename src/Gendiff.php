<?php
namespace Diff\Gendiff;

use Diff\Mainview;

use Diff\Parser;

use Diff\Differast;
use Diff\Differ;

function genDiff($file1, $file2, $format)
{
    $dataBefore = file_get_contents($file1);
    $dataAfter = file_get_contents($file2);

    $before =  Parser\getData($dataBefore, $format);
    $after =  Parser\getData($dataAfter, $format);

    if ($format == "pretty") {
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
    if ($format == "plain") {
        $data = Differast\diffAst($before, $after);
        $result = Viewcli\viewDiff($data);
    }

    if ($format == "jsonplain") {
        $data = Differ\diff($before, $after);
        $result = Viewplain\viewDiff($data);
    }


    return $result;
}
