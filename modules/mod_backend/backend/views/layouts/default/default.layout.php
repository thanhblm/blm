<?php

use core\Decorator;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\ActionUtil;

?>
<!DOCTYPE html>

<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title><?= RequestUtil::get("pageTitle") ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="Preview page of Metronic Admin Theme #3 for " name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="icon" href="<?=AppUtil::resource_url("global/img/favicon.ico")?>">
    <link href="<?= AppUtil::resource_url("global/css/fonts.css") ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= AppUtil::resource_url("global/plugins/font-awesome/css/font-awesome.min.css") ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= AppUtil::resource_url("global/plugins/simple-line-icons/simple-line-icons.min.css") ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= AppUtil::resource_url("global/plugins/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= AppUtil::resource_url("global/plugins/bootstrap-switch/css/bootstrap-switch.min.css") ?>" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?= AppUtil::resource_url("global/css/components.css") ?>" rel="stylesheet" id="style_components" type="text/css"/>
    <link href="<?= AppUtil::resource_url("global/css/plugins.css") ?>" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?= AppUtil::resource_url("global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css") ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= AppUtil::resource_url("global/plugins/bootstrap-modal/css/bootstrap-modal.css") ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= AppUtil::resource_url("global/plugins/bootstrap-sweetalert/sweetalert.css") ?>" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?= AppUtil::resource_url("layouts/layout3/css/layout.min.css") ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= AppUtil::resource_url("layouts/layout3/css/themes/default.min.css") ?>" rel="stylesheet" type="text/css" id="style_color"/>

    <!-- BEGIN CORE PLUGINS -->
    <script src="<?= AppUtil::resource_url("global/plugins/jquery.min.js") ?>" type="text/javascript"></script>
    <script src="<?= AppUtil::resource_url("global/plugins/jquery-ui/jquery-ui.min.js") ?>" type="text/javascript"></script>
    <script src="<?= AppUtil::resource_url("global/plugins/bootstrap/js/bootstrap.min.js") ?>" type="text/javascript"></script>
    <script src="<?= AppUtil::resource_url("global/plugins/js.cookie.min.js") ?>" type="text/javascript"></script>
    <script src="<?= AppUtil::resource_url("global/plugins/jquery-slimscroll/jquery.slimscroll.min.js") ?>" type="text/javascript"></script>
    <script src="<?= AppUtil::resource_url("global/plugins/bootstrap-switch/js/bootstrap-switch.min.js") ?>" type="text/javascript"></script>
    <script src="<?= AppUtil::resource_url("global/plugins/jquery.blockui.min.js") ?>" type="text/javascript"></script>
    <script src="<?= AppUtil::resource_url("global/plugins/bootstrap-sweetalert/sweetalert.min.js") ?>" type="text/javascript"></script>
    <script src="<?= AppUtil::resource_url("global/plugins/jquery-repeater/jquery.repeater.min.js") ?>" type="text/javascript"></script>


    <script src="<?= AppUtil::resource_url("global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js") ?>" type="text/javascript"></script>
    <script src="<?= AppUtil::resource_url("global/plugins/bootstrap-modal/js/bootstrap-modal.js") ?>" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- bootstrap-select taipv -->
    <script src="<?= AppUtil::resource_url("global/plugins/bootstrap-select/js/bootstrap-select.min.js") ?>" type="text/javascript"></script>
    <link href="<?= AppUtil::resource_url("global/plugins/bootstrap-select/css/bootstrap-select.min.css") ?>" rel="stylesheet" type="text/css"/>

    <!-- bootstrap-checkbox taipv -->
    <script src="<?= AppUtil::resource_url("global/plugins/bootstrap-checkbox/js/bootstrap-checkbox.min.js") ?>" type="text/javascript"></script>

    <!-- fancy_box taipv -->
    <script src="<?= AppUtil::resource_url("global/plugins/fancybox/source/jquery.fancybox.js") ?>" type="text/javascript"></script>
    <link href="<?= AppUtil::resource_url("global/plugins/fancybox/source/jquery.fancybox.css") ?>" rel="stylesheet" type="text/css"/>

    <!-- auto_numeric taipv -->
    <script src="<?= AppUtil::resource_url("global/plugins/auto_numeric/autoNumeric.js") ?>" type="text/javascript"></script>

    <!-- bootstrap-datepicker taipv  -->
    <script src="<?= AppUtil::resource_url("global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") ?>" type="text/javascript"></script>
    <link href="<?= AppUtil::resource_url("global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css") ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= AppUtil::resource_url("global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css") ?>" rel="stylesheet" type="text/css"/>

    <!-- bootstrap-toastr taipv -->
    <script src="<?= AppUtil::resource_url("global/plugins/bootstrap-toastr/toastr.min.js") ?>" type="text/javascript"></script>
    <link href="<?= AppUtil::resource_url("global/plugins/bootstrap-toastr/toastr.min.css") ?>" rel="stylesheet" type="text/css"/>

    <!-- custom style taipv -->
    <link href="<?= AppUtil::resource_url("global/css/dato.common.css") ?>" rel="stylesheet" type="text/css"/>
    <script src="<?= AppUtil::resource_url("global/scripts/app.js") ?>" type="text/javascript"></script>

    <!-- select2 dangdh -->
    <script src="<?= AppUtil::resource_url("global/plugins/select2/js/select2.full.min.js") ?>" type="text/javascript"></script>

    <link href="<?= AppUtil::resource_url("global/plugins/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= AppUtil::resource_url("global/plugins/select2/css/select2-bootstrap.min.css") ?>" rel="stylesheet" type="text/css"/>

    <!-- Dato custom scripts -->
    <script src="<?= AppUtil::resource_url("global/scripts/dato.tablesorter.js") ?>" type="text/javascript"></script>
    <script src="<?= AppUtil::resource_url("global/scripts/dato.common.js") ?>" type="text/javascript"></script>

	<link href="<?= AppUtil::resource_url("layouts/layout3/css/custom.css") ?>" rel="stylesheet" type="text/css"/>

