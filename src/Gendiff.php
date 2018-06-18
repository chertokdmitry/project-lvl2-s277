<?php
namespace Gendiff;

require(__DIR__ . '/../vendor/docopt/docopt/src/docopt.php');

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

    foreach ($result as $k => $v) {
        echo $k.': '.json_encode($v).PHP_EOL;
    }
}
