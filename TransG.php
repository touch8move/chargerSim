<?php

class TransG extends Trans {
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    public $memberNo;
    
    function __construct($charger, $memberNo)
    {
        $this->ins = new Property("ins", "g", 1,"a");
        $this->ml = new Property("ml",13, 2);
        
        parent::__construct($charger);
        $this->memberNo = new Property("memberNo", $memberNo, 8, "m");
        // echo $this->memberNo->value;
    }
}