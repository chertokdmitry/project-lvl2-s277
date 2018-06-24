<?php
namespace Gendiff;

function genDiff($file1, $file2, $format)
{
    $dataBefore = file_get_contents($file1);
    $dataAfter = file_get_contents($file2);

    $before =  \Parser\parser($dataBefore, $format);
    $after =  \Parser\parser($dataAfter, $format);

    $ast = \Differast\diffAst($before, $after);
    $file = fopen('result.txt', 'a');
    $astOut = \View\viewDiff($ast, $file);

    return $astOut;
}
