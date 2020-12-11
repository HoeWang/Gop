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

$res = ArrayHp::inArray(0, ['werwer', 'werwerwe', 'apple', '0']);
var_dump($res);



//Key is invalid. You must supply a key in OpenSSH public key format