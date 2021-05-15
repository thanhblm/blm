<?php
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\Button;
$templateVo = RequestUtil::get ( "templateVo" );
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Delete template")?></h4>
</div>
<div class="modal-body">
	<form id="del_template_form" class="form-horizontal" novalidate="novalidate">
		<input name="templateId" type="hidden" value="<?=$templateVo->id?>" />
		<div class="form-body">
			<p><?=Lang::getWithFormat("Are you sure you want to delete template <b>{0}</b>?",$templateVo->name)?></p>
		</div>
	</form>
</div>
<div class="modal-footer">
	<?php
	$button = new Button ();
	$button->type = "button";
	$button->id = "btnDel";
	$button->class = "";
	$button->title = Lang::get ( "Yes" );
	$button->attributes = "btn green";
	$button->render ();
	
	$button = new Button ();
	$button->type = "button";
	$button->title = Lang::get ( "No" );
	$button->class = "btn dark";
	$button->attributes = "data-dismiss=\"modal\"";
	$button->render ();
	?>
</div>