<?php

// Action map config.
return array(
	"err/404" => array(
		'controller' => 'frontend\controllers\ErrorController',
		'method' => 'error404',
		'desc' => 'Error 404',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/404.php'
			)
		)
	),
	"" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'index',
		'desc' => 'Index Page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/index.php'
			)
		)
	),
	"language/change" => array(
		'controller' => 'frontend\controllers\language\LanguageController',
		'method' => 'change',
		'desc' => 'Change language'
	),
	"region/change" => array(
		'controller' => 'frontend\controllers\region\RegionController',
		'method' => 'change',
		'desc' => 'Change region'
	),
	"category/list" => array(
		'controller' => 'frontend\controllers\category\CategoryController',
		'method' => 'categoryList',
		'desc' => 'category list',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/product/product_list.php'
			)
		)
	),

	"category/list/search" => array(
		'controller' => 'frontend\controllers\category\CategoryController',
		'method' => 'searchProduct',
		'desc' => 'category list',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/product/product_list_data.php'
			)
		)
	),

	"category/orderby" => array(
		'controller' => 'frontend\controllers\category\CategoryController',
		'method' => 'categoryOrderBy',
		'desc' => 'category list orderby',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/product/product_list_data.php'
			)
		)
	),
	"category/detail" => array(
		'controller' => 'frontend\controllers\category\CategoryController',
		'method' => 'categoryList',
		'desc' => 'category detail',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/product/product_list.php'
			)
		)
	),
	"product/detail" => array(
		'controller' => 'frontend\controllers\product\ProductController',
		'method' => 'detail',
		'desc' => 'product detail',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/product/product_detail.php'
			),
			'categorylist' => array(
				'type' => 'redirect',
				'path' => 'category/list'
			)
		)
	),
	"product/detail/dialog" => array(
		'controller' => 'frontend\controllers\product\ProductController',
		'method' => 'detail',
		'desc' => 'product detail data',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/product/product_detail_data.php'
			),
		)
	),
	// Start Customer Frontend
	"home/login/view" => array(
		'controller' => 'frontend\controllers\home\LoginController',
		'method' => 'loginView',
		'desc' => 'Login View',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_login_view_data.php'
			)
		)
	),
	"home/login" => array(
		'controller' => 'frontend\controllers\home\LoginController',
		'method' => 'login',
		'desc' => 'Login',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_login_form_data.php'
			)
		)

	),
	"home/guest/login" => array(
		'controller' => 'frontend\controllers\home\LoginController',
		'method' => 'guestLogin',
		'desc' => 'Guest Login',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_login_form_data.php'
			)
		)

	),
	"home/logout/view" => array(
		'controller' => 'frontend\controllers\home\LoginController',
		'method' => 'logoutView',
		'desc' => 'Home Logout View',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_logout_view_data.php'
			)
		)
	),

	"home/logout" => array(
		'controller' => 'frontend\controllers\home\LoginController',
		'method' => 'logout',
		'desc' => 'Customer Logout',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_logout_view_data.php'
			)
		)
	),
	"home/customer/password/reminder" => array(
		'controller' => 'frontend\controllers\home\LoginController',
		'method' => 'rePassword',
		'desc' => 'Customer Password Reminder',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_password_reminder.php'
			)
		)
	),

	"home/customer/password/reminder/confirm" => array(
		'controller' => 'frontend\controllers\home\LoginController',
		'method' => 'confirmChangePw',
		'desc' => 'Confirm Change Password',
		'results' => array(
			'error' => array(
				'type' => 'include',
				'path' => 'blm/home/home_password_reminder.php'
			),
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_password_confirm.php'
			)
		)
	),

	"home/customer/password/reminder/confirm/update" => array(
		'controller' => 'frontend\controllers\home\LoginController',
		'method' => 'changePassword',
		'desc' => 'Change Password',
		'results' => array(
			'error' => array(
				'type' => 'include',
				'path' => 'blm/home/home_password_confirm.php'
			),
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_password_confirm.php'
			)
		)
	),

	"customer/detail" => array(
		'controller' => 'frontend\controllers\customer\CustomerController',
		'method' => 'detail',
		'desc' => 'Customer detail',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_detail.php'
			),
			'login' => array(
				'type' => 'redirect',
				'path' => ''
			)
		)
	),
	"customer/edit" => array(
		'controller' => 'frontend\controllers\customer\CustomerController',
		'method' => 'edit',
		'desc' => 'Customer Edit',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_detail_data.php'
			)
		)
	),
	"customer/order/list" => array(
		'controller' => 'frontend\controllers\customer\CustomerController',
		'method' => 'listOrders',
		'desc' => 'Customer Order List',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_order_list.php'
			),
			'login' => array(
				'type' => 'redirect',
				'path' => ''
			)
		)
	),
	"customer/order/list/data" => array(
		'controller' => 'frontend\controllers\customer\CustomerController',
		'method' => 'listOrders',
		'desc' => 'Customer Order List',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_order_data.php'
			),
			'login' => array(
				'type' => 'redirect',
				'path' => ''
			)
		)
	),
	"customer/order/detail" => array(
		'controller' => 'frontend\controllers\customer\CustomerController',
		'method' => 'detailOrder',
		'desc' => 'Customer Detail Order',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_order_detail_data.php'
			),
			'login' => array(
				'type' => 'redirect',
				'path' => ''
			)
		)
	),
	"customer/order/pdf" => array(
		'controller' => 'frontend\controllers\customer\CustomerController',
		'method' => 'pdfOrder',
		'desc' => 'Customer View Order PDF',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => ''
			),
			'login' => array(
				'type' => 'redirect',
				'path' => ''
			)
		)
	),
	"customer/order/send/message" => array(
		'controller' => 'frontend\controllers\customer\CustomerController',
		'method' => 'sendMessageOrder',
		'desc' => 'Send message order',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_order_history_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_order_send_message_data.php'
			)
		)
	),
	"customer/order/history" => array(
		'controller' => 'frontend\controllers\customer\CustomerController',
		'method' => 'listOrderHistory',
		'desc' => 'Order History',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_order_history_data.php'
			),
			'login' => array(
				'type' => 'redirect',
				'path' => ''
			)
		)
	),
	"customer/account/info" => array(
		'controller' => 'frontend\controllers\customer\CustomerController',
		'method' => 'detail',
		'desc' => 'Customer accountInfo',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_detail_data.php'
			),
			'login' => array(
				'type' => 'redirect',
				'path' => ''
			),
			'login' => array(
				'type' => 'redirect',
				'path' => ''
			)
		)
	),
	// End Customer Frontend
	// Begin Sales Rep
	"customer/salesrep" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'salesRep',
		'desc' => 'Sales Rep',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_salesrep.php'
			),
			'login' => array(
				'type' => 'redirect',
				'path' => ''
			)
		)
	),
	"customer/salesrep/order" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'listOrders',
		'desc' => 'Sales Rep',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_order_data.php'
			)
		)
	),
	"customer/salesrep/quick/order" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'quickOrderView',
		'desc' => 'Quick order view',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/quick_order/customer_quick_order_data.php'
			)
		)
	),

	"customer/salesrep/order/detail" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'detailOrderSalesRep',
		'desc' => 'Detail Order',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_order_detail_data.php'
			)
		)
	),

	"customer/salesrep/order/history" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'listOrderHistory',
		'desc' => 'Order History',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_order_history_data.php'
			)
		)
	),
	"customer/salesrep/order/pdf" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'pdfOrder',
		'desc' => 'Detail Order',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => ''
			)
		)
	),
	"customer/salesrep/order/send/message/view" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'sendMessageOrderView',
		'desc' => 'Detail Order',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_order_send_message_data.php'
			)
		)
	),
	"customer/order/send/message/view" => array(
		'controller' => 'frontend\controllers\customer\CustomerController',
		'method' => 'sendMessageOrderView',
		'desc' => 'Detail Order',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_order_send_message_data.php'
			)
		)
	),

	"customer/salesrep/order/send/message" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'sendMessageOrder',
		'desc' => 'Detail Order',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_order_history_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_order_send_message_data.php'
			)
		)
	),
	"customer/salesrep/quick/order/product/search" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'searchProduct',
		'desc' => 'Detail Order',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/quick_order/customer_order_product_search_data.php'
			)
		)
	),
	"customer/salesrep/cart/content/tr" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'cartContentTr',
		'desc' => 'Detail Order',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/quick_order/customer_order_cart_content_tr_data.php'
			)
		)
	),
	"customer/salesrep/cart/content/tr/new" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'cartContentTrNew',
		'desc' => 'Detail Order',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/quick_order/customer_order_cart_content_tr_new_data.php'
			)
		)
	),
	"customer/salesrep/quick/order/checkout" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'quickCheckOut',
		'desc' => 'Quick chech out'
	),
	"customer/salesrep/list" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'listSalesReps',
		'desc' => 'List Sales Rep belong to customer',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_salesrep_data.php'
			)
		)
	),
	"customer/salesrep/edit/view" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'editView',
		'desc' => 'Sale rep edit form',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_salesrep_edit_form_data.php'
			)
		)
	),
	"customer/salesrep/add/view" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'addView',
		'desc' => 'Sale rep add form',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_salesrep_add_form_data.php'
			)
		)
	),
	"customer/salesrep/edit" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'edit',
		'desc' => 'Do edit sale rep',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_salesrep_edit_form_data.php'
			)
		)
	),
	"customer/salesrep/add" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'add',
		'desc' => 'Do add sale rep',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_salesrep_add_form_data.php'
			)
		)
	),
	"customer/salesrep/child/login" => array(
		'controller' => 'frontend\controllers\customer\CustomerSalesRepController',
		'method' => 'childLogin',
		'desc' => 'Login for sale rep child',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/sales_rep/customer_salesrep_login_data.php'
			)
		)
	),

	// End Sales Rep
	// Start Address Frontend
	"home/address/state/list" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'changeCountry',
		'desc' => 'State',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/address/state_list_data.php'
			)
		)
	),
	"home/register/state/list" => array(
		'controller' => 'frontend\controllers\home\RegisterController',
		'method' => 'changeCountry',
		'desc' => 'State',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/state_list_data.php'
			)
		)
	),
	"home/customer/register" => array(
		'controller' => 'frontend\controllers\home\RegisterController',
		'method' => 'register',
		'desc' => 'Home customer register',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_register_form_data.php'
			)
		)
	),
	"home/address/list" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'listView',
		'desc' => 'listView Address',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_address_detail.php'
			),
			'login' => array(
				'type' => 'redirect',
				'path' => ''
			)
		)
	),
	"home/address/search" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'search',
		'desc' => 'search Address',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/customer/customer_address_detail_data.php'
			),
		)
	),
	"home/address/edit/view" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'editView',
		'desc' => 'View Edit Address',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/address/address_edit_view_data.php'
			)
		)
	),
	"home/address/edit" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'edit',
		'desc' => 'Edit Address',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/address/address_edit_form_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'blm/address/address_edit_form_data.php'
			)
		)
	),

	"home/address/add/view" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'addView',
		'desc' => 'View Add Address',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/address/address_add_view_data.php'
			)
		)
	),

	"home/address/add" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'add',
		'desc' => 'Add Address',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/address/address_add_form_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'blm/address/address_add_form_data.php'
			)
		)
	),

	"home/address/del/view" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'delView',
		'desc' => 'View Del Address',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/address/address_del_view_data.php'
			)
		)
	),

	"home/address/del" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'del',
		'desc' => 'Delete Address',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/address/address_del_form_data.php'
			)
		)
	),
	// End Address Frontend

	// page (taipv)
	"home/page/view" => array(
		'controller' => 'frontend\controllers\home\PageController',
		'method' => 'index',
		'desc' => 'Show page content',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/page/view.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'blm/page/error.php'
			)
		)
	),
	"home/page/view/prepare/content" => array(
		'controller' => 'frontend\controllers\home\PageController',
		'method' => 'prepareContent',
		'desc' => 'Show page content',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/page/view_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'blm/page/error_data.php'
			)
		)
	),
	"home/page/view/data" => array(
		'controller' => 'frontend\controllers\home\PageController',
		'method' => 'index',
		'desc' => 'Show page content'
	)
	// 'results' => array(
	// 'success' => array(
	// 'type' => 'include',
	// 'path' => 'blm/page/view_data.php'
	// ),
	// 'error' => array(
	// 'type' => 'include',
	// 'path' => 'blm/page/error_data.php'
	// )
	// )
