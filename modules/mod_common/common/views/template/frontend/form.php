<?php
use core\template\html\base\BaseForm;
use core\utils\AppUtil;

$form = new BaseForm ();
AppUtil::copyProperties ( $sourceElement, $form );
$form->render ();
?>