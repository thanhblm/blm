<?php
use common\template\extend\Button;
use common\template\extend\ModalTemplate;
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
						<span class="caption-subject bold uppercase"><?=Lang::get('Payment Methods')?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
						<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
										<select name="pageSize" onchange="searchPayment()" class="form-control input-sm input-xsmall input-inline">
										<?php
										foreach ( $pageSizes as $pageSize ) {
											?>
											<option value="<?=$pageSize?>" <?=(RequestUtil::get("pageSize")==$pageSize)?"selected":""?>><?=$pageSize?></option>
											<?php
										}
										?>
										</select> 
											<?=Lang::get('entries')?>
										</label>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										$button = new Button ();
										$button->type = "button";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" addPayment()\"";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "payment_method_list_data.php"?>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>
<?php
$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "modalDialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	var defaultField 		= "id";
	var defaultDirection 	= "asc";
	$(document).ready(function() {
	    showTableView(defaultField,defaultDirection);
	});
	function showTableView(field,direction){
		$("#page_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","name","status",""],
			callback : searchPayment
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/payment/method/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/payment/method/add") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/payment/method/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/payment/method/edit") ?>" + "?rtype=json";
	gUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/payment/method/copy/view") ?>" + "?rtype=json";
	pUrlCopy 			= "<?=ActionUtil::getFullPathAlias("admin/payment/method/copy") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/payment/method/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/payment/method/del") ?>" + "?rtype=json";
	searchUrl			= "<?=ActionUtil::getFullPathAlias("admin/payment/method/search") ?>" + "?rtype=json";

	function addSuccess(dialogId,btnId,res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    doRefresh(dialogId,btnId,res);
	}

	function editSuccess(dialogId,btnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		doRefresh(dialogId,btnId,res);
	}

	function copySuccess(dialogId,btnId,res){
	    showMessage("<?=Lang::get("Clone success") ?>");
	    doRefresh(dialogId,btnId,res);
	}
	
	function delSuccess(dialogId,btnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    doRefresh(dialogId,btnId,res);
	}
	
	function addPayment(){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlAdd, 
			    pUrlAdd, 
			    addSuccess
		    );
	}
	
	function deletePaymentDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&paymentMo[id]="+id, 
			    pUrlDel, 
			    delSuccess
		    );
	}
	
	function editPaymentDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&paymentMo[id]="+id, 
			    pUrlEdit, 
			    editSuccess
		    );
	}

	function copyPaymentDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlCopy+"&paymentMo[id]="+id, 
			    pUrlCopy, 
			    copySuccess
		    );
	}

	function resetPaymentForm(){
	    searchPayment(defaultField,defaultDirection,true);
	}
	
	function searchPayment(field = defaultField, direction = defaultDirection, isReset = false){
	    App.blockUI({ target: '#page_table' });
	    var data = "";
	    if (!isReset){
			data = $("#page_form").serialize();
			data += "&orderBy=" + field + " " + direction;
		 }
		$.post(searchUrl, data, function(res) {
		    App.unblockUI('#page_table');
			if (res.errorCode == "SUCCESS") {
				$("#page_result").html(res.content);
				showTableView(field,direction);
			} else {
			    alert(res.errorMessage);
			}
		}).fail(function() {
		    App.unblockUI('#page_table');
			alert("System error.");
		});
	}
	
	function onPageChange(page){
	    var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
	    $("#page_form #page").val(page);
	    searchPayment(field, direction);
	}
	function doRefresh(dialogId,btnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		searchPayment(field, direction);
		$(dialogId).modal("toggle");
	}
</script>