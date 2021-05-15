<?php
use core\utils\RequestUtil;

use common\helper\DatoImageHelper;
use common\template\extend\Image;
use core\utils\ActionUtil;

$imageUrl = RequestUtil::get('imageUrl');
$imageMo = DatoImageHelper::getImageInfoById($imageUrl);
$index = RequestUtil::get('index');
?>
<li class='input_file input_file'>
	<div class="input_file">
		<div class="input_file_preview">
			<input type="hidden" class="image_source form-control" value="<?= $imageUrl ?>"
			       name="<?= $imageMo->profile; ?>Images[]" id="id_image<?= $index ?>">
			<div class="image_preview_wrap image_center">
				<a class="fancybox image_preview_link image_preview_link" id="id_image_image_preview_link"
				   href="<?php echo DatoImageHelper::getUrl($imageMo) ?>" title="Image preview">
					<img id="id_image_image_preview" class="image_preview image_preview"
					     src="<?php echo DatoImageHelper::getSmallImageUrl($imageMo) ?>" alt="Image preview"
					     title="Image preview">
				</a>
			</div>
		</div>
		<div class="clear"></div>

		<div class="image-action">
			<a class="btn btn-primary popup left" title="Image preview"
			   href="<?= ActionUtil::getFullPathAlias("file/manager?") . "field_id=id_image" . $index . "&pid=" . $imageMo->profile ?>">
				Select image</a>
			<div class="margin-left-10 button_delete delete_image" title="Delete item">
				<i class="fa fa-trash" title="Delete image"></i>
			</div>
		</div>
	</div>
</li>