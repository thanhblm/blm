<?php
use core\utils\ActionUtil;
?>
<div class="row">
	<div class="col-md-12">
		<?php include_once 'region_edit_res_data.php';?>
	</div>
</div>
<script type="text/javascript">
	function editRegion(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/region/edit?rtype=json")?>",
			$("#edit_region_form").serialize(),
			onAddRegionSuccess,
			onAddRegionFieldErrors,
			onAddRegionActionErrors
		);
	}
	function onAddRegionSuccess(res){
		location.href = '<?=ActionUtil::getFullPathAlias("admin/region/list")?>';
	}
	function onAddRegionFieldErrors(res){
		$("#edit_region_form").replaceWith(res.content);
	}
	function onAddRegionActionErrors(res){
		showMessage(res.errorMessage,"error");
	}
	function editToEditRegion(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/region/edittoedit?rtype=json")?>",
			$("#edit_region_form").serialize(),
			onEditToEditRegionSuccess,
			onEditToEditRegionFieldErrors,
			onEditToEditRegionActionErrors
		);
	}
	function onEditToEditRegionSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/region/edit/view')?>" + "?id=" + res.extra.regionId;
	}
	function onEditToEditRegionFieldErrors(res){
		$("#edit_region_form").replaceWith(res.content);
	}
	function onEditToEditRegionActionErrors(res){
		showMessage(res.errorMessage,"error");
	}
</script>