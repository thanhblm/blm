<?php

use common\helper\DatoImageHelper;
use common\helper\SettingHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use common\rule\url\friendly\BlogUrlFriendly;
use common\rule\url\friendly\CategoryBlogUrlFriendly;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$categoryParent = RequestUtil::get("categoryParent");
$categoryUrl = ActionUtil::getFullPathAlias("category/blog/detail?categoryId=" . $categoryParent->id, new CategoryBlogUrlFriendly($categoryParent->languageCode, $categoryParent->id, $categoryParent->seoUrl, $categoryParent->name));
$titlePage = SettingHelper::getSettingValue("Name");
$blog = RequestUtil::get("blog");
$imageMo = DatoImageHelper::getImageInfoById(json_decode($blog->images)[0]);
$url = ActionUtil::getFullPathAlias("home/blog/detail?id=$blog->id", new BlogUrlFriendly($blog->languageCode, $blog->id, $blog->url, $blog->name));
?>


<div class="main-container">
    <!-- Page Banner -->
    <div class="page-banner">
        <!-- Container -->
        <div class="container">
            <h3><?= $blog->name ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a title="<?= Lang::get("Home") ?>"
                                               href="<?= ActionUtil::getFullPathAlias("/") ?>"><?= Lang::get("Home") ?></a>
                </li>
                <li class="breadcrumb-item"><a
                            href="<?= ActionUtil::getFullPathAlias("home/blog/list", new AliasUrlFriendly("tin-tuc")) ?>"
                            title="<?= Lang::get("Tin tức") ?>"><?= Lang::get("Tin tức") ?></a></li>
                <li class="breadcrumb-item"><a
                            href="<?= $categoryUrl ?>"
                            title="<?= $categoryParent->name ?>"><?= $categoryParent->name ?></a></li>
                <li class="breadcrumb-item active"><?= $blog->name ?></li>

            </ol>
        </div><!-- Container /- -->
    </div><!-- Page Banner /- -->

    <main class="site-main">

        <!-- Page Content -->
        <div class="page-content">

            <!-- Single Post -->
            <div class="single-post">
                <!-- Container -->
                <div class="container">
                    <!-- Row -->
                    <div class="row">
                        <!-- Content Area -->
                        <div class="col-lg-9 col-md-7 content-area">
                            <!-- Blog Box -->
                            <div class="blog-box">
                                <div class="entry-cover">
                                    <img src="<?= DatoImageHelper::getUrl($imageMo) ?>" alt="<?= $blog->name ?>"/>
                                    <div class="entry-meta">
                                        <span class="posted-on"><a href="<?=$url?>"><?= $blog->crDate ?></a></span>
                                        <div class="author">
                                            <span class="cat-links"><?= $categoryParent->name ?> : <a
                                                        href="<?= $categoryUrl ?>"><?= $categoryParent->name ?></a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    <h3 class="entry-title"><?= $blog->name ?></h3>
                                    <h4 class="entry-title"><?= $blog->description ?></h4>
                                    <?= $blog->composition ?>
                                </div>
                                <!--<div class="entry-footer">
                                    <div class="social-share">
                                        <h4>Share This Post</h4>
                                        <ul>
                                            <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#" title="Google+"><i class="fa fa-google-plus"></i></a></li>
                                            <li><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                                            <li><a href="#" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                        </ul>
                                    </div>
                                </div>-->
                            </div><!-- Blog Box -->
                            <!-- About Author -->
                            <!--<div class="post-author">
                                <div class="author-detail">
                                    <img src="assets/images/post-author.jpg" alt="Author" />
                                    <h3>john davis</h3>
                                    <p>These men promptly escaped from a maximum security stockade to the Los Angeles underground? Believe it or not I'm walking on air. I never thought I could feel so free. Flying away on a wing and a prayer could it beme.</p>
                                    <ul>
                                        <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" title="Google+"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                                        <li><a href="#" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>-->
                            <!-- About Author /- -->
                            <!-- Comment Area -->
                        </div><!-- Content Area -->
                        <!-- Widget Area -->
                        <div class="col-lg-3 col-md-5 widget-area">
                            <?php
                            include "side_bar_blog_right.php";
                            ?>
                        </div><!-- Widget Area /- -->
                    </div><!-- Row /- -->
                </div><!-- Container /- -->
            </div><!-- Single Post /- -->

        </div><!-- Page Content /- -->

    </main>
</div>