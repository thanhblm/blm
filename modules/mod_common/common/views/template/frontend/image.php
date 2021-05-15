<?php
use common\utils\ImageUtil;

$noImage = ImageUtil::getNoImage ();

// get $imageLoad
$imageLoad = ($value != '') ? ImageUtil::getImagePath ( $value ) : $noImage;
$imageThumb = ($value != '') ? ImageUtil::getImagePath ( $value, $size ) : $noImage;
?>
<div class='image_preview_wrap'>
	<a class='fancybox image_preview_link image_preview_link' href='<?php echo $imageLoad?>' title='Image preview'> <img class="image_preview image_preview" src="<?php echo $imageThumb ?>" alt='Image preview' title='Image preview' /></a>
</div>