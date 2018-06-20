<?php
namespace Differ;

use Funct;

function diff($files)
{

    $before = $files[0];
    $after = $files[1];

    $union = Funct\Collection\union(array_keys($before), array_keys($after));

    $func = function ($value) use ($after, $before) {
        $result = [];

        if (!Funct\arrayKeyNotExists($value, $before) && !Funct\arrayKeyNotExists($value, $after)) {
            if ($after[$value] == $before[$value]) {
                $result[] = "  " . $value . ": " . $after[$value];
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
