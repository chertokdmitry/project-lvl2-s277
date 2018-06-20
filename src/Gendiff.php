<?php
namespace Gendiff;

function genDiff($pathToFile1, $pathToFile2, $format)
{
    $files =  \Parser\parser($pathToFile1, $pathToFile2, $format);
    return \Differ\diff($files);
}
