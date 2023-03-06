<?php

require_once 'src/currency.php';

use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function testGetCurrencies(): void
    {
        $currency = $this->createStub(Currency::class);
        $currency->method('getCurrencies')
                 ->willReturn([]);

        $result = $currency->getCurrencies();
        $this->assertIsArray($result);
    }
}