<?php

class TransD extends Trans {
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    public $channel;
	public $charger_state;
    public $kwh;
	public $availAmpere;
	public $channelAmpere;
    
    function __construct($charger)
    {
        $this->ins = new Property("ins", "d", 1,"a");
        $this->ml = new Property("ml", 15, 2);

        parent::__construct($charger);
    }
}