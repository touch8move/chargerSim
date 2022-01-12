<?php

class Property {
    public $name;
    public $value;
    public $byteLength;
    public $convertType;
    function __construct($name, $value, $length, $type="h")
    {
        $this->name = $name;
        $this->value = $value;
        $this->byteLength = $length;
        $this->convertType = $type;
    }
}