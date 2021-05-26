<?php

use core\config\ApplicationConfig;

ApplicationConfig::set("default.timezone", date_default_timezone_get());
ApplicationConfig::set("authentication.mode", true);
ApplicationConfig::set("authentication.super.administrator.group.id", 1);
ApplicationConfig::set("cache.settings.name", "cache.settings.name");
ApplicationConfig::set("cache.language.value.name", "cache.language.value.name");

ApplicationConfig::set("admin.memu.list", array(
    "System",
    "Product",
    "Content",
    "Store",
    "Discounts"
));
// Set permission type list.
ApplicationConfig::set("permission.type.list", array(
    "none" => "None",
    "view" => "View Only",
    "full" => "Full Access"
));

ApplicationConfig::set("permission.custom.type.list", array(
    "Piwik|Piwik" => array(
        "none" => "View",
        "full" => "Administrator"
    )
));

ApplicationConfig::set("encryption.type.list", array(
    "md5",
    "sha1"
));
ApplicationConfig::set("encryption.type.default", "md5");
ApplicationConfig::set("authentication.allow.actions", array(
    'admin/access/denied',
    'admin/login',
    'admin/logout',
    'sys/permission/update',
    'admin/shipping/shipchung/tracking'
));
// Alias actions.
ApplicationConfig::set("action.alias.list", array(
    "/" => "",
    "page-not-found" => "err/404",
    "products" => "category/list",
    "shopping-cart" => "home/cart/checkout/view",
    "gioi-thieu" => "home/about/us",
    "faq" => "home/faq",
    "quy-chuan-chat-luong" => "home/quality/control",
    "contact" => "home/contact",
    "quality-report" => "home/quality/report",
    "terms-and-conditions" => "home/terms/and/conditions",
    "why-choose-endoca" => "home/why/choose/endoca",
    "shipping-information" => "home/shipping/information",
    "payment-information" => "home/payment/information",
    "autoshipping-terms-and-conditions" => "home/autoshipping/terms/and/conditions",
    "order-confirmation" => "home/order/confirmation",
    "our-hemp" => "home/our/hemp",
    "auto-shipping-details" => "home/auto/shipping/details",
    "which-product-to-choose" => "home/which/product/to/choose",
    "cbd-price-calculator" => "home/cbd/price/calculator",
    "trustpilot-reviews" => "home/trustpilot/reviews",
    "quiz" => "home/quiz",
    "rick-simpson-oil" => "home/rick/simpson/oil",
    "seo-new-content" => "home/seo/new/content",
    "our-team" => "home/our/team",
    "error-404" => "home/error/404",
    "reseller" => "customer/salesrep",
    "page-data" => "home/page/view/data",
    "tin-tuc" => "home/blog/list"
));
// Session name config.
ApplicationConfig::set("session.user.login.name", "loginUserInfo");
ApplicationConfig::set("region.default.id", 4429);
ApplicationConfig::set("language.default.code", "en");
// Site name.
ApplicationConfig::set('site.name', 'HPD Framework');
ApplicationConfig::set('version', '0.0.1');
ApplicationConfig::set('session.prefix', 'blm');
ApplicationConfig::set('web.context', '/saas');
// Set production mode.
ApplicationConfig::set('production.mode', 'dev');
// Database APP_SETTINGS.
ApplicationConfig::set('db.host', 'localhost');
ApplicationConfig::set('db.username', 'root');
ApplicationConfig::set('db.password', '');
ApplicationConfig::set('db.schema', 'saas');
// Email settings
ApplicationConfig::set('email.host', 'smtp.gmail.com');
ApplicationConfig::set('email.port', 587);
ApplicationConfig::set('email.auth.mode', 'tls');
ApplicationConfig::set('email.from.address', "info@haiphongdeveloper.com");
ApplicationConfig::set('email.from.name', "HPD-HaiPhongDev");
ApplicationConfig::set('email.username', 'tkvclub01hp@gmail.com');
ApplicationConfig::set('email.password', 'ThanhTanVbrand@t2d');
ApplicationConfig::set('email.dev.mail', 'tkvclub01@hotmail.com');
ApplicationConfig::set("email.send.async", false);
// Settings for paging.
ApplicationConfig::set("page.size.list", "5,10,20,50,100,200");
ApplicationConfig::set("page.default.page.size", "10");
ApplicationConfig::set("page.default.nlinks", "10");
// Set symbol position list.
ApplicationConfig::set("currency.symbol.position.list", array(
    "0" => "Before the amount",
    "1" => "After the amount"
));
// Set status list of each categories.
ApplicationConfig::set("common.status.list", array(
    "active" => "Active",
    "inactive" => "Inactive"
));
// Set currency placement list.
ApplicationConfig::set("currency.placement.list", array(
    "before" => "Before amount",
    "after" => "After amount"
));

