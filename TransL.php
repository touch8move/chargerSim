<?php

class TransL extends Trans {
    private $address;

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

    public $prepay_amount;
    public $prepay_tran_date;
    public $prepay_tran_no;
    public $prepay_auth_no;

    public $smartro_y;
    public $smartro_amount;
    public $smartro_auth_date;
    public $smartro_order_no;
    public $smartro_auth_no;




    
    
    function __construct($charger, $memberNo, $chargedKwhByHour, $prepay_amount=0, $tran_date="", $prepay_tran_no="", $prepay_auth_no=""
    ,$smartro_y="N",    $smartro_amount=0,    $smartro_auth_date="",    $smartro_order_no="",    $smartro_auth_no="")
    {
        $this->ins = new Property("ins", "l", 1,"a");
        $this->ml = new Property("ml",136+71, 2);
        
        parent::__construct($charger);
        $this->memberNo = new Property("memberNo", $memberNo, 8, "m");
        $this->charging_state = new Property("charger_state", 0, 1);
        $start =  new Datetime();
        $end = new Datetime();
        $unpluged = new Datetime();
        // $start->sub(new DateInterval("PT1H"));
        // echo "Time:".$start->format('ymd His')."\n";

        $this->chargingStartTime = new Property("chargingStartTime", $start->getTimestamp(), 6, "b");
        $this->chargingEndTime = new Property("chargingEndTime", $end->getTimestamp(), 6, "b");
        $this->unPlugedTime = new Property("unPlugedTime", $unpluged->getTimestamp(), 6, "b");
        $this->chargedKwhByHour = new Property("chargedKwhByHour", $chargedKwhByHour, 48, "p");

        $this->prepay_amount = new Property("prepay_amount", $prepay_amount, 4, "h");
        $this->prepay_tran_date = new Property("prepay_tran_date", empty($tran_date)===false?$tran_date->getTimestamp():"", 6, "b");
        $this->prepay_tran_no = new Property("prepay_tran_no", $prepay_tran_no, 30, "a");
        $this->prepay_auth_no = new Property("prepay_auth_no", $prepay_auth_no, 20, "a");

        $this->smartro_y = new Property("smartro_y", $smartro_y, 1, "a");
        $this->smartro_amount = new Property("smartro_amount", $smartro_amount, 4, "h") ;
        $this->smartro_auth_date = new Property("smartro_auth_date", empty($tran_date)===false?$tran_date->getTimestamp():"", 6, "b");
        $this->smartro_order_no = new Property("smartro_order_no", $smartro_order_no, 40, "a");
        $this->smartro_auth_no = new Property("smartro_auth_no", $smartro_auth_no, 20, "a");

        // $this->pay($prepay_amount, $prepay_tran_no, $prepay_auth_no);
        $scid = $this->station_id->value."-".$this->charger_id->value;
        $this->pay_evrang($scid, $prepay_amount, $prepay_tran_no, $prepay_auth_no);
    }

