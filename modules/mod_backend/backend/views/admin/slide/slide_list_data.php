<?php
use common\helper\DatoImageHelper;
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\Image;
use common\template\extend\PagingTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$listSlideGroup = RequestUtil::get("listSlideGroup");
$paging = RequestUtil::get ( "slideList" );
$slideVos = $paging->records;
$slideMo = RequestUtil::get ( 'slideMo' );
$filter = RequestUtil::get ( "filter" );
$statusList = ApplicationConfig::get ( "common.status.list" );
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
				<th><?=Lang::get('Image');?></th>
				<th><?=Lang::get('Title');?></th>
				<th><?=Lang::get('Slide group');?></th>
				<th><?=Lang::get('Status');?></th>
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
					$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_OBJECT;
					$select->name = "filter[slideGroupId]";
					$select->propertyName = "id";
					$select->propertyValue = "name";
					$select->headerKey = "";
					$select->headerValue = "All";
					$select->collections = $listSlideGroup;
					$select->class = "form-control form-filter input-sm";
					$select->value = AppUtil::defaultIfEmpty ( $filter->slideGroupId );
					$select->render ();
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
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchSlide()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"resetFormSlide()\"";
					$button->render ();
					?>
				</td>
			</tr>
			
			<?php
			if (empty ( $slideVos ) || count ( $slideVos ) == 0) {
				?>
			<tr role="row">
				<td colspan="6"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $slideVos as $vo ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$vo->id?></td>
				<td>
					<?php
						$image = new Image();
						$imageVo = DatoImageHelper::getImageInfoById($vo->image);
						$image->value = $imageVo->relativePath.$imageVo->fileName;
						$image->size = 'small';
						$image->label = $vo->title;
						$image->render();
					?>
				</td>
				<td><?=$vo->title?></td>
				<td>
					<?=$vo->slideGroupName?>
				</td>
				<td>
					<?php
					$select = new Select ();
					$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
					$select->collections = $statusList;
					$select->class = "form-control form-filter input-sm";
					$select->value = AppUtil::defaultIfEmpty ( $vo->status );
					$select->attributes ="onchange='changeSlideStatus(".$vo->id.", $(this).val())'";
					$select->render ();
					?>
				</td>
				<td>
				<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "editSlideDialog($vo->id)";
					$actionBtn->checkActionPath = "admin/slide/edit/view";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteSlideDialog($vo->id)";
					$actionBtn->checkActionPath = "admin/slide/del/view";
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
