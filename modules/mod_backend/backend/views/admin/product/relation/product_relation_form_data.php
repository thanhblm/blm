<div id="divTempProductRelateRow" style="display:none">
	<div class="product-relate-row" data-productId="" style="border-bottom: solid 1px #ccc;padding : 5px 0px 5px 0px">
		<input class="product-relate-name-hidden" type="hidden" name="" value="">
		<input class="product-relate-id" type="hidden" name="" value="">
		<a class="delete-product-relate" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a>
		<span class="product-relate-name"></span>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#productRelate").select2({
		 placeholder: 'Select a product'
	});
	$("#productRelate").change(function(){
		onAddProductRelate();
	});
});

function onAddProductRelate(){
	var productId = $("#productRelate option:selected").val();
	var productName = $("#productRelate option:selected").text();
	if(!isExistProductSelect(productId,productName) && productId != ""){
		$div = buildProductRelateRow(productId,productName);
		$("#listProductRelations").append($div.html());
	}
}
function buildProductRelateRow(productId,productName){
	var count = $("#listProductRelations .product-relate-row").length;
	$div = $("#divTempProductRelateRow").clone();
	$hiddenrelateProductId = $div.find(".product-relate-id");
	$hiddenrelateProductId.val(productId);
	$hiddenrelateProductId.attr("name","productRelations["+count+"][relateProductId]");
	$div.find(".product-relate-name").html(productName);
	$hiddenName = $div.find(".product-relate-name-hidden");
	$hiddenName.val(productName);
	$hiddenName.attr("name","productRelations["+count+"][name]");
	$div.find(".product-relate-row").attr("data-productId",productId);
	$div.find(".delete-product-relate").attr("onclick","delProductRelate("+productId+")");
	$div.show();
	return $div;
}
function delProductRelate(productId){
	$divDelete = $("#listProductRelations").find("[data-productId='"+productId+"']");
	$divDelete.remove();
	resetIndex();
}
function resetIndex(){
	$("#listProductRelations .product-relate-row").each(function(index,element){
		$(this).find(".product-relate-id").attr("name","productRelations["+index+"][relateProductId]");
	});
}
function isExistProductSelect(productId){
	var isExist = false;
	$("#listProductRelations .product-relate-id").each(function(index,element){
		if($(this).val()==productId){
			isExist = true;
		}
	});
	return isExist;
}
</script>