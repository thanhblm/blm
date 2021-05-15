<?php
return array(
	// BEGIN ADMIN LOGIN
	"admin/access/denied" => array(
		'controller' => 'backend\controllers\login\LoginController',
		'method' => 'accessDenied',
		'desc' => 'Login User',
		'group' => array('login:*'),
		'results' => array(
			'web' => array(
				'type' => 'include',
				'path' => 'admin/login/access_denied_web_data.php'
			),
			'json' => array(
				'type' => 'include',
				'path' => 'admin/login/access_denied_data.php'
			),

		)
	),
	"admin/login" => array(
		'controller' => 'backend\controllers\login\LoginController',
		'method' => 'login',
		'desc' => 'Login User',
		'group' => array('login:*'),
		'results' => array(
			'login' => array(
				'type' => 'include',
				'path' => 'admin/login/login.php'
			),
			'success' => array(
				'type' => 'redirect',
				'path' => 'admin/dashboard'
			)
		)
	),
	"admin/logout" => array(
		'controller' => 'backend\controllers\login\LoginController',
		'method' => 'logout',
		'desc' => 'Logout User',
		'group' => array('logout:*'),
		'results' => array(
			'success' => array(
				'type' => 'redirect',
				'path' => 'admin/login'
			)
		)
	),
	"admin/dashboard" => array(
		'controller' => 'backend\controllers\dashboard\DashboardController',
		'method' => 'dashboard',
		'desc' => 'Dashboard',
		'group' => array(
			'dashboard:authenticated'
		),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/dashboard/dashboard.php'
			)
		)
	),
	"admin" => array(
		'controller' => 'backend\controllers\dashboard\DashboardController',
		'method' => 'dashboard',
		'desc' => 'Dashboard',
		'group' => array('dashboard:authenticated'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/dashboard/dashboard.php'
			)
		)
	),
	// END ADMIN LOGIN

	// Begin shipping method
	"admin/shipping/method/list" => array(
		'controller' => 'backend\controllers\shipping\ShippingMethodController',
		'method' => 'listView',
		'desc' => 'Shipping Manage',
		'group' => array('shipping.method:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/method/shipping_method_list.php'
			)
		)
	),
	"admin/shipping/method/search" => array(
		'controller' => 'backend\controllers\shipping\ShippingMethodController',
		'method' => 'search',
		'desc' => 'Search Shipping',
		'group' => array('shipping.method:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/method/shipping_method_list_data.php'
			)
		)
	),
	"admin/shipping/method/edit/view" => array(
		'controller' => 'backend\controllers\shipping\ShippingMethodController',
		'method' => 'editView',
		'desc' => 'View Edit Shipping',
		'group' => array('shipping.method:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/method/shipping_method_edit_view_data.php'
			)
		)
	),
	"admin/shipping/method/edit" => array(
		'controller' => 'backend\controllers\shipping\ShippingMethodController',
		'method' => 'edit',
		'desc' => 'Edit Shipping',
		'group' => array('shipping.method:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/method/shipping_method_edit_form_data.php'
			)
		)
	),

	"admin/shipping/method/copy/view" => array(
		'controller' => 'backend\controllers\shipping\ShippingMethodController',
		'method' => 'copyView',
		'desc' => 'Show copy shipping method view',
		'group' => array('shipping.method:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/method/shipping_method_copy_view_data.php'
			)
		)
	),
	"admin/shipping/method/copy" => array(
		'controller' => 'backend\controllers\shipping\ShippingMethodController',
		'method' => 'copy',
		'desc' => 'Copy shipping method',
		'group' => array('shipping.method:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/method/shipping_method_copy_form_data.php'
			)
		)
	),

	"admin/shipping/method/add/view" => array(
		'controller' => 'backend\controllers\shipping\ShippingMethodController',
		'method' => 'addView',
		'desc' => 'View Add Shipping',
		'group' => array('shipping.method:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/method/shipping_method_add_view_data.php'
			)
		)
	),
	"admin/shipping/method/add" => array(
		'controller' => 'backend\controllers\shipping\ShippingMethodController',
		'method' => 'add',
		'desc' => 'Add Shipping',
		'group' => array('shipping.method:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/method/shipping_method_add_form_data.php'
			)
		)
	),
	"admin/shipping/method/del/view" => array(
		'controller' => 'backend\controllers\shipping\ShippingMethodController',
		'method' => 'delView',
		'desc' => 'View Del Shipping',
		'group' => array('shipping.method:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/method/shipping_method_del_view_data.php'
			)
		)
	),
	"admin/shipping/method/del" => array(
		'controller' => 'backend\controllers\shipping\ShippingMethodController',
		'method' => 'del',
		'desc' => 'Delete Shipping',
		'group' => array('shipping.method:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/method/shipping_method_del_form_data.php'
			)
		)
	),
	// End shipping method

	// Shipping status
	"admin/shipping/status/list" => array(
		'controller' => 'backend\controllers\shipping\ShippingStatusController',
		'method' => 'listView',
		'desc' => 'Shipping Status',
		'group' => array('System|Shipping Status:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/shipping_status/shipping_status_list.php'
			)
		)
	),
	"admin/shipping/status/search" => array(
		'controller' => 'backend\controllers\shipping\ShippingStatusController',
		'method' => 'search',
		'desc' => 'Shipping Status',
		'group' => array('System|Shipping Status:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/shipping_status/shipping_status_list_data.php'
			)
		)
	),
	"admin/shipping/status/add/view" => array(
		'controller' => 'backend\controllers\shipping\ShippingStatusController',
		'method' => 'addView',
		'desc' => 'Add Shipping Status',
		'group' => array('System|Shipping Status:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/shipping_status/shipping_status_add_view_data.php'
			)
		)
	),
	"admin/shipping/status/add" => array(
		'controller' => 'backend\controllers\shipping\ShippingStatusController',
		'method' => 'add',
		'desc' => 'Add Shipping Status',
		'group' => array('System|Shipping Status:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/shipping_status/shipping_status_add_res_data.php'
			)
		)
	),
	"admin/shipping/status/copy/view" => array(
		'controller' => 'backend\controllers\shipping\ShippingStatusController',
		'method' => 'copyView',
		'desc' => 'Clone Shipping Status',
		'group' => array('System|Shipping Status:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/shipping_status/shipping_status_copy_view_data.php'
			)
		)
	),
	"admin/shipping/status/copy" => array(
		'controller' => 'backend\controllers\shipping\ShippingStatusController',
		'method' => 'copy',
		'desc' => 'Clone Shipping Status',
		'group' => array('System|Shipping Status:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/shipping_status/shipping_status_copy_res_data.php'
			)
		)
	),
	"admin/shipping/status/edit/view" => array(
		'controller' => 'backend\controllers\shipping\ShippingStatusController',
		'method' => 'editView',
		'desc' => 'Edit Shipping Status',
		'group' => array('System|Shipping Status:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/shipping_status/shipping_status_edit_view_data.php'
			)
		)
	),
	"admin/shipping/status/edit" => array(
		'controller' => 'backend\controllers\shipping\ShippingStatusController',
		'method' => 'edit',
		'desc' => 'Edit Shipping Status',
		'group' => array('System|Shipping Status:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/shipping_status/shipping_status_edit_res_data.php'
			)
		)
	),
	"admin/shipping/status/del/view" => array(
		'controller' => 'backend\controllers\shipping\ShippingStatusController',
		'method' => 'delView',
		'desc' => 'Delete Shipping Status',
		'group' => array('System|Shipping Status:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/shipping_status/shipping_status_del_view_data.php'
			)
		)
	),
	"admin/shipping/status/del" => array(
		'controller' => 'backend\controllers\shipping\ShippingStatusController',
		'method' => 'del',
		'desc' => 'Delete Shipping Status',
		'group' => array('System|Shipping Status:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipping/shipping_status/shipping_status_del_res_data.php'
			)
		)
	),
	// End Shipping Status
	// Order status
	"admin/order/status/list" => array(
		'controller' => 'backend\controllers\order\OrderStatusController',
		'method' => 'listView',
		'desc' => 'Order Status',
		'group' => array('System|Order Statuses::view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order_status/order_status_list.php'
			)
		)
	),
	"admin/order/status/search" => array(
		'controller' => 'backend\controllers\order\OrderStatusController',
		'method' => 'search',
		'desc' => 'order Status',
		'group' => array('System|Order Statuses::view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order_status/order_status_list_data.php'
			)
		)
	),
	"admin/order/status/add/view" => array(
		'controller' => 'backend\controllers\order\OrderStatusController',
		'method' => 'addView',
		'desc' => 'Add order Status',
		'group' => array('System|Order Statuses::add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order_status/order_status_add_view_data.php'
			)
		)
	),
	"admin/order/status/add" => array(
		'controller' => 'backend\controllers\order\OrderStatusController',
		'method' => 'add',
		'desc' => 'Add order Status',
		'group' => array('System|Order Statuses::add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order_status/order_status_add_res_data.php'
			)
		)
	),
	"admin/order/status/copy/view" => array(
		'controller' => 'backend\controllers\order\OrderStatusController',
		'method' => 'copyView',
		'desc' => 'Clone order Status',
		'group' => array('System|Order Statuses::copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order_status/order_status_copy_view_data.php'
			)
		)
	),
	"admin/order/status/copy" => array(
		'controller' => 'backend\controllers\order\OrderStatusController',
		'method' => 'copy',
		'desc' => 'Clone order Status',
		'group' => array('System|Order Statuses::copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order_status/order_status_copy_res_data.php'
			)
		)
	),
	"admin/order/status/edit/view" => array(
		'controller' => 'backend\controllers\order\OrderStatusController',
		'method' => 'editView',
		'desc' => 'Edit order Status',
		'group' => array('System|Order Statuses::edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order_status/order_status_edit_view_data.php'
			)
		)
	),
	"admin/order/status/edit" => array(
		'controller' => 'backend\controllers\order\OrderStatusController',
		'method' => 'edit',
		'desc' => 'Edit order Status',
		'group' => array('System|Order Statuses::edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order_status/order_status_edit_res_data.php'
			)
		)
	),
	"admin/order/status/del/view" => array(
		'controller' => 'backend\controllers\order\OrderStatusController',
		'method' => 'delView',
		'desc' => 'Delete order Status',
		'group' => array('System|Order Statuses::del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order_status/order_status_del_view_data.php'
			)
		)
	),
	"admin/order/status/del" => array(
		'controller' => 'backend\controllers\order\OrderStatusController',
		'method' => 'del',
		'desc' => 'Delete order Status',
		'group' => array('System|Order Statuses::del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order_status/order_status_del_res_data.php'
			)
		)
	),
	// End Order Status

	//Bulk Discount
	"admin/discount/bulk/list" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'listView',
		'desc' => 'Bulk Discount',
		'group' => array('Discounts|Bulk Discounts:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/bulk_discount_list.php'
			)
		)
	),
	"admin/discount/bulk/search" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'search',
		'desc' => 'Search Bulk Discount',
		'group' => array('Discounts|Bulk Discounts:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/bulk_discount_list_data.php'
			)
		)
	),
	"admin/discount/bulk/add/product" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'addProduct',
		'desc' => 'Add Bulk Discount',
		'group' => array('Discounts|Bulk Discounts:add', 'Discounts|Bulk Discounts:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/product/bulk_discount_product_tr_data.php'
			)
		)
	),
	"admin/discount/bulk/add/view" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'addView',
		'desc' => 'Add Bulk Discount',
		'group' => array('Discounts|Bulk Discounts:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/bulk_discount_add_view_data.php'
			)
		)
	),
	"admin/discount/bulk/add" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'add',
		'desc' => 'Add Bulk Discount',
		'group' => array('Discounts|Bulk Discounts:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/bulk_discount_add_res_data.php'
			)
		)
	),
	"admin/discount/bulk/edit/view" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'editView',
		'desc' => 'Edit Bulk Discount',
		'group' => array('Discounts|Bulk Discounts:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/bulk_discount_edit_view_data.php'
			)
		)
	),
	"admin/discount/bulk/edit" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'edit',
		'desc' => 'Edit Bulk Discount',
		'group' => array('Discounts|Bulk Discounts:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/bulk_discount_edit_res_data.php'
			)
		)
	),
	"admin/discount/bulk/copy/view" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'copyView',
		'desc' => 'Show Copy Bulk Discount view',
		'group' => array('Discounts|Bulk Discounts:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/bulk_discount_copy_view_data.php'
			)
		)
	),
	"admin/discount/bulk/copy" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'copy',
		'desc' => 'Copy Bulk Discount',
		'group' => array('Discounts|Bulk Discounts:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/bulk_discount_copy_res_data.php'
			)
		)
	),
	"admin/discount/bulk/del/view" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'delView',
		'desc' => 'Edit Bulk Discount',
		'group' => array('Discounts|Bulk Discounts:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/bulk_discount_del_view_data.php'
			)
		)
	),
	"admin/discount/bulk/del" => array(
		'controller' => 'backend\controllers\bulk_discount\BulkDiscountController',
		'method' => 'del',
		'desc' => 'Edit Bulk Discount',
		'group' => array('Discounts|Bulk Discounts:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/bulk_discount/bulk_discount_del_res_data.php'
			)
		)
	),
	// End Bulk Discount
	//Product Manage
	//add multi file for product
	'admin/file/add/multi/image' => array(
		'controller' => 'backend\controllers\media\ImageController',
		'method' => 'addImageAjax',
		'desc' => 'Add image Ajax',
		'group' => array("Media|Image:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/media/media_image_data.php'
			)
		)
	),
	"admin/product/list" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'listView',
		'desc' => 'List Product',
		'group' => array('Product|Products:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_list.php'
			)
		)
	),
	"admin/product/search" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'search',
		'desc' => 'Search Product',
		'group' => array('Product|Products:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_list_data.php'
			)
		)
	),
	"admin/product/add/view" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'addView',
		'desc' => 'Add Product',
		'group' => array('Product|Products:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_add_view.php'
			)
		)
	),
	"admin/product/add" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'add',
		'desc' => 'Add Product',
		'group' => array('Product|Products:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_add_res_data.php'
			)
		)
	),
	"admin/product/addtoedit" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'addToEdit',
		'desc' => 'Add Product',
		'group' => array('Product|Products:add', 'Product|Products:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_add_res_data.php'
			)
		)
	),
	"admin/product/edit/view" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'editView',
		'desc' => 'Edit Product',
		'group' => array('Product|Products:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_edit_view.php'
			)
		)
	),
	"admin/product/edit" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'edit',
		'desc' => 'Edit Product',
		'group' => array('Product|Products:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_edit_res_data.php'
			)
		)
	),
	"admin/product/edittoclose" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'editToClose',
		'desc' => 'Edit Product',
		'group' => array('Product|Products:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_edit_res_data.php'
			)
		)
	),
	"admin/product/del/view" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'delView',
		'desc' => 'Delete View Product',
		'group' => array('Product|Products:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_del_view_data.php'
			)
		)
	),
	"admin/product/del" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'del',
		'desc' => 'Delete Product',
		'group' => array('Product|Products:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_del_res_data.php'
			)
		)
	),
	"admin/product/copy/view" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'copyView',
		'desc' => 'Copy Product',
		'group' => array('Product|Products:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_copy_view.php'
			)
		)
	),
	"admin/product/copy" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'copy',
		'desc' => 'Copy Product',
		'group' => array('Product|Products:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_copy_res_data.php'
			)
		)
	),
	"admin/product/copytoclose" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'copyToClose',
		'desc' => 'Copy Product',
		'group' => array('Product|Products:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/product_copy_res_data.php'
			)
		)
	),
	"admin/product/price/list" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'productPriceList',
		'desc' => 'List Product price and quick edit',
		'group' => array('Product|Products:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/price_list/product_price_list.php'
			)
		)
	),
	"admin/product/price/search" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'productPriceSearch',
		'desc' => 'Search product price',
		'group' => array('Product|Products:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/price_list/product_price_list_data.php'
			)
		)
	),
	"admin/product/change/price" => array(
		'controller' => 'backend\controllers\product\ProductController',
		'method' => 'changeProductPrice',
		'desc' => 'Quick change product price',
		'group' => array('Product|Products:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/price_list/product_price_change_data.php'
			)
		)
	),
	"admin/product/attribute" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'listView',
		'desc' => 'Get Attribute ',
		'group' => array('Product|Products:list'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/product/attribute/product_attribute_form_add_data.php'
			)
		)
	),
	//End product Manage

	// Starts User manage
	"admin/user/list" => array(
		'controller' => 'backend\controllers\user\UserController',
		'method' => 'listView',
		'desc' => 'User Manage',
		'group' => array('System|Administrators:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user/user_list.php'
			)
		)
	),

	"admin/user/search" => array(
		'controller' => 'backend\controllers\user\UserController',
		'method' => 'search',
		'desc' => 'Search User',
		'group' => array('System|Administrators:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user/user_list_data.php'
			)
		)
	),

	"admin/user/edit/view" => array(
		'controller' => 'backend\controllers\user\UserController',
		'method' => 'editView',
		'desc' => 'View Edit User',
		'group' => array('System|Administrators:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user/user_edit_view_data.php'
			)
		)
	),
	"admin/user/edit" => array(
		'controller' => 'backend\controllers\user\UserController',
		'method' => 'edit',
		'desc' => 'Edit User',
		'group' => array('System|Administrators:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user/user_edit_form_data.php'
			)
		)
	),

	"admin/user/add/view" => array(
		'controller' => 'backend\controllers\user\UserController',
		'method' => 'addView',
		'desc' => 'View Add User',
		'group' => array('System|Administrators:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user/user_add_view_data.php'
			)
		)
	),

	"admin/user/add" => array(
		'controller' => 'backend\controllers\user\UserController',
		'method' => 'add',
		'desc' => 'Add User',
		'group' => array('System|Administrators:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user/user_add_form_data.php'
			)
		)
	),

	"admin/user/del/view" => array(
		'controller' => 'backend\controllers\user\UserController',
		'method' => 'delView',
		'desc' => 'View Del User',
		'group' => array('System|Administrators:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user/user_del_view_data.php'
			)
		)
	),

	"admin/user/del" => array(
		'controller' => 'backend\controllers\user\UserController',
		'method' => 'del',
		'desc' => 'Delete User',
		'group' => array('System|Administrators:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user/user_del_form_data.php'
			)
		)
	),

	"admin/user/copy/view" => array(
		'controller' => 'backend\controllers\user\UserController',
		'method' => 'copyView',
		'desc' => 'Copy User',
		'group' => array('System|Administrators:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user/user_copy_view_data.php'
			)
		)
	),

	"admin/user/copy" => array(
		'controller' => 'backend\controllers\user\UserController',
		'method' => 'copy',
		'desc' => 'Copy User',
		'group' => array('System|Administrators:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user/user_copy_form_data.php'
			)
		)
	),

	// End user manage

	// Start payment method
	"admin/payment/method/list" => array(
		'controller' => 'backend\controllers\payment\PaymentMethodController',
		'method' => 'listView',
		'desc' => 'Payment Manage',
		'group' => array('payment.method:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/payment/method/payment_method_list.php'
			)
		)
	),
	"admin/payment/method/search" => array(
		'controller' => 'backend\controllers\payment\PaymentMethodController',
		'method' => 'search',
		'desc' => 'Search Payment',
		'group' => array('payment.method:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/payment/method/payment_method_list_data.php'
			)
		)
	),
	"admin/payment/method/edit/view" => array(
		'controller' => 'backend\controllers\payment\PaymentMethodController',
		'method' => 'editView',
		'desc' => 'View Edit Payment',
		'group' => array('payment.method:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/payment/method/payment_method_edit_view_data.php'
			)
		)
	),
	"admin/payment/method/edit" => array(
		'controller' => 'backend\controllers\payment\PaymentMethodController',
		'method' => 'edit',
		'desc' => 'Edit Payment',
		'group' => array('payment.method:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/payment/method/payment_method_edit_form_data.php'
			)
		)
	),
	"admin/payment/method/copy/view" => array(
		'controller' => 'backend\controllers\payment\PaymentMethodController',
		'method' => 'copyView',
		'desc' => 'Show copy payment method view',
		'group' => array('payment.method:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/payment/method/payment_method_copy_view_data.php'
			)
		)
	),
	"admin/payment/method/copy" => array(
		'controller' => 'backend\controllers\payment\PaymentMethodController',
		'method' => 'copy',
		'desc' => 'Copy payment method',
		'group' => array('payment.method:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/payment/method/payment_method_copy_form_data.php'
			)
		)
	),
	"admin/payment/method/add/view" => array(
		'controller' => 'backend\controllers\payment\PaymentMethodController',
		'method' => 'addView',
		'desc' => 'View Add Payment',
		'group' => array('payment.method:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/payment/method/payment_method_add_view_data.php'
			)
		)
	),
	"admin/payment/method/add" => array(
		'controller' => 'backend\controllers\payment\PaymentMethodController',
		'method' => 'add',
		'desc' => 'Add Payment',
		'group' => array('payment.method:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/payment/method/payment_method_add_form_data.php'
			)
		)
	),
	"admin/payment/method/del/view" => array(
		'controller' => 'backend\controllers\payment\PaymentMethodController',
		'method' => 'delView',
		'desc' => 'View Del Payment',
		'group' => array('payment.method:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/payment/method/payment_method_del_view_data.php'
			)
		)
	),
	"admin/payment/method/del" => array(
		'controller' => 'backend\controllers\payment\PaymentMethodController',
		'method' => 'del',
		'desc' => 'Delete Payment',
		'group' => array('payment.method:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/payment/method/payment_method_del_form_data.php'
			)
		)
	),
	// End payment method

	// Start UserGroup manage
	"admin/user/group/list" => array(
		'controller' => 'backend\controllers\user_group\UserGroupController',
		'method' => 'listView',
		'desc' => 'UserGroup Manage',
		'group' => array('System|Administrator Groups:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user_group/user_group_list.php'
			)
		)
	),

	"admin/user/group/search" => array(
		'controller' => 'backend\controllers\user_group\UserGroupController',
		'method' => 'search',
		'desc' => 'Search UserGroup',
		'group' => array('System|Administrator Groups:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user_group/user_group_list_data.php'
			)
		)
	),

	"admin/user/group/edit/view" => array(
		'controller' => 'backend\controllers\user_group\UserGroupController',
		'method' => 'editView',
		'desc' => 'View Edit UserGroup',
		'group' => array('System|Administrator Groups:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user_group/user_group_edit_view_data.php'
			)
		)
	),
	"admin/user/group/edit" => array(
		'controller' => 'backend\controllers\user_group\UserGroupController',
		'method' => 'edit',
		'desc' => 'Edit UserGroup',
		'group' => array('System|Administrator Groups:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user_group/user_group_edit_form_data.php'
			)
		)
	),

	"admin/user/group/add/view" => array(
		'controller' => 'backend\controllers\user_group\UserGroupController',
		'method' => 'addView',
		'desc' => 'View Add UserGroup',
		'group' => array('System|Administrator Groups:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user_group/user_group_add_view_data.php'
			)
		)
	),

	"admin/user/group/add" => array(
		'controller' => 'backend\controllers\user_group\UserGroupController',
		'method' => 'add',
		'desc' => 'Add UserGroup',
		'group' => array('System|Administrator Groups:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user_group/user_group_add_form_data.php'
			)
		)
	),

	"admin/user/group/del/view" => array(
		'controller' => 'backend\controllers\user_group\UserGroupController',
		'method' => 'delView',
		'desc' => 'View Del UserGroup',
		'group' => array('System|Administrator Groups:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user_group/user_group_del_view_data.php'
			)
		)
	),

	"admin/user/group/del" => array(
		'controller' => 'backend\controllers\user_group\UserGroupController',
		'method' => 'del',
		'desc' => 'Delete UserGroup',
		'group' => array('System|Administrator Groups:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user_group/user_group_del_form_data.php'
			)
		)
	),
	"admin/user/group/copy/view" => array(
		'controller' => 'backend\controllers\user_group\UserGroupController',
		'method' => 'copyView',
		'desc' => 'View Copy UserGroup',
		'group' => array('System|Administrator Groups:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user_group/user_group_copy_view_data.php'
			)
		)
	),

	"admin/user/group/copy" => array(
		'controller' => 'backend\controllers\user_group\UserGroupController',
		'method' => 'copy',
		'desc' => 'Copy UserGroup',
		'group' => array('System|Administrator Groups:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/user_group/user_group_copy_form_data.php'
			)
		)
	),
	// End UserGroup manage
	// Begin system setting.
	"admin/system/setting/list" => array(
		'controller' => 'backend\controllers\system_setting\SystemSettingController',
		'method' => 'listView',
		'desc' => 'Show system settings',
		'group' => array('System|Settings:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/system_setting/setting_list.php'
			)
		)
	),
	"admin/system/setting/update" => array(
		'controller' => 'backend\controllers\system_setting\SystemSettingController',
		'method' => 'update',
		'desc' => 'Update system settings',
		'group' => array('System|Settings:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/system_setting/setting_update_data.php'
			)
		)
	),
	// End system setting
	// Begin currency.
	"admin/currency/list" => array(
		'controller' => 'backend\controllers\currency\CurrencyController',
		'method' => 'listView',
		'desc' => 'List currencies',
		'group' => array('System|Currencies:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/currency/currency_list.php'
			)
		)
	),
	"admin/currency/search" => array(
		'controller' => 'backend\controllers\currency\CurrencyController',
		'method' => 'search',
		'desc' => 'Search currencies',
		'group' => array('System|Currencies:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/currency/currency_list_data.php'
			)
		)
	),
	"admin/currency/add/view" => array(
		'controller' => 'backend\controllers\currency\CurrencyController',
		'method' => 'addView',
		'desc' => 'Show add currency dialog',
		'group' => array('System|Currencies:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/currency/currency_add_view_data.php'
			)
		)
	),
	"admin/currency/add" => array(
		'controller' => 'backend\controllers\currency\CurrencyController',
		'method' => 'add',
		'desc' => 'Add currency',
		'group' => array('System|Currencies:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/currency/currency_add_res_data.php'
			)
		)
	),
	"admin/currency/edit/view" => array(
		'controller' => 'backend\controllers\currency\CurrencyController',
		'method' => 'editView',
		'desc' => 'Show edit currency dialog',
		'group' => array('System|Currencies:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/currency/currency_edit_view_data.php'
			)
		)
	),
	"admin/currency/edit" => array(
		'controller' => 'backend\controllers\currency\CurrencyController',
		'method' => 'edit',
		'desc' => 'Edit currency',
		'group' => array('System|Currencies:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/currency/currency_edit_res_data.php'
			)
		)
	),
	"admin/currency/copy/view" => array(
		'controller' => 'backend\controllers\currency\CurrencyController',
		'method' => 'copyView',
		'desc' => 'Show copy currency dialog',
		'group' => array('System|Currencies:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/currency/currency_copy_view_data.php'
			)
		)
	),
	"admin/currency/copy" => array(
		'controller' => 'backend\controllers\currency\CurrencyController',
		'method' => 'copy',
		'desc' => 'Copy currency',
		'group' => array('System|Currencies:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/currency/currency_copy_res_data.php'
			)
		)
	),
	"admin/currency/del/view" => array(
		'controller' => 'backend\controllers\currency\CurrencyController',
		'method' => 'delView',
		'desc' => 'Show delete currency dialog',
		'group' => array('System|Currencies:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/currency/currency_del_view_data.php'
			)
		)
	),
	"admin/currency/del" => array(
		'controller' => 'backend\controllers\currency\CurrencyController',
		'method' => 'del',
		'desc' => 'Delete currency',
		'group' => array('System|Currencies:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/currency/currency_del_res_data.php'
			)
		)
	),
	// End currency.

	// Begin language.
	"admin/language/list" => array(
		'controller' => 'backend\controllers\language\LanguageController',
		'method' => 'listView',
		'desc' => 'List languages',
		'group' => array('System|Languages:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/lang/language_list.php'
			)
		)
	),
	"admin/language/search" => array(
		'controller' => 'backend\controllers\language\LanguageController',
		'method' => 'search',
		'desc' => 'Search languages',
		'group' => array('System|Languages:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/lang/language_list_data.php'
			)
		)
	),
	"admin/language/add/view" => array(
		'controller' => 'backend\controllers\language\LanguageController',
		'method' => 'addView',
		'desc' => 'Show add language dialog',
		'group' => array('System|Languages:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/lang/language_add_view_data.php'
			)
		)
	),
	"admin/language/add" => array(
		'controller' => 'backend\controllers\language\LanguageController',
		'method' => 'add',
		'desc' => 'Add language',
		'group' => array('System|Languages:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/lang/language_add_res_data.php'
			)
		)
	),
	"admin/language/edit/view" => array(
		'controller' => 'backend\controllers\language\LanguageController',
		'method' => 'editView',
		'desc' => 'Show edit language dialog',
		'group' => array('System|Languages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/lang/language_edit_view_data.php'
			)
		)
	),
	"admin/language/edit" => array(
		'controller' => 'backend\controllers\language\LanguageController',
		'method' => 'edit',
		'desc' => 'Edit language',
		'group' => array('System|Languages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/lang/language_edit_res_data.php'
			)
		)
	),
	"admin/language/copy/view" => array(
		'controller' => 'backend\controllers\language\LanguageController',
		'method' => 'copyView',
		'desc' => 'Show clone language dialog',
		'group' => array('System|Languages:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/lang/language_copy_view_data.php'
			)
		)
	),
	"admin/language/copy" => array(
		'controller' => 'backend\controllers\language\LanguageController',
		'method' => 'copy',
		'desc' => 'Clone language',
		'group' => array('System|Languages:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/lang/language_copy_res_data.php'
			)
		)
	),
	"admin/language/del/view" => array(
		'controller' => 'backend\controllers\language\LanguageController',
		'method' => 'delView',
		'desc' => 'Show delete language dialog',
		'group' => array('System|Languages:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/lang/language_del_view_data.php'
			)
		)
	),
	"admin/language/del" => array(
		'controller' => 'backend\controllers\language\LanguageController',
		'method' => 'del',
		'desc' => 'Delete language',
		'group' => array('System|Languages:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/lang/language_del_res_data.php'
			)
		)
	),
	// End language.

	// Begin language value.
	"admin/language/value/list" => array(
		'controller' => 'backend\controllers\language\LanguageValueController',
		'method' => 'listView',
		'desc' => 'List language values',
		'group' => array('System|Translation:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/value/language_value_list.php'
			)
		)
	),
	"admin/language/value/search" => array(
		'controller' => 'backend\controllers\language\LanguageValueController',
		'method' => 'search',
		'desc' => 'Search language values',
		'group' => array('System|Translation:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/value/language_value_list_data.php'
			)
		)
	),
	"admin/language/value/edit/view" => array(
		'controller' => 'backend\controllers\language\LanguageValueController',
		'method' => 'editView',
		'desc' => 'Show edit language value dialog',
		'group' => array('System|Translation:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/value/language_value_edit_view_data.php'
			)
		)
	),
	"admin/language/value/edit" => array(
		'controller' => 'backend\controllers\language\LanguageValueController',
		'method' => 'edit',
		'desc' => 'Edit language value',
		'group' => array('System|Translation:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/language/value/language_value_edit_res_data.php'
			)
		)
	),
	"admin/language/value/export" => array(
		'controller' => 'backend\controllers\language\LanguageValueController',
		'method' => 'exportCSV',
		'desc' => 'Export Language',
		'group' => array('System|Languages:view'),
		'results' => array(
			'success' => array(
				'type' => 'stream',
				'input' => 'fullPathFile',
				'output' => 'fileNameDownload',
				'params' => array(
					'Content-Type' => 'text/csv; charset=utf-8',
					'Content-Disposition' => 'attachment; filename=#{fileNameDownload}',
					'Set-Cookie' => ' fileDownload=true; path=/'
				)
			)
		)
	),
	// End language value.

	//start template (taipv)
	"admin/template/list" => array(
		'controller' => 'backend\controllers\template\TemplateController',
		'method' => 'listView',
		'desc' => 'List template groups',
		'group' => array('Content|Pages:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/template/template_list.php'
			)
		)
	),
	"admin/template/search" => array(
		'controller' => 'backend\controllers\template\TemplateController',
		'method' => 'search',
		'desc' => 'Search template groups',
		'group' => array('Content|Pages:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/template/template_list_data.php'
			)
		)
	),
	"admin/template/add/view" => array(
		'controller' => 'backend\controllers\template\TemplateController',
		'method' => 'addView',
		'desc' => 'Show add template form',
		'group' => array('Content|Pages:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/template/template_add_view.php'
			)
		)
	),
	"admin/template/add" => array(
		'controller' => 'backend\controllers\template\TemplateController',
		'method' => 'add',
		'desc' => 'Add template',
		'group' => array('Content|Pages:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/template/empty.php'
			)
		)
	),
	"admin/template/edit/view" => array(
		'controller' => 'backend\controllers\template\TemplateController',
		'method' => 'editView',
		'desc' => 'Template edit view',
		'group' => array('Content|Pages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/template/template_edit_view.php'
			),
		)
	),
	"admin/template/edit" => array(
		'controller' => 'backend\controllers\template\TemplateController',
		'method' => 'edit',
		'desc' => 'template edit',
		'group' => array('Content|Pages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/template/empty.php'
			),
		)
	),
	"admin/template/del/view" => array(
		'controller' => 'backend\controllers\template\TemplateController',
		'method' => 'delView',
		'desc' => 'Delete template view',
		'group' => array('Content|Pages:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/template/template_del_view_data.php'
			),
		)
	),
	"admin/template/del" => array(
		'controller' => 'backend\controllers\template\TemplateController',
		'method' => 'del',
		'desc' => 'Delete template group',
		'group' => array('Content|Pages:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/template/template_del_form_data.php'
			)
		)
	),
	//end template

	// page (taipv)
	"admin/page/list" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'listView',
		'desc' => 'List page groups',
		'group' => array('Content|Pages:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/page_list.php'
			)
		)
	),
	"admin/page/search" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'search',
		'desc' => 'Search page groups',
		'group' => array('Content|Pages:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/page_list_data.php'
			)
		)
	),
	"admin/page/add/view" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'addView',
		'desc' => 'Show add page form',
		'group' => array('Content|Pages:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/page_add_view.php'
			)
		)
	),
	"admin/page/add" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'add',
		'desc' => 'Add page',
		'group' => array('Content|Pages:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/layout/empty.php'
			)
		)
	),
	"admin/page/edit/view" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'editView',
		'desc' => 'Page edit view',
		'group' => array('Content|Pages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/page_edit_view.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/error/404.php'
			),
		)
	),
	"admin/page/edit" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'edit',
		'desc' => 'page edit',
		'group' => array('Content|Pages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/layout/empty.php'
			),
		)
	),
	"admin/page/copy" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'copy',
		'desc' => 'Copy page',
		'group' => array('Content|Pages:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/empty.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/error/404.php'
			),
		)
	),
	"admin/page/del/view" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'delView',
		'desc' => 'Delete page view',
		'group' => array('Content|Pages:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/page_del_view_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/error/404.php'
			),
		)
	),
	"admin/page/del" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'del',
		'desc' => 'Delete page group',
		'group' => array('Content|Pages:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/page_del_form_data.php'
			)
		)
	),

	"admin/page/recache/page/view" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'recachePageView',
		'desc' => 'Recache a page view',
		'group' => array('Content|Pages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/cache/page_cache_view_data.php'
			)
		)
	),
	"admin/page/recache/page" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'recachePage',
		'desc' => 'Recache a page',
		'group' => array('Content|Pages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/cache/page_cache_view_data.php'
			)
		)
	),
	"admin/page/recache/page/all/view" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'recachePageAllView',
		'desc' => 'Recache all page view',
		'group' => array('Content|Pages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/cache/page_cache_all_view_data.php'
			)
		)
	),
	"admin/page/recache/page/all" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'recachePageAll',
		'desc' => 'Recache all page',
		'group' => array('Content|Pages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/cache/page_cache_all_view_data.php'
			)
		)
	),
	"admin/page/page/cache/enable/view" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'pageCacheEnableView',
		'desc' => 'Recache enable a page view',
		'group' => array('Content|Pages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/cache/page_cache_enable_view_data.php'
			)
		)
	),
	"admin/page/page/cache/enable" => array(
		'controller' => 'backend\controllers\page\PageController',
		'method' => 'pageCacheEnable',
		'desc' => 'Recache enable a page',
		'group' => array('Content|Pages:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/cache/page_cache_enable_view_data.php'
			)
		)
	),
	//page end

	//start container (taipv)
	"admin/container/list" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'listView',
		'desc' => 'List container groups',
		'group' => array("Content|Pages:view"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_list.php'
			)
		)
	),
	"admin/container/search" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'search',
		'desc' => 'Search container groups',
		'group' => array("Content|Pages:view"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_list_data.php'
			)
		)
	),
	"admin/container/add/view" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'addView',
		'desc' => 'Show add container form',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_add_view.php'
			)
		)
	),
	"admin/container/add" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'add',
		'desc' => 'Add container',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/empty.php'
			)
		)
	),
	"admin/container/edit/view" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'editView',
		'desc' => 'Container edit view',
		'group' => array("Content|Pages:edit"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_edit_view.php'
			),
		)
	),
	"admin/container/edit/view/data" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'editView',
		'desc' => 'Container edit view',
		'group' => array("Content|Pages:edit"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_edit_form_data.php'
			),
		)
	),
	"admin/container/edit" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'edit',
		'desc' => 'container edit',
		'group' => array("Content|Pages:edit"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/empty.php'
			),
		)
	),
	"admin/container/copy" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'copy',
		'desc' => 'Copy container',
		'group' => array("Content|Pages:copy"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/empty.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/error/404.php'
			),
		)
	),
	"admin/container/del/view" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'delView',
		'desc' => 'Delete container view',
		'group' => array("Content|Pages:del"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_del_view_data.php'
			),
		)
	),
	"admin/container/del" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'del',
		'desc' => 'Delete container group',
		'group' => array("Content|Pages:del"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_del_form_data.php'
			)
		)
	),
	//layout
	"admin/container/layout/refresh" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'refreshLayout',
		'desc' => 'Layout refresh',
		'group' => array("Content|Pages:view"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_edit_form_data.php'
			)
		)
	),
	//layout/widget/content
	"admin/container/layout/widget/content/add/view" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'widgetContentAddView',
		'desc' => 'Show add widget content dialog',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/widget_content/widget_content_add_view_data.php'
			)
		)
	),
	"admin/container/layout/widget/content/exist/add" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'widgetContentExistAdd',
		'desc' => 'Add widget content exist',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/empty.php'
			)
		)
	),
	"admin/container/layout/widget/content/add" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'widgetContentAdd',
		'desc' => 'Add widget content',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/empty.php'
			),
		)
	),
	"admin/container/layout/widget/content/select/add" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'widgetContentSelectAdd',
		'desc' => 'Select widget then add widget dialog',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/widget_content/widget_content_add_form_data.php'
			)
		)
	),
	"admin/container/layout/widget/content/edit/view" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'widgetContentEditView',
		'desc' => 'Show edit widget content dialog',
		'group' => array("Content|Pages:edit"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/widget_content/widget_content_edit_view_data.php'
			)
		)
	),
	"admin/container/layout/widget/content/edit" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'widgetContentEdit',
		'desc' => 'Edit widget content',
		'group' => array("Content|Pages:edit"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/empty.php'
			)
		)
	),
	"admin/container/layout/grid/widget/edit/status" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridWidgetEditStatus',
		'desc' => 'Edit status of widget content',
		'group' => array("Content|Pages:edit"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_edit_form_data.php'
			)
		)
	),
	"admin/container/layout/widget/content/delete" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'widgetContentDelete',
		'desc' => 'Delete widget content',
		'group' => array("Content|Pages:del"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_edit_form_data.php'
			)
		)
	),
	//layout/grid
	"admin/container/layout/grid/add/view" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridAddView',
		'desc' => 'Show add grid dialog',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/grid/grid_add_view_data.php'
			)
		)
	),
	"admin/container/layout/grid/add" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridAdd',
		'desc' => 'Add grid',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/grid/grid_add_res_data.php'
			)
		)
	),
	"admin/container/layout/grid/edit/view" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridEditView',
		'desc' => 'Show edit grid dialog',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/grid/grid_edit_view_data.php'
			)
		)
	),
	"admin/container/layout/grid/edit" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridEdit',
		'desc' => 'Edit grid',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/grid/grid_edit_res_data.php'
			)
		)
	),
	"admin/container/layout/grid/edit/status" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridEditStatus',
		'desc' => 'Edit status of grid',
		'group' => array("Content|Pages:add"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_edit_form_data.php'
			)
		)
	),
	"admin/container/layout/grid/delete/view" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridDeleteView',
		'desc' => 'Show delete grid dialog',
		'group' => array("Content|Pages:del"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/grid/grid_delete_view_data.php'
			)
		)
	),
	"admin/container/layout/grid/delete" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridDelete',
		'desc' => 'Delete grid',
		'group' => array("Content|Pages:del"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/grid/grid_delete_res_data.php'
			)
		)
	),
	"admin/container/layout/grid/widget/delete/view" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridWidgetDeleteView',
		'desc' => 'Show delete widget content dialog',
		'group' => array("Content|Pages:del"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/grid_widget/grid_widget_delete_view_data.php'
			)
		)
	),
	"admin/container/layout/grid/widget/delete" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridWidgetDelete',
		'desc' => 'Delete widget content',
		'group' => array("Content|Pages:del"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/layout/grid_widget/grid_widget_delete_res_data.php'
			)
		)
	),
	//layout/container
	"admin/container/layout/container/edit/status" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'containerEditStatus',
		'desc' => 'Edit status of container',
		'group' => array("Content|Pages:edit"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_edit_form_data.php'
			)
		)
	),
	//layout-sortable
	"admin/container/layout/grid/sortable" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridSortable',
		'desc' => 'Grid sortable',
		'group' => array("Content|Pages:edit"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_edit_form_data.php'
			),
		)
	),
	"admin/container/layout/grid/widget/sortable" => array(
		'controller' => 'backend\controllers\container\ContainerController',
		'method' => 'gridWidgetSortable',
		'desc' => 'Widget sortable',
		'group' => array("Content|Pages:edit"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/container/container_edit_form_data.php'
			)
		)
	),
	//end container

	// Begin backend menu (taipv)
	"admin/backend/menu/list" => array(
		'controller' => 'backend\controllers\backend_menu\BackendMenuController',
		'method' => 'listView',
		'desc' => 'List backend menu',
		'group' => array(),
		//'group' => array('System|Admin menu::view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/backend_menu/backend_menu_list.php'
			)
		)
	),
	"admin/backend/menu/refresh" => array(
		'controller' => 'backend\controllers\backend_menu\BackendMenuController',
		'method' => 'refreshBackendMenu',
		'desc' => 'Refresh Page',
		//'group' => array('System|Admin menu::view'),
		'group' => array(),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/backend_menu/backend_menu_list_data.php'
			)
		)
	),
	"admin/backend/menu/add/view" => array(
		'controller' => 'backend\controllers\backend_menu\BackendMenuController',
		'method' => 'addView',
		'desc' => 'Show add backend menu form',
		//'group' => array('System|Admin menu::add'),
		'group' => array(),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/backend_menu/backend_menu_add_view_data.php'
			)
		)
	),
	"admin/backend/menu/add" => array(
		'controller' => 'backend\controllers\backend_menu\BackendMenuController',
		'method' => 'add',
		'desc' => 'Add backend menu',
		'group' => array(),
		//'group' => array('System|Admin menu::add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/backend_menu/backend_menu_add_form_data.php'
			)
		)
	),
	"admin/backend/menu/edit/view" => array(
		'controller' => 'backend\controllers\backend_menu\BackendMenuController',
		'method' => 'editView',
		'desc' => 'Show edit backend menu form',
		'group' => array(),
// 		'group' => array('System|Admin menu::edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/backend_menu/backend_menu_edit_view_data.php'
			)
		)
	),
	"admin/backend/menu/edit" => array(
		'controller' => 'backend\controllers\backend_menu\BackendMenuController',
		'method' => 'edit',
		'desc' => 'Edit backend menu',
// 		'group' => array('System|Admin menu::edit'),
		'group' => array(),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/backend_menu/backend_menu_edit_form_data.php'
			)
		)
	),
	"admin/backend/menu/del/view" => array(
		'controller' => 'backend\controllers\backend_menu\BackendMenuController',
		'method' => 'delView',
		'desc' => 'Delete backend menu view',
// 		'group' => array('System|Admin menu::del'),
		'group' => array(),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/backend_menu/backend_menu_del_view_data.php'
			)
		)
	),
	"admin/backend/menu/del" => array(
		'controller' => 'backend\controllers\backend_menu\BackendMenuController',
		'method' => 'del',
		'desc' => 'Delete backend menu',
// 		'group' => array('System|Admin menu::del'),
		'group' => array(),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/backend_menu/backend_menu_del_form_data.php'
			)
		)
	),
	"admin/backend/menu/sortable" => array(
		'controller' => 'backend\controllers\backend_menu\BackendMenuController',
		'method' => 'sortable',
		'desc' => 'Backend menu sortable',
// 		'group' => array('System|Admin menu::edit'),
		'group' => array(),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/backend_menu/backend_menu_list_data.php'
			),
		)
	),
	// End backend menu

	// Begin price_level.
	"admin/price/level/list" => array(
		'controller' => 'backend\controllers\price_level\PriceLevelController',
		'method' => 'listView',
		'desc' => 'List price level',
		'group' => array('Discounts|Price Levels:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/price_level/price_level_list.php'
			)
		)
	),
	"admin/price/level/search" => array(
		'controller' => 'backend\controllers\price_level\PriceLevelController',
		'method' => 'search',
		'desc' => 'Search price level',
		'group' => array('Discounts|Price Levels:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/price_level/price_level_list_data.php'
			)
		)
	),
	"admin/price/level/add/view" => array(
		'controller' => 'backend\controllers\price_level\PriceLevelController',
		'method' => 'addView',
		'desc' => 'Show add price level form',
		'group' => array('Discounts|Price Levels:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/price_level/price_level_add_view_data.php'
			)
		)
	),
	"admin/price/level/add" => array(
		'controller' => 'backend\controllers\price_level\PriceLevelController',
		'method' => 'add',
		'desc' => 'Add price level',
		'group' => array('Discounts|Price Levels:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/price_level/price_level_add_form_data.php'
			)
		)
	),
	"admin/price/level/edit/view" => array(
		'controller' => 'backend\controllers\price_level\PriceLevelController',
		'method' => 'editView',
		'desc' => 'Show edit price level form',
		'group' => array('Discounts|Price Levels:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/price_level/price_level_edit_view_data.php'
			)
		)
	),
	"admin/price/level/edit" => array(
		'controller' => 'backend\controllers\price_level\PriceLevelController',
		'method' => 'edit',
		'desc' => 'Edit price level group',
		'group' => array('Discounts|Price Levels:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/price_level/price_level_edit_form_data.php'
			)
		)
	),
	"admin/price/level/copy/view" => array(
		'controller' => 'backend\controllers\price_level\PriceLevelController',
		'method' => 'copyView',
		'desc' => 'Show copy price level form',
		'group' => array('Discounts|Price Levels:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/price_level/price_level_copy_view_data.php'
			)
		)
	),
	"admin/price/level/copy" => array(
		'controller' => 'backend\controllers\price_level\PriceLevelController',
		'method' => 'copy',
		'desc' => 'Copy price level',
		'group' => array('Discounts|Price Levels:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/price_level/price_level_copy_form_data.php'
			)
		)
	),
	"admin/price/level/del/view" => array(
		'controller' => 'backend\controllers\price_level\PriceLevelController',
		'method' => 'delView',
		'desc' => 'Delete price_level view',
		'group' => array('Discounts|Price Levels:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/price_level/price_level_del_view_data.php'
			)
		)
	),
	"admin/price/level/del" => array(
		'controller' => 'backend\controllers\price_level\PriceLevelController',
		'method' => 'del',
		'desc' => 'Delete price_level group',
		'group' => array('Discounts|Price Levels:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/price_level/price_level_del_res_data.php'
			)
		)
	),
	// End price_level
	// Begin discount_coupon.
	"admin/discount/coupon/list" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'listView',
		'desc' => 'List discount_coupon groups',
		'group' => array('Discounts|Discount Coupons:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/discount_coupon_list.php'
			)
		)
	),
	"admin/discount/coupon/search" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'search',
		'desc' => 'Search discount_coupon groups',
		'group' => array('Discounts|Discount Coupons:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/discount_coupon_list_data.php'
			)
		)
	),
	"admin/discount/coupon/add/view" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'addView',
		'desc' => 'Show add discount_coupon form',
		'group' => array('Discounts|Discount Coupons:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/discount_coupon_add_view.php'
			)
		)
	),
	"admin/discount/coupon/add" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'add',
		'desc' => 'Add discount_coupon group',
		'group' => array('Discounts|Discount Coupons:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/discount_coupon_add_form_data.php'
			)
		)
	),
	"admin/discount/coupon/edit/view" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'editView',
		'desc' => 'Show edit discount_coupon form',
		'group' => array('Discounts|Discount Coupons:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/discount_coupon_edit_view.php'
			)
		)
	),
	"admin/discount/coupon/edit" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'edit',
		'desc' => 'Edit discount_coupon group',
		'group' => array('Discounts|Discount Coupons:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/discount_coupon_edit_form_data.php'
			)
		)
	),
	"admin/discount/coupon/copy/view" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'copyView',
		'desc' => 'Show copy discount_coupon form',
		'group' => array('Discounts|Discount Coupons:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/discount_coupon_copy_view.php'
			)
		)
	),
	"admin/discount/coupon/copy" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'copy',
		'desc' => 'Copy discount_coupon group',
		'group' => array('Discounts|Discount Coupons:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/discount_coupon_copy_form_data.php'
			)
		)
	),
	"admin/discount/coupon/del/view" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'delView',
		'desc' => 'Delete discount_coupon view',
		'group' => array('Discounts|Discount Coupons:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/discount_coupon_del_view_data.php'
			)
		)
	),
	"admin/discount/coupon/del" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'del',
		'desc' => 'Delete discount_coupon group',
		'group' => array('Discounts|Discount Coupons:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/discount_coupon_del_res_data.php'
			)
		)
	),
	"admin/discount/coupon/product/add" => array(
		'controller' => 'backend\controllers\discount_coupon\DiscountCouponController',
		'method' => 'addProductCategory',
		'desc' => 'add discount_coupon product',
		'group' => array('Discounts|Discount Coupons:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/discount_coupon/product/discount_coupon_product_success_data.php'
			)
		)
	),
	// End discount_coupon

	// Begin subscriber.
	"admin/subscriber/list" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'listView',
		'desc' => 'List subscribers',
		'group' => array('Store|Subscribers:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/subscriber/subscriber_list.php'
			)
		)
	),
	"admin/subscriber/search" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'search',
		'desc' => 'Search subscribers',
		'group' => array('Store|Subscribers:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/subscriber/subscriber_list_data.php'
			)
		)
	),
	"admin/subscriber/add/view" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'addView',
		'desc' => 'Show add subscriber dialog',
		'group' => array('Store|Subscribers:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/subscriber/subscriber_add_view_data.php'
			)
		)
	),
	"admin/subscriber/add" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'add',
		'desc' => 'Add subscriber',
		'group' => array('Store|Subscribers:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/subscriber/subscriber_add_res_data.php'
			)
		)
	),
	"admin/subscriber/edit/view" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'editView',
		'desc' => 'Show edit subscriber dialog',
		'group' => array('Store|Subscribers:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/subscriber/subscriber_edit_view_data.php'
			)
		)
	),
	"admin/subscriber/edit" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'edit',
		'desc' => 'Edit subscriber',
		'group' => array('Store|Subscribers:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/subscriber/subscriber_edit_res_data.php'
			)
		)
	),
	"admin/subscriber/copy/view" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'copyView',
		'desc' => 'Show copy subscriber dialog',
		'group' => array('Store|Subscribers:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/subscriber/subscriber_copy_view_data.php'
			)
		)
	),
	"admin/subscriber/copy" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'copy',
		'desc' => 'Copy subscriber',
		'group' => array('Store|Subscribers:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/subscriber/subscriber_copy_res_data.php'
			)
		)
	),
	"admin/subscriber/del/view" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'delView',
		'desc' => 'Show delete subscriber dialog',
		'group' => array('Store|Subscribers:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/subscriber/subscriber_del_view_data.php'
			)
		)
	),
	"admin/subscriber/del" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'del',
		'desc' => 'Delete subscriber',
		'group' => array('Store|Subscribers:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/subscriber/subscriber_del_res_data.php'
			)
		)
	),
	"admin/subscriber/export/csv" => array(
		'controller' => 'backend\controllers\subscriber\SubscriberController',
		'method' => 'exportCsv',
		'desc' => 'Export subscribers to csv file',
		'group' => array('Store|Subscribers:view'),
		'results' => array(
			'success' => array(
				'type' => 'stream',
				'input' => 'fileName',
				'output' => 'outputFileName',
				'params' => array(
					'Content-Type' => 'text/csv; charset=utf-8',
					'Content-Disposition' => 'attachment; filename=#{outputFileName}'
				)
			)
		)
	),
	// End subscriber.

	// Begin email template.
	"admin/email/template/list" => array(
		'controller' => 'backend\controllers\email_template\EmailTemplateController',
		'method' => 'listView',
		'desc' => 'List email_template groups',
		'group' => array('System|Email Templates:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/email_template/email_template_list.php'
			)
		)
	),
	"admin/email/template/search" => array(
		'controller' => 'backend\controllers\email_template\EmailTemplateController',
		'method' => 'search',
		'desc' => 'Search email_template groups',
		'group' => array('System|Email Templates:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/email_template/email_template_list_data.php'
			)
		)
	),
	"admin/email/template/edit/view" => array(
		'controller' => 'backend\controllers\email_template\EmailTemplateController',
		'method' => 'editView',
		'desc' => 'Show edit email_template form',
		'group' => array('System|Email Templates:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/email_template/email_template_edit_view_data.php'
			)
		)
	),
	"admin/email/template/edit" => array(
		'controller' => 'backend\controllers\email_template\EmailTemplateController',
		'method' => 'edit',
		'desc' => 'Edit email_template group',
		'group' => array('System|Email Templates:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/email_template/email_template_edit_form_data.php'
			)
		)
	),
	"admin/email/template/copy/view" => array(
		'controller' => 'backend\controllers\email_template\EmailTemplateController',
		'method' => 'copyView',
		'desc' => 'Show copy email_template form',
		'group' => array('System|Email Templates:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/email_template/email_template_copy_view_data.php'
			)
		)
	),
	"admin/email/template/copy" => array(
		'controller' => 'backend\controllers\email_template\EmailTemplateController',
		'method' => 'copy',
		'desc' => 'Copy email_template group',
		'group' => array('System|Email Templates:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/email_template/email_template_copy_form_data.php'
			)
		)
	),
	"admin/template/copy" => array(
		'controller' => 'backend\controllers\template\TemplateController',
		'method' => 'copy',
		'desc' => 'Copy template',
		'group' => array('System|Email Templates:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/template/empty.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/error/404.php'
			),
		)
	),
	"admin/email/template/del/view" => array(
		'controller' => 'backend\controllers\email_template\EmailTemplateController',
		'method' => 'delView',
		'desc' => 'Delete email_template view',
		'group' => array('System|Email Templates:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/email_template/email_template_del_view_data.php'
			)
		)
	),
	"admin/email/template/del" => array(
		'controller' => 'backend\controllers\email_template\EmailTemplateController',
		'method' => 'del',
		'desc' => 'Delete email_template group',
		'group' => array('System|Email Templates:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/email_template/email_template_del_res_data.php'
			)
		)
	),
	// End email template

	// Begin Piwik
	// End Piwik

	// Begin batch group value.

	// Starts Batch Group manage
	"admin/batch/group/list" => array(
		'controller' => 'backend\controllers\batch_group\BatchGroupController',
		'method' => 'listView',
		'desc' => 'Batch Group Manage',
		'group' => array('Content|Batches:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch_group/batch_group_list.php'
			)
		)
	),
	"admin/batch/group/search" => array(
		'controller' => 'backend\controllers\batch_group\BatchGroupController',
		'method' => 'search',
		'desc' => 'Search Batch Group',
		'group' => array('Content|Batches:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch_group/batch_group_list_data.php'
			)
		)
	),
	"admin/batch/group/edit/view" => array(
		'controller' => 'backend\controllers\batch_group\BatchGroupController',
		'method' => 'editView',
		'desc' => 'View Edit Batch Group',
		'group' => array('Content|Batches:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch_group/batch_group_edit_view_data.php'
			)
		)
	),
	"admin/batch/group/edit" => array(
		'controller' => 'backend\controllers\batch_group\BatchGroupController',
		'method' => 'edit',
		'desc' => 'Edit Batch Group',
		'group' => array('Content|Batches:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch_group/slide_group_edit_form_data.php'
			)
		)
	),

	"admin/batch/group/add/view" => array(
		'controller' => 'backend\controllers\batch_group\BatchGroupController',
		'method' => 'addView',
		'desc' => 'View Add Batch Group',
		'group' => array('Content|Batches:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch_group/batch_group_add_view_data.php'
			)
		)
	),

	"admin/batch/group/add" => array(
		'controller' => 'backend\controllers\batch_group\BatchGroupController',
		'method' => 'add',
		'desc' => 'Add Batch Group',
		'group' => array('Content|Batches:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch_group/batch_group_add_form_data.php'
			)
		)
	),

	"admin/batch/group/del/view" => array(
		'controller' => 'backend\controllers\batch_group\BatchGroupController',
		'method' => 'delView',
		'desc' => 'View Del Batch Group',
		'group' => array('Content|Batches:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch_group/batch_group_del_view_data.php'
			)
		)
	),

	"admin/batch/group/del" => array(
		'controller' => 'backend\controllers\batch_group\BatchGroupController',
		'method' => 'del',
		'desc' => 'Delete Batch Group',
		'group' => array('Content|Batches:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch_group/batch_group_del_form_data.php'
			)
		)
	),
	"admin/batch/group/copy/view" => array(
		'controller' => 'backend\controllers\batch_group\BatchGroupController',
		'method' => 'copyView',
		'desc' => 'View Copy Batch Group',
		'group' => array('Content|Batches:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch_group/batch_group_copy_view_data.php'
			)
		)
	),

	"admin/batch/group/copy" => array(
		'controller' => 'backend\controllers\batch_group\BatchGroupController',
		'method' => 'copy',
		'desc' => 'Copy Batch Group',
		'group' => array('Content|Batches:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch_group/batch_group_copy_form_data.php'
			)
		)
	),
	// End Batch Group manage

	// Starts Batch manage
	"admin/batch/list" => array(
		'controller' => 'backend\controllers\batch\BatchController',
		'method' => 'listView',
		'desc' => 'Batch Manage',
		'group' => array('Content|Batches:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch/batch_list.php'
			)
		)
	),
	"admin/batch/search" => array(
		'controller' => 'backend\controllers\batch\BatchController',
		'method' => 'search',
		'desc' => 'Search Batch',
		'group' => array('Content|Batches:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch/slide_list_data.php'
			)
		)
	),
	"admin/batch/edit/view" => array(
		'controller' => 'backend\controllers\batch\BatchController',
		'method' => 'editView',
		'desc' => 'View Edit Batch',
		'group' => array('Content|Batches:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch/batch_edit_view_data.php'
			)
		)
	),
	"admin/batch/edit" => array(
		'controller' => 'backend\controllers\batch\BatchController',
		'method' => 'edit',
		'desc' => 'Edit Batch',
		'group' => array('Content|Batches:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch/batch_edit_form_data.php'
			)
		)
	),

	"admin/batch/add/view" => array(
		'controller' => 'backend\controllers\batch\BatchController',
		'method' => 'addView',
		'desc' => 'View Add Batch',
		'group' => array('Content|Batches:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch/batch_add_view_data.php'
			)
		)
	),

	"admin/batch/add" => array(
		'controller' => 'backend\controllers\batch\BatchController',
		'method' => 'add',
		'desc' => 'Add Batch',
		'group' => array('Content|Batches:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch/batch_add_form_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/batch/result_upload/batch_list_data.php'
			)
		)
	),

	"admin/batch/confirm" => array(
		'controller' => 'backend\controllers\batch\BatchController',
		'method' => 'confirmUpload',
		'desc' => 'Confirm Upload Batch',
		'group' => array('Content|Batches:add', 'Content|Batches:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch/batch_add_form_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/batch/result_upload/batch_list_data.php'
			)
		)
	),

	"admin/batch/del/view" => array(
		'controller' => 'backend\controllers\batch\BatchController',
		'method' => 'delView',
		'desc' => 'View Del Batch',
		'group' => array('Content|Batches:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch/batch_del_view_data.php'
			)
		)
	),

	"admin/batch/del" => array(
		'controller' => 'backend\controllers\batch\BatchController',
		'method' => 'del',
		'desc' => 'Delete Batch',
		'group' => array('Content|Batches:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch/batch_del_form_data.php'
			)
		)
	),
	"admin/batch/group/quick/add" => array(
		'controller' => 'backend\controllers\batch\BatchController',
		'method' => 'addBatchGroup',
		'desc' => 'Add Batch',
		'group' => array('Content|Batches:add', 'Content|Batches:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/batch/batch_add_batch_group_form_data.php'
			)
		)
	),
	// End Batch manage
	// Starts Customer Type manage
	/*
		"admin/customer/type/list" => array (
				'controller' => 'backend\controllers\customer\CustomerTypeController',
				'method' => 'listView',
				'desc' => 'Customer Type Manage',
				'group' => array (),
				'results' => array (
						'success' => array (
								'type' => 'include',
								'path' => 'admin/customer/customer_type/customer_type_list.php'
						)
				)
		),
		"admin/customer/type/search" => array (
				'controller' => 'backend\controllers\customer\CustomerTypeController',
				'method' => 'search',
				'desc' => 'Search Customer Type',
				'group' => '',
				'results' => array (
						'success' => array (
								'type' => 'include',
								'path' => 'admin/customer/customer_type/customer_type_list_data.php'
						)
				)
		),
		"admin/customer/type/edit/view" => array (
				'controller' => 'backend\controllers\customer\CustomerTypeController',
				'method' => 'editView',
				'desc' => 'View Edit Customer Type',
				'group' => '',
				'results' => array (
						'success' => array (
								'type' => 'include',
								'path' => 'admin/customer/customer_type/customer_type_edit_view_data.php'
						)
				)
		),
		"admin/customer/type/edit" => array (
				'controller' => 'backend\controllers\customer\CustomerTypeController',
				'method' => 'edit',
				'desc' => 'Edit Customer Type',
				'group' => '',
				'results' => array (
						'success' => array (
								'type' => 'include',
								'path' => 'admin/customer/customer_type/customer_type_edit_form_data.php'
						)
				)
		),

		"admin/customer/type/add/view" => array (
				'controller' => 'backend\controllers\customer\CustomerTypeController',
				'method' => 'addView',
				'desc' => 'View Add Customer Type',
				'group' => '',
				'results' => array (
						'success' => array (
								'type' => 'include',
								'path' => 'admin/customer/customer_type/customer_type_add_view_data.php'
						)
				)
		),

		"admin/customer/type/add" => array (
				'controller' => 'backend\controllers\customer\CustomerTypeController',
				'method' => 'add',
				'desc' => 'Add Customer Type',
				'group' => '',
				'results' => array (
						'success' => array (
								'type' => 'include',
								'path' => 'admin/customer/customer_type/customer_type_add_form_data.php'
						)
				)
		),

		"admin/customer/type/del/view" => array (
				'controller' => 'backend\controllers\customer\CustomerTypeController',
				'method' => 'delView',
				'desc' => 'View Del Customer Type',
				'group' => '',
				'results' => array (
						'success' => array (
								'type' => 'include',
								'path' => 'admin/customer/customer_type/customer_type_del_view_data.php'
						)
				)
		),

		"admin/customer/type/del" => array (
				'controller' => 'backend\controllers\customer\CustomerTypeController',
				'method' => 'del',
				'desc' => 'Delete Customer Type',
				'group' => '',
				'results' => array (
						'success' => array (
								'type' => 'include',
								'path' => 'admin/customer/customer_type/customer_type_del_form_data.php'
						)
				)
		),
		*/
	// End Customer Type manage

	// Starts Customer manage
	"admin/customer/list" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'listView',
		'desc' => 'Customer Manage',
		'group' => array('Store|Customers:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_list.php'
			)
		)
	),
	"admin/customer/search" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'search',
		'desc' => 'Search Customer',
		'group' => array('Store|Customers:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_list_data.php'
			)
		)
	),
	"admin/customer/edit/view" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'editView',
		'desc' => 'View Edit Customer',
		'group' => array('Store|Customers:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_edit_view_data.php'
			)
		)
	),
	"admin/customer/edit" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'edit',
		'desc' => 'Edit Customer',
		'group' => array('Store|Customers:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_edit_form_data.php'
			)
		)
	),

	"admin/customer/add/view" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'addView',
		'desc' => 'View Add Customer',
		'group' => array('Store|Customers:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_add_view_data.php'
			)
		)
	),

	"admin/customer/add" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'add',
		'desc' => 'Add Customer',
		'group' => array('Store|Customers:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_add_form_data.php'
			)
		)
	),

	"admin/customer/del/view" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'delView',
		'desc' => 'View Del Customer',
		'group' => array('Store|Customers:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_del_view_data.php'
			)
		)
	),

	"admin/customer/del" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'del',
		'desc' => 'Delete Customer',
		'group' => array('Store|Customers:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_del_form_data.php'
			)
		)
	),
	"admin/customer/copy/view" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'copyView',
		'desc' => 'View Copy Customer',
		'group' => array('Store|Customers:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_copy_view_data.php'
			)
		)
	),
	"admin/customer/copy" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'copy',
		'desc' => 'Copy Customer',
		'group' => array('Store|Customers:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_copy_form_data.php'
			)
		)
	),
	"admin/customer/export" => array(
		'controller' => 'backend\controllers\customer\CustomerController',
		'method' => 'exportCSV',
		'desc' => 'Export Customer',
		'group' => array('Store|Customers:view'),
		'results' => array(
			'success' => array(
				'type' => 'stream',
				'input' => 'fullPathFile',
				'output' => 'fileNameDownload',
				'params' => array(
					'Content-Type' => 'text/csv; charset=utf-8',
					'Content-Disposition' => 'attachment; filename=#{fileNameDownload}',
					'Set-Cookie' => ' fileDownload=true; path=/'
				)
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_list.php'
			)
		)
	),
	"admin/customer/address/view" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'listView',
		'desc' => 'View Address',
		'group' => array('Store|Customers:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/customer_address_view_data.php'
			)
		)
	),
	// End Customer manage
	// Begin category.
	"admin/category/list" => array(
		'controller' => 'backend\controllers\product\CategoryController',
		'method' => 'listView',
		'desc' => 'List category groups',
		'group' => array('Product|Categories:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category/category_list.php'
			)
		)
	),
	"admin/category/search" => array(
		'controller' => 'backend\controllers\product\CategoryController',
		'method' => 'search',
		'desc' => 'Search category groups',
		'group' => array('Product|Categories:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category/category_list_data.php'
			)
		)
	),
	"admin/category/add/view" => array(
		'controller' => 'backend\controllers\product\CategoryController',
		'method' => 'addView',
		'desc' => 'Show add category form',
		'group' => array('Product|Categories:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category/category_add_view.php'
			)
		)
	),
	"admin/category/add" => array(
		'controller' => 'backend\controllers\product\CategoryController',
		'method' => 'add',
		'desc' => 'Add category group',
		'group' => array('Product|Categories:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category/category_add_form_data.php'
			)
		)
	),
	"admin/category/edit/view" => array(
		'controller' => 'backend\controllers\product\CategoryController',
		'method' => 'editView',
		'desc' => 'Show edit category form',
		'group' => array('Product|Categories:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category/category_edit_view.php'
			)
		)
	),
	"admin/category/edit" => array(
		'controller' => 'backend\controllers\product\CategoryController',
		'method' => 'edit',
		'desc' => 'Edit category group',
		'group' => array('Product|Categories:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category/category_edit_form_data.php'
			)
		)
	),
	"admin/category/copy/view" => array(
		'controller' => 'backend\controllers\product\CategoryController',
		'method' => 'copyView',
		'desc' => 'Show copy category form',
		'group' => array('Product|Categories:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category/category_copy_view.php'
			)
		)
	),
	"admin/category/copy" => array(
		'controller' => 'backend\controllers\product\CategoryController',
		'method' => 'copy',
		'desc' => 'Copy category group',
		'group' => array('Product|Categories:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category/category_copy_form_data.php'
			)
		)
	),
	"admin/category/del/view" => array(
		'controller' => 'backend\controllers\product\CategoryController',
		'method' => 'delView',
		'desc' => 'Delete category view',
		'group' => array('Product|Categories:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category/category_del_view_data.php'
			)
		)
	),
	"admin/category/del" => array(
		'controller' => 'backend\controllers\product\CategoryController',
		'method' => 'del',
		'desc' => 'Delete category group',
		'group' => array('Product|Categories:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category/category_del_res_data.php'
			)
		)
	),
	// End category


	// Begin category_blog Blog.
	"admin/category/blog/list" => array(
		'controller' => 'backend\controllers\blog\CategoryBlogController',
		'method' => 'listView',
		'desc' => 'List category_blog groups',
		'group' => array('Content|CategoryBlog:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category_blog/category_blog_list.php'
			)
		)
	),
	"admin/category/blog/search" => array(
		'controller' => 'backend\controllers\blog\CategoryBlogController',
		'method' => 'search',
		'desc' => 'Search category_blog groups',
		'group' => array('Content|CategoryBlog:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category_blog/category_blog_list_data.php'
			)
		)
	),
	"admin/category/blog/add/view" => array(
		'controller' => 'backend\controllers\blog\CategoryBlogController',
		'method' => 'addView',
		'desc' => 'Show add category_blog form',
		'group' => array('Content|CategoryBlog:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category_blog/category_blog_add_view.php'
			)
		)
	),
	"admin/category/blog/add" => array(
		'controller' => 'backend\controllers\blog\CategoryBlogController',
		'method' => 'add',
		'desc' => 'Add category_blog group',
		'group' => array('Content|CategoryBlog:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category_blog/category_blog_add_form_data.php'
			)
		)
	),
	"admin/category/blog/edit/view" => array(
		'controller' => 'backend\controllers\blog\CategoryBlogController',
		'method' => 'editView',
		'desc' => 'Show edit category_blog form',
		'group' => array('Content|CategoryBlog:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category_blog/category_blog_edit_view.php'
			)
		)
	),
	"admin/category/blog/edit" => array(
		'controller' => 'backend\controllers\blog\CategoryBlogController',
		'method' => 'edit',
		'desc' => 'Edit category_blog group',
		'group' => array('Content|CategoryBlog:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category_blog/category_blog_edit_form_data.php'
			)
		)
	),
	"admin/category/blog/copy/view" => array(
		'controller' => 'backend\controllers\blog\CategoryBlogController',
		'method' => 'copyView',
		'desc' => 'Show copy category_blog form',
		'group' => array('Content|CategoryBlog:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category_blog/category_blog_copy_view.php'
			)
		)
	),
	"admin/category/blog/copy" => array(
		'controller' => 'backend\controllers\blog\CategoryBlogController',
		'method' => 'copy',
		'desc' => 'Copy category_blog group',
		'group' => array('Content|CategoryBlog:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category_blog/category_blog_copy_form_data.php'
			)
		)
	),
	"admin/category/blog/del/view" => array(
		'controller' => 'backend\controllers\blog\CategoryBlogController',
		'method' => 'delView',
		'desc' => 'Delete category_blog view',
		'group' => array('Content|CategoryBlog:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category_blog/category_blog_del_view_data.php'
			)
		)
	),
	"admin/category/blog/del" => array(
		'controller' => 'backend\controllers\blog\CategoryBlogController',
		'method' => 'del',
		'desc' => 'Delete category_blog group',
		'group' => array('Content|CategoryBlog:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/category_blog/category_blog_del_res_data.php'
			)
		)
	),
