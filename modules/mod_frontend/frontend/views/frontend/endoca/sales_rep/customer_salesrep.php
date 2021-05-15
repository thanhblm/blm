<?php
use common\template\extend\Text;
use core\Lang;
use common\template\extend\ModalTemplate;
use core\utils\ActionUtil;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("body").attr("class", "_my-account");
    });
</script>
<div id="main">
    <div class="light my-account">
        <div>
            <div class="row">
                <div class="col-xs-3">
                    <h2 class="title"><?= Lang::get("Sales Rep Center") ?></h2>
                    <ul class="nav nav-pills nav-stacked" id="account_menu">
                        <li class="active">
                            <a href="#orders" data-toggle="tab" aria-expanded="true"> <?= Lang::get("Orders") ?> </a>
                        </li>
                        <li class="">
                            <a href="#customers" data-toggle="tab" aria-expanded="false" onclick="loadSalesReps()">  <?= Lang::get("Customers") ?> </a>
                        </li>
                        <li class="">
                            <a href="#quickOrder" data-toggle="tab" aria-expanded="false">  <?= Lang::get("Quick Order") ?> </a>
                        </li>
                        <li class="">
                            <a href="#" onclick="showLogoutDialog()">  <?= Lang::get("Logout") ?> </a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-9">
                    <div class="tab-content" id="account_container">
                        <div class="tab-pane active" id="orders">
                        	<a name="orders"/>
                            <?php include_once 'customer_order_data.php';?>
                        </div>
                        <!--customers-->
                        <div class="tab-pane" id="customers">
                        	<a name="customers"/>
                            <h2><?= Lang::get("My Customers") ?></h2>
                            <div class="tab-content">
								
                            </div>
                        </div>
                        <!--tab_1_3-->
                        <div class="tab-pane" id="quickOrder">
                        	<a name="quickOrder"/>
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
$modalTemplate->size = 800;
$modalTemplate->render();
?>
<script type="text/javascript">
$(function(){
	$('a[href="#orders"]').click(function(){
		$("#page").val(1);
		onCustomerOrder();
		history.pushState({}, null, "#orders");
	});
	$('a[href="#quickOrder"]').click(function(){
		onQuickOrder();
	});
});

function onQuickOrder(){
	var data = "page="+$("#page").val();
	simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("customer/salesrep/quick/order?rtype=json")?>",
			data,
			onCustomerQuickOrderSuccess,
			onCustomerQuickOrderErrors,
			onCustomerQuickOrderErrors
		);
}
function onCustomerQuickOrderSuccess(res){
	history.pushState({}, null, "#quickOrder");
	$("#quickOrder").html(res.content);
}
function onCustomerQuickOrderErrors(res){
	showMessage(res.errorMessage, 'error');
}




function changePageOrdersCustomer(page){
	$("#page").val(page);
	onCustomerOrder();
}
function onCustomerOrder(){
	var data = "page="+$("#page").val();
	simpleAjaxPost(
		guid(),
		"<?=ActionUtil::getFullPathAlias("customer/salesrep/order?rtype=json")?>",
		data,
		onCustomerOrderSuccess,
		onCustomerOrderErrors,
		onCustomerOrderErrors
	);
}
function onCustomerOrderSuccess(res){
	$("#orders").html(res.content);
}
function onCustomerOrderErrors(res){
	showMessage(res.errorMessage, 'error');
}

function loadSalesReps(){
    var data = "page="+$("#page").val();
    simpleAjaxPost(
        guid(),
        "<?=ActionUtil::getFullPathAlias("customer/salesrep/list?rtype=json")?>",
        data,
        onSalesRepSuccess,
        onSalesRepErrors,
        onSalesRepErrors
    );
}
function changePageSaleRep(page){
    $("#page").val(page);
    onSaleRep();
}
function onSaleRep(){
    var data = "page="+$("#page").val();
    simpleAjaxPost(
        guid(),
        "<?=ActionUtil::getFullPathAlias("customer/salesrep/list?rtype=json")?>",
        data,
        onSalesRepSuccess,
        onSalesRepErrors,
        onSalesRepErrors
    );
}

function onSalesRepSuccess(res){
	history.pushState({}, null, "#customers");
    $("#customers").html(res.content);
}
function onSalesRepErrors(res){
    showMessage(res.errorMessage, 'error');
}

function loadEditSaleRepForm(saleRepId){
    var data = "page="+$("#page").val();
    data=data+'&saleRepId='+saleRepId;
    simpleAjaxPost(
        guid(),
        "<?=ActionUtil::getFullPathAlias("customer/salesrep/edit/view?rtype=json")?>",
        data,
        onEditSaleRepSuccess,
        onEditSaleRepErrors,
        onEditSaleRepErrors
    );
}
function onEditSaleRepSuccess(res){
    $("#customers").html(res.content);
}
function onEditSaleRepErrors(res){
    showMessage(res.errorMessage, 'error');
}

function editSaleRep(){
    simpleAjaxPost(
        guid(),
        "<?=ActionUtil::getFullPathAlias("customer/salesrep/edit?rtype=json")?>",
        $("#sale_rep_edit_form").serialize(),
        loadSalesReps,
        onEditSaleRepFieldErrors,
        onEditSaleRepActionErrors
    );
}
function onEditSaleRepFieldErrors(res){
    $("#customers").replaceWith(res.content);
}
function onEditSaleRepActionErrors(res){
    showMessage(res.errorMessage, 'error');
}
function onEditSaleRepSuccess(res){
    $("#customers").html(res.content);
}
function onEditSaleRepErrors(res){
    showMessage(res.errorMessage, 'error');
}

function loadAddSaleRepForm(){
    var data = "page="+$("#page").val();
    simpleAjaxPost(
        guid(),
        "<?=ActionUtil::getFullPathAlias("customer/salesrep/add/view?rtype=json")?>",
        data,
        onEditSaleRepSuccess,
        onEditSaleRepErrors,
        onEditSaleRepErrors
    );
}

function onAddSaleRepErrors(res){
    showMessage(res.errorMessage, 'error');
}
function addSaleRep(){
    simpleAjaxPost(
        guid(),
        "<?=ActionUtil::getFullPathAlias("customer/salesrep/add?rtype=json")?>",
        $("#sale_rep_add_form").serialize(),
        loadSalesReps,
        onEditSaleRepFieldErrors,
        onEditSaleRepActionErrors
    );
}

function autoSaleRepLogin(saleRepId){
    var data = "page="+$("#page").val();
    data=data+'&saleRepId='+saleRepId;
    simpleAjaxPost(
        guid(),
        "<?=ActionUtil::getFullPathAlias("customer/salesrep/child/login?rtype=json")?>",
        data,
        loginSaleRepSuccess,
        onLoginSaleRepFieldErrors,
        onLoginSaleRepActionErrors
    );
}
function loginSaleRepSuccess(res){
    $('.btn btn-default dropdown-toggle').css('red');
    location.href = "<?=ActionUtil::getFullPathAlias('customer/detail')?>";
}
function onLoginSaleRepFieldErrors(res){
    $("#customers").html(res.content);
}
function onLoginSaleRepActionErrors(res){
    showMessage(res.errorMessage, 'error');
}
</script>
