<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$paging = RequestUtil::get ( "batchList" );
$batchVos = $paging->records;
$batchMo = RequestUtil::get ( 'batchMo' );
$filter = RequestUtil::get ( "filter" );
$statusList = ApplicationConfig::get ( "common.status.list" );
$batchRelative = ApplicationConfig::get ( "batch.relative" );
?>
<div class="table-scrollable">
	<?php
	$text = new Text ();
	$text->type = 'hidden';
	$text->value = AppUtil::defaultIfEmpty ( RequestUtil::get ( "page" ), 1 );
	$text->name = "page";
	$text->id = "page";
	$text->render ();
	?>
	<table class="tbl_sort_data table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="page_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Title');?></th>
				<th><?=Lang::get('Status');?></th>
				<th><?=Lang::get('Batch file name');?></th>
				<!-- <th><?=Lang::get('Batch reports range');?></th>
				<th><?=Lang::get('Batch group');?></th> -->
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
				<td>
					<?php
					$text = new Text ();
					$text->placeholder = Lang::get ( "Id" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[id]";
					$text->value = $filter->id;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->placeholder = Lang::get ( "Title" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[title]";
					$text->value = $filter->title;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$select = new Select ();
					$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
					$select->name = "filter[status]";
					$select->headerKey = "";
					$select->headerValue = "All";
					$select->collections = $statusList;
					$select->class = "form-control form-filter input-sm";
					$select->value = AppUtil::defaultIfEmpty ( $filter->status );
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->placeholder = Lang::get ( "File name" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[fileName]";
					$text->value = $filter->fileName;
					$text->render ();
					?>
				</td>
				<!--<td>
					<?php
					$text = new Text ();
					$text->type = "number";
					$text->placeholder = Lang::get ( "Reports range from" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[reportsRangeFrom]";
					$text->value = $filter->reportsRangeFrom;
					$text->render ();
					?>
					<?php
					$text = new Text ();
					$text->type = "number";
					$text->placeholder = Lang::get ( "Reports range to" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[reportsRangeTo]";
					$text->value = $filter->reportsRangeTo;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->placeholder = Lang::get ( "Batch Group" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[batchGroupName]";
					$text->value = $filter->batchGroupName;
					$text->render ();
					?>
				</td>-->
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchBatch()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"resetFormBatch()\"";
					$button->render ();
					?>
				</td>
			</tr>
			
			<?php
			if (empty ( $batchVos ) || count ( $batchVos ) == 0) {
				?>
			<tr role="row">
				<td colspan="6"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $batchVos as $vo ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$vo->id?></td>
				<td><?=$vo->title?></td>
				<td>
					<?php
					$select = new Select ();
					$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
					$select->collections = $statusList;
					$select->class = "form-control form-filter input-sm";
					$select->value = AppUtil::defaultIfEmpty ( $vo->status );
					$select->attributes ="onchange='changeBatchStatus(".$vo->id.", $(this).val())'";
					$select->render ();
					?>
				</td>
				<td><?=$vo->fileName?></td>
				<!-- <td><?=$vo->reportsRange?></td>
				<td><?=$vo->batchGroupName?></td> -->
				<td>
				<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-download";
					$actionBtn->color = ButtonAction::COLOR_GREEN;
					$actionBtn->url = ActionUtil::getFullPathAlias ( $batchRelative . $vo->batchGroupId . DS . $vo->fileName );
					$actionBtn->title = Lang::get ( "Download Batch" );
					$actionBtn->attributes = ' target="_blank" ';
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "editBatchDialog($vo->id)";
					$actionBtn->checkActionPath = "admin/batch/edit/view";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteBatchDialog($vo->id)";
					$actionBtn->checkActionPath = "admin/batch/del/view";
					$actionBtn->title = Lang::get ( "Delete" );
					$actionBtn->render ();
					?>
				</td>
			</tr>
			<?php
				}
			}
			?>
		</tbody>
	</table>
</div>
<?php
$pagingTemplate = new PagingTemplate ();
$pagingTemplate->paging = $paging;
$pagingTemplate->changePageJs = "onPageChange";
$pagingTemplate->render ();
?>
