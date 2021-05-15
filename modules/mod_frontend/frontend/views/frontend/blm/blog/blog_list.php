<?php

use common\helper\SettingHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$categoryInfo = RequestUtil::get("categoryBlog");
$titlePage = SettingHelper::getSettingValue("Name");
?>
<!-- Page Banner -->
<div class="page-banner">
    <!-- Container -->
    <div class="container">
        <h3><?= $categoryInfo->name ?></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a title="<?= Lang::get("Home") ?>"
                                           href="<?= ActionUtil::getFullPathAlias("/") ?>"><?= Lang::get("Home") ?></a>
            </li>
            <?php
            if ($categoryInfo != null && $categoryInfo->name != '') {
                ?>
                <li class="breadcrumb-item"><a
                            href="<?= ActionUtil::getFullPathAlias("home/blog/list", new AliasUrlFriendly("tin-tuc")) ?>"
                            title="<?= Lang::get("Tin tức") ?>"><?= Lang::get("Tin tức") ?></a></li>
                <li class="breadcrumb-item active"><?= $categoryInfo->name ?></li>
                <?php
            } else {
                ?>
                <li class="breadcrumb-item active"><?= Lang::get("Tin tức") ?></li>
                <?php
            }

            ?>

        </ol>
    </div><!-- Container /- -->
</div><!-- Page Banner /- -->

<main class="site-main">

    <div class="page-content">
        <!-- Blog Post -->
        <div class="blog-post">
            <!-- Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <!-- Content Area -->
                    <div class="col-lg-9 col-md-7 content-area" id="Blog1">
                        <!-- Blog Box -->
                        <?php
                            include  "blog_list_data.php";

                        ?>

                    </div><!-- Content Area -->
                    <!-- Widget Area -->
                    <div class="col-lg-3 col-md-5 widget-area">
                    <?php
                    include "side_bar_blog_right.php";
                    ?>
                    </div>
                </div><!-- Row /- -->
            </div><!-- Container /- -->
        </div><!-- Blog Post /- -->

    </div>

</main>


<script type="text/javascript">
    var gUrlBlogList = "<?=ActionUtil::getFullPathAlias("home/blog/list/search") ?>" + "?rtype=json";

    function changePageBlogs(page) {
        simpleAjaxPost(
            guid(),
            gUrlBlogList + "&page=" + page,
            "",
            loadBlogSuccess
        );
    }

    function loadBlogSuccess(res) {
        $("#Blog1").html(res.content);
    }
</script>