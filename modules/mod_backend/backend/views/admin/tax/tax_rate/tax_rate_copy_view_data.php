<?php
use common\template\extend\Button;
use core\Lang;
use core\utils\RequestUtil;

$taxRate = RequestUtil::get ( "taxRate" );
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::getWithFormat("Clone tax rate {0}", $taxRate->name)?></h4>
</div>
<div class="modal-body">
	<?php include_once 'tax_rate_copy_form_data.php'; ?>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "btnSubmit";
	$button->title = " " . Lang::get ( "Save" );
	$button->class = "btn btn-sm blue margin-bottom-5";
	$button->attributes = "";
	$button->render ();
	
	$button = new Button ();
	$button->type = "button";
	$button->id = "";
	$button->title = " " . Lang::get ( "Cancel" );
	$button->class = "btn btn-sm btn-close margin-bottom-5";
	$button->attributes = "data-dismiss=\"modal\"";
	$button->render ();
	?>
</div>


