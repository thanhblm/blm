<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\ActionUtil;

$paging = RequestUtil::get ( "templateList" );
$templateList = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="template_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Name');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[id]";
					$text->value = $filter->id;
					$text->placeholder = Lang::get ( "Id" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[name]";
					$text->value = $filter->name;
					$text->placeholder = Lang::get ( "Name" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchTemplates()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchTemplates(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $templateList ) || count ( $templateList ) == 0) {
				?>
			<tr role="row">
				<td colspan="4"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $templateList as $templateVo ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$templateVo->id?></td>
				<td><?=$templateVo->name?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->url = ActionUtil::getFullPathAlias ( 'admin/template/edit/view?templateId=' .$templateVo->id);
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->url = ActionUtil::getFullPathAlias ( 'admin/template/copy?templateId=' .$templateVo->id);
					$actionBtn->title = Lang::get ( "Copy" );
					$actionBtn->render ();

					if(!$templateVo->isSystem) {
                        $actionBtn = new ButtonAction ();
                        $actionBtn->iconClass = "fa fa-trash-o";
                        $actionBtn->color = ButtonAction::COLOR_RED;
                        $actionBtn->js = "deleteTemplateDialog($templateVo->id)";
                        $actionBtn->title = Lang::get("Delete");
                        $actionBtn->render();
                    }
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
$pagingTemplate->changePageJs = "changeTemplatePages";
$pagingTemplate->render ();
?>