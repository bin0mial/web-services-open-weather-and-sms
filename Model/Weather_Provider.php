<?php


abstract class Weather_Provider implements  Weather_Interface
{
    public function get_weather($city_id)
    {
        $url =  $this->get_final_url(["id"=>$city_id]);
        $response = $this->send($url);
        $this->reformat_response($response);
        return $response;
    }
    private function get_final_url($data): string
    {
        // Dealing with parameters (Assoc array)
        $params = array_map(function ($value, $key){
            return sprintf("%s=%s", $key, $value);
        }, $data, array_keys($data));
        $params[] = "appid=".__WEATHER_API_KEY;
        $params = join("&", $params);

        // Forming the last URL
        return "$this->url?$params";

    }
    public function get_cities() {
        $file = file_get_contents(__RESOURCES_DIR."/city.list.json");
        $json_data = json_decode($file, true);
        return array_filter($json_data, function ($city){
            return $city["country"] == "EG";
        });
    }

    public function get_current_time(): array
    {
        $full_datetime = [];

        $unix_time = time();
        $tz = new DateTimeZone("Africa/Cairo");

        $time = new DateTime();
        $time->setTimestamp($unix_time)->setTimezone($tz);

        $full_datetime["day_hour"] = $time->format("l g:i a");
        $full_datetime["date"] = $time->format("jS F, Y");

        return $full_datetime;
    }

    protected function reformat_response(&$response){
        $response["main"]["temp_max"] = (int)($response["main"]["temp_max"] -273);
        $response["main"]["temp_min"] = (int)($response["main"]["temp_min"] -273);
        $response["wind"]["speed"] = round($response["wind"]["speed"]*3.6, 1);
    }

}