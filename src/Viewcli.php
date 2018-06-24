<?php
namespace Diff\Viewcli;

function switchStatus($data, $parent)
{
    $result = '';
    $path = '';
    foreach ($parent as $value) {
        $path .= $value;
    }

    if ($data['status'] == "added") {
        $added = '';
        if ($data['afterVal']) {
            $added = "'" . $data['afterVal'] . "'";
        }
        $result .=  "\n Property '" . $path . $data['key'] . "' was added with value " . $added;
    }

    if ($data['status'] == "deleted") {
        $result .=  "\n Property '". $path  . $data['key']  . "' was removed";
    }

    if ($data['status'] == "changed") {
        $result .= "\n Property '". $path  .  $data['key'] . "' was changed. From '" . $data['beforeVal'] . "' to '" . $data['afterVal'] . "'";
    }

    return $result;
}

function viewDiff($data)
{
    $func = function ($carry, $item) {
        $path = [];
        if (is_array($item)) {
            $ak = array_keys($item);
            if (!in_array('tree', $ak)) {
                $path[] = $item[$ak[0]]['key'] . ".";
                if ($item[$ak[0]]['tree'] == 'parent') {
                    $carry .= switchStatus($item[$ak[0]], []);
                    $akk = array_keys($item[$ak[0]]['children']);
                    if (in_array('tree', $akk)) {
                        $carry .= getChildren($item[$ak[0]]['children'], $path);
                    } else {
                        if ($item[$ak[0]]['status'] != 'deleted') {
                            $carry .= "'complex value'";
                        }
                    }
                }
            }
        }
        return $carry;
    };
    $result = array_reduce($data, $func);
    print_r($result);
}

function getChildren($data, $parent)
{
    $func = function ($carry, $item) use ($parent) {

        if (is_array($item)) {
            $ak = array_keys($item);
            if (($item[$ak[0]]['tree'] == 'parent')) {
                if (!in_array('children', $ak)) {
                    $ch = array_keys($item[$ak[0]]['children']);
                    if (!in_array('children', $ch)) {
                        $carry .= switchStatus($item[$ak[0]], $parent);
                        if ($item[$ak[0]]['status'] != 'deleted') {
                            $carry .= "'complex value'";
                        }
                    } else {
                            $carry .= viewDiff($item);
                    }
                }
            } else {
                $carry .= switchStatus($item[$ak[0]], $parent);
            }
        }
        return $carry;
    };
    return array_reduce($data, $func);
}
