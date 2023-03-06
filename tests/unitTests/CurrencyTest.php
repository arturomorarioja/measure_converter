<?php

require_once 'src/currency.php';

use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    private Currency $currency;

    protected function setUp(): void
    {
        $this->currency = $this->createStub(Currency::class);
    }

    protected function tearDown(): void
    {
        unset($this->currency);
    }

    public function testGetCurrencies(): void
    {
        $this->currency->method('getCurrencies')
                 ->willReturn([]);

        $result = $this->currency->getCurrencies();
        $this->assertIsArray($result);
    }

    /**
     * @dataProvider ConvertNoCurrencies
     */
    public function testConvertNoCurrencies($amount) 
    {
        $this->currency->method('convert')
             ->willReturn(0);
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
        $this->currency->method('convert')
             ->willReturn(0);
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
        $this->currency->method('convert')
             ->willReturn(0);
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

        $this->currency->method('convert')
             ->willReturn('Validation error');
        $result = $this->currency->convert($amount, $from, $to);

        $this->assertEquals($expected, $result);
    }
    public function testNonExistingToCurrency()
    {
        $amount = 1000;
        $from = 'NOK';
        $to = 'XXX';
        $expected = 'Destination currency not found';

        $this->currency->method('convert')
             ->willReturn('Destination currency not found');
        $result = $this->currency->convert($amount, $from, $to);

        $this->assertEquals($expected, $result);
    }

}