<?php
namespace layout\widgets;
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\RequestUtil;

$customerViewList = RequestUtil::get ( 'customerViewList' );
?>
<div class="tabbable-line">
    <?php
    // get $setting
    $setting = ($widgetContentInfo->setting || $widgetContentInfo->setting != '') ? json_decode ( $widgetContentInfo->setting, true ) : array ();
    // set setting default
    $setting ['action'] = (isset ( $setting ['action'] )) ? $setting ['action'] : '';

    $text = new TextInput();
    $text->name = "widgetContentVo[setting][action]";
    $text->label = Lang::get ( "Action" );
    $text->value = $setting ['action'];
    $text->render ();
    ?>
</div>