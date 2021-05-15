<?php
use common\template\extend\FormContainer;
use core\Lang;
use core\utils\RequestUtil;

// get data
$gridVo = RequestUtil::get ( "gridVo" );

$form = new FormContainer ();
$form->id = "grid_delete_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<input name='gridVo[id]' type="hidden" value="<?=$gridVo->id?>" />
	<p><?=Lang::getWithFormat("Are you sure you want to delete grid <b>#{0}</b>?", $gridVo->id)?></p>
</div>
<?php $form->renderEnd ();?>