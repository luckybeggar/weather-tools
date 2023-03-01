# WeatherTools

## Overview
WeatherTools is a set of php methods to work on weather data.

## Features
### Get apparent temperature
* apparentTemperature(float $temperatureC, float $windSpeedKmH, float $relativeHumidity, float $pressureHPa) : Get apparent temperature. Uses wind chill or heat index calculation based on temperature.

    * $temperatureC     : Temperature in degrees Сelsius
    * $windSpeedKmH     : Wind speed in km/h
    * $relativeHumidity : Relative humidity (between 0 and 1)
    * $pressureHPa      : Pressure in hPa (hectopascals, or millibars)

### Calculate heat index

* heatIndex($temperatureC, $relativeHumidity, $pressureHPa)

### Calculate wind chill index

* windChill($temperatureC, $windSpeedKmH)

### Calculate dew point

* dewPoint($temperatureC, $relativeHumidity)
 