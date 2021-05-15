<?php

use core\Lang;
use core\utils\ActionUtil;

$dirFiles = $_REQUEST ['fileList'];
$subFolders = $_REQUEST ['subFolders'];
?>
<div id="drop_zone" class="image_list">
	<a class="btn btn-primary popup left" title="<?= Lang::get("Add Folder") ?>" onclick="addFolders()" href="#"><?= Lang::get("Add Folder") ?></a>
	<a class="btn btn-primary popup left" title="<?= Lang::get("Add Files") ?>" onclick="addFile()" href="#"><?= Lang::get("Add Files") ?></a>
	<a class="btn btn-primary popup right" title="<?= Lang::get("Delete") ?>" href="#" onclick="checkAllFiles()"><?= Lang::get("Check All") ?></a>
	<a class="btn btn-primary popup right" title="<?= Lang::get("Delete") ?>" href="#" onclick="checkNoneFiles()"><?= Lang::get("Check None") ?></a>
	<a class="btn btn-primary popup left" title="<?= Lang::get("Delete") ?>" href="#" onclick="deleteFiles()"><?= Lang::get("Delete") ?></a>
	<p><b><?= Lang::get("Category:") ?> <?= isset($_REQUEST['pid']) ? $_REQUEST['pid'] : "default" ?></b></p>
	<?php foreach ($subFolders as $subFolder) { ?>
		<div style="background-color: #ffde94;">
			<input type="checkbox" name="subFolders[]" value="<?= $subFolder ?>">
			<a title="<?= $subFolder ?>" href="#" ondblclick="showFolders(<?= $subFolder ?>)"><?= $subFolder ?></a>
		</div>
	<?php } ?>
	<?php
	if (count($subFolders) > 0) {
		?>
		<p style="clear: both; margin: 10px;">--------------------------------------</p>
		<?php
	}
	?>

	<?php foreach ($dirFiles as $fileMo) { ?>
		<div class="image_center image_item">
			<input type="checkbox" name="fileIds[]" value="<?= $fileMo->fileId ?>">
			<img src="<?= $fileMo->thumbUrl ?>"
			     ondblclick="selectImage('<?= ($fileMo->url) ?>','<?= ($fileMo->thumbUrl) ?>','<?= $fileMo->fileId ?>','<?= $fileMo->relativeUrl ?>')"
			     class="thumbnails" title="<?= $fileMo->fileName ?>"/>
		</div>
	<?php } ?>
</div>
<input type="hidden" id="ip_cache_id" value="<?= isset($_REQUEST['field_id']) ? $_REQUEST['field_id'] : "" ?>" name="field_id">
<input type="hidden" id="pid" value="<?= isset($_REQUEST['pid']) ? $_REQUEST['pid'] : "" ?>" name="pid">
<input type="hidden" id="ckid" value="<?= isset($_REQUEST['ckid']) ? $_REQUEST['ckid'] : "" ?>" name="ckid">

<div>
	<div class="progress progress-striped active">
		<div class="progress-bar progress-bar-success" id="progress-wrp" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%; display: none">
			<span id="status"> 0% complete </span>
		</div>
	</div>
	<div>
		<p class="text-center"><?= Lang::get("Please double click or drag &amp; drop image files to upload, single click to select") ?>
			<br> Copy-right by HPD</p>
	</div>
	<div id="output">
		<!-- error or success results -->
	</div>
