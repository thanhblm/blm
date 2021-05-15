<?php
use common\template\extend\Button;
use core\Lang;
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">
		<?=Lang::get("Add grid")?>
	</h4>
</div>
<div class="modal-body">
	<?php include_once 'grid_add_res_data.php'; ?>
</div>
<div class="modal-footer">
	<?php
	$button = new Button ();
	$button->type = "button";
	$button->id = "btnSave";
	$button->title = " " . Lang::get ( "Save" );
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