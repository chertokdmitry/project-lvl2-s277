function viewChildren($inside, $file, $str)
{
    $func = function ($carry, $item) use ($file, $str) {
        
        $str .= $str;
        $space = setGetSpace(4, 'plus');
        if ($item['tree'] == 'parent') {
            $depth = setGetDepth('plus');
            $space = setGetSpace(2, 'minus');

            if ($depth > 1) { 
                $str .= '  ';
            }

            $str .= $space . $item['status'];
            $str .= $item['key'] . ": ";
            $space = setGetSpace(2, 'plus');
        } else {

            if ($item['status'] == '  ') {
                $str .= $space . $item['status'];
                $str .= $item['key'] . ": ";
                $str .= $item['beforeVal'] . "\n";
            }
            if ($item['status'] == '+ ') {
                $str .= $space . $item['status'];
                $str .= $item['key'] . ": ";
                $str .= $item['afterVal'] . "\n";
            }
            if ($item['status'] == '- ') {
                $str .= $space . $item['status'];
                $str .= $item['key'] . ": ";
                $str .= $item['beforeVal'] . "\n";
            }
            if ($item['status'] == '-+') {
                $str .= $space . "- ";
                $str .= $item['key'] . ": ";
                $str .= $item['beforeVal'] . "\n";
                $str .= $space . "+ ";
                $str .= $item['key'] . ": ";
                $str .= $item['afterVal'] . "\n";
            }
        }
        $space = setGetSpace(4, 'minus');
        if ($item['tree'] == 'parent') {

             $str .= $space . '{'. "\n";
        }

        if(($item['status'] != '  ') && (is_array($item['children']))) {
            $space = setGetSpace(8, 'plus');
            foreach ($item['children'] as $k => $v) {
                $str .= $space . $k . ": " . $v . "\n";
            }

            $depth = setGetDepth('minus');
            $str .= $space . "} \n";
            $space = setGetSpace(8, 'minus');

        }
        $str .= $space . "}1 \n";
        echo $str;
        $carry[] = $str;

        if ((is_array($item['children'])) && ($item['status'] == '  ')) {

            viewDiff($item['children'], $file, $str);
        }
  
        return $str;
    };

    $res = array_reduce($inside, $func);
}

function viewDiff($data, $file, $str)
{
    $func = function ($carry, $item) use ($file, $str) {
        $strCh = '';
        if (is_array($item)) {

            $inside = viewChildren($item, $file, $strCh);
        }
    };

    $newArray = array_reduce($data, $func);
    
    //        //$myfile = fwrite($file, $str);
    //print_r($data);
}

