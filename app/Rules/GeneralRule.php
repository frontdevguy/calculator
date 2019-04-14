<?php

namespace App\Rules;

class GeneralRule
{

    /**
     * splits string to array
     * @param  string  
     * @return array
    */

    protected function strSplitUnicode(string $str,int $l = 0) {
        if ($l > 0) {
            $ret = [];
            $len = mb_strlen($str, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, "UTF-8");
            }
            return $ret;
        }
        return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }
}
