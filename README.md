# Measure converter

## Purpose
Sample application to demonstrate basic concepts of object-oriented programming, unit testing, and integration testing.

It allows conversions between the following measure systems:
- Length: between metric and imperial
- Temperature: between Celsius, Fahrenheit, and Kelvin
- Currency: between all currencies at https://currencyapi.com/
- Academic grades: between the Danish and American systems

## Installation

1. A file `info/info.php` must be created with the following content:

```php
<?php

class apiKey {
    public const CURRENCY_API_KEY = '<API key provided by https://currencyapi.com/>';
}
```

2. The script `db/converter.sql` for the MariaDB/MySQL database `converter` must be installed.

## Tools
PHP8 / MariaDB / JQuery / JavaScript / CSS3 / HTML5

## Author
Arturo Mora-Rioja (amri@kea.dk)