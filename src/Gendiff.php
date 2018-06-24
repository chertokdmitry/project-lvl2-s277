<?php
namespace Diff\Gendiff;

use Diff\Parser;

use Diff\Differast;
use Diff\Differ;

use Diff\Viewjson;
use Diff\Viewplain;
use Diff\Viewcli;
use Diff\Viewfile;

function genDiff($file1, $file2, $format)
{
    $dataBefore = file_get_contents($file1);
    $dataAfter = file_get_contents($file2);

    $before =  Parser\getData($dataBefore, $format);
    $after =  Parser\getData($dataAfter, $format);

    if ($format == "json") {
        $data = Differast\diffAst($before, $after);
        $result = Viewjson\viewDiff($data);
        $resultForJson = "{" . $result . "}";
        $json = json_encode($resultForJson, JSON_FORCE_OBJECT);
        print_r($json);
    }
    if ($format == "plain") {
        $data = Differast\diffAst($before, $after);
        $result = Viewcli\viewDiff($data);
    }
    if ($format == "fileast") {
        $data = Differast\diffAst($before, $after);
        $file = fopen('result.txt', 'a');
        $result = Viewfile\viewDiff($data, $file);
    }
    if ($format == "jsonplain") {
        $data = Differ\diff($before, $after);
        $result = Viewplain\viewDiff($data);
    }
    return $result;
}
