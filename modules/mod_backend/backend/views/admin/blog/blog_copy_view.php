<?php
use core\utils\ActionUtil;
?>
<div class="row">
	<div class="col-md-12">
		<?php include_once 'blog_copy_res_data.php';?>
	</div>
</div>
<script type="text/javascript">
	function copyBlog(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/blog/copy?rtype=json")?>",
			$("#edit_blog_form").serialize(),
			onCopyBlogSuccess,
			onCopyBlogFieldErrors,
			onCopyBlogActionErrors
		);
	}
	function onCopyBlogSuccess(res){
		$("#edit_blog_form").replaceWith(res.content);
	}
	function onCopyBlogFieldErrors(res){
		$("#edit_blog_form").replaceWith(res.content);
	}
	function onCopyBlogActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}

	function copyCloseBlog(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/blog/copytoclose?rtype=json")?>",
			$("#edit_blog_form").serialize(),
			onCopyCloseBlogSuccess,
			onCopyBlogFieldErrors,
			onCopyBlogActionErrors
		);
	}
	function onCopyCloseBlogSuccess(res){
		location.href = "<?=ActionUtil::getFullPathAlias('admin/blog/list')?>";
	}
</script>