</div>
<input type="file" id="getFile" name="btnFile[]" multiple/>
<script type="text/javascript">
    var result_output = '#output';
    var progress_bar_id = '#progress-wrp';

    function addFile(){
        $("#getFile").trigger("click");
    }
    $("#getFile").on("change", function (event) {
        var files = event.currentTarget.files;
        if (files.length) {
            loadImage(files);
        }
    });

    function handleFileSelect(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        var files = evt.dataTransfer.files;
        loadImage(files);
    }

    function handleDragOver(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        evt.dataTransfer.dropEffect = 'drop';
    }

    var dropZone = document.getElementById('drop_zone');
    dropZone.addEventListener('dragover', handleDragOver, false);
    dropZone.addEventListener('drop', handleFileSelect, false);

    function setupReader(file) {
        var name = file.name;
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#drop_zone').append('<div class="image_center image_item"><img src="' + e.target.result + '" class="thumbnails" width="200"/></div>');
        }
        reader.readAsDataURL(file);
    }

    function loadImage(files) {
        var approvedHTML = "";
        var unapprovedHTML = "";
        for (var x in files) {
            var filesize = ((files[x].size / 1024) / 1024).toFixed(4);
            if (files[x].name != "item" && typeof files[x].name != "undefined") {
                if (filesize <= 10) {
                    if (unapprovedHTML == "") {
                        approvedHTML += files[x].name;
                    } else {
                        approvedHTML += ", " + files[x].name;
                    }
                } else {
                    if (unapprovedHTML == "") {
                        unapprovedHTML += files[x].name;
                    } else {
                        unapprovedHTML += ", " + files[x].name;
                    }
                }
            }
        }
        if (unapprovedHTML != "") {
            alert("The uploaded file exceeds the MAX FILE SIZE directive : " + unapprovedHTML);
            return;
        }

        if (files.length > 0) {
            for (i = 0; i < files.length; i++) {
                setupReader(files[i]);
            }
        }
        upload(files);
    }

    function upload(files) {
        $(".progress-bar").show();
        $(".progress-bar").css("width", "0%");
        $(progress_bar_id + " #status").text("0%");

        var form_data = new FormData();
        for (var i = 0; i < files.length; i++) {
            form_data.append("myfile[]", files[i]);
        }
        form_data.append("pid", $("#pid").val());
        $.ajax({
            url: "<?=ActionUtil::getFullPathAlias("file/manager/upload")?>?rtype=json",
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        $(".progress-bar").css("width", +percent + "%");
                        $(progress_bar_id + " #status").text(percent + "%");
                    }, true);
                }
                return xhr;
            },
            mimeType: "multipart/form-data"
        }).done(function (res) {
            if (typeof res !== 'object') {
                res = JSON.parse(res);
            }
            if (res.errorCode == "SUCCESS") {
            } else if (res.errorCode == "FIELD_ERROR") {
                alert(res.errorMessage);
            } else {
                alert(res.errorMessage);
            }
            location.reload(true);
        });

    }

    $(document).on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });
    $(document).on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });
    $(document).on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });

    function selectImage(url, thumbUrl, fileId, relavetivePath) {
        var id = $("#ip_cache_id").val();
        var ckid = $("#ckid").val();
        parent.dato_filemanager_callback(id, url, thumbUrl, fileId, ckid, relavetivePath);
    }

    function deleteFiles() {
        var data = new FormData();
        var url = "<?=ActionUtil::getFullPathAlias("file/manager/delete")?>?rtype=json";
        var formId = "#drop_zone";
        var inputs = $(formId + ' input, ' + formId + ' select,' + formId + ' textarea');
        $.each(inputs, function (obj, v) {
            var name = $(v).attr("name");
            if ($(v).is(':checked')) {
                data.append(name, $(v).val());
            }
        });
        $.ajax({
            type: 'POST',
            url: url + getAppendIntact(url) + "rid=" + guid(),
            data: data,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.errorCode == "SUCCESS") {
                    alert(res.errorMessage);
                } else if (res.errorCode == "FIELD_ERROR") {
                    alert(res.errorMessage);
                } else {
                    alert(res.errorMessage);
                }
                location.reload(true);
            },
            async: true
        }).fail(function (jqXHR, textStatus, error) {
            alert("System error.");
        });
    }

    function checkAllFiles() {
        $('#drop_zone input[type=checkbox]').each(function () {
            this.checked = true;
        });
    }

    function addFolders() {
        var folderName = prompt("Please enter your folder name:", "folder_name");
        if (folderName == null || folderName == "") {
            txt = "User cancelled the prompt.";
        } else {
            var data = new FormData();
            data.append("folderName", folderName);
            data.append("pid", $("#pid").val());
            var url = "<?=ActionUtil::getFullPathAlias("file/manager/folder/add")?>?rtype=json";
            $.ajax({
                type: 'POST',
                url: url + getAppendIntact(url) + "rid=" + guid(),
                data: data,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.errorCode == "SUCCESS") {
                        alert(res.errorMessage);
                    } else if (res.errorCode == "FIELD_ERROR") {
                        alert(res.errorMessage);
                    } else {
                        alert(res.errorMessage);
                    }
                    location.reload(true);
                },
                async: true
            }).fail(function (jqXHR, textStatus, error) {
                alert("System error.");
            });
        }
    }

    function checkNoneFiles() {
        $('#drop_zone input[type=checkbox]').each(function () {
            this.checked = false;
        });
    }

    function getAppendIntact(url) {
        return (!/\?/.test(url) ? '?' : '&');
    }

    function showFolders(folderName) {
        var data = new FormData();
        var url = "<?=ActionUtil::getFullPathAlias("file/manager")?>?rtype=json";
        data.append("pid", folderName);
        $.ajax({
            type: 'POST',
            url: url + getAppendIntact(url) + "rid=" + guid(),
            data: data,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.errorCode == "SUCCESS") {
                    alert(res.errorMessage);
                } else if (res.errorCode == "FIELD_ERROR") {
                    alert(res.errorMessage);
                } else {
                    alert(res.errorMessage);
                }
                location.reload(true);
            },
            async: true
        }).fail(function (jqXHR, textStatus, error) {
            alert("System error.");
        });
    }

    function guid() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
        }

        return s4() + s4() + s4() + s4() + s4() + s4() + s4() + s4();
    }
</script>