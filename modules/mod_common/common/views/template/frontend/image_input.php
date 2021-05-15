<?php 
use core\utils\AppUtil;
use common\utils\ImageUtil;
use core\Lang;

$id = AppUtil::defaultIfEmpty($id, "image_select");
$id_image_preview = $id."_image_preview";
$id_image_preview_link = $id."_image_preview_link";
?>

<div class="form-group <?php echo $hasError?'has-error':''?>">
	<label class="control-label col-md-4"><?=$label?><?=$required?"<span class='required' aria-required='true'> * </span>":""?>  </label>
	<div class="col-md-8">
		<?php 
			$noImage = ImageUtil::getNoImage();
		
			//get $imageLoad
			$imageLoad = !empty($value) ? ImageUtil::getImagePath($value) : $noImage;
			$imageThumb = !empty($value) ? ImageUtil::getImagePath($value, 'large') : $noImage;
		?>
		<div class='input_file <?php echo $class?>"?>'>
			<div class="input_file_preview">
				<input type="hidden" class="image_source" value="<?php echo $imageLoad?>"
					name="<?php echo($name != '')? $name : 'image'; ?>" 
					id="<?=$id?>"
				>
				<div class='image_preview_wrap image_center'>
					<a class='fancybox image_preview_link image_preview_link' id = '<?=$id_image_preview_link?>' href='<?php echo $imageLoad?>' title='Image preview'>
						<img id = '<?=$id_image_preview?>' class="image_preview image_preview" src="<?php echo $imageThumb ?>" alt='Image preview' title='Image preview'/>
					</a>
				</div>
			</div>
			<div class='clear'></div>
			
			<?php if($hasImgAction){?>
				<div class="image-action">
					<a class="btn btn-primary popup left" title='<?php echo Lang::get('Image preview')?>'
						href="<?php echo AppUtil::resource_url("global/scripts/filemanager/dialog.php?type=0")?>&field_id=<?php echo ($id != '')? $id : 'image_select'?>" >
						<?php echo Lang::get('Select image')?>
					</a>
					<div class="margin-left-10 button_delete delete_image" title='<?php echo Lang::get('Delete item')?>'>
						<i class="fa fa-trash" title="Delete image"></i>
					</div>
				</div>
				<script type="text/javascript">
					$(document).on('click', '.delete_image', function(){
						$("#<?=$id?>").attr('value', '<?php echo $noImage?>');
						$("#<?=$id_image_preview?>").attr('src', '<?php echo $noImage?>');
						$("#<?=$id_image_preview_link?>").attr('href', '<?php echo $noImage?>');
					});
				</script>
			<?php }?>
		</div>
		<span class="help-block"><?=$errorMessage?></span>
	</div>
</div>