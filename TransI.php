<?php

class TransI extends Trans {
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    public $channel;
    public $charger_state;
    public $kwh;
    public $charging_state;
    public $memberNo;

    public $chargingStartTime;
    public $chargingEndTime;
    public $unPlugedTime;

    public $setChargingAmpere;
    public $chargingVoltage;
    public $realChargingAmpere;

    public $betteryCapacity;
    public $betteryAmount;
    public $betteryTemperature;

    public $temp;
    public $humi;
    
    
    function __construct($charger, $memberNo)
    {
        $this->ins = new Property("ins", "i", 1,"a");
        $this->ml = new Property("ml",110, 2);
        
        parent::__construct($charger);
        $this->memberNo = new Property("memberNo", $memberNo, 8);
        
        $this->setChargingAmpere = new Property("setChargingAmpere", 1, 4);
        $this->chargingVoltage = new Property("chargingVoltage", 1, 4);
        $this->realChargingAmpere = new Property("realChargingAmpere", 1, 4);
        $this->betteryCapacity = new Property("betteryCapacity", 1, 4);
        $this->betteryAmount = new Property("betteryAmount", 1, 4);
        $this->betteryTemperature = new Property("betteryTemperature", 1, 4);
        $date = new Datetime();
        $this->chargingStartTime = new Property("chargingStartTime", $date->getTimestamp(), 6);
    }
}