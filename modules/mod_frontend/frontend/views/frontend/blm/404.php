<?php

use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;

?>
<!-- Page Banner -->
<div class="page-banner">
    <!-- Container -->
    <div class="container">
        <h3><?= Lang::get("Trang không tồn tại") ?></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a title="<?= Lang::get("Home") ?>"
                                           href="<?= ActionUtil::getFullPathAlias("/") ?>"><?= Lang::get("Home") ?></a>
            </li>
            <li class="breadcrumb-item active"><?= Lang::get("Trang không tồn tại") ?></li>
        </ol>
    </div><!-- Container /- -->
</div><!-- Page Banner /- -->

<main class="site-main">
    <!-- 404 page -->
    <div class="error-section">
        <!-- container -->
        <div class="container">
            <div class="error-block">
                <img src="<?= AppUtil::resource_url("layouts/etoviet/images/404.png") ?>" alt="404.jpg">
                <h2>Oops! Sorry the page not found</h2>
                <div class="searchbox">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search Here....">
                        <span class="input-group-btn">
									<button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
								</span>
                    </div>
                </div>
                <a href="<?= ActionUtil::getFullPathAlias("/") ?>" title="Back Home">Quay lại <?= Lang::get("Home") ?></a>
            </div>
        </div><!-- container /- -->
    </div><!-- 404 page -->

</main>