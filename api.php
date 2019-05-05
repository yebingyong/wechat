<?php
/**
 * User: yeby
 * Date: 2019/5/5
 * Time: 16:34
 */

var_dump(GET["echostr"]);
return GET["echostr"];
//echostr
//private function checkSignature()
//{
//    _GET["signature"];
//    _GET["timestamp"];
//    _GET["nonce"];
//
//    tmpArr = array(timestamp, $nonce);
//    sort($tmpArr, SORT_STRING);
//    $tmpStr = implode( $tmpArr );
//    $tmpStr = sha1( $tmpStr );
//
//    if( signature ){
//        return true;
//    }else{
//        return false;
//    }
//}