// Set discount uses per product list.
ApplicationConfig::set("discount.coupon.userperproduct.list", array(
    "any_product" => "Any Product",
    "any_following" => "Any Of Following",
    "only_for_following" => "Only For Following"
));
ApplicationConfig::set("discount.coupon.userperproduct.description.list", array(
    "any_product" => "Discount will be subtracted from cart total",
    "any_following" => "If any of the following products are in cart, Discount will be subtracted from cart total",
    "only_for_following" => "Discount will be subtracted only from following products in cart"
));
// Set fallback region list
ApplicationConfig::set("region.fallback.list", array(
    "yes" => "Yes",
    "no" => "No"
));
// Set tax shipping zone excluse list
ApplicationConfig::set("tax.shipping.zone.excluse.list", array(
    "no" => "Include",
    "yes" => "Exclude"
));

// Set contact status list.
ApplicationConfig::set("contact.status.list", array(
    "pending" => "Pending",
    "viewed" => "Viewed"
));
// Set category featured list
ApplicationConfig::set("category.featured.list", array(
    "yes" => "Yes",
    "no" => "No"
));
// Set product featured list
ApplicationConfig::set("product.featured.list", array(
    "yes" => "Yes",
    "no" => "No"
));
// "email template send to list
ApplicationConfig::set("email.template.send.to.list", array(
    "admin" => "Admin",
    "customer" => "Customer"
));
// is usa list
ApplicationConfig::set("is.usa.list", array(
    "1" => "USA",
    "2" => "Outside USA"
));
// layout constant
ApplicationConfig::set("layout.name", "etoviet");
ApplicationConfig::set("layout.width.max", 12);
ApplicationConfig::set("layout.width.list", array(
    1 => 1,
    2 => 2,
    3 => 3,
    4 => 4,
    5 => 5,
    6 => 6,
    7 => 7,
    8 => 8,
    9 => 9,
    10 => 10,
    11 => 11,
    12 => 12
));
ApplicationConfig::set("layout.grid.align.list", array(
    "full_width" => "Full width",
    "left" => "Left",
    "right" => "Right"
));
ApplicationConfig::set("layout.yn.list", array(
    1 => "Yes",
    0 => "No"
));
ApplicationConfig::set("layout.widget.link.target.list", array(
    "_blank" => "_blank",
    "_self" => "_self"
));

ApplicationConfig::set("layout.grid.background.size.list", array(
    "auto" => "auto",
    "cover" => "cover",
    "contain" => "contain",
    "none" => "none"
));
ApplicationConfig::set("layout.grid.background.repeat.list", array(
    "no-repeat" => "no-repeat",
    "repeat" => "repeat",
    "repeat-x" => "repeat-x",
    "repeat-y" => "repeat-y"
));
ApplicationConfig::set("layout.container.position.list", array(
    "header" => "header",
    "main" => "main",
    "footer" => "footer"
));
// layout constant end
ApplicationConfig::set("batch.name", "Batch");
ApplicationConfig::set("batch.path", ROOT . DS . "uploads" . DS . "batchs" . DS);
ApplicationConfig::set("batch.relative", "uploads/batchs/");
ApplicationConfig::set("batch.size.limit", 1000000); // 10MB
ApplicationConfig::set("batch.type.limit", array(
    "application/pdf"
)); // 10MB
ApplicationConfig::set("tax.zone.match", array(
    "shipping" => "Shipping Address",
    'billing' => "Billing Address"
));

