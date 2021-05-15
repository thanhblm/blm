<?php

use core\utils\RequestUtil;
use common\template\extend\TextInput;
use common\template\extend\TextArea;
use core\Lang;

$contact = RequestUtil::get("contact");
?>
<form class="row" id="contact_form" onsubmit="return false;">
    <?php
    $text = new TextInput();
    $text->type = "text";
    $text->id = "contact_form_fullname";
    $text->class = " form-control ";
    $text->name = "contact[fullName]";
    $text->placeholder = Lang::get('Fullname');
    $text->required = "required";
    $text->render();

    $text = new TextInput();
    $text->type = "text";
    $text->id = "contact_form_email";
    $text->class = " form-control ";
    $text->name = "contact[email]";
    $text->placeholder = Lang::get('Email');
    $text->required = "required";
    $text->render();

    $text = new TextInput();
    $text->type = "text";
    $text->id = "contact_form_phone";
    $text->class = " form-control ";
    $text->name = "contact[phone]";
    $text->placeholder = Lang::get('Phone');
    $text->required = "required";
    $text->render();

    $textArea = new TextArea();
    $textArea->class = " form-control ";
    $textArea->placeholder = Lang::get('Message');
    $textArea->id = "contact_form_message";
    $textArea->name = "contact[message]";
    $textArea->attributes = "cols=\"15\" rows=\"4\"";
    $textArea->render();
    ?>
</form>
