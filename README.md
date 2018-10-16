# MicroSMS-API
UnOffical API Class for MicroSMS payments

## Requirements
* PHP 5.6+

### Composer

Inside of `composer.json` specify the following:

``` json
{
  "require": {
    "matix8981/microsms-api": "dev-master"
  }
}
```

### Simple usage for SMS Premium Payment

``` php
<?php
// Load Composer
require "vendor/autoload.php";

try
{
	$api = new MicroSMS-API("userID");
  $api->checkSMS(array(
    "serviceid" => "serviceID",
    "code" =>	"SMSCODE",
	));
	
}
catch(Exception $error)
{
	echo	'Error:	'	.$error->getMessage();
}
?>
```
