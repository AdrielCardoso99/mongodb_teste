<?php

Class Response{
    
    private $status;
    private $message;
    private $data;
    
    function getStatus() {
        return $this->status;
    }

    function getMessage() {
        return $this->message;
    }

    function getData() {
        return $this->data;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setData($data) {
        $this->data = $data;
    }


}
