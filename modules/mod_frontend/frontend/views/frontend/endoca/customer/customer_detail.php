<?php
use common\template\extend\ModalTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
if(is_null(SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME))){
	header(ActionUtil::getFullPathAlias("")); 
	exit();
}

$customer = RequestUtil::get('customer');

?>
<div class="container-fluid" id="main" style="background-color: #f5f6f9;">
    <div class="light my-account">
        <div>
            <div class="row">
                <div class="col-xs-3">
                    <h2 class="title"><?= Lang::get("My Account") ?></h2>
                    <ul class="nav nav-pills nav-stacked" id="account_menu">
                        <li class="active">
                            <a href="<?=ActionUtil::getFullPathAlias("customer/detail") ?>" aria-expanded="true"> <?= Lang::get("Account Info") ?> </a>
                        </li>
                        <li class="">
                            <a href="<?=ActionUtil::getFullPathAlias("home/address/list") ?>" aria-expanded="false">  <?= Lang::get("My Addresses") ?> </a>
                        </li>
                        <li class="">
                            <a href="<?=ActionUtil::getFullPathAlias("customer/order/list") ?>" aria-expanded="false">  <?= Lang::get("My Orders") ?> </a>
                        </li>
                        <li class="">
                            <a href="#" onclick="showLogoutDialog()">  <?= Lang::get("Logout") ?> </a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-9">
                    <div class="tab-content" id="account_container">
                        <div class="tab-pane active" id="tab_account_info">
							<?php include_once 'customer_detail_data.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$modalTemplate = new ModalTemplate();
$modalTemplate->id = "modalAddressDialog";
$modalTemplate->size = 900;
$modalTemplate->render();