    public function pay($amount, $order_no, $auth_no){
        $date = new Datetime();
        $conn = mysqli_connect($this->address, 'root', 'Dlzkvmffjrm1!', 'ecarplug', 3306);
        if (!$conn) {
            die("서버와의 연결 실패! : ".mysqli_connect_error());
        }
        $r_res_cd = "0000";
        $r_res_msg = "정상승인";
        $r_cno = $date->format("YmdHisu");
        $r_memb_id = "05558919";
        $r_amount = $amount;
        $r_order_no = $order_no;
        $r_noti_type = "10";
        $r_auth_no = $auth_no;
        $r_tran_date = $date->format("YmdHis");
        $r_card_no = "11111111****1111";
        $r_issuer_cd = "006";
        $r_issuer_nm = "하나기업";
        $r_acquirer_cd = "008";
        $r_acquirer_nm = "하나카드";
        $r_install_period = "00";
        $r_noint = "00";
        $r_bank_cd = "";
        $r_bank_nm = "";
        $r_account_no = "";
        $r_deposit_nm = "";
        $r_expire_date = "";
        $r_cash_res_cd = "";
        $r_cash_res_msg = "";
        $r_cash_auth_no = "";
        $r_cash_tran_date = "";
        $r_cp_cd = "";
        $r_used_pnt = "";
        $r_remain_pnt = "";
        $r_pay_pnt = "";
        $r_accrue_pnt = "";
        $r_escrow_yn = "N";
        $r_canc_date = "";
        $r_canc_acq_date = "";
        $r_refund_date = "";
        $r_pay_type = "11";
        $r_auth_cno = "";
        $r_tlf_sno = "";
        $r_account_type = "";


        $sql = "INSERT INTO `kicc_prepay_result` (
	`r_res_cd`,
	`r_res_msg`,
	`r_cno`,
	`r_memb_id`,
	`r_amount`,
	`r_order_no`,
	`r_noti_type`,
	`r_auth_no`,
	`r_tran_date`,
	`r_card_no`,
	`r_issuer_cd`,
	`r_issuer_nm`,
	`r_acquirer_cd`,
	`r_acquirer_nm`,
	`r_install_period`,
	`r_noint`,
	`r_bank_cd`,
	`r_bank_nm`,
	`r_account_no`,
	`r_deposit_nm`,
	`r_expire_date`,
	`r_cash_res_cd`,
	`r_cash_res_msg`,
	`r_cash_auth_no`,
	`r_cash_tran_date`,
	`r_cp_cd`,
	`r_used_pnt`,
	`r_remain_pnt`,
	`r_pay_pnt`,
	`r_accrue_pnt`,
	`r_escrow_yn`,
	`r_canc_date`,
	`r_canc_acq_date`,
	`r_refund_date`,
	`r_pay_type`,
	`r_auth_cno`,
	`r_tlf_sno`,
	`r_account_type`
)
values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssssssssssssss", 
        $r_res_cd,
        $r_res_msg,
        $r_cno,
        $r_memb_id,
        $r_amount,
        $r_order_no,
        $r_noti_type,
        $r_auth_no,
        $r_tran_date,
        $r_card_no,
        $r_issuer_cd,
        $r_issuer_nm,
        $r_acquirer_cd,
        $r_acquirer_nm,
        $r_install_period,
        $r_noint,
        $r_bank_cd,
        $r_bank_nm,
        $r_account_no,
        $r_deposit_nm,
        $r_expire_date,
        $r_cash_res_cd,
        $r_cash_res_msg,
        $r_cash_auth_no,
        $r_cash_tran_date,
        $r_cp_cd,
        $r_used_pnt,
        $r_remain_pnt,
        $r_pay_pnt,
        $r_accrue_pnt,
        $r_escrow_yn,
        $r_canc_date,
        $r_canc_acq_date,
        $r_refund_date,
        $r_pay_type,
        $r_auth_cno,
        $r_tlf_sno,
        $r_account_type);
        if(mysqli_stmt_execute($stmt)==false){
			echo mysqli_error($conn);
		}
    }

    public function pay_evrang($scid, $amount, $order_no, $auth_no){
        $date = new Datetime();
        $conn = mysqli_connect($this->address, 'root', 'test', 'evrang', 3306);
        if (!$conn) {
            die("서버와의 연결 실패! : ".mysqli_connect_error());
        }
        $r_res_cd = "0000";
        $r_res_msg = "정상승인";
        $r_cno = $date->format("YmdHisu");
        $r_memb_id = "05558919";
        $r_amount = $amount;
        $r_order_no = $order_no;
        $r_noti_type = "10";
        $r_auth_no = $auth_no;
        $r_tran_date = $date->format("YmdHis");
        $r_card_no = "11111111****1111";
        $r_issuer_cd = "006";
        $r_issuer_nm = "하나기업";
        $r_acquirer_cd = "008";
        $r_acquirer_nm = "하나카드";
        $r_install_period = "00";
        $r_noint = "00";
        $r_bank_cd = "";
        $r_bank_nm = "";
        $r_account_no = "";
        $r_deposit_nm = "";
        $r_expire_date = "";
        $r_cash_res_cd = "";
        $r_cash_res_msg = "";
        $r_cash_auth_no = "";
        $r_cash_tran_date = "";
        $r_cp_cd = "";
        $r_used_pnt = "";
        $r_remain_pnt = "";
        $r_pay_pnt = "";
        $r_accrue_pnt = "";
        $r_escrow_yn = "N";
        $r_canc_date = "";
        $r_canc_acq_date = "";
        $r_refund_date = "";
        $r_pay_type = "11";
        $r_auth_cno = "";
        $r_tlf_sno = "";
        $r_account_type = "";


        $mem_id = 0;
        $nickname = "비회원현장결제";
        $phone = "";
        $email = "";
        $productnm = "비회원현장실물카드결제";
        $n = "정상";
        $a = "N";
        $b = "N";
        $c = "TS03";
        $d = "매입요청";
        $e = "Y";
        $f = "N";
        $g = "C";
        $h = "";
        $hh = "";
        $gg = "";
        $ggg = "";
        $gggg = $date->format("Y-m-d H:i:s");
        $ggggg = "127.0.0.1";
        $gggggg = "Mozilla";
        $ggggggg = "N";

$sql = "INSERT INTO `sb_pg_kicc` (
    `mem_id`,
    `kicc_sc_id`,
	`mem_nickname`,
	`mem_realname`,
	`mem_email`,
	`mem_phone`,
	`product_name`,
	`kicc_res_cd`,
	`kicc_res_msg`,
	`kicc_cno`,
	`kicc_amount`,
	`kicc_order_no`,
	`kicc_auth_no`,
	`kicc_tran_date`,
	`kicc_escrow_yn`,
	`kicc_complex_yn`,
	`kicc_stat_cd`,
	`kicc_stat_msg`,
	`kicc_pay_type`,
	`kicc_mall_id`,
	`kicc_card_no`,
	`kicc_issuer_cd`,
	`kicc_issuer_nm`,
	`kicc_acquirer_cd`,
	`kicc_acquirer_nm`,
	`kicc_install_period`,
	`kicc_noint`,
	`kicc_part_cancel_yn`,
	`kicc_card_gubun`,
	`kicc_card_biz_gubun`,
	`kicc_cpon_flag`,
	`kicc_used_cpon`,
	`kicc_canc_acq_date`,
	`kicc_canc_date`,
	`kicc_account_no`,
	`kicc_datetime`,
	`kicc_ip`,
	`kicc_useragent`,
	`kicc_is_test`
)
values (
    $mem_id,
    '$scid',
    '$nickname',
    '$nickname',
    '$phone',
    '$email',
    '$productnm',
    '$r_res_cd',
    '$n',
    '$r_cno',
    $r_amount,
    '$r_order_no',
    $r_auth_no,
    '$r_tran_date',
    '$a',
    '$b',
    '$c',
    '$d',
    '$r_pay_type',
    '$r_memb_id',
    '$r_card_no',
    '$r_issuer_cd',
    '$r_issuer_nm',
    '$r_acquirer_cd',
    '$r_acquirer_nm',
    '$r_install_period',
    '$r_noint',
    '$e',
    '$f',
    '$g',
    '$h',
    '$hh',
    '$gg',
    '$ggg',
    '$r_tran_date',
    '$gggg',
    '$ggggg',
    '$gggggg',
    '$ggggggg'
    )";
    // echo $sql."\n";
$result = mysqli_query($conn, $sql);
    echo mysqli_error($conn);
    }
}