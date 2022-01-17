<?php

class TransL extends Trans {
    public $station_id;
    public $charger_id;
    public $ins;
    public $ml;

    public $channel;
    public $charging_state;
    public $memberNo;

    public $chargingStartTime;
    public $chargingEndTime;
    public $chargedKwhByHour;
    public $unPlugedTime;

    
    function __construct($charger, $memberNo, $chargedKwhByHour)
    {
        $this->ins = new Property("ins", "l", 1,"a");
        $this->ml = new Property("ml",13, 2);
        
        parent::__construct($charger);
        $this->memberNo = new Property("memberNo", $memberNo, 8, "m");
        $this->charging_state = new Property("charger_state", 0, 1);
        $start =  new Datetime();
        $end = new Datetime();
        $unpluged = new Datetime();
        $start->sub(new DateInterval("PT1H"));
        // echo "Time:".$start->format('ymd His')."\n";

        $this->chargingStartTime = new Property("chargingStartTime", $start->getTimestamp(), 6, "b");
        $this->chargingEndTime = new Property("chargingEndTime", $end->getTimestamp(), 6, "b");
        $this->unPlugedTime = new Property("unPlugedTime", $unpluged->getTimestamp(), 6, "b");
        $this->chargedKwhByHour = new Property("chargedKwhByHour", $chargedKwhByHour, 48, "p");

    }
}