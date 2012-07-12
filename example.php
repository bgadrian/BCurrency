<?php

error_reporting(E_ALL);
            
/** DEBUG and TEST **/
require ('bcurrency.class.php');
$b_rates = new BCurrency();

echo '<h1>BTooLs - BNR and Google currency convertors</h1>
    <p>The main function of the class : convert from or to RON, with Romanian National Bank rates.</p>
    <h2>Examples</h2>
    <p>Quick convert 1 EURO to RON</p>';
    
//1EUR in RON 
//is recommeded if you check for erros before you display the result : 
$result = $b_rates->bnr_convert(1);
    echo ' <b>$b_rates->bnr_convert(1);</b>//Result : '.$result;
    if ($result === false)
        echo '<br />Error';
    else
        echo '<br /> 1 EUR : '.$result.'RON';


//150 US$ with 2 decimals
    echo '<br /><b>$b_rates->bnr_convert(150,"USD","RON",2);</b>//Convert 150 USD in RON with 2 decimals ';
echo '<br /> 150 USD : '.$b_rates->bnr_convert(150,'USD','RON',2).'RON';


    echo '<p>Other examples</p>';
//249RON in HUF
echo '249RON : '.$b_rates->bnr_convert(249,'RON','HUF').'HUF';

//100RON in EURO
echo '<br /> 100RON : '.$b_rates->bnr_convert(100,'RON','EUR',3);
      
//wrong currencies
$result = $b_rates->bnr_convert(23,'UFO','RON');
    if ($result === false)
        echo '<br />Error - UFO currency doesn`t exists';
    else
        echo '<br /> 1 EUR : '.$result.'RON';
    
// other BNR related functions
        echo '<br />Supported currencies : '.implode(',',$b_rates->get_bnr_currencies());
        echo '<br />Rates date : '.$b_rates->get_bnr_day();
        echo '<br /> Get a specific rate (CAD) : '.$b_rates->get_bnr_currency('CAD').' ';
        echo '<br /> Show multiple rates .. (USD,CAD,EUR) <code> ';
        print_r($b_rates->get_bnr_currency(array('USD','CAD','EUR'))) ;
        echo '</code>';       
        
        
//using the GOOGLE currency converter
echo '<h2>Google function : </h2> '
.'<br /> 1EUR in USD - google : '.$b_rates->google_convert(1,'EUR','USD')
.'<br /> 1CAD in JPY - google : '.$b_rates->google_convert(1,'CAD','JPY')
.'<br /> 1GBP in CHF - google : '.$b_rates->google_convert(1,'GBP','CHF')
.'<br /> 1RUB in AED - google : '.$b_rates->google_convert(1,'RUB','AED')
;
