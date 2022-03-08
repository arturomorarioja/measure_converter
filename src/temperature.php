<?php
/**
 * Temperature class
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0, March 2022
 */

    class Temperature {
        const CELSIUS = 'C';
        const FAHRENHEIT = 'F';
        const KELVIN = 'K';

        private float $measure;
        private string $system;

        function __construct(float $measure, string $system) {
            if (!$this->isValidSystem($system)) {
                throw new InvalidArgumentException('Invalid temperature system');
            } else {
                $this->measure = $measure;
                $this->system = $system;
            }
        }

        function convert(string $destinationSystem) {
            if (!$this->isValidSystem($destinationSystem)) {
                throw new InvalidArgumentException('Invalid temperature system');
            } else {
                if ($this->system === $destinationSystem) {
                    return $this->measure;
                } else {
                    switch ($this->system . $destinationSystem) {
                        case Temperature::CELSIUS . Temperature::FAHRENHEIT:    return round($this->celsiusToFahrenheit(), 2);
                        case Temperature::CELSIUS . Temperature::KELVIN:        return round($this->celsiusToKelvin(), 2);
                        case Temperature::FAHRENHEIT . Temperature::CELSIUS:    return round($this->fahrenheitToCelsius(), 2);
                        case Temperature::FAHRENHEIT . Temperature::KELVIN:     return round($this->fahrenheitToKelvin(), 2);
                        case Temperature::KELVIN . Temperature::CELSIUS:        return round($this->kelvinToCelsius(), 2);
                        case Temperature::KELVIN . Temperature::FAHRENHEIT:     return round($this->kelvinToFahrenheit(), 2);
                    }
                }
            }
        }        
        
        /**
         * return   true if the temperature system is valid, false otherwise
         */
        private function isValidSystem($system) {
            return in_array($system, [Temperature::CELSIUS, Temperature::FAHRENHEIT, Temperature::KELVIN]);
        }
        
        private function celsiusToFahrenheit()  { return ($this->measure * 1.8) + 32; }
        private function celsiusToKelvin()      { return $this->measure + 273.15; }
        private function fahrenheitToCelsius()  { return ($this->measure - 32) / 1.8; }
        private function fahrenheitToKelvin()   { return ($this->measure + 459.67) * (5 / 9); }
        private function kelvinToCelsius()      { return $this->measure - 273.15; }
        private function kelvinToFahrenheit()   { return ($this->measure * (5 / 9)) - 459.67; }
    }

?>