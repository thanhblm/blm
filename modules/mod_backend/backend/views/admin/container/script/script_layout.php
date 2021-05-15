<?php
use core\Lang;
use core\utils\RequestUtil;
use core\utils\ActionUtil;
//get data
$containerId = RequestUtil::get("containerId");
?>

<!-- widgetContent action -->
<script type="text/javascript">
    function widgetContentAddView<?=$containerId?>(containerId, gridId){
        simpleCUDModal(
            "#layout_dialog_large",
            "#widget_content_add_form",
            guid(),
            "#btnSave",
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/widget/content/add/view?rtype=json")?>" + `&containerId=${containerId}&gridId=${gridId}`
        );
    };

    function widgetContentExistAdd<?=$containerId?>(gridId, widgetContentId) {
        //get data
        var data = {'gridId': gridId, 'widgetContentId': widgetContentId};
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/widget/content/exist/add?rtype=json")?>",
            data,
            function (res) {	//success callback
                refreshLayout<?=$containerId?>("#layout_dialog_large");
            },
            function (res) {	//field error callback
                showMessage(res.errorMessage, "error", true);
            }
        );
    };

    function widgetContentAdd<?=$containerId?>(gridId){
        //get data
        var data = $('#widget_content_add_form').serialize();
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/widget/content/add?rtype=json")?>" + `&gridId=${gridId}`,
            data,
            function (res){
                refreshLayout<?=$containerId?>("#layout_dialog_large");
            },
            simpleAjaxPost_fieldErrorCallBack
        );
    };

    //event select widget
    function widgetListSelect<?=$containerId?>(containerId, widgetId){
        var data = {'widgetId': widgetId};
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/widget/content/select/add?rtype=json")?>" + `&containerId=${containerId}`,
            data,
            function (res) {
                $('.widget_content_form').html(res.content);
            }
        );
    };

    function widgetContentEditView<?=$containerId?>(widgetContentId){
        simpleCUDModal(
            "#layout_dialog",
            "#widget_content_edit_form",
            guid(),
            "#btnSave",
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/widget/content/edit/view?rtype=json&widgetContentId=")?>" + widgetContentId,
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/widget/content/edit?rtype=json")?>",
            refreshLayout<?=$containerId?>,
            simpleCUDModal_fieldErrorCallBack
        );
    };

    function gridWidgetEditStatus<?=$containerId?>(containerId, gridId, widgetContentId, status){
        $.ajax({
            url: '<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/widget/edit/status")?>',
            type: 'post',
            data:{'containerId': containerId, 'gridId': gridId, 'widgetContentId': widgetContentId, 'status': status},
            success: function(res){
                //change view (reload res)
                $("#layout-data<?=$containerId?>").html(res);

                //message
                var message = '<?php echo Lang::get('The layout updated successfully')?>';
                showMessage(message, 'success', true);
            },
            error: function(xhr, desc, err){
                console.log(xhr + "\n" + err);
            }
        });
    }

    function gridWidgetDeleteView<?=$containerId?>(gridWidgetId, widgetContentId){
        simpleCUDModal(
            "#layout_dialog",
            "#grid_widget_delete_form",
            guid(),
            "#btnDelete",
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/widget/delete/view?rtype=json")?>" + `&gridWidgetId=${gridWidgetId}&widgetContentId=${widgetContentId}`,
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/widget/delete?rtype=json")?>",
            refreshLayout<?=$containerId?>
        );
    };

    function widgetContentDelete<?=$containerId?>(containerId, widgetContentId, widgetContentName){
        if(confirm('<?php echo Lang::get("Are you sure to delete item ")?>' + `"${widgetContentName}"`)){
            var data = {'widgetContentId': widgetContentId};
            simpleAjaxPost(
                guid(),
                "<?=ActionUtil::getFullPathAlias("admin/container/layout/widget/content/delete?rtype=json")?>" + `&containerId=${containerId}`,
                data,
                function (res){
                    //change view (reload data)
                    $("#layout-data<?=$containerId?>").html(res.content);

                    //message
                    var message = '<?php echo Lang::get('The widget deleted successfully')?>';
                    showMessage(message, 'success', true);

                    //remove element
                    $('#layout_dialog_large #select-block-' + widgetContentId).remove();
                }
            );
        }
    };
</script>

<!-- grid action -->
<script type="text/javascript">
    function gridAddView<?=$containerId?>(containerId, parentId){
        simpleCUDModal(
            "#layout_dialog",
            "#grid_add_form",
            guid(),
            "#btnSave",
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/add/view?rtype=json")?>" + `&containerId=${containerId}&parentId=${parentId}`,
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/add?rtype=json")?>",
            refreshLayout<?=$containerId?>
        );
    };

    function gridEditView<?=$containerId?>(gridId){
        simpleCUDModal(
            "#layout_dialog",
            "#grid_edit_form",
            guid(),
            "#btnSave",
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/edit/view?rtype=json&gridId=")?>" + gridId,
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/edit?rtype=json")?>",
            refreshLayout<?=$containerId?>
        );
    }

    function gridEditStatus<?=$containerId?>(containerId, gridId, status){
        $.ajax({
            url: '<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/edit/status")?>',
            type: 'post',
            data:{'containerId': containerId, 'gridId': gridId, 'status': status},
            success: function(res){
                //change view (reload res)
                $("#layout-data<?=$containerId?>").html(res);

                //message
                var message = '<?php echo Lang::get('The layout updated successfully')?>';
                showMessage(message, 'success', true);
            },
            error: function(xhr, desc, err){
                console.log(xhr + "\n" + err);
            }
        });
    }

    function gridDeleteView<?=$containerId?>(gridId){
        simpleCUDModal(
            "#layout_dialog",
            "#grid_delete_form",
            guid(),
            "#btnDelete",
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/delete/view?rtype=json&gridId=")?>" + gridId,
            "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/delete?rtype=json")?>",
            refreshLayout<?=$containerId?>
        );
    };
</script>

<!-- refreshLayout<?=$containerId?> -->
<script type="text/javascript">
    function refreshLayout<?=$containerId?>(dialogId,btnId,res){
        var data = {'containerId': <?=$containerId?>};
        $.post("<?=ActionUtil::getFullPathAlias("admin/container/layout/refresh?rtype=json")?>", data, function(res) {
            if (res.errorCode == "SUCCESS") {
                //update content
                $("#layout-data<?=$containerId?>").html(res.content);
                //show message
                var message = '<?php echo Lang::get('The layout updated successfully')?>';
                showMessage(message, 'success', true);
                //close dialog
                $(dialogId).modal("toggle");
                $(dialogId).html("");
            } else {
                alert(res.errorMessage);
            }
        }).fail(function() {
            alert("System error.");
        });
    }
</script>