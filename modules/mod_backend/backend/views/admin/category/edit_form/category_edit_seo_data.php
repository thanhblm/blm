<?php
use common\template\extend\Text;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$seoInfoLangs = RequestUtil::get("seoInfoLanguages")->getArray();
?>
<div class="row">
    <div class="col-md-3 col-sm-3 col-xs-3">
        <ul class="nav nav-tabs tabs-left">
			<?php
			$isFirst = true;
			foreach ($seoInfoLangs as $lang) {
				?>
                <li <?= $isFirst ? "class=\"active\"" : "" ?>>
                    <a href="#seo_<?= $lang->code ?>" data-toggle="tab">
                        <img src="<?= AppUtil::resource_url("global/img/flags/".strtolower($lang->flag).".png") ?>"/> <?= Lang::get($lang->name) ?>
                    </a>
                </li>
				<?php
				$isFirst = false;
			}
			?>
        </ul>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-9">
        <div class="tab-content">
			<?php
			$isFirst = true;
			$index = 0;
			foreach ($seoInfoLangs as $lang) {
				?>
                <div class="tab-pane fade <?= $isFirst ? "active in" : "" ?>" id="seo_<?= $lang->code ?>">
                    <div class="form-body">
						<?php
						$text = new Text ();
						$text->name = "seoInfoLanguages[" . $index . "][code]";
						$text->value = $lang->code;
						$text->type = "hidden";
						$text->render();

						$text = new Text ();
						$text->name = "seoInfoLanguages[" . $index . "][name]";
						$text->value = $lang->name;
						$text->type = "hidden";
						$text->render();

						$text = new Text ();
						$text->name = "seoInfoLanguages[" . $index . "][flag]";
						$text->value = $lang->flag;
						$text->type = "hidden";
						$text->render();

						$text = new Text ();
						$text->name = "seoInfoLanguages[" . $index . "][itemId]";
						$text->value = $lang->itemId;
						$text->type = "hidden";
						$text->render();

						$text = new Text ();
						$text->name = "seoInfoLanguages[" . $index . "][type]";
						$text->value = $lang->type;
						$text->type = "hidden";
						$text->render();

						$text = new Text ();
						$text->name = "seoInfoLanguages[" . $index . "][languageCode]";
						$text->value = $lang->languageCode;
						$text->type = "hidden";
						$text->render();

						$text = new TextInput ('text_input_fluid');
						$text->name = "seoInfoLanguages[" . $index . "][url]";
						$text->errorMessage = RequestUtil::getFieldError("seoInfoLanguages[" . $index . "][url]");
						$text->hasError = RequestUtil::isFieldError("seoInfoLanguages[" . $index . "][url]");
						$text->value = $lang->url;
						$text->label = Lang::get("Url");
						$text->type = "text";
						$text->render();

						$text = new TextInput ('text_input_fluid');
						$text->name = "seoInfoLanguages[" . $index . "][title]";
						$text->errorMessage = RequestUtil::getFieldError("seoInfoLanguages[" . $index . "][title]");
						$text->hasError = RequestUtil::isFieldError("seoInfoLanguages[" . $index . "][title]");
						$text->value = $lang->title;
						$text->label = Lang::get("Title");
						$text->type = "text";
						$text->render();

						$text = new TextInput ('text_input_fluid');
						$text->name = "seoInfoLanguages[" . $index . "][keywords]";
						$text->errorMessage = RequestUtil::getFieldError("seoInfoLanguages[" . $index . "][keywords]");
						$text->hasError = RequestUtil::isFieldError("seoInfoLanguages[" . $index . "][keywords]");
						$text->value = $lang->keywords;
						$text->label = Lang::get("Keywords");
						$text->type = "text";
						$text->render();

						$text = new TextArea ('textarea_fluid');
						$text->errorMessage = RequestUtil::getFieldError("seoInfoLanguages[" . $index . "][description]");
						$text->hasError = RequestUtil::isFieldError("seoInfoLanguages[" . $index . "][description]");
						$text->label = Lang::get("Description");
						$text->name = "seoInfoLanguages[" . $index . "][description]";
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
