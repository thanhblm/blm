<?php
use core\utils\ActionUtil;
?>
<div class="row">
	<div class="col-md-12">
		<?php include_once 'product_copy_res_data.php';?>
	</div>
</div>
<script type="text/javascript">
	function copyProduct(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/product/copy?rtype=json")?>",
			$("#edit_product_form").serialize(),
			onCopyProductSuccess,
			onCopyProductFieldErrors,
			onCopyProductActionErrors
		);
	}
	function onCopyProductSuccess(res){
		$("#edit_product_form").replaceWith(res.content);
	}
	function onCopyProductFieldErrors(res){
		$("#edit_product_form").replaceWith(res.content);
	}
	function onCopyProductActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}

	function copyCloseProduct(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/product/copytoclose?rtype=json")?>",
			$("#edit_product_form").serialize(),
			onCopyCloseProductSuccess,
			onCopyProductFieldErrors,
			onCopyProductActionErrors
		);
	}
	function onCopyCloseProductSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/product/list')?>";
	}
</script>