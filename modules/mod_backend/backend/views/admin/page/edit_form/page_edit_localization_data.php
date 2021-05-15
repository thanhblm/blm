<?php
use core\utils\RequestUtil;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\AppUtil;
use common\template\extend\Text;
use common\template\extend\TextArea;

$pageLanguages = RequestUtil::get('pageLanguages')->getArray();
?>

<div class="row mutilLanguagesPercenForLocalization">
    <div class="col-md-4 col-sm-4 col-xs-4">
        <ul class="nav nav-tabs tabs-left">
			<?php
			$isFirst = true;
			foreach ($pageLanguages as $lang) {
				?>
                <li <?= $isFirst ? "class=\"active\"" : "" ?>>
                    <a href="#<?= $lang->code ?>" data-toggle="tab">
                        <img src="<?= AppUtil::resource_url("global/img/flags/".strtolower($lang->flag).".png") ?>"/>
						<?= Lang::get($lang->languageName) ?>
                    </a>
                </li>
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
			foreach ($pageLanguages as $lang) {
				?>
                <div class="tab-pane fade <?= $isFirst ? "active in" : "" ?>" id="<?= $lang->code ?>">
                    <div class="form-body" style="margin-left: 15px; margin-right: 15px;">
						<?php
						$text = new Text ();
						$text->name = "pageLanguages[" . $index . "][code]";
						$text->value = $lang->code;
						$text->type = "hidden";
						$text->render();

						$text = new Text();
						$text->name = "pageLanguages[" . $index . "][name]";
						$text->value = $lang->name;
						$text->type = "hidden";
						$text->render();

						$text = new Text ();
						$text->name = "pageLanguages[" . $index . "][flag]";
						$text->value = $lang->flag;
						$text->type = "hidden";
						$text->render();

						$text = new Text ();
						$text->name = "pageLanguages[" . $index . "][pageId]";
						$text->value = $lang->pageId;
						$text->type = "hidden";
						$text->render();

						$text = new Text ();
						$text->name = "pageLanguages[" . $index . "][languageCode]";
						$text->value = $lang->code;
						$text->type = "hidden";
						$text->render();

						$text = new TextInput('text_input_fluid');
						$text->errorMessage = RequestUtil::getFieldError("pageLanguages[" . $index . "][name]");
						$text->hasError = RequestUtil::isFieldError("pageLanguages[" . $index . "][name]");
						$text->name = "pageLanguages[" . $index . "][name]";
						$text->label = Lang::get("Name");
						$text->value = $lang->name;
						$text->render();

						$text = new TextArea ('textarea_fluid');
						$text->errorMessage = RequestUtil::getFieldError("pageLanguages[" . $index . "][description]");
						$text->hasError = RequestUtil::isFieldError("pageLanguages[" . $index . "][description]");
						$text->label = Lang::get("Description");
						$text->name = "pageLanguages[" . $index . "][description]";
						$text->value = $lang->description;
						$text->class = "ckeditor";
						$text->render();
						?>
                    </div>
                </div>
				<?php
				$isFirst = false;
				$index++;
			}
			?>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		mutilLanguagesPercen('.mutilLanguagesPercenForLocalization');
	});
</script>