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