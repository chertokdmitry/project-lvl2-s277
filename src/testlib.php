<?php
include(__DIR__ . '/Gendiff.php');

$diff = \Gendiff\genDiff("before.json", "after.json", "json");

print_r($diff);
