<?php

class TransH extends Trans {
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    public $channel;
    public $charger_state;
    public $kwh;
    public $memberNo;

    public $chargingStartTime;
    public $demandKwh;
    public $demandTime;
    public $demandPrice;
    
    function __construct($charger, $memberNo)
    {
        $this->ins = new Property("ins", "h", 1,"a");
        $this->ml = new Property("ml",71, 2);
        
        parent::__construct($charger);
        $this->memberNo = new Property("memberNo", $memberNo, 8);
        $this->chargingStartTime = new Property("chargingStartTime", 0, 6);
        $this->demandKwh = new Property("demandKwh", 0, 4);
        $this->demandTime = new Property("demandTime", 0, 4);
        $this->demandPrice = new Property("demandPrice", 0, 4);
    }
}