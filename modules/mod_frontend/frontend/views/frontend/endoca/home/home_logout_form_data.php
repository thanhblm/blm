<?php
use core\Lang;
use common\template\extend\FormContainer;

$form = new FormContainer();
$form->id = "formLogoutId";
$form->attributes = 'class="_register"';
$form->renderStart();
?>
<div class="_form">
    <h2 style="margin-bottom: 30px"><?= Lang::get("Are you sure you want to logout?") ?></h2>
</div>
<?php $form->renderEnd(); ?>
