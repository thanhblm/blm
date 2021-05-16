<?php

use common\helper\DatoImageHelper;
use common\helper\SettingHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use common\rule\url\friendly\BlogUrlFriendly;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$slides = RequestUtil::get("slides");
$slideDoiDac = RequestUtil::get("slideDoiDac");
$slideTaiXe = RequestUtil::get("slideTaiXe");
$blog = RequestUtil::get("gioiThieuVo");
?>

<main class="site-main">
<section class="jss1 jss125 jss127 jss128" data-testid="HeroSection-root">
            <div data-testid="HeroSection-darkOverlay" class="jss126"></div>
            <video data-testid="HeroSectionBackgroundMedia-video" class="jss129" poster="../images.ctfassets.net/6hguaqyqmoa2/77REvKbP5wDCB3thPXmQkB/b4623d4fa88b095c4238c4edbfd14af6/montage-video-poster4c30.jpg?w=800&amp;q=50" muted="" autoplay="" data-autoplay="true" loop="" playsinline="" preload="true">
                <source src="http://videos.ctfassets.net/6hguaqyqmoa2/1JUnyS24IfHkuvM5Jaxcwt/4860aa33bd81f56f6421cbeded7aeae5/home-desktop-1920x800-1.mp4" type="video/mp4" />
            </video>
            <div class="jss130 jss131 jss2 jss120">
                <div class="jss132 jss139 hero-section-content-child jss3">
                    <div data-testid="Headline-root" class="jss142 jss148 jss133 jss140">
                        <div class="jss143">
                            <p class="MuiTypography-root MuiTypography-h5 MuiTypography-colorTextPrimary"><span style="display:block">FREE 14 DAY TRIAL</span></p>
                        </div>
                        <h1 class="MuiTypography-root jss144 jss146 MuiTypography-h1"><span style="display:block"><?= Lang::get('Work simpler. Grow smarter.') ?></span></h1>
                        <h4 class="MuiTypography-root jss145 jss146 MuiTypography-h4">Start a risk free trial to see how easily you can improve scheduling, dispatching, invoicing and payment collection.</h4>
                    </div>
                    <div class="jss137 jss141">
                        <div class="jss47 jss138" data-testid="Form-root">
                            <form data-testid="FreeTrialEmailForm-root" class="jss55">
                                <div class="MuiFormControl-root MuiTextField-root jss65 jss56 jss62">
                                    <div class="MuiInputBase-root MuiOutlinedInput-root jss67 MuiInputBase-formControl">
                                        <input type="email" aria-invalid="false" id="EmailForm-Field-email" name="email" placeholder="Enter your email" value="" data-testid="EmailForm-Field-email" aria-label="Email" class="MuiInputBase-input MuiOutlinedInput-input jss66 jss150 jss57 jss62" />
                                        <fieldset aria-hidden="true" style="padding-left:8px" class="jss73 MuiOutlinedInput-notchedOutline">
                                            <legend class="jss74" style="width:0.01px"><span>&#8203;</span></legend>
                                        </fieldset>
                                    </div>
                                </div>
                                <button class="MuiButtonBase-root MuiButton-root jss58 jss63 MuiButton-contained jss33 jss34 MuiButton-containedPrimary MuiButton-containedSizeSmall MuiButton-sizeSmall MuiButton-disableElevation" tabindex="0" type="submit" data-testid="EmailForm-button"><span class="MuiButton-label">Start Free Trial</span></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="hero-section-content-child jss5">
                    <p class="MuiTypography-root jss4 MuiTypography-body2">Trusted by 17,000 HVACs, plumbers, electricians, cleaners &amp; others</p>
                    <div class="jss151">
                        <span class="MuiRating-root jss157 MuiRating-readOnly" role="img" aria-label="4.5 Stars">
                            <span class="MuiRating-decimal">
                                <span style="width:0%;overflow:hidden;z-index:1;position:absolute">
                                    <span class="MuiRating-icon MuiRating-iconFilled">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    </span>
                                </span>
                                <span>
                                    <span class="MuiRating-icon MuiRating-iconFilled">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    </span>
                                </span>
                            </span>
                            <span class="MuiRating-decimal">
                                <span style="width:0%;overflow:hidden;z-index:1;position:absolute">
                                    <span class="MuiRating-icon MuiRating-iconFilled">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    </span>
                                </span>
                                <span>
                                    <span class="MuiRating-icon MuiRating-iconFilled">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    </span>
                                </span>
                            </span>
                            <span class="MuiRating-decimal">
                                <span style="width:0%;overflow:hidden;z-index:1;position:absolute">
                                    <span class="MuiRating-icon MuiRating-iconFilled">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    </span>
                                </span>
                                <span>
                                    <span class="MuiRating-icon MuiRating-iconFilled">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    </span>
                                </span>
                            </span>
                            <span class="MuiRating-decimal">
                                <span style="width:0%;overflow:hidden;z-index:1;position:absolute">
                                    <span class="MuiRating-icon MuiRating-iconFilled">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    </span>
                                </span>
                                <span>
                                    <span class="MuiRating-icon MuiRating-iconFilled">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    </span>
                                </span>
                            </span>
                            <span class="MuiRating-decimal">
                                <span style="width:50%;overflow:hidden;z-index:1;position:absolute">
                                    <span class="MuiRating-icon MuiRating-iconFilled">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    </span>
                                </span>
                                <span>
                                    <span class="MuiRating-icon MuiRating-iconEmpty">
                                        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    </span>
                                </span>
                            </span>
                        </span>
                        <div class="jss152">
                            <svg class="MuiSvgIcon-root jss153 jss155 jss7" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"></path>
                            </svg>
                            <p class="MuiTypography-root jss154 jss156 jss6 MuiTypography-body2">
                                4.5<!-- --> • <!-- -->3.5K Ratings
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="jss158 jss128">
            <div class="jss120">
                <div data-testid="Headline-root" class="jss142 jss162">
                    <div class="jss143">
                        <p class="MuiTypography-root MuiTypography-h5 MuiTypography-colorTextPrimary"><span style="display:block">WHY HOUSECALL PRO?</span></p>
                    </div>
                    <h2 class="MuiTypography-root jss144 jss146 MuiTypography-h2"><span style="display:block">Solutions for your business.</span></h2>
                    <h4 class="MuiTypography-root jss145 jss146 MuiTypography-h4">Whether you need to improve dispatching, reduce paperwork, increase workforce or grow revenue, we have a solution. </h4>
                </div>
                <div class="jss159 jss161">
                    <div class="MuiPaper-root MuiCard-root jss164 jss168 MuiPaper-elevation1 MuiPaper-rounded" data-testid="Card-root">
                        <div data-testid="PopoverVideo-root" class="jss177">
                            <div class="wistia_responsive_padding jss178">
                                <div class="wistia_responsive_wrapper jss179">
                                    <span class="wistia_embed wistia_async_kz3kvy5rr3 popover=true videoFoam=true jss179 wistia_embed_initialized" id="wistia-kz3kvy5rr3-1"><div id="wistia_47.thumb_container" class="wistia_click_to_play" style="position: relative; height: 316.406px; width: 562.5px;"><div id="wistia_98.thumbnail" tabindex="0" style="cursor: pointer; display: block; height: 316.391px; overflow: hidden; outline: none; position: relative; width: 562.5px;" class=""><div id="wistia_114.big_play_button_background" style="height: 81px; position: absolute; width: 127px; z-index: 1; background-color: rgba(84, 187, 255, 0.8); left: 218px; top: 118px;"></div><div id="wistia_114.big_play_button_graphic" tabindex="0" role="button" aria-label="Play" style="background: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH8AAABRCAYAAAD7G3lVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAATFJREFUeNrs22FtwkAYx+F2QcAkMAfgYBKQwBxMQh1MwiRQB+CgEoaDzkG5S1a+E5IF+n+e5D4ve3+7N0s4mgYAAAAAAAAAAAAA7jFN06cp5MavjuWsTSMzfjWWszORzPizQzmvJpMZ3xYIj28LiG8LpMeffdsCufGrn3LeTS0z/uzLFsiNbwuEx7cFxL9ugY1pZsafdSaaG78abIHc+LaA+MvbAi/+XG5Sww9L2QLtEm/+P/2oUzkfbduexc+LX51L/DdrP09fzvaZf4GVhjf7/Vv3vVFk/bfvMUhg/PoAZG+6efE9Aw+MP/oCSGZ8tz0wvtseGn9w2zPjdyaXF99n9aHx3fbA+G57aHy3PTC+N/mh8b3DD4zvtofGd9tD47vtAAAAAAAAAAAAADymiwADAOSj1JBfF8xMAAAAAElFTkSuQmCC&quot;) 0px 0px / 127px 81px no-repeat transparent; cursor: pointer; display: block; height: 81px; outline: none; position: absolute; width: 127px; z-index: 1; left: 218px; top: 118px;" class=""></div><img id="wistia_98.thumbnail_img" alt="Wistia video thumbnail" src="https://embed-fastly.wistia.com/deliveries/356257f8d50ec4b692474747ba90c399.jpg?image_crop_resized=640x360" style="border: 0px; display: block; float: none; height: 316.391px; margin: 0px; max-height: none; max-width: none; padding: 0px; position: absolute; width: 562.5px; left: 0px; top: 0px;"></div></div></span>                                
                                </div>
                            </div>
                        </div>
                        <div class="MuiCardContent-root jss165 jss174">
                            <div class="jss166">
                                <h3 class="MuiTypography-root MuiTypography-h3">Work simpler</h3>
                            </div>
                            <div>
                                <ul class="MuiTypography-root MuiTypography-body1">
                                    <li class="MuiTypography-root MuiTypography-body1">Improve scheduling and dispatching</li>
                                    <li class="MuiTypography-root MuiTypography-body1">Reduce paperwork and admin tasks</li>
                                    <li class="MuiTypography-root MuiTypography-body1">Create estimates, issue invoices and get paid</li>
                                </ul>
                            </div>
                        </div>
                        <div class="MuiCardActions-root jss169 jss176 MuiCardActions-spacing">
                            <div data-testid="ActionLink-root" class="jss89"><a data-testid="Link-GatsbyLink-internal" class="MuiTypography-root jss90 jss181 MuiTypography-body1" href="work-simpler/index.html"><span>Learn more</span><span class="arrow-wrapper jss91"><span data-testid="ActionLink-arrow" class="jss93">❯</span><span data-testid="ActionLink-arrow" class="jss93">❯</span></span></a></div>
                            <button class="MuiButtonBase-root MuiIconButton-root jss170 jss172" tabindex="0" type="button" aria-expanded="false" aria-label="show more">
                                <span class="MuiIconButton-label">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="MuiPaper-root MuiCard-root jss164 jss168 MuiPaper-elevation1 MuiPaper-rounded" data-testid="Card-root">
                        <div data-testid="PopoverVideo-root" class="jss177">
                            <div class="wistia_responsive_padding jss178">
                                <div class="wistia_responsive_wrapper jss179">
                                    <span class="wistia_embed wistia_async_zn84n4rhzk popover=true videoFoam=true jss179 wistia_embed_initialized" id="wistia-zn84n4rhzk-1"><div id="wistia_57.thumb_container" class="wistia_click_to_play" style="position: relative; height: 316.406px; width: 562.5px;"><div id="wistia_197.thumbnail" tabindex="0" style="cursor: pointer; display: block; height: 316.391px; overflow: hidden; outline: none; position: relative; width: 562.5px;" class=""><div id="wistia_212.big_play_button_background" style="height: 81px; position: absolute; width: 127px; z-index: 1; background-color: rgba(84, 187, 255, 0.8); left: 218px; top: 118px;"></div><div id="wistia_212.big_play_button_graphic" tabindex="0" role="button" aria-label="Play" style="background: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH8AAABRCAYAAAD7G3lVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAATFJREFUeNrs22FtwkAYx+F2QcAkMAfgYBKQwBxMQh1MwiRQB+CgEoaDzkG5S1a+E5IF+n+e5D4ve3+7N0s4mgYAAAAAAAAAAAAA7jFN06cp5MavjuWsTSMzfjWWszORzPizQzmvJpMZ3xYIj28LiG8LpMeffdsCufGrn3LeTS0z/uzLFsiNbwuEx7cFxL9ugY1pZsafdSaaG78abIHc+LaA+MvbAi/+XG5Sww9L2QLtEm/+P/2oUzkfbduexc+LX51L/DdrP09fzvaZf4GVhjf7/Vv3vVFk/bfvMUhg/PoAZG+6efE9Aw+MP/oCSGZ8tz0wvtseGn9w2zPjdyaXF99n9aHx3fbA+G57aHy3PTC+N/mh8b3DD4zvtofGd9tD47vtAAAAAAAAAAAAADymiwADAOSj1JBfF8xMAAAAAElFTkSuQmCC&quot;) 0px 0px / 127px 81px no-repeat transparent; cursor: pointer; display: block; height: 81px; outline: none; position: absolute; width: 127px; z-index: 1; left: 218px; top: 118px;" class=""></div><img id="wistia_197.thumbnail_img" alt="Wistia video thumbnail" src="https://embedwistia-a.akamaihd.net/deliveries/58580e4ca3014265343285b5e93caa21.jpg?image_crop_resized=640x360" style="border: 0px; display: block; float: none; height: 316.391px; margin: 0px; max-height: none; max-width: none; padding: 0px; position: absolute; width: 562.5px; left: 0px; top: 0px;"></div></div></span>
                                </div>
                            </div>
                        </div>
                        <div class="MuiCardContent-root jss165 jss182">
                            <div class="jss166">
                                <h3 class="MuiTypography-root MuiTypography-h3">Grow smarter</h3>
                            </div>
                            <div>
                                <ul class="MuiTypography-root MuiTypography-body1">
                                    <li class="MuiTypography-root MuiTypography-body1">Boost revenue and profitability per job</li>
                                    <li class="MuiTypography-root MuiTypography-body1">Scale workforce to meet customer demand</li>
                                    <li class="MuiTypography-root MuiTypography-body1">Win more jobs with 5-star ratings</li>
                                </ul>
                            </div>
                        </div>
                        <div class="MuiCardActions-root jss169 jss184 MuiCardActions-spacing">
                            <div data-testid="ActionLink-root" class="jss89"><a data-testid="Link-GatsbyLink-internal" class="MuiTypography-root jss90 jss185 MuiTypography-body1" href="grow-smarter/index.html"><span>Learn more</span><span class="arrow-wrapper jss91"><span data-testid="ActionLink-arrow" class="jss93">❯</span><span data-testid="ActionLink-arrow" class="jss93">❯</span></span></a></div>
                            <button class="MuiButtonBase-root MuiIconButton-root jss170 jss172" tabindex="0" type="button" aria-expanded="false" aria-label="show more">
                                <span class="MuiIconButton-label">
                                    <svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="jss186 jss8 jss128">
            <div class="jss120">
                <div data-testid="Headline-root" class="jss142 jss192">
                    <div class="jss143">
                        <p class="MuiTypography-root MuiTypography-h5 MuiTypography-colorTextPrimary"><span style="display:block">INDUSTRIES</span></p>
                    </div>
                    <h2 class="MuiTypography-root jss144 jss146 MuiTypography-h2"><span style="display:block">Built for you.</span></h2>
                </div>
                <div class="jss187">
                    <ol class="jss188">
                        <li class="MuiTypography-root jss193 jss199 MuiTypography-h3" aria-current="false">
                            <a data-testid="Link-GatsbyLink-internal" class="jss32 jss194 jss200" href="industries/hvac-software/index.html">
                                HVAC<!-- -->
                                <aside class="jss195 jss201">➔</aside>
                            </a>
                        </li>
                        <li class="MuiTypography-root jss193 jss199 MuiTypography-h3" aria-current="false">
                            <a data-testid="Link-GatsbyLink-internal" class="jss32 jss194 jss200" href="industries/plumbing-software/index.html">
                                Plumbing<!-- -->
                                <aside class="jss195 jss201">➔</aside>
                            </a>
                        </li>
                        <li class="MuiTypography-root jss193 jss202 MuiTypography-h3" aria-current="false">
                            <a data-testid="Link-GatsbyLink-internal" class="jss32 jss194 jss203" href="industries/electrical-contractor-software/index.html">
                                Electrical<!-- -->
                                <aside class="jss195 jss204">➔</aside>
                            </a>
                        </li>
                        <li class="MuiTypography-root jss193 jss205 MuiTypography-h3" aria-current="false">
                            <a data-testid="Link-GatsbyLink-internal" class="jss32 jss194 jss206" href="industries/garage-door-software/index.html">
                                Garage Door<!-- -->
                                <aside class="jss195 jss207">➔</aside>
                            </a>
                        </li>
                        <li class="MuiTypography-root jss193 jss208 MuiTypography-h3" aria-current="false">
                            <a data-testid="Link-GatsbyLink-internal" class="jss32 jss194 jss209" href="industries/landscaping-and-lawn-software/index.html">
                                Landscaping &amp; Lawn<!-- -->
                                <aside class="jss195 jss210">➔</aside>
                            </a>
                        </li>
                        <li class="MuiTypography-root jss193 jss211 MuiTypography-h3" aria-current="false">
                            <a data-testid="Link-GatsbyLink-internal" class="jss32 jss194 jss212" href="industries/appliance-repair-software/index.html">
                                Appliance<!-- -->
                                <aside class="jss195 jss213">➔</aside>
                            </a>
                        </li>
                        <li class="MuiTypography-root jss193 jss214 MuiTypography-h3" aria-current="false">
                            <a data-testid="Link-GatsbyLink-internal" class="jss32 jss194 jss215" href="industries/carpet-cleaning-software/index.html">
                                Carpet Cleaning<!-- -->
                                <aside class="jss195 jss216">➔</aside>
                            </a>
                        </li>
                        <li class="jss189">
                            <div data-testid="ActionLink-root" class="jss89"><a data-testid="Link-GatsbyLink-internal" class="MuiTypography-root jss90 jss217 MuiTypography-body1" href="industries/index.html"><span>All industries</span><span class="arrow-wrapper jss91"><span data-testid="ActionLink-arrow" class="jss93">❯</span><span data-testid="ActionLink-arrow" class="jss93">❯</span></span></a></div>
                        </li>
                    </ol>
                    <div class="jss190">
                        <div role="button" aria-label="HVAC-image" tabindex="0" data-testid="LinksAndMediaSection-mediaWrapper" class="jss191" style="opacity:0;z-index:1;display:block;background-image:url(../images.ctfassets.net/6hguaqyqmoa2/OzT9a59nCuLTuYXsnLZ1v/55802feba1fdb4cf541e270f6526fa8b/hvac4c30.jpg?w=800&amp;q=50);background-size:contain;background-repeat:no-repeat;background-position:center;cursor:pointer"></div>
                        <div role="button" aria-label="Plumbing-image" tabindex="0" data-testid="LinksAndMediaSection-mediaWrapper" class="jss191" style="opacity:0;visibility:hidden;z-index:0;display:none;background-image:url(../images.ctfassets.net/6hguaqyqmoa2/48fJvN2dtUmFKFyaDZ29sa/74ea46d4284d347bf93c4dc93c19535d/plumbing4c30.jpg?w=800&amp;q=50);background-size:contain;background-repeat:no-repeat;background-position:center;cursor:pointer"></div>
                        <div role="button" aria-label="Electrical-image" tabindex="0" data-testid="LinksAndMediaSection-mediaWrapper" class="jss191" style="opacity:0;visibility:hidden;z-index:0;display:none;background-image:url(../images.ctfassets.net/6hguaqyqmoa2/rdR50MyUec8iqOcFbrfAU/1345bfa5fac188cdca697531daa413e0/electrical4c30.jpg?w=800&amp;q=50);background-size:contain;background-repeat:no-repeat;background-position:center;cursor:pointer"></div>
                        <div role="button" aria-label="Garage Door-image" tabindex="0" data-testid="LinksAndMediaSection-mediaWrapper" class="jss191" style="opacity:0;visibility:hidden;z-index:0;display:none;background-image:url(../images.ctfassets.net/6hguaqyqmoa2/7ewyuo8sAGmO7vCHlt691g/428f060f405fadebb7af63dab3cbf036/garage-door4c30.jpg?w=800&amp;q=50);background-size:contain;background-repeat:no-repeat;background-position:center;cursor:pointer"></div>
                        <div role="button" aria-label="Landscaping &amp; Lawn-image" tabindex="0" data-testid="LinksAndMediaSection-mediaWrapper" class="jss191" style="opacity:0;visibility:hidden;z-index:0;display:none;background-image:url(../images.ctfassets.net/6hguaqyqmoa2/4YYTAwlPp2u4kVa4OlJ1ZT/c0f62694331460fdd1d81fdfaef1ef7c/landscape4c30.jpg?w=800&amp;q=50);background-size:contain;background-repeat:no-repeat;background-position:center;cursor:pointer"></div>
                        <div role="button" aria-label="Appliance-image" tabindex="0" data-testid="LinksAndMediaSection-mediaWrapper" class="jss191" style="opacity:0;visibility:hidden;z-index:0;display:none;background-image:url(../images.ctfassets.net/6hguaqyqmoa2/36o9jfjKsFsL0AxJe56h7H/c3f68ed7223564c20bd859aa75c0b1d3/appliance-24c30.jpg?w=800&amp;q=50);background-size:contain;background-repeat:no-repeat;background-position:center;cursor:pointer"></div>
                        <div role="button" aria-label="Carpet Cleaning-image" tabindex="0" data-testid="LinksAndMediaSection-mediaWrapper" class="jss191" style="opacity:0;visibility:hidden;z-index:0;display:none;background-image:url(../images.ctfassets.net/6hguaqyqmoa2/2V7N3U6MXOGHNCA0rGuMQ6/14d269ef99db5ca8a3af4ac6ec996b39/cleaning4c30.jpg?w=800&amp;q=50);background-size:contain;background-repeat:no-repeat;background-position:center;cursor:pointer"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="jss218 jss128" data-testid="TextAndMediaSection-root">
            <div class="jss120">
                <div class="jss219 jss222">
                    <div class="jss220 jss223">
                        <div data-testid="PopoverVideo-root" class="jss177">
                            <div class="wistia_responsive_padding jss178">
                                <div class="wistia_responsive_wrapper jss179">
                                <span class="wistia_embed wistia_async_zn84n4rhzk popover=true videoFoam=true jss179 wistia_embed_initialized" id="wistia-zn84n4rhzk-1"><div id="wistia_57.thumb_container" class="wistia_click_to_play" style="position: relative; height: 316.406px; width: 562.5px;"><div id="wistia_197.thumbnail" tabindex="0" style="cursor: pointer; display: block; height: 316.391px; overflow: hidden; outline: none; position: relative; width: 562.5px;" class=""><div id="wistia_212.big_play_button_background" style="height: 81px; position: absolute; width: 127px; z-index: 1; background-color: rgba(84, 187, 255, 0.8); left: 218px; top: 118px;"></div><div id="wistia_212.big_play_button_graphic" tabindex="0" role="button" aria-label="Play" style="background: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH8AAABRCAYAAAD7G3lVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAATFJREFUeNrs22FtwkAYx+F2QcAkMAfgYBKQwBxMQh1MwiRQB+CgEoaDzkG5S1a+E5IF+n+e5D4ve3+7N0s4mgYAAAAAAAAAAAAA7jFN06cp5MavjuWsTSMzfjWWszORzPizQzmvJpMZ3xYIj28LiG8LpMeffdsCufGrn3LeTS0z/uzLFsiNbwuEx7cFxL9ugY1pZsafdSaaG78abIHc+LaA+MvbAi/+XG5Sww9L2QLtEm/+P/2oUzkfbduexc+LX51L/DdrP09fzvaZf4GVhjf7/Vv3vVFk/bfvMUhg/PoAZG+6efE9Aw+MP/oCSGZ8tz0wvtseGn9w2zPjdyaXF99n9aHx3fbA+G57aHy3PTC+N/mh8b3DD4zvtofGd9tD47vtAAAAAAAAAAAAADymiwADAOSj1JBfF8xMAAAAAElFTkSuQmCC&quot;) 0px 0px / 127px 81px no-repeat transparent; cursor: pointer; display: block; height: 81px; outline: none; position: absolute; width: 127px; z-index: 1; left: 218px; top: 118px;" class=""></div><img id="wistia_197.thumbnail_img" alt="Wistia video thumbnail" src="https://embedwistia-a.akamaihd.net/deliveries/58580e4ca3014265343285b5e93caa21.jpg?image_crop_resized=640x360" style="border: 0px; display: block; float: none; height: 316.391px; margin: 0px; max-height: none; max-width: none; padding: 0px; position: absolute; width: 562.5px; left: 0px; top: 0px;"></div></div></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="jss221 jss224">
                        <div data-testid="Headline-root" class="jss142 jss225">
                            <div class="jss143">
                                <p class="MuiTypography-root MuiTypography-h5 MuiTypography-colorTextPrimary"><span style="display:block">SUPPORT</span></p>
                            </div>
                            <h2 class="MuiTypography-root jss144 MuiTypography-h2"><span style="display:block">We got your back.</span></h2>
                        </div>
                        <p class="MuiTypography-root MuiTypography-body1 MuiTypography-gutterBottom">Our support team is available by phone and in-app chat. Equally important, you&#x27;ll get access to an online university and help center as well as a private Facebook group of 10,000 pros like you to share tips and grow together.</p>
                        <div data-testid="ActionLink-root" class="jss89"><a data-testid="Link-GatsbyLink-internal" class="MuiTypography-root jss90 jss226 MuiTypography-body1" href="signup/index.html"><span>Get started for free</span><span class="arrow-wrapper jss91"><span data-testid="ActionLink-arrow" class="jss93">❯</span><span data-testid="ActionLink-arrow" class="jss93">❯</span></span></a></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="jss128">
            <div class="jss120">
                <div data-testid="Headline-root" class="jss142 jss227">
                    <div class="jss143">
                        <h4 class="MuiTypography-root MuiTypography-h4" data-testid="TollFree-root">
                            TOLL FREE:<!-- --> <a class="jss228" href="tel:877-944-9010" data-testid="Link-GatsbyLink-external" target="_blank" rel="noreferrer">877-944-9010</a>
                        </h4>
                    </div>
                    <h2 class="MuiTypography-root jss144 jss146 MuiTypography-h2"><span style="display:block">Let us earn your trust.</span></h2>
                </div>
                <div class="jss9">
                    <div class="jss47" data-testid="Form-root">
                        <form data-testid="FreeTrialEmailForm-root" class="jss55">
                            <div class="MuiFormControl-root MuiTextField-root jss65 jss56 jss62">
                                <div class="MuiInputBase-root MuiOutlinedInput-root jss67 MuiInputBase-formControl">
                                    <input type="email" aria-invalid="false" id="EmailForm-Field-email" name="email" placeholder="Enter your email" value="" data-testid="EmailForm-Field-email" aria-label="Email" class="MuiInputBase-input MuiOutlinedInput-input jss66 jss230 jss57 jss62" />
                                    <fieldset aria-hidden="true" style="padding-left:8px" class="jss73 MuiOutlinedInput-notchedOutline">
                                        <legend class="jss74" style="width:0.01px"><span>&#8203;</span></legend>
                                    </fieldset>
                                </div>
                            </div>
                            <button class="MuiButtonBase-root MuiButton-root jss58 jss63 MuiButton-contained jss33 jss34 MuiButton-containedPrimary MuiButton-containedSizeSmall MuiButton-sizeSmall MuiButton-disableElevation" tabindex="0" type="submit" data-testid="EmailForm-button"><span class="MuiButton-label">Get started</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
</main>