$modalTemplate = new ModalTemplate();
$modalTemplate->id = "modalAddressSuggetDialog";
$modalTemplate->size = 800;
$modalTemplate->render();
?>
<script type="text/javascript">
    $("body").attr("class","_my-account");
	formAddressList = "#formAddressList";
	btnSubmitAddress = "#btnSubmitAddress";
	formIdAddress = "#formIdAddress";
	uuidAddress = guid();

	modalAddressDialog = "#modalAddressDialog";
	customerDetailForm = "#customerDetailForm";
	btnSaveCustomerSubmit = "#btnSaveCustomerSubmit";
	groupId = '<?=$customer->id ?>';
	gUrlCustomerDetail = "<?=ActionUtil::getFullPathAlias("customer/account/info") ?>" + "?rtype=json";
	gUrlEditCustomer = "<?=ActionUtil::getFullPathAlias("customer/edit") ?>" + "?rtype=json";
	gUrlAddressList = "<?=ActionUtil::getFullPathAlias("home/address/list") ?>" + "?rtype=json";
	gUrlAddAddress = "<?=ActionUtil::getFullPathAlias("home/address/add/view") ?>" + "?rtype=json";
	pUrlAddAddress = "<?=ActionUtil::getFullPathAlias("home/address/add") ?>" + "?rtype=json";
	gUrlEditAddress = "<?=ActionUtil::getFullPathAlias("home/address/edit/view") ?>" + "?rtype=json";
	pUrlEditAddress = "<?=ActionUtil::getFullPathAlias("home/address/edit") ?>" + "?rtype=json";
	gUrlDelAddress = "<?=ActionUtil::getFullPathAlias("home/address/del/view") ?>" + "?rtype=json";
	pUrlDelAddress = "<?=ActionUtil::getFullPathAlias("home/address/del") ?>" + "?rtype=json";
	gUrlChangeCountry = "<?=ActionUtil::getFullPathAlias("home/address/state/list") ?>" + "?rtype=json";
	gUrlOrderList = "<?=ActionUtil::getFullPathAlias("customer/order/list") ?>" + "?rtype=json";
	function updateSuccess(res){
		showMessage("<?=Lang::get("Updated Successfully") ?>");
		$("#tab_account_info").html(res.content);
	}
	function loadAccountSuccess(res){
        history.pushState({}, null, "#tab_account_info");
		$("#tab_account_info").html(res.content);
	}
	function fieldErrorEditCustomer(res){
		$("#tab_account_info").replaceWith(res.content);
	}
	function actionErrorEditCustomer(res){
		showMessage(res.errorMessage);
		$("#tab_account_info").html(res.content);
	}
	function editCustomer(){
		var data = $(customerDetailForm).serialize();
		simpleAjaxPost(
			guid(),
			gUrlEditCustomer,
			data,
			updateSuccess,
			fieldErrorEditCustomer,
			actionErrorEditCustomer
		);
	}
	function loadAddressSuccess(res){
        history.pushState({}, null, "#tab_address");
		$("#div_address_list").html(res.content);
	}
	function loadAddress(){
		var data = $("#formAddressList").serialize();
		simpleAjaxPost(
			guid(),
			gUrlAddressList + "&address[groupId]=" + groupId,
			data,
			loadAddressSuccess
		);
	}
	function changeAddressPage(page){
		$("#pageAddress").val(page);
		var data = $("#formAddressList").serialize();
		simpleAjaxPost(
			guid(),
			gUrlAddressList,
			data,
			loadAddressSuccess
		);
	}

	function addSuccessAddress(dialogId, actionBtnId, res){
		showMessage("<?=Lang::get("Address is added successfully") ?>");
		loadAddress();
		$(dialogId).modal("toggle");
	}

	function addActionErrorAddress(res){
		$("#addressAddFormId").replaceWith(res.content);
	}

	function editActionErrorAddress(dialogId, actionBtnId, res){
		$("#addressEditFormId").replaceWith(res.content);
	}

	function editSuccessAddress(dialogId, actionBtnId, res){
		showMessage("<?=Lang::get("Updated successfully!") ?>");
		loadAddress();
		$(dialogId).modal("toggle");
	}

	function delSuccessAddress(dialogId, actionBtnId, res){
		showMessage("<?=Lang::get("Deleted successfully") ?>");
		loadAddress();
		$(dialogId).modal("toggle");
	}

	function editAddress(id){
		simpleCUDModal(
			modalAddressDialog,
			"#addressEditFormId",
			uuidAddress,
			btnSubmitAddress,
			gUrlEditAddress + "&address[id]=" + id,
			pUrlEditAddress,
			editSuccessAddress,
			null,
			editActionErrorAddress
		);
	}
	function delAddress(id){
		simpleCUDModal(
			modalAddressDialog,
			formIdAddress,
			uuidAddress,
			btnSubmitAddress,
			gUrlDelAddress + "&address[id]=" + id,
			pUrlDelAddress,
			delSuccessAddress
		);
	}
	function addAddress(){
		simpleCUDModal(
			modalAddressDialog,
			"#addressAddFormId",
			uuidAddress,
			btnSubmitAddress,
			gUrlAddAddress + "&address[groupId]=" + groupId,
			pUrlAddAddress,
			addSuccessAddress,
			null,
			editActionErrorAddress
		);
	}
	function changeCountrySuccess(res){
		$("#state_result").html(res.content);
	}
	function changeCountry(countryId){
		simpleAjaxPost(
			uuid,
			gUrlChangeCountry + "&address[country]=" + countryId,
			$("#addressAddFormId").serialize(),
			changeCountrySuccess
		)
	}
	function loadAccountInfo(){
		simpleAjaxPost(
			guid(),
			gUrlCustomerDetail,
			"",
			loadAccountSuccess
		);
	}
	function loadOrderSuccess(res){
        history.pushState({}, null, "#tab_orders");
		$("#tab_customer_order").html(res.content);
	}
	function loadOrder(){
		var data = $("#formAddressList").serialize();
		simpleAjaxPost(
			guid(),
			gUrlOrderList,
			data,
			loadOrderSuccess
		);
	}

	
</script>
