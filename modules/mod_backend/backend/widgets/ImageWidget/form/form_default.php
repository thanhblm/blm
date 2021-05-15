<?php

namespace layout\widgets;

use common\template\extend\ImageInput;
use common\template\extend\SelectInput;
use common\template\extend\Text;
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
	$setting ['imageId'] = (isset ( $setting ['imageId'] )) ? $setting ['imageId'] : 0;
	$setting ['url'] = (isset ( $setting ['url'] )) ? $setting ['url'] : '';
	$setting ['target'] = (isset ( $setting ['target'] )) ? $setting ['target'] : '_blank';
	
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
	
	$image = new ImageInput ();
	$image->name = "widgetContentVo[setting][imageId]";
	$image->label = Lang::get ( "Image" );
	$image->hasImgAction = true;
	$image->id = "imageId_default";
	$image->row = 2;
	$image->profileId = 'layout';
	$image->value = $setting ['imageId'];
	$image->render ();
	
	$text = new TextInput ( 'text_input_fluid' );
	$text->name = "widgetContentVo[setting][url]";
	$text->label = Lang::get ( "Link" );
	$text->value = $setting ['url'];
	$text->render ();
	
	$select = new SelectInput ( "select_input_fluid" );
	$select->name = "widgetContentVo[setting][target]";
	$select->label = Lang::get ( "Target" );
	$select->collections = ApplicationConfig::get ( 'layout.widget.link.target.list' );
	$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
	$select->value = $setting ['target'];
	$select->render ();
	?>
</div>