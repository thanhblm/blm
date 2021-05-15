<?php
use core\utils\RequestUtil;
use common\template\extend\TextInput;
use core\Lang;

$productPrices = RequestUtil::get ( 'productPrices' );
?>
<div class="porlet-body">
	<?php
	if(count($productPrices->getArray())==0){
		?>
		<div><?php echo Lang::get("No data available...")?></div>
		<?php 
	}else{
		$i = 0;
		foreach ($productPrices->getArray() as $productPrice){?>
		<div>
			<input type="hidden" name="productPrices[<?=$i?>][productId]" value="<?=$productPrice->productId?>"/>
			<input type="hidden" name="productPrices[<?=$i?>][currencyCode]" value="<?=$productPrice->currencyCode?>"/>
			<?php 
			$text = new TextInput();
			$text->label = $productPrice->currencyCode;
			$text->type = "number";
			$text->errorMessage = RequestUtil::getFieldError ( "productPrices[$i][price]" );
			$text->hasError = RequestUtil::isFieldError ( "productPrices[$i][price]" );
			$text->name = "productPrices[$i][price]";
			$text->value = $productPrice->price;
			$text->class = "form-control edit-product-price";
			$text->required = true;
			$text->attributes = "min='0'";
			$text->render ();
			?>
		</div>
	<?php
		$i++;
		}
	}
	?>
</div>