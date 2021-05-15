<?php
use common\helper\ProductHelper;
use common\template\extend\Button;
use common\template\extend\ModalTemplate;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get("pageSizes");
$productId = RequestUtil::get("productId");
$attrExtGroupVos = ProductHelper::getAttributeProduct($productId);
?>

<!-- BEGIN PAGE CONTENT INNER -->


<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?= Lang::get('Attribute Manage') ?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div id="page_form">
						<?php
						if(!is_null(RequestUtil::get("productId"))){
							include "product/product_attribute_data.php";
							echo '<hr/>';
						}
						?>
						<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?= Lang::get('Show') ?>
											<select name="pageSize" onchange="sortAttribute()"
											        class="form-control input-sm input-xsmall input-inline">
												<?php
												foreach ($pageSizes as $pageSize) {
													?>
													<option value="<?= $pageSize ?>" <?= (RequestUtil::get("pageSize") == $pageSize) ? "selected" : "" ?>><?= $pageSize ?></option>
													<?php
												}
												?>
											</select>
											<?= Lang::get('entries') ?>
										</label>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										$button = new Button();
										$button->type = "button";
										$button->title = " " . Lang::get('Add New');
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" addAttributeDialog()\"";
										$button->render();
										?>
									</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "attribute_list_data.php" ?>
							</div>
						</div>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>
<?php
$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "modalDialog";
$modalTemplate->render();

