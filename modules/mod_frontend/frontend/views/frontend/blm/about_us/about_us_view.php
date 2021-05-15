<?php

use common\helper\DatoImageHelper;
use common\helper\LayoutHelper;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$blog = RequestUtil::get("blog");
?>

<!-- Page Banner -->
<div class="page-banner">
    <!-- Container -->
    <div class="container">
        <h3><?= Lang::get("Giới thiệu") ?></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a title="<?= Lang::get("Home") ?>"
                                           href="<?= ActionUtil::getFullPathAlias("/") ?>"><?= Lang::get("Home") ?></a>
            </li>
            <li class="breadcrumb-item active"><?= Lang::get("Giới thiệu") ?></li>
        </ol>
    </div><!-- Container /- -->
</div><!-- Page Banner /- -->

<main class="site-main">

    <!-- About Section -->
    <div class="about-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="about-content">
                        <!-- Section Header -->
                        <div class="section-header section-header-left">
                            <h6><?= $blog->name ?></h6>
                            <h3><?= $blog->description ?></h3>
                        </div><!-- Section Header -->
                        <?= $blog->composition ?>
                    </div>
                </div>

                <?php
                if (count($blog->images) > 0) {
                    $image = DatoImageHelper::getImageInfoById(json_decode($blog->images)[0]);
                    ?>
                    <div class="col-lg-6 about-img">
                        <img src="<?= DatoImageHelper::getLargeImageUrl($image) ?>" alt="About"/>
                    </div>
                    <?php
                }
                ?>

            </div><!-- Row /- -->
        </div><!-- Container /- -->
    </div><!-- About Section /- -->

</main>
