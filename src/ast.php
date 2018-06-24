<?php

namespace Ast;

function newAst($key, $status, $beforeVal, $afterVal, $hasChild)
{
    return [
        'key' => $key,
        'status' => $status,
        'beforeVal' => $dataBefore,
        'afterVal' => $dataAfter,
        'hasChild ' => $hasChild,
    ];
}

function diff($files)
{

    $before = $files[0];
    $after = $files[1];

    $union = Funct\Collection\union(array_keys($before), array_keys($after));

    $func = function ($value) use ($after, $before) {
        $result = [];
        $ast = [];

        if (!Funct\arrayKeyNotExists($value, $before) && !Funct\arrayKeyNotExists($value, $after)) {
            if ($after[$value] == $before[$value]) {
                $result[] = "  " . $value . ": " . $after[$value];
                $ast[] = newAst($value, 'same', $after[$value], $before[$value], false);
            } else {
                $result[] = "+ " . $value . ": " . $after[$value];
                $result[] = "- " . $value . ": " . $before[$value];
            }
        }

        if (Funct\arrayKeyNotExists($value, $before)) {
            $result[] = "+ " . $value . ": " . $after[$value];
        }

        if (Funct\arrayKeyNotExists($value, $after)) {
            $result[] = "- " . $value . ": " . $before[$value];
        }

        return $result;
    };

    $diffAfterBefore = array_map($func, $union);

    return Funct\Collection\flattenAll($diffAfterBefore);
}


function parser($file, $format)
{
    $result = [];
    
    if ($format == "json" || $format == "pretty") {
        $func = function ($fileData) {
            return json_decode($fileData);
        };
    }

    if ($format == "yaml") {
        $func = function ($fileData) {
            return Yaml::parse($fileData);
        };
    }

    $data = $func($file);

    foreach ($data as $key => $value) {
            $result[$key] = $value;
    }

    return $result;
}

    $dataAfter = file_get_contents("afterast.json");
    $after =  parser($dataAfter, "json");

    $dataBefore = file_get_contents("beforeast.json");
    $before =  parser($dataBefore, "json");

    print_r($before);
    print_r($after);

    diff([$before, $after]);
