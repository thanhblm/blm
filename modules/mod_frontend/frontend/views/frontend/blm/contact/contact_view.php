<?php

use common\helper\SettingHelper;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\ActionUtil;
use common\template\extend\TextInput;
use common\template\extend\TextArea;
use core\template\html\base\BaseSelect;
use common\template\extend\SelectInput;
use core\Lang;

?>
<!-- Page Banner -->
<div class="page-banner">
    <!-- Container -->
    <div class="container">
        <h3><?= Lang::get("Liên hệ") ?></h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a title="<?= Lang::get("Home") ?>"
                                           href="<?= ActionUtil::getFullPathAlias("/") ?>"><?= Lang::get("Home") ?></a>
            </li>
            <li class="breadcrumb-item active"><?= Lang::get("Liên hệ") ?></li>
        </ol>
    </div><!-- Container /- -->
</div><!-- Page Banner /- -->

<main class="site-main">

    <!-- Contact Section -->
    <div class="contact-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="contact-box">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <h2><?= Lang::get('Phone') ?></h2>
                        <p><?= Lang::get('Phone : ') ?><a
                                    href="tel:<?= SettingHelper::getSettingValue("Phone Number") ?>"><?= SettingHelper::getSettingValue("Phone Number") ?></a>
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="contact-box">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <h2><?= Lang::get("Address") ?></h2>
                        <p><?= SettingHelper::getSettingValue("Site Address") ?></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="contact-box">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <h2><?= Lang::get('Email') ?></h2>
                        <p>
                            <a href="mailto:<?= SettingHelper::getSettingValue("Site Owner's Email") ?>"><?= SettingHelper::getSettingValue("Site Owner's Email") ?></a>
                        </p>
                    </div>
                </div>
            </div><!-- Row /- -->
        </div><!-- Container /- -->
    </div><!-- Contact Section /- -->

    <!-- Contact Form -->
    <div class="contact-form">
        <!-- Container -->
        <div class="container">
            <h3><?= Lang::get("get in touch with us") ?></h3>
            <div class="row">
                <div class="col-md-6">
                    <div id="div_form">
                        <?php
                        include "contact_form_data.php";
                        ?>
                    </div>
                    <div class="col-md-12 form-group">
                        <button name="submit" class="submit" onclick="addContact()">submit now</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="<?= AppUtil::resource_url("layouts/etoviet/images/contact-car.png") ?>" alt="contact-car">
                </div>
            </div>
        </div><!-- Container -->
    </div><!-- Contact Form /- -->
</main>
<script type="text/javascript">
    gUrlAddContact = "<?=ActionUtil::getFullPathAlias("home/contact/add") ?>?rtype=json";

    function addContact() {
        simpleAjaxPostUpload(
            guid(),
            gUrlAddContact,
            "#contact_form",
            onAddContactSuccess
        )
    }

    function onAddContactSuccess(res) {
        showMessage(res.errorMessage);
        $("#div_form").html(res.content);
    }
</script>