<?php
namespace layout\widgets;
use common\template\extend\SelectInput;
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
    $setting ['customView'] = (isset ( $setting ['customView'] )) ? $setting ['customView'] : '';

    $select = new SelectInput();
    $select->name = "widgetContentVo[setting][customView]";
    $select->label = Lang::get ( "Select a view" );
    $select->collections = $customerViewList;
    $select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
    $select->value = $setting ['customView'];
    $select->render ();
    ?>
</div>