<?php
namespace Gendiff;

require(__DIR__ . '/../vendor/docopt/docopt/src/docopt.php');
include(__DIR__ . '/Differ.php');

function docs()
{
    $doc = <<<'DOCOPT'
Generate diff

Usage:
  gendiff (-h|--help)
  gendiff [--format <fmt>] <firstFile> <secondFile>

Options:
  -h --help                     Show this screen
  --format <fmt>                Report format [default: pretty]
DOCOPT;
    $result = \Docopt::handle($doc, array('version'=>'1.0.0'));

    if ($result["<firstFile>"] && $result["<secondFile>"]) {
            \Differ\genDiff($result["<firstFile>"], $result["<secondFile>"]);
    } else {
        foreach ($result as $k => $v) {
            echo $k.': '.json_encode($v).PHP_EOL;
        }
    }
}
