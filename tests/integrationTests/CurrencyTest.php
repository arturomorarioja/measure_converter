<?php
/**
 * Integration tests for currency conversion.
 * Components tested:
 * - Currency class
 * - Currency API curencyapi.com
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0.0 March 2023
 */

    require_once 'src/currency.php';

    use PHPUnit\Framework\TestCase;

    class CurrencyTest extends TestCase
    {
        private Currency $currency;

        protected function setUp(): void
        {
            $this->currency = new Currency;
        }

        protected function tearDown(): void
        {
            unset($this->currency);
        }

        public function testGetCurrencies(): void 
        {
            $result = $this->currency->getCurrencies();

            $this->assertIsArray($result);
        }

        /**
         * @dataProvider ConvertNoCurrencies
         */
        public function testConvertNoCurrencies($amount) 
        {
            $result = $this->currency->convert($amount);

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
            $result = $this->currency->convert($amount, $from);

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
            $result = $this->currency->convert($amount, $from, $to);

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
            $amount = 1000;
            $from = 'XXX';
            $to = 'USD';
            $expected = 'Validation error';

            $result = $this->currency->convert($amount, $from, $to);

            $this->assertEquals($expected, $result);
        }
        public function testNonExistingToCurrency()
        {
            $amount = 1000;
            $from = 'NOK';
            $to = 'XXX';
            $expected = 'Destination currency not found';

            $result = $this->currency->convert($amount, $from, $to);

            $this->assertEquals($expected, $result);
        }
    }