ApplicationConfig::set("product.image.config", array(
    "file.dir" => DS . 'uploads' . DS,
    "file.thumb.dir" => DS . 'uploads' . DS . "thumbnail" . DS,
    "url.image" => 'uploads/',
    "url.thumb" => 'uploads/thumbnail/',
    "thumb.width" => 200,
    "thumb.height" => 200,
    "thumb.prefix" => "thumb.",
    "filename.random" => true
));
ApplicationConfig::set("export.tmp.path", ROOT . DS . "tmp" . DS . "exports" . DS);
ApplicationConfig::set("debug.tmp.path", ROOT . DS . "tmp" . DS . "debug" . DS);
// after move to db
ApplicationConfig::set("file.manager.url.friendly", false);
ApplicationConfig::set("file.manager.config", array(
    "default" => array(
        "dir" => "uploads" . DS . "default" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),

            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),
    "blog" => array(
        "dir" => "uploads" . DS . "blog" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),
            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),

    "slide" => array(
        "dir" => "uploads" . DS . "blog" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),
            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),

    "manufacture" => array(
        "dir" => "uploads" . DS . "manufacture" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),
            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),

    "product" => array(
        "dir" => "uploads" . DS . "product" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),

            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),
    "category" => array(
        "dir" => "uploads" . DS . "category" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),

            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),

    "category_blog" => array(
        "dir" => "uploads" . DS . "category_blog" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),

            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),

    "setting" => array(
        "dir" => "uploads" . DS . "setting" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),

            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),
    "attribute" => array(
        "dir" => "uploads" . DS . "attribute" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),

            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),
    "layout" => array(
        "dir" => "uploads" . DS . "layout" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),

            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),
    "tinymce" => array(
        "dir" => "uploads" . DS . "tinymce" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),

            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    ),
    "area" => array(
        "dir" => "uploads" . DS . "area" . DS,
        "filename.random" => false,
        "image" => array(
            "small" => array(
                "dir" => "small" . DS,
                "width" => 150,
                "height" => 150
            ),

            "medium" => array(
                "dir" => "medium" . DS,
                "width" => 300,
                "height" => 300
            ),
            "large" => array(
                "dir" => "large" . DS,
                "width" => 600,
                "height" => 600
            )
        )
    )
));
// Tax Rate Dynamic
ApplicationConfig::set("tax.rate.dynamic.list", array(
    "us-wa" => "Washington Tax"
));

// Maxmind user
ApplicationConfig::set("maxmind.user", "12120732");
ApplicationConfig::set("maxmind.password", "12Z14Tmd7nx550");
ApplicationConfig::set("ups.address.validation.api.enable", true);

ApplicationConfig::set("tax.rate.shipping.tax", 1);
ApplicationConfig::set("tax.rate.taxable.goods", 2);

ApplicationConfig::set("product.type.list", array(
    "normal" => "Normal",
    "seo" => "Seo"
));

ApplicationConfig::set("exclude.products.id", array(563584, 563636, 563700, 563837, 563940));
ApplicationConfig::set("pending.order.startdate", "2017-05-01");
ApplicationConfig::set("pending.order.banktransfer.time", 672);
ApplicationConfig::set("pending.order.creditcard.time", 1);
ApplicationConfig::set("cookie.expire", (3600 * 1));
ApplicationConfig::set("cookie.path", "/");
ApplicationConfig::set("guest.checkout.enable", true);

ApplicationConfig::set("attribute.type.list", array(
    "image" => "Image",
    "content" => "Content",
    "code" => "Code"
));