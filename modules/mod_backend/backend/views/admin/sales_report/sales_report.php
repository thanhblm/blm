<?php
use common\template\extend\Text;
use common\template\extend\Select;
use common\template\extend\Button;
use common\template\extend\FormContainer;
use core\Lang;
use core\utils\DateTimeUtil;
use core\utils\RequestUtil;
use core\utils\ActionUtil;

$filter = RequestUtil::get ( "filter" );
$regionList = RequestUtil::get ( "regionList" );
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light">
				<div class="portlet-title">
					<div class="caption font-dark">
						<span class="caption-subject bold uppercase"><?= Lang::get("Sales Report") ?></span>
					</div>
				</div>
				<div class="portlet-body" style="width: 150px">
				<?php
				$form = new FormContainer ();
				$form->id = "sales_report_form";
				$form->attributes = 'class="form-horizontal"';
				$form->method = "post";
				$form->action = ActionUtil::getFullPathAlias ( "admin/sales/report/export" );
				$form->renderStart ();
				
				$text = new Text ( "text_date" );
				$text->name = "filter[startDate]";
				$text->value = $filter->startDate;
				$text->placeholder = Lang::get ( "Start date" );
				$text->attributes = "style='width: 150px'";
				$text->render ();
				
				$text = new Text ( "text_date" );
				$text->name = "filter[endDate]";
				$text->value = $filter->endDate;
				$text->placeholder = Lang::get ( "End date" );
				$text->attributes = "style='width: 150px'";
				$text->render ();
				
				$select = new Select ();
				$select->collections = $regionList;
				$select->value = $filter->regionId;
				$select->name = "filter[regionId]";
				$select->propertyName = 'id';
				$select->propertyValue = 'name';
				$select->headerKey = '0';
				$select->headerValue = Lang::get ( '-Select region-' );
				$select->class = "form-control input-sm";
				$select->render ();
				
				$button = new Button ();
				$button->type = "submit";
				$button->title = " " . Lang::get ( "Export" );
				$button->icon = "<i class='fa fa-search'></i>";
				$button->attributes = "onclick=\"exportSalesReport()\"";
				$button->render ();
				$form->renderEnd ();
				?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.date-picker').datepicker({
			format: "<?=DateTimeUtil::getDatePickerFormat()?>",
		});
	});
</script>