<?php
use common\template\extend\Button;
use core\Lang;
?>
<div class="row">
	<div class="col-md-12">
		<?php include_once 'bulk_discount_add_res_data.php';?>
	</div>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "btnAddBulkDiscount";
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