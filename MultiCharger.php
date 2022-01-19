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


class ChargerThread extends Thread {
    public $stop = false;
	public $charger;
	public function __construct($socket, $station_id, $charger_id, $channel, $manufacturer_code, $model_code, $fw_ver, $soundVol, $mdn){
		$this->socket = $socket;
        $this->charger = new Charger($station_id, $charger_id, $channel, $manufacturer_code, $model_code, $fw_ver, $soundVol, $mdn);
        $memberNo = "e0c11001a0083687";
        $this->action = [
            new TransB($this->charger),
            new TransD($this->charger),
            new TransE($this->charger),
            new TransF($this->charger),
            new TransG($this->charger, $memberNo),
            new TransH($this->charger, $memberNo),
            new TransI($this->charger, $memberNo, [20000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,20,30]),
            new TransJ($this->charger, $memberNo),
            new TransL($this->charger, $memberNo, [20000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,20,30]),
            new TransM($this->charger, "0"),
            new TransN($this->charger, "0", 0)
        
        ];
        
	}
	
	public function run(){
		while(true){
			while(true){
                $hexarray = Library::strToHexArray($this->action[rand(0,10)]);
                $merge_array = array_merge(array(0x01),$hexarray);  // SOH
                $crc=Library::getCRC16($merge_array);
                array_push($merge_array, ($crc << 8) & 0xFF); // CRC
                array_push($merge_array, $crc & 0xFF); // CRC
                array_push($merge_array, 0x04);    // EOT
                $message  = pack("C*",...$merge_array); 
                socket_write($this->socket, $message, strlen($message));
                usleep(1000000*rand(0,20));
                
            }
		}
	}
}

$service_port = 8085;

/* Get the IP address for the target host. */
$address = "127.0.0.1";
$station = [];
// charger created
for($i=0;$i<10;$i++){
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    } else {
        echo "OK.\n";
    }
    
    echo "Attempting to connect to '$address' on port '$service_port'...";
    $result = socket_connect($socket, $address, $service_port);
    if ($result === false) {
        echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
    } else {
        echo "OK.\n";
    }
    $charger = new ChargerThread($socket, "11111111", sprintf("%02d",$i+1), 2, 8, 1, "CTT0000011", 5, "01200000000");
    $charger->start();
    $station[] = $charger;
}


while (count($station) > 0){
    sleep(1);
}