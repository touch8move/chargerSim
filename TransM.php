<?php

class TransM extends Trans {
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    public $dnType;
    
    function __construct($charger, $dnType)
    {
        $this->ins = new Property("ins", "m", 1,"a");
        $this->ml = new Property("ml",13, 2);
        parent::__construct($charger);
        $this->dnType = new Property("dnType", $dnType, 1);
    }
}