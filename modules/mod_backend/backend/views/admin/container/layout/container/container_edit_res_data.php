<?php
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

// get data
$containerVo = RequestUtil::get ( "containerVo" );

$form = new FormContainer ();
$form->id = "container_edit_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<?php
	// containerId
	echo "<input type='hidden' name='containerVo[id]' value='{$containerVo->id}'>";
	
	$text = new TextInput ();
	$text->label = Lang::get ( "Custom class" );
	$text->name = "containerVo[class]";
	$text->value = $containerVo->class;
	$text->render ();
	?>
</div>
<?php $form->renderEnd ();?>