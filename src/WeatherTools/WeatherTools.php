<?php

class WeatherTools {
    /**
     * Apparent temperature. Мodel, that shows how people feels the temperature.
     * @param $temperatureC     float Temperature in degrees Сelsius
     * @param $windSpeedKmH     float Wind speed in km/h
     * @param $relativeHumidity float Relative humidity (between 0 and 1)
     * @param $pressureHPa      float Pressure in hPa (hectopascals, or millibars)
     * @return float|mixed
     */
    public function apparentTemperature(float $temperatureC, float $windSpeedKmH, float $relativeHumidity, float $pressureHPa): float {
        if ($temperatureC < 10) {
            return $this->windChill($temperatureC, $windSpeedKmH);
        }

        return $this->heatIndex($temperatureC, $relativeHumidity, $pressureHPa);
    }

    public function windChill($temperatureC, $windSpeedKmH): float {
        if ($temperatureC >= 10)
            return $temperatureC;

        if ($windSpeedKmH >= 4.8 && $windSpeedKmH <= 177) {
            $Rc = 13.12 + 0.6215 * $temperatureC + (0.3965 * $temperatureC - 11.37) * pow($windSpeedKmH, 0.16);
        } else if ($windSpeedKmH < 4.8) {
            $Rc = $temperatureC + 0.2 * (0.1345 * $temperatureC - 1.59) * $windSpeedKmH;
        } else {
            $Rc = $temperatureC;
        }

        return (float) $Rc;
    }

    public function dewPoint(float $temperatureC, float $relativeHumidity): float
    {
        if ($temperatureC < 0 || $temperatureC > 60) {
            return $temperatureC;
        }

        if ($relativeHumidity < 0.01 || $relativeHumidity > 1) {
            return $temperatureC;
        }

        $a = 17.27;
        $b = 237.7;

        $alphaTR = (($a * $temperatureC) / ($b + $temperatureC)) + log($relativeHumidity);

        $Tr = ($b * $alphaTR) / ($a - $alphaTR);

        if ($Tr < 0 || $Tr > 50) {
            return $temperatureC;
        }

        return $Tr;
    }

    public function heatIndex(float $temperatureC, float $relativeHumidity, float $pressureHPa): float
    {
        if ($pressureHPa < 16) {
            return $temperatureC;
        }

        if (
            $temperatureC < 27
            || $relativeHumidity < 0.40
            || ($this->dewPoint($temperatureC, $relativeHumidity) < 12)
        ) {
            return $temperatureC;
        }

        $c1 = -8.784695;
        $c2 = 1.61139411;
        $c3 = 2.338549;
        $c4 = -0.14611605;
        $c5 = -1.2308094 * 0.01;
        $c6 = -1.6424828 * 0.01;
        $c7 = 2.211732 * 0.001;
        $c8 = 7.2546 * 0.0001;
        $c9 = -3.582 * 0.000001;

        return $c1 + $c2 * $temperatureC + $c3 * $relativeHumidity + $c4 * $temperatureC * $relativeHumidity + $c5 * $temperatureC * $temperatureC + $c6 * $relativeHumidity * $relativeHumidity + $c7 * $temperatureC * $temperatureC * $relativeHumidity + $c8 * $temperatureC * $relativeHumidity * $relativeHumidity + $c9 * $temperatureC * $temperatureC * $relativeHumidity * $relativeHumidity;
    }
}