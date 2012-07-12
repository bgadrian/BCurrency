BCurrency
=========

BTooLs PHP class wrapper for Google currency convertor (all currencies) and BNR exchange rates (RON)

# Google currency convertor

The class can be used as a wrapper for google online convertor. It has a very fast method of calling the finance convertor API !
I saw some other convertors that uses the organic search and do tons of preg matches, don't do that, BCurrency has only one fast preg match and its NOT using curl.

# BNR.ro RON convertor

The main part of the class is used to work with the BNR (National Bank of Romania) currency rates.
The class can use PHP APC extension to store the BNR data (xml), best used for public convertors, this way your IP will not get banned by BNR.ro (too many requests).


## Usage
* use it to allow your visitors or clients to freely convert currencies (ex using AJAX requests)
* use it on your eCommerce / shop to automatically display prices in more currencies with the current rates
* update product prices periodically
* make a web form to upload a CSV product list and update or create new currencies fields
* ... your imagination is the limit ...

### Notes
* the class was made to automatically update an eCommerce database at regular intervals using a cronjob
* new features will be made ONLY if more people requests them
* how to use the PHP class and examples in "example.php"

## About
 * version 0.9 - 2011-08-22
 * since 01.08.2011
 * author B.G.Adrian
 * website http://btools.eu
 * license MIT License
 * source https://github.com/BTooLs/BCurrency
 
 ## Currencies supported
 Google supports the following currencies : United Arab Emirates Dirham (AED), Netherlands Antillean Guilder (ANG), Argentine Peso (ARS), Australian Dollar (AUD), Bangladeshi Taka (BDT), Bulgarian Lev (BGN), Bahraini Dinar (BHD), Brunei Dollar (BND), Bolivian Boliviano (BOB), Brazilian Real (BRL), Botswanan Pula (BWP), Canadian Dollar (CAD), Swiss Franc (CHF), Chilean Peso (CLP), Chinese Yuan (CNY), Colombian Peso (COP), Costa Rican Colón (CRC), Czech Republic Koruna (CZK), Danish Krone (DKK), Dominican Peso (DOP), Algerian Dinar (DZD), Estonian Kroon (EEK), Egyptian Pound (EGP), Euro (EUR), Fijian Dollar (FJD), British Pound Sterling (GBP), Hong Kong Dollar (HKD), Honduran Lempira (HNL), Croatian Kuna (HRK), Hungarian Forint (HUF), Indonesian Rupiah (IDR), Israeli New Sheqel (ILS), Indian Rupee (INR), Jamaican Dollar (JMD), Jordanian Dinar (JOD), Japanese Yen (JPY), Kenyan Shilling (KES), South Korean Won (KRW), Kuwaiti Dinar (KWD), Cayman Islands Dollar (KYD), Kazakhstani Tenge (KZT), Lebanese Pound (LBP), Sri Lankan Rupee (LKR), Lithuanian Litas (LTL), Latvian Lats (LVL), Moroccan Dirham (MAD), Moldovan Leu (MDL), Macedonian Denar (MKD), Mauritian Rupee (MUR), Maldivian Rufiyaa (MVR), Mexican Peso (MXN), Malaysian Ringgit (MYR), Namibian Dollar (NAD), Nigerian Naira (NGN), Nicaraguan Córdoba (NIO), Norwegian Krone (NOK), Nepalese Rupee (NPR), New Zealand Dollar (NZD), Omani Rial (OMR), Peruvian Nuevo Sol (PEN), Papua New Guinean Kina (PGK), Philippine Peso (PHP), Pakistani Rupee (PKR), Polish Zloty (PLN), Paraguayan Guarani (PYG), Qatari Rial (QAR), Romanian Leu (RON), Serbian Dinar (RSD), Russian Ruble (RUB), Saudi Riyal (SAR), Seychellois Rupee (SCR), Swedish Krona (SEK), Singapore Dollar (SGD), Slovak Koruna (SKK), Sierra Leonean Leone (SLL), Salvadoran Colón (SVC), Thai Baht (THB), Tunisian Dinar (TND), Turkish Lira (TRY), Trinidad and Tobago Dollar (TTD), New Taiwan Dollar (TWD), Tanzanian Shilling (TZS), Ukrainian Hryvnia (UAH), Ugandan Shilling (UGX), US Dollar (USD), Uruguayan Peso (UYU), Uzbekistan Som (UZS), Venezuelan Bolívar (VEF), Vietnamese Dong (VND), CFA Franc BCEAO (XOF), Yemeni Rial (YER), South African Rand (ZAR), Zambian Kwacha (ZMK)