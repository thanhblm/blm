function getAppendIntact(url){
	return (!/\?/.test(url) ? '?' : '&');
}

/* 
 @PARAM:dialogId  : modal div id  
 @formId: formId of Edit/Update; 
 @PARAM: uuid = guid();
 @actionBtnId : id of button to perform submit to webserver 
 @PARAM: gUrl = 'http://dato.example.com/address_View4Edit?key=xxx&value=yyy';
 @PARAM: pUrl = 'http://dato.example.com/address_SaveEdit?key=xxx&value=yyy';

 Callback function: it is a name of your own function to handle result, if null or not exist then --> call default

 @successCallBack = myOwnFunctionSuccessCallBack |  default : alert(res.errorMessage);
 @fieldErrorCallBack = myOwnFunctionFieldErrorCallBack | default : $(formId).replaceWith(res.content); replace content of formId -- [with error fields]
 @actionErrorCallBack = myOwnFunctionActionErrorCallBack | default : alert(res.errorMessage);
 ex: 
 function myOwnFunctionSuccessCallBack(res){
 alert(res.errorCode);
 }
 */

function simpleCUDModal(dialogId, formId, uuid, actionBtnId, gUrl, pUrl, successCallBack, fieldErrorCallBack, actionErrorCallBack){
	App.blockUI();
	$.ajax({
		url: gUrl + getAppendIntact(gUrl) + "rid=" + uuid,
		success: function(res){
			App.unblockUI();
			$(dialogId).html(res.content).promise().done(function(){
				$(dialogId).modal();
			});
			$(actionBtnId).click(function(){
				App.blockUI();
				var data = $(formId).serialize();
				$.post(pUrl, data, function(res){
					App.unblockUI();
					if (res.errorCode == "SUCCESS") {
						if (typeof successCallBack != 'undefined' && successCallBack != null) {
							successCallBack(dialogId, actionBtnId, res);
						} else {
							alert(res.errorMessage);
						}
					} else if (res.errorCode == "FIELD_ERROR") {
						if (typeof fieldErrorCallBack != 'undefined' && fieldErrorCallBack != null) {
							fieldErrorCallBack(dialogId, actionBtnId, res);
						} else {
							$(formId).replaceWith(res.content);
						}
					} else {
						if (typeof actionErrorCallBack != 'undefined' && actionErrorCallBack != null) {
							actionErrorCallBack(dialogId, actionBtnId, res);
						} else {
							alert(res.errorMessage);
						}
					}
				}).fail(function(){
					alert("System error.");
					App.unblockUI();
				});
			});
		}
	}).fail(function(){
		App.unblockUI();
	});
}
/* 
 @PARAM: uuid = guid();
 @PARAM: url = 'http://dato.example.com';
 @dataStr: "key1="+ encodeURIComponent('value1')+"&key2="+ encodeURIComponent('value2');
 Callback function: it is a name of your own function to handle result, if null or not exist then --> no action
 @successCallBack = myOwnFunctionSuccessCallBack; 
 @fieldErrorCallBack = myOwnFunctionFieldErrorCallBack;
 @actionErrorCallBack = myOwnFunctionActionErrorCallBack [or other Error];
 ex: 
 function myOwnFunctionSuccessCallBack(res){
 alert(res.errorCode);
 }
 */
function simpleAjaxGet(uuid, url, successCallBack, fieldErrorCallBack, actionErrorCallBack){
	$.ajax({
		type: 'GET',
		url: url + getAppendIntact(url) + "rid=" + uuid,
		success: function(res){
			if (res.errorCode == "SUCCESS") {
				if (typeof successCallBack != 'undefined' && successCallBack != null) {
					successCallBack(res);
				}
			} else if (res.errorCode == "FIELD_ERROR") {
				if (typeof fieldErrorCallBack != 'undefined' && fieldErrorCallBack != null) {
					fieldErrorCallBack(res);
				}
			} else {
				if (typeof actionErrorCallBack != 'undefined' && actionErrorCallBack != null) {
					actionErrorCallBack(res);
				}
			}
		},
		async: true
	}).fail(function(jqXHR, textStatus, error){
		alert("System error.");
	});
}

