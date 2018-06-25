<?php
namespace Diff\Viewpretty;

function dataOut($data, $action, $tree, $parent)
{
    static $counter;
    $counter++;
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
    if ($tree == 'parent' && $counter != 1) {
        $result .=  $space . $space . "}\n";
    }
    
    if ($action == 'stringOut') {
        if ($tree == 'parent') {
        }
        if ($data['status'] == "added") {
            $result .=  $space . "+ " . $data['key'] . ": " . $data['afterVal'];
        }
        if ($data['status'] == "deleted") {
            $result .=  $space . "- " . $data['key']  . ": " . $data['beforeVal'];
        }
        if ($data['status'] == "changed") {
            $result .= $space  . "- " . $data['key'] . ": " . $data['beforeVal']. "\n";
            $result .= $space  . $space  . "+ " . $data['key'] . ": " . $data['afterVal'];
        }
        if ($data['status'] == "same") {
            $result .=  $space . '  ' . $data['key'] . ": " . $data['beforeVal'];
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
            $result .= "{\n";
        }
        foreach ($data['children'] as $k => $v) {
            $result .=  $space . $k . ": " . $v . "\n";
        }
        if ($tree != 'default') {
            $result .=  $space . "}";
        }
        if ($tree != 'default') {
            $result .= "\n";
        }
    }
    return $result;
}
