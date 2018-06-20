<?php
namespace Gendiff;

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

    $result = \Docopt::handle($doc);
    $format = $result["--format"] ? $result["--format"] : "pretty";

    \Differ\genDiff($result["<firstFile>"], $result["<secondFile>"], $format);
}
