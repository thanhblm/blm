<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\ActionUtil;
use common\helper\SettingHelper;

$paging = RequestUtil::get ( "pageList" );
$pages = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="page_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Name');?></th>
				<th><?=Lang::get('Description');?></th>
                <th><?=Lang::get('Cache Enable');?></th>
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
				<td></td>
                <td></td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchPages()\"";
					$button->render ();

					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchPages(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $pages ) || count ( $pages ) == 0) {
				?>
			<tr role="row">
				<td colspan="4"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $pages as $page ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$page->id?></td>
				<td>
					<a href="<?=ActionUtil::getFullPathAlias ( 'home/page/view?pageId=' .$page->id)?>" target="_blank">
						<?=$page->name?>
					</a>
				</td>
				<td><?= strip_tags($page->description)?></td>
                <td>
                    <label style="cursor: pointer" title="<?=Lang::get("Enable cache")?>">
                        <input type="checkbox" value="1" onclick="javascript:pageCacheEnableView(<?=$page->id?>)"
                        <?= ($page->cacheEnable == 'yes') ? 'checked' : ''?>  <?php echo SettingHelper::getSettingValue("Page Cache Enable") === "yes"? "" : "disabled" ?> >
                        <span><?=$page->cacheEnable?></span>
                    </label>
                </td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->url = ActionUtil::getFullPathAlias ( 'admin/page/edit/view?pageId=' .$page->id);
					$actionBtn->title = Lang::get ( "Edit Page" );
					$actionBtn->checkActionPath = "admin/page/edit/view";
					$actionBtn->render ();

					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->url = ActionUtil::getFullPathAlias ( 'admin/page/copy?pageId=' .$page->id);
					$actionBtn->title = Lang::get ( "Copy Page" );
					$actionBtn->checkActionPath = "admin/page/copy";
					$actionBtn->render ();

                    $actionBtn = new ButtonAction ();
                    $actionBtn->iconClass = "fa fa-refresh";
                    $actionBtn->color = ButtonAction::COLOR_BLUE;
                    $actionBtn->url = "javascript:recachePageView($page->id)";
                    $actionBtn->title = Lang::get ( "Recache Page" );
                    $actionBtn->checkActionPath = "admin/page/recache/page/view";
                    $actionBtn->isShow = SettingHelper::getSettingValue("Page Cache Enable") === "yes"? true : false;

                    $actionBtn->render ();

					if(!$page->isSystem) {
                        $actionBtn = new ButtonAction ();
                        $actionBtn->iconClass = "fa fa-trash-o";
                        $actionBtn->color = ButtonAction::COLOR_RED;
                        $actionBtn->js = "deletePageDialog($page->id)";
                        $actionBtn->title = Lang::get("Delete");
						$actionBtn->checkActionPath = "admin/page/del";
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
$pagingTemplate->changePageJs = "changePagePages";
$pagingTemplate->render ();
?>