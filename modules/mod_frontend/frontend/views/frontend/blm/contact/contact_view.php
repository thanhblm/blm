<?php
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\ActionUtil;
use common\template\extend\TextInput;
use common\template\extend\TextArea;
use core\template\html\base\BaseSelect;
use common\template\extend\SelectInput;
use core\Lang;

$countryList = RequestUtil::get("countryList");
?>
<main id="main">
    <div class="row white">
        <div>
            <div class="box col-xs-12  text ">
                <div>
                    <h1><?= Lang::get('Contact us')?></h1>
                    <h2><?= Lang::get('How to find us')?>?</h2>
                </div>
            </div>
            <div class="box col-xs-12 col-md-4 shadow text ">
                <div>
                    <h2><?= Lang::get('Cơ sở Hải Phòng')?></h2>
                    <p>
                       <?= Lang::get('SBirds HP')?> <br>
                       <?= Lang::get('Ngã ba Vsip đối diện Honda Minh Hai')?>
                    </p>
                    <p>
                        <a href="/mailto:infohp@sbirds.vn">infohp@sbirds.vn</a>
                        <br><?= Lang::get('Tel')?> :&nbsp;<a href="/tel:+1-619-831-0156">1-619-831-0156</a>
                    </p>
                    <p></p>
                    <div id="map-1" style="height: 350px; width: 100%; position: relative; overflow: hidden;">
                    </div>
                    <p></p>
                </div>
            </div>
            <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyD1NznvcUvknJAkydrVDYq20DTP7oVMRyM"></script>
            <script type="text/javascript"><!--
				var WEB_ROOT = location.protocol + "//" + location.host + "/";
				//--></script>
            <script type="text/javascript"><!--
				$(function(){
					new google.maps.Marker({
						position: new google.maps.LatLng(32.734363, -117.216462),
						map: new google.maps.Map(document.getElementById('map-1'), {
							zoom: 15,
							center: new google.maps.LatLng(32.734363, -117.216462),
							styles: [{
								"featureType": "administrative",
								"elementType": "all",
								"stylers": [{"visibility": "on"}, {"lightness": 33}]
							}, {
								"featureType": "landscape",
								"elementType": "all",
								"stylers": [{"color": "#f2e5d4"}]
							}, {
								"featureType": "poi.park",
								"elementType": "geometry",
								"stylers": [{"color": "#c5dac6"}]
							}, {
								"featureType": "poi.park",
								"elementType": "labels",
								"stylers": [{"visibility": "on"}, {"lightness": 20}]
							}, {
								"featureType": "road",
								"elementType": "all",
								"stylers": [{"lightness": 20}]
							}, {
								"featureType": "road.highway",
								"elementType": "geometry",
								"stylers": [{"color": "#c5c6c6"}]
							}, {
								"featureType": "road.arterial",
								"elementType": "geometry",
								"stylers": [{"color": "#e4d7c6"}]
							}, {
								"featureType": "road.local",
								"elementType": "geometry",
								"stylers": [{"color": "#fbfaf7"}]
							}, {
								"featureType": "water",
								"elementType": "all",
								"stylers": [{"visibility": "on"}, {"color": "#acbcc9"}]
							}]
						}),
						icon: {
							url: "<?=AppUtil::resource_url("layouts/endoca.com/images/endoca_map_marker.png")?>",
							scaledSize: new google.maps.Size(40, 40),
							origin: new google.maps.Point(0, 0),
							anchor: new google.maps.Point(0, 0)
						}
					});
					new google.maps.Marker({
						position: new google.maps.LatLng(55.676097, 12.568337),
						map: new google.maps.Map(document.getElementById('map-2'), {
							zoom: 15,
							center: new google.maps.LatLng(55.676097, 12.568337),
							styles: [{
								"featureType": "administrative",
								"elementType": "all",
								"stylers": [{"visibility": "on"}, {"lightness": 33}]
							}, {
								"featureType": "landscape",
								"elementType": "all",
								"stylers": [{"color": "#f2e5d4"}]
							}, {
								"featureType": "poi.park",
								"elementType": "geometry",
								"stylers": [{"color": "#c5dac6"}]
							}, {
								"featureType": "poi.park",
								"elementType": "labels",
								"stylers": [{"visibility": "on"}, {"lightness": 20}]
							}, {
								"featureType": "road",
								"elementType": "all",
								"stylers": [{"lightness": 20}]
							}, {
								"featureType": "road.highway",
								"elementType": "geometry",
								"stylers": [{"color": "#c5c6c6"}]
							}, {
								"featureType": "road.arterial",
								"elementType": "geometry",
								"stylers": [{"color": "#e4d7c6"}]
							}, {
								"featureType": "road.local",
								"elementType": "geometry",
								"stylers": [{"color": "#fbfaf7"}]
							}, {
								"featureType": "water",
								"elementType": "all",
								"stylers": [{"visibility": "on"}, {"color": "#acbcc9"}]
							}]
						}),
						icon: {
							url: "<?=AppUtil::resource_url("layouts/endoca.com/images/endoca_map_marker.png")?>",
							scaledSize: new google.maps.Size(40, 40),
							origin: new google.maps.Point(0, 0),
							anchor: new google.maps.Point(0, 0)
						}
					});
				});
				//--></script>
            <div class="box col-xs-12 col-md-4 shadow text ">
                <div>
                    <h2><?= Lang::get('Cơ sở HCM')?></h2>
                    <p>
                        <?= Lang::get('Comming soon')?>
                    </p>
                    <p>
                        <a href="/mailto:infohcm@sbirds.vn">infohcm@sbirds.vn</a>
                        <br><?= Lang::get('Tel')?>:&nbsp;<a href="/tel:+45-898-707-00">45-898-707-00</a>
                        <br>
                        <br>
                    </p>
                    <p></p>
                    <div id="map-2" style="height: 350px; width: 100%; position: relative; overflow: hidden;">
                    </div>
                    <p></p>
                </div>
            </div>
            <div class="box col-xs-12 col-md-4 gray text ">
                <div>
                    <h2><?= Lang::get('Leave Us a Message Below')?></h2>
                    <form id="contact-form" name="contact" class="_contact  purlForm" onsubmit="return false;">
                        <div class="_form">
							<?php
							$text = new TextInput();
							$text->type = "text";
							$text->id = "contact-form-fullname";
							$text->class = " ";
							$text->name = "contact[fullName]";
							$text->placeholder = Lang::get('Fullname');
							$text->required = "required";
							$text->render();

							$text = new TextInput();
							$text->type = "text";
							$text->id = "contact-form-email";
							$text->class = " ";
							$text->name = "contact[email]";
							$text->placeholder = Lang::get('Email');
							$text->required = "required";
							$text->render();

							$text = new TextInput();
							$text->type = "text";
							$text->id = "contact-form-phone";
							$text->class = " ";
							$text->name = "contact[phone]";
							$text->placeholder = Lang::get('Phone');
							$text->required = "required";
							$text->render();

							$select = new SelectInput();
							$select->id = "contact-form-country";
							$select->class = " ";
							$select->headerKey = "";
							$select->headerValue = Lang::get("Country");
							$select->name = "contact[countryCode]";
							$select->propertyName = "iso2";
							$select->propertyValue = "name";
							$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_OBJECT;
							$select->collections = $countryList;
							$select->required = "required";
							$select->render();

							$textArea = new TextArea();
							$textArea->class = " ";
							$textArea->placeholder = Lang::get('Message');
							$textArea->id = "contact-form-message";
							$textArea->name = "contact[message]";
							$textArea->attributes = "wrap=\"soft\" cols=\"15\" rows=\"4\"";
							$textArea->render();
							?>
                        </div>
                        <div class="_buttons">
                            <button type="submit" onclick="addContact()">
                                <span><?=Lang::get('Send Message')?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
	gUrlAddContact = "<?=ActionUtil::getFullPathAlias("home/contact/add") ?>?rtype=json";
	function addContact(){
		simpleAjaxPost(
			guid(),
			gUrlAddContact,
			$("form#contact-form").serialize(),
			onAddContactSuccess,
			onAddContactFieldErrors,
			onAddContactActionErrors
		);
	}
	function onAddContactSuccess(res){
		showMessage(res.errorMessage);
		$("#contact-form-fullname").val("");
		$("#contact-form-email").val("");
		$("#contact-form-phone").val("");
		$("#contact-form-country").val("");
		$("#contact-form-message").val("");
	}
	function onAddContactFieldErrors(res){
		$("#contact-form").replaceWith(res.content);
	}
	function onAddContactActionErrors(res){
		showMessage(res.errorMessage, "error");
	}
</script>