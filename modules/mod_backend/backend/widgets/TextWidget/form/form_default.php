<?php

namespace layout\widgets;

use common\template\extend\SelectInput;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\RequestUtil;

// get data (exist data $widgetContentInfo and $widgetContentLangs)
$widgetId = $widgetContentInfo->widgetId;
$widgetData = RequestUtil::get ( 'widgetData' );
?>
<div class="form-body" style="margin-left: 15px; margin-right: 15px;">
	<?php
	// get $setting
	$setting = ($widgetContentInfo->setting || $widgetContentInfo->setting != '') ? json_decode ( $widgetContentInfo->setting, true ) : array ();
	// set setting default
	$setting ['title'] = (isset ( $setting ['title'] )) ? $setting ['title'] : '';
	$setting ['showTitle'] = (isset ( $setting ['showTitle'] )) ? $setting ['showTitle'] : 1;
	$setting ['content'] = (isset ( $setting ['content'] )) ? $setting ['content'] : '';
	
	$text = new TextInput ( 'text_input_fluid' );
	$text->name = "widgetContentVo[setting][title]";
	$text->label = Lang::get ( "Title" );
	$text->value = $setting ['title'];
	$text->render ();
	
	$select = new SelectInput ( "select_input_fluid" );
	$select->name = "widgetContentVo[setting][showTitle]";
	$select->label = Lang::get ( "Show title" );
	$select->collections = ApplicationConfig::get ( 'layout.yn.list' );
	$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
	$select->value = $setting ['showTitle'];
	$select->render ();
	
	$text = new TextArea ( 'textarea_fluid' );
	$text->name = "widgetContentVo[setting][content]";
	$text->label = Lang::get ( "Content" );
	$text->class = "ckeditor";
	$text->value = htmlentities($setting ['content']);
	$text->render ();
	?>
</div>