<?php

use common\rule\url\friendly\BlogUrlFriendly;
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\config\ApplicationConfig;
use common\helper\DatoImageHelper;

$filter = RequestUtil::get ( 'filter' );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table id="blog_table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Image');?></th>
				<th><?=Lang::get('Name');?></th>
                <th><?=Lang::get('URL');?></th>
				<th><?=Lang::get('Featured');?></th>
				<th><?=Lang::get('Status');?></th>
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
					/*$text = new Text ();
					$text->name = "filter[itemCode]";
					$text->value = $filter->itemCode;
					$text->placeholder = Lang::get ( "Item Code" );
					$text->render ();*/
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
				<td>
					<?php
					$select = new Select ();
					$select->headerKey = "";
					$select->headerValue = Lang::get ( "All" );
					$select->label = Lang::get ( "Featured" );
					$select->name = "filter[featured]";
					$select->value = $filter->featured;
					$select->collections = ApplicationConfig::get ( "blog.featured.list" );
					$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_VALUE;
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$select = new Select ();
					$select->name = "filter[status]";
					$select->value = $filter->status;
					$select->headerKey = "";
					$select->headerValue = Lang::get ( "All" );
					$select->collections = ApplicationConfig::get ( "common.status.list" );
					$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"doBlogSearch()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"doBlogSearch(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
		<?php
		$paging = isset ( $_REQUEST ['blogs'] ) ? $_REQUEST ['blogs'] : null;
		if (! empty ( $paging ) && count ( $paging->records )>0) {
			foreach ( $paging->records as $blog ) {
				$imageMo = DatoImageHelper::getImageInfoById(json_decode($blog->images)[0]);
				$url= ActionUtil::getFullPathAlias("home/blog/detail?id=$blog->id", new BlogUrlFriendly($blog->languageCode, $blog->id, $blog->url, $blog->name));
				?>
			<tr class="gradeX odd" role="row">
				<td><?=$blog->id?></td>
				<td><img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" alt="" width="75" height="75"></td>
				<td><?=$blog->name?></td>
                <td><a href="<?=$url?>"><?=$url?></a></td>

				<td><?=$blog->featured?></td>
				<td><?=$blog->status?></td>
				<td>
				<?php
				$actionBtn = new ButtonAction ();
				$actionBtn->url = ActionUtil::getFullPathAlias ( 'admin/blog/edit/view?id=' . $blog->id );
				$actionBtn->color = ButtonAction::COLOR_BLUE;
				$actionBtn->iconClass = "fa fa-edit";
				$actionBtn->title = Lang::get ( "Edit" );
				$actionBtn->checkActionPath="admin/blog/edit/view";
				$actionBtn->render ();
				
				$actionBtn = new ButtonAction ();
				$actionBtn->url = ActionUtil::getFullPathAlias ( 'admin/blog/copy/view?id=' . $blog->id );
				$actionBtn->color = ButtonAction::COLOR_BLUE;
				$actionBtn->iconClass = "fa fa-copy";
				$actionBtn->title = Lang::get ( "Clone" );
				$actionBtn->checkActionPath = "admin/blog/copy/view";
				$actionBtn->render ();
				
				$actionBtn = new ButtonAction ();
				$actionBtn->iconClass = "fa fa-trash-o";
				$actionBtn->color = ButtonAction::COLOR_RED;
				$actionBtn->js = "showDeleteBlogDialog($blog->id)";
				$actionBtn->title = Lang::get ( 'Delete' );
				$actionBtn->checkActionPath = "admin/blog/del/view";
				$actionBtn->render ();
				?>
				</td>
			</tr>
		<?php
			}
		}else{
			?>
			<tr role="row">
				<td colspan="7"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
</div>
<?php
$pagingTemplate = new PagingTemplate ();
$pagingTemplate->paging = $paging;
$pagingTemplate->changePageJs = "onBlogPageChange";
$pagingTemplate->render ();
?>