/* 
 @PARAM: uuid = guid();
 @PARAM: url = 'http://dato.example.com/POST';
 @dataStr: "key1="+ encodeURIComponent('value1')+"&key2="+ encodeURIComponent('value2') or data = $(formId).serialize();
 Callback function: it is a name of your own function to handle result, if null or not exist then --> no action
 @successCallBack = myOwnFunctionSuccessCallBack; 
 @fieldErrorCallBack = myOwnFunctionFieldErrorCallBack;
 @actionErrorCallBack = myOwnFunctionActionErrorCallBack [or other Error];
 ex: 
 function myOwnFunctionSuccessCallBack(res){
 alert(res.errorCode);
 }
 */
function simpleAjaxPost(uuid, url, data, successCallBack, fieldErrorCallBack, actionErrorCallBack){
	App.blockUI();
	$.ajax({
		type: 'POST',
		url: url + getAppendIntact(url) + "rid=" + uuid,
		data: data,
		success: function(res){
			App.unblockUI();
			if (res.errorCode == "SUCCESS") {
				if (typeof successCallBack != 'undefined' && successCallBack != null) {
					successCallBack(res);
				}
			} else if (res.errorCode == "FIELD_ERROR") {
				if (typeof fieldErrorCallBack != 'undefined' && fieldErrorCallBack != null) {
					fieldErrorCallBack(res);
				}
			} else {
				if (typeof actionErrorCallBack != 'undefined' && actionErrorCallBack != null) {
					actionErrorCallBack(res);
				}
			}
		},
		async: true
	}).fail(function(jqXHR, textStatus, error){
		alert("System error.");
	});
}


function simpleAjaxPostUpload(uuid, url, formId, successCallBack, fieldErrorCallBack, actionErrorCallBack){
	App.blockUI();
	var data = new FormData();
	var inputs = $(formId + ' input, ' + formId + ' select,' + formId + ' textarea');
	$.each(inputs, function(obj, v){
		var name = $(v).attr("name");
		if ($(v).attr("type") == "file") {
			var id = $(v).attr("id");
			var input = document.getElementById(id);
			for (var indexElement = 0; indexElement < input.files.length; indexElement++) {
				data.append(name + "[" + indexElement + "]", input.files[indexElement]);
			}
		} else if ($(v).attr("type") == "radio") {
			if ($(v).is(':checked')) {
				data.append(name, $(v).val());
			}
		} else if ($(v).attr("type") == "checkbox") {
			if ($(v).is(':checked')) {
				data.append(name, $(v).val());
			}
		}else {
			data.append(name, $(v).val());
		}
	});
	$.ajax({
		url: url,
		type: "POST",
		data: data,
		contentType: false,
		cache: false,
		processData: false,
		success: function(res){
			App.unblockUI();
			if (res.errorCode == "SUCCESS") {
				if (typeof successCallBack != 'undefined' && successCallBack != null) {
					successCallBack(res);
				} else {
					alert(res.errorMessage);
				}
			} else if (res.errorCode == "FIELD_ERROR") {
				if (typeof fieldErrorCallBack != 'undefined' && fieldErrorCallBack != null) {
					fieldErrorCallBack(res);
				} else {
					$(formId).replaceWith(res.content);
				}
			} else {
				if (typeof actionErrorCallBack != 'undefined' && actionErrorCallBack != null) {
					actionErrorCallBack(res);
				} else {
					alert(res.errorMessage);
				}
			}
		}
	}).fail(function(jqXHR, textStatus, error){
		alert("System error.");
		App.unblockUI();
	});
}


/*
 function loadModal(dialogId, formId, uuid, actionBtnId, gUrl, pUrl, successCallBack, fieldErrorCallBack, actionErrorCallBack) {
 $.ajax({
 url : gUrl + "&rid=" + uuid,
 success : function(res) {
 $(dialogId).html(res.content);
 $(dialogId).modal();
 $(actionBtnId).click(function() {
 var data = $(formId).serialize();
 $.post(pUrl, data, function(res) {
 $(formId).replaceWith(res.content);
 if (res.errorCode == "SUCCESS") {
 if (typeof successCallBack != 'undefined' && successCallBack != null) {
 successCallBack(dialogId, actionBtnId, res);
 }
 } else if (res.errorCode == "FIELD_ERROR") {
 if (typeof fieldErrorCallBack != 'undefined' && fieldErrorCallBack != null) {
 fieldErrorCallBack(dialogId, actionBtnId, res);
 }
 } else {
 if (typeof actionErrorCallBack != 'undefined' && actionErrorCallBack != null) {
 actionErrorCallBack(dialogId, actionBtnId, res);
 }
 }
 }).fail(function() {
 alert("System error.");
 });
 });
 }
 });
 }
 */