?>
<script type="text/javascript">
	var defaultField = "id";
	var defaultDirection = "asc";
	$(document).ready(function () {
		showTableView(defaultField, defaultDirection);
	});

	function showTableView(field, direction) {
		$("#page_table").tablesorter({
			field: field,
			direction: direction,
			fieldList: ["id", "code", "category_id", "attr_group_id", "", "name", "type", ""],
			callback: sortAttribute
		});
	}

	modalDiaglogId = "#modalDialog";
	formId = "#formId";
	uuid = guid();
	btnSubmit = "#btnSubmit";
	gUrlAdd = "<?=ActionUtil::getFullPathAlias("admin/attribute/add/view") ?>" + "?rtype=json";
	pUrlAdd = "<?=ActionUtil::getFullPathAlias("admin/attribute/add") ?>" + "?rtype=json";
	gUrlCoppy = "<?=ActionUtil::getFullPathAlias("admin/attribute/copy/view") ?>" + "?rtype=json";
	pUrlCoppy = "<?=ActionUtil::getFullPathAlias("admin/attribute/copy") ?>" + "?rtype=json";
	gUrlEdit = "<?=ActionUtil::getFullPathAlias("admin/attribute/edit/view") ?>" + "?rtype=json";
	pUrlEdit = "<?=ActionUtil::getFullPathAlias("admin/attribute/edit") ?>" + "?rtype=json";
	gUrlDel = "<?=ActionUtil::getFullPathAlias("admin/attribute/del/view") ?>" + "?rtype=json";
	pUrlDel = "<?=ActionUtil::getFullPathAlias("admin/attribute/del") ?>" + "?rtype=json";
	gUrlRemove = "<?=ActionUtil::getFullPathAlias("admin/attribute/remove/view") ?>" + "?rtype=json";
	pUrlRemove = "<?=ActionUtil::getFullPathAlias("admin/attribute/remove") ?>" + "?rtype=json";
	gUrlAddProduct = "<?=ActionUtil::getFullPathAlias("admin/attribute/set/view") ?>" + "?rtype=json";
	pUrlAddProduct = "<?=ActionUtil::getFullPathAlias("admin/attribute/set") ?>" + "?rtype=json";
	searchUrl = "<?=ActionUtil::getFullPathAlias("admin/attribute/search") ?>" + "?rtype=json";

	function addSuccess(dialogId, actionBtnId, res) {
		showMessage("<?=Lang::get("Added successfully") ?>");
		refreshAttribute(dialogId, actionBtnId, res);
	}

	function editActionError(dialogId, actionBtnId, res) {
		$(formId).replaceWith(res.content);
	}

	function editSuccess(dialogId, actionBtnId, res) {
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		refreshAttribute(dialogId, actionBtnId, res);
	}

	function delSuccess(dialogId, actionBtnId, res) {
		showMessage("<?=Lang::get("Deleted successfully") ?>");
		refreshAttribute(dialogId, actionBtnId, res);
	}

	function addAttributeDialog() {
		simpleCUDModalUpload(
			modalDiaglogId,
			"#attributeAddFormId",
			uuid,
			btnSubmit,
			gUrlAdd,
			pUrlAdd,
			addSuccess
		);
	}
	function viewAttribute(id) {
		$("#attrGroupMo_id").val(id);
		$("#attr_group_view_form").submit();
	}
	function deleteAttributeDialog(id) {
		simpleCUDModalUpload(
			modalDiaglogId,
			formId,
			uuid,
			btnSubmit,
			gUrlDel + "&attributeVo[id]=" + id,
			pUrlDel,
			delSuccess
		);
	}

	function copyAttributeDialog(id) {
		simpleCUDModalUpload(
			modalDiaglogId,
			"#attributeCopyFormId",
			uuid,
			btnSubmit,
			gUrlCoppy + "&attributeVo[id]=" + id,
			pUrlCoppy,
			addSuccess
		);
	}

	function editAttributeDialog(id) {
		simpleCUDModalUpload(
			modalDiaglogId,
			"#attributeEditFormId",
			uuid,
			btnSubmit,
			gUrlEdit + "&attributeVo[id]=" + id,
			pUrlEdit,
			editSuccess,
			null,
			editActionError
		);
	}

	function resetForm() {
		sortAttribute(defaultField, defaultDirection, true);
	}

	function sortAttribute(field = defaultField, direction = defaultDirection, isReset = false) {
		App.blockUI({target: '#page_table'});
		var data = "";
		if (!isReset) {
			simpleAjaxPostUpload(
				uuid,
				searchUrl + "&orderBy=" + field + " " + direction,
				"#page_form",
				sortSuccess
			);
		} else {
			simpleAjaxPostUpload(
				uuid,
				searchUrl + "&orderBy=" + field + " " + direction,
				"#nofound_reset",
				sortSuccess
			);
		}
	}

	function sortSuccess(res) {
		$("#page_result").html(res.content);
		showTableView(defaultField, defaultDirection);
	}

	function changePageAttribute(page) {
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		$("#page_form #page").val(page);
		sortAttribute(field, direction);
	}
	function refreshAttribute(dialogId, actionBtnId, res) {
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		sortAttribute(field, direction);
		$(dialogId).modal("toggle");
	}
	function updateProductAttribute() {
		simpleAjaxPostUpload(
			guid(),
			'<?=ActionUtil::getFullPathAlias("admin/product/attribute/update")?>?rtype=json',
			"#product_attr",
			selectAttributeSuccess,
			selectAttributeFieldError,
			selectAttributeActionError
		);
	}

	function removeAttributeForProduct(productId,attributeId) {
		simpleCUDModalUpload(
			modalDiaglogId,
			"#formRemoveId",
			uuid,
			btnSubmit,
			gUrlRemove + "&attributeVo[id]=" + attributeId + "&productId=" + productId,
			pUrlRemove,
			removeSuccess
		);
	}

	function addAttributeForProduct(productId,attributeId) {
		simpleCUDModalUpload(
			modalDiaglogId,
			"#formSetAttributeId",
			uuid,
			btnSubmit,
			gUrlAddProduct + "&attributeVo[id]=" + attributeId + "&productId=" + productId,
			pUrlAddProduct,
			removeSuccess
		);
	}

	function removeSuccess(dialogId, actionBtnId, res) {
		loadProductAttribute();
		$(dialogId).modal("toggle");
	}
	
	/* function changeAttrStatus(id, val, name){
	 var data = {
	 "attrGroupMo[id]":id,
	 "attrGroupMo[status]":val,
	 "attrGroupMo[name]":name
	 };
	 simpleAjaxPost(
	 guid(),
	 pUrlEdit,
	 data
	 );
	 } */
</script>