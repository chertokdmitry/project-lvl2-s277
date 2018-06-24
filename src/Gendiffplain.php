<?php
namespace Diff\Gendiffplain;

use Diff\Parser;
use Diff\Differ;
use Diff\View;

function genDiffPlain($file1, $file2, $format)
{
    $dataBefore = file_get_contents($file1);
    $dataAfter = file_get_contents($file2);

    $before =  Parser\getData($dataBefore, $format);
    $after =  Parser\getData($dataAfter, $format);

    $diff = Differ\diff($before, $after);

    return $diff;
}
