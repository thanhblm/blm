<?php

use common\template\extend\Link;
use core\Lang;

?>
<div id="why_house_call" class="find-out-block">
    <div class="container">
        <div class="row">
            <h2 class="text-center"><?= Lang::get("WHY HOUSECALL PRO?") ?></h2>
            <h3><?= Lang::get("Solutions for your business.") ?></h3>
            <h4><?= Lang::get("Whether you need to improve dispatching, reduce paperwork, increase workforce or grow revenue, we have a solution.") ?></h4>
        </div>
        <div class="row" style="margin-top: 30px">
            <div class="col-md-6" style="margin-bottom: 30px;">
                <div class="embed-responsive embed-responsive-16by9 container">
                    <iframe class="embed-responsive-item" width="100%" height="350px"
                            src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                </div>
                <div class="col-md-12"  style="margin-left: 50px">
                    <ul class="list-group">
                        <li class="list-group-item active"><?= Lang::get("Work simpler") ?></li>
                        <li class="list-group-item"><?= Lang::get("Improve scheduling and dispatching") ?></li>
                        <li class="list-group-item"><?= Lang::get("Reduce paperwork and admin tasks") ?></li>
                        <li class="list-group-item"><?= Lang::get("Create estimates, issue invoices and get paid") ?></li>
                    </ul>
                </div>
                <div class="col-md-12"  style="margin-left: 50px">
                    <?php
                    $link = new Link();
                    $link->class = "btn btn-circle blue";
                    $link->attributes = "onclick=\"clickLearnMore()\"";
                    $link->title = Lang::get("Learn more ") . "<i class=\"fa fa-arrow-right\"></i>";
                    $link->id = "iClickLearnMore";
                    $link->render();
                    ?>
                </div>
            </div>

            <div class="col-md-6" style="margin-bottom: 30px;">
                <div class="embed-responsive embed-responsive-16by9 container" >
                    <iframe class="embed-responsive-item" width="100%" height="350px"
                            src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                </div>
                <div class="col-md-12" >
                    <ul class="list-group" style="margin-left: 50px">
                        <li class="list-group-item active"><?= Lang::get("Work simpler") ?></li>
                        <li class="list-group-item"><?= Lang::get("Improve scheduling and dispatching") ?></li>
                        <li class="list-group-item"><?= Lang::get("Reduce paperwork and admin tasks") ?></li>
                        <li class="list-group-item"><?= Lang::get("Create estimates, issue invoices and get paid") ?></li>
                    </ul>
                </div>
                <div class="col-md-12" style="margin-left: 50px">
                    <?php
                    $link = new Link();
                    $link->class = "btn btn-circle blue";
                    $link->attributes = "onclick=\"clickLearnMore()\"";
                    $link->title = Lang::get("Learn more ") . "<i class=\"fa fa-arrow-right\"></i>";
                    $link->id = "iClickLearnMore";
                    $link->render();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>