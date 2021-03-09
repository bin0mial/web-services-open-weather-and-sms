<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Weather
 *
 * @author webre
 */
class Weather extends Weather_Provider {

    protected $url;

    public function __construct($api_version=2.5) {
       $this->url = __WEATHER_API_BASE_URL."data/$api_version/weather";
    }


    protected function send($url)
    {
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, ["Content-Type: application/json", "Accept: application/json"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);

            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $result = substr($result, $header_size);

            curl_close($ch);

            return json_decode($result, true);
        }
        catch (Exception $e){
            echo $e->getMessage();
            return false;
        }
    }



}
