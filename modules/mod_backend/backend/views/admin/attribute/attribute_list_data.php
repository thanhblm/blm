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
use core\utils\AppUtil;
use core\utils\RequestUtil;

$paging = RequestUtil::get("attributeList");
$categories = RequestUtil::get("categoryList");
$attrGroupList = RequestUtil::get("attrGroupList");
$typeList = ApplicationConfig::get("attribute.type.list");
$attributeList = $paging->records;
$filter = RequestUtil::get("filter");
$productId = RequestUtil::get("productId");
$groupAttributes = RequestUtil::get("groupAttributes");
$productAttributes = RequestUtil::get("productAttributes");
?>
<div class="table-scrollable">
	<?php
	$text = new Text ();
	$text->type = 'hidden';
	$text->value = AppUtil::defaultIfEmpty(RequestUtil::get("page"), 1);
	$text->name = "page";
	$text->id = "page";
	$text->render();
	?>
	<table class="tbl_sort_data table table-striped table-bordered table-hover dataTable no-footer" role="grid"
	       id="page_table">
		<thead>
		<tr role="row">
			<th><?= Lang::get('Id'); ?></th>
			<th><?= Lang::get('Code'); ?></th>
			<th><?= Lang::get('Category'); ?></th>
			<th><?= Lang::get('Attribute Group'); ?></th>
			<th><?= Lang::get('Image'); ?></th>
			<th><?= Lang::get('Name'); ?></th>
			<th><?= Lang::get('Type'); ?></th>
			<th><?= Lang::get('Actions'); ?></th>
		</tr>
		</thead>
		<tbody>
		<tr role="row" class="filter">
			<td style="max-width: 70px;">
				<?php
				$text = new Text();
				$text->type = "hidden";
				$text->name = "categoryId";
				$text->value = RequestUtil::get("categoryId");
				$text->render();
				$text = new Text();
				$text->type = "hidden";
				$text->name = "productId";
				$text->value = $productId;
				$text->render();

				$text = new Text ();
				$text->placeholder = Lang::get("Id");
				$text->class = "form-control form-filter input-sm";
				$text->name = "filter[id]";
				$text->value = $filter->id;
				$text->render();
				?>
			</td>
			<td style="max-width: 70px;">
				<?php
				$text = new Text ();
				$text->placeholder = Lang::get("Code");
				$text->class = "form-control form-filter input-sm";
				$text->name = "filter[code]";
				$text->value = $filter->code;
				$text->render();
				?>
			</td>
			<td>
				<?php
				$select = new Select ();
				$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_OBJECT;
				$select->name = "filter[categoryId]";
				$select->propertyName = "id";
				$select->propertyValue = "name";
				$select->headerKey = "";
				$select->headerValue = "All";
				$select->collections = $categories;
				$select->class = "form-control form-filter input-sm";
				$select->value = AppUtil::defaultIfEmpty($filter->categoryId);
				$select->render();
				?>
			</td>
			<td>
				<?php
				$select = new Select ();
				$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_OBJECT;
				$select->name = "filter[attrGroupId]";
				$select->propertyName = "id";
				$select->propertyValue = "name";
				$select->headerKey = "";
				$select->headerValue = "All";
				$select->collections = $attrGroupList;
				$select->class = "form-control form-filter input-sm";
				$select->value = AppUtil::defaultIfEmpty($filter->attrGroupId);
				$select->render();
				?>
			</td>
			<td>
			</td>
			<td>
				<?php
				$text = new Text ();
				$text->placeholder = Lang::get("Name");
				$text->class = "form-control form-filter input-sm";
				$text->name = "filter[name]";
				$text->value = $filter->name;
				$text->render();
				?>
			</td>
			<td>
				<?php
				$select = new Select ();
				$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
				$select->name = "filter[type]";
				$select->headerKey = "";
				$select->headerValue = "All";
				$select->collections = $typeList;
				$select->class = "form-control form-filter input-sm";
				$select->value = AppUtil::defaultIfEmpty($filter->type);
				$select->render();
				?>
			</td>
			<td>
				<?php
				$button = new Button ();
				$button->type = "button";
				$button->title = " " . Lang::get("Search");
				$button->icon = "<i class='fa fa-search'></i>";
				$button->attributes = "onclick=\"sortAttribute()\"";
				$button->render();

				$button = new Button ();
				$button->type = "button";
				$button->title = " " . Lang::get("Reset");
				$button->icon = "<i class='fa fa-refresh'></i>";
				$button->attributes = "onclick=\"resetForm()\"";
				$button->render();
				?>
			</td>
		</tr>

		<?php
		if (empty ($attributeList) || count($attributeList) == 0) {
			?>
			<tr role="row">
				<td colspan="8"><?= Lang::get("No data available...") ?></td>
			</tr>
			<?php
		} else {
			foreach ($attributeList as $vo) {
				$isAddAttr = true;
				foreach ($groupAttributes as $productAttribute){
					if($productAttribute->id == $vo->attrGroupId){
						foreach ($productAttribute->listAttr->getArray() as $attributeVo){
							if($attributeVo->id == $vo->id){
								$isAddAttr = false;
							}
						}
					}
				}
				$styleRow = "";
				if(!$isAddAttr){
					$styleRow = ' style="background-color: rgba(0, 88, 243, 0.25);"';
				}
				?>
				<tr class="gradeX odd" role="row" <?=$styleRow ?>>
					<td><?= $vo->id ?></td>
					<td><?= $vo->code ?></td>
					<td><?= $vo->categoryName ?></td>
					<td><?= $vo->attrGroupName ?></td>
					<td>
						<?php
						if ($vo->type === 'image') {
							$image = new Image();
							$imageVo = DatoImageHelper::getImageInfoById($vo->image);
							$image->value = $imageVo->relativePath . $imageVo->fileName;
							$image->size = 'small';
							$image->render();
						} else {
							echo $vo->description;
						}
						?>
					</td>
					<td><?= $vo->name ?></td>
					<td><?php
						$select = new Select ();
						$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
						$select->name = "filter[type]";
						$select->headerKey = "";
						$select->headerValue = "All";
						$select->value = $vo->type;
						$select->collections = $typeList;
						$select->class = "form-control form-filter input-sm";
						$select->render();
						?></td>
					<td>
						<?php
						if(!AppUtil::isEmptyString($productId)){
							if($isAddAttr){
								$actionBtn = new ButtonAction ();
								$actionBtn->iconClass = "fa fa-plus";
								$actionBtn->color = ButtonAction::COLOR_BLUE;
								$actionBtn->js = "addAttributeForProduct($productId,$vo->id)";
								$actionBtn->title = Lang::get ( "Add To Product" );
								$actionBtn->render ();
							}else{
								$actionBtn = new ButtonAction ();
								$actionBtn->iconClass = "fa fa-minus";
								$actionBtn->color = ButtonAction::COLOR_RED;
								$actionBtn->js = "removeAttributeForProduct($productId,$vo->id)";
								$actionBtn->title = Lang::get ( "Add To Product" );
								$actionBtn->render ();
							}

						}
						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-edit";
						$actionBtn->color = ButtonAction::COLOR_BLUE;
						//$actionBtn->js = "editAttrGroupDialog($vo->id)";
						$actionBtn->js = "editAttributeDialog($vo->id)";
						/*  $actionBtn->checkActionPath = "admin/batch/group/edit/view";*/
						$actionBtn->title = Lang::get("Edit");
						$actionBtn->render();

						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-copy";
						$actionBtn->color = ButtonAction::COLOR_BLUE;
						$actionBtn->js = "copyAttributeDialog($vo->id)";
						$actionBtn->title = Lang::get("Clone");
						$actionBtn->render();

						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-trash-o";
						$actionBtn->color = ButtonAction::COLOR_RED;
						$actionBtn->js = "deleteAttributeDialog($vo->id)";
						$actionBtn->title = Lang::get("Delete");
						$actionBtn->render();
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
$pagingTemplate->changePageJs = "changePageAttribute";
$pagingTemplate->render();
?>
