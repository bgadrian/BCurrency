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