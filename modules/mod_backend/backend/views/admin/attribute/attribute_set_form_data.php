<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;
$attributeVo= RequestUtil::get("attributeVo");

?>
<div id="formSetAttributeId">
<?php

//include "product/product_attribute_data.php";

$text = new Text();
$text->name = "attributeVo[id]";
$text->value = $attributeVo->id;
$text->type = "hidden";
$text->render();

$text = new Text();
$text->name = "productId";
$text->value = RequestUtil::get("productId");
$text->type = "hidden";
$text->render();

echo  Lang::get("You have set again price for attribute, are you sure?");

?>
</div>