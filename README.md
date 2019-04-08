# MicroSMS-API
UnOfficial API Class for MicroSMS payments

## Requirements
* PHP 5.6+

### Composer

Inside of `composer.json` specify the following:

``` json
{
  "require": {
    "matix8981/microsms_api": "dev-master"
  }
}
```

### Simple usage for SMS Premium Payment
*Checking the SMS code on many numbers*
``` php
    require_once("vendor/autoload.php");
    $settings =
    [
        "clientID" => 1234,
        "serviceID" => 1234,
    ];

    try
    {
        $api = new Matix8981\Payments\MicroSMS\SMS($settings["clientID"], $settings["serviceID"]);
        /**
         * Example return
         * array(2) { ["connect"]=> bool(true) ["data"]=> array(6) { ["status"]=> int(1) ["used"]=> NULL ["service"]=> string(4) "6205" ["number"]=> string(5) "92550" ["phone"]=> string(11) "48123456789" ["reply"]=> string(69) "Twoj kod dostepu to: XYZ. Dziekujemy za zakupy w naszym sklepie." } } 
        */
        $api->ValidateMulti($_GET["code"]);
        /**
         * Example format return
         * array(6) { ["status"]=> bool(true) ["used"]=> bool(false) ["service"]=> string(4) "6205" ["number"]=> string(5) "92550" ["phone"]=> string(11) "48123456789" ["reply"]=> string(69) "Twoj kod dostepu to: XYZ. Dziekujemy za zakupy w naszym sklepie." } 
        */
        $api->ValidateResult();
    }
    catch(Exception $error)
    {
        echo "Error: ".$error->getMessage();
    }
?>
```

*Checking the SMS code on single number*
``` php
    require_once("vendor/autoload.php");
    $settings =
    [
        "clientID" => 1234,
        "serviceID" => 1234,
    ];

    try
    {
        $api = new Matix8981\Payments\MicroSMS\SMS($settings["clientID"], $settings["serviceID"]);
        /**
         * Example return
         * array(2) { ["connect"]=> bool(true) ["data"]=> array(5) { ["status"]=> int(1) ["service"]=> string(4) "6205" ["number"]=> string(5) "92550" ["phone"]=> string(11) "48123456789" ["reply"]=> string(69) "Twoj kod dostepu to: XYZ. Dziekujemy za zakupy w naszym sklepie." } }
        */
        $api->ValidateSingle($_GET["code"], $_GET["number"]);
        /**
         * Example format return
         * array(6) { ["status"]=> bool(true) ["used"]=> bool(false) ["service"]=> string(4) "6205" ["number"]=> string(5) "92550" ["phone"]=> string(11) "48123456789" ["reply"]=> string(69) "Twoj kod dostepu to: XYZ. Dziekujemy za zakupy w naszym sklepie." } 
        */
        $api->ValidateResult();
    }
    catch(Exception $error)
    {
        echo "Error: ".$error->getMessage();
    }
?>
```
