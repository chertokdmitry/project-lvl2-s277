<?php
namespace Cli;

use \Differ\diff;
use \Parser\parser;

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

    $files =  \Parser\parser($result["<firstFile>"], $result["<secondFile>"], $format);
    $result = \Differ\diff($files);

    foreach ($result as $key => $value) {
        echo $value;
        echo "\n";
    }
}
