<?php

class TransE extends Trans {
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    // public $channel;
	// public $charger_state;
    // public $kwh;
	// public $availAmpere;
	// public $channelAmpere;
    
    function __construct($charger)
    {
        $this->ins = new Property("ins", "e", 1,"a");
        $this->ml = new Property("ml",0, 2);
        parent::__construct($charger);
    }
}