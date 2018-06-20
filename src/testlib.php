<?php
include(__DIR__ . '/Lib.php');

$diff = \Gendiff\genDiff("before.json", "after.json", "json");

print_r($diff);
