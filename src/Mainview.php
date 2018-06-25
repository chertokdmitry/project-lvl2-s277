<?php
namespace Diff\Mainview;

use Diff\Viewjson;
use Diff\Viewplain;
use Diff\Viewcli;
use Diff\Viewpretty;

function viewDiff($data, $format)
{
    if ($format == "pretty") {
        $dataOut = "Diff\Viewpretty\dataOut";
    }
    if ($format == "json") {
        $dataOut = "Diff\Viewjson\dataOut";
    }
    if ($format == "plain") {
        $dataOut = "Diff\Viewcli\dataOut";
    }

    $path = [];
    $func = function ($carry, $item) use ($dataOut) {
        if (is_array($item)) {
            $ak = array_keys($item);
            if (!in_array('tree', $ak)) {
                $path[] = $item[$ak[0]]['key'] . ".";
                if ($item[$ak[0]]['tree'] == 'parent') {
                    $carry .= $dataOut($item[$ak[0]], 'stringOut', 'parent', []);
                    $akk = array_keys($item[$ak[0]]['children']);
                    if (in_array('tree', $akk)) {
                        $carry .= getChildren($item[$ak[0]]['children'], $dataOut, $path);
                    } else {
                        $carry .= $dataOut($item[$ak[0]], 'arrayOut', 'default', $path);
                    }
                }
            }
        }
        return $carry;
    };

    $res = array_reduce($data, $func);

    return $res;
}

function getChildren($data, $dataOut, $parent)
{
    $func = function ($carry, $item) use ($dataOut, $parent) {

        if (is_array($item)) {
            $ak = array_keys($item);
            if (($item[$ak[0]]['tree'] == 'parent')) {
                if (!in_array('children', $ak)) {
                    $ch = array_keys($item[$ak[0]]['children']);
                    if (!in_array('children', $ch)) {
                        $carry .= $dataOut($item[$ak[0]], 'stringOut', 'children', $parent);
                        $carry .= $dataOut($item[$ak[0]], 'arrayOut', 'children', $parent);
                    } else {
                            $carry .= viewDiff($item);
                    }
                }
            } else {
                $carry .= $dataOut($item[$ak[0]], 'stringOut', 'default', $parent);
            }
        }
        return $carry;
    };
    return array_reduce($data, $func);
}
