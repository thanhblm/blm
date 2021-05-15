<?php
use common\template\extend\Button;
use core\Lang;
use core\utils\ActionUtil;

?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Region shipping method configuration")?></h4>
</div>
<div class="modal-body">
	<?php include_once 'zone_table_config_edit_form_data.php'; ?>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "btnEditShippingMethodSetting";
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
<script type="text/javascript">
	function addShippingMethodRow(){
		var data = $("#edit_shipping_method_setting_form").serialize();
		simpleAjaxPost(guid(), "<?=ActionUtil::getFullPathAlias("admin/zone/table/template/add")?>?rtype=json", data, onAddShippingMethodRowSuccess);
	}
	function onAddShippingMethodRowSuccess(res){
		$("#edit_shipping_method_setting_form").replaceWith(res.content);
	}
	function removeShippingMethodRow(index){
		var data = $("#edit_shipping_method_setting_form").serialize();
		simpleAjaxPost(guid(), "<?=ActionUtil::getFullPathAlias("admin/zone/table/template/remove")?>?rtype=json&index=" + index, data, onRemoveShippingMethodRowSuccess);
	}
	function onRemoveShippingMethodRowSuccess(res){
		$("#edit_shipping_method_setting_form").replaceWith(res.content);
	}
</script>