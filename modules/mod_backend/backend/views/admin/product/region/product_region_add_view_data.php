<?php 
use core\utils\RequestUtil;
use core\Lang;

$productRegions = RequestUtil::get('productRegions');
?>
<div class="form-body">
	<div id="listProductRegions">
	<?php
	$i=0;
	if(count($productRegions->getArray())==0){
		?>
		<div><?php echo Lang::get("No data available...")?></div>
		<?php
	}
	else{
		foreach ($productRegions->getArray() as $region){
			?>
		<div>
			<input type="hidden" name="productRegions[<?=$i?>][name]" value="<?=$region->name?>"/>
			<input type="hidden" name="productRegions[<?=$i?>][productId]" value="<?=$region->productId?>"/>
			<input type="hidden" name="productRegions[<?=$i?>][regionId]" value="<?=$region->regionId?>"/>
			<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
				<input name="productRegions[<?=$i?>][select]" type="checkbox" <?=$region->select==1?"checked='checked'":""?>  data-region-id="<?=$region->regionId?>" class="checkboxes check-region" value="<?=$region->select?>" ><?=$region->name?>
				<span></span>
			</label>			
		</div>
			<?php
			$i++;
		}
	}
	?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$(".check-region").click(function(){
		var regionId = $(this).attr("data-region-id");
		if($(this).is(":checked")){
			$(this).val(1);
		}else{
			$(this).val(0);
		}
	});
});
</script>
