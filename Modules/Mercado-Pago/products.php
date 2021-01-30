<!--

 * This file is part of a JoyGDR project
 *
 * Copyright (c) JoyGDR
 * https://github.com/lincolnjota
 */

-->
<?php 
require("vendor/autoload.php");
$config = include('config.php');

MercadoPago\SDK::setAccessToken($config->acsstoken);

//Instance object preference
$preferenceItemOne = new MercadoPago\Preference();

// Create Item
$itemOne = new MercadoPago\Item();
$itemOne->title = 'VipTest'; //Here, the same name you placed in the config.yml file in minecraft must be entered. 
$itemOne->quantity = 1; // 1 is sufficient (because it is individual). 
$itemOne->unit_price = 20.00; // Set price for your vip.
$preferenceItemOne->items = array($itemOne);
$preferenceItemOne->save();



// | Uncomment these lines below and duplicate as much as you want. |


/*

$preferenceItemTwo = new MercadoPago\Preference();

// Create Item
$itemTwo = new MercadoPago\Item();
$itemTwo->title = 'VipOne';
$itemTwo->quantity = 1;
$itemTwo->unit_price = 20.00;
$preferenceItemTwo->items = array($itemTwo);
$preferenceItemTwo->save();

*/
?>