<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
$batchGroupMo = RequestUtil::get ( "batchGroupMo" );
$form = new FormContainer ();
$form->id = "batchGroupAddFormId";

$form->attributes = 'class="form-horizontal" enctype="multipart/form-data" method="post"';

$form->renderStart ();
?>
<div class="form-body">
<?php
$text = new TextInput ();
$text->errorMessage = RequestUtil::getFieldError ( "batchGroupMo[name]" );
$text->hasError = RequestUtil::isFieldError ( "batchGroupMo[name]" );
$text->label = Lang::get ( "Name" );
$text->required = true;
$text->name = "batchGroupMo[name]";
$text->value = $batchGroupMo->name ;
$text->render ();

$text = new Text ();
$text->type = "hidden";
$text->value = $batchGroupMo->id;
$text->name = "batchGroupOldId";
$text->render ();

?>
<h3><?=Lang::getWithFormat("All Batchs in Group {0} will copy to new Group", $batchGroupMo->name) ?> </h3>
</div>
<?php $form->renderEnd(); ?>
