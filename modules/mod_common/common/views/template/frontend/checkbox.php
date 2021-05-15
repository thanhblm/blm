<?php 

use core\utils\AppUtil;
use core\template\html\base\BaseCheckBox;

$appendAttribute = ! empty ( $class ) ? "class='$class'" : "class = ''";
$checkbox = new BaseCheckBox();
AppUtil::copyProperties($sourceElement, $checkbox);
$checkbox->attributes .= " " . $appendAttribute;
$checkbox->render();
?>
