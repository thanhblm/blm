<?php
use common\template\extend\LabelContainer;
use common\template\extend\Select;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\Button;
use core\utils\ActionUtil;
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?=Lang::get("Page")?></span>
					</div>
				</div>
				<div class="portlet-body">
					<div class="dataTables_wrapper no-footer">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									Page:
									<?php
									$select = new Select ();
									$select->collectionType = Select::CT_SINGLE_ARRAY_OBJECT;
									$select->id = "sel_page";
									$select->value = "";
									$select->collections = RequestUtil::get ( "pageVos" );
									$select->propertyName = "id";
									$select->propertyValue = "name";
									$select->render ();
									?>
									Language:
									<?php
									$select = new Select ();
									$select->id = "sel_language";
									$select->collectionType = Select::CT_SINGLE_ARRAY_OBJECT;
									$select->value = "";
									$select->collections = RequestUtil::get ( "languageVos" );
									$select->propertyName = "code";
									$select->propertyValue = "name";
									$select->render ();
									?>
									<?php 
									$button = new Button();
									$button->id = "btn_generate_content";
									$button->title = "Generate content";
									$button->render();
									?>
								</div>
							</div>
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
</div>
<script>
$('#btn_generate_content').on('click', function() {
	 pageId = $( "#sel_page" ).val();
	 languageCode = $( "#sel_language" ).val();
	 window.open('<?=ActionUtil::getFullPathAlias("admin/page/raw/content")?>?pageId='+pageId+'&languageCode='+languageCode);
});
</script>