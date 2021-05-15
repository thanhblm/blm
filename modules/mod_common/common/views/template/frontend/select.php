<?php
use core\template\html\base\BaseSelect;
use core\utils\AppUtil;

$str = ! empty ( $class ) ? "class='$class'" : "class = 'form-control input-sm input-inline'";
$select = new BaseSelect();
AppUtil::copyProperties($sourceElement, $select);
$select->attributes = $select->attributes . " " . $str;
$select->render();
?>



