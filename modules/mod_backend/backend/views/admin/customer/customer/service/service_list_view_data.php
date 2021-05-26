<?php
use common\template\extend\Text;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
$addressList= RequestUtil::get ( "addressList" );
?>

	<?php include 'address_list_data.php';?>

<script type="text/javascript">
	var defaultFieldAddress 		= "id";
	var defaultDirectionAddress 	= "asc";
	$(document).ready(function() {
	    showTableViewAddress(defaultFieldAddress,defaultDirectionAddress);
	});
	function showTableViewAddress(field,direction){
		$("#page_table_address").tablesorter({
			field : field,
			direction : direction,
			fieldList : ["id","first_name", "last_name", "", ],
			callback : sortAddress
		});
	}
	
	modalDiaglogIdAddress 	= "#modalAddAddressDialog";
	formIdAddress 			= "#formIdAddress";
	uuidAddress 			= guid();
	btnSubmitAddress 		= "#btnSubmitAddress";
	gUrlAddAddress 			= "<?=ActionUtil::getFullPathAlias("admin/address/add/view") ?>" + "?rtype=json";
	pUrlAddAddress 			= "<?=ActionUtil::getFullPathAlias("admin/address/add") ?>" + "?rtype=json";
	gUrlEditAddress 		= "<?=ActionUtil::getFullPathAlias("admin/address/edit/view") ?>" + "?rtype=json";
	pUrlEditAddress 		= "<?=ActionUtil::getFullPathAlias("admin/address/edit") ?>" + "?rtype=json";
	gUrlDelAddress 			= "<?=ActionUtil::getFullPathAlias("admin/address/del/view") ?>" + "?rtype=json";
	pUrlDelAddress 			= "<?=ActionUtil::getFullPathAlias("admin/address/del") ?>" + "?rtype=json";
	searchUrlAddress 		= "<?=ActionUtil::getFullPathAlias("admin/address/search") ?>" + "?rtype=json";
	gUrlChangeCountry 		= "<?=ActionUtil::getFullPathAlias("admin/address/country/change") ?>" + "?rtype=json";
	function addSuccessAddress(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Address success") ?>");
		refreshAddress(dialogId,actionBtnId,res);
	}

	function addActionErrorAddress(res){
	    showMessage(res.errorMessage, "error");
	  	$("#addressAddFormId").replaceWith(res.content);
	}

	function editActionErrorAddress(dialogId, actionBtnId, res){
	    showMessage(res.errorMessage, "error");
	  	$("#addressEditFormId").replaceWith(res.content);
	}

	function editSuccessAddress(dialogId,actionBtnId,res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		refreshAddress(dialogId,actionBtnId,res);
	}

	function delSuccessAddress(dialogId,actionBtnId,res){
	    showMessage("<?=Lang::get("Deleted successfully") ?>");
	    refreshAddress(dialogId,actionBtnId,res);
	}

	function addAddressDialog(id){
	    simpleCUDModal(
		    	modalDiaglogIdAddress, 
			    "#addressAddFormId", 
			    uuidAddress, 
			    btnSubmitAddress, 
			    gUrlAddAddress+"&address[groupId]="+id, 
			    pUrlAddAddress, 
			    addSuccessAddress,
			    null,
			    editActionErrorAddress
		    );
	}
	
	function deleteAddressDialog(id){
	    simpleCUDModal(
		    	modalDiaglogIdAddress, 
		    	formIdAddress, 
			    uuidAddress, 
			    btnSubmitAddress, 
			    gUrlDelAddress+"&address[id]="+id, 
			    pUrlDelAddress, 
			    delSuccessAddress
		    );
	}
	function editAddressDialog(id){
	    simpleCUDModalUpload(
		    	modalDiaglogIdAddress, 
			    "#addressEditFormId", 
			    uuidAddress, 
			    btnSubmitAddress, 
			    gUrlEditAddress+"&address[id]="+id, 
			    pUrlEditAddress, 
			    editSuccessAddress,
			    null,
			    editActionErrorAddress
		    );
	}

	function resetAddressForm(){
	    sortAddress(defaultFieldAddress,defaultDirectionAddress,true);
	}
	
	function sortAddress(field = defaultFieldAddress, direction = defaultDirectionAddress, isReset = false){
	    App.blockUI({ target: '#page_table_address' });
	    var data = "";
	    if (!isReset){
			data = $("#addressFormId").serialize();
			data += "&orderBy=" + field + " " + direction;
		 }
		$.post(searchUrlAddress + "&address[groupId]=" + $("#groupId").val(), data, function(res) {
		    App.unblockUI('#page_table_address');
			if (res.errorCode == "SUCCESS") {
				$("#page_result_address").html(res.content);
				showTableViewAddress(field,direction);
			} else {
			    alert(res.errorMessage);
			}
		}).fail(function() {
		    App.unblockUI('#page_table_address');
			alert("System error.");
		});
	}

	function changePageAddress(page){
	    var field = $("#page_table_address").attr("field");
		var direction = $("#page_table_address").attr("direction");
	    $("#addressFormId #page").val(page);
	    sortAddress(field, direction);
	}
	function refreshAddress(dialogId,actionBtnId,res){
		var field = $("#page_table_address").attr("field");
		var direction = $("#page_table_address").attr("direction");
		sortAddress(field, direction);
		$(dialogId).modal("toggle");
	}

	function changeCountrySuccess(res){
	    $("#state_result").html(res.content);
	}
	function changeCountry(countryId){
	    simpleAjaxPost(
		    uuid, 
		    gUrlChangeCountry+"&address[country]="+countryId, 
		    $("#addressAddFormId").serialize(),
		    changeCountrySuccess
		   )
	}
</script>
