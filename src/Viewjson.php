<?php
namespace Diff\Viewjson;

function switchStatus($data)
{
    $result = '';
    if ($data['status'] == "added") {
        $result .=  "  ". "+ " . $data['key'] . ": " . $data['afterVal'];
    }

    if ($data['status'] == "deleted") {
        $result .=  "  ". "- " . $data['key']  . ": " . $data['beforeVal'];
    }

    if ($data['status'] == "changed") {
        $result .= "  " . "- " . $data['key'] . ": " . $data['beforeVal'];
        $result .= "  " . "    " . "+ " . $data['key'] . ": " . $data['afterVal'];
    }

    if ($data['status'] == "same") {
        $result .=  "    " . $data['key'] . ": " . $data['beforeVal'];
    }
    return $result;
}

function viewDiff($data)
{
    $func = function ($carry, $item) {
        if (is_array($item)) {
            $ak = array_keys($item);
            if (!in_array('tree', $ak)) {
                if ($item[$ak[0]]['tree'] == 'parent') {
                    $carry .= switchStatus($item[$ak[0]]) . "{";
                    $akk = array_keys($item[$ak[0]]['children']);
                    if (in_array('tree', $akk)) {
                        $carry .= getChildren($item[$ak[0]]['children']);
                    } else {
                        foreach ($item[$ak[0]]['children'] as $k => $v) {
                            $carry .=  "    " . "    " . $k . ": " . $v ;
                        }
                    }
                    $carry .= "    "  . "}";
                }
            }
        }
        return $carry;
    };

    $res = array_reduce($data, $func);
    return $res;
}

function getChildren($data)
{
    $func = function ($carry, $item) {

        if (is_array($item)) {
            $ak = array_keys($item);
            if (($item[$ak[0]]['tree'] == 'parent')) {
                if (!in_array('children', $ak)) {
                    $ch = array_keys($item[$ak[0]]['children']);
                    if (!in_array('children', $ch)) {
                        $carry .= "    " . switchStatus($item[$ak[0]]) . " {";
                        foreach ($item[$ak[0]]['children'] as $k => $v) {
                            $carry .=  "    " . "    " . "    " . $k . ": " . $v;
                        }
                        $carry .= "    "  . "    "  .  "}";
                    } else {
                            $carry .= viewDiff($item);
                    }
                }
            } else {
                $carry .= "    " . switchStatus($item[$ak[0]]);
            }
        }
        return $carry;
    };
    return array_reduce($data, $func);
}
