<?php
namespace Diff\Cli;

use Diff\Gendiff;

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
    $result =  Gendiff\genDiff($result["<firstFile>"], $result["<secondFile>"], $result["--format"]);

    print_r($result);
}
