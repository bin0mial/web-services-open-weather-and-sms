<?php

namespace APIFetcher\weather;

use \GuzzleHttp\Client;

class WeatherGuzzle extends Weather_Provider
{
    protected $url;

    public function __construct($api_version=2.5) {
        $this->url = __WEATHER_API_BASE_URL."data/$api_version/weather";
    }


    protected function send($url)
    {
        try {
            $client = new Client();
            $response = $client->get($url);
            return json_decode($response->getBody(), true);
        }
        catch (\Exception $e){
            echo $e->getMessage();
            return false;
        }
    }

}