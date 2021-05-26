<?php
use common\template\extend\Button;
use common\template\extend\FormContainer;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use common\template\extend\Text;
use core\utils\ActionUtil;

$customer = RequestUtil::get("customer");
?>
<div class="row">
    <div class="light col-xs-6 col-xs-offset-3">
        <div class="box col-xs-12">
            <h2><?=Lang::get("Change your password")?></h2>
            <p><?=Lang::get("Please enter your new password to change your password.")?></p>
			<?php

			if (RequestUtil::hasActionMessages()) {
				echo RequestUtil::getErrorMessage();
			}
			if (RequestUtil::hasFieldErrors()) {
				echo RequestUtil::getFieldErrors();
			}

			$form = new FormContainer ();
			$form->id = "formChangePassId";
			$form->action = ActionUtil::getFullPathAlias("home/customer/password/reminder/confirm/update");
			$form->method = "post";
			$form->attributes = 'class="form-horizontal"';
			$form->renderStart();

			if(!AppUtil::isEmptyString(RequestUtil::getErrorMessage())){
				?>
				<ul class="message-stack"><li class="error"><?=RequestUtil::getErrorMessage() ?></li></ul>
			<?php } 
			if(RequestUtil::hasActionMessages()) {
			?>
			<ul class="message-stack">
				<li class="success"><?=RequestUtil::getActionMessage() ?></li>
			</ul>
			<?php 
			}
			?>
            <div class="_form">
				<?php
				$text = new Text();
				$text->type = "hidden";
				$text->name = "codeComfirmPw";
				$text->value = RequestUtil::get("codeComfirmPw");
				$text->render();

				$text = new TextInput ();
				$text->errorMessage = RequestUtil::getFieldError("customer[password]");
				$text->hasError = RequestUtil::isFieldError("customer[password]");
				$text->name = "customer[password]";
				$text->placeholder = "New password...";
				$text->type = "password";
				$text->required = true;
				$text->class = " ";
				$text->render();

				$text = new TextInput ();
				$text->errorMessage = RequestUtil::getFieldError("cPassword");
				$text->hasError = RequestUtil::isFieldError("cPassword");
				$text->name = "cPassword";
				$text->placeholder = "Confirm password...";
				$text->type = "password";
				$text->required = true;
				$text->class = " ";
				$text->render();

				?>
            </div>
            <div class="_buttons dt-buttons">
				<?php
				$button = new Button();
				$button->type = "submit";
				$button->id = "btnChangePassSubmit";
				$button->title = " " . Lang::get("Change password");
				$button->attributes = "";
				$button->class = " ";
				$button->render();
				?>
            </div>
			<?php
			$form->renderEnd();
			?>
        </div>
    </div>
</div>