</head>
<!-- END HEAD -->
<body class="page-container-bg-solid">
<div class="page-wrapper">
    <div class="page-wrapper-row">
        <div class="page-wrapper-top">
            <!-- BEGIN HEADER -->
            <div class="page-header">
                <!-- BEGIN HEADER TOP -->
                <div class="page-header-top">
                    <div class="container-fluid">
                        <!-- BEGIN LOGO -->
                        <div class="page-logo">
                            <a href="<?= ActionUtil::getFullPathAlias("admin/dashboard") ?>">
                                <img src="<?= AppUtil::resource_url("global/img/vdato-logo.png") ?>" width="200px" alt="logo">
                            </a>
                        </div>
                        <!-- END LOGO -->
                        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                        <a href="javascript:;" class="menu-toggler"></a>
                        <!-- END RESPONSIVE MENU TOGGLER -->
                        <!-- BEGIN TOP NAVIGATION MENU -->
                        <div class="top-menu">
                            <?php include 'includes/backend-header.php'; ?>
                        </div>
                        <!-- END TOP NAVIGATION MENU -->
                    </div>
                </div>
                <!-- END HEADER TOP -->
                <!-- BEGIN HEADER MENU -->
                <div class="page-header-menu">
                    <div class="container-fluid">
                        <!-- BEGIN HEADER SEARCH BOX -->
                        <!-- form class="search-form" action="page_general_search.html" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" name="query">
                                <span class="input-group-btn"> <a href="javascript:;" class="btn submit"> <i class="icon-magnifier"></i>
									</a>
									</span>
                            </div>
                        </form-->
                        <!-- END HEADER SEARCH BOX -->
                        <!-- BEGIN MEGA MENU -->
                        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                        <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                        <div class="hor-menu  ">
                            <?php include 'includes/backend-menu.php'; ?>
                        </div>
                        <!-- END MEGA MENU -->
                    </div>
                </div>
                <!-- END HEADER MENU -->
            </div>
            <!-- END HEADER -->
        </div>
    </div>
    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="container-fluid">
                            <?php include Decorator::getBodyPath() ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTAINER -->
        </div>
    </div>
    <?php include 'includes/backend-footer.php'; ?>
</div>
<!-- END THEME GLOBAL SCRIPTS -->
<script src="<?= AppUtil::resource_url("layouts/layout3/scripts/layout.min.js") ?>" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="<?= AppUtil::resource_url("global/scripts/plugin.init.js") ?>" type="text/javascript"></script>

