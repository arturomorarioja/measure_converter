<?php

    require_once 'src/currency.php';

    use PHPUnit\Framework\TestCase;

    class CurrencyTest extends TestCase
    {
        public function testGetCurrencies(): void 
        {
            $currency = new Currency;

            $result = $currency->getCurrencies();

            $this->assertIsArray($result);
        }

        /**
         * @dataProvider ConvertNoCurrencies
         */
        public function testConvertNoCurrencies($amount) 
        {
            $currency = new Currency;

            $result = $currency->convert($amount);

            $this->assertIsNumeric($result);
        }
        public function ConvertNoCurrencies(): array 
        {
            return [
                [0],
                [1000],
                [1245.2],
                [1245.25]
            ];
        }

        /**
         * @dataProvider ConvertFromCurrency
         */
        public function testConvertFromCurrency($amount, $from) 
        {
            $currency = new Currency;

            $result = $currency->convert($amount, $from);

            $this->assertIsNumeric($result);
        }
        public function ConvertFromCurrency(): array 
        {
            return [
                [0, 'NOK'],
                [1000, 'USD'],
                [1245.2, 'EUR'],
                [1245.25, 'MXN']
            ];
        }        

        /**
         * @dataProvider Convert
         */
        public function testConvert($amount, $from, $to) 
        {
            $currency = new Currency;

            $result = $currency->convert($amount, $from, $to);

            $this->assertIsNumeric($result);
        }
        public function Convert(): array 
        {
            return [
                [0, 'NOK', 'MXN'],
                [1000, 'USD', 'EUR'],
                [1245.2, 'EUR', 'NOK'],
                [1245.25, 'MXN', 'USD']
            ];
        }        

        public function testNonExistingFromCurrency()
        {
            $currency = new Currency;
            $amount = 1000;
            $from = 'XXX';
            $to = 'USD';
            $expected = 'Validation error';

            $result = $currency->convert($amount, $from, $to);

            $this->assertEquals($expected, $result);
        }
        public function testNonExistingToCurrency()
        {
            $currency = new Currency;
            $amount = 1000;
            $from = 'NOK';
            $to = 'XXX';
            $expected = 'Destination currency not found';

            $result = $currency->convert($amount, $from, $to);

            $this->assertEquals($expected, $result);
        }
    }