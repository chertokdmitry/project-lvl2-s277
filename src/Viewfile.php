<?php
namespace Diff\Viewfile;

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
        $result .= "  " . "- " . $data['key'] . ": " . $data['beforeVal'] . "\n";
        $result .= "  " . "    " . "+ " . $data['key'] . ": " . $data['afterVal'];
    }
    if ($data['status'] == "same") {
        $result .=  "    " . $data['key'] . ": " . $data['beforeVal'];
    }
    return $result;
}
function viewDiff($data, $file)
{
    $func = function ($carry, $item) use ($file) {
        if (is_array($item)) {
            $ak = array_keys($item);
            if (!in_array('tree', $ak)) {
                if ($item[$ak[0]]['tree'] == 'parent') {
                    $carry .= switchStatus($item[$ak[0]]) . "{" . "\n";
                    $akk = array_keys($item[$ak[0]]['children']);
                    if (in_array('tree', $akk)) {
                        $carry .= getChildren($item[$ak[0]]['children'], $file);
                    } else {
                        foreach ($item[$ak[0]]['children'] as $k => $v) {
                            $carry .=  "    " . "    " . $k . ": " . $v . "\n";
                        }
                    }
                    $carry .= "    "  . "}" . "\n";
                }
            }
        }
        return $carry;
    };
    $result = array_reduce($data, $func);

    $resultData = fwrite($file, $result);
    $message = "Data saved to " . $file;

    return $message;
}
function getChildren($data, $file)
{
    $func = function ($carry, $item) {
        if (is_array($item)) {
            $ak = array_keys($item);
            if (($item[$ak[0]]['tree'] == 'parent')) {
                if (!in_array('children', $ak)) {
                    $ch = array_keys($item[$ak[0]]['children']);
                    if (!in_array('children', $ch)) {
                        $carry .= "    " . switchStatus($item[$ak[0]]) . " {" . "\n";
                        foreach ($item[$ak[0]]['children'] as $k => $v) {
                            $carry .=  "    " . "    " . "    " . $k . ": " . $v . "\n";
                        }
                        $carry .= "    "  . "    "  .  "}" . "\n";
                    } else {
                            $carry .= viewDiff($item, $file);
                    }
                }
            } else {
                $carry .= "    " . switchStatus($item[$ak[0]]) . "\n";
            }
        }
        return $carry;
    };
    return array_reduce($data, $func);
}
