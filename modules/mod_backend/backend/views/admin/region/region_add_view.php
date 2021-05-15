<?php
use core\utils\ActionUtil;
?>
<div class="row">
	<div class="col-md-12">
		<?php include_once 'region_add_res_data.php';?>
	</div>
</div>
<script type="text/javascript">
	function addRegion(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/region/add?rtype=json")?>",
			$("#add_region_form").serialize(),
			onAddRegionSuccess,
			onAddRegionFieldErrors,
			onAddRegionActionErrors
		);
	}
	function onAddRegionSuccess(res){
		location.href = '<?=ActionUtil::getFullPathAlias("admin/region/list")?>';
	}
	function onAddRegionFieldErrors(res){
		$("#add_region_form").replaceWith(res.content);
	}
	function onAddRegionActionErrors(res){
		showMessage(res.errorMessage,"error");
	}
	function addToEditRegion(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/region/addtoedit?rtype=json")?>",
			$("#add_region_form").serialize(),
			onAddToEditRegionSuccess,
			onAddToEditRegionFieldErrors,
			onAddToEditRegionActionErrors
		);
	}
	function onAddToEditRegionSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/region/edit/view')?>" + "?id=" + res.extra.regionId;
	}
	function onAddToEditRegionFieldErrors(res){
		$("#add_region_form").replaceWith(res.content);
	}
	function onAddToEditRegionActionErrors(res){
		showMessage(res.errorMessage,"error");
	}
</script>