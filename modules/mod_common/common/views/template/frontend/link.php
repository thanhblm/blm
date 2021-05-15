<?php 

use core\utils\AppUtil;
use core\template\html\base\BaseLink;

$appendAttribute = ! empty ( $class ) ? "class='$class'" : "class = ''";
$link = new BaseLink();
AppUtil::copyProperties($sourceElement, $link);
$link->attributes .= " " . $appendAttribute;
$link->render();
?>

