<?php

use common\rule\url\friendly\BlogUrlFriendly;
use common\rule\url\friendly\CategoryBlogUrlFriendly;
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\template\extend\Select;
use core\config\ApplicationConfig;

$paging = RequestUtil::get("categoriesBlog");
$categoriesBlog = $paging->records;
$filter = RequestUtil::get("filter");
?>
<div class="table-scrollable">
    <input id="page" name="page" type="hidden" value="<?= RequestUtil::get("page") ?>"/>
    <table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid"
           id="category_blog_table">
        <thead>
        <tr role="row">
            <th style="cursor: pointer;"><?= Lang::get('Id'); ?></th>
            <th><?= Lang::get('Name'); ?></th>
            <th><?= Lang::get('URL'); ?></th>
            <th><?= Lang::get('Status'); ?></th>
            <th><?= Lang::get('Actions'); ?></th>
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
                $text->name = "filter[name]";
                $text->value = $filter->name;
                $text->placeholder = Lang::get("Name");
                $text->render();
                ?>
            </td>
            <td>

            </td>
            <td>
                <?php
                $select = new Select();
                $select->value = $filter->status;
                $select->name = "filter[status]";
                $select->headerKey = "";
                $select->headerValue = Lang::get("All");
                $select->collections = ApplicationConfig::get("common.status.list");
                $select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
                $select->class = "form-control form-filter input-sm";
                $select->render();
                ?>
            </td>
            <td>
                <?php
                $button = new Button ();
                $button->type = "button";
                $button->title = " " . Lang::get("Search");
                $button->icon = "<i class='fa fa-search'></i>";
                $button->attributes = "onclick=\"searchCategoriesBlog()\"";
                $button->render();

                $button = new Button ();
                $button->type = "button";
                $button->title = " " . Lang::get("Reset");
                $button->icon = "<i class='fa fa-refresh'></i>";
                $button->attributes = "onclick=\"searchCategoriesBlog(true)\"";
                $button->render();
                ?>
            </td>
        </tr>
        <?php
        if (empty ($categoriesBlog) || count($categoriesBlog) == 0) {
            ?>
            <tr role="row">
                <td colspan="5"><?= Lang::get("No data available...") ?></td>
            </tr>
            <?php
        } else {
            foreach ($categoriesBlog as $categoryBlog) {
                ?>
                <tr class="gradeX odd" role="row">
                    <td><?= $categoryBlog->id ?></td>
                    <td><?= $categoryBlog->name ?></td>
                    <td><?php
                        $url = ActionUtil::getFullPathAlias("home/blog/detail?id=$categoryBlog->id", new CategoryBlogUrlFriendly($categoryBlog->languageCode, $categoryBlog->id, $categoryBlog->url, $categoryBlog->name));
                        echo "<a href='$url' target='_blank'>".$url."</a>";
                        ?></td>
                    <td><?= $categoryBlog->status ?></td>
                    <td>
                        <?php
                        $actionBtn = new ButtonAction ();
                        $actionBtn->iconClass = "fa fa-edit";
                        $actionBtn->color = ButtonAction::COLOR_BLUE;
                        $actionBtn->js = "onEditCategoryBlog('$categoryBlog->id')";
                        $actionBtn->title = Lang::get("Edit");
                        $actionBtn->checkActionPath = "admin/category/blog/edit/view";
                        $actionBtn->render();

                        $actionBtn = new ButtonAction ();
                        $actionBtn->iconClass = "fa fa-copy";
                        $actionBtn->color = ButtonAction::COLOR_BLUE;
                        $actionBtn->js = "onCopyCategoryBlog('$categoryBlog->id')";
                        $actionBtn->title = Lang::get("Clone");
                        $actionBtn->checkActionPath = "admin/category/blog/copy/view";
                        $actionBtn->render();

                        $actionBtn = new ButtonAction ();
                        $actionBtn->iconClass = "fa fa-trash-o";
                        $actionBtn->color = ButtonAction::COLOR_RED;
                        $actionBtn->js = "deleteCategoryBlogDialog('$categoryBlog->id')";
                        $actionBtn->title = Lang::get("Delete");
                        $actionBtn->checkActionPath = "admin/category/blog/del/view";
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
$pagingTemplate->changePageJs = "changePageCategoriesBlog";
$pagingTemplate->render();
?>
