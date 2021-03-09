<?php
interface Weather_Interface {
    public function get_cities();
    public function get_weather($city_id);
    public function get_current_time();
    
    
}