,
	// end page

	// Start Cart
	"home/cart/item/cart/update" => array(
		'controller' => 'frontend\controllers\cart\CartController',
		'method' => 'updateShoppingCart',
		'desc' => 'Add To Cart',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/add_to_cart_view_data.php'
			)
		)
	),
	"home/cart/checkout/update/language" => array(
		'controller' => 'frontend\controllers\cart\CartController',
		'method' => 'updateLanguage',
		'desc' => 'Update Language'
	),
	"home/cart/checkout/view" => array(
		'controller' => 'frontend\controllers\cart\CartController',
		'method' => 'checkoutView',
		'desc' => 'View Checkout Cart',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/cart_checkout_view.php'
			)
		)
	),
	"home/cart/checkout/update" => array(
		'controller' => 'frontend\controllers\cart\CartController',
		'method' => 'updateShoppingCart',
		'desc' => 'Update Shopping Cart',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/cart_checkout_view_data.php'
			)
		)
	),
	"home/cart/checkout/shipping/view" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'shippingView',
		'desc' => 'View Shipping Checkout',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/cart_checkout_shipping_view.php'
			),
			'redirect' => array(
				'type' => 'redirect',
				'path' => 'home/cart/checkout/view'
			)
		)
	),
	"home/cart/checkout/shipping/valid" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'shippingValid',
		'desc' => 'View Shipping Valid',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/cart_checkout_shipping_view_data.php'
			),
			'redirect' => array(
				'type' => 'redirect',
				'path' => 'home/cart/checkout/view'
			)
		)
	),

	"home/cart/checkout/shipping/cost" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'updateShippingCost',
		'desc' => 'Update Shipping Cost',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/cart_checkout_shipping_view_data.php'
			)
		)
	),

	"home/cart/checkout/payment/method/update" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'updatePaymentMethod',
		'desc' => 'Update Payment Method'
	),

	"home/cart/checkout/payment/valid" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'paymentValid',
		'desc' => 'View payment Valid',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_payment/cart_checkout_payment_view_data.php'
			),
			'redirect' => array(
				'type' => 'redirect',
				'path' => 'home/cart/checkout/view'
			),
			'back' => array(
				'type' => 'redirect',
				'path' => 'home/cart/checkout/shipping/view'
			)
		)

	),
	"home/cart/checkout/payment/cardgate/return" => array(
		'controller' => 'frontend\controllers\payment\PaymentController',
		'method' => 'processCardgateReturn',
		'desc' => 'Process Cardgate Return',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/cart_checkout_success_view.php'
			),
			'redirect' => array(
				'type' => 'redirect',
				'path' => 'home/cart/checkout/view'
			)
		)
	),
	"home/cart/checkout/payment/cardgate/callback" => array(
		'controller' => 'frontend\controllers\payment\PaymentController',
		'method' => 'processCardgateCallback',
		'desc' => 'Process Cardgate Callback',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_payment/methods/cardgate/cardgate_callback_data.php'
			)
		)
	),
	"home/cart/shipping/shiprush/test" => array(
		'controller' => 'frontend\controllers\shipping\ShippingController',
		'method' => 'shiprushTest',
		'desc' => 'Shiprush test',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/methods/shiprush/cart_checkout_shiprush_test_data.php'
			)
		)
	),
	"home/cart/shipping/shiprush/callback" => array(
		'controller' => 'frontend\controllers\shipping\ShippingController',
		'method' => 'shiprushCallback',
		'desc' => 'Shiprush callback',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/methods/shiprush/cart_checkout_shiprush_callback_data.php'
			)
		)
	),
	"home/cart/shipping/address/edit/view" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'editView',
		'desc' => 'View Edit Address',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/cart_checkout_shipping_address_edit_view_data.php'
			)
		)
	),
	"home/cart/shipping/address/edit" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'edit',
		'desc' => 'Edit Address',
		'group' => '',
		'results' => array(
			'error' => array(
				'type' => 'include',
				'path' => 'blm/address/address_edit_form_data.php'
			),
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/cart_checkout_hidden_address_data.php'
			)
		)
	),

	"home/cart/shipping/address/add/view" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'addView',
		'desc' => 'View Add Address',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/cart_checkout_shipping_address_add_view_data.php'
			)
		)
	),

	"home/cart/shipping/address/add" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'add',
		'desc' => 'Add Address',
		'group' => '',
		'results' => array(
			'error' => array(
				'type' => 'include',
				'path' => 'blm/address/address_add_form_data.php'
			),
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/cart_checkout_hidden_address_data.php'
			)
		)
	),
	"home/cart/shipping/address/list" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'shippingAddressView',
		'desc' => 'Shipping Address View',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/cart_checkout_shipping_list_address_data.php'
			)
		)
	),
	"home/cart/total/price/list" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'loadTotalPrice',
		'desc' => 'Load Total Price',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_shipping/cart_checkout_total_price_data.php'
			)
		)
	),
	"home/cart/checkout/discount/coupon/add" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'discountCouponAdd',
		'desc' => 'Apply Discount CounPont',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/cart_checkout_view_data.php'
			)
		)
	),

	"home/cart/checkout/payment/view" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'paymentView',
		'desc' => 'View Payment Checkout',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_payment/cart_checkout_payment_view.php'
			),
			'redirect' => array(
				'type' => 'redirect',
				'path' => 'home/cart/checkout/view'
			),
			'back' => array(
				'type' => 'redirect',
				'path' => 'home/cart/checkout/shipping/view'
			)

		)
	),
	"home/cart/payment/address/edit/view" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'editView',
		'desc' => 'View Edit Address',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_payment/cart_checkout_payment_address_edit_view_data.php'
			)
		)
	),
	"home/cart/payment/address/edit" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'edit',
		'desc' => 'Edit Address',
		'group' => '',
		'results' => array(
			'error' => array(
				'type' => 'include',
				'path' => 'blm/address/address_edit_form_data.php'
			),
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_payment/cart_checkout_hidden_address_data.php'
			)
		)
	),

	"home/cart/payment/address/add/view" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'addView',
		'desc' => 'View Add Address',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_payment/cart_checkout_payment_address_add_view_data.php'
			)
		)
	),

	"home/cart/payment/address/add" => array(
		'controller' => 'frontend\controllers\address\AddressController',
		'method' => 'add',
		'desc' => 'Add Address',
		'group' => '',
		'results' => array(
			'error' => array(
				'type' => 'include',
				'path' => 'blm/address/address_add_form_data.php'
			),
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_payment/cart_checkout_hidden_address_data.php'
			)
		)
	),
	"home/cart/payment/address/list" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'paymentAddressView',
		'desc' => 'Payment Address View',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/checkout_payment/cart_checkout_payment_list_address_data.php'
			)
		)
	),
	"home/cart/checkout/success" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'checkoutSuccess',
		'desc' => 'Checkout success',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/cart_checkout_success_view.php'
			),
			'redirect' => array(
				'type' => 'redirect',
				'path' => 'category/list'
			)
		)
	),
	"home/cart/checkout/test" => array(
		'controller' => 'frontend\controllers\cart\CheckoutController',
		'method' => 'checkoutTest',
		'desc' => 'Checkout test',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/cart_checkout_success_view.php'
			),
			'redirect' => array(
				'type' => 'redirect',
				'path' => 'home/cart/checkout/view'
			)
		)
	),
	"home/cart/reload" => array(
		'controller' => 'frontend\controllers\cart\CartController',
		'method' => 'reload',
		'desc' => 'Reload Cart success',
		'group' => '',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/cart/add_to_cart_view_data.php'
			)
		)
	),
	// End Cart
	// Start newsletter subscriber
	"home/subscriber/add" => array(
		'controller' => 'frontend\controllers\subscriber\SubscriberController',
		'method' => 'add',
		'desc' => 'Add Subscriber',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/subscriber/frontend_subscriber_data.php'
			)
		)
	),
	"home/subscriber/unsubscribe" => array(
		'controller' => 'frontend\controllers\subscriber\SubscriberController',
		'method' => 'unsubscribe',
		'desc' => 'Unsubscribe',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/subscriber/frontend_unsubscribe_view.php'
			)
		)
	),
	// End newsletter subscriber
	// Start contact
	"home/contact" => array(
		'controller' => 'frontend\controllers\contact\ContactController',
		'method' => 'show',
		'desc' => 'Show contact',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/contact/contact_view.php'
			)
		)
	),
	"home/contact/add" => array(
		'controller' => 'frontend\controllers\contact\ContactController',
		'method' => 'add',
		'desc' => 'Add contact',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/contact/contact_form_data.php'
			)
		)
	),
	// End contact
	// Start Quality Control
	"home/quality/control" => array(
		'controller' => 'frontend\controllers\quality\QualityController',
		'method' => 'show',
		'desc' => 'Show Quality Control Page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/quality/quality_control.php'
			)
		)
	),
	"home/quality/report" => array(
		'controller' => 'frontend\controllers\quality\QualityController',
		'method' => 'report',
		'desc' => 'Report Quality Control Page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/quality/quality_report.php'
			)
		)
	),
	// End Quality Control
	// Start FAQ
	"home/faq" => array(
		'controller' => 'frontend\controllers\faq\FaqController',
		'method' => 'show',
		'desc' => 'Show FAQ',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/faq/faq_view.php'
			)
		)
	),
	// End FAQ
	// Start About Us
	"home/about/us" => array(
		'controller' => 'frontend\controllers\about_us\AboutUsController',
		'method' => 'show',
		'desc' => 'Show About Us',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/about_us/about_us_view.php'
			)
		)
	),
	"home/etoviet/lifestyle" => array(
		'controller' => 'frontend\controllers\about_us\AboutUsController',
		'method' => 'showEndocaLifestyle',
		'desc' => 'Show Endoca Lifestyle',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/about_us/endoca_lifestyle_view.php'
			)
		)
	),
	"home/live/in/balance" => array(
		'controller' => 'frontend\controllers\about_us\AboutUsController',
		'method' => 'showLiveInBalance',
		'desc' => 'Show Live In Balance',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/about_us/live_in_balance_view.php'
			)
		)
	),
	// End About Us
	// Start Misc Page
	"home/terms/and/conditions" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'termsAndConditions',
		'desc' => 'Show Terms and Conditions',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/terms_and_conditions.php'
			)
		)
	),
	"home/autoshipping/terms/and/conditions" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'autoshippingTermsAndConditions',
		'desc' => 'Show Terms and Conditions of autoshipping',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/autoshipping_terms_and_conditions.php'
			)
		)
	),
	"home/anvisa" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'anvisa',
		'desc' => 'Show Anvisa',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/anvisa.php'
			) // ko co

		)
	),
	"home/shipping/information" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'shippingInformation',
		'desc' => 'Show Shipping information',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/shipping_information.php'
			)
		)
	),
	"home/payment/information" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'paymentInformation',
		'desc' => 'Show Payment information',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/payment_information.php'
			)
		)
	),
	"home/can/cannabis/cause/allergic/reactions" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'canCannabisCauseAllergicReactions',
		'desc' => 'Show Can cannabis cause allergic reactions',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/can_cannabis_cause_allergic_reactions.php'
			)
		)
	),
	"home/order/confirmation" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'orderConfirmation',
		'desc' => 'Show Order Confirmation',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/order_confirmation.php'
			)
		)
	),
	"home/our/hemp" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'ourHemp',
		'desc' => 'Show Our Hemp',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/our_hemp.php'
			)
		)
	),
	"home/auto/shipping/details" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'autoShippingDetails',
		'desc' => 'Show Auto shipping details',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/auto_shipping_details.php'
			)
		)
	),
	"home/will/i/test/positive/for/cannabis/if/i/use/cbd/hemp/oil" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'willITestPositiveForCannabisIfIUseCbdHempOil',
		'desc' => 'Show Will I test positive for Cannabis if I use CBD Hemp oil',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/will_i_test_positive_for_cannabis_if_i_use_cbd_hemp_oil.php'
			)
		)
	),
	"home/why/choose/endoca" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'whyChooseEndoca',
		'desc' => 'Show Why choose Endoca',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/why_choose_endoca.php'
			)
		)
	),
	"home/which/product/to/choose" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'whichProductToChoose',
		'desc' => 'Show Which product to choose',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/which_product_to_choose.php'
			)
		)
	),
	"home/cbd/price/calculator" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'cbdPriceCalculator',
		'desc' => 'Show CBD price calculator',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/cbd_price_calculator.php'
			)
		)
	),
	"home/trustpilot/reviews" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'trustpilotReviews',
		'desc' => 'Show Trustpilot Reviews',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/trustpilot_reviews.php'
			)
		)
	),
	"home/" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'show',
		'desc' => 'Show view',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/view.php'
			) // bo

		)
	),
	"home/quiz" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'quiz',
		'desc' => 'Show Quiz',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/quiz.php'
			)
		)
	),
	"home/rick/simpson/oil" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'rickSimpsonOil',
		'desc' => 'Show Rick Simpson Oil',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/rick_simpson_oil.php'
			)
		)
	),
	"home/shopping/cart" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'shoppingCart',
		'desc' => 'Show Shopping Cart',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/shopping_cart.php'
			) // bo

		)
	),
	"home/how/to/use/cbd/oil" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'howToUseCbdOil',
		'desc' => 'Show How to use CBD OIL',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/how_to_use_cbd_oil.php'
			) // bo

		)
	),
	"home/seo/new/content" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'seoNewContent',
		'desc' => 'Show Seo content page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/seo_new_content.php'
			)
		)
	),
	"home/beginners/guide/to/cbd" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'beginnersGuideToCbd',
		'desc' => 'Show Beginners Guide To CBD',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/beginners_guide_to_cbd.php'
			)
		)
	),
	"home/our/team" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'ourTeam',
		'desc' => 'Show Our team',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/our_team.php'
			)
		)
	),
	"home/error/404" => array(
		'controller' => 'frontend\controllers\misc_page\MiscPageController',
		'method' => 'error404',
		'desc' => 'Show Error 404',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/misc_page/error_404.php'
			)
		)
	),
	// home widget start
	"home/slides/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeSlidesWidget',
		'desc' => 'Show slides widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_slides_data.php'
			)
		)
	),
	"home/findouts/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeFindoutsWidget',
		'desc' => 'Show findouts widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_findouts_data.php'
			)
		)
	),
	"home/icons/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeIconsWidget',
		'desc' => 'Show icons widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_icons_data.php'
			)
		)
	),
	"home/categories/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeCategoriesWidget',
		'desc' => 'Show categories widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_categories_data.php'
			)
		)
	),
	"home/videos/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeVideosWidget',
		'desc' => 'Show videos widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_videos_data.php'
			)
		)
	),
	"home/quality/controls/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeQualityControlsWidget',
		'desc' => 'Show quality controls widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_quality_controls_data.php'
			)
		)
	),
	"home/archivements/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeArchivementsWidget',
		'desc' => 'Show archivements widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_archivements_data.php'
			)
		)
	),
	"home/history/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeHistoryWidget',
		'desc' => 'Show history widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_history_data.php'
			)
		)
	),
	"home/founder/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeFounderWidget',
		'desc' => 'Show founder widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_founder_data.php'
			)
		)
	),
	"home/faq/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeFaqWidget',
		'desc' => 'Show faq widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_faq_data.php'
			)
		)
	),
	"home/testimoninals/widget" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'homeTestimoninalsWidget',
		'desc' => 'Show testimoninals widget in home page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_boxes_data/home_testimoninals_data.php'
			)
		)
	),
	// home widget end
	// End Misc Page
	"sitemap" => array(
		'controller' => 'frontend\controllers\site_map\SiteMapController',
		'method' => 'index',
		'desc' => 'Generate site map file',
		'group' => array(
			'SiteMap|SiteMap:view'
		),
		'results' => array(
			'success' => array(
				'type' => 'stream',
				'input' => 'fileName',
				'output' => 'filePath',
				'params' => array(
					'Content-Type' => 'application/xml; charset=utf-8',
					'Content-Disposition' => 'attachment; filename=#{outputFileName}'
				)
			)
		)
	),
	"home/seo/enhancement" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'seoEnhancement',
		'desc' => 'Seo Enhancement ',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/home/home_seo_enhancement_data.php'
			)
		)
	),
	"home/product/attribute/select" => array(
		'controller' => 'frontend\controllers\product\ProductController',
		'method' => 'selectAttribute',
		'desc' => 'Select Attribute',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/product/attribute/product_attribute_data.php'
			),
		)
	),
	// BLOG
	"home/blog/list" => array(
		'controller' => 'frontend\controllers\blog\BlogController',
		'method' => 'listView',
		'desc' => 'blog index',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/blog/blog_list.php'
			),

		)
	),

	"home/blog/list/search" => array(
		'controller' => 'frontend\controllers\blog\BlogController',
		'method' => 'search',
		'desc' => 'blog index',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/blog/blog_list_data.php'
			),

		)
	),
	"home/blog/detail" => array(
		'controller' => 'frontend\controllers\blog\BlogController',
		'method' => 'detail',
		'desc' => 'Show edit blog form',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/blog/blog_detail.php'
			)
		)
	),

	"price" => array(
		'controller' => 'frontend\controllers\home\HomeController',
		'method' => 'price',
		'desc' => 'Show price page',
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'blm/price.php'
			)
		)
	)
);