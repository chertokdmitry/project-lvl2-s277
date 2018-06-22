<?php
namespace Cli;

use \Gendiff\genDiff;

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

    $result = \Docopt::handle($doc);
    $format = $result["--format"] ? $result["--format"] : "pretty";

    $result =  \Gendiff\genDiff($result["<firstFile>"], $result["<secondFile>"], $format);

    print_r($result);
}
