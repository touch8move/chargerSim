<?php

class TransB extends Trans{
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    public $manufacturer_code;
    public $model_code;
    public $channel;
    public $fw_ver;
    public $currentTime;
    public $soundVol;
    public $mdn;

    function __construct($charger)
    {
        $this->ins = new Property("ins", "b", 1, "a");
        $this->ml = new Property("ml", 44, 2);

        parent::__construct($charger);
        $date = new Datetime();
        $this->currentTime = new Property("currentTime", $date->getTimestamp(), 6);

    }
}