<?php
use common\template\extend\Text;
use core\utils\AppUtil;
$hasErrorStr = $hasError ? "border-red font-red" : "";
$text = new Text();
AppUtil::copyProperties($sourceElement, $text);
$text->class = (empty($class) ? "form-control input-sm" : $class) . " ". $hasErrorStr;
$text->attributes = $text->attributes . ' aria-required="true" aria-describedby="name-error" aria-invalid="false" data-required="1"';
if ($readonly) {
	$text->attributes = $text->attributes . " readonly ";
}
if ($required) {    //taipv
	$text->attributes = $text->attributes . " required='required'";
}
echo $prepend;
$text->render();
echo $append;
?>