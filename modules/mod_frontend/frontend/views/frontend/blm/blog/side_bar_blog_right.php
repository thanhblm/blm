<?php

use common\helper\DatoImageHelper;
use common\rule\url\friendly\BlogUrlFriendly;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$blogs = RequestUtil::get("blogRelated")

?>
<!-- Widget: Categories -->
<!--<aside id="categories" class="widget widget_categories">
    <h3 class="widget-title">Categories</h3>
    <ul>
        <li class="cat-item"><a href="#" title="Town Taxi">Town Taxi</a></li>
        <li class="cat-item"><a href="#" title="Hybrid Taxi">Hybrid Taxi</a></li>
        <li class="cat-item"><a href="#" title="Limousine Taxi">Limousine Taxi</a></li>
        <li class="cat-item"><a href="#" title="SUV Taxi">SUV Taxi</a></li>
        <li class="cat-item"><a href="#" title="Interstate Tour">Interstate Tour</a></li>
    </ul>
</aside>--><!-- Widget: Categories /- -->
<!-- Widget : Latest Post -->
<aside class="widget widget_latest_post">
    <h3 class="widget-title"><?=Lang::get("recent news")?></h3>
    <div class="latest-content">
        <?php

        if (!empty ($blogs) && count($blogs) > 0) {
            foreach ($blogs as $blog) {
                $imageMo = DatoImageHelper::getImageInfoById(json_decode($blog->images)[0]);
                $url = ActionUtil::getFullPathAlias("home/blog/detail?id=$blog->id", new BlogUrlFriendly($blog->languageCode, $blog->id, $blog->url, $blog->name));
                ?>
                <div class="latest-post">
                    <a href="<?= $url ?>"><img src="<?= DatoImageHelper::getSmallImageUrl($imageMo) ?>" width="80" height="80"
                                               alt="<?= $blog->name ?>"/></a>
                    <h4><a href="<?= $url ?>"><?= $blog->name ?></a></h4>
                    <span><a href="<?= $url ?>"><?= $blog->crDate ?></a></span>
                </div>
                <?php
            }
        }
        ?>
    </div>
</aside><!-- Widget : Latest Post -->