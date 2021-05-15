<?php 

use core\utils\AppUtil;
use core\template\html\base\BaseText;

$appendAttribute = ! empty ( $class ) ? "class='$class'" : "class = 'form-control form-filter input-sm'";
$appendAttribute .= " ".(! empty ( $placeholder ) ? "placeholder=\"$placeholder\"" : "");
$text = new BaseText();
AppUtil::copyProperties($sourceElement, $text);
$text->attributes .= " " . $appendAttribute;
$text->render();
?>


