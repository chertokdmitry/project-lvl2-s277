<?php
use Gendiff;

$diff = \Gendiff\genDiff("before.json", "after.json", "json");

print_r($diff);
