<?php
use common\helper\PermissionHelper;
use common\template\extend\Button;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$filter = RequestUtil::get('filter');
$currencies = RequestUtil::get("currencies");
?>
    <div class="table-scrollable">
        <input id="page" name="page" type="hidden" value="<?= RequestUtil::get("page") ?>"/>
        <table id="product_table" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid">
            <thead>
            <tr role="row">
                <th><?= Lang::get('Id'); ?></th>
                <th><?= Lang::get('Code'); ?></th>
				<?php
				foreach ($currencies as $currency) {
					?>
                    <th><?= $currency->name; ?></th>
					<?php
				}
				?>
                <th><?= Lang::get('Name'); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr role="row" class="filter">
                <td>
					<?php
					$text = new Text ();
					$text->name = "filter[id]";
					$text->value = $filter->id;
					$text->placeholder = Lang::get("Id");
					$text->render();
					?>
                </td>
                <td>
					<?php
					$text = new Text ();
					$text->name = "filter[itemCode]";
					$text->value = $filter->itemCode; // $_REQUEST['name'];
					$text->placeholder = Lang::get("Item Code");
					$text->render();
					?>
                </td>
                <?php
				foreach ($currencies as $currency) {
					?>
                    <td></td>
					<?php
				}
				?>
                <td>
					<?php
					$text = new Text ();
					$text->name = "filter[name]";
					$text->value = $filter->name; // $_REQUEST['name'];
					$text->placeholder = Lang::get("Name");
					$text->attributes = "style=\"width: 400px\"";
					$text->render();
					?>
                </td>
                <td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get("Search");
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"doProductPriceSearch()\"";
					$button->render();

					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get("Reset");
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"doProductPriceSearch(true)\"";
					$button->render();
					?>
                </td>
            </tr>
			<?php
			$paging = isset ($_REQUEST ['products']) ? $_REQUEST ['products'] : null;
			if (!empty ($paging) && count($paging->records) > 0) {
				foreach ($paging->records as $product) {
					?>
                    <tr class="gradeX odd" role="row">
                        <td><?= $product->id ?></td>
                        <td><?= $product->itemCode ?></td>
						<?php
						foreach ($product->prices as $productPriceVo) {
							?>
                            <td>
								<?php
								$text = new Text ();
								$text->value = $productPriceVo->price;
								$text->placeholder = "";
								$text->attributes = "style=\"width: 100px\" step=\"0.01\" onchange=\"changeProductPrice(this,$product->id,'$productPriceVo->currencyCode')\"";
								$text->type = "number";
								$text->render();
								?>
                            </td>
							<?php
						}
						?>
                        <td>
							<?php if (PermissionHelper::hasAdminPermission("admin/product/edit/view")) { ?>
                                <a href="<?= ActionUtil::getFullPathAlias('admin/product/edit/view?id=' . $product->id); ?>"><?= $product->name ?></a>
								<?php
							} else {
								?>
								<?= $product->name ?>
								<?php
							}
							?>
                        </td>
                        <td></td>
                    </tr>
					<?php
				}
			} else {
				?>
                <tr role="row">
                    <td colspan="6"><?= Lang::get("No data available...") ?></td>
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
$pagingTemplate->changePageJs = "onProductPageChange";
$pagingTemplate->render();
?>