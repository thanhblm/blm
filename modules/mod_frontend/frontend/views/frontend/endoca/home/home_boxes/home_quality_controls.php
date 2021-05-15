<?php
use core\Lang;
use core\utils\AppUtil;

?>
<div class="content-line knob-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12"><h2><?=Lang::get("Quality Control")?></h2></div>
        </div>
        <div id="control" class="row">
            <div class="col-sm-12"></div>
            <div class="col-sm-3">
                <div class="qualityControlImg">
                    <img src="<?=AppUtil::resource_url("layouts/endoca.com/images/home/quality_control/-buy-cbd-oil-in-canada-from-endoca-com.png")?>" alt="CBD Oil" title=" CBD Oil " width="61" height="63">
                </div>
                <div class="qualityControlHead"> Guaranteed</div>
                <div class="qualityControlContent"><p>Accurate CBD Concentration Guaranteed</p></div>
            </div>
            <div class="col-sm-3">
                <div class="qualityControlImg">
                    <img src="<?=AppUtil::resource_url("layouts/endoca.com/images/home/quality_control/-high-strength-cbd-oil-uk-from-endoca-com.png")?>" alt="CBD Oil" title=" CBD Oil " width="63" height="63">
                </div>
                <div class="qualityControlHead"> Organic</div>
                <div class="qualityControlContent"><p>The Hemp We Grow Is Certified Organic</p>
                    <div class="col-sm-3">&nbsp;</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="qualityControlImg">
                    <img src="<?=AppUtil::resource_url("layouts/endoca.com/images/home/quality_control/rick-simpson-hemp-oil-where-to-buy-from-endoca-com.png")?>" alt="CBD Oil" title=" CBD Oil " width="62" height="63">
                </div>
                <div class="qualityControlHead"> Quality tested</div>
                <div class="qualityControlContent"><p>Produced under good manufacturing practices</p></div>
            </div>
            <div class="col-sm-3">
                <div class="qualityControlImg">
                    <img src="<?=AppUtil::resource_url("layouts/endoca.com/images/home/quality_control/hemp-oil-and-cannabis-oil-from-endoca-com.png")?>" alt="CBD Oil" title=" CBD Oil " width="62" height="62">
                </div>
                <div class="qualityControlHead"> Tested by a third party</div>
                <div class="qualityControlContent"><p>Tested and monitored by a third party for over 200 pesticides,
                        heavy metals, herbicides, bacteria, molds, fungi and mycotoxins.</p></div>
            </div>
            <div class="col-xs-12 t-alc">
                <div class="percents mgt60 mgb100">
                    <div class="knob-container k1"><input id="cs_knob1" class="num" rel="100" disabled value="100%"/> <span class="name"><?= Lang::get('Natural');?></span></div>
                    <div class="knob-container k2"><input id="cs_knob2" class="num" rel="100" disabled value="100%"/> <span class="name"><?=Lang::get('Legal')?></span></div>
                    <div class="knob-container k3"><input id="cs_knob3" class="num" rel="100" disabled value="100%"/> <span class="name"><?=Lang::get('Organic')?></span></div>
                    <div class="knob-container k4"><input id="cs_knob4" class="num" rel="100" disabled value="100%"/> <span class="name"><?=Lang::get('Quality tested')?></span></div>
                    <img src="<?=AppUtil::resource_url("layouts/endoca.com/images/home/quality_control/-cbd-hemp-oil-uses-from-endoca.com.png")?>" alt="Hemp Oil Drops CBD Oil" title=" Hemp Oil Drops CBD Oil " width="557" height="606" class="knob-visible-image">
                </div>
            </div>
        </div>
    </div>
</div>