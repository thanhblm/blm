<?php

namespace layout\widgets;

use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextArea;
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
				$setting ['content'] = (isset ( $setting ['content'] )) ? $setting ['content'] : '';
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
						
						$text = new TextArea ( 'textarea_fluid' );
						$text->name = "widgetContentLanguages[" . $index . "][setting][content]";
						$text->label = Lang::get ( "Content" );
						$text->class = "html_widget_content";
						$text->value = htmlentities($setting ['content']);
						$text->render ();
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