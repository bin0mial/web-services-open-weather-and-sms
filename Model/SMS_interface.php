<?php
interface SMS_Interface {
    public function send_bulk($numbers=array(), $message="");
    public function send($number, $message="");
    
}


