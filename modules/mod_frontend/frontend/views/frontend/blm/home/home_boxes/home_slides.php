<?php

use common\helper\DatoImageHelper;
use common\template\extend\Button;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$slides = RequestUtil::get("slides");
?>
<!-- BEGIN SLIDER
<div class="top-line" id="top_line" data-slides="null">
	<?php
foreach ($slides as $slide) {
    $imageMo = DatoImageHelper::getImageInfoById($slide->image);
    ?>
		<div class="slide" style="background-image: url(<?= DatoImageHelper::getUrl($imageMo) ?>)" data-delay="5">
			<div class="textblock">
				<div class="heading">
					<?= $slide->title ?>
				</div>
				<div class="body">
					<p><?= $slide->description ?></p>
				</div>
			</div>
		</div>
		<?php
}
?>
	<div class="bubbles">
		<span class="bubble"></span><span class="bubble"></span><span class="bubble sel"></span>
	</div>
	<a href="#find-out" class="scroll-down"><span class="icon scroll"></span><br><?= Lang::get("Scroll Down") ?></a>
	<svg viewbox="0 0 1920 110">
		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<g fill="#f5f6f9">
				<path d="M0,110 L1920,110 L1920,1 L963.969078,109.549344 C961.777017,109.798235 958.226571,109.796795 956.030922,109.54521 L0,0 L0,110 Z"/>
			</g>
		</g>
	</svg>
</div>

END SLIDER -->
<div class="jumbotron jumbotron-fluid">

    <video autoplay muted loop poster="https://dummyimage.com/900x400/000/fff">
        <source src="" data-src="https://upload.wikimedia.org/wikipedia/commons/7/79/Big_Buck_Bunny_small.mp4"
                type="video/mp4">
        <source src="" data-src="https://upload.wikimedia.org/wikipedia/commons/7/79/Big_Buck_Bunny_small.webm"
                type="video/webm">
        <source src="" data-src="https://upload.wikimedia.org/wikipedia/commons/7/79/Big_Buck_Bunny_small.ogv"
                type="video/ogg">
    </video>

    <div class="container text-white">
        <h1><?= Lang::get("FREE 14 DAY TRIAL") ?></h1>
        <h2><?= Lang::get("Work simpler. Grow smarter.") ?></h2>
        <h4><?= Lang::get("Start a risk free trial to see how easily you can improve scheduling, dispatching, invoicing and payment collection.") ?></h4>
        <div class="row">
            <div class="container" style="max-width: 613px;height: 50px;min-height: 50px;">
                <div class="col-md-6">
                    <?php
                    $textExtend = new TextInput();
                    $textExtend->placeholder = Lang::get("Enter your Email");
                    $textExtend->name = "id_email_subcriber_text";
                    $textExtend->id = "id_email_subcriber_text";
                    $textExtend->render();
                    ?>
                </div>
                <div class="col-md-6">
                    <div class="_buttons dt-buttons">
                        <?php
                        $button = new Button();
                        $button->class = "wide";
                        $button->id = "btnSubcribeSubmit";
                        $button->title = Lang::get("START FREE TRIAL");
                        $button->type = "button";
                        $button->attributes = 'onclick="registerCustomer()"';
                        $button->render();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
</div>
<!-- /.jumbotron -->
<script type="text/javascript">
    function deferVideo() {

        $("video source").each(function () {
            var sourceFile = $(this).attr("data-src");
            $(this).attr("src", sourceFile);
            const video = this.parentElement;
            //video.load();
            video.play();
        });

    }

    window.onload = deferVideo;
</script>