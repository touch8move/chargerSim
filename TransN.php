<?php

class TransN extends Trans {
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    public $dnType;
    public $dnVer;
    public $dnIndex;
    
    function __construct($charger, $version, $index)
    {
        $this->ins = new Property("ins", "n", 1,"a");
        $this->ml = new Property("ml",13, 2);
        
        parent::__construct($charger);

        $this->dnType = new Property("dnType", 0, 1);
        $this->dnVer = new Property("dnVer", $version, 10);
        $this->dnIndex = new Property("dnType", $index, 4);
        
    }
}