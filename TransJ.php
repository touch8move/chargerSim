<?php

class TransJ extends Trans {
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    public $channel;
    public $charger_state;
    public $kwh;
    public $charging_state;
    public $memberNo;
    
    function __construct($charger, $memberNo)
    {
        $this->ins = new Property("ins", "j", 1,"a");
        $this->ml = new Property("ml",16, 2);
        
        parent::__construct($charger);
        $this->memberNo = new Property("memberNo", $memberNo, 8, "m");
        $this->charger_state = new Property("charger_state", $memberNo, 2);
        $this->charging_state = new Property("charging_state", $memberNo, 1);

    }
}