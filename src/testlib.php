<?php
include(__DIR__ . '/Differ.php');

$diff = \Differ\genDiff("before.json", "after.json");

print_r($diff);

