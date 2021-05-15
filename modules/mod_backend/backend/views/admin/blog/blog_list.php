<?php

use common\template\extend\LabelContainer;
use common\template\extend\Link;
use common\template\extend\Select;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pageSizes = RequestUtil::get("pageSizes");
?>
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?= Lang::get('Blogs') ?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
						<form action="" id="blog_form">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<?php
									$labelContainer = new LabelContainer ();
									$labelContainer->textBefore = Lang::get('Show');
									$labelContainer->textAfter = Lang::get('entries');
									$select = new Select ();
									$collections = $pageSizes;
									$select->collectionType = Select::CT_SINGLE_ARRAY_VALUE;
									$select->name = "pageSize";
									$select->value = RequestUtil::get("pageSize");
									$select->attributes = "onchange=\"doBlogSearch()\"";
									$select->collections = $collections;
									$labelContainer->addElement($select);
									$labelContainer->render();
									?>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="table-group-actions pull-right">
										<?php
										$link = new Link ();
										$link->class = "btn btn-sm blue margin-bottom-5";
										$link->title = "<i class=\"fa fa-plus\"></i> " . Lang::get('Add New');
										$link->link = ActionUtil::getFullPathAlias('admin/blog/add/view');
										$link->checkActionPath = "admin/blog/add/view";
										$link->render();
										?>
									</div>
								</div>
							</div>
							<div id="blog_result">
								<?php include_once 'blog_list_data.php'; ?>
							</div>
						</form>
					</div>

				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>
<div class="modal fade in" id="blog_dialog" tabindex="-1" role="basic" aria-hidden="true" style="display: none;"></div>
<script type="text/javascript">
    $(document).ready(function () {
        showBlogTableView("id", "asc");
    });

    function showDeleteBlogDialog(id) {
        simpleCUDModal(
            "#blog_dialog",
            "#del_blog_form",
            guid(),
            "#btnDelBlog",
            "<?=ActionUtil::getFullPathAlias("admin/blog/del/view?rtype=json&id=")?>" + id,
            "<?=ActionUtil::getFullPathAlias("admin/blog/del?rtype=json")?>",
            doRefreshBlog
        );
    }

    function showBlogTableView(field, direction) {
        $("#blog_table").tablesorter({
            field: field,
            direction: direction,
            fieldList: ["id", "", "name", "featured", "status", ""],
            callback: doBlogSorting
        });
    }

    function doBlogSorting(field, direction, is_reset = false) {
        App.blockUI({
            target: '#blog_table'
        });
        var data = "";
        if (!is_reset) {
            data = $("#blog_form").serialize();
        }
        data += "&orderBy=" + field + " " + direction;
        $.post("<?=ActionUtil::getFullPathAlias("admin/blog/search?rtype=json")?>", data, function (res) {
            App.unblockUI('#blog_table');
            if (res.errorCode == "SUCCESS") {
                // Get user list.
                $("#blog_result").html(res.content);
                // Update view for sorting.
                showBlogTableView(field, direction);
            } else {
                alert(res.errorMessage);
            }
        }).fail(function () {
            alert("System error.");
        });
    }

    function doBlogSearch(is_reset = false) {
        $("#blog_form #page").val(1);
        doBlogSorting("name", "asc", is_reset);
    }

    function onBlogPageChange(page) {
        var field = $("#blog_table").attr("field");
        var direction = $("#blog_table").attr("direction");
        $("#blog_form #page").val(page);
        doBlogSorting(field, direction);
    }

    function doRefreshBlog(dialogId, btnId, res) {
        var field = $("#blog_table").attr("field");
        var direction = $("#blog_table").attr("direction");
        doBlogSorting(field, direction);
        $(dialogId).modal("toggle");
    }
</script>