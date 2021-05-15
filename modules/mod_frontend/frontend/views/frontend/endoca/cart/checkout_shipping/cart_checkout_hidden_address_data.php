<?php
use core\utils\RequestUtil;
use common\template\extend\Text;
$address = RequestUtil::get("address");

$text = new Text();
$text->id = "hidAddressId";
$text->name = "address[id]";
$text->type = "hidden";
$text->value = $address->id;
$text->render();
?>
