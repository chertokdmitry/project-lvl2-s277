<?php
namespace Differast;

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

function setGetDepth($before, $after, $action)
{
    static $beforeDepth;
    static $afterDepth;

    if ($action == 'set') {
        $beforeDepth = $before;
        $afterDepth = $after;
    }
    return [$beforeDepth, $afterDepth];
}

function diffAst($beforeData, $afterData)
{
    $ast = [];
    $depthOfData = setGetDepth($beforeData, $afterData, 'set');
    $before = $depthOfData[0];
    $after = $depthOfData[1];
    $union = Funct\Collection\union(array_keys($before), array_keys($after));

    $func = function ($value) use (&$func, $before, $after, $ast) {

        $depthOfData = setGetDepth(0, 0, 'get');
        $before = $depthOfData[0];
        $after = $depthOfData[1];

        if (!Funct\arrayKeyNotExists($value, $before) && !Funct\arrayKeyNotExists($value, $after)) {
            if (is_array($before[$value])) {
                $ast[$value] = newNodeAst($value, 'same', null, null, 'parent', null);

                setGetDepth($before[$value], $after[$value], 'set');
  
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

        setGetDepth($before, $after, 'set');
        return $ast;
    };

    $diff = array_map($func, $union);
    return $diff;
}
