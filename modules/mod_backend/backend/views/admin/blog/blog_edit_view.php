<?php
use core\utils\ActionUtil;
?>
<div class="row">
	<div class="col-md-12">
		<?php include_once 'blog_edit_res_data.php';?>
	</div>
</div>
<script type="text/javascript">
	function editBlog(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/blog/edit?rtype=json")?>",
			$("#edit_blog_form").serialize(),
			onAddBlogSuccess,
			onAddBlogFieldErrors,
			onAddBlogActionErrors
		);
	}
	function onAddBlogSuccess(res){
		$("#edit_blog_form").replaceWith(res.content);
	}
	function onAddBlogFieldErrors(res){
		$("#edit_blog_form").replaceWith(res.content);
	}
	function onAddBlogActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}
	function editCloseBlog(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/blog/edittoclose?rtype=json")?>",
			$("#edit_blog_form").serialize(),
			onEditCloseBlogSuccess,
			onEditCloseBlogFieldErrors,
			onEditCloseBlogActionErrors
		);
	}
	function onEditCloseBlogSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/blog/list')?>";
	}
	function onEditCloseBlogFieldErrors(res){
		$("#edit_blog_form").replaceWith(res.content);
	}
	function onEditCloseBlogActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}
</script>