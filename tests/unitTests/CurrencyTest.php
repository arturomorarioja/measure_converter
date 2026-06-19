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

    // This test is useless. 
    // It only tests that the empty array we hardcoded is, in fact, an array.
    // Do never implement mocking as part of a recipe one follows.
    // Test relevance must be assessed based on the value the test brings.

    public function testGetCurrencies(): void
    {
        $this->currency->method('getCurrencies')
                 ->willReturn([]);

        $result = $this->currency->getCurrencies();
        $this->assertIsArray($result);
    }

    // The following test is even more dangerous than the previous one,
    // since it apparently tests with different values,
    // but only their data type is asserted.
    // Anyway, the actual return value is hardcoded (a zero).
    // Since 0 is numeric, the test always passes, 
    // but tests nothing in the actual system

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

    // Horrible test. Same as the previous one.

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

    // Same.

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

    // Two more bad tests.
    // Again they assess hardcoded values.

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