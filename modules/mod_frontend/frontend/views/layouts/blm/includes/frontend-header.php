<?php

use common\helper\SettingHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use common\rule\url\friendly\CategoryBlogUrlFriendly;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\RouteUtil;

$titlePage = SettingHelper::getSettingValue("Name");
$languages = RequestUtil::get('languages');
$language = RequestUtil::get("language");
$languageCode = RequestUtil::get('languageCode');
$categoryBlogMenu = RequestUtil::get("categoryBlogMenu");
$path = RouteUtil::getRoute()->getPath();
date_default_timezone_set("Asia/Ho_Chi_Minh");
$date = date("d-m-Y H:i:s");
?>

<!-- Loader -->
<div id="site-loader" class="load-complete">
    <div class="loader">
        <div class="line-scale">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div><!-- Loader /- -->

<!-- Header Section -->
<header class="MuiPaper-root MuiAppBar-root MuiAppBar-positionFixed MuiAppBar-colorPrimary jss10 jss14 mui-fixed MuiPaper-elevation0">
   <nav aria-label="Main" class="jss11">
      <div class="MuiToolbar-root MuiToolbar-regular jss15 jss12 MuiToolbar-gutters" aria-label="Desktop navigation menu">
         <div class="jss16">
            <a aria-current="page" data-testid="Link-GatsbyLink-internal" class="jss32 active" href="/">
               <svg version="1.1" x="0px" y="0px" viewBox="0 0 270.3 40.3" class="jss17 jss30">
                  <g>
                     <polygon points="39.2,19.2 52,19.2 52,6 56.5,6 56.5,35.9 52,35.9 52,23.4 39.2,23.4 39.2,35.9 34.6,35.9 34.6,6 39.2,6 	"></polygon>
                     <path d="M64.9,26.5c0,1.9,0.5,3.4,1.5,4.5s2.4,1.7,4.1,1.7s3.1-0.5,4.1-1.6s1.5-2.6,1.5-4.4c0-1.8-0.5-3.3-1.5-4.4 c-1-1.1-2.4-1.7-4.1-1.7s-3,0.6-4,1.7C65.4,23.3,64.9,24.7,64.9,26.5L64.9,26.5z M60.4,26.4c0-2.7,1-5,2.9-6.9 c1.9-1.9,4.3-2.9,7.1-2.9c2.8,0,5.2,1,7.2,2.9c1.9,1.9,2.9,4.3,2.9,7.1s-1,5.2-2.9,7.1c-2,1.9-4.4,2.8-7.2,2.8 c-2.8,0-5.2-1-7.1-2.9C61.4,31.7,60.4,29.3,60.4,26.4L60.4,26.4z"></path>
                     <path d="M88.7,17.1v10.8c0,3.1,1.2,4.7,3.7,4.7s3.7-1.6,3.7-4.7V17.1h4.4V28c0,1.5-0.2,2.8-0.6,3.9 c-0.4,1-1,1.9-1.9,2.7c-1.5,1.3-3.3,1.9-5.6,1.9c-2.3,0-4.1-0.6-5.6-1.9c-0.9-0.8-1.5-1.7-1.9-2.7c-0.4-0.9-0.5-2.2-0.5-3.9V17.1 H88.7L88.7,17.1z"></path>
                     <path d="M116.6,20.3l-3.6,1.9c-0.6-1.2-1.3-1.7-2.1-1.7c-0.4,0-0.7,0.1-1,0.4c-0.3,0.3-0.4,0.6-0.4,1 c0,0.7,0.8,1.4,2.5,2.1c2.3,1,3.9,1.9,4.7,2.7s1.2,2,1.2,3.4c0,1.8-0.7,3.3-2,4.6c-1.3,1.2-2.9,1.7-4.7,1.7c-3.2,0-5.4-1.5-6.7-4.6 l3.7-1.7c0.5,0.9,0.9,1.5,1.2,1.7c0.5,0.5,1.2,0.7,1.9,0.7c1.5,0,2.2-0.7,2.2-2c0-0.8-0.6-1.5-1.7-2.2c-0.4-0.2-0.9-0.4-1.3-0.6 c-0.4-0.2-0.9-0.4-1.3-0.6c-1.3-0.6-2.2-1.2-2.7-1.9c-0.7-0.8-1-1.8-1-3c0-1.6,0.6-3,1.7-4.1s2.5-1.6,4.2-1.6 C113.6,16.6,115.4,17.8,116.6,20.3L116.6,20.3z"></path>
                     <path d="M135.3,24c-0.6-2.3-2.1-3.5-4.4-3.5c-0.5,0-1,0.1-1.5,0.2c-0.5,0.2-0.9,0.4-1.3,0.7c-0.4,0.3-0.7,0.7-1,1.1 c-0.3,0.4-0.5,0.9-0.6,1.5H135.3L135.3,24z M139.7,27.6h-13.5c0.1,1.5,0.6,2.8,1.5,3.7c0.9,0.9,2,1.4,3.4,1.4c1.1,0,2-0.3,2.7-0.8 s1.5-1.5,2.4-2.9l3.7,2.1c-0.6,1-1.2,1.8-1.8,2.5s-1.3,1.3-2,1.7s-1.5,0.8-2.3,1s-1.7,0.3-2.7,0.3c-2.8,0-5.1-0.9-6.8-2.7 s-2.6-4.2-2.6-7.2s0.8-5.4,2.5-7.2s3.9-2.7,6.6-2.7c2.8,0,5,0.9,6.6,2.7s2.4,4.2,2.4,7.3L139.7,27.6L139.7,27.6z"></path>
                     <path d="M166.9,26.5c0,1.8,0.5,3.3,1.5,4.4c1,1.1,2.2,1.7,3.8,1.7s2.9-0.6,3.9-1.7c1-1.1,1.5-2.6,1.5-4.4 s-0.5-3.2-1.5-4.4c-1-1.1-2.3-1.7-3.9-1.7c-1.5,0-2.7,0.6-3.8,1.7C167.4,23.4,166.9,24.8,166.9,26.5L166.9,26.5z M177.3,17.1h4.4 v18.8h-4.4v-2c-1.8,1.7-3.7,2.5-5.8,2.5c-2.6,0-4.8-0.9-6.5-2.8c-1.7-1.9-2.5-4.3-2.5-7.2c0-2.8,0.8-5.2,2.5-7.1 c1.7-1.9,3.8-2.8,6.3-2.8c2.2,0,4.2,0.9,5.9,2.7v-2.1H177.3z"></path>
                     <polygon points="190.9,6 190.9,36 186.6,36 186.6,6 	"></polygon>
                     <polygon points="200.3,6 200.3,36 195.9,36 195.9,6 	"></polygon>
                     <path d="M218.1,19.6h1.7c4.1,0,6.2-1.6,6.2-4.8c0-3.1-2.1-4.6-6.4-4.6h-1.5V19.6L218.1,19.6z M218.1,23.8v12.1h-4.5 V6h5.1c2.5,0,4.4,0.2,5.7,0.5s2.4,1,3.4,2c1.7,1.7,2.6,3.8,2.6,6.3c0,2.7-0.9,4.9-2.7,6.5s-4.3,2.4-7.4,2.4L218.1,23.8L218.1,23.8z "></path>
                     <path d="M234.1,17.1h4.4v1.7c0.8-0.8,1.5-1.4,2.1-1.7s1.4-0.5,2.2-0.5c1.1,0,2.3,0.4,3.6,1.1l-2,4 c-0.8-0.6-1.6-0.9-2.4-0.9c-2.4,0-3.6,1.8-3.6,5.4V36H234L234.1,17.1L234.1,17.1z"></path>
                     <path d="M252.2,26.5c0,1.9,0.5,3.4,1.5,4.5s2.4,1.7,4.1,1.7s3.1-0.5,4.1-1.6s1.5-2.6,1.5-4.4c0-1.8-0.5-3.3-1.5-4.4 c-1-1.1-2.4-1.7-4.1-1.7s-3,0.6-4,1.7C252.7,23.3,252.2,24.7,252.2,26.5L252.2,26.5z M247.7,26.4c0-2.7,1-5,2.9-6.9 s4.3-2.9,7.1-2.9c2.8,0,5.2,1,7.2,2.9c1.9,1.9,2.9,4.3,2.9,7.1s-1,5.2-2.9,7.1c-2,1.9-4.4,2.8-7.2,2.8c-2.8,0-5.2-1-7.1-2.9 C248.7,31.7,247.7,29.3,247.7,26.4L247.7,26.4z"></path>
                     <path d="M154,20.5c0.2,0,0.4,0,0.6,0C154.3,20.5,154.2,20.5,154,20.5L154,20.5z"></path>
                     <path d="M153.7,20.5h0.1l0,0h0.1c0.2,0,0.4,0,0.6,0c1.6,0.1,3.2,0.5,4.6,1.3v-3.9c-1.7-0.9-3.4-1.3-5.3-1.3 c-2.9,0-5.3,1-7.3,2.9s-3,4.3-3,7.1s1,5.2,2.9,7.1c2,1.9,4.4,2.8,7.3,2.8c1.8,0,3.5-0.5,5.3-1.4v-3.9c-1.5,0.8-3.1,1.2-4.6,1.3 c-0.3,0-0.6,0.1-0.9,0.1c-1.6,0-3-0.6-4-1.7c-1-1.1-1.6-2.6-1.6-4.4c0-1.7,0.5-3.2,1.6-4.3C150.8,21.1,152.1,20.5,153.7,20.5 L153.7,20.5z"></path>
                     <path d="M153.9,20.5L153.9,20.5L153.9,20.5L153.9,20.5L153.9,20.5z"></path>
                     <polygon points="1,8.9 1,33.1 12.8,39.4 12.8,36 12.8,32.3 12.8,9.9 12.8,6.2 12.8,2 	"></polygon>
                     <polygon points="21.1,35.9 16.2,35.9 16.2,33.1 18.3,33.1 18.4,8.8 16.2,8.8 16.2,6 21.2,6 	"></polygon>
                  </g>
               </svg>
            </a>
         </div>
         <ul class="jss18">
         <li class="<?= $path == "/" ? 'active' : '' ?> dropdown">
                            <a class="nav-link" title="<?= Lang::get("Home") ?>"
                               href="<?= ActionUtil::getFullPathAlias("/") ?>"><?= Lang::get("Home") ?></a>
                        </li>
                        <li class="<?= $path == "home/about/us" ? 'active' : '' ?>"><a class="nav-link"
                                                                                       title="<?= Lang::get("Giới thiệu") ?>"
                                                                                       href="<?= ActionUtil::getFullPathAlias("home/about/us", new AliasUrlFriendly("gioi-thieu")) ?>"><?= Lang::get("Giới thiệu") ?></a>
                        </li>
                        <li class="<?= $path == "home/blog/list" || $path == "category/blog/detail" ? 'active' : '' ?> dropdown">
                            <a href="<?= ActionUtil::getFullPathAlias("home/blog/list", new AliasUrlFriendly("tin-tuc")) ?>"
                               class="nav-link dropdown-toggle" title="<?= Lang::get("Tin tức") ?>" role="button"
                               aria-haspopup="true" aria-expanded="false"><?= Lang::get("Tin tức") ?></a>
                            <i class="ddl-switch fa fa-angle-down"></i>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($categoryBlogMenu as $category) {
                                    ?>
                                    <li>
                                        <a class="dropdown-item"
                                           href="<?= ActionUtil::getFullPathAlias("category/blog/detail?categoryId=" . $category->id, new CategoryBlogUrlFriendly($category->languageCode, $category->id, $category->seoUrl, $category->name)) ?>"><?= $category->name ?></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="<?= $path == "home/contact" ? 'active' : '' ?>"><a class="nav-link"
                                                                                      title="<?= Lang::get("Liên hệ") ?>"
                                                                                      href="<?= ActionUtil::getFullPathAlias("home/contact", new AliasUrlFriendly("contact")) ?>"><?= Lang::get("Liên hệ") ?></a>
            
                            <i class="ddl-switch fa fa-angle-down"></i>
                            <ul class="dropdown-menu">
                            <div class="jss27">
                                <div data-testid="NavbarSectionMenu-root" class="jss77 jss28" style="opacity: 0; transition: opacity 600ms cubic-bezier(0.4, 0, 0.2, 1) 0ms; visibility: hidden;">
                                    <a data-testid="Link-GatsbyLink-internal" class="menu-list jss78" href="/work-simpler/">
                                        <ul class="menu-list jss79">
                                            <li class="MuiTypography-root header jss80 MuiTypography-h4">Work Simpler</li>
                                            <li class="MuiTypography-root jss82 MuiTypography-body1">Save time &amp; cut costs. Work more efficiently and exceed customer expectations.</li>
                                            <li class="jss86">
                                            <div data-testid="ActionLink-root" class="jss89">
                                                <p class="MuiTypography-root jss90 jss297 MuiTypography-body1" location="header"><span>Learn more</span><span class="arrow-wrapper jss91"><span data-testid="ActionLink-arrow" class="jss93">❯</span><span data-testid="ActionLink-arrow" class="jss93">❯</span></span></p>
                                            </div>
                                            </li>
                                            <li class="jss83 jss85"><img class="jss84" src="//images.ctfassets.net/6hguaqyqmoa2/59FHKyak0aavXZ5D7TZcqi/a6f70caf02c562115a25edede1dd66e3/work-simpler-1.jpg" alt="Work Simpler"></li>
                                        </ul>
                                    </a>
                                    <a data-testid="Link-GatsbyLink-internal" class="menu-list jss78" href="/grow-smarter/">
                                        <ul class="menu-list jss79">
                                            <li class="MuiTypography-root header jss80 MuiTypography-h4">Grow Smarter</li>
                                            <li class="MuiTypography-root jss82 MuiTypography-body1">Win more jobs. Boost revenue and profitability per job.</li>
                                            <li class="jss86">
                                            <div data-testid="ActionLink-root" class="jss89">
                                                <p class="MuiTypography-root jss90 jss298 MuiTypography-body1" location="header"><span>Learn more</span><span class="arrow-wrapper jss91"><span data-testid="ActionLink-arrow" class="jss93">❯</span><span data-testid="ActionLink-arrow" class="jss93">❯</span></span></p>
                                            </div>
                                            </li>
                                            <li class="jss83 jss85"><img class="jss84" src="//images.ctfassets.net/6hguaqyqmoa2/2pF4dNqMdAMQ7IXRwCeHwt/0e2316da1a8568d03421414b9ed64239/grow-smarter-1.jpg" alt="Grow Smarter"></li>
                                        </ul>
                                    </a>
                                </div>
                                <div data-testid="NavbarSectionMenu-root" class="jss77 jss28" style="opacity: 0; transition: opacity 600ms cubic-bezier(0.4, 0, 0.2, 1) 0ms; visibility: hidden;">
                                    <ul class="menu-list jss79">
                                        <li class="MuiTypography-root header jss80 MuiTypography-h4">Grow Revenue</li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/website-builder/">Website Builder</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/online-booking/">Online Booking</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/automated-marketing/">Follow-Up Marketing</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/recurring-service-plans/">Recurring Service Plans</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/local-services/">Local Service Ads</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/strategic-account-manager/">Strategic Account Manager</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/callrail/">Phone Integration</a></li>
                                    </ul>
                                    <ul class="menu-list jss79">
                                        <li class="MuiTypography-root header jss80 MuiTypography-h4">Save Time</li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/scheduling-software/">Scheduling</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/dispatching-software/">Dispatching</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/job-management-software/">Job Management</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/estimating-software/">Estimates</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/invoicing-software/">Invoicing</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/dispatching-software#dispatching">Live Map GPS</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/advanced-reporting/">Advanced Reporting</a></li>
                                    </ul>
                                    <ul class="menu-list jss79">
                                        <li class="MuiTypography-root header jss80 MuiTypography-h4">Manage Your Money</li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/payment/">Payment</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/instapay/">Instapay</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/card-reader/">Card Reader</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/expense-management/">Company Cards</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/consumer-financing/">Consumer Financing</a></li>
                                    </ul>
                                    <ul class="menu-list jss79">
                                        <li class="MuiTypography-root header jss80 MuiTypography-h4">Customer Experience</li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/dispatching-software#text-notification">On My Way Texts</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/sales-proposal-tool/">Sales Proposal Tool</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/reviews/">Reviews</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/checklists/">Checklists</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/property-profiles/">Property Profiles</a></li>
                                        <li class="MuiTypography-root jss81 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/">All Features</a></li>
                                    </ul>
                                </div>
                                <div data-testid="NavbarSectionMenu-root" class="jss77 jss28" style="opacity: 0; visibility: hidden;">
                                    <ul class="menu-list jss79">
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/hvac-software/">HVAC</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/plumbing-software/">Plumbing</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/electrical-contractor-software/">Electrical</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/garage-door-software/">Garage Door</a></li>
                                    </ul>
                                    <ul class="menu-list jss79">
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/landscaping-and-lawn-software/">Landscaping &amp; Lawn</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/appliance-repair-software/">Appliance</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/carpet-cleaning-software/">Carpet Cleaning</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/">All Industries</a></li>
                                    </ul>
                                </div>
                                <div data-testid="NavbarSectionMenu-root" class="jss77 jss28" style="opacity: 1; transition: opacity 600ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;">
                                    <ul class="menu-list jss79">
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/mastermind-online/">Mastermind Online</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/protalks/">Pro Talks</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/community/">Community</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/ladypros/">Lady Pros</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/learn/coronavirus-resources/">Coronavirus Resources</a></li>
                                    </ul>
                                    <ul class="menu-list jss79">
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/learn/">Blog</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/working-in-the-trades/">Working In The Trades</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/resources/ebooks/">Ebooks</a></li>
                                        <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/resources/">All Resources</a></li>
                                    </ul>
                                </div>
                                </div>
                            </ul>
                        </li>
         </ul>
         <div class="jss24">
            <div class="desktop-action"><a class="MuiButtonBase-root MuiButton-root MuiButton-text jss33 jss44 jss46 jss45" tabindex="0" aria-disabled="false" data-testid="Button-root" href="https://pro.housecallpro.com/pro/log_in"><span class="MuiButton-label">Login</span><span class="MuiTouchRipple-root"></span></a></div>
            <div class="desktop-action">
               <div class="jss25 jss47" data-testid="Form-root">
                  <form data-testid="FreeTrialEmailForm-root" class="jss55 jss25">
                     <div class="MuiFormControl-root MuiTextField-root jss65 jss56 jss62">
                        <div class="MuiInputBase-root MuiOutlinedInput-root jss67 MuiInputBase-formControl">
                           <input type="email" aria-invalid="false" id="EmailForm-Field-email" name="email" placeholder="Enter your email" value="" data-testid="EmailForm-Field-email" aria-label="Email" class="MuiInputBase-input MuiOutlinedInput-input jss66 jss72 jss57 jss62">
                           <fieldset aria-hidden="true" style="padding-left:8px" class="jss73 MuiOutlinedInput-notchedOutline">
                              <legend class="jss74" style="width:0.01px"><span>&#8203;</span></legend>
                           </fieldset>
                        </div>
                     </div>
                     <button class="MuiButtonBase-root MuiButton-root jss58 jss63 MuiButton-contained jss33 jss34 jss45 MuiButton-containedPrimary MuiButton-disableElevation" tabindex="0" type="submit" data-testid="EmailForm-button"><span class="MuiButton-label">Start Free Trial</span><span class="MuiTouchRipple-root"></span></button>
                  </form>
               </div>
            </div>
         </div>
         <div class="MuiCollapse-container jss26 MuiCollapse-hidden" style="min-height: 0px; height: 0px; transition-duration: 300ms;">
            <div class="MuiCollapse-wrapper">
               <div class="MuiCollapse-wrapperInner">
                  <div class="jss27">
                     <div data-testid="NavbarSectionMenu-root" class="jss77 jss28" style="opacity:0;visibility:hidden">
                        <a data-testid="Link-GatsbyLink-internal" class="menu-list jss78" href="/work-simpler/">
                           <ul class="menu-list jss79">
                              <li class="MuiTypography-root header jss80 MuiTypography-h4">Work Simpler</li>
                              <li class="MuiTypography-root jss82 MuiTypography-body1">Save time &amp; cut costs. Work more efficiently and exceed customer expectations.</li>
                              <li class="jss86">
                                 <div data-testid="ActionLink-root" class="jss89">
                                    <p class="MuiTypography-root jss90 jss92 MuiTypography-body1" location="header"><span>Learn more</span><span class="arrow-wrapper jss91"><span data-testid="ActionLink-arrow" class="jss93">❯</span><span data-testid="ActionLink-arrow" class="jss93">❯</span></span></p>
                                 </div>
                              </li>
                              <li class="jss83 jss85"><img class="jss84" src="//images.ctfassets.net/6hguaqyqmoa2/59FHKyak0aavXZ5D7TZcqi/a6f70caf02c562115a25edede1dd66e3/work-simpler-1.jpg" alt="Work Simpler"></li>
                           </ul>
                        </a>
                        <a data-testid="Link-GatsbyLink-internal" class="menu-list jss78" href="/grow-smarter/">
                           <ul class="menu-list jss79">
                              <li class="MuiTypography-root header jss80 MuiTypography-h4">Grow Smarter</li>
                              <li class="MuiTypography-root jss82 MuiTypography-body1">Win more jobs. Boost revenue and profitability per job.</li>
                              <li class="jss86">
                                 <div data-testid="ActionLink-root" class="jss89">
                                    <p class="MuiTypography-root jss90 jss94 MuiTypography-body1" location="header"><span>Learn more</span><span class="arrow-wrapper jss91"><span data-testid="ActionLink-arrow" class="jss93">❯</span><span data-testid="ActionLink-arrow" class="jss93">❯</span></span></p>
                                 </div>
                              </li>
                              <li class="jss83 jss85"><img class="jss84" src="//images.ctfassets.net/6hguaqyqmoa2/2pF4dNqMdAMQ7IXRwCeHwt/0e2316da1a8568d03421414b9ed64239/grow-smarter-1.jpg" alt="Grow Smarter"></li>
                           </ul>
                        </a>
                     </div>
                     <div data-testid="NavbarSectionMenu-root" class="jss77 jss28" style="opacity:0;visibility:hidden">
                        <ul class="menu-list jss79">
                           <li class="MuiTypography-root header jss80 MuiTypography-h4">Grow Revenue</li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/website-builder/">Website Builder</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/online-booking/">Online Booking</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/automated-marketing/">Follow-Up Marketing</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/recurring-service-plans/">Recurring Service Plans</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/local-services/">Local Service Ads</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/strategic-account-manager/">Strategic Account Manager</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/callrail/">Phone Integration</a></li>
                        </ul>
                        <ul class="menu-list jss79">
                           <li class="MuiTypography-root header jss80 MuiTypography-h4">Save Time</li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/scheduling-software/">Scheduling</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/dispatching-software/">Dispatching</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/job-management-software/">Job Management</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/estimating-software/">Estimates</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/invoicing-software/">Invoicing</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/dispatching-software#dispatching">Live Map GPS</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/advanced-reporting/">Advanced Reporting</a></li>
                        </ul>
                        <ul class="menu-list jss79">
                           <li class="MuiTypography-root header jss80 MuiTypography-h4">Manage Your Money</li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/payment/">Payment</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/instapay/">Instapay</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/card-reader/">Card Reader</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/expense-management/">Company Cards</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/consumer-financing/">Consumer Financing</a></li>
                        </ul>
                        <ul class="menu-list jss79">
                           <li class="MuiTypography-root header jss80 MuiTypography-h4">Customer Experience</li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/dispatching-software#text-notification">On My Way Texts</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/sales-proposal-tool/">Sales Proposal Tool</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/reviews/">Reviews</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/checklists/">Checklists</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/property-profiles/">Property Profiles</a></li>
                           <li class="MuiTypography-root jss81 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/">All Features</a></li>
                        </ul>
                     </div>
                     <div data-testid="NavbarSectionMenu-root" class="jss77 jss28" style="opacity: 0; transition: opacity 600ms cubic-bezier(0.4, 0, 0.2, 1) 0ms; visibility: hidden;">
                        <ul class="menu-list jss79">
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/hvac-software/">HVAC</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/plumbing-software/">Plumbing</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/electrical-contractor-software/">Electrical</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/garage-door-software/">Garage Door</a></li>
                        </ul>
                        <ul class="menu-list jss79">
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/landscaping-and-lawn-software/">Landscaping &amp; Lawn</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/appliance-repair-software/">Appliance</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/carpet-cleaning-software/">Carpet Cleaning</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/">All Industries</a></li>
                        </ul>
                     </div>
                     <div data-testid="NavbarSectionMenu-root" class="jss77 jss28" style="opacity: 0; transition: opacity 600ms cubic-bezier(0.4, 0, 0.2, 1) 0ms; visibility: hidden;">
                        <ul class="menu-list jss79">
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/mastermind-online/">Mastermind Online</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/protalks/">Pro Talks</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/community/">Community</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/ladypros/">Lady Pros</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/learn/coronavirus-resources/">Coronavirus Resources</a></li>
                        </ul>
                        <ul class="menu-list jss79">
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/learn/">Blog</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/working-in-the-trades/">Working In The Trades</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/resources/ebooks/">Ebooks</a></li>
                           <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/resources/">All Resources</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="MuiToolbar-root MuiToolbar-regular jss95 jss13 MuiToolbar-gutters" aria-label="Mobile navigation menu">
         <a aria-current="page" data-testid="Link-GatsbyLink-internal" class="jss96 active" href="/">
            <svg version="1.1" x="0px" y="0px" viewBox="0 0 270.3 40.3" class="jss97 jss116">
               <g>
                  <polygon points="39.2,19.2 52,19.2 52,6 56.5,6 56.5,35.9 52,35.9 52,23.4 39.2,23.4 39.2,35.9 34.6,35.9 34.6,6 39.2,6 	"></polygon>
                  <path d="M64.9,26.5c0,1.9,0.5,3.4,1.5,4.5s2.4,1.7,4.1,1.7s3.1-0.5,4.1-1.6s1.5-2.6,1.5-4.4c0-1.8-0.5-3.3-1.5-4.4 c-1-1.1-2.4-1.7-4.1-1.7s-3,0.6-4,1.7C65.4,23.3,64.9,24.7,64.9,26.5L64.9,26.5z M60.4,26.4c0-2.7,1-5,2.9-6.9 c1.9-1.9,4.3-2.9,7.1-2.9c2.8,0,5.2,1,7.2,2.9c1.9,1.9,2.9,4.3,2.9,7.1s-1,5.2-2.9,7.1c-2,1.9-4.4,2.8-7.2,2.8 c-2.8,0-5.2-1-7.1-2.9C61.4,31.7,60.4,29.3,60.4,26.4L60.4,26.4z"></path>
                  <path d="M88.7,17.1v10.8c0,3.1,1.2,4.7,3.7,4.7s3.7-1.6,3.7-4.7V17.1h4.4V28c0,1.5-0.2,2.8-0.6,3.9 c-0.4,1-1,1.9-1.9,2.7c-1.5,1.3-3.3,1.9-5.6,1.9c-2.3,0-4.1-0.6-5.6-1.9c-0.9-0.8-1.5-1.7-1.9-2.7c-0.4-0.9-0.5-2.2-0.5-3.9V17.1 H88.7L88.7,17.1z"></path>
                  <path d="M116.6,20.3l-3.6,1.9c-0.6-1.2-1.3-1.7-2.1-1.7c-0.4,0-0.7,0.1-1,0.4c-0.3,0.3-0.4,0.6-0.4,1 c0,0.7,0.8,1.4,2.5,2.1c2.3,1,3.9,1.9,4.7,2.7s1.2,2,1.2,3.4c0,1.8-0.7,3.3-2,4.6c-1.3,1.2-2.9,1.7-4.7,1.7c-3.2,0-5.4-1.5-6.7-4.6 l3.7-1.7c0.5,0.9,0.9,1.5,1.2,1.7c0.5,0.5,1.2,0.7,1.9,0.7c1.5,0,2.2-0.7,2.2-2c0-0.8-0.6-1.5-1.7-2.2c-0.4-0.2-0.9-0.4-1.3-0.6 c-0.4-0.2-0.9-0.4-1.3-0.6c-1.3-0.6-2.2-1.2-2.7-1.9c-0.7-0.8-1-1.8-1-3c0-1.6,0.6-3,1.7-4.1s2.5-1.6,4.2-1.6 C113.6,16.6,115.4,17.8,116.6,20.3L116.6,20.3z"></path>
                  <path d="M135.3,24c-0.6-2.3-2.1-3.5-4.4-3.5c-0.5,0-1,0.1-1.5,0.2c-0.5,0.2-0.9,0.4-1.3,0.7c-0.4,0.3-0.7,0.7-1,1.1 c-0.3,0.4-0.5,0.9-0.6,1.5H135.3L135.3,24z M139.7,27.6h-13.5c0.1,1.5,0.6,2.8,1.5,3.7c0.9,0.9,2,1.4,3.4,1.4c1.1,0,2-0.3,2.7-0.8 s1.5-1.5,2.4-2.9l3.7,2.1c-0.6,1-1.2,1.8-1.8,2.5s-1.3,1.3-2,1.7s-1.5,0.8-2.3,1s-1.7,0.3-2.7,0.3c-2.8,0-5.1-0.9-6.8-2.7 s-2.6-4.2-2.6-7.2s0.8-5.4,2.5-7.2s3.9-2.7,6.6-2.7c2.8,0,5,0.9,6.6,2.7s2.4,4.2,2.4,7.3L139.7,27.6L139.7,27.6z"></path>
                  <path d="M166.9,26.5c0,1.8,0.5,3.3,1.5,4.4c1,1.1,2.2,1.7,3.8,1.7s2.9-0.6,3.9-1.7c1-1.1,1.5-2.6,1.5-4.4 s-0.5-3.2-1.5-4.4c-1-1.1-2.3-1.7-3.9-1.7c-1.5,0-2.7,0.6-3.8,1.7C167.4,23.4,166.9,24.8,166.9,26.5L166.9,26.5z M177.3,17.1h4.4 v18.8h-4.4v-2c-1.8,1.7-3.7,2.5-5.8,2.5c-2.6,0-4.8-0.9-6.5-2.8c-1.7-1.9-2.5-4.3-2.5-7.2c0-2.8,0.8-5.2,2.5-7.1 c1.7-1.9,3.8-2.8,6.3-2.8c2.2,0,4.2,0.9,5.9,2.7v-2.1H177.3z"></path>
                  <polygon points="190.9,6 190.9,36 186.6,36 186.6,6 	"></polygon>
                  <polygon points="200.3,6 200.3,36 195.9,36 195.9,6 	"></polygon>
                  <path d="M218.1,19.6h1.7c4.1,0,6.2-1.6,6.2-4.8c0-3.1-2.1-4.6-6.4-4.6h-1.5V19.6L218.1,19.6z M218.1,23.8v12.1h-4.5 V6h5.1c2.5,0,4.4,0.2,5.7,0.5s2.4,1,3.4,2c1.7,1.7,2.6,3.8,2.6,6.3c0,2.7-0.9,4.9-2.7,6.5s-4.3,2.4-7.4,2.4L218.1,23.8L218.1,23.8z "></path>
                  <path d="M234.1,17.1h4.4v1.7c0.8-0.8,1.5-1.4,2.1-1.7s1.4-0.5,2.2-0.5c1.1,0,2.3,0.4,3.6,1.1l-2,4 c-0.8-0.6-1.6-0.9-2.4-0.9c-2.4,0-3.6,1.8-3.6,5.4V36H234L234.1,17.1L234.1,17.1z"></path>
                  <path d="M252.2,26.5c0,1.9,0.5,3.4,1.5,4.5s2.4,1.7,4.1,1.7s3.1-0.5,4.1-1.6s1.5-2.6,1.5-4.4c0-1.8-0.5-3.3-1.5-4.4 c-1-1.1-2.4-1.7-4.1-1.7s-3,0.6-4,1.7C252.7,23.3,252.2,24.7,252.2,26.5L252.2,26.5z M247.7,26.4c0-2.7,1-5,2.9-6.9 s4.3-2.9,7.1-2.9c2.8,0,5.2,1,7.2,2.9c1.9,1.9,2.9,4.3,2.9,7.1s-1,5.2-2.9,7.1c-2,1.9-4.4,2.8-7.2,2.8c-2.8,0-5.2-1-7.1-2.9 C248.7,31.7,247.7,29.3,247.7,26.4L247.7,26.4z"></path>
                  <path d="M154,20.5c0.2,0,0.4,0,0.6,0C154.3,20.5,154.2,20.5,154,20.5L154,20.5z"></path>
                  <path d="M153.7,20.5h0.1l0,0h0.1c0.2,0,0.4,0,0.6,0c1.6,0.1,3.2,0.5,4.6,1.3v-3.9c-1.7-0.9-3.4-1.3-5.3-1.3 c-2.9,0-5.3,1-7.3,2.9s-3,4.3-3,7.1s1,5.2,2.9,7.1c2,1.9,4.4,2.8,7.3,2.8c1.8,0,3.5-0.5,5.3-1.4v-3.9c-1.5,0.8-3.1,1.2-4.6,1.3 c-0.3,0-0.6,0.1-0.9,0.1c-1.6,0-3-0.6-4-1.7c-1-1.1-1.6-2.6-1.6-4.4c0-1.7,0.5-3.2,1.6-4.3C150.8,21.1,152.1,20.5,153.7,20.5 L153.7,20.5z"></path>
                  <path d="M153.9,20.5L153.9,20.5L153.9,20.5L153.9,20.5L153.9,20.5z"></path>
                  <polygon points="1,8.9 1,33.1 12.8,39.4 12.8,36 12.8,32.3 12.8,9.9 12.8,6.2 12.8,2 	"></polygon>
                  <polygon points="21.1,35.9 16.2,35.9 16.2,33.1 18.3,33.1 18.4,8.8 16.2,8.8 16.2,6 21.2,6 	"></polygon>
               </g>
            </svg>
         </a>
         <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss33 jss98 jss44 jss46 jss45" tabindex="0" aria-disabled="false" data-testid="Button-root" href="https://pro.housecallpro.com/pro/log_in"><span class="MuiButton-label">Login</span><span class="MuiTouchRipple-root"></span></a><button class="MuiButtonBase-root MuiButton-root MuiButton-contained jss33 jss98 jss34 jss46 jss45 MuiButton-containedPrimary" tabindex="0" type="button" data-testid="Button-root"><span class="MuiButton-label">START FREE TRIAL</span><span class="MuiTouchRipple-root"></span></button>
         <a class="jss32" href="tel:877-944-9010" data-testid="Link-GatsbyLink-external" target="_blank" rel="noreferrer">
            <svg class="MuiSvgIcon-root jss101" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
               <path d="M20 15.5c-1.25 0-2.45-.2-3.57-.57-.35-.11-.74-.03-1.02.24l-2.2 2.2c-2.83-1.44-5.15-3.75-6.59-6.59l2.2-2.21c.28-.26.36-.65.25-1C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1zM19 12h2c0-4.97-4.03-9-9-9v2c3.87 0 7 3.13 7 7zm-4 0h2c0-2.76-2.24-5-5-5v2c1.66 0 3 1.34 3 3z"></path>
            </svg>
         </a>
         <div role="button" aria-label="Open menu" aria-expanded="false" class="jss102 jss117" tabindex="0">
            <svg class="MuiSvgIcon-root jss103 jss118" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
               <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
            </svg>
            <svg class="MuiSvgIcon-root jss103 jss118" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
               <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
            </svg>
         </div>
         <div class="jss104 jss106">
            <div class="jss109 jss119 jss120">
               <div class="MuiPaper-root MuiAccordion-root jss110 MuiPaper-elevation1">
                  <div class="MuiButtonBase-root MuiAccordionSummary-root" tabindex="0" role="button" aria-disabled="false" aria-expanded="false" aria-controls="panel1d-content">
                     <div class="MuiAccordionSummary-content">
                        <h3 class="MuiTypography-root jss99 MuiTypography-h3">Solutions</h3>
                     </div>
                     <div class="MuiButtonBase-root MuiIconButton-root MuiAccordionSummary-expandIcon MuiIconButton-edgeEnd" aria-disabled="false" aria-hidden="true">
                        <span class="MuiIconButton-label">
                           <svg class="MuiSvgIcon-root jss111" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                              <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                           </svg>
                        </span>
                        <span class="MuiTouchRipple-root"></span>
                     </div>
                  </div>
                  <div class="MuiCollapse-container MuiCollapse-hidden" style="min-height:0px">
                     <div class="MuiCollapse-wrapper">
                        <div class="MuiCollapse-wrapperInner">
                           <div id="panel1d-content" role="region">
                              <div class="MuiAccordionDetails-root">
                                 <div data-testid="NavbarSectionMenu-root" class="jss77">
                                    <a data-testid="Link-GatsbyLink-internal" class="menu-list jss78" href="/work-simpler/">
                                       <ul class="menu-list jss79">
                                          <li class="MuiTypography-root header jss80 MuiTypography-h4">Work Simpler</li>
                                          <li class="MuiTypography-root jss82 MuiTypography-body1">Save time &amp; cut costs. Work more efficiently and exceed customer expectations.</li>
                                          <li class="jss86">
                                             <div data-testid="ActionLink-root" class="jss89">
                                                <p class="MuiTypography-root jss90 jss121 MuiTypography-body1" location="header"><span>Learn more</span><span class="arrow-wrapper jss91"><span data-testid="ActionLink-arrow" class="jss93">❯</span><span data-testid="ActionLink-arrow" class="jss93">❯</span></span></p>
                                             </div>
                                          </li>
                                          <li class="jss83 jss85"><img class="jss84" src="//images.ctfassets.net/6hguaqyqmoa2/59FHKyak0aavXZ5D7TZcqi/a6f70caf02c562115a25edede1dd66e3/work-simpler-1.jpg" alt="Work Simpler"></li>
                                       </ul>
                                    </a>
                                    <a data-testid="Link-GatsbyLink-internal" class="menu-list jss78" href="/grow-smarter/">
                                       <ul class="menu-list jss79">
                                          <li class="MuiTypography-root header jss80 MuiTypography-h4">Grow Smarter</li>
                                          <li class="MuiTypography-root jss82 MuiTypography-body1">Win more jobs. Boost revenue and profitability per job.</li>
                                          <li class="jss86">
                                             <div data-testid="ActionLink-root" class="jss89">
                                                <p class="MuiTypography-root jss90 jss122 MuiTypography-body1" location="header"><span>Learn more</span><span class="arrow-wrapper jss91"><span data-testid="ActionLink-arrow" class="jss93">❯</span><span data-testid="ActionLink-arrow" class="jss93">❯</span></span></p>
                                             </div>
                                          </li>
                                          <li class="jss83 jss85"><img class="jss84" src="//images.ctfassets.net/6hguaqyqmoa2/2pF4dNqMdAMQ7IXRwCeHwt/0e2316da1a8568d03421414b9ed64239/grow-smarter-1.jpg" alt="Grow Smarter"></li>
                                       </ul>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="MuiPaper-root MuiAccordion-root jss110 MuiPaper-elevation1">
                  <div class="MuiButtonBase-root MuiAccordionSummary-root" tabindex="0" role="button" aria-disabled="false" aria-expanded="false" aria-controls="panel1d-content">
                     <div class="MuiAccordionSummary-content">
                        <h3 class="MuiTypography-root jss99 MuiTypography-h3">Features</h3>
                     </div>
                     <div class="MuiButtonBase-root MuiIconButton-root MuiAccordionSummary-expandIcon MuiIconButton-edgeEnd" aria-disabled="false" aria-hidden="true">
                        <span class="MuiIconButton-label">
                           <svg class="MuiSvgIcon-root jss111" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                              <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                           </svg>
                        </span>
                        <span class="MuiTouchRipple-root"></span>
                     </div>
                  </div>
                  <div class="MuiCollapse-container MuiCollapse-hidden" style="min-height:0px">
                     <div class="MuiCollapse-wrapper">
                        <div class="MuiCollapse-wrapperInner">
                           <div id="panel1d-content" role="region">
                              <div class="MuiAccordionDetails-root">
                                 <div data-testid="NavbarSectionMenu-root" class="jss77">
                                    <ul class="menu-list jss79">
                                       <li class="MuiTypography-root header jss80 MuiTypography-h4">Grow Revenue</li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/website-builder/">Website Builder</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/online-booking/">Online Booking</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/automated-marketing/">Follow-Up Marketing</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/recurring-service-plans/">Recurring Service Plans</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/local-services/">Local Service Ads</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/strategic-account-manager/">Strategic Account Manager</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/callrail/">Phone Integration</a></li>
                                    </ul>
                                    <ul class="menu-list jss79">
                                       <li class="MuiTypography-root header jss80 MuiTypography-h4">Save Time</li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/scheduling-software/">Scheduling</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/dispatching-software/">Dispatching</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/job-management-software/">Job Management</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/estimating-software/">Estimates</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/invoicing-software/">Invoicing</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/dispatching-software#dispatching">Live Map GPS</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/advanced-reporting/">Advanced Reporting</a></li>
                                    </ul>
                                    <ul class="menu-list jss79">
                                       <li class="MuiTypography-root header jss80 MuiTypography-h4">Manage Your Money</li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/payment/">Payment</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/instapay/">Instapay</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/card-reader/">Card Reader</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/expense-management/">Company Cards</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/consumer-financing/">Consumer Financing</a></li>
                                    </ul>
                                    <ul class="menu-list jss79">
                                       <li class="MuiTypography-root header jss80 MuiTypography-h4">Customer Experience</li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/dispatching-software#text-notification">On My Way Texts</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/sales-proposal-tool/">Sales Proposal Tool</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/reviews/">Reviews</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/checklists/">Checklists</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/property-profiles/">Property Profiles</a></li>
                                       <li class="MuiTypography-root jss81 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/features/">All Features</a></li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="MuiPaper-root MuiAccordion-root jss110 MuiPaper-elevation1">
                  <div class="MuiButtonBase-root MuiAccordionSummary-root" tabindex="0" role="button" aria-disabled="false" aria-expanded="false" aria-controls="panel1d-content">
                     <div class="MuiAccordionSummary-content">
                        <h3 class="MuiTypography-root jss99 MuiTypography-h3">Industries</h3>
                     </div>
                     <div class="MuiButtonBase-root MuiIconButton-root MuiAccordionSummary-expandIcon MuiIconButton-edgeEnd" aria-disabled="false" aria-hidden="true">
                        <span class="MuiIconButton-label">
                           <svg class="MuiSvgIcon-root jss111" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                              <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                           </svg>
                        </span>
                        <span class="MuiTouchRipple-root"></span>
                     </div>
                  </div>
                  <div class="MuiCollapse-container MuiCollapse-hidden" style="min-height:0px">
                     <div class="MuiCollapse-wrapper">
                        <div class="MuiCollapse-wrapperInner">
                           <div id="panel1d-content" role="region">
                              <div class="MuiAccordionDetails-root">
                                 <div data-testid="NavbarSectionMenu-root" class="jss77">
                                    <ul class="menu-list jss79">
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/hvac-software/">HVAC</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/plumbing-software/">Plumbing</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/electrical-contractor-software/">Electrical</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/garage-door-software/">Garage Door</a></li>
                                    </ul>
                                    <ul class="menu-list jss79">
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/landscaping-and-lawn-software/">Landscaping &amp; Lawn</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/appliance-repair-software/">Appliance</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/carpet-cleaning-software/">Carpet Cleaning</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/industries/">All Industries</a></li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="MuiPaper-root MuiAccordion-root jss110 MuiPaper-elevation1">
                  <div class="MuiButtonBase-root MuiAccordionSummary-root" tabindex="0" role="button" aria-disabled="false" aria-controls="panel1d-content">
                     <div class="MuiAccordionSummary-content">
                        <h3 class="MuiTypography-root jss99 MuiTypography-h3">XL</h3>
                     </div>
                  </div>
                  <div class="MuiCollapse-container MuiCollapse-hidden" style="min-height:0px">
                     <div class="MuiCollapse-wrapper">
                        <div class="MuiCollapse-wrapperInner">
                           <div id="panel1d-content" role="region"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="MuiPaper-root MuiAccordion-root jss110 MuiPaper-elevation1">
                  <div class="MuiButtonBase-root MuiAccordionSummary-root" tabindex="0" role="button" aria-disabled="false" aria-controls="panel1d-content">
                     <div class="MuiAccordionSummary-content">
                        <h3 class="MuiTypography-root jss99 MuiTypography-h3">Pricing</h3>
                     </div>
                  </div>
                  <div class="MuiCollapse-container MuiCollapse-hidden" style="min-height:0px">
                     <div class="MuiCollapse-wrapper">
                        <div class="MuiCollapse-wrapperInner">
                           <div id="panel1d-content" role="region"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="MuiPaper-root MuiAccordion-root jss110 MuiPaper-elevation1">
                  <div class="MuiButtonBase-root MuiAccordionSummary-root" tabindex="0" role="button" aria-disabled="false" aria-expanded="false" aria-controls="panel1d-content">
                     <div class="MuiAccordionSummary-content">
                        <h3 class="MuiTypography-root jss99 MuiTypography-h3">Learn</h3>
                     </div>
                     <div class="MuiButtonBase-root MuiIconButton-root MuiAccordionSummary-expandIcon MuiIconButton-edgeEnd" aria-disabled="false" aria-hidden="true">
                        <span class="MuiIconButton-label">
                           <svg class="MuiSvgIcon-root jss111" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                              <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                           </svg>
                        </span>
                        <span class="MuiTouchRipple-root"></span>
                     </div>
                  </div>
                  <div class="MuiCollapse-container MuiCollapse-hidden" style="min-height:0px">
                     <div class="MuiCollapse-wrapper">
                        <div class="MuiCollapse-wrapperInner">
                           <div id="panel1d-content" role="region">
                              <div class="MuiAccordionDetails-root">
                                 <div data-testid="NavbarSectionMenu-root" class="jss77">
                                    <ul class="menu-list jss79">
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/mastermind-online/">Mastermind Online</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/protalks/">Pro Talks</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/community/">Community</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/ladypros/">Lady Pros</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/learn/coronavirus-resources/">Coronavirus Resources</a></li>
                                    </ul>
                                    <ul class="menu-list jss79">
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/learn/">Blog</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/working-in-the-trades/">Working In The Trades</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/resources/ebooks/">Ebooks</a></li>
                                       <li class="MuiTypography-root jss87 MuiTypography-h4"><a data-testid="Link-GatsbyLink-internal" class="jss88" href="/resources/">All Resources</a></li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="jss113 jss47" data-testid="Form-root">
                  <form data-testid="FreeTrialEmailForm-root" class="jss55 jss113">
                     <div class="MuiFormControl-root MuiTextField-root jss65 jss56 jss62">
                        <div class="MuiInputBase-root MuiOutlinedInput-root jss67 MuiInputBase-formControl">
                           <input type="email" aria-invalid="false" id="EmailForm-Field-email" name="email" placeholder="Enter your email" value="" data-testid="EmailForm-Field-email" aria-label="Email" class="MuiInputBase-input MuiOutlinedInput-input jss66 jss124 jss57 jss62">
                           <fieldset aria-hidden="true" style="padding-left:8px" class="jss73 MuiOutlinedInput-notchedOutline">
                              <legend class="jss74" style="width:0.01px"><span>&#8203;</span></legend>
                           </fieldset>
                        </div>
                     </div>
                     <button class="MuiButtonBase-root MuiButton-root jss58 jss63 MuiButton-contained jss33 jss34 MuiButton-containedPrimary MuiButton-containedSizeSmall MuiButton-sizeSmall MuiButton-disableElevation" tabindex="0" type="submit" data-testid="EmailForm-button"><span class="MuiButton-label">Start Free Trial</span><span class="MuiTouchRipple-root"></span></button>
                  </form>
               </div>
               <a class="MuiButtonBase-root MuiButton-root MuiButton-text jss33 jss114 jss44 jss46 MuiButton-textSizeSmall MuiButton-sizeSmall MuiButton-fullWidth" tabindex="0" aria-disabled="false" data-testid="Button-root" href="https://pro.housecallpro.com/pro/log_in"><span class="MuiButton-label">LOGIN</span><span class="MuiTouchRipple-root"></span></a>
            </div>
         </div>
      </div>
   </nav>
</header>
<!-- Header Section /- -->