<?php

use common\helper\DatoImageHelper;
use common\rule\url\friendly\BlogUrlFriendly;
use common\rule\url\friendly\CategoryBlogUrlFriendly;
use common\template\extend\PagingTemplate;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$blogs = RequestUtil::get("blogList")
?>
<?php

if (!empty ($blogs) && count($blogs->records) > 0) {
    foreach ($blogs->records as $blog) {
        $imageMo = DatoImageHelper::getImageInfoById(json_decode($blog->images)[0]);
        $url = ActionUtil::getFullPathAlias("home/blog/detail?id=$blog->id", new BlogUrlFriendly($blog->languageCode, $blog->id, $blog->url, $blog->name));
        ?>

        <div class="blog-box">
            <div class="entry-cover">
                <a href="<?= $url ?>" title="<?= $blog->name ?>"><img
                            src="<?= DatoImageHelper::getUrl($imageMo) ?>"
                            alt="<?= $blog->name ?>"/></a>
                <div class="entry-meta">
                    <span class="posted-on"><a href="<?= $url ?>"><?= $blog->crDate ?></a></span>
                    <div class="author">
                        <span class="cat-links"><?= Lang::get("Chuyên mục") ?> : <a
                                    href="<?= ActionUtil::getFullPathAlias("category/blog/detail?categoryId=" . $blog->categoryBlogId, new CategoryBlogUrlFriendly($blog->languageCode, $blog->categoryBlogId, null, $blog->categoryName)) ?>"><?= $blog->categoryName ?></a></span>
                    </div>
                </div>
            </div>
            <div class="entry-content">
                <h3 class="entry-title"><a href="<?= $url ?>" title="<?= $blog->name ?>"><?= $blog->name ?></a></h3>
                <?= $blog->description ?>
                <a href="<?= $url ?>" title="<?= $blog->name ?>"><?= Lang::get("read more") ?></a>
            </div>
        </div>
        <?php
    }
}
?>

<!-- Blog Box /- -->
<nav class="navigation pagination">
    <h2 class="screen-reader-text">Posts navigation</h2>
    <?php
    $pagingTemplate = new PagingTemplate();
    $pagingTemplate->paging = $blogs;
    $pagingTemplate->changePageJs = "changePageBlogs";
    try {
        $pagingTemplate->render();
    } catch (Exception $e) {
        DatoLogUtil::devInfo($e);
    }
    ?>
</nav>
