<?php
namespace Cli;

use \Differ\diff;
use \Parcer\parcer;

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

    $files =  \Parcer\parcer($result["<firstFile>"], $result["<secondFile>"], $format);
    $result = \Differ\diff($files);

    foreach ($result as $key => $value) {
        echo $value;
        echo "\n";
    }
}
