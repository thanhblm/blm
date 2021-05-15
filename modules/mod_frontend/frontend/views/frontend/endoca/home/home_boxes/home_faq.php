<?php
use core\Lang;
use core\utils\ActionUtil;

?>

<div class="white faq pdb50">
    <div class="box col-xs-12 text">
        <div>
            <h2 style="text-align: center;">FAQ</h2>
        </div>
    </div>
    <div class="box col-xs-6 text">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="collapsed" href="/#question-1" data-toggle="collapse">
                            <strong>Demo?</strong>
                        </a>
                    </h4>
                </div>
                <div id="question-1" class="panel-collapse collapse">
                    <div class="collapse-inner">
                        <p>
<span>Demo </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cb"></div>
    <p class="content-line" style="margin: 0 20px 20px; text-align: center;">
        <span><a href="<?= ActionUtil::getFullPathAlias("home/faq") ?>"><?= Lang::get("Read more") ?></a></span>
    </p>
</div>

