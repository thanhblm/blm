<?php
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\template\extend\Button;
use common\template\extend\LabelContainer;
use common\template\extend\Select;
use common\template\extend\ModalTemplate;
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
						<span class="caption-subject bold uppercase"><?=Lang::get("Url Redirects")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="url_redirect_search_form">
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
									$select->attributes = "onchange=\"refreshUrlRedirects()\"";
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
										$button->id = "btnAddUrlRedirectDialog";
										$button->title = " " . Lang::get ( 'Add New' );
										$button->class = "btn btn-sm blue margin-bottom-5";
										$button->icon = "<i class=\"fa fa-plus\"></i>";
										$button->attributes = "onclick=\" return false\"";
										$button->checkActionPath = "admin/url/redirect/add/view";
										$button->render ();
										?>
									</div>
								</div>
							</div>
							<div id="url_redirect_search_result">
								<?php include "url_redirect_list_data.php"?>
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
$modalTemplate->id = "url_redirect_dialog";
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showUrlRedirects("id","asc");
		$("#btnAddUrlRedirectDialog").click(function(){
			simpleCUDModal(
				"#url_redirect_dialog",
				"#add_url_redirect_form",
				guid(),
				"#btnAddUrlRedirect",
				"<?=ActionUtil::getFullPathAlias("admin/url/redirect/add/view?rtype=json")?>",
				"<?=ActionUtil::getFullPathAlias("admin/url/redirect/add?rtype=json")?>",
				refreshUrlRedirects
			);
		});
	});
	function editUrlRedirectDialog(id){
		simpleCUDModal(
			"#url_redirect_dialog",
			"#edit_url_redirect_form",
			guid(),
			"#btnEditUrlRedirect",
			"<?=ActionUtil::getFullPathAlias("admin/url/redirect/edit/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/url/redirect/edit?rtype=json")?>",
			refreshUrlRedirects
		);
	}
	function copyUrlRedirectDialog(id){
		simpleCUDModal(
			"#url_redirect_dialog",
			"#copy_url_redirect_form",
			guid(),
			"#btnCopyUrlRedirect",
			"<?=ActionUtil::getFullPathAlias("admin/url/redirect/copy/view?rtype=json&id=")?>" + id,
			"<?=ActionUtil::getFullPathAlias("admin/url/redirect/copy?rtype=json")?>",
			refreshUrlRedirects
		);
	}
	function deleteUrlRedirectDialog(id){
		simpleCUDModal(
				"#url_redirect_dialog",
				"#del_url_redirect_form",
				guid(),
				"#btnDelUrlRedirect",
				"<?=ActionUtil::getFullPathAlias("admin/url/redirect/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/url/redirect/del?rtype=json")?>",
				refreshUrlRedirects
			);
	}
	function showUrlRedirects(field,direction){
		$("#url_redirect_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","oldUrl","newUrl",""],
			callback : sortUrlRedirects
		});
	}
	function sortUrlRedirects(field, direction, is_reset = false){
		App.blockUI({
            target: '#url_redirect_table'
        })
		var data = "";
		if (!is_reset) {
			data = $("#url_redirect_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/url/redirect/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#url_redirect_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#url_redirect_search_result").html(res.content);
				// Update view for sorting.
				showUrlRedirects(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#url_redirect_table');
			alert("System error.");
		});
	}
	function searchUrlRedirects(is_reset = false){
		$("#url_redirect_search_form #page").val(1);
		sortUrlRedirects("id","asc",is_reset);
	}
	function changePageUrlRedirects(page){
		var field = $("#url_redirect_table").attr("field");
		var direction = $("#url_redirect_table").attr("direction");
		$("#url_redirect_search_form #page").val(page);
		sortUrlRedirects(field,direction);
	}
	function refreshUrlRedirects(dialogId,btnId,res){
		var field = $("#url_redirect_table").attr("field");
		var direction = $("#url_redirect_table").attr("direction");
		sortUrlRedirects(field,direction);
		$(dialogId).modal("toggle");
	}
</script>