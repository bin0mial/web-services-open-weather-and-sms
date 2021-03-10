<?php

use \APIFetcher\weather\WeatherGuzzle;
use \APIFetcher\sms\SMS;

require("./vendor/autoload.php");
ini_set('memory_limit', '-1');

$weather = new WeatherGuzzle();
$egyptian_cities = $weather->get_cities();
if (isset($_POST["submit"]) && isset($_POST["city"])) {
    $weather_data = $weather->get_weather($_POST["city"]);
    $datetime = $weather->get_current_time();

//    $sms_numbers = ["+201279852321"];
//    $sms_text = "Weather for {$weather_data["name"]} for {$datetime["day_hour"]} \n
//                in {$datetime["date"]} is {$weather_data["weather"][0]["description"]} \n
//                The Temperature is {$weather_data["main"]["temp_max"]}°C {$weather_data["main"]["temp_min"]}°C \n
//                The Humidity is {$weather_data["main"]["humidity"]}% and Wind Speed is {$weather_data["wind"]["speed"]}";
//    $sms = new SMS();
//    $sms->send_bulk($sms_numbers, $sms_text);

}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Weather Forecast</title>
</head>
<body>
<?php if(isset($weather_data) && isset($datetime)): ?>
    <h2><?php echo $weather_data["name"] ?> Weather Status</h2>
    <div>
        <div><?php echo $datetime["day_hour"] ?></div>
        <div><?php echo $datetime["date"] ?></div>
        <div><?php echo $weather_data["weather"][0]["description"]?></div>
        <div>
            <img src="http://openweathermap.org/img/wn/<?php echo $weather_data["weather"][0]["icon"] ?>@2x.png" style="filter: drop-shadow(0px 0px 2px black);" alt="<?php echo $weather_data["weather"][0]["description"] ?>">
            <span><?php echo $weather_data["main"]["temp_max"] ?>&deg;C</span>
            <span><?php echo $weather_data["main"]["temp_min"] ?>&deg;C</span>
        </div>
        <div>Humidity: <?php echo $weather_data["main"]["humidity"]?>&percnt;</div>
        <div>Wind Speed: <?php echo $weather_data["wind"]["speed"] ?> km/h</div>
    </div>
<?php endif; ?>
<h1>Weather Forecast</h1>
<form method="post">
    <label>
        <select name="city" required>
            <option disabled selected>Select City</option>
            <optgroup label="Egypt">Egypt
            <?php foreach ($egyptian_cities as $egyptian_city): ?>
                <option value="<?php echo $egyptian_city["id"] ?>"><?php echo "{$egyptian_city["country"]} >> {$egyptian_city["name"]}"?></option>
            <?php endforeach; ?>
            </optgroup>
        </select>
    </label>
    <button type="submit" name="submit" value="true">Get Weather</button>
</form>

</body>
</html>
