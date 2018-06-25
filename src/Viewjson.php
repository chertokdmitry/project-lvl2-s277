<?php
namespace Diff\Viewjson;

function dataOut($data, $action, $tree, $parent)
{
    static $counter;
    $counter++;
    $value = "";
    $result = '';
    $space = "  ";

    if ($tree == 'default') {
        $result .= $space;
    }
    if ($action == 'stringOut' && $tree== 'children') {
        $space = "    ";
    }
    if ($counter == 1) {
        $result .= "{\n";
    }
    if ($tree == 'parent' && $counter != 1 && $action != 'arrayOut') {
        $result .=  $space . $space . "}\n";
    }
    
    if ($action == 'stringOut') {
        if ($tree == 'parent') {
        }

        if ($data['status'] == "added") {
            if ($data['afterVal']) {
                $value = '"' . $data['afterVal'] . '",';
            }
            $result .=  $space . '"' . $data['key'] . '": {"status": "added", "value": ' . $value;
        }

        if ($data['status'] == "deleted") {
            if ($data['beforeVal']) {
                $value = '"' . $data['beforeVal'] . '"},';
            }
            $result .=  $space . '"' . $data['key'] . '": {"status": "deleted", "value": ' . $value;
        }

        if ($data['status'] == "changed") {
            if ($data['afterVal']) {
                $value = '"' . $data['afterVal'] . '"},';
            }

            $result .=  $space . '"' . $data['key'] . '": {"status": "changed", "oldvalue": "';
            $result .= $data['beforeVal'] . '", "value": ' . $value;

            // $result .= $space  . "- " . $data['key'] . ": " . $data['beforeVal']. "\n";
            // $result .= $space  . $space  . "+ " . $data['key'] . ": " . $data['afterVal'];
        }

        if ($data['status'] == "same") {
            if ($data['afterVal']) {
                $value = '"' . $data['afterVal'] . '"},';
            }
            $result .=  $space . '"' . $data['key'] . '": {"status": "same", "value": ' . $value;
        }
        if ($tree == 'parent') {
              $result .= " {";
        }
        if ($tree != 'children') {
            $result .= "\n";
        }
    }

    if ($action == 'arrayOut') {
        $space = "      ";

        if ($tree != 'default') {
            $result .= '{' . "\n";
        }
        foreach ($data['children'] as $k => $v) {
            $result .=  $space . '"' . $k . '": "' . $v . '"' . "\n";
        }
        if ($tree == 'children') {
            $result .=  $space . '},';
        }
        if ($tree != 'default') {
            $result .= "\n";
        }
    }
    return $result;
}
