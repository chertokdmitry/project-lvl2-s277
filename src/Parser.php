<?php
namespace Diff\Parser;

use Symfony\Component\Yaml\Yaml;

function getData($file, $format)
{
    $result = [];

    if ($format == "json" || $format == "pretty") {
        $func = function ($fileData) {
            return json_decode($fileData);
        };
    }

    if ($format == "yaml") {
        $func = function ($fileData) {
            return Yaml::parse($fileData);
        };
    }

    $data = $func($file);
    $newdata = objToArray($data);

    return $newdata;
}

function objToArray($obj)
{
    if (is_object($obj)) {
        $obj = (array) $obj;
    }
    if (is_array($obj)) {
        $new = array();
        foreach ($obj as $key => $val) {
            $new[$key] = objToArray($val);
        }
    } else {
        $new = $obj;
    }
    return $new;
}
