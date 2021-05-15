function reloadCart(){
    simpleAjaxPost(
	    guid(), 
	    urlReloadCart, // 
	    "", 
	    reloadCartSuccess, 
	    shoppingCartUpdateError, 
	    shoppingCartUpdateError
    	);
}
function reloadCartSuccess(res){
    showMessage("Shopping basket is updated successfully!", "success", true);
    $("div#fw_sidecart_contents").html(res.content);
    $("div#sidecart_contents").html(res.content);
}

function shoppingCartUpdateSuccess(res){
    var element =  document.getElementById('discountCodeId');
    if (typeof(element) != 'undefined' && element != null)
    {
        simpleAjaxPost(
    	    guid(), 
    	    urlCheckoutItemRemove, // 
    	    "", 
    	    checkoutUpdateCartSuccess, 
    	    checkoutUpdateCartFieldErrors, 
    	    shoppingCartUpdateError
        	);
    }
    reloadCart();
}

function shoppingCartUpdateError(res){
    var element =  document.getElementById('discountCodeId');
    if (typeof(element) != 'undefined' && element != null)
    {
        simpleAjaxPost(
    	    guid(), 
    	    urlCheckoutItemRemove, // 
    	    "", 
    	    checkoutUpdateCartSuccess
        	);
    }
    reloadCart();
    showMessage(res.errorMessage,"warning",true);
}

function shoppingCartUpdate(){
    var data = $("#info-product-detail");
    simpleAjaxPostUpload(
	    guid(), 
	    urlShoppingCartUpdate, // 
	    data, 
	    shoppingCartUpdateSuccess, 
	    shoppingCartUpdateError, 
	    shoppingCartUpdateError
    	);
}

function checkoutUpdateCartSuccess(res){
    showMessage("Shopping basket is updated successfully!","success",true);
    window.location.reload(true);
}

function checkoutUpdateCartFieldErrors(res){
    $("#main").html(res.content);
}

function checkoutUpdateCart(productId, quantity){
    var data = {
	    "product[id]":productId,
	    "productQuantity":quantity
    };
    simpleAjaxPost(
	    guid(), 
	    urlCheckoutItemRemove, // 
	    data, 
	    checkoutUpdateCartSuccess, 
	    checkoutUpdateCartFieldErrors, 
	    shoppingCartUpdateError
    	);
}

function simpleCUDNormal(divContentId, formId, uuid, actionBtnId, gUrl, pUrl, successCallBack, fieldErrorCallBack, actionErrorCallBack) {
    App.blockUI();
    $.ajax({
	url : gUrl + getAppendIntact(gUrl) + "rid=" + uuid,
	success : function(res) {
	    App.unblockUI();
	    $(divContentId).html(res.content).promise().done(function() {
	    });
	    $(actionBtnId).click(function() {
		App.blockUI();
		var data = $(formId).serialize();
		$.post(pUrl, data, function(res) {
		    App.unblockUI();
		    if (res.errorCode == "SUCCESS") {
			if (typeof successCallBack != 'undefined' && successCallBack != null) {
			    successCallBack(divContentId, actionBtnId, res);
			} else {
			    alert(res.errorMessage);
			}
		    } else if (res.errorCode == "FIELD_ERROR") {
			if (typeof fieldErrorCallBack != 'undefined' && fieldErrorCallBack != null) {
			    fieldErrorCallBack(divContentId, actionBtnId, res);
			} else {
			    $(formId).replaceWith(res.content);
			}
		    } else {
			if (typeof actionErrorCallBack != 'undefined' && actionErrorCallBack != null) {
			    actionErrorCallBack(divContentId, actionBtnId, res);
			} else {
			    alert(res.errorMessage);
			}
		    }
		}).fail(function() {
		    alert("System error.");
		    App.unblockUI();
		});
	    });
	}
    }).fail(function() {
	App.unblockUI();
    });
}