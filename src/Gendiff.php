<?php
namespace Gendiff;

function genDiff($file1, $file2, $format)
{
    $dataBefore = file_get_contents($file1);
    $dataAfter = file_get_contents($file2);

    $before =  \Parser\parser($dataBefore, $format);
    $after =  \Parser\parser($dataAfter, $format);

    return \Differ\diff([$before, $after]);
}
