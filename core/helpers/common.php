<?php
/**
 * 对称加密算法之加密
 * @param String $string 需要加密的字串
 * @param String $skey 加密EKY
 * @return String
 */
if(!function_exists('encode')){
    function encode($string = '', $skey = 'ifelse') {
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value)
            $key < $strCount && $strArr[$key].=$value;
        return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
    }
}

/**
 * 对称加密算法之解密
 * @param String $string 需要解密的字串
 * @param String $skey 解密KEY
 * @return String
 */
if(!function_exists('decode')){
    function decode($string = '', $skey = 'ifelse') {
        $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value)
            $key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
        return base64_decode(join('', $strArr));
    }
}


function getStringHash($string, $tab_count)
{
    $unsign = sprintf('%u', crc32($string));
    if ($unsign > 2147483647)  // sprintf u for 64 & 32 bit
    {
        $unsign -= 4294967296;
    }
    return abs($unsign) % $tab_count;
}
