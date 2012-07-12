<?php

/**
* BTooLs BNR exchange rates, for lei (RON,leu, the Romanian currency).
* If you plan to extensively use this class for your users, be careful BNR could ban your IP,
* You can use the APC option that will cache the XML every hour, so the script will not read the BNR XML 
* every time your page is accesed.
* 
* More about APC : http://devzone.zend.com/article/12618
* 
* 
* requirements : PHP 5.3+ , APC for cache
* Read the BNR feed rules : http://www.bnro.ro/apage.aspx?pid=3424
* 
 * @package    BTooLs
 * @copyright  Copyright (c) 2007 through 2011+, Georgescu Adrian (B3aT)
 * @license    http://www.gnu.org/licenses/gpl.txt     GPL 
 * @author     B.Georgescu Adrian (B3aT) <btools@gmail.com>
 * @version    0.9 2011-08-22 
 * @link       http://btools.eu
 * @source     https://github.com/BTooLs/BCurrency
*/
class BCurrency {
    
  /* the XML url */
  private $url = 'http://www.bnro.ro/nbrfxrates.xml';
  
  /* Cache the exchange rates, you need the PHP APC extension enabled ! */
  private $use_cache = false;        
  private $apc_var_name = 'btools_bnr_rates';
  private $apc_var_ttl = 3600;
    
  /* rate date (the rates refresh every day, at 13:00 GTM+2) */
  private $date = null;
  
  /* the rates , array ('currency'=>array('rate'=>value,'multiplier'=>1), ex 'EUR'=>4.2669*/
  private $rates = array();
    
  /** Functions **/  
  public function __construct()                              
  {                                     
      define('APC_EXTENSION_LOADED', extension_loaded('apc') );
      $this->bnr_refresh();
  }  
  
 /**
 * Shorcut, invoke the function to convert an RON amount to EUR.
 *  
 * @param float $amount
 * @return Float
 */
 public function __invoke($amount)
 {
     return $this->convert($amount);
 } 
 
 
   /** ********************************************************************************************************
    * 
    *                       B N R . RO         F U N C T I O N S
    * 
    ************************************************************************************************************/
    
 
 
  /**
   *  Refresh the rates, load them into the internal array 
   * 
   * @return TRUE on succes, FALSE otherwise
   * */
    public function bnr_refresh()
    {
        

        //first let's check if the data is already cached
        if ($this->use_cache)
            {
                //check the APC
                if (APC_EXTENSION_LOADED === false)
                    {
                        throw new Exception('APC PHP plugin is missing. Disable the cache or install the pluging.',99);
                        return false;
                    }
             //var_dump(apc_cache_info());
              if(apc_exists($this->apc_var_name))
                {
                    $ok = true;
                    $temp = apc_fetch($this->apc_var_name);
                    
                    if ($temp === false OR !is_array($temp))
                        return true;//everything is ok, we took the data from the cache
                    
                    //echo 'FROM CACHE !';
                    $this->rates = $temp;
                }
            }
     
     /** cache is disabled or expired, check the XML  **/
     try {  
        
        //we need the XML class
        $xml = simplexml_load_file($this->url);
        
        //if we can't get the xml ..
        if ($xml === false)
            {
                return FALSE;
            }
        
        //clean old data if exists and add the RON 
        $this->rates = array('RON'=>array('rate'=>1,'multiplier'=>1));
        
        //keep the date
        $temp = $xml->Body->Cube->attributes();
        $this->date = (string)$temp['date'];
        
        //let's load the data
        $list = $xml->Body->Cube->children();
        
        if (empty($list))
            return FALSE;
        
     foreach($list AS $rate)
            {
                $attr = $rate->attributes();
                $this->rates[(string)$attr['currency']] = array(
                    'rate'          => (float)$rate,
                    'multiplier'    => ((isset($attr['multiplier'])) ? (float)$attr['multiplier'] : 1)
                );
                
            }
      
      //debug
      //var_dump($this->rates);  
        
        //if cache is enabled ..store the values in server`s memory
         if ($this->use_cache)
            {
                apc_add($this->apc_var_name,$this->rates,$this->apc_var_ttl);
            }
    
         //the end
         return TRUE;
         
        }
        catch (Exception $e)
        {                
            return FALSE;
        }
    }        
    
  
    /** Convert currencies(from or to RON)
    * @param $amount The amount of money you need to convert (a positive float)
    * @param $currency A short currency name, avaible in the XML 
    * @param $decimals How accurate you need the result.
    * @example convert(23,'EUR',2) //transforms 23 EURO's into LEI, with 2 decimals result
    * @return Float number or FALSE on error.
    **/
    public function bnr_convert($amount,$from_currency='EUR',$to_currency='RON',$decimals=1)
    {
        $amount = (float)$amount;
        $decimals = (int)$decimals;
        
         //if the parameters are wrong ..
        if ($amount<1 OR $decimals < 0 )
            return FALSE;
        //if out is in :)
        if ($from_currency === $to_currency)
            return $amount;
            
            
        //let's check if the currency`s exists
      if (!array_key_exists($from_currency,$this->rates)) return FALSE;
      if (!array_key_exists($to_currency,$this->rates)) return FALSE;
      
        //foreign to foreign currency NOT SUPPORTED  USE GOOGLE function
        if ($from_currency != 'RON' AND $to_currency != 'RON')
            return FALSE;
  
        //foreign TO RON 
        if ($to_currency == 'RON')
        {
            return (round((float)(($amount*$this->rates[$from_currency]['rate'])/$this->rates[$from_currency]['multiplier']),$decimals));
        }
      
        //RON TO foreign
        if ($from_currency == 'RON')
        {
            return (round((float)(($amount/$this->rates[$to_currency]['rate'])*$this->rates[$to_currency]['multiplier']),$decimals));
        }
        
        return FALSE;//something is wrong
    }
    
