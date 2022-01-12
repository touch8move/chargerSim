<?php

class TransF extends Trans {
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    public $channel;
	public $charger_state;
    public $kwh;
    public $temp;
    public $humi;

	public $eventCode;
	public $rsrp;
    
    function __construct($charger)
    {
        $this->ins = new Property("ins", "f", 1,"a");
        $this->ml = new Property("ml",13, 2);
        parent::__construct($charger);
    }
}