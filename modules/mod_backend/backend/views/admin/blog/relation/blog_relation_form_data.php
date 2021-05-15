<div id="divTempProductRelateRow" style="display:none">
	<div class="blog-relate-row" data-blogId="" style="border-bottom: solid 1px #ccc;padding : 5px 0px 5px 0px">
		<input class="blog-relate-name-hidden" type="hidden" name="" value="">
		<input class="blog-relate-id" type="hidden" name="" value="">
		<a class="delete-blog-relate" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a>
		<span class="blog-relate-name"></span>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#blogRelate").select2({
		 placeholder: 'Select a blog'
	});
	$("#blogRelate").change(function(){
		onAddProductRelate();
	});
});

function onAddProductRelate(){
	var blogId = $("#blogRelate option:selected").val();
	var blogName = $("#blogRelate option:selected").text();
	if(!isExistProductSelect(blogId,blogName) && blogId != ""){
		$div = buildProductRelateRow(blogId,blogName);
		$("#listProductRelations").append($div.html());
	}
}
function buildProductRelateRow(blogId,blogName){
	var count = $("#listProductRelations .blog-relate-row").length;
	$div = $("#divTempProductRelateRow").clone();
	$hiddenrelateProductId = $div.find(".blog-relate-id");
	$hiddenrelateProductId.val(blogId);
	$hiddenrelateProductId.attr("name","blogRelations["+count+"][relateProductId]");
	$div.find(".blog-relate-name").html(blogName);
	$hiddenName = $div.find(".blog-relate-name-hidden");
	$hiddenName.val(blogName);
	$hiddenName.attr("name","blogRelations["+count+"][name]");
	$div.find(".blog-relate-row").attr("data-blogId",blogId);
	$div.find(".delete-blog-relate").attr("onclick","delProductRelate("+blogId+")");
	$div.show();
	return $div;
}
function delProductRelate(blogId){
	$divDelete = $("#listProductRelations").find("[data-blogId='"+blogId+"']");
	$divDelete.remove();
	resetIndex();
}
function resetIndex(){
	$("#listProductRelations .blog-relate-row").each(function(index,element){
		$(this).find(".blog-relate-id").attr("name","blogRelations["+index+"][relateProductId]");
	});
}
function isExistProductSelect(blogId){
	var isExist = false;
	$("#listProductRelations .blog-relate-id").each(function(index,element){
		if($(this).val()==blogId){
			isExist = true;
		}
	});
	return isExist;
}
</script>