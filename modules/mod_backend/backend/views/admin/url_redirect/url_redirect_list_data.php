<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;

$paging = RequestUtil::get ( "urlRedirects" );
$urlRedirects = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="url_redirect_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Old Url');?></th>
				<th><?=Lang::get('New Url');?></th>
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
					$text->name = "filter[oldUrl]";
					$text->value = $filter->oldUrl;
					$text->placeholder = Lang::get ( "Old Url" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[newUrl]";
					$text->value = $filter->newUrl;
					$text->placeholder = Lang::get ( "New Url" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchUrlRedirects()\"";
					$button->checkActionPath = "admin/url/redirect/search";
					$button->render ();
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchUrlRedirects(true)\"";
					$button->checkActionPath = "admin/url/redirect/search";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $urlRedirects ) || count ( $urlRedirects ) == 0) {
				?>
			<tr role="row">
				<td colspan="7"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $urlRedirects as $urlRedirect ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$urlRedirect->id?></td>
				<td><?=$urlRedirect->oldUrl?></td>
				<td><?=$urlRedirect->newUrl?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "editUrlRedirectDialog('$urlRedirect->id')";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->checkActionPath = "admin/url/redirect/edit/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "copyUrlRedirectDialog('$urlRedirect->id')";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->checkActionPath = "admin/url/redirect/copy/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteUrlRedirectDialog('$urlRedirect->id')";
					$actionBtn->title = Lang::get ( "Delete" );
					$actionBtn->checkActionPath = "admin/url/redirect/del/view";
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
$pagingTemplate->changePageJs = "changePageUrlRedirects";
$pagingTemplate->render ();
?>
