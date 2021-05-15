<?php
use common\template\extend\Button;
use common\template\extend\ModalTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get ( "pageSizes" );
$slideGroupMo = RequestUtil::get ( "slideGroupMo" );
$listSlideGroup = RequestUtil::get ( "listSlideGroup" );
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-slides"></i> <span class="caption-subject bold uppercase"><?=Lang::get("Slide Reports")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<form id="page_form">
							<?php
							$text = new Text ();
							$text->type = "hidden";
							$text->name = "slideGroupMo[id]";
							$text->value = $slideGroupMo->id;
							$text->render ();
							
							$text = new Text ();
							$text->type = "hidden";
							$text->name = "slideMo[slideGroupId]";
							$text->value = $slideGroupMo->id;
							$text->render ();
							?>
							<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="dataTables_length">
										<label><?=Lang::get('Show')?> 
											<select name="pageSize" onchange="searchSlide()" class="form-control input-sm input-xsmall input-inline">
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
											$button->checkActionPath = "admin/slide/add/view";
											$button->title = " " . Lang::get ( 'Add New' );
											$button->class = "btn btn-sm blue margin-bottom-5";
											$button->icon = "<i class=\"fa fa-plus\"></i>";
											$button->attributes = "onclick=\"javascript:addSlideDialog()\"";
											$button->render ();
											?>
										</div>
								</div>
							</div>
							<div id="page_result">
								<?php include "slide_list_data.php" ?>
							</div>
						</div>
					</form>
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
$modalTemplate->size = 1000;
$modalTemplate->render ();

$modalTemplate = new ModalTemplate ();
$modalTemplate->id = "modalDialogErrorSlide";
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
			fieldList : ["id","","title","","", ""],
			callback : searchSlide
		});
	}
	
	modalDiaglogId 	= "#modalDialog";
	formId 			= "#formId";
	uuid 				= guid();
	btnSubmit 			= "#btnSubmit";
	gUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/slide/add/view") ?>" + "?rtype=json";
	pUrlAdd 			= "<?=ActionUtil::getFullPathAlias("admin/slide/add") ?>" + "?rtype=json";
	gUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/slide/edit/view") ?>" + "?rtype=json";
	pUrlEdit 			= "<?=ActionUtil::getFullPathAlias("admin/slide/edit") ?>" + "?rtype=json";
	gUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/slide/del/view") ?>" + "?rtype=json";
	pUrlDel 			= "<?=ActionUtil::getFullPathAlias("admin/slide/del") ?>" + "?rtype=json";
	searchUrl			= "<?=ActionUtil::getFullPathAlias("admin/slide/search") ?>" + "?rtype=json";
	pUrlConfirmUpload 	= "<?=ActionUtil::getFullPathAlias("admin/slide/confirm") ?>" + "?rtype=json";
	function addSuccess(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Added successfully") ?>");
	    doRefresh(dialogId,actionBtnId,res);
	}

	function addSlideActionError(dialogId,actionBtnId,res){
	    $("#modalDialogErrorSlide").html(res.content).promise().done(function() {
			$("#modalDialogErrorSlide").modal();
	    });
	}

	function editActionError(dialogId, actionBtnId, res){
	    	$(formId).replaceWith(res.content);
	}
	
	function editSuccess(dialogId,actionBtnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		doRefresh(dialogId,actionBtnId,res);
	}

	function delSuccess(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    doRefresh(dialogId,actionBtnId,res);
	}
	
	function addSlideDialog(){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    "#slideAddFormId", 
			    uuid, 
			    btnSubmit, 
			    gUrlAdd+"&slideMo[slideGroupId]=<?=$slideGroupMo->id?>", 
			    pUrlAdd, 
			    addSuccess,
			    null,
			    addSlideActionError
		    );
	}
	
	function deleteSlideDialog(id){
	    simpleCUDModal(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlDel+"&slideMo[id]="+id, 
			    pUrlDel, 
			    delSuccess
		    );
	}
	
	function editSlideDialog(id){
	    simpleCUDModalUpload(
		    	modalDiaglogId, 
			    formId, 
			    uuid, 
			    btnSubmit, 
			    gUrlEdit+"&slideMo[id]="+id, 
			    pUrlEdit, 
			    editSuccess,
			    null,
			    editActionError
		    );
	}

	function resetFormSlide(){
	    searchSlide(defaultField,defaultDirection,true);
	}
	
	function searchSlide(field = defaultField, direction = defaultDirection, isReset = false){
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
			    showMessage(res.errorMessage, "ERROR");
			}
		}).fail(function() {
			alert("System error.");
			App.blockUI({ target: '#page_table' });
		});
	}
	
	function onPageChange(page){
	    var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
	    $("#page_form #page").val(page);
	    searchSlide(field, direction);
	}
	function doRefresh(dialogId,actionBtnId,res){
		var field = $("#page_table").attr("field");
		var direction = $("#page_table").attr("direction");
		searchSlide(field, direction);
		$(dialogId).modal("toggle");
	}


	function changeSlideStatus(id, val){
		var data = {
				"slideMo[id]":id,
				"slideMo[status]":val
			};
	    simpleAjaxPost(
		    guid(), 
		    pUrlEdit, 
		    data
		    );
	}
</script>