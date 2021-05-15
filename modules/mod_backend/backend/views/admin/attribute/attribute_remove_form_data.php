<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;
$attributeVo= RequestUtil::get("attributeVo");

?>
<div id="formRemoveId">
<?php
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

echo  Lang::getWithFormat("Are you sure you want to remove attribute {0} of product {1}?",  $attributeVo->name, RequestUtil::get("productId"));

?>
</div>