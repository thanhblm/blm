<?php
use core\utils\ActionUtil;
?>
<div class="row">
	<div class="col-md-12">
		<?php include_once 'region_copy_res_data.php';?>
	</div>
</div>
<script type="text/javascript">
	function copyRegion(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/region/copy?rtype=json")?>",
			$("#copy_region_form").serialize(),
			onAddRegionSuccess,
			onAddRegionFieldErrors,
			onAddRegionActionErrors
		);
	}
	function onAddRegionSuccess(res){
		location.href = '<?=ActionUtil::getFullPathAlias("admin/region/list")?>';
	}
	function onAddRegionFieldErrors(res){
		$("#copy_region_form").replaceWith(res.content);
	}
	function onAddRegionActionErrors(res){
		showMessage(res.errorMessage,"error");
	}
	function copyToEditRegion(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/region/copytoedit?rtype=json")?>",
			$("#copy_region_form").serialize(),
			onCopyToEditRegionSuccess,
			onCopyToEditRegionFieldErrors,
			onCopyToEditRegionActionErrors
		);
	}
	function onCopyToEditRegionSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/region/edit/view')?>" + "?id=" + res.extra.regionId;
	}
	function onCopyToEditRegionFieldErrors(res){
		$("#copy_region_form").replaceWith(res.content);
	}
	function onCopyToEditRegionActionErrors(res){
		showMessage(res.errorMessage,"error");
	}
</script>