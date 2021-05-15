<?php
use core\Lang;
use core\utils\ActionUtil;
?>

<!-- sortable widget -->
<script type="text/javascript">
    var sortable_element_id = '';
    var gridIdSource = 0;
    var widgetContentIdSortable = 0;
    $(".grid_widget_list<?=$containerId?>").sortable({
        start: function(event, ui){
            console.log('.grid_widget_list<?=$containerId?> sortable start');
            sortable_element_id = $(ui.item).attr('id');
            gridIdSource = $('#'+sortable_element_id).parent('ul').data('gridid');
            widgetContentIdSortable = $('#'+sortable_element_id).data('widgetcontentid');
            //console.log(`ortable start sortable_element_id = ${sortable_element_id} ... gridIdSource = ${gridIdSource}`);
        },
        stop: function(){
            console.log('.grid_widget_list<?=$containerId?> sortable stop');
            var gridWidgetListTarget = [];
            var order = 0;
            var gridIdTarget = 0;
            $('#'+sortable_element_id).parent().find('.grid_widget_item').each(function(){
                order++;
                //update data-order
                $(this).attr('data-order', order);
                //update data-gridid
                gridIdTarget = $(this).parent('ul').data('gridid');
                $(this).attr('data-gridid', gridIdTarget);
                //update data
                var gridWidgetId = $(this).data('gridwidgetid');
                var widgetContentId = $(this).data('widgetcontentid');
                var gridWidgetData = {'gridWidgetId': gridWidgetId, 'widgetContentId': widgetContentId, 'order': order};
                gridWidgetListTarget.push(gridWidgetData);
            });

            var containerId = <?=$containerId?>;
            var data = {'gridIdSource': gridIdSource, 'gridIdTarget': gridIdTarget,
                'widgetContentIdSortable': widgetContentIdSortable, 'gridWidgetListTarget': gridWidgetListTarget};
            //console.log(data);
            simpleAjaxPost(
                guid(),
                "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/widget/sortable?rtype=json")?>" + `&containerId=${containerId}`,
                data,
                function (res){	//success callback
                    var message = '<?php echo Lang::get('The layout updated successfully')?>';
                    showMessage(message, 'success', true);
                    //change view (reload data)
                    $("#layout-data<?=$containerId?>").html(res.content);
                },
                null,			//field error callback
                function (res){	//action error	callback
                    showMessage(res.errorMessage, "error", true);
                    //change view (reload data)
                    $("#layout-data<?=$containerId?>").html(res.content);
                }
            );
        },
        over: function(){
            $(this).addClass('sortable_over');
            $(this).find('.ui-sortable-placeholder').addClass('widget_item_placeholder');
            $(this).find('.ui-sortable-placeholder').attr('style', '');
        },
        out: function(){
            $(this).removeClass('sortable_over');
        }
    });
    $(".grid_widget_list<?=$containerId?>").sortable({
        connectWith: ".connectedSortable<?=$containerId?>"
    }).disableSelection();
</script>

<!-- sortable grid -->
<script type="text/javascript">
    function gridSortable<?=$containerId?>(){
        var i = 0;
        var gridList = [];
        $('li.grid').each(function(){
            i++;
            var gridId = $(this).data('gridid');
            var parentId = $(this).parents('li.grid').data('gridid');
            if(typeof(parentId) === 'undefined') parentId = 0;
            var order = $(this).data('order');
// 			console.log(`gridId = ${gridId} ... parentId = ${parentId} ... order = ${order} -> ${i}`);

            var gridData = {'gridId': gridId, 'parentId': parentId, 'order': i};
            gridList.push(gridData);
        });
        return gridList;
    }

    var layout_grid_height = 0;
    $(".layout_grid<?=$containerId?>").sortable({
        start: function(event, ui){
            console.log('.layout_grid<?=$containerId?> sortable start');
            sortable_element_id = $(ui.item).attr('id');
            layout_grid_height = $('#'+sortable_element_id).outerHeight();
        },
        stop: function(){
            console.log('.layout_grid<?=$containerId?> sortable stop');
            var gridList = gridSortable<?=$containerId?>();
            //ajax
            var containerId = <?=$containerId?>;
            var data = {'gridList': gridList};
            simpleAjaxPost(
                guid(),
                "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/sortable?rtype=json")?>" + `&containerId=${containerId}`,
                data,
                function (res){	//success callback
                    var message = '<?php echo Lang::get('The layout updated successfully')?>';
                    showMessage(message, 'success', true);
                    $("#layout-data<?=$containerId?>").html(res.content);
                }
            );
        },
        over: function(){
            $(this).addClass('sortable_over');
            $(this).find('.ui-sortable-placeholder').addClass('widget_item_placeholder');
            $(this).find('.ui-sortable-placeholder').attr('style', `height: ${layout_grid_height}px`);
        },
        out: function(){
            $(this).removeClass('sortable_over');
        }
    });
    $(".layout_grid<?=$containerId?>").sortable({
        connectWith: ".ul-sortable<?=$containerId?>"
    }).disableSelection();

    $(".grid_parent<?=$containerId?> > ul").sortable({
        start: function(event, ui){
            console.log('.grid_parent<?=$containerId?> ul sortable start');
            sortable_element_id = $(ui.item).attr('id');
            layout_grid_height = $('#'+sortable_element_id).outerHeight();
        },
        stop: function(){
            console.log('.grid_parent<?=$containerId?> ul sortable stop');
            var gridList = gridSortable<?=$containerId?>();
            //ajax
            var containerId = <?=$containerId?>;
            var data = {'gridList': gridList};
            simpleAjaxPost(
                guid(),
                "<?=ActionUtil::getFullPathAlias("admin/container/layout/grid/sortable?rtype=json")?>" + `&containerId=${containerId}`,
                data,
                function (res){	//success callback
                    var message = '<?php echo Lang::get('The layout updated successfully')?>';
                    showMessage(message, 'success', true);
                    $("#layout-data<?=$containerId?>").html(res.content);
                }
            );
        },
        over: function(){
            $(this).addClass('sortable_over');
            $(this).find('.ui-sortable-placeholder').addClass('widget_item_placeholder');
            $(this).find('.ui-sortable-placeholder').attr('style', `height: ${layout_grid_height}px`);
        },
        out: function(){
            $(this).removeClass('sortable_over');
        }
    });
    $(".grid_parent<?=$containerId?> > ul").sortable({
        connectWith: ".ul-sortable<?=$containerId?>"
    }).disableSelection();
</script>