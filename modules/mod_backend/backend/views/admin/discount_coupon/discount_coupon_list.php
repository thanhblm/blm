<?php
use common\template\extend\Button;
use common\template\extend\LabelContainer;
use common\template\extend\ModalTemplate;
use common\template\extend\Select;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get ( "pageSizes" );
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get("Discount coupons")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="discount_coupon_search_form">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<?php
									$labelContainer = new LabelContainer ();
									$labelContainer->textBefore = Lang::get ( 'Show' );
									$labelContainer->textAfter = Lang::get ( 'entries' );
									$select = new Select ();
									$collections = $pageSizes;
									$select->collectionType = Select::CT_SINGLE_ARRAY_VALUE;
									$select->name = "pageSize";
									$select->value = RequestUtil::get ( "pageSize" );
									$select->attributes = "onchange=\"refreshDiscountCoupons()\"";
									$select->collections = $collections;
									$labelContainer->addElement ( $select );
									$labelContainer->render ();
									?>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
									<?php
									$button = new Button ();
									$button->type = "button";
									$button->id = "btnAddDiscountCouponDialog";
									$button->title = " " . Lang::get ( 'Add New' );
									$button->class = "btn btn-sm blue margin-bottom-5";
									$button->icon = "<i class=\"fa fa-plus\"></i>";
									$button->attributes = "onclick=\"onAddDiscountCoupon()\"";
									$button->checkActionPath = "admin/discount/coupon/add/view";
									$button->render ();
									?>
									</div>
								</div>
							</div>
							<div id="discount_coupon_search_result">
								<?php include "discount_coupon_list_data.php"?>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>
<?php
$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "discount_coupon_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showDiscountCoupons("id","asc");
	});
	function onAddDiscountCoupon(){
		window.location.href = "<?=ActionUtil::getFullPathAlias("admin/discount/coupon/add/view")?>";
	}
	function onCopyDiscountCoupon(id){
		window.location.href = "<?=ActionUtil::getFullPathAlias("admin/discount/coupon/copy/view?id=")?>"+id;
	}
	
	function onEditDiscountCoupon(id){
		window.location.href = "<?=ActionUtil::getFullPathAlias("admin/discount/coupon/edit/view?id=")?>"+id;
	}
	function deleteDiscountCouponDialog(id){
		simpleCUDModal(
				"#discount_coupon_dialog",
				"#del_discount_coupon_form",
				guid(),
				"#btnDelDiscountCoupon",
				"<?=ActionUtil::getFullPathAlias("admin/discount/coupon/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/discount/coupon/del?rtype=json")?>",
				refreshDiscountCoupons
			);
	}
	function showDiscountCoupons(field,direction){
		$("#discount_coupon_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","code","name","discount","status",""],
			callback : sortDiscountCoupons
		});
	}
	function sortDiscountCoupons(field, direction, is_reset = false){
		App.blockUI({
            target: '#discount_coupon_table'
        });
		var data = "";
		if (!is_reset){
			data = $("#discount_coupon_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/discount/coupon/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#discount_coupon_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#discount_coupon_search_result").html(res.content);
				// Update view for sorting.
				showDiscountCoupons(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#discount_coupon_table');
			alert("System error.");
		});
	}
	function searchDiscountCoupons(is_reset = false){
		$("#discount_coupon_search_form #page").val(1);
		sortDiscountCoupons("id","asc", is_reset);
	}

	function changePageDiscountCoupons(page){
		var field = $("#discount_coupon_table").attr("field");
		var direction = $("#discount_coupon_table").attr("direction");
		$("#discount_coupon_search_form #page").val(page);
		sortDiscountCoupons(field,direction);
	}
	function refreshDiscountCoupons(dialogId,btnId,res){
		var field = $("#discount_coupon_table").attr("field");
		var direction = $("#discount_coupon_table").attr("direction");
		sortDiscountCoupons(field,direction);
		$(dialogId).modal("toggle");
	}
</script>