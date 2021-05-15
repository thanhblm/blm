<?php

use core\utils\ActionUtil;

?>
<div class="row">
	<div class="col-md-12">
		<?php include_once 'product_edit_res_data.php';?>
	</div>
</div>
<script type="text/javascript">
	function editProduct(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/product/edit?rtype=json")?>",
			$("#edit_product_form").serialize(),
			function(res){
			},
			onAddProductFieldErrors,
			onAddProductActionErrors
		);
	}
	function onAddProductSuccess(res){
        $("#edit_product_form").replaceWith(res.content);
	}
	function onAddProductFieldErrors(res){
		$("#edit_product_form").replaceWith(res.content);
	}
	function onAddProductActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}
	function editCloseProduct(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/product/edittoclose?rtype=json")?>",
			$("#edit_product_form").serialize(),
			function (res){
			},
			onEditCloseProductFieldErrors,
			onEditCloseProductActionErrors
		);
	}
	function onEditCloseProductSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/product/list')?>";
	}
	function onEditCloseProductFieldErrors(res){
		$("#edit_product_form").replaceWith(res.content);
	}
	function onEditCloseProductActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}
</script>