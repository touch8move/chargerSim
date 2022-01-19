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
require_once "TransL.php";
require_once "TransM.php";
require_once "TransN.php";

$memberNo = "e0c11001a0083687";
// $memberNo = "1010010145540773";
$hexmemberNo = "0003e0c11001a008";
// $memberNo = "1111111111111111";


$date = new Datetime();
$startTime = $date->getTimestamp();
$controller = new Controller(
    new Charger("11111111","01","1","1","1","CTT0000000","5","012333333333"),
    "127.0.0.1",
    "8085"
);
$action = [
    new TransB($controller->charger),
    new TransD($controller->charger),
    new TransE($controller->charger),
    new TransF($controller->charger),
    new TransG($controller->charger, $memberNo),
    new TransH($controller->charger, $memberNo),
    new TransI($controller->charger, $memberNo, [20000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,20,30]),
    new TransJ($controller->charger, $memberNo),
    new TransL($controller->charger, $memberNo, [20000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,20,30]),
    new TransM($controller->charger, "0"),
    new TransN($controller->charger, "0", 0)

];
while(true){
foreach($action as $item){
    echo $item->ins->value."\n";
    $controller->test($item);
    usleep(100000);
}
usleep(100000);
}