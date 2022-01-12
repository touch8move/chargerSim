<?php


class Controller {
// TODO 초기 설정 로드
    private $address;
    private $port;
    private $socket;
    
    public $charger;
    function __construct($charger, $address, $port)
    {
        $this->charger = $charger;
        $this->address = $address;"127.0.0.1";
        $this->port = $port;;
    }
    function connect(){
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if(socket_connect($this->socket, $this->address, $this->port)==false){
            echo "connection failed";
        }
    }
    function send($hexarray){
        $merge_array = $hexarray;
        $merge_array = array_merge(array(0x01),$hexarray);  // SOH
        $crc=Library::getCRC16($merge_array);
        array_push($merge_array, ($crc>>8) & 0xFF); // CRC
        array_push($merge_array, ($crc>>0) & 0xFF); // CRC
        array_push($merge_array, 4);    // EOT
        
        $prt = "";
        foreach($merge_array as $value){
            $prt.=sprintf("%02x", $value);
        }
        echo sprintf("%s, length:%d, data: %s", chr($merge_array[6]), count($merge_array), $prt)."\n";
        $message  = pack("C*",...$merge_array); 
        socket_write($this->socket, $message, strlen($message));
    }

    function test($tran){
        $this->connect();
        if($this->socket){
            $hexarray = Library::strToHexArray($tran);
            $this->send($hexarray);
        }
    }
}

