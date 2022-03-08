<?php
/**
 * Measure converter API
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0, March 2022
 * 
 * PENDING  Input checks on POST variables
 */

    if (!empty($_POST['conversion'])) {
        $conversion = $_POST['conversion'];

        switch ($conversion) {
            case 'length':
                require_once '../src/length.php';

                $length = new Length($_POST['measure'], $_POST['system']);
                echo json_encode($length->convert());

                break;
            case 'temperature':
                require_once '../src/temperature.php';

                $temperature = new Temperature($_POST['measure'], $_POST['originScale']);
                echo json_encode($temperature->convert($_POST['destinationScale']));

                break;
            case 'currency':
                require_once '../src/currency.php';

                $currency = new Currency($_POST['baseCurrency']);
                echo json_encode($currency->convert($_POST['measure'], $_POST['destinationCurrency']));

                break;
            case 'grading':
                require_once '../src/grade.php';

                $grade = new Grade();
                echo $grade->convert($_POST['measure'], $_POST['country']);

                break;
        }

    }

?>