<?php
require_once "Controller.php";
require_once "Charger.php";
require_once "Property.php";
require_once "Library.php";
require_once "Trans.php";
require_once "TransB.php";
require_once "TransD.php";
require_once "TransE.php";
require_once "TransF.php";
require_once "TransG.php";
require_once "TransH.php";
require_once "TransI.php";
require_once "TransJ.php";
// require_once "TransL.php";
// require_once "TransM.php";
// require_once "TransN.php";

$memberNo = "e0c11001a0083687";
$hexmemberNo = "0003e0c11001a008";
// $memberNo = "1111111111111111";
$controller = new Controller(
    new Charger("11111111","01","1","1","1","CTT0000000","5","012333333333"),
    "127.0.0.1",
    "8085"
);

// $controller->test(new TransB($controller->charger));
// $controller->test(new TransD($controller->charger));
// $controller->test(new TransE($controller->charger));

// $controller->test(new TransF($controller->charger));
// $controller->test(new TransG($controller->charger, $memberNo));
// $controller->test(new TransH($controller->charger, $memberNo));
// $controller->test(new TransI($controller->charger, $memberNo));
// $controller->test(new TransJ($controller->charger, $memberNo));
// $controller->test(new TransL($controller->charger));

// $controller->test(new TransM($controller->charger));
// $controller->test(new TransN($controller->charger));


function hexString($data ){
    $logstr="";
    for($i=0;$i<count($data);$i++){
        $logstr=$logstr. sprintf("%02x", $data[$i]);
    }
    return   $logstr;
}
// echo hexdec("e0");
// echo implode(",",Library::stringToHex($memberNo));
// echo hexString(str_split($hexmemberNo, 2));
echo implode(",", Library::hexstrTohex($memberNo));
// echo "\n";

$eval = "e";

echo $eval."\n";
echo sprintf("%02x\n", ord($eval));
echo sprintf("%d\n", hexdec($eval));

