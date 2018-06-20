<?php
namespace Gendiff;

        include(__DIR__ . '/Parser.php');
        include(__DIR__ . '/Differ.php');
        include(__DIR__ . '/General.php');
        include(__DIR__ . '/Collection.php');

function genDiff($pathToFile1, $pathToFile2, $format)
{
    $files =  \Parser\parser($pathToFile1, $pathToFile2, $format);
    return \Differ\diff($files);
}
