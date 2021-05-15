<?php 
use core\Lang;
use common\template\extend\Button;
use common\helper\PermissionHelper;
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Access Denied")?></h4>
</div>
<div class="modal-body">
	<form id="del_language_form" class="form-horizontal" novalidate="novalidate">
		<div class="form-body">
			<?php 
			if (!PermissionHelper::checkAdminUserLogin()){
				$message = "Your session has expired.";
			}else{
				$message = "You don't have permission to access this function !";
			}
			?>
			<p><?=Lang::get($message)?></p>
			
		</div>
	</form>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "";
	$button->title = " " . Lang::get ( "Close" );
	$button->class = "btn btn-sm btn-close margin-bottom-5";
	$button->attributes = "data-dismiss=\"modal\"";
	$button->render ();
	?>
</div>
