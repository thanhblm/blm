<?php 

use core\template\html\base\BaseButton;
use core\utils\AppUtil;
?>
<div class="_field">
<?php
$appendAttribute = ! empty ( $class ) ? "class='$class'" : "";
$appendTitle =  ! empty ( $icon ) ? $icon : "";
$button = new BaseButton();
AppUtil::copyProperties($sourceElement, $button);
$button->attributes .= " " . $appendAttribute;
$button->title = $appendTitle." ".$button->title;
$button->render();
?>
</div>
