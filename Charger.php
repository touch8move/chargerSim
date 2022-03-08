<?php

class Charger {
    public $station_id;
    public $charger_id;
    public $manufacturer_code;
    public $model_code;
    public $channel;
    public $fw_ver;
    public $soundVol;
    public $mdn;
    public $charger_state;
    public $charging_state;
    public $kwh;
    public $availAmpere;
    public $channelAmpere;
    public $unitprice;
    public $nonmemberprice;
    public $temp;
    public $humi;
    public $eventCode;
    public $rsrp;
    public $memberType;
    public $memberNo;
    public $chargedKwhByHour;
    public $chargingStartTime;
    public $chargingEndTime;
    public $unPlugedTime;
    public $demandKwh;
    public $demandTime;
    public $demandPrice;

    function __construct($address, $station_id, $charger_id, $channel, $manufacturer_code, $model_code, $fw_ver, $soundVol, $mdn)
    {
        $this->station_id = new Property("station_id", $station_id, 4);
        $this->charger_id = new Property("charger_id", $charger_id, 1);
        $this->channel = new Property("channel", $channel, 1);
        $this->manufacturer_code = new Property("manufacturer_code", $manufacturer_code, 1);
        $this->model_code = new Property("model_code", $model_code, 1);
        $this->fw_ver = new Property("fw_ver", $fw_ver, 10, "a");
        $this->soundVol = new Property("soundVol", $soundVol, 1);
        $this->mdn = new Property("mdn", $mdn, 12, "a");

        $this->charger_state = new Property("charger_state", 0, 2);
        $this->charging_state = new Property("charging_state", 0, 1);;
        $this->kwh = new Property("kwh", 0, 4); // 충전기 사용 전력량
        $this->availAmpere = new Property("availAmpere", 0, 4); // 공급가능 전력량
        $this->channelAmpere = new Property("channelAmpere", 0, 4); // 채널 설정 전류량
        $this->unitprice = new Property("unitprice", null, 48);
        $this->nonmemberprice = new Property("nonmemberprice", 100, 2);
        $this->temp = new Property("temp", 250, 2);
        $this->humi = new Property("humi", 400, 2);
        $this->eventCode = new Property("eventCode", 0, 1);;
        $this->rsrp = new Property("rsrp", 0, 1);;
        $this->memberType = new Property("memberType", 0, 1);
        $this->memberNo = new Property("memberNo", 0, 8);
        $this->chargedKwhByHour = new Property("chargedKwhByHour", [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0], 48);
        $this->chargingStartTime = new Property("chargingStartTime", 0, 6);
        $this->chargingEndTime = new Property("chargingEndTime", 0, 6);
        $this->unPlugedTime = new Property("unPlugedTime", 0, 6);
        $this->demandKwh = new Property("demandKwh", 0, 4);
        $this->demandTime = new Property("demandTime", 0, 4);
        $this->demandPrice = new Property("demandPrice", 0, 4);
        $this->address = $address;
    }
}