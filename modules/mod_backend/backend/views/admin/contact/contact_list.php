<?php
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
						<span class="caption-subject bold uppercase"><?=Lang::get("Inquiry History")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form id="contact_search_form">
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
									$select->attributes = "onchange=\"refreshContacts()\"";
									$select->collections = $collections;
									$labelContainer->addElement ( $select );
									$labelContainer->render ();
									?>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
									</div>
								</div>
							</div>
							<div id="contact_search_result">
								<?php include "contact_list_data.php"?>
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
$modalTemplate->id = "contact_dialog";
$modalTemplate->size = 900;
$modalTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		showContacts("crDate","desc");
	});
	function detailContactDialog(id){
		simpleCUDModal(
			"#contact_dialog",
			"#detail_contact_form",
			guid(),
			"#btnDetailContact",
			"<?=ActionUtil::getFullPathAlias("admin/contact/detail/view?rtype=json&id=")?>" + id,
			"",
			refreshContacts
		);
	}
	function deleteContactDialog(id){
		simpleCUDModal(
				"#contact_dialog",
				"#del_contact_form",
				guid(),
				"#btnDelContact",
				"<?=ActionUtil::getFullPathAlias("admin/contact/del/view?rtype=json&id=")?>" + id,
				"<?=ActionUtil::getFullPathAlias("admin/contact/del?rtype=json")?>",
				refreshContacts
			);
	}
	function showContacts(field,direction){
		$("#contact_table").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","fullName","email","phone","countryCode","crDate","status",""],
			callback : sortContacts
		});
	}
	function sortContacts(field, direction, is_reset = false){
		App.blockUI({
            target: '#contact_table'
        })
		var data = "";
		if (!is_reset) {
			data = $("#contact_search_form").serialize();
		}
		data += "&orderBy=" + field + " " + direction;
		$.post("<?=ActionUtil::getFullPathAlias("admin/contact/search?rtype=json")?>", data, function(res) {
			App.unblockUI('#contact_table');
			if (res.errorCode == "SUCCESS") {
				// Get user list.
				$("#contact_search_result").html(res.content);
				// Update view for sorting.
				showContacts(field,direction);
			} else {
				alert(res.errorMessage);
			}
		}).fail(function() {
			App.unblockUI('#contact_table');
			alert("System error.");
		});
	}
	function searchContacts(is_reset = false){
		$("#contact_search_form #page").val(1);
		sortContacts("crDate","desc",is_reset);
	}
	function changePageContacts(page){
		var field = $("#contact_table").attr("field");
		var direction = $("#contact_table").attr("direction");
		$("#contact_search_form #page").val(page);
		sortContacts(field,direction);
	}
	function refreshContacts(dialogId,btnId,res){
		var field = $("#contact_table").attr("field");
		var direction = $("#contact_table").attr("direction");
		sortContacts(field,direction);
		$(dialogId).modal("toggle");
	}
</script>