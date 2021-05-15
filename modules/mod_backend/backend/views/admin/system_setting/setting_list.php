<?php
use core\Lang;
use core\utils\RequestUtil;
use core\utils\ActionUtil;
use common\template\extend\ImageInput;
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use common\template\extend\TextArea;
use common\template\extend\Button;

$groups = RequestUtil::get("groups");
$settings = RequestUtil::get("settings");
?>
<div class="page-content-inner">
    <div class="row">
        <div class="col-xs-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject bold uppercase"><?= Lang::get('System settings') ?></span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <ul class="nav nav-tabs tabs-left" id="setting_left_tab">
                                <?php
                                $isFirstGroup = true;
                                foreach ($groups as $group) {
                                    ?>
                                    <li class="<?= $isFirstGroup ? "active" : "" ?>" data-group-id="<?= $group->id ?>">
                                        <a href="#tab_<?= $group->id ?>" data-toggle="tab" aria-expanded="<?= $isFirstGroup ? "true" : "false" ?>"> <?= $group->name ?> </a>
                                    </li>
                                    <?php
                                    $isFirstGroup = false;
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <div class="tab-content">
                                <?php
                                $isFirstGroup = true;
                                foreach ($groups as $group) {
                                    ?>
                                    <div class="tab-pane <?= $isFirstGroup ? "active" : "fade" ?>" id="tab_<?= $group->id ?>">
                                        <form id="setting_edit_form_<?= $group->id ?>" class="form-horizontal" novalidate="novalidate">
                                            <div class="form-body">
                                                <?php
                                                $settingIndex = 0;
                                                foreach ($settings [$group->id] as $setting) {
                                                    ?>
                                                    <input type="hidden" name="editSettings[<?= $settingIndex ?>][id]" value="<?= $setting->id ?>"/>
                                                    <?php
                                                    switch ($setting->type) {
                                                        case "LIST" :
                                                            $select = new SelectInput ();
                                                            $select->value = $setting->value;
                                                            $select->name = "editSettings[" . $settingIndex . "][value]";
                                                            $select->collections = json_decode($setting->valueList, true);
                                                            $select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
                                                            $select->propertyName = "key";
                                                            $select->propertyValue = "value";
                                                            $select->label = Lang::get($setting->name);
                                                            $select->errorMessage = RequestUtil::getFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $select->hasError = RequestUtil::isFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $select->required = (0 === $setting->allowNull);
                                                            $select->render();
                                                            break;
                                                        case "TEXT" :
                                                            $text = new TextInput ();
                                                            $text->errorMessage = RequestUtil::getFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $text->hasError = RequestUtil::isFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $text->label = Lang::get($setting->name);
                                                            $text->required = (0 === $setting->allowNull);
                                                            $text->name = "editSettings[" . $settingIndex . "][value]";
                                                            $text->value = $setting->value;
                                                            $text->render();
                                                            break;
                                                        case "INT" :
                                                            $text = new TextInput ();
                                                            $text->errorMessage = RequestUtil::getFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $text->hasError = RequestUtil::isFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $text->label = Lang::get($setting->name);
                                                            $text->required = (0 === $setting->allowNull);
                                                            $text->name = "editSettings[" . $settingIndex . "][value]";
                                                            $text->value = $setting->value;
                                                            $text->class = "form-control numberic-int";
                                                            $text->render();
                                                            break;
                                                        case "FLOAT" :
                                                            $text = new TextInput ();
                                                            $text->errorMessage = RequestUtil::getFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $text->hasError = RequestUtil::isFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $text->label = Lang::get($setting->name);
                                                            $text->required = (0 === $setting->allowNull);
                                                            $text->name = "editSettings[" . $settingIndex . "][value]";
                                                            $text->value = $setting->value;
                                                            $text->class = "form-control numberic-float";
                                                            $text->render();
                                                            break;
                                                        case "IMAGE" :
                                                            $image = new ImageInput ();
                                                            $image->label = Lang::get($setting->name);
                                                            $image->errorMessage = RequestUtil::getFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $image->hasError = RequestUtil::isFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $image->required = (0 === $setting->allowNull);
                                                            $image->name = "editSettings[" . $settingIndex . "][value]";
                                                            $image->value = $setting->value;
                                                            $image->hasImgAction = true; // add
                                                            $image->id = "image_{$setting->id}"; // add required (unique)
                                                            $image->profileId = "setting";
                                                            $image->render();
                                                            break;
                                                       case "LONGTEXT" :
                                                           	$text = new TextArea("textarea_fluid");
                                                           	$text->class = "ckeditor";
                                                            $text->errorMessage = RequestUtil::getFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $text->hasError = RequestUtil::isFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $text->label = Lang::get($setting->name);
                                                            $text->required = (0 === $setting->allowNull);
                                                            $text->name = "editSettings[" . $settingIndex . "][value]";
                                                            $text->value = $setting->value;
                                                            $text->render();
                                                            break;
                                                        default :
                                                            $text = new TextInput ();
                                                            $text->errorMessage = RequestUtil::getFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $text->hasError = RequestUtil::isFieldError("editSettings[" . $settingIndex . "][value]");
                                                            $text->label = Lang::get($setting->name);
                                                            $text->required = (0 === $setting->allowNull);
                                                            $text->name = "editSettings[" . $settingIndex . "][value]";
                                                            $text->value = $setting->value;
                                                            $text->render();
                                                            break;
                                                    }
                                                    $settingIndex++;
                                                }
                                                ?>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                    $isFirstGroup = false;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding: 15px; padding-bottom:0px">
                            <div style="float: right">
                            	<?php
								$button = new Button();
								$button->type = "button";
								$button->id = "btnUpdateSettings";
								$button->title = " " . Lang::get ( "Save" );
								$button->class = "btn btn-sm blue margin-bottom-5";
								$button->attributes = "onclick='updateSystemSettings()'";
								$button->checkActionPath = "admin/system/setting/update";
								$button->render ();
								
								$button = new Button ();
								$button->type = "button";
								$button->id = "btnResetSettings";
								$button->title = " " . Lang::get ( "Cancel" );
								$button->class = "btn btn-sm btn-close margin-bottom-5";
								$button->attributes = "onclick='resetSystemSettings()' data-dismiss=\"modal\"";
								$button->render ();
								?>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
    	$("textarea.ckeditor").ckeditor();
        $("input.numberic-int").autoNumeric('init', {mDec: '0', eDec: '0'});
        $("input.numberic-float").autoNumeric('init');
    });
    function updateSystemSettings() {
        var activeTab = $("ul#setting_left_tab>li[class='active']");
        var formId = "#setting_edit_form_" + activeTab.data("group-id");
        var data = $(formId).serialize();
        $.post("<?=ActionUtil::getFullPathAlias("admin/system/setting/update?rtype=json")?>", data, function (res) {
            if (res.errorCode == "SUCCESS") {
                alert(res.errorMessage);
            } else {
                alert(res.errorMessage);
            }
        }).fail(function () {
            alert("System error.");
        });
    }
    function resetSystemSettings() {
        var activeTab = $("ul#setting_left_tab>li[class='active']");
        var formId = "#setting_edit_form_" + activeTab.data("group-id");
        $(formId).trigger("reset");
    }
</script>