<?php
use common\template\extend\FormContainer;
use common\template\extend\Select;
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\RequestUtil;

$subscriber = RequestUtil::get ( "subscriber" );

$form = new FormContainer ();
$form->id = "edit_subscriber_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<input type="hidden" id="id" name="subscriber[id]" value="<?=$subscriber->id ?>" />
	<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "subscriber[email]" );
	$text->hasError = RequestUtil::isFieldError ( "subscriber[email]" );
	$text->label = Lang::get ( "Email" );
	$text->required = true;
	$text->readonly = true;
	$text->name = "subscriber[email]";
	$text->value = $subscriber->email;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "subscriber[firstName]" );
	$text->hasError = RequestUtil::isFieldError ( "subscriber[firstName]" );
	$text->label = Lang::get ( "First Name" );
	$text->required = false;
	$text->name = "subscriber[firstName]";
	$text->value = $subscriber->firstName;
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "subscriber[lastName]" );
	$text->hasError = RequestUtil::isFieldError ( "subscriber[lastName]" );
	$text->label = Lang::get ( "Last Name" );
	$text->required = false;
	$text->name = "subscriber[lastName]";
	$text->value = $subscriber->lastName;
	$text->render ();
	
	$select = new SelectInput ();
	$select->value = $subscriber->status;
	$select->name = "subscriber[status]";
	$select->collections = ApplicationConfig::get ( "common.status.list" );
	$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
	$select->label = Lang::get ( "Status" );
	$select->errorMessage = RequestUtil::getFieldError ( "subscriber[status]" );
	$select->hasError = RequestUtil::isFieldError ( "subscriber[status]" );
	$select->required = true;
	$select->render ();
	?>
</div>
<?php $form->renderEnd ();?>
<script type="text/javascript">
	$(document).ready(function(){
		$("input.numberic-float").autoNumeric('init');
	});
</script>