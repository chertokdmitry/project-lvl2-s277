<?php
namespace Diff\Differ;

use Funct;

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
    $result = Funct\Collection\flattenAll($diffAfterBefore);
    $resultString = implode("", $result);
    return $resultString;
}
