<?php

use core\utils\ActionUtil;

?>
<div class="row">
	<div class="col-md-12">
		<?php include_once 'product_add_res_data.php';?>
	</div>
</div>
<div class="modal fade in" id="product_lang_dialog" tabindex="-1" role="basic" aria-hidden="true" style="display: none; width: 600px; height: 400px"></div>
<div class="modal fade in" id="delete_product_lang_dialog" tabindex="-1" role="basic" aria-hidden="true" style="display: none;"></div>
<script type="text/javascript">
	function addProduct(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/product/add?rtype=json")?>",
			$("#add_product_form").serialize(),
            function(res){
            },
			onAddProductFieldErrors,
			onAddProductActionErrors
		);
	}
	function onAddProductSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/product/list')?>";
	}
	function onAddProductFieldErrors(res){
		$("#add_product_form").replaceWith(res.content);
	}
	function onAddProductActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}
	
	function addToEditProduct(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/product/addtoedit?rtype=json")?>",
			$("#add_product_form").serialize(),
            function (res){
            },
			onAddToEditProductFieldErrors,
			onAddToEditProductActionErrors
		);
	}
	function onAddToEditProductSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/product/edit/view')?>" + "?id=" + res.extra.product['id'];
	}
	function onAddToEditProductFieldErrors(res){
		$("#add_product_form").replaceWith(res.content);
	}
	function onAddToEditProductActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}
</script>