function simpleCUDModalUpload(dialogId, formId, uuid, actionBtnId, gUrl, pUrl, successCallBack, fieldErrorCallBack, actionErrorCallBack){
	App.blockUI();
	$.ajax({
		url: gUrl + getAppendIntact(gUrl) + "rid=" + uuid,
		success: function(res){
			App.unblockUI();
			if (res.errorCode == "SUCCESS") {
				$(dialogId).html(res.content);
				$(dialogId).modal();
				$(actionBtnId).click(function(e){
					App.blockUI();
					e.preventDefault();
					var data = new FormData();
					var inputs = $(formId + ' input, ' + formId + ' select,' + formId + ' textarea');
					$.each(inputs, function(obj, v){
						var name = $(v).attr("name");
						if ($(v).attr("type") == "file") {
							var id = $(v).attr("id");
							var input = document.getElementById(id);
							for (var indexElement = 0; indexElement < input.files.length; indexElement++) {
								data.append(name + "[" + indexElement + "]", input.files[indexElement]);
							}
						} else if ($(v).attr("type") == "radio") {
							if ($(v).is(':checked')) {
								data.append(name, $(v).val());
							}
						} else {
							data.append(name, $(v).val());
						}
					});
					$.ajax({
						url: pUrl,
						type: "POST",
						data: data,
						contentType: false,
						cache: false,
						processData: false,
						success: function(res){
							App.unblockUI();
							if (res.errorCode == "SUCCESS") {
								if (typeof successCallBack != 'undefined' && successCallBack != null) {
									successCallBack(dialogId, actionBtnId, res);
								} else {
									alert(res.errorMessage);
								}
							} else if (res.errorCode == "FIELD_ERROR") {
								if (typeof fieldErrorCallBack != 'undefined' && fieldErrorCallBack != null) {
									fieldErrorCallBack(dialogId, actionBtnId, res);
								} else {
									$(formId).replaceWith(res.content);
								}
							} else {
								if (typeof actionErrorCallBack != 'undefined' && actionErrorCallBack != null) {
									actionErrorCallBack(dialogId, actionBtnId, res);
								} else {
									alert(res.errorMessage);
								}
							}
						}
					}).fail(function(jqXHR, textStatus, error){
						alert("System error.");
						App.unblockUI();
					});
				});
			} else if (res.errorCode == "FIELD_ERROR") {
				if (typeof fieldErrorCallBack != 'undefined' && fieldErrorCallBack != null) {
					fieldErrorCallBack(dialogId, actionBtnId, res);
				} else {
					alert(res.errorMessage);
				}
			} else {
				if (typeof actionErrorCallBack != 'undefined' && actionErrorCallBack != null) {
					actionErrorCallBack(dialogId, actionBtnId, res);
				} else {
					alert(res.errorMessage);
				}
			}
		}
	}).fail(function(jqXHR, textStatus, error){
		alert("System error.");
		App.unblockUI();
	});
}


function simpleModalUpload(dialogId, formId, uuid, gUrl){
	App.blockUI();
	var data = {};
	if(formId != "" && formId != null){
		data = new FormData();
		var inputs = $(formId + ' input, ' + formId + ' select,' + formId + ' textarea');
		$.each(inputs, function(obj, v){
			var name = $(v).attr("name");
			if ($(v).attr("type") == "file") {
				var id = $(v).attr("id");
				var input = document.getElementById(id);
				for (var indexElement = 0; indexElement < input.files.length; indexElement++) {
					data.append(name + "[" + indexElement + "]", input.files[indexElement]);
				}
			} else if ($(v).attr("type") == "radio") {
				if ($(v).is(':checked')) {
					data.append(name, $(v).val());
				}
			} else {
				data.append(name, $(v).val());
			}
		});
	}
	$.ajax({
		url: gUrl + getAppendIntact(gUrl) + "rid=" + uuid,
		data: data,
		success: function(res){
			App.unblockUI();
			if (res.errorCode == "SUCCESS") {
				App.unblockUI();
				$(dialogId).html(res.content).promise().done(function(){
					$(dialogId).modal();
				});
			}
		}
	}).fail(function(jqXHR, textStatus, error){
		alert("System error.");
		App.unblockUI();
	});
}


function guid(){
	function s4(){
		return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
	}

	return s4() + s4() + s4() + s4() + s4() + s4() + s4() + s4();
}