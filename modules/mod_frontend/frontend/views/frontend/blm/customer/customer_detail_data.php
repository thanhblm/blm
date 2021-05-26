<?php
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\Button;
$customer = RequestUtil::get ( 'customer' );
$address = RequestUtil::get ( "address" );
?>

<?php
$form = new FormContainer ();
$form->id = "customerDetailForm";
$form->attributes = 'class=""';

$form->renderStart ();
?>
 <h2><?= Lang::get("Account Info") ?></h2>
<div class="form-body">
    <div class="row">
        <?php
        $text = new Text ();
        $text->type = "hidden";
        $text->value = $customer->id;
        $text->name = "customer[id]";
        $text->render ();
        ?>
        <div class="col-xs-12 col-md-6">
            <?php
            $text = new TextInput ();
            $text->errorMessage = RequestUtil::getFieldError ( "customer[firstName]" );
            $text->hasError = RequestUtil::isFieldError ( "customer[firstName]" );
            $text->label = Lang::get ( "First Name" );
            $text->required = true;
            $text->name = "customer[firstName]";
            $text->value = $customer->firstName;
            $text->class = " ";
            $text->placeholder = Lang::get ( "First Name..." );
            $text->render ();

            $text = new TextInput ();
            $text->errorMessage = RequestUtil::getFieldError ( "customer[email]" );
            $text->hasError = RequestUtil::isFieldError ( "customer[email]" );
            $text->label = Lang::get ( "Email Address" );
            $text->name = "customer[email]";
            $text->required = true;
            $text->class = " ";
            $text->placeholder = Lang::get ( "Email..." );
            $text->value = $customer->email;
            $text->render ();

            $text = new TextInput ();
            $text->errorMessage = RequestUtil::getFieldError ( "customer[companyName]" );
            $text->hasError = RequestUtil::isFieldError ( "customer[companyName]" );
            $text->label = Lang::get ( "Company Name" );
            $text->name = "customer[companyName]";
            $text->value = $customer->companyName;
            $text->class = " ";
            $text->placeholder = Lang::get ( "Company Name..." );
            $text->render ();

            $text = new TextInput ();
            $text->errorMessage = RequestUtil::getFieldError ( "customer[phone]" );
            $text->hasError = RequestUtil::isFieldError ( "customer[phone]" );
            $text->label = Lang::get ( "Phone" );
            $text->name = "customer[phone]";
            $text->required = true;
            $text->placeholder = Lang::get ( "Phone..." );
            $text->value = $customer->phone;
            $text->class = " ";
            $text->render ();

            $text = new TextInput ();
            $text->errorMessage = RequestUtil::getFieldError ( "customer[fax]" );
            $text->hasError = RequestUtil::isFieldError ( "customer[fax]" );
            $text->label = Lang::get ( "FAX" );
            $text->name = "customer[fax]";
            $text->placeholder = Lang::get ( "FAX..." );
            $text->value = $customer->fax;
            $text->class = " ";
            $text->render ();
            ?>
        </div>

        <div class="col-xs-12 col-md-6">
            <?php
            $text = new TextInput ();
            $text->errorMessage = RequestUtil::getFieldError ( "customer[lastName]" );
            $text->hasError = RequestUtil::isFieldError ( "customer[lastName]" );
            $text->label = Lang::get ( "Last Name" );
            $text->required = true;
            $text->class = " ";
            $text->name = "customer[lastName]";
            $text->value = $customer->lastName;
            $text->placeholder = Lang::get ( "Last Name..." );
            $text->render ();

            $text = new TextInput ();
            $text->errorMessage = RequestUtil::getFieldError ( "customer[vatNo]" );
            $text->hasError = RequestUtil::isFieldError ( "customer[vatNo]" );
            $text->label = Lang::get ( "VAT No" );
            $text->name = "customer[vatNo]";
            $text->value = $customer->vatNo;
            $text->class = " ";
            $text->placeholder = Lang::get ( "VAT No..." );
            $text->render ();

            $text = new TextInput ();
            $text->type = "password";
            $text->errorMessage = RequestUtil::getFieldError ( "customer[password]" );
            $text->hasError = RequestUtil::isFieldError ( "customer[password]" );
            $text->label = Lang::get ( "Password" );
            $text->name = "customer[password]";
            $text->class = " ";
            $text->placeholder = Lang::get ( "Your new password..." );
            $text->value = "";
            $text->render ();
            
            $text = new TextInput ();
            $text->type = "password";
            $text->errorMessage = RequestUtil::getFieldError ( "cPassword" );
            $text->hasError = RequestUtil::isFieldError ( "cPassword" );
            $text->label = Lang::get ( "Confirm Password" );
            $text->name = "cPassword";
            $text->class = " ";
            $text->placeholder = Lang::get ( "Confirm Password..." );
            $text->value = "";
            $text->render ();
            ?>
        </div>
    </div>
</div>
<div class="_buttons dt-buttons">
<?php
$button = new Button();
$button->type = "button";
$button->class = "btn btn-endoca-green";
$button->id = "btnSaveCustomerSubmit";
$button->title = " " . Lang::get("Update");
$button->attributes = 'onclick="javascript:editCustomer()"';
$button->render();
?>
                            </div>
<?php $form->renderEnd ();?>
								