//END category_blog Blog


	// Begin region.
	"admin/region/list" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'listView',
		'desc' => 'List regions',
		'group' => array('Store|Region:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_list.php'
			)
		)
	),
	"admin/region/search" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'search',
		'desc' => 'Search regions',
		'group' => array('Store|Region:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_list_data.php'
			)
		)
	),
	"admin/region/add/view" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'addView',
		'desc' => 'Show add region dialog',
		'group' => array('Store|Region:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_add_view.php'
			)
		)
	),
	"admin/region/add" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'add',
		'desc' => 'Add region',
		'group' => array('Store|Region:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_add_res_data.php'
			)
		)
	),
	"admin/region/country/add" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'addRegionCountry',
		'desc' => 'Add region country',
		'group' => array('Store|Region:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/location/region_location_success_data.php'
			)
		)
	),
	"admin/region/edit/view" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'editView',
		'desc' => 'Show edit region dialog',
		'group' => array('Store|Region:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_edit_view.php'
			)
		)
	),
	"admin/region/edit" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'edit',
		'desc' => 'Edit region',
		'group' => array('Store|Region:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_edit_res_data.php'
			)
		)
	),
	"admin/region/copy/view" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'copyView',
		'desc' => 'Show copy region dialog',
		'group' => array('Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_copy_view.php'
			)
		)
	),
	"admin/region/copy" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'copy',
		'desc' => 'Copy region',
		'group' => array('Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_copy_res_data.php'
			)
		)
	),
	"admin/region/del/view" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'delView',
		'desc' => 'Show delete region dialog',
		'group' => array('Store|Region:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_del_view_data.php'
			)
		)
	),
	"admin/region/del" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'del',
		'desc' => 'Delete region',
		'group' => array('Store|Region:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_del_res_data.php'
			)
		)
	),
	"admin/region/addtoedit" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'addToEdit',
		'desc' => 'Add region',
		'group' => array('Store|Region:add', 'Store|Region:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_add_res_data.php'
			)
		)
	),
	"admin/region/edittoedit" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'addToEdit',
		'desc' => 'Edit region',
		'group' => array('Store|Region:add', 'Store|Region:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_edit_res_data.php'
			)
		)
	),
	"admin/region/copytoedit" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'addToEdit',
		'desc' => 'Copy region',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/region_copy_res_data.php'
			)
		)
	),
	"admin/region/state/add/get" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'getStates',
		'desc' => 'Get state belong to country',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/location/region_location_state_add_res_data.php'
			)
		)
	),
	"admin/region/state/edit/get" => array(
		'controller' => 'backend\controllers\region\RegionController',
		'method' => 'getEditState',
		'desc' => 'Get state belong to country',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/location/region_location_state_edit_res_data.php'
			)
		)
	),
	// End region.

	// Begin region shipping method config.
	"admin/flat/rate/setting/edit/view" => array(
		'controller' => 'backend\controllers\region\FlatRateSettingController',
		'method' => 'editView',
		'desc' => 'Show region shipping method config edit dialog',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/shipping_method/config/flat_rate/flat_rate_config_edit_view_data.php'
			)
		)
	),
	"admin/flat/rate/setting/edit" => array(
		'controller' => 'backend\controllers\region\FlatRateSettingController',
		'method' => 'edit',
		'desc' => 'Save region shipping method config',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/shipping_method/config/flat_rate/flat_rate_config_edit_form_data.php'
			)
		)
	),
	"admin/flat/rate/template/add" => array(
		'controller' => 'backend\controllers\region\FlatRateSettingController',
		'method' => 'addShippingMethodRow',
		'desc' => 'Add shipping method row',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/shipping_method/config/flat_rate/flat_rate_config_edit_form_data.php'
			)
		)
	),
	"admin/flat/rate/template/remove" => array(
		'controller' => 'backend\controllers\region\FlatRateSettingController',
		'method' => 'removeShippingMethodRow',
		'desc' => 'Remove shipping method row',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/shipping_method/config/flat_rate/flat_rate_config_edit_form_data.php'
			)
		)
	),
	"admin/zone/table/setting/edit/view" => array(
		'controller' => 'backend\controllers\region\ZoneTableSettingController',
		'method' => 'editView',
		'desc' => 'Show region shipping method config edit dialog',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/shipping_method/config/zone_table/zone_table_config_edit_view_data.php'
			)
		)
	),
	"admin/zone/table/setting/edit" => array(
		'controller' => 'backend\controllers\region\ZoneTableSettingController',
		'method' => 'edit',
		'desc' => 'Save region shipping method config',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/shipping_method/config/zone_table/zone_table_config_edit_form_data.php'
			)
		)
	),
	"admin/zone/table/template/add" => array(
		'controller' => 'backend\controllers\region\ZoneTableSettingController',
		'method' => 'addShippingMethodRow',
		'desc' => 'Add shipping method row',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/shipping_method/config/zone_table/zone_table_config_edit_form_data.php'
			)
		)
	),
	"admin/zone/table/template/remove" => array(
		'controller' => 'backend\controllers\region\ZoneTableSettingController',
		'method' => 'removeShippingMethodRow',
		'desc' => 'Remove shipping method row',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/shipping_method/config/zone_table/zone_table_config_edit_form_data.php'
			)
		)
	),
	// End region shipping method config.

	// Begin region payment method config.
	"admin/bank/transfer/setting/edit/view" => array(
		'controller' => 'backend\controllers\payment\BankTranferSettingController',
		'method' => 'editView',
		'desc' => 'Show region payment method config edit dialog',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/payment_method/bank_transfer/bank_transfer_config_edit_view_data.php'
			)
		)
	),
	"admin/bank/transfer/setting/edit" => array(
		'controller' => 'backend\controllers\payment\BankTranferSettingController',
		'method' => 'edit',
		'desc' => 'Save region payment method config',
		'group' => array('Store|Region:add', 'Store|Region:edit', 'Store|Region:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/region/payment_method/bank_transfer/bank_transfer_config_edit_form_data.php'
			)
		)
	),
	// End region payment method config.
	// Starts Tax Rate manage
	"admin/tax/rate/list" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'listView',
		'desc' => 'Tax Rate Manage',
		'group' => array('System|Tax Rates:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_list.php'
			)
		)
	),
	"admin/tax/rate/search" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'search',
		'desc' => 'Search Tax Rate',
		'group' => array('System|Tax Rates:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_list_data.php'
			)
		)
	),
	"admin/tax/rate/edit/view" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'editView',
		'desc' => 'View Edit Tax Rate',
		'group' => array('System|Tax Rates:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_edit_view_data.php'
			)
		)
	),
	"admin/tax/rate/edit" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'edit',
		'desc' => 'Edit Tax Rate',
		'group' => array('System|Tax Rates:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_edit_form_data.php'
			)
		)
	),

	"admin/tax/rate/add/view" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'addView',
		'desc' => 'View Add Tax Rate',
		'group' => array('System|Tax Rates:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_add_view_data.php'
			)
		)
	),

	"admin/tax/rate/add" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'add',
		'desc' => 'Add Tax Rate',
		'group' => array('System|Tax Rates:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_add_form_data.php'
			)
		)
	),

	"admin/tax/rate/del/view" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'delView',
		'desc' => 'View Del Tax Rate',
		'group' => array('System|Tax Rates:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_del_view_data.php'
			)
		)
	),

	"admin/tax/rate/del" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'del',
		'desc' => 'Delete Tax Rate',
		'group' => array('System|Tax Rates:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_del_form_data.php'
			)
		)
	),
	"admin/tax/rate/copy/view" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'copyView',
		'desc' => 'View Copy Tax Rate',
		'group' => array('System|Tax Rates:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_copy_view_data.php'
			)
		)
	),
	"admin/tax/rate/copy" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'copy',
		'desc' => 'Copy Tax Rate',
		'group' => array('System|Tax Rates:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_copy_form_data.php'
			)
		)
	),
	"admin/tax/rate/export" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'exportCSV',
		'desc' => 'Export Tax Rate',
		'group' => array('System|Tax Rates:view'),
		'results' => array(
			'success' => array(
				'type' => 'stream',
				'output' => 'fileNameDownload',
				'params' => array(
					'Content-Type' => 'text/csv; charset=utf-8',
					'Content-Disposition' => 'attachment; filename=#{fileNameDownload}',
					'Set-Cookie' => ' fileDownload=true; path=/'
				)
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_list.php'
			)
		)
	),
	// End Tax Rate manage
	// Begin tax shipping zone.
	"admin/tax/shipping/zone/list" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'listView',
		'desc' => 'List tax shipping zone groups',
		'group' => array('System|Tax & Shipping Zones::view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_list.php'
			)
		)
	),
	"admin/tax/shipping/zone/search" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'search',
		'desc' => 'Search tax_shipping_zone groups',
		'group' => array('System|Tax & Shipping Zones:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_list_data.php'
			)
		)
	),
	"admin/tax/shipping/zone/add/view" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'addView',
		'desc' => 'Show add tax_shipping_zone form',
		'group' => array('System|Tax & Shipping Zones:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_add_view_data.php'
			)
		)
	),
	"admin/tax/shipping/zone/add" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'add',
		'desc' => 'Add tax_shipping_zone group',
		'group' => array('System|Tax & Shipping Zones:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_add_form_data.php'
			)
		)
	),
	"admin/tax/shipping/zone/edit/view" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'editView',
		'desc' => 'Show edit tax_shipping_zone form',
		'group' => array('System|Tax & Shipping Zones:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_edit_view_data.php'
			)
		)
	),
	"admin/tax/shipping/zone/edit" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'edit',
		'desc' => 'Edit tax_shipping_zone group',
		'group' => array('System|Tax & Shipping Zones:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_edit_form_data.php'
			)
		)
	),
	"admin/tax/shipping/zone/copy/view" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'copyView',
		'desc' => 'Show copy tax_shipping_zone form',
		'group' => array('System|Tax & Shipping Zones:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_copy_view_data.php'
			)
		)
	),
	"admin/tax/shipping/zone/copy" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'copy',
		'desc' => 'Copy tax_shipping_zone group',
		'group' => array('System|Tax & Shipping Zones:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_copy_form_data.php'
			)
		)
	),
	"admin/tax/shipping/zone/del/view" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'delView',
		'desc' => 'Delete tax_shipping_zone view',
		'group' => array('System|Tax & Shipping Zones:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_del_view_data.php'
			)
		)
	),
	"admin/tax/shipping/zone/del" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'del',
		'desc' => 'Delete tax shipping zone group',
		'group' => array('System|Tax & Shipping Zones:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_del_res_data.php'
			)
		)
	),
	"admin/tax/shipping/zone/get/state" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'getState',
		'desc' => 'get state by country id',
		'group' => array('System|Tax & Shipping Zones:view', 'System|Tax & Shipping Zones:add', 'System|Tax & Shipping Zones:copy', 'System|Tax & Shipping Zones:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/state_view_data.php'
			)
		)
	),
	"admin/tax/shipping/zone/info/add/view" => array(
		'controller' => 'backend\controllers\tax_shipping_zone\TaxShippingZoneController',
		'method' => 'addTaxShippingZoneInfoView',
		'desc' => 'View Add Tax Shipping Zone Info',
		'group' => array('System|Tax & Shipping Zones:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax_shipping_zone/tax_shipping_zone_info/tax_shipping_zone_info_add_success_data.php'
			)
		)
	),
	// End tax shipping zone
	"admin/tax/rate/info/add/view" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'addTaxInfoView',
		'desc' => 'View Add Tax Info',
		'group' => array('System|Tax Rates:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_info/tax_rate_info_add_success_data.php'
			)
		)
	),
	"admin/tax/rate/info/dynamic/add/view" => array(
		'controller' => 'backend\controllers\tax\TaxRateController',
		'method' => 'addTaxInfoView',
		'desc' => 'View Add Tax Dynamic',
		'group' => array('System|Tax Rates:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/tax/tax_rate/tax_rate_info/tax_rate_dynamic_add_success_data.php'
			)
		)
	),
	// Starts Address manage
	"admin/address/list" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'listView',
		'desc' => 'Address Manage',
		'group' => array('Store|Customers:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_list_data.php'
			)
		)
	),
	"admin/address/search" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'search',
		'desc' => 'Search Address',
		'group' => array('Store|Customers:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_list_data.php'
			)
		)
	),
	"admin/address/edit/view" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'editView',
		'desc' => 'View Edit Address',
		'group' => array('Store|Customers:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_edit_view_data.php'
			)
		)
	),
	"admin/address/edit" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'edit',
		'desc' => 'Edit Address',
		'group' => array('Store|Customers:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_edit_form_data.php'
			)
		)
	),

	"admin/address/add/view" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'addView',
		'desc' => 'View Add Address',
		'group' => array('Store|Customers:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_add_view_data.php'
			)
		)
	),

	"admin/address/add" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'add',
		'desc' => 'Add Address',
		'group' => array('Store|Customers:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_add_form_data.php'
			)
		)
	),

	"admin/address/del/view" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'delView',
		'desc' => 'View Del Address',
		'group' => array('Store|Customers:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_del_view_data.php'
			)
		)
	),

	"admin/address/del" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'del',
		'desc' => 'Delete Address',
		'group' => array('Store|Customers:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_del_form_data.php'
			)
		)
	),
	"admin/address/copy/view" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'copyView',
		'desc' => 'View Copy Address',
		'group' => array('Store|Customers:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_copy_view_data.php'
			)
		)
	),
	"admin/address/copy" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'copy',
		'desc' => 'Copy Address',
		'group' => array('Store|Customers:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_copy_form_data.php'
			)
		)
	),
	"admin/address/export" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'exportCSV',
		'desc' => 'Export Address',
		'group' => array('Store|Customers:view'),
		'results' => array(
			'success' => array(
				'type' => 'stream',
				'output' => 'fileNameDownload',
				'params' => array(
					'Content-Type' => 'text/csv; charset=utf-8',
					'Content-Disposition' => 'attachment; filename=#{fileNameDownload}',
					'Set-Cookie' => ' fileDownload=true; path=/'
				)
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/address_list.php'
			)
		)
	),
	"admin/address/country/change" => array(
		'controller' => 'backend\controllers\address\AddressController',
		'method' => 'changeCountry',
		'desc' => 'Change Country Address',
		'group' => array('Store|Customers:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/customer/customer/address/state_list_data.php'
			)
		)
	),
	// End Address manage
	// Begin order .
	"admin/order/list" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'listView',
		'desc' => 'List order ',
		'group' => array('Store|Orders:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_list.php'
			)
		)
	),
	"admin/order/search" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'search',
		'desc' => 'Search order ',
		'group' => array('Store|Orders:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_list_data.php'
			)
		)
	),
	"admin/order/edit" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'edit',
		'desc' => 'edit ',
		'group' => array('Store|Orders:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_detail_row_bill_ship_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_detail_row_bill_ship_data.php'
			),
		)
	),
	"admin/order/refund" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'refund',
		'desc' => 'Order Refund ',
		'group' => array('Store|Orders:refund'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_detail.php'
			)
		)
	),
	"admin/order/change/order/status" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'changeOrderStatus',
		'desc' => 'Change order status',
		'group' => array('Store|Orders:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_list_change_order_status_data.php'
			)
		)
	),
	"admin/order/change/shipping/status" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'changeShippingStatus',
		'desc' => 'Change shipping status',
		'group' => array('Store|Orders:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_list_change_shipping_status_data.php'
			)
		)
	),
	"admin/order/del/view" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'delView',
		'desc' => 'Delete order view',
		'group' => array('Store|Orders:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_del_view_data.php'
			)
		)
	),
	"admin/order/del" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'del',
		'desc' => 'Delete order ',
		'group' => array('Store|Orders:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_del_res_data.php'
			)
		)
	),
	"admin/order/detail/view" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'detailView',
		'desc' => 'Delete order ',
		'group' => array('Store|Orders:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_detail.php'
			)
		)
	),
	"admin/order/detail/get/state" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'getStateByCountry',
		'desc' => 'get state by country ',
		'group' => array('Store|Orders:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/state_view_data.php'
			)
		)
	),
	"admin/order/check/erdt" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'checkERDT',
		'desc' => 'tick ERDT',
		'group' => array('Store|Orders:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_check_erdt_data.php'
			)
		)
	),
	"admin/order/uncheck/erdt" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'uncheckERDT',
		'desc' => 'untick ERDT',
		'group' => array('Store|Orders:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/order/order/order_check_erdt_data.php'
			)
		)
	),
	"admin/order/pdf" => array(
		'controller' => 'backend\controllers\order\OrderController',
		'method' => 'pdfOrder',
		'desc' => 'View Order PDF',
		'group' => array('Store|Orders:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => ''
			)
		)
	),
	// End order

	// Begin url redirect.
	"admin/url/redirect/list" => array(
		'controller' => 'backend\controllers\url_redirect\UrlRedirectController',
		'method' => 'listView',
		'desc' => 'List url redirects',
		'group' => array('Content|URL Redirects:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/url_redirect/url_redirect_list.php'
			)
		)
	),
	"admin/url/redirect/search" => array(
		'controller' => 'backend\controllers\url_redirect\UrlRedirectController',
		'method' => 'search',
		'desc' => 'Search url redirects',
		'group' => array('Content|URL Redirects:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/url_redirect/url_redirect_list_data.php'
			)
		)
	),
	"admin/url/redirect/add/view" => array(
		'controller' => 'backend\controllers\url_redirect\UrlRedirectController',
		'method' => 'addView',
		'desc' => 'Show add url redirect dialog',
		'group' => array('Content|URL Redirects:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/url_redirect/url_redirect_add_view_data.php'
			)
		)
	),
	"admin/url/redirect/add" => array(
		'controller' => 'backend\controllers\url_redirect\UrlRedirectController',
		'method' => 'add',
		'desc' => 'Add url redirect',
		'group' => array('Content|URL Redirects:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/url_redirect/url_redirect_add_res_data.php'
			)
		)
	),
	"admin/url/redirect/edit/view" => array(
		'controller' => 'backend\controllers\url_redirect\UrlRedirectController',
		'method' => 'editView',
		'desc' => 'Show edit url redirect dialog',
		'group' => array('Content|URL Redirects:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/url_redirect/url_redirect_edit_view_data.php'
			)
		)
	),
	"admin/url/redirect/edit" => array(
		'controller' => 'backend\controllers\url_redirect\UrlRedirectController',
		'method' => 'edit',
		'desc' => 'Edit url redirect',
		'group' => array('Content|URL Redirects:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/url_redirect/url_redirect_edit_res_data.php'
			)
		)
	),
	"admin/url/redirect/copy/view" => array(
		'controller' => 'backend\controllers\url_redirect\UrlRedirectController',
		'method' => 'copyView',
		'desc' => 'Show copy url redirect dialog',
		'group' => array('Content|URL Redirects:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/url_redirect/url_redirect_copy_view_data.php'
			)
		)
	),
	"admin/url/redirect/copy" => array(
		'controller' => 'backend\controllers\url_redirect\UrlRedirectController',
		'method' => 'copy',
		'desc' => 'Copy url redirect',
		'group' => array('Content|URL Redirects:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/url_redirect/url_redirect_copy_res_data.php'
			)
		)
	),
	"admin/url/redirect/del/view" => array(
		'controller' => 'backend\controllers\url_redirect\UrlRedirectController',
		'method' => 'delView',
		'desc' => 'Show delete url redirect dialog',
		'group' => array('Content|URL Redirects:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/url_redirect/url_redirect_del_view_data.php'
			)
		)
	),
	"admin/url/redirect/del" => array(
		'controller' => 'backend\controllers\url_redirect\UrlRedirectController',
		'method' => 'del',
		'desc' => 'Delete url redirect',
		'group' => array('Content|URL Redirects:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/url_redirect/url_redirect_del_res_data.php'
			)
		)
	),
	// End url redirect.

	// Begin contact.
	"admin/contact/list" => array(
		'controller' => 'backend\controllers\contact\ContactController',
		'method' => 'listView',
		'desc' => 'List contacts',
		'group' => array('Store|Contacts:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/contact/contact_list.php'
			)
		)
	),
	"admin/contact/search" => array(
		'controller' => 'backend\controllers\contact\ContactController',
		'method' => 'search',
		'desc' => 'Search contacts',
		'group' => array('Store|Contacts:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/contact/contact_list_data.php'
			)
		)
	),
	"admin/contact/detail/view" => array(
		'controller' => 'backend\controllers\contact\ContactController',
		'method' => 'detailView',
		'desc' => 'Show detail contact dialog',
		'group' => array('Store|Contacts:detail'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/contact/contact_detail_view_data.php'
			)
		)
	),
	"admin/contact/del/view" => array(
		'controller' => 'backend\controllers\contact\ContactController',
		'method' => 'delView',
		'desc' => 'Show delete contact dialog',
		'group' => array('Store|Contacts:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/contact/contact_del_view_data.php'
			)
		)
	),
	"admin/contact/del" => array(
		'controller' => 'backend\controllers\contact\ContactController',
		'method' => 'del',
		'desc' => 'Delete contact',
		'group' => array('Store|Contacts:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/contact/contact_del_res_data.php'
			)
		)
	),
	// End contact.
	"erdt/upload" => array(
		'controller' => 'backend\controllers\erdt\ErdtController',
		'method' => 'erdtUpload',
		'desc' => 'ERDT upload',
		'group' => array(),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => ''
			)
		)
	),
	"dk/export" => array(
		'controller' => 'backend\controllers\erdt\ErdtController',
		'method' => 'erdtExport',
		'desc' => 'ERDT Export',
		'group' => array("Store|DK Export:view"),
		'results' => array(
			'success' => array(
				'type' => 'stream',
				'input' => 'inputFilePath',
				'output' => 'outputFileName',
				'params' => array(
					'Content-Type' => 'text/csv; charset=utf-8',
					'Content-Disposition' => 'attachment; filename=#{outputFileName}'
				)
			)
		),
	),

	"admin/piwik" => array(
		'controller' => 'fake',
		'method' => 'fake',
		'desc' => 'Admin Piwik',
		'group' => array("Piwik|Piwik:edit"),
	),
	"admin/page/raw/content" => array(
		'controller' => 'backend\controllers\page\PageContentController',
		'method' => 'generateRawContent',
		'desc' => 'generate raw Content',
		'group' => array(""),
	),
	"admin/page/raw/content/form" => array(
		'controller' => 'backend\controllers\page\PageContentController',
		'method' => 'generateRawContentForm',
		'desc' => 'generate raw Content form',
		'group' => array(""),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/page/page_raw_content_form.php'
			)
		)
	),
	// Begin sales report action.
	"admin/sales/report" => array(
		'controller' => 'backend\controllers\sales_report\SalesReportController',
		'method' => 'show',
		'desc' => 'Sales report page',
		'group' => array("Store|Sales Report:view"),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/sales_report/sales_report.php'
			)
		)
	),
	"admin/sales/report/export" => array(
		'controller' => 'backend\controllers\sales_report\SalesReportController',
		'method' => 'export',
		'desc' => 'Export sales report page',
		'group' => array("Store|Sales Report:view"),
		'results' => array(
			'success' => array(
				'type' => 'stream',
				'input' => 'inputFilePath',
				'output' => 'outputFileName',
				'params' => array(
					'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8',
					'Content-Disposition' => 'attachment; filename=#{outputFileName}'
				)
			)
		)
//        'results' => array(
//            'input' => array(
//                'type' => 'include',
//                'path' => 'admin/sales_report/sales_report.php'
//            ),
//            'success' => array(
//                'type' => 'include',
//                'path' => 'admin/sales_report/export_sales_report.php'
//            )
//        )
	),
	// End sales report action.
	//block email
	"admin/block/email/list" => array(
		'controller' => 'backend\controllers\block_email\BlockEmailController',
		'method' => 'listView',
		'desc' => 'Block email',
		'group' => array('System|Block Email:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/block_email/block_email_list.php'
			)
		)
	),
	"admin/block/email/search" => array(
		'controller' => 'backend\controllers\block_email\BlockEmailController',
		'method' => 'search',
		'desc' => 'block email',
		'group' => array('System|Block Email:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/block_email/block_email_list_data.php'
			)
		)
	),
	"admin/block/email/add/view" => array(
		'controller' => 'backend\controllers\block_email\BlockEmailController',
		'method' => 'addView',
		'desc' => 'Add block email',
		'group' => array('System|Block Email:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/block_email/block_email_add_view_data.php'
			)
		)
	),
	"admin/block/email/add" => array(
		'controller' => 'backend\controllers\block_email\BlockEmailController',
		'method' => 'add',
		'desc' => 'Add block email',
		'group' => array('System|Block Email:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/block_email/block_email_add_res_data.php'
			)
		)
	),
	"admin/block/email/copy/view" => array(
		'controller' => 'backend\controllers\block_email\BlockEmailController',
		'method' => 'copyView',
		'desc' => 'Clone block email',
		'group' => array('System|Block Email:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/block_email/block_email_copy_view_data.php'
			)
		)
	),
	"admin/block/email/copy" => array(
		'controller' => 'backend\controllers\block_email\BlockEmailController',
		'method' => 'copy',
		'desc' => 'Clone block email',
		'group' => array('System|Block Email:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/block_email/block_email_copy_res_data.php'
			)
		)
	),
	"admin/block/email/edit/view" => array(
		'controller' => 'backend\controllers\block_email\BlockEmailController',
		'method' => 'editView',
		'desc' => 'Edit block email',
		'group' => array('System|Block Email:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/block_email/block_email_edit_view_data.php'
			)
		)
	),
	"admin/block/email/edit" => array(
		'controller' => 'backend\controllers\block_email\BlockEmailController',
		'method' => 'edit',
		'desc' => 'Edit block email',
		'group' => array('System|Block Email:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/block_email/block_email_edit_res_data.php'
			)
		)
	),
	"admin/block/email/del/view" => array(
		'controller' => 'backend\controllers\block_email\BlockEmailController',
		'method' => 'delView',
		'desc' => 'Delete block email',
		'group' => array('System|Block Email:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/block_email/block_email_del_view_data.php'
			)
		)
	),
	"admin/block/email/del" => array(
		'controller' => 'backend\controllers\block_email\BlockEmailController',
		'method' => 'del',
		'desc' => 'Delete block email',
		'group' => array('System|Block Email:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/block_email/block_email_del_res_data.php'
			)
		)
	),
	// End Order Status
	// Trustpilot
	"trustpilot" => array(
		'controller' => 'backend\controllers\trustpilot\TrustpilotController',
		'method' => 'trustpilot',
		'desc' => 'Trustpilot',
		'group' => array(),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/trustpilot/trustpilot_view.php'
			)
		)
	),
	// End Trustpilot
	//Blog Manage
	//add multi file for product

	"admin/blog/list" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'listView',
		'desc' => 'List Blog',
		'group' => array('Content|Blogs:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_list.php'
			)
		)
	),
	"admin/blog/search" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'search',
		'desc' => 'Search Blog',
		'group' => array('Content|Blogs:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_list_data.php'
			)
		)
	),
	"admin/blog/add/view" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'addView',
		'desc' => 'Add Blog',
		'group' => array('Content|Blogs:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_add_view.php'
			)
		)
	),
	"admin/blog/add" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'add',
		'desc' => 'Add Blog',
		'group' => array('Content|Blogs:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_add_res_data.php'
			)
		)
	),
	"admin/blog/addtoedit" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'addToEdit',
		'desc' => 'Add Blog',
		'group' => array('Content|Blogs:add', 'Blog|Blogs:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_add_res_data.php'
			)
		)
	),
	"admin/blog/edit/view" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'editView',
		'desc' => 'Edit Blog',
		'group' => array('Content|Blogs:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_edit_view.php'
			)
		)
	),
	"admin/blog/edit" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'edit',
		'desc' => 'Edit Blog',
		'group' => array('Content|Blogs:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_edit_res_data.php'
			)
		)
	),
	"admin/blog/edittoclose" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'editToClose',
		'desc' => 'Edit Blog',
		'group' => array('Content|Blogs:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_edit_res_data.php'
			)
		)
	),
	"admin/blog/del/view" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'delView',
		'desc' => 'Delete View Blog',
		'group' => array('Content|Blogs:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_del_view_data.php'
			)
		)
	),
	"admin/blog/del" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'del',
		'desc' => 'Delete Blog',
		'group' => array('Content|Blogs:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_del_res_data.php'
			)
		)
	),
	"admin/blog/copy/view" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'copyView',
		'desc' => 'Copy Blog',
		'group' => array('Content|Blogs:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_copy_view.php'
			)
		)
	),
	"admin/blog/copy" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'copy',
		'desc' => 'Copy Blog',
		'group' => array('Content|Blogs:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_copy_res_data.php'
			)
		)
	),
	"admin/blog/copytoclose" => array(
		'controller' => 'backend\controllers\blog\BlogController',
		'method' => 'copyToClose',
		'desc' => 'Copy Blog',
		'group' => array('Content|Blogs:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/blog/blog_copy_res_data.php'
			)
		)
	),
	//End blog Manage

	// Start Slide

	// Starts Slide Group manage
	"admin/slide/group/list" => array(
		'controller' => 'backend\controllers\slide_group\SlideGroupController',
		'method' => 'listView',
		'desc' => 'Slide Group Manage',
		'group' => array('Content|Slides:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide_group/slide_group_list.php'
			)
		)
	),
	"admin/slide/group/search" => array(
		'controller' => 'backend\controllers\slide_group\SlideGroupController',
		'method' => 'search',
		'desc' => 'Search Slide Group',
		'group' => array('Content|Slides:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide_group/slide_group_list_data.php'
			)
		)
	),
	"admin/slide/group/edit/view" => array(
		'controller' => 'backend\controllers\slide_group\SlideGroupController',
		'method' => 'editView',
		'desc' => 'View Edit Slide Group',
		'group' => array('Content|Slides:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide_group/slide_group_edit_view_data.php'
			)
		)
	),
	"admin/slide/group/edit" => array(
		'controller' => 'backend\controllers\slide_group\SlideGroupController',
		'method' => 'edit',
		'desc' => 'Edit Slide Group',
		'group' => array('Content|Slides:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide_group/slide_group_edit_form_data.php'
			)
		)
	),

	"admin/slide/group/add/view" => array(
		'controller' => 'backend\controllers\slide_group\SlideGroupController',
		'method' => 'addView',
		'desc' => 'View Add Slide Group',
		'group' => array('Content|Slides:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide_group/slide_group_add_view_data.php'
			)
		)
	),

	"admin/slide/group/add" => array(
		'controller' => 'backend\controllers\slide_group\SlideGroupController',
		'method' => 'add',
		'desc' => 'Add Slide Group',
		'group' => array('Content|Slides:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide_group/slide_group_add_form_data.php'
			)
		)
	),

	"admin/slide/group/del/view" => array(
		'controller' => 'backend\controllers\slide_group\SlideGroupController',
		'method' => 'delView',
		'desc' => 'View Del Slide Group',
		'group' => array('Content|Slides:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide_group/slide_group_del_view_data.php'
			)
		)
	),

	"admin/slide/group/del" => array(
		'controller' => 'backend\controllers\slide_group\SlideGroupController',
		'method' => 'del',
		'desc' => 'Delete Slide Group',
		'group' => array('Content|Slides:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide_group/slide_group_del_form_data.php'
			)
		)
	),
	"admin/slide/group/copy/view" => array(
		'controller' => 'backend\controllers\slide_group\SlideGroupController',
		'method' => 'copyView',
		'desc' => 'View Copy Slide Group',
		'group' => array('Content|Slides:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide_group/slide_group_copy_view_data.php'
			)
		)
	),

	"admin/slide/group/copy" => array(
		'controller' => 'backend\controllers\slide_group\SlideGroupController',
		'method' => 'copy',
		'desc' => 'Copy Slide Group',
		'group' => array('Content|Slides:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide_group/slide_group_copy_form_data.php'
			)
		)
	),
	// End Slide Group manage

	// Starts Slide manage
	"admin/slide/list" => array(
		'controller' => 'backend\controllers\slide\SlideController',
		'method' => 'listView',
		'desc' => 'Slide Manage',
		'group' => array('Content|Slides:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide/slide_list.php'
			)
		)
	),
	"admin/slide/search" => array(
		'controller' => 'backend\controllers\slide\SlideController',
		'method' => 'search',
		'desc' => 'Search Slide',
		'group' => array('Content|Slides:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide/slide_list_data.php'
			)
		)
	),
	"admin/slide/edit/view" => array(
		'controller' => 'backend\controllers\slide\SlideController',
		'method' => 'editView',
		'desc' => 'View Edit Slide',
		'group' => array('Content|Slides:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide/slide_edit_view_data.php'
			)
		)
	),
	"admin/slide/edit" => array(
		'controller' => 'backend\controllers\slide\SlideController',
		'method' => 'edit',
		'desc' => 'Edit Slide',
		'group' => array('Content|Slides:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide/slide_edit_form_data.php'
			)
		)
	),

	"admin/slide/add/view" => array(
		'controller' => 'backend\controllers\slide\SlideController',
		'method' => 'addView',
		'desc' => 'View Add Slide',
		'group' => array('Content|Slides:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide/slide_add_view_data.php'
			)
		)
	),

	"admin/slide/add" => array(
		'controller' => 'backend\controllers\slide\SlideController',
		'method' => 'add',
		'desc' => 'Add Slide',
		'group' => array('Content|Slides:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide/slide_add_form_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/slide/result_upload/slide_list_data.php'
			)
		)
	),

	"admin/slide/confirm" => array(
		'controller' => 'backend\controllers\slide\SlideController',
		'method' => 'confirmUpload',
		'desc' => 'Confirm Upload Slide',
		'group' => array('Content|Slides:add', 'Content|Slides:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide/slide_add_form_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/slide/result_upload/slide_list_data.php'
			)
		)
	),

	"admin/slide/del/view" => array(
		'controller' => 'backend\controllers\slide\SlideController',
		'method' => 'delView',
		'desc' => 'View Del Slide',
		'group' => array('Content|Slides:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide/slide_del_view_data.php'
			)
		)
	),

	"admin/slide/del" => array(
		'controller' => 'backend\controllers\slide\SlideController',
		'method' => 'del',
		'desc' => 'Delete Slide',
		'group' => array('Content|Slides:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide/slide_del_form_data.php'
			)
		)
	),
	"admin/slide/group/quick/add" => array(
		'controller' => 'backend\controllers\slide\SlideController',
		'method' => 'addSlideGroup',
		'desc' => 'Add Slide',
		'group' => array('Content|Slides:add', 'Content|Slides:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/slide/slide_add_slide_group_form_data.php'
			)
		)
	),
	// End Slide manage
	// End Slide

	// Starts Manufacture manage
	"admin/manufacture/list" => array(
		'controller' => 'backend\controllers\manufacture\ManufactureController',
		'method' => 'listView',
		'desc' => 'Manufacture Manage',
		'group' => array('Content|Manufacturees:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/manufacture/manufacture_list.php'
			)
		)
	),
	"admin/manufacture/search" => array(
		'controller' => 'backend\controllers\manufacture\ManufactureController',
		'method' => 'search',
		'desc' => 'Search Manufacture',
		'group' => array('Content|Manufacturees:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/manufacture/manufacture_list_data.php'
			)
		)
	),
	"admin/manufacture/edit/view" => array(
		'controller' => 'backend\controllers\manufacture\ManufactureController',
		'method' => 'editView',
		'desc' => 'View Edit Manufacture',
		'group' => array('Content|Manufacturees:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/manufacture/manufacture_edit_view_data.php'
			)
		)
	),
	"admin/manufacture/edit" => array(
		'controller' => 'backend\controllers\manufacture\ManufactureController',
		'method' => 'edit',
		'desc' => 'Edit Manufacture',
		'group' => array('Content|Manufacturees:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/manufacture/manufacture_edit_form_data.php'
			)
		)
	),

	"admin/manufacture/add/view" => array(
		'controller' => 'backend\controllers\manufacture\ManufactureController',
		'method' => 'addView',
		'desc' => 'View Add Manufacture',
		'group' => array('Content|Manufacturees:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/manufacture/manufacture_add_view_data.php'
			)
		)
	),

	"admin/manufacture/add" => array(
		'controller' => 'backend\controllers\manufacture\ManufactureController',
		'method' => 'add',
		'desc' => 'Add Manufacture',
		'group' => array('Content|Manufacturees:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/manufacture/manufacture_add_form_data.php'
			)
		)
	),

	"admin/manufacture/confirm" => array(
		'controller' => 'backend\controllers\manufacture\ManufactureController',
		'method' => 'confirmUpload',
		'desc' => 'Confirm Upload Manufacture',
		'group' => array('Content|Manufacturees:add', 'Content|Manufacturees:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/manufacture/manufacture_add_form_data.php'
			),
			'error' => array(
				'type' => 'include',
				'path' => 'admin/manufacture/result_upload/manufacture_list_data.php'
			)
		)
	),

	"admin/manufacture/del/view" => array(
		'controller' => 'backend\controllers\manufacture\ManufactureController',
		'method' => 'delView',
		'desc' => 'View Del Manufacture',
		'group' => array('Content|Manufacturees:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/manufacture/manufacture_del_view_data.php'
			)
		)
	),

	"admin/manufacture/del" => array(
		'controller' => 'backend\controllers\manufacture\ManufactureController',
		'method' => 'del',
		'desc' => 'Delete Manufacture',
		'group' => array('Content|Manufacturees:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/manufacture/manufacture_del_form_data.php'
			)
		)
	),
	// End Manufacture manage
	// End Manufacture

	// ATTRIBUTE GROUP
	"admin/attribute/group/list" => array(
		'controller' => 'backend\controllers\attribute_group\AttributeGroupController',
		'method' => 'listView',
		'desc' => 'list Attr Group',
		'group' => array('AttrGroup|AttrGroups:list'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute_group/attribute_group_list.php'
			)
		)
	),
	"admin/attribute/group/search" => array(
		'controller' => 'backend\controllers\attribute_group\AttributeGroupController',
		'method' => 'listView',
		'desc' => 'search Attr Group',
		'group' => array('AttrGroup|AttrGroups:search'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute_group/attribute_group_list_data.php'
			)
		)
	),
	"admin/attribute/group/edit/view" => array(
		'controller' => 'backend\controllers\attribute_group\AttributeGroupController',
		'method' => 'editView',
		'desc' => 'View Edit Attr Group',
		'group' => array('AttrGroup|AttrGroups:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute_group/attribute_group_edit_view_data.php'
			)
		)
	),
	"admin/attribute/group/edit" => array(
		'controller' => 'backend\controllers\attribute_group\AttributeGroupController',
		'method' => 'edit',
		'desc' => 'Edit Attr Group',
		'group' => array('AttrGroup|AttrGroups:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute_group/attribute_group_edit_form_data.php'
			)
		)
	),

	"admin/attribute/group/add/view" => array(
		'controller' => 'backend\controllers\attribute_group\AttributeGroupController',
		'method' => 'addView',
		'desc' => 'View Add Attr Group',
		'group' => array('AttrGroup|AttrGroups:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute_group/attribute_group_add_view_data.php'
			)
		)
	),

	"admin/attribute/group/add" => array(
		'controller' => 'backend\controllers\attribute_group\AttributeGroupController',
		'method' => 'add',
		'desc' => 'Add Attr Group',
		'group' => array('AttrGroup|AttrGroups:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute_group/attribute_group_add_form_data.php'
			)
		)
	),

	"admin/attribute/group/del/view" => array(
		'controller' => 'backend\controllers\attribute_group\AttributeGroupController',
		'method' => 'delView',
		'desc' => 'View Del Attr Group',
		'group' => array('AttrGroup|AttrGroups:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute_group/attribute_group_del_view_data.php'
			)
		)
	),

	"admin/attribute/group/del" => array(
		'controller' => 'backend\controllers\attribute_group\AttributeGroupController',
		'method' => 'del',
		'desc' => 'Delete Attr Group',
		'group' => array('AttrGroup|AttrGroups:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute_group/attribute_group_del_form_data.php'
			)
		)
	),
	"admin/attribute/group/copy/view" => array(
		'controller' => 'backend\controllers\attribute_group\AttributeGroupController',
		'method' => 'copyView',
		'desc' => 'View Copy Attr Group',
		'group' => array('AttrGroup|AttrGroups:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute_group/attribute_group_copy_view_data.php'
			)
		)
	),
	"admin/attribute/group/copy" => array(
		'controller' => 'backend\controllers\attribute_group\AttributeGroupController',
		'method' => 'copy',
		'desc' => 'Copy Attr Group',
		'group' => array('AttrGroup|AttrGroups:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute_group/attribute_group_copy_form_data.php'
			)
		)
	),

	// ATTRIBUTE
	"admin/attribute/list" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'listView',
		'desc' => 'Attribute',
		'group' => array('Attribute|Attributes:list'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_list.php'
			)
		)
	),

	"admin/attribute/search" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'listView',
		'desc' => 'search Attribute',
		'group' => array('Attribute|Attributes:search'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_list_data.php'
			)
		)
	),
	"admin/attribute/edit/view" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'editView',
		'desc' => 'View Edit Attribute',
		'group' => array('Attribute|Attributes:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_edit_view_data.php'
			)
		)
	),
	"admin/attribute/edit" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'edit',
		'desc' => 'Edit Attribute',
		'group' => array('Attribute|Attributes:edit'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_edit_form_data.php'
			)
		)
	),

	"admin/attribute/add/view" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'addView',
		'desc' => 'View Add Attribute',
		'group' => array('Attribute|Attributes:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_add_view_data.php'
			)
		)
	),

	"admin/attribute/add" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'add',
		'desc' => 'Add Attribute',
		'group' => array('Attribute|Attributes:add'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_add_form_data.php'
			)
		)
	),

	"admin/attribute/del/view" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'delView',
		'desc' => 'View Del Attribute',
		'group' => array('Attribute|Attributes:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_del_view_data.php'
			)
		)
	),

	"admin/attribute/del" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'del',
		'desc' => 'Delete Attribute',
		'group' => array('Attribute|Attributes:del'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_del_form_data.php'
			)
		)
	),


	"admin/attribute/remove/view" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'removeView',
		'desc' => 'View Remove Attribute',
		'group' => array('Attribute|Attributes:remove'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_remove_view_data.php'
			)
		)
	),

	"admin/attribute/remove" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'remove',
		'desc' => 'Remove Attribute',
		'group' => array('Attribute|Attributes:remove'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_remove_form_data.php'
			)
		)
	),

	"admin/attribute/set/view" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'setView',
		'desc' => 'View Set Attribute',
		'group' => array('Attribute|Attributes:set'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_set_view_data.php'
			)
		)
	),

	"admin/attribute/set" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'setAttribute',
		'desc' => 'Set Attribute',
		'group' => array('Attribute|Attributes:set'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_set_form_data.php'
			)
		)
	),

	"admin/attribute/copy/view" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'copyView',
		'desc' => 'View Copy Attribute',
		'group' => array('Attribute|Attributes:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_copy_view_data.php'
			)
		)
	),
	"admin/attribute/copy" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'copy',
		'desc' => 'Copy Attribute',
		'group' => array('Attribute|Attributes:copy'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/attribute_copy_form_data.php'
			)
		)
	),
	"admin/product/attribute/select" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'selectAttribute',
		'desc' => 'Select Attribute',
		'group' => array('Attribute|Attributes:select'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/product/product_attribute_update_data.php'
			)
		)
	),
	"admin/product/attribute/update" => array(
		'controller' => 'backend\controllers\attribute\AttributeController',
		'method' => 'updateProductAttribute',
		'desc' => 'Update Product Attribute',
		'group' => array('Attribute|Attributes:select'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/attribute/product/product_attribute_update_data.php'
			)
		)
	),
	"admin/shipping/shipchung/tracking" => array(
		'controller' => 'backend\controllers\shipchung\TrackingController',
		'method' => 'tracking',
		'desc' => 'Shipchung',
		'group' => array('Shipping|Shipchung:view'),
		'results' => array(
			'success' => array(
				'type' => 'include',
				'path' => 'admin/shipchung/shipchung_list.php'
			)
		)
	),
);