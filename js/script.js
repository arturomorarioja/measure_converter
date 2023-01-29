/* eslint-disable no-undef */
'use strict';
$(function() {

    const API_URL = 'api/index.php';

    //  Navigation menu

    $('nav > ul > li').click(function() {
        $('nav > ul > li').each(function() {
            $(this).removeClass('selected');
            $('#section' + $(this).attr('id').substring(4)).removeClass('visible');
        });
        $(this).addClass('selected');                       

        const currentSection = $('#section' + $(this).attr('id').substring(4));
        currentSection.addClass('visible');
        currentSection.find('input[type="text"]:eq(0)').focus();
    });    

    //  Length

    $('#sectionLength > form').on('submit', function(e) {
        e.preventDefault();
        const measure = $('#txtLength').val();
        const system = $('[name="radLengthSystem"]:checked').val();
        
        $.ajax({
            url: API_URL,
            method: 'POST',
            data: {
                'conversion': 'length',
                'measure': measure,
                'system': system
            }
        }).done(function(result) {
            const text = measure + (system === 'M' ? ' centimeters' : ' inches') + ' is ' + result + (system === 'M' ? ' inches' : ' centimeters');

            $('#sectionLength > div').text(text);
        });
    });

    //  Temperature

    $('#sectionTemperature > form').on('submit', function(e) {
        e.preventDefault();
        const measure = $('#txtTemperature').val();
        const from = $('#lstFrom').val();
        const to = $('#lstTo').val();

        $.ajax({
            url: API_URL,
            method: 'POST',
            data: {
                'conversion': 'temperature',
                'measure': measure,
                'originScale': from,
                'destinationScale': to
            }
        }).done(function(result) {
            const text = `${measure} &deg;${from} is ${result} &deg;${to}`;

            $('#sectionTemperature > div').html(text);
        });
    });

    //  Currency

    $.ajax({
        url: API_URL,
        method: 'POST',
        data: {
            'conversion': 'currency',
            'action': 'getCurrencyList'
        }
    }).done(function(result) {
        result = JSON.parse(result);
        // eslint-disable-next-line no-unused-vars
        for (const [key, value] of Object.entries(result)) {
            $('#cmbFrom').append($('<option>').val(value[0]).text(value[0] + ' - ' + value[1]));
            $('#cmbTo').append($('<option>').val(value[0]).text(value[0] + ' - ' + value[1]));
        }
        // Default values
        $('#cmbFrom > option[value="DKK"]').attr('selected', true);
        $('#cmbTo > option[value="EUR"]').attr('selected', true);
    });

    $('#sectionCurrency > form').on('submit', function(e) {
        e.preventDefault();
        const measure = $('#txtCurrency').val();
        const from = $('#cmbFrom').val();
        const to = $('#cmbTo').val();

        $.ajax({
            url: API_URL,
            method: 'POST',
            data: {
                'conversion': 'currency',
                'action': 'convert',
                'measure': measure,
                'baseCurrency': from,
                'destinationCurrency': to
            }
        }).done(function(result) {
            const text = `${measure} ${from} is ${result} ${to}`;

            $('#sectionCurrency > div').text(text);
        });
    });

    //  Grading population

    $('[name="radGradingSystem"]').on('change', function() {
        if ($('[name="radGradingSystem"]:checked').val() === 'Denmark') {
            $('#cmbGrade').html(`
                <option value="12" selected>12</option>
                <option value="10">10</option>
                <option value="7">7</option>
                <option value="4">4</option>
                <option value="02">02</option>
                <option value="00">00</option>
                <option value="-3">-3</option>
            `);
        } else {
            $('#cmbGrade').html(`
                <option value="A+" selected>A+</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="F">F</option>
            `);
        }
    });

    //  Grading

    $('#sectionGrading > form').on('submit', function(e) {
        e.preventDefault();
        const measure = $('#cmbGrade').val();
        const country = $('[name="radGradingSystem"]:checked').val();

        $.ajax({
            url: API_URL,
            method: 'POST',
            data: {
                'conversion': 'grading',
                'measure': measure,
                'country': country
            }
        }).done(function(result) {
            let text = `${measure} in ${country} is ${result} in `;
            text += (country === 'Denmark' ? 'USA' : 'Denmark');

            $('#sectionGrading > div').text(text);
        });
    });

    $('nav > ul > li#menuLength').click();
    $('[name="radGradingSystem"]').change();
});