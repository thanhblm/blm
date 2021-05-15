<?php
use common\rule\url\friendly\AliasUrlFriendly;
use common\template\extend\Button;
use common\template\extend\TextInput;
use common\helper\NetworkHelper;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\ActionUtil;

?>

<footer id="footer">
    <div class="container-fluid">
        <div class="light">
            <div class="row">
                <article class="box col-xs-12 col-sm-3 text">
                    <div>
                        <ul>
                            <li>
                                <a href="<?= ActionUtil::getFullPathAlias("/") ?>"><?= Lang::get('Homepage') ?></a>
                            </li>
                            <li>
                                <a href="<?= ActionUtil::getFullPathAlias("home/faq", new AliasUrlFriendly("faq")) ?>"><?= Lang::get('FAQ') ?></a>
                            </li>
                            <li>
                                <a href="https://www.trustpilot.com/review/www.sbirds.vn"><?= Lang::get('Tell your story') ?></a>
                            </li>
                            <li>
                                <a href="<?= ActionUtil::getFullPathAlias("home/quality/control", new AliasUrlFriendly("quy-chuan-chat-luong")) ?>"><?= Lang::get('Quality') ?></a>
                            </li>
                            <li>
                                <a href="<?= ActionUtil::getFullPathAlias("home/about/us", new AliasUrlFriendly("gioi-thieu")) ?>"><?= Lang::get('About us') ?></a>
                            </li>
                            <li>
                                <a href="<?= ActionUtil::getFullPathAlias("category/list", new AliasUrlFriendly("products")) ?>"><?= Lang::get('Products') ?></a>
                            </li>
                            <li>
                                <a href="<?= ActionUtil::getFullPathAlias("home/terms/and/conditions", new AliasUrlFriendly("terms-and-conditions")) ?>"><?= Lang::get('Terms and Conditions') ?></a>
                            </li>
                        </ul>
                    </div>
                </article>
                <article class="box col-xs-12 col-sm-3  text">
                    <div>
                        <p><?= Lang::get('Address') ?></p>
                        <p>
                            <strong><?= Lang::get('Viet Nam:') ?></strong><br>Tel:
                            <a style="color: inherit;" href="tel:+84-941406590">84-941406590</a>
                            <br>
                            <a style="color: #81ad00;" href="mailto:info@endoca.com">info@haiphongdeveloper.com</a>
                        </p>
                        <p>
                            <strong><?= Lang::get('USA:') ?></strong><br>2305 Historic Decatur Rd <br>San Diego
                            CA 92106 Suite 100 <br>Tel:
                            <a style="color: inherit;" href="tel:+1-123456789">1-123456789</a>
                            <br>
                            <a style="color: #81ad00;" href="mailto:info@haiphongdeveloper.com">info@haiphongdeveloper.com</a>
                        </p>
                    </div>
                </article>
                <article class="box col-xs-12 col-sm-6 text">
                    <div>
                        <p>
                            <strong><?= Lang::get('Subscribe for Updates') ?></strong>
                        </p>
                        <p id="news_header" class="subscribe-text-above"><?= Lang::get('Sign up to receive regular updates, news and educational material about the benefits of CBD oil.') ?></p>
						<div id="subscriber_form_result">
                        <form id="newsletter-form" class="_newsletter" onsubmit="return false;">
                            <div class="col-xs-12 col-md-2 no-padding">
								<?php
								$text = new TextInput ();
								$text->type = "Text";
								$text->name = "subscriber[firstName]";
								$text->placeholder = Lang::get("First name");
								$text->class = "name";
								$text->render();
								?>
                            </div>
                            <div class="col-xs-12 col-md-2 no-padding">
								<?php
								$text = new TextInput ();
								$text->type = "Text";
								$text->name = "subscriber[lastName]";
								$text->placeholder = Lang::get("Last name");
								$text->class = "name";
								$text->render();
								?>
                            </div>
                            <div class="col-xs-12 col-md-4 col-lg-5 no-padding">
								<?php
								$text = new TextInput ();
								$text->type = "text";
								$text->name = "subscriber[email]";
								$text->required = "required";
								$text->placeholder = Lang::get("Email");
								$text->class = "email";
								$text->render();
								?>
                            </div>
                            <div class="col-xs-12 col-md-4 col-lg-3 no-padding">
								<?php
								$button = new Button();
								$button->type = "submit";
								$button->id = "";
								$button->title = Lang::get('Send Me Updates');
								$button->attributes = "onclick=\" addSubscriber()\"";
								$button->render();
								?>
                            </div>
                        </form>
						</div>
                        <p class="subscribe-text-below"><?= Lang::get('Your email address is safe, you can unsubscribe any time') ?></p>
                        <ul class="social">
                            <li class="facebook">
                                <a href="https://www.facebook.com/endoca"><?= Lang::get('Facebook') ?></a>
                            </li>
                            <li class="google">
                                <a href="https://plus.google.com/+EndocaCBD"><?= Lang::get('Google+') ?></a>
                            </li>
                            <li class="twitterbird">
                                <a href="https://twitter.com/Endocacbdoil"><?= Lang::get('Twitter') ?></a>
                            </li>
                            <li class="instagram">
                                <a href="https://www.instagram.com/endoca/"><?= Lang::get('Instagram') ?></a>
                            </li>
                            <li class="blog">
                                <a href="https://www.endoca.com/blog/"><?= Lang::get('Blog') ?></a>
                            </li>
                            <li class="youtube">
                                <a href="https://www.youtube.com/channel/UCNXwDCTBaa0WPEf1cOUHe9g"><?= Lang::get('Twitter') ?></a>
                            </li>
                        </ul>
                        <h3>
                            <span class="wrap" style="font-size: 85%; color: #ffffff; font-weight: bold;"><?= Lang::get('Sbirds - Đồng phục yêu thương') ?></span>
                        </h3>
                    </div>
                </article>
            </div>
        </div>
        <div class="bot row">
            <div class="col-xs-12">
                <div class="box col-xs-12 col-md-6 copy"><?= Lang::get("© 2020 Sbirds. All rights reserved.") ?>
                    <br><span style="font-size: 85%;">
                        <?= Lang::get("Đồng phục yêu thương") ?>
                    </span>
                </div>
                <div class="box col-xs-12 col-md-6 cards">
                    Cards: <span class="sprite visa-mastercard-maestro"></span>
                </div>
            </div>
        </div>
    </div>
</footer>
<script type="text/javascript">
	gUrlAddSubscriber = "<?=ActionUtil::getFullPathAlias("home/subscriber/add") ?>" + "?rtype=json";
	function addSubscriber(){
		simpleAjaxPost(
			guid(),
			gUrlAddSubscriber,
			$("form#newsletter-form").serialize(),
			onAddSubscriberSuccess,
			onAddSubscriberFieldErrors,
			onAddSubscriberActionErrors
		);
	}
	function onAddSubscriberSuccess(res){
		$("#subscriber_form_result").replaceWith(res.content);
		showMessage(res.errorMessage);
	}
	function onAddSubscriberFieldErrors(res){
		$("#newsletter-form").replaceWith(res.content);
	}
	function onAddSubscriberActionErrors(res){
		showMessage(res.errorMessage, "error");
	}
</script>
