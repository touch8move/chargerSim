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
    public $socket = null;
	public $charger;
	public function __construct($address, $socket, $station_id, $charger_id, $channel, $manufacturer_code, $model_code, $fw_ver, $soundVol, $mdn){
		$this->socket = $socket;
        $this->charger = new Charger($address, $station_id, $charger_id, $channel, $manufacturer_code, $model_code, $fw_ver, $soundVol, $mdn);
        $memberNo = "e0c11001a0083687";
        // $memberNo = "F0F0F0F010101010";
        $tran_date =  new Datetime();
        $this->action = [
            // new TransB($this->charger),
            // new TransD($this->charger),
            // new TransE($this->charger),
            // new TransF($this->charger),
            // new TransG($this->charger, $memberNo),
            // new TransH($this->charger, $memberNo),
            // new TransI($this->charger, $memberNo, [20000,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,20,30]),
            // new TransJ($this->charger, $memberNo),
            new TransL($this->charger, $memberNo, [0,0,0,0,0,0,0,0,0,0,0,0,101,500,654,0,0,0,0,0,0,0,0,0], 20000, $tran_date->format("YmdHis").$station_id.$charger_id, sprintf("%08d",rand(0,99999999))),
            // new TransM($this->charger, "0"),
            // new TransN($this->charger, "0", 0)
        
        ];
        
	}
	
	public function run(){
		
        while(true){
            echo "{$this->charger->station_id->value}-{$this->charger->charger_id->value}, {$this->charger->channel->value} start ---------------------------------------------------------------------------------------------------\n";
            // echo "--------------------------------------------------------------------------------------------\n";
            $hexarray = Library::strToHexArray($this->action[rand(0,count($this->action)-1)]);
            $merge_array = array_merge(array(0x01),$hexarray);  // SOH
            $crc=Library::getCRC16($merge_array);
            array_push($merge_array, ($crc << 8) & 0xFF); // CRC
            array_push($merge_array, $crc & 0xFF); // CRC
            array_push($merge_array, 0x04);    // EOT
            $message  = pack("C*",...$merge_array); 
            socket_write($this->socket, $message, strlen($message));
            
            $start = Library::get_time();
            /*
            수행할 내용
            */
            
            $buf = socket_read($this->socket,2048); 


            if ($buf === ''){ 
                echo "{$this->charger->station_id->value}-{$this->charger->charger_id->value}, {$this->charger->channel->value} Connection closed charger '' \n";
                
                $this->isClosed = 1;
                exit();
            }

            if ($buf === false){
                echo "{$this->charger->station_id->value}-{$this->charger->charger_id->value}, {$this->charger->channel->value} Connection closed charger false\n";
                
                $this->isClosed = 1;
                
                exit();
            }

            if (!$buf = trim($buf)) {
                continue;
            }

            if ($buf) {
                $byte_array = Library::byteStr2byteArray($buf); 
                Library::taillog($byte_array,"[RECV]");
            } 
            
            $end = Library::get_time();
            $time = $end - $start;
            
            echo "{$this->charger->station_id->value}-{$this->charger->charger_id->value}, {$this->charger->channel->value}   ".number_format($time,6) . " sec\n";
            if($time> 10){
                $this->isClosed = 1;
                echo "connection closed\n";
                exit();
            }
            usleep(100000*rand(0,20));
            
            
        }
    
	}
}

$service_port = 8085;

// $address = "192.168.1.198";
// $address = "121.67.246.183";
$address = "127.0.0.1";
$station = [];
// charger created
for($i=0;$i<1;$i++){
    // Create a TCP Stream socket
    $socket = socket_create(AF_INET, SOCK_STREAM, 0);
    
    if (! socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1)) 
    { 
        echo (socket_last_error($socket)); 
        exit; 
    }
    // socket_set_block($socket);
    // 서버가 강제 종료되면 연결된 소켓은 즉시 커넥션을 해제한다.
    $linger = array('l_linger' => 0, 'l_onoff' => 1);
    socket_set_option($socket, SOL_SOCKET, SO_LINGER, $linger);

    $result = socket_connect($socket, $address, $service_port);
    if ($result === false) {
        echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
    }

    $charger1 = new ChargerThread($address, $socket, "11111111", sprintf("%02d",$i+1), 0, 8, 1, "CTT0000011", 5, "01200000000");
    $charger1->start();
    // $charger2 = new ChargerThread($socket, "11111111", sprintf("%02d",$i+1), 1, 8, 1, "CTT0000011", 5, "01200000000");
    // $charger2->start();
    $station[] = $charger1;
    // $station[] = $charger2;
    foreach($station as $key=>$value){
		if($value->isClosed == 1){
	
			// unset($item);
			unset($station[$key]);
			echo ("close".$value->station_id."-".$value->charger_id);
		}
	}
    sleep(1);
}


while (count($station) > 0){
    sleep(1);
}