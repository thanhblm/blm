<?php
use core\utils\ActionUtil;
?>
<div class="row">
	<div class="col-md-12">
		<?php include_once 'blog_add_res_data.php';?>
	</div>
</div>
<div class="modal fade in" id="blog_lang_dialog" tabindex="-1" role="basic" aria-hidden="true" style="display: none; width: 600px; height: 400px"></div>
<div class="modal fade in" id="delete_blog_lang_dialog" tabindex="-1" role="basic" aria-hidden="true" style="display: none;"></div>
<script type="text/javascript">
	function addBlog(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/blog/add?rtype=json")?>",
			$("#add_blog_form").serialize(),
			onAddBlogSuccess,
			onAddBlogFieldErrors,
			onAddBlogActionErrors
		);
	}
	function onAddBlogSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/blog/list')?>";
	}
	function onAddBlogFieldErrors(res){
		$("#add_blog_form").replaceWith(res.content);
	}
	function onAddBlogActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}
	
	function addToEditBlog(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/blog/addtoedit?rtype=json")?>",
			$("#add_blog_form").serialize(),
			onAddToEditBlogSuccess,
			onAddToEditBlogFieldErrors,
			onAddToEditBlogActionErrors
		);
	}
	function onAddToEditBlogSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/blog/edit/view')?>" + "?id=" + res.extra.blogId;
	}
	function onAddToEditBlogFieldErrors(res){
		$("#add_blog_form").replaceWith(res.content);
	}
	function onAddToEditBlogActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}
</script>