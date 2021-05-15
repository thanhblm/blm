<?php
use common\helper\DatoImageHelper;
use common\utils\ImageUtil;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;

$id = AppUtil::defaultIfEmpty ( $id, "image_select" );
$id_image_preview = $id . "_image_preview";
$id_image_preview_link = $id . "_image_preview_link";
if ($row == 1) {
	$classLabel = 'col-md-4';
	$classInput = 'col-md-8';
} else if ($row == 2) {
	$classLabel = '';
	$classInput = 'image_single_input_row';
}
?>
<div class="form-group <?php echo $hasError?'has-error':''?>">
	<label class="control-label <?php echo $classLabel?>"><?=$label?><?php echo ($required) ? "<span class='required' aria-required='true'> * </span>" : ""?>  </label>
	<div class="<?php echo $classInput?>">
		<?php
		$noImage = ImageUtil::getNoImage ();
		$imageMo = DatoImageHelper::getImageInfoById ( $value );
		$imageLoad = DatoImageHelper::getUrl ( $imageMo );
		$imageThumb = DatoImageHelper::getSmallImageUrl ( $imageMo );
		?>
		<div class='input_file <?php echo $class?>'>
			<div class="input_file_preview">
				<input type="hidden" class="image_source form-control" value="<?=$value?>" name="<?php echo($name != '')? $name : 'image'; ?>" id="<?=$id?>">
				<div class='image_preview_wrap image_center'>
					<a class='fancybox image_preview_link image_preview_link' id='<?=$id_image_preview_link?>' href='<?php echo $imageLoad?>' title='Image preview'> <img id='<?=$id_image_preview?>' class="image_preview image_preview" src="<?php echo $imageThumb ?>" alt='Image preview' title='Image preview' />
					</a>
				</div>
			</div>
			<div class='clear'></div>
			<?php if($hasImgAction){?>
				<div class="image-action">
				<a class="btn btn-primary popup left" title='<?php echo Lang::get('Image preview')?>' href="<?php echo ActionUtil::getFullPathAlias("file/manager")?>?field_id=<?php echo ($id != '')? $id : 'image_select'?>&pid=<?=$profileId?>">
						<?php echo Lang::get('Select image')?>
					</a>
				<div class="margin-left-10 button_delete delete_image" title='<?php echo Lang::get('Delete item')?>'>
					<i class="fa fa-trash" title="Delete image"></i>
				</div>
			</div>
			<script type="text/javascript">
					$(document).on('click', '.delete_image', function(){
						$(this).parents('.input_file').find("#<?=$id?>").attr('value', '');
						$(this).parents('.input_file').find("#<?=$id_image_preview?>").attr('src', '<?php echo $noImage?>');
						$(this).parents('.input_file').find("#<?=$id_image_preview_link?>").attr('href', '<?php echo $noImage?>');
					});
				</script>
			<?php }?>
		</div>
		<span class="help-block"><?=$errorMessage?></span>
	</div>
</div>