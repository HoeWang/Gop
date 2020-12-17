<?php
require_once './vendor/autoload.php';

use Gop\Tools\Count;
use Gop\Tools\Ram;
use Gop\Tools\ArrayHp;

//$res = Count::math(2323.231, '/', 234, 3);
//var_dump($res);

//Ram::execMemory(function () {
//    $s = [];
//    for ($i = 0; $i < 1000000; $i++) {
//        $s[] = $i;
//    }
//});

//$res = ArrayHp::unique(['werwer', 'werwerwe', 'apple', 'apple']);
//var_dump($res);

//$res = ArrayHp::inArray(0, ['werwer', 'werwerwe', 'apple', '0']);


//$res = \Gop\Tools\StringHp::getTypeByMobile(18520638333);
//var_dump($res);


$res = 0;
Ram::execMemory(function () use (&$res){
    $s = Ram::yieldToDo(function () {
        return 2;
    }, 100000000);
    $res = 0;
    foreach ($s as $data) {
        $res += $data;
    }
});

//Ram::execMemory(function () use (&$res){
//    ini_set('memory_limit', '12048M');
//    $s = [];
//
//    for($i = 0; $i < 100000000; $i++) {
//        $s[] = 2;
//    }
//    foreach ($s as $data) {
//        $res += $data;
//    }
//});



var_dump($res);
//Key is invalid. You must supply a key in OpenSSH public key format