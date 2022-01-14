<?php

class Trans {
    
    public function __construct($charger)
    {
        $charger_properties = get_object_vars($charger);
        $trans_properties = get_object_vars($this);
        foreach ($charger_properties as $c_property=>$c_val){
            foreach($trans_properties as $t_property=>$t_val){
                if($c_property == $t_property){
                    $this->{$t_property} = $c_val;
                }
            }
        }
        
    }

}