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

    public $prepay_amount;
    public $prepay_tran_date;
    public $prepay_tran_no;
    public $prepay_auth_no;
    
    function __construct($charger, $memberNo, $prepay_amount, $prepay_tran_no, $prepay_auth_no)
    {
        $this->ins = new Property("ins", "h", 1,"a");
        $this->ml = new Property("ml",93, 2);
        
        parent::__construct($charger);
        $this->memberNo = new Property("memberNo", $memberNo, 8, "m");
        $start = new Datetime();
        // $start->sub(new DateInterval("P1H"));
        

        $this->chargingStartTime = new Property("chargingStartTime", $start->getTimestamp(), 6, "b");
        $this->demandKwh = new Property("demandKwh", 0, 4);
        $this->demandTime = new Property("demandTime", 0, 4);
        $this->demandPrice = new Property("demandPrice", 0, 4);

        $this->prepay_amount = new Property("prepay_amount", $prepay_amount, 4, "h");
        $this->prepay_tran_date = new Property("prepay_tran_date", $start->getTimestamp(), 6, "b");
        $this->prepay_tran_no = new Property("prepay_tran_no", $prepay_tran_no, 30, "a");
        $this->prepay_auth_no = new Property("prepay_auth_no", $prepay_auth_no, 20, "a");
    }
}