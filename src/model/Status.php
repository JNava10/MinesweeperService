<?php

namespace model;

class Status {
    public $code;
    public $description;

    public function __construct($code, $description) {
        $this->code = $code;
        $this->description = $description;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getDescription()
    {
        return $this->description;
    }
}