<!-- tinymce taipv -->
<script src="<?= AppUtil::resource_url("global/scripts/tinymce/tinymce.min.js") ?>" type="text/javascript"></script>
<!-- tinymce taipv -->
<script src="<?= AppUtil::resource_url("global/plugins/ckeditor/ckeditor.js") ?>" type="text/javascript"></script>
<script src="<?= AppUtil::resource_url("global/plugins/ckeditor/adapters/jquery.js") ?>" type="text/javascript"></script>

<!-- tinymce end -->
<script type="text/javascript">
    //hungnt - auto define active menu
    $(document).ready(function () {
        var currentURL = location.protocol + '//' + location.host + location.pathname;
        var selector = $('ul.navbar-nav a[href="' + currentURL + '"]');
        selector.closest('li.menu-dropdown').addClass('active');
        selector.parent().addClass('active');
    });

    function tinyMCEInit() {
        tinymce.init({
            selector: "textarea.tinymce",
            entity_encoding: "raw",
            theme: "modern",
            height: 260,
            plugins: [
                "advlist autolink link lists charmap print preview hr anchor pagebreak",
                "wordcount code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality paste textcolor datofilemanager "
            ],
            content_css: "<?=AppUtil::resource_url("global/scripts/tinymce/css/content.css")?>",
            toolbar: "datofilemanager fontsizeselect | bold italic | forecolor backcolor | link responsivefilemanager media emoticons | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
            style_formats: [
                {title: 'Heading 1', inline: 'h1', classes: ''},
                {title: 'Heading 2', inline: 'h2', classes: ''},
                {title: 'Heading 3', inline: 'h3', classes: ''},
                {title: 'Heading 4', inline: 'h4', classes: ''},
            ],

            dato_filemanager_path: "<?=ActionUtil::getFullPathAlias('file/manager?pid=tinymce&field_id=tinymce')?>",
            dato_dialog_width :800,
			dato_dialog_height : 600,
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
            
        });

        tinymce.init({
            selector: "textarea.tinymce-mini",
            entity_encoding: "raw",
            theme: "modern",
            height: 160,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor datofilemanager"
            ],
            content_css: "<?=AppUtil::resource_url("global/scripts/tinymce/css/content.css")?>",
            toolbar: "bold italic | forecolor backcolor | link  emoticons | alignleft aligncenter alignright alignjustify | bullist numlist",
            statusbar: false,
            menubar: false,
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });
    }

    var dato_file_manager_url = "<?=ActionUtil::getFullPathAlias('file/manager?pid=tinymce&field_id=ckeditor')?>";
    
    function dato_filemanager_callback(id,url,thumbUrl,fileId,ckid, relavetivePath) {
        switch (id) {
            case 'image_add': // case image_add (not test)
                var index = $('ul.input_multi_file li').size() + 1;
                var data = "imageUrl="+fileId+"&index="+index;
                simpleAjaxPost(
            			guid(),
            			"<?=ActionUtil::getFullPathAlias("admin/file/add/multi/image?rtype=json")?>",
            			data,
            			onAddImageSuccess,
            			onAddImageFieldErrors,
            			onAddImageActionErrors
            		);
                break;
            case 'tinymce':
                tinymce.activeEditor.execCommand('mceInsertContent', false, "<p><img src='"+url+"' width=100/></p>");
                tinymce.activeEditor.windowManager.close();
                break;  
            case 'ckeditor':
                $("#dfilemanage_editor").modal('toggle');
                $("#dfilemanage_editor").remove();

                var currentInstance = ckid;
                if (currentInstance !== null && currentInstance !== ''){
                	var oEditor   = CKEDITOR.instances[currentInstance];
                	oEditor.insertHtml(  "<p><img src='"+relavetivePath+"' width=200'/></p>" );
                }     
                break;    
            default: // (insert n image on 1 page)
                $('#' + id).parents('.input_file').find('.image_source').attr('value', fileId);
                $('#' + id).parents('.input_file').find('.image_preview').attr('src', thumbUrl);
                $('#' + id).parents('.input_file').find('.image_preview_link').attr('href', url);
                break;
        }
        parent.$.fancybox.close();
    }
    
    function onAddImageSuccess(res){
    	$('ul.input_multi_file').append(res.content);
	}
	function onAddImageFieldErrors(res){
		
	}
	function onAddImageActionErrors(res){
		
	}
</script>
</body>

</html>