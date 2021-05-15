<?php
use common\template\extend\Button;
use common\template\extend\FormContainer;
use core\Lang;
use core\utils\RequestUtil;

// get data
$gridVo = RequestUtil::get("gridVo");
$ajaxData = RequestUtil::get("ajaxData");
$containerId = RequestUtil::get("containerId");
$widgetGroup = $ajaxData ['widgetGroup'];
$widgetContentGroup = $ajaxData ['widgetContentGroup'];
$widgetContentDefault = $ajaxData ['widgetContentDefault'];

$form = new FormContainer ();
$form->id = "widget_content_add_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart();
?>
<div class="form-body">
    <ul class="nav nav-tabs widget_content_add_form_tab">
        <li class="active"><a data-toggle="tab" href="#tab1">
                <?= Lang::get('Use existing widget') ?>
            </a></li>
        <li class="_active"><a data-toggle="tab" href="#tab2">
                <?= Lang::get('Create new widget') ?>
            </a></li>
    </ul>
    <div class="tab-content widget_content_add_form">
        <div id="tab1" class="tab-pane fade in active">
            <div class="widget_content_exist_list">
                <?php
                if (empty ($widgetContentGroup)) {
                    echo "<div class='data_empty'>";
                    echo Lang::get('Widgets list is empty');
                    echo "</div>";
                } else {
                    foreach ($widgetContentGroup as $group) {
                        ?>
                        <h4>
                            <span><?= $group['name'] ?></span>
                        </h4>
                        <ul>
                            <?php
                            $i = 0;
                            $cols = 4;
                            foreach ($group['data'] as $widgetContentInfo) {
                                if (!$widgetContentInfo->public) continue;
                                $i++;
                                ?>
                                <li class="select-block cm-add-block col-md-3"
                                    id="select-block-<?= $widgetContentInfo->id ?>">
                                    <input type="hidden" name="widgetContentId" value="<?= $widgetContentInfo->id ?>">
                                    <input type="hidden" name="gridId" value="<?= $gridVo->id ?>">
                                    <a class="icon-remove-circle cm-tooltip cm-remove-block"
                                       title="<?= Lang::get('Delete widget') ?>"
                                       href="javascript:widgetContentDelete<?= $containerId ?>(<?= $containerId ?>, <?= $widgetContentInfo->id ?>, '<?= $widgetContentInfo->name ?>')">
                                        <i class="fa fa-close red"></i>
                                    </a>
                                    <a class="select-block-box widgetContentExistAdd"
                                       title="<?= Lang::get('Add widget') ?>"
                                       href='javascript:widgetContentExistAdd<?= $containerId ?>(<?= $gridVo->id ?>, <?= $widgetContentInfo->id ?>)'>
                                        <?php
                                        echo (!empty ($widgetContentInfo->widgetIcon)) ? "<i class='{$widgetContentInfo->widgetIcon} fa-2x'></i>" : "<i class='fa fa-bars fa-2x'></i>";
                                        ?>
                                    </a>
                                    <a class="select-block-description widgetContentExistAdd"
                                       title="<?= Lang::get('Add widget') ?>"
                                       href='javascript:widgetContentExistAdd<?= $containerId ?>(<?= $gridVo->id ?>, <?= $widgetContentInfo->id ?>)'>
                                        <strong><?= $widgetContentInfo->name ?></strong>
                                        <p>
                                            <?= (!empty($widgetContentInfo->description)) ? $widgetContentInfo->description : $widgetContentInfo->widgetDescription; ?>
                                        </p>
                                    </a>
                                </li>
                                <?= ($i%$cols==0) ? '<div class="clear"></div>' : '' ?>
                            <?php } ?>
                        </ul>
                        <?php
                    } // end foreach
                }
                ?>
            </div>
        </div>
        <!-- end #tab1 -->
        <div id="tab2" class="tab-pane fade _active">
            <div class="widget_content_form">
                <?php include 'widget_content_add_form_data.php' ?>
            </div>
            <div class="modal-footer">
                <a class="btn btn-sm blue" href='javascript:widgetContentAdd<?= $containerId ?>(<?= $gridVo->id ?>)'>
                    <?= Lang::get('Save') ?>
                </a>
                <?php
                $button = new Button ();
                $button->type = "button";
                $button->id = "";
                $button->title = " " . Lang::get("Cancel");
                $button->class = "btn btn-sm btn-close margin-bottom-5";
                $button->attributes = "data-dismiss=\"modal\"";
                $button->render();
                ?>
            </div>
        </div>
        <!-- end tab2 -->
    </div>
</div>
<?php $form->renderEnd(); ?>
<!-- accordion event hinh nhu khong chay-->
<script type="text/javascript">
    $().ready(function ($) {
        $("#accordion").accordion({
            heightStyle: "fill",
            active: 0
        });
        $("#accordion-resizer").resizable({
            minHeight: 360,
            minWidth: 200,
            resize: function () {
                $("#accordion").accordion("refresh");
            }
        });
    });
</script>