    /**
    * Returns the date which the rates are for.
    * 
    */
    public function get_bnr_day()
        {
            return $this->date;
        }
   
   /** 
   * Returns an array with the supported BNR currencies.
   * 
   */
    public function get_bnr_currencies()
    {
        return array_keys($this->rates);
    } 
    
    
    /**
    * Returns a single (or multiple, if the parameter is array) currency.
    * Be careful, this function doesn't take into consideration the currencies with multiplier !
    * 
    * @param mixed $currency
    * @example   get_bnr_currency('USD');//result 2.3
    *            get_bnr_currency(array('USD','EUR')); //results array('USD'=>2.3,'EUR'=>3,1)
    */
    public function get_bnr_currency($currency,$decimals=2)
    {
        $decimals = (int)$decimals;
        
        if (is_array($currency))
            {
                $result = array();
                foreach($currency AS $c)
                    {
                        //if the currency exists ..
                         if (isset($this->rates[$c]))
                            $result[$c] = round($this->rates[$c]['rate'],$decimals);
                        else
                            $result[$c] = 0;
                    }
                return $result;
            }
        
        //else, $currency is string..return simple value
        if (is_string($currency) AND isset($this->rates[$currency]))
            return round($this->rates[$currency]['rate'],$decimals);
        else
            return FALSE;
    }
    
    
    /** ********************************************************************************************************
    * 
    *                       G  O  O  G  L  E   F U N C T I O N S
    * 
    ************************************************************************************************************/
    
    
    /**
    * Use the google currency convertor !
    * 
    * @param float $amount
    * @param string $from_currency
    * @param string $to_currency
    * @param int $decimals
    * @return float or false (bool)
    */
    public function google_convert($amount,$from_currency,$to_currency,$decimals=1)
    {
        
        $url = "http://www.google.com/finance/converter?a=$amount&from=$from_currency&to=$to_currency";
        
        $file = file_get_contents($url);
       // var_dump($file);
        
        //find the result in "<span class=bld>"
        preg_match_all("'<span class=bld>(.*?) ".$to_currency."</span>'",$file,$matches);
        
        //var_dump($matches[1][0]);
        if (isset($matches[1][0]))
            return round((float)$matches[1][0],$decimals);
        else
            return FALSE;
    }
    
}     
return;