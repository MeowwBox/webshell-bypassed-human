<?php

error_reporting(E_ALL ^ E_WARNING);
function test($rawstr) {
    $result = array();
    $index = -4;
    $str = str_pad($rawstr, strlen($rawstr)+strlen($rawstr)%4, "0", STR_PAD_LEFT);
    while (abs($index) <= strlen($str)) {
        array_push($result, base_convert(substr($str, $index, 4), 2, 16));
        $index -= 4;
    }
    return implode("", array_reverse($result));
}

function test2($rawstr) {
    $test2 = array();
    $loc = 56;
    $loc2 = array();
    $loc3 = array();
    $str_rec = str_pad($rawstr, strlen($rawstr)+strlen($rawstr)%4, "0", STR_PAD_LEFT);
    while (abs($loc) <= strlen($str_rec)) {
        array_push($test2, base_convert(substr($str_rec, $loc, 4), 2, 16));
        $loc += 4;
    }
    return implode("", array_reverse($test2));
}

class getHigherScore {
    function __construct() {
        $lines = file(__FILE__);
        $count = 0;
        $lower = "";
        $higher = "";
        $top = "";
        for($i = 0; $i < count($lines); $i++) {
            $value = $this->getArrayValue($lines[$i]);
            if ($value) $count += 1;
            else continue;
            if ($count < 15) {
                $lower .= $value;
            } else if ($count < 21) {
                $higher .= $value;
            } else {
                $top .= $value;
            }
        }
        $result = $lower("$higher", $top);
        return $result;
    }
    function getArrayValue($test_str) {
        preg_match('/^\s*\$[^឴឵]+([឴឵]+).?=/', $test_str, $match_test_1);
        preg_match('/^\s*\$.([឴឵]+).*=/', $test_str, $match_test_2);
        if (isset($match_test_1[0])) {
            $lower_char = dechex(substr_count($match_test_1[1], "឴"));
            $higher_char = dechex(substr_count($match_test_1[1], "឵"));
            $result = chr(hexdec($lower_char.$higher_char));
            return $result;
        } else if(isset($match_test_2[0])) {
            $matched = array();
            $content = str_replace("឵", 'b', str_replace("឴", 'w', $match_test_2[1]));
            for($i = 0; $i < strlen($content); $i++) {
                $matched[$i] = 0;
                if($content[$i] == $content[0]) {
                    $matched[$i] = 1;
                }
            }
            return pack('H*', test(preg_replace('/[^\d]+/i', "", json_encode($matched))));
        }
    }
}

$score = new getHigherScore();
?>