<?php
use common\template\extend\Button;
use common\template\extend\FormContainer;
use core\Lang;
use core\utils\RequestUtil;
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("List file slide error")?></h4>
</div>
<div class="modal-body">
	<?php
	$form = new FormContainer ();
	$form->id = "taxRateAddFormId";
	$form->attributes = 'class="form-horizontal" ';
	
	$form->renderStart ();
	?>
	<div class="form-body">

		<div class="alert alert-danger" role="alert">
		<h3><?=Lang::get("There are some files has already existed, are you overide all?")?></h3>
			<p><?= str_replace("\n", "<br/>", RequestUtil::getErrorMessage ())?></p>
		</div>
	</div>
<?php $form->renderEnd(); ?>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "btnSubmitSlide";
	$button->title = " " . Lang::get ( "Yes" );
	$button->class = "btn btn-sm blue margin-bottom-5";
	$button->attributes = "";
	$button->render ();
	
	$button = new Button ();
	$button->type = "button";
	$button->id = "";
	$button->title = " " . Lang::get ( "No" );
	$button->class = "btn btn-sm btn-close margin-bottom-5";
	$button->attributes = "data-dismiss=\"modal\"";
	$button->render ();
	?>
</div>
