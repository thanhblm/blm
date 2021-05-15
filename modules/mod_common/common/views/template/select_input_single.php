<?php
use core\template\html\base\BaseSelect;
use core\utils\AppUtil;
$hasErrorStr = $hasError ? "border-red font-red" : "";
$str = ! empty ( $class ) ? "class='$class $hasErrorStr'" : "class = 'form-control input-sm $hasErrorStr'";
$select = new BaseSelect();
AppUtil::copyProperties($sourceElement, $select);
$select->attributes = $select->attributes . " " . $str;
echo $prepend;
$select->render ();
echo $append;
?>