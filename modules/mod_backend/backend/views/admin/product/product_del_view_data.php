<?php
use common\template\extend\Button;
use core\Lang;
use core\utils\RequestUtil;
$product = RequestUtil::get ( "product" );
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Delete Product")?></h4>
</div>
<div class="modal-body">
	<form id="del_product_form" class="form-horizontal" novalidate="novalidate">
		<input name="id" type="hidden" value="<?=$product->id?>" />
		<div class="form-body">
			<p><?=Lang::getWithFormat("Are you sure you want to delete the product [{0}]?",$product->name)?></p>
		</div>
	</form>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "btnDelProduct";
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