<?php
class SMS implements SMS_Interface{

    private $text_local;
    private $sender;

    public function __construct()
    {
        $this->text_local = new Textlocal(__TEXT_LOCAL_USERNAME, __TEXT_LOCAL_HASH);
        $this->sender = __TEXT_LOCAL_SENDER;
    }

    public function send_bulk($numbers = array(), $message="")
    {
        if(!empty($numbers)){
            try {
                return $this->text_local->sendSms($numbers, $message, $this->sender);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        return false;
    }

    public function send($number, $message="")
    {
        try {
            return $this->text_local->sendSms($number, $message, $this->sender);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return false;
    }
}