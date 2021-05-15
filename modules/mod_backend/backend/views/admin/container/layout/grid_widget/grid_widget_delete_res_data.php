<?php
use common\template\extend\FormContainer;
use core\Lang;
use core\utils\RequestUtil;

// get data
$gridWidgetVo = RequestUtil::get ( "gridWidgetVo" );
$widgetContentVo = RequestUtil::get ( "widgetContentVo" );

$form = new FormContainer ();
$form->id = "grid_widget_delete_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart ();
?>
<div class="form-body">
	<input name='gridWidgetVo[id]' type="hidden" value="<?=$gridWidgetVo->id?>" />
	<div class="form-body">
		<p><?=Lang::getWithFormat("Are you sure you want to delete widget <b>#{0}</b>?", $widgetContentVo->name)?></p>
	</div>
</div>
<?php $form->renderEnd ();?>