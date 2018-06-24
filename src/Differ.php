<?php
namespace Differ;

use Funct;

function newNodeAst($key, $status, $beforeVal, $afterVal, $tree, $children)
{
    return [
        'key' => $key,
        'status' => $status,
        'beforeVal' => $beforeVal,
        'afterVal' => $afterVal,
        'tree' => $tree,
        'children' => $children
    ];
}

function setGetDepth($before, $after)
{
    static $beforeDepth;
    static $afterDepth;

    if ($before != 0) {
        $beforeDepth = $before;
        $afterDepth = $after;
    }

    return [$beforeDepth, $afterDepth];
}

function diffAst($beforeData, $afterData)
{
    $ast = [];
    $depthOfData = setGetDepth($beforeData, $afterData);
    $before = $depthOfData[0];
    $after = $depthOfData[1];
    $union = Funct\Collection\union(array_keys($before), array_keys($after));

    $func = function ($value) use (&$func, $before, $after, $ast) {

        $depthOfData = setGetDepth(0, 0);
        $before = $depthOfData[0];
        $after = $depthOfData[1];

        if (!Funct\arrayKeyNotExists($value, $before) && !Funct\arrayKeyNotExists($value, $after)) {
            if (is_array($before[$value])) {
                $ast[$value] = newNodeAst($value, 'same', null, null, 'parent', null);

                setGetDepth($before[$value], $after[$value]);
  
                $union = Funct\Collection\union(array_keys($before[$value]), array_keys($after[$value]));
                $ast[$value]['children'] = array_map($func, $union);
            } else {
                if ($before[$value] == $after[$value]) {
                    $changes = "same";
                } else {
                    $changes = "changed";
                }
                $ast[$value] = newNodeAst($value, $changes, $before[$value], $after[$value], 'child', null);
            }
        }

        if (Funct\arrayKeyNotExists($value, $before)) {
            if (is_array($after[$value])) {
                $ast[$value] = newNodeAst($value, 'added', null, null, 'parent', null);
                $ast[$value]['children'] = $after[$value];
            } else {
                $ast[$value] = newNodeAst($value, 'added', null, $after[$value], 'child', null);
            }
        }

        if (Funct\arrayKeyNotExists($value, $after)) {
            if (is_array($before[$value])) {
                $ast[$value] = newNodeAst($value, 'deleted', null, null, 'parent', null);
                $ast[$value]['children'] = $before[$value];
            } else {
                $ast[$value] = newNodeAst($value, 'deleted', $before[$value], null, 'child', null);
            }
        }

        setGetDepth($before, $after);

        return $ast;
    };

    $diff = array_map($func, $union);
    return $diff;
    //return Funct\Collection\flattenAll($diffAfterBefore);
}

// function diff($files)
// {

//     $before = $files[0];
//     $after = $files[1];

//     $union = Funct\Collection\union(array_keys($before), array_keys($after));

//     $func = function ($value) use ($after, $before) {
//         $result = [];
//         $ast = [];

//         if (!Funct\arrayKeyNotExists($value, $before) && !Funct\arrayKeyNotExists($value, $after)) {
//             if ($after[$value] == $before[$value]) {
//                 $result[] = "  " . $value . ": " . $after[$value];
//                 $ast[] = newAst($value, 'same', $after[$value], $before[$value], false);
//             } else {
//                 $result[] = "+ " . $value . ": " . $after[$value];
//                 $result[] = "- " . $value . ": " . $before[$value];
//             }
//         }

//         if (Funct\arrayKeyNotExists($value, $before)) {
//             $result[] = "+ " . $value . ": " . $after[$value];
//         }

//         if (Funct\arrayKeyNotExists($value, $after)) {
//             $result[] = "- " . $value . ": " . $before[$value];
//         }

//         return $result;
//     };

//     $diffAfterBefore = array_map($func, $union);

//     return Funct\Collection\flattenAll($diffAfterBefore);
// }
