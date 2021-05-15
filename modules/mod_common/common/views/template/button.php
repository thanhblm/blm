<?php
use core\template\html\base\BaseButton;
use core\utils\AppUtil;

$defClass = 'btn btn-sm blue margin-bottom-5 margin-top-5';
$applyClass = empty ( $class ) ? $defClass : $class;
$applyClass = empty ( $extraClass ) ? $applyClass : $applyClass . " " . $extraClass;
$appendTitle = ! empty ( $icon ) ? $icon : "";
$button = new BaseButton ();
AppUtil::copyProperties ( $sourceElement, $button );
$button->attributes .= " class='" . $applyClass . "'";
$button->title = $appendTitle . " " . $button->title;
$button->render ();
?>