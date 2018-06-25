<?php
namespace Diff\Viewcli;

function dataOut($data, $action, $tree, $parent)
{
    $result = '';
    $path = '';
    foreach ($parent as $value) {
        $path .= $value;
    }
    if ($action != 'arrayOut') {
        if ($data['status'] == "added") {
            $added = '';
            if ($data['afterVal']) {
                $added = "'" . $data['afterVal'] . "'";
            } else {
                $added = "'complex value'";
            }
            $result .=  "\n Property '" . $path . $data['key'] . "' was added with value " . $added;
        }

        if ($data['status'] == "deleted") {
            $result .=  "\n Property '". $path  . $data['key']  . "' was removed";
        }

        if ($data['status'] == "changed") {
            $result .= "\n Property '". $path  .  $data['key'] . "' was changed.";
            $result .= " From '" . $data['beforeVal'] . "' to '" . $data['afterVal'] . "'";
        }
    }
    return $result;
}
