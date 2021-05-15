//checkboxpicker (use bootstrap-checkbox plugin) [taipv]
$(document).ready(function () {
    $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner =
        '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
        '<div class="progress progress-striped active">' +
        '<div class="progress-bar" style="width: 100%;"></div>' +
        '</div>' +
        '</div>';

    $.fn.modalmanager.defaults.resize = true;
    $('.checkboxpicker').checkboxpicker();
    $(".draggable-modal").draggable({
        handle: ".modal-header"
    });
    // apply for show image
    $(".fancybox").fancybox();
    // apply for select image from file manage or view page
    // popup
    $('.popup').fancybox({
        type: 'iframe',
        fitToView: true,
        width: '80%',
        height: '80%',
        autoSize: false,
        closeClick: true,
        openEffect: 'none',
        closeEffect: 'none',
        title: '',
    });
    $('.popup-max').fancybox({
        type: 'iframe',
        fitToView: true,
        width: '95%',
        height: '95%',
        autoSize: false,
        closeClick: true,
        openEffect: 'none',
        closeEffect: 'none',
        title: '',
    });
    $('.popup-auto').fancybox({
        type: 'iframe',
        fitToView: true,
        width: 'auto',
        height: 'auto',
        autoSize: false,
        closeClick: true,
        openEffect: 'none',
        closeEffect: 'none',
    });
});

/**
 * function callback when select image from file manage popup [taipv]
 *
 * ok case1: single select image (field_id == 'image_select') (file_form.php)
 * (insert 1 image on 1 page) case2: add image (field_id == 'image_add')
 * (multi_file_form.php) case3: select (changle) image (field_id ==
 * 'image_list') (multi_file_form.php) default: (field_id ==
 * 'image_select_%id%') (file_form.php) (insert n image on 1 page set by id)
 */
//function responsive_filemanager_callback(field_id) {
//    switch (field_id) {
//        case 'image_add': // case image_add (not test)
//            var url = $('#' + field_id).val();
//            var index = $('ul.input_multi_file li').size() + 1;
//            var data = {
//                'image': url,
//                'index': index
//            };
//            $.ajax({
//                type: "POST",
//                url: 'admin/file/add_image_ajax?rtype=json',
//                "<?=ActionUtil::getFullPathAlias("admin/product/add?rtype=json")?>",
//                data: data,
//                async: false,
//                complete: function (data) {
//                    // console.log(data);
//                    $('ul.input_multi_file').append(data.responseText);
//                },
//                error: function (xhr, desc, err) {
//                    console.log(xhr + "\n" + err);
//                }
//            });
//            break;
//        default: // (insert n image on 1 page)
//            var url = $('#' + field_id).val();
//            // console.log(`url = ${url} ... field_id = ${field_id}`);
//            $('#' + field_id).parents('.input_file').find('.image_source').attr('value', url);
//            $('#' + field_id).parents('.input_file').find('.image_preview').attr('src', url);
//            $('#' + field_id).parents('.input_file').find('.image_preview_link').attr('href', url);
//            break;
//    }
//    parent.$.fancybox.close();
//}

// show_notice use bootstrap-toastr plugin [taipv]
// status is 0 or false for error message else success message

function showMessage(message, status, isToastr) {
    if (typeof isToastr == "undefined" || isToastr == false) {
        if (typeof status == "undefined" || status == "" || status == null) {
            status = "success";
        } else {
            status = status.toLowerCase();
        }
        if (status == "success") {
            swal({
                title: "",
                text: message,
                type: status,
                showConfirmButton: false,
                timer: 1000
            });
        } else {
            swal({
                title: "",
                text: message,
                type: status,
            });
        }
    } else if (typeof isToastr != "undefined" && isToastr == true){
        toastr.options = {
            closeButton: true,
            debug: false,
            positionClass: 'toast-top-right',
            onclick: null
        };
        toastr.options.showDuration = '1000';
        toastr.options.hideDuration = '1000';
        toastr.options.timeOut = '5000';
        toastr.options.extendedTimeOut = '1000';
        toastr.options.showEasing = 'swing';
        toastr.options.hideEasing = 'linear';
        toastr.options.showMethod = 'fadeIn';
        toastr.options.hideMethod = 'fadeOut';
        toastr[status](message, status.toUpperCase());
    }
}
/*function showMessage(message, status) {

 }*/

// priceFormat use auto_numeric plugin [taipv]
$().ready(function () {
    $('input.price').autoNumeric('init')
})

// datepicker use bootstrap-datepicker plugin [taipv]
$(function () {
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
    });
});

//show percen (input has value/total input) in label tab [taipv]
function mutilLanguagesPercen(id){
	id = typeof(id) == "undefined" ? ".mutilLanguagesPercen" : id;
	var iTab = 0;
	var percen = [];
	$(id + ' .tab-content .tab-pane .form-body').each(function(){
		iTab++;
		//get form-group count
		var form_group_count = 0;
		$(this).find('.form-group').each(function(){
			form_group_count++;
		});
	
		var has_value_count = 0;
		//foreach for .form-control list
		$(this).find('.form-group .form-control').each(function(){
			 var val = $(this).val();
			 if(val != '') has_value_count++;
		});
		//foreach for textarea list
		$(this).find('.form-group textarea').each(function(){
			 var val = $(this).html();
			 if(val != '' && val != '<p></p>') has_value_count++;
		});
		 
		percen.push(`${has_value_count}/${form_group_count}`);
	});
	
	iTab = 0;
	$(id + ' ul.nav-tabs li').each(function(){
		var label = "<span class='mutil_languages_percen'>" +percen[iTab] + "</span>";
		$(this).append(label);
		iTab++;
	});
}

/**
 * showFieldError use then validate form not reload dialog [taipv]
 * demo admin/layout/widget/content/add
 * @param res data return of simpleAjaxPost function callback
 */
function simpleCUDModal_fieldErrorCallBack(dialogId, actionBtnId, res){
	showFieldError(res);
}
function simpleAjaxPost_fieldErrorCallBack(res){
	showFieldError(res);
}
function showFieldError(res){
    var errorMessage = JSON.parse(res.errorMessage);
    console.log('errorMessage');
    console.log(errorMessage);

	//reset validate
    resetValidate();
	
	for(name in errorMessage){
		var message = errorMessage[name];
		//console.log(`name = ${name} ... message = ${message}`);
		$('input[name="' +name+ '"]').focus();
		$('input[name="' +name+ '"]').parent().parent().addClass('has-error');
		$('input[name="' +name+ '"]').parent().parent().find('.help-block').html(message);
	}
}
function resetValidate(){
    $('.form-group').removeClass('has-error');
    $('.form-group').find('.help-block').html('');
}