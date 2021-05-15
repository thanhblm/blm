<?php

namespace layout\widgets;

use common\template\extend\ImageInput;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\AppUtil;
use core\utils\RequestUtil;

// get data (exist data $widgetContentInfo and $widgetContentLangs)
$widgetId = $widgetContentInfo->widgetId;
$widgetData = RequestUtil::get ( 'widgetData' );
?>
<div class="row mutilLanguagesPercen">
	<div class="col-md-4 col-sm-4 col-xs-4">
		<ul class="nav nav-tabs tabs-left">
		<?php
		$isFirst = true;
		foreach ( $widgetContentLangs as $lang ) {
			?>
			<li <?= $isFirst ? "class=\"active\"" : "" ?>><a href="#widget_<?=$widgetId?>_<?= $lang->code ?>" data-toggle="tab"> <img src="<?= AppUtil::resource_url("global/img/flags/".strtolower($lang->flag).".png") ?>" />
					<?= Lang::get($lang->name)?>
            	</a></li>
		<?php
			$isFirst = false;
		}
		?>
        </ul>
	</div>
	<div class="col-md-8 col-sm-8 col-xs-8">
		<div class="tab-content">
		<?php
		$isFirst = true;
		$index = 0;
		foreach ( $widgetContentLangs as $lang ) {
			// get $setting
			$setting = ( array ) $lang->setting;
			// set setting default
			$setting ['title'] = (isset ( $setting ['title'] )) ? $setting ['title'] : '';
			$setting ['showTitle'] = (isset ( $setting ['showTitle'] )) ? $setting ['showTitle'] : 1;
			$setting ['imageId'] = (isset ( $setting ['imageId'] )) ? $setting ['imageId'] : 0;
			$setting ['url'] = (isset ( $setting ['url'] )) ? $setting ['url'] : '';
			$setting ['target'] = (isset ( $setting ['target'] )) ? $setting ['target'] : '_blank';
			?>
			<div class="tab-pane fade <?= $isFirst ? "active in" : "" ?>" id="widget_<?=$widgetId?>_<?= $lang->code ?>">
				<div class="form-body" style="margin-left: 15px; margin-right: 15px;">
				<?php
					$text = new Text ();
					$text->name = "widgetContentLanguages[" . $index . "][code]";
					$text->value = $lang->code;
					$text->type = "hidden";
					$text->render ();
					
					$text = new Text ();
					$text->name = "widgetContentLanguages[" . $index . "][name]";
					$text->value = $lang->name;
					$text->type = "hidden";
					$text->render ();
					
					$text = new Text ();
					$text->name = "widgetContentLanguages[" . $index . "][flag]";
					$text->value = $lang->flag;
					$text->type = "hidden";
					$text->render ();
					
					$text = new Text ();
					$text->name = "widgetContentLanguages[" . $index . "][widgetContentId]";
					$text->value = $lang->widgetContentId;
					$text->type = "hidden";
					$text->render ();
					
					$text = new Text ();
					$text->name = "widgetContentLanguages[" . $index . "][languageCode]";
					$text->value = $lang->code;
					$text->type = "hidden";
					$text->render ();
					
					$text = new TextInput ( 'text_input_fluid' );
					$text->name = "widgetContentLanguages[" . $index . "][setting][title]";
					$text->label = Lang::get ( "Title" );
					$text->value = $setting ['title'];
					$text->render ();
					
					$select = new SelectInput ( "select_input_fluid" );
					$select->name = "widgetContentLanguages[" . $index . "][setting][showTitle]";
					$select->label = Lang::get ( "Show title" );
					$select->collections = ApplicationConfig::get ( 'layout.yn.list' );
					$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
					$select->value = $setting ['showTitle'];
					$select->render ();
					
					$image = new ImageInput ();
					$image->name = "widgetContentLanguages[" . $index . "][setting][imageId]";
					$image->label = Lang::get ( "Image" );
					$image->hasImgAction = true;
					$image->id = "imageId_{$index}";
					$image->row = 2;
					$image->profileId = 'layout';
					$image->value = $setting ['imageId'];
					$image->render ();
					
					$text = new TextInput ( 'text_input_fluid' );
					$text->name = "widgetContentLanguages[" . $index . "][setting][url]";
					$text->label = Lang::get ( "Link" );
					$text->value = $setting ['url'];
					$text->render ();
					
					$select = new SelectInput ( "select_input_fluid" );
					$select->name = "widgetContentLanguages[" . $index . "][setting][target]";
					$select->label = Lang::get ( "Target" );
					$select->collections = ApplicationConfig::get ( 'layout.widget.link.target.list' );
					$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
					$select->value = $setting ['target'];
					$select->render ();
					?>
				</div>
			</div>
		<?php
			$isFirst = false;
			$index ++;
		}
		?>
        </div>
	</div>
</div>