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

// $service_port = 8085;
$service_port = 8085; // lotte_local

// $address = "192.168.1.198";
// $address = "121.67.246.183";
// $address = "121.67.246.151";
// $address = "121.67.246.161";
$address = "127.0.0.1";
// $address = "192.168.1.160";
$lot_number = "0205001201";
$firmware = "CST2106080";
$mdn = "01235840713";
$sound = 5;
$channel = 0;
$model_code = 8;
$manufacturer_code = 1;
// $station_id = "3116002307";
// $lot_number = "3116002308";

class ChargerThread extends Thread {
    public $stop = false;
    public $socket = null;
	public $charger;
	public function __construct($address, $socket, $station_id, $charger_id, $channel, $manufacturer_code, $model_code, $fw_ver, $soundVol, $mdn){
        $tran_date =  new Datetime();
		$this->socket = $socket;
        $this->charger = new Charger($address, $station_id, $charger_id, $channel, $manufacturer_code, $model_code, $fw_ver, $soundVol, $mdn);
        // $memberNo = "1010010187583380";
        // $memberNo = "1010010006728315"; // 환경부카드
        $memberNo = "F0F0F0F010101010"; // 비회원
        // $memberNo = "1010010170374771";
        $prepay_amount = 20000;
        $prepay_tran_no = $tran_date->format("YmdHis").$station_id.$charger_id;
        $prepay_auth_no = sprintf("%08d",rand(0,99999999));

        // $smartro_y = "Y";
        // $smartro_amount = 5000;
        // $smartro_auth_date = $tran_date;
        // $smartro_order_no = $tran_date->format("YmdHis").$station_id.$charger_id;
        // $smartro_auth_no = sprintf("%08d",rand(0,99999999));

        $smartro_y = "N";
        $smartro_amount = 0;
        $smartro_auth_date = "";
        $smartro_order_no = "";
        $smartro_auth_no = "";

        // $prepay_amount = 0;
        // $prepay_tran_no = "";
        // $prepay_auth_no = "";
        // $tran_date = 0;
        // $memberNo = "F0F0F0F010101010";
        
        $this->action = [
            // new TransB($this->charger),
            // new TransD($this->charger),
            // new TransE($this->charger),
            // new TransF($this->charger),
            // new TransG($this->charger, $memberNo),
            // new TransH($this->charger, $memberNo, $prepay_amount, $prepay_tran_no, $prepay_auth_no),
            // new TransI($this->charger, $memberNo, [0,0,0,0,0,0,0,0,0,0,0,0,10,0,0,0,0,0,0,0,0,0,20,30]),
            // new TransJ($this->charger, $memberNo),
            new TransL($this->charger, $memberNo, [0,0,0,0,0,0,0,0,0,0,0,0,100,0,0,0,0,0,0,0,0,0,0,0], $prepay_amount, $tran_date, $prepay_tran_no, $prepay_auth_no, $smartro_y, $smartro_amount, $smartro_auth_date, $smartro_order_no, $smartro_auth_no),
            // new TransM($this->charger, "0"),
            // new TransN($this->charger, "0", 0)
        
        ];
        
	}
	
	public function run(){
		$i = 0;
        while(count($this->action)>$i){
            echo "{$this->charger->station_id->value}-{$this->charger->charger_id->value}, {$this->charger->channel->value} start ---------------------------------------------------------------------------------------------------\n";
            // echo "--------------------------------------------------------------------------------------------\n";
            $hexarray = Library::strToHexArray($this->action[$i]);
            $i++;
            // $hexarray = Library::strToHexArray($this->action[rand(0,count($this->action)-1)]);
            $merge_array = array_merge(array(0x01),$hexarray);  // SOH
            $crc=new Property("crc", Library::getCRC16($merge_array), 2, "a");
            // $crchex = Library::strToHexArray($crc);
            array_push($merge_array, ($crc << 8) & 0xFF); // CRC
            array_push($merge_array, $crc & 0xFF); // CRC
            // array_push($merge_array, $crchex); // CRC
            array_push($merge_array, 0x04);    // EOT
            Library::taillog($merge_array,"[SEND]");
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
            usleep(1000000);
            
            
        }
    
	}
}

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

    // $charger1 = new ChargerThread($address, $socket, $station_id, sprintf("%02d",$i+1), 0, 8, 1, "2222222222", 5, "01200000000");
    $charger1 = new ChargerThread($address, $socket, substr($lot_number, 0,8), substr($lot_number, 8,2), $channel, $model_code, $manufacturer_code, $firmware, $sound, $mdn);
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