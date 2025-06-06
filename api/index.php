<?php
/**
 * Measure converter API
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0, March 2022
 *          2.0, August 2022    The currency class provides the currency list
 *                              The base currency is provided only when converting
 *          2.1, September 2022 Input checks introduced for POST parameters
 */

    define('BASE_PATH', '../src/');
    define('ERROR_MSG', 'Error: incorrect API call');

    foreach ($_POST as $key => $value) {
        $_POST[$key] = filter_var(htmlspecialchars($value), FILTER_SANITIZE_SPECIAL_CHARS);
    }

    if (!empty($_POST['conversion'])) {
        $conversion = $_POST['conversion'];

        switch ($conversion) {
            case 'length':
                if (!isset($_POST['measure']) || !isset($_POST['system'])) {
                    echo json_encode(ERROR_MSG);
                } else {
                    require_once BASE_PATH . 'length.php';
                    
                    try {
                        $length = new Length($_POST['measure'], $_POST['system']);                    
                        echo json_encode($length->convert());
                    } catch (Exception $e) {
                        echo json_encode($e->getMessage());
                    }
                }
                break;
            case 'temperature':
                if (!isset($_POST['measure']) || !isset($_POST['originScale'])) {
                    echo json_encode(ERROR_MSG);
                } else {
                    require_once BASE_PATH . 'temperature.php';

                    try {
                        $temperature = new Temperature($_POST['measure'], $_POST['originScale']);
                        echo json_encode($temperature->convert($_POST['destinationScale']));
                    } catch (Exception $e) {
                        echo json_encode($e->getMessage());
                    }
                }
                break;
            case 'currency':
                if (!isset($_POST['action'])) {
                    echo json_encode(ERROR_MSG);
                } else {
                    require_once BASE_PATH . 'currency.php';

                    $currency = new Currency();

                    if (!empty($_POST['action'])) {
                        $action = $_POST['action'];

                        switch($action) {
                            case 'getCurrencyList':
                                echo json_encode($currency->getCurrencies());
                                break;
                            case 'convert':
                                if (!isset($_POST['measure']) || !isset($_POST['baseCurrency']) || !isset($_POST['destinationCurrency'])) {
                                    echo json_encode(ERROR_MSG);
                                } else {
                                    echo json_encode($currency->convert($_POST['measure'], $_POST['baseCurrency'], $_POST['destinationCurrency']));
                                }
                                break;
                        }
                    } 
                }
                break;
            case 'grading':
                if (!isset($_POST['measure']) || !isset($_POST['country'])) {
                    echo json_encode(ERROR_MSG);
                } else {
                    require_once BASE_PATH . 'grade.php';

                    $grade = new Grade();
                    echo $grade->convert($_POST['measure'], $_POST['country']);
                }
                break;
        }
    }
?>