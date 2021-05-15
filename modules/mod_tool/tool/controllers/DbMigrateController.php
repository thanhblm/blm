<?php

namespace tool\controllers;

use common\persistence\base\dao\CategoryBaseDao;
use common\persistence\base\dao\CategoryLangBaseDao;
use common\persistence\base\dao\ProductBaseDao;
use common\persistence\base\dao\ProductLangBaseDao;
use common\persistence\base\dao\SeoInfoLangBaseDao;
use common\persistence\base\vo\CategoryLangVo;
use common\persistence\base\vo\CategoryVo;
use common\persistence\base\vo\ProductVo;
use common\persistence\base\vo\SeoInfoLangVo;
use core\config\ApplicationConfig;
use core\Controller;
use core\utils\FileUploadUtil;
use filemanager\persistence\base\vo\ImageVo;
use filemanager\services\filemanager\ImageService;
use filemanager\utils\FileManagerHelper;
use common\persistence\base\vo\ProductLangVo;
use core\utils\AppUtil;
use common\persistence\base\dao\RegionBaseDao;
use common\persistence\base\vo\RegionVo;
use common\persistence\base\vo\ProductRegionVo;
use common\persistence\base\dao\ProductRegionBaseDao;
use common\persistence\base\dao\EmailTemplateBaseDao;
use common\persistence\base\dao\EmailTemplateLangBaseDao;
use common\persistence\base\vo\EmailTemplateVo;
use common\persistence\base\vo\EmailTemplateLangVo;
use common\persistence\base\vo\ProductPriceVo;
use common\persistence\base\dao\ProductPriceBaseDao;
use common\persistence\base\dao\CustomerBaseDao;
use common\persistence\base\vo\CustomerVo;

class DbMigrateController extends Controller {
	private $targetDbName = 'endoca';
	public function __construct() {
	}
	public function endocaDbMigrate() {
		ini_set ( 'max_execution_time', 300 );
		$host = ApplicationConfig::get ( "db.host" );
		$user = ApplicationConfig::get ( "db.username" );
		$pass = ApplicationConfig::get ( "db.password" );
		$dbName = "endoca_purl";
		$connection = new \mysqli ( $host, $user, $pass, $dbName );
		$connection->set_charset ( "utf8" );
		
		$connection->query ( "DROP PROCEDURE IF EXISTS $this->targetDbName.reset_autoincrement;" );
		$connection->query ( "
				CREATE DEFINER=`root`@`localhost` PROCEDURE $this->targetDbName.`reset_autoincrement`(IN tableName varchar(255))
				BEGIN
				set @qry1 = concat('SELECT MAX(id)+ 1 FROM ',tableName,' INTO @ai');
				PREPARE stmt1 FROM @qry1;
				EXECUTE stmt1;
				
				set @qry2 = concat('ALTER TABLE ',tableName,' AUTO_INCREMENT = ', @ai);
				PREPARE stmt2 FROM @qry2;
				EXECUTE stmt2;
				SELECT @ai, tableName, @qry2;
				END;
				" );
	}
	
	public function endocaDbMigrate1() {
		ini_set ( 'max_execution_time', 300 );
		$host = ApplicationConfig::get ( "db.host" );
		$user = ApplicationConfig::get ( "db.username" );
		$pass = ApplicationConfig::get ( "db.password" );
		$dbName = "endoca_purl";
		$connection = new \mysqli ( $host, $user, $pass, $dbName );
		$connection->set_charset ( "utf8" );
		
		$connection->query ( "DROP PROCEDURE IF EXISTS $this->targetDbName.reset_autoincrement;" );
		$connection->query ( "
				CREATE DEFINER=`root`@`localhost` PROCEDURE $this->targetDbName.`reset_autoincrement`(IN tableName varchar(255))
				BEGIN
				set @qry1 = concat('SELECT MAX(id)+ 1 FROM ',tableName,' INTO @ai');
				PREPARE stmt1 FROM @qry1;
				EXECUTE stmt1;
				
				set @qry2 = concat('ALTER TABLE ',tableName,' AUTO_INCREMENT = ', @ai);
				PREPARE stmt2 FROM @qry2;
				EXECUTE stmt2;
				SELECT @ai, tableName, @qry2;
				END;
				" );
		
		
		echo  "image ";
		// 		$connection->query ( "truncate table $this->targetDbName.image" );
		\DatoLogUtil::info ( "Migrate Discount Coupon" );
		$this->migrateDiscountCoupon( $connection );
		
		\DatoLogUtil::info ( "Migrate Bulk Discount" );
		$this->migrateBulkDiscount($connection );
		
		\DatoLogUtil::info ( "Migrate Bulk Discount Product" );
		$this->migrateBulkDiscountProduct( $connection );
		
		
		// 		\DatoLogUtil::info ( "Migrate ShippingStatus" );
		// 		$this->migrateShippingStatus ( $connection );
		
		// 		\DatoLogUtil::info ( "Migrate OrderStatus" );
		// 		$this->migrateOrderStatus ( $connection );
		
		\DatoLogUtil::info ( "Migrate PriceLevel" );
		$this->migratePriceLevel ( $connection );
		
		\DatoLogUtil::info ( "Migrate Subscriber" );
		$this->migrateSubscriber ( $connection );
		
		\DatoLogUtil::info ( "Migrate Customer" );
		$this->migrateCustomer ( $connection );
		
		\DatoLogUtil::info ( "Migrate Address" );
		$this->migrateAddress ( $connection );
		
		// 		\DatoLogUtil::info ( "Migrate Administrator" );
		// 		$this->migrateUsers ( $connection );
		
		// 		\DatoLogUtil::info ( "Migrate User Group" );
		// 		$this->migrateUserGroups ( $connection );
		
		// 		\DatoLogUtil::info ( "Migrate Language" );
		// 		$this->migrateLanguage ( $connection );
		
		// 		\DatoLogUtil::info ( "Migrate Currency" );
		// 		$this->migrateCurrency ( $connection );
		
		// 		\DatoLogUtil::info ( "Migrate Region" );
		// 		$this->migrateRegion ( $connection );
		
		// 		\DatoLogUtil::info ( "Migrate Email Template" );
		// 		$this->migrateEmailTemplate ( $connection );
		
		
		// 		\DatoLogUtil::info ( "Migrate Category" );
		// 		$this->migrateCategory ( $connection );
		
// 		\DatoLogUtil::info ( "Migrate Product" );
// 		$this->migrateProduct ( $connection );
		
		\DatoLogUtil::info ( "Migrate Order" );
		$this->migrateOrder( $connection );
		
		\DatoLogUtil::info ( "Migrate Order Product" );
		$this->migrateOrderProduct( $connection );
		
		\DatoLogUtil::info ( "Migrate Order History" );
		$this->migrateOrderHistory($connection );
		
		\DatoLogUtil::info ( "Migrate Order Total" );
		$this->migrateOrderTotal($connection );
		
		\DatoLogUtil::info ( "Migrate Order Refund" );
		$this->migrateOrderRefund($connection );
		
		
		\DatoLogUtil::info ( "Migrate Order Shipping Info" );
		$this->migrateOrderShipingInfo($connection );
		
		
		//$this->updateImageAutoId($connection);
		
		$this->migrateBatch($connection);
		$this->migrateBatchFile($connection);
		\DatoLogUtil::info ( "Migrate Done!" );
		
		echo "<br> ----------------------------------------------------------- <br>";
		echo "<br> Note : make sure: <br>
					1.  order status have unsuccessful credit status <br>
					2.  manual modify localtion, shiping method, payment method for region <br>
					3.  manual insert extra email_template, email_template_lang  then run update auto auto-increment email_template procedure <br>
					4.  Make sure taxable goods id is 2, shipping tax id  is 1 as in app_config  <br>
		";
		return null;
	}
	
	private function migrateBatch($connection) {
		echo "`batch` ";
		$connection->query ( "truncate table  `$this->targetDbName`.`batch`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`batch`
				(id,`title`, `status`, `file_name`, `batch_group_id`, `cr_date`, `cr_by`, `md_date`, `md_by`) 
					select 
					b.id, 
					b.`name` as `title`, 
					case b.`hidden` when 1 then 'inactive' else 'active' end as `status`,
					f.filename as `file_name`, 
					1 as `batch_group_id`, 
					c.date_added as `cr_date`, 
					'0' as `cr_by`, 
					c.date_modified, 
					0  as `md_by` 
					from endoca_purl.batch b 
					inner join endoca_purl.`file` f on b.`file` = f.id
					left join endoca_purl.content c
					on b.id = c.id");
		
		$this->updateAutoIncrement ( "`$this->targetDbName`.`batch`" );
	}
	
	private function migrateBatchFile($connection) {
		echo 'batch files ';
		$result = $connection->query ( "select * from endoca_purl.`file`" );
		$orgDir = "D:".DS."Working".DS."Workspace".DS."pproject".DS."endoca_com".DS."var".DS."files";
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			$fileId = $row ["id"];
			$fileName = $row ["filename"];
			$source = $orgDir.DS.$fileId.DS."content";
			$dest = "D:".DS."Working".DS."Workspace".DS."pproject".DS."endoca".DS."uploads".DS."batchs".DS."1".DS.$fileName;
			copy($source, $dest);
			echo "<br> source: ".$source;
			echo "<br> dest: ".$dest;
		}
	}
	
	private function migrateOrderStatus($connection) {
		echo "order_status ";
		$connection->query ( "truncate table `$this->targetDbName`.`order_status`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`order_status` (`id`,`name`,`status`,`description`) VALUES (1,'Pending','active',NULL);" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`order_status` (`id`,`name`,`status`,`description`) VALUES (2,'Paid','active',NULL);" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`order_status` (`id`,`name`,`status`,`description`) VALUES (3,'Canceled','active',NULL);" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`order_status` (`id`,`name`,`status`,`description`) VALUES (4,'Refunded','active',NULL);" );
		$this->updateAutoIncrement ( "`$this->targetDbName`.`order_status`" );
	}
	
	
	private function migrateOrder($connection) {
		echo "`order` ";
		$connection->query ( "truncate table  `$this->targetDbName`.`order`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`order`
								(`id`,
				`mega_id`,	
 				`order_status_id`,
				`shipping_status_id`,
				`currency_code`,
				`region_id`,
				`language_code`,
				`payment_method`,
				`shipping_method`,
                `shipping_method_item`,
				`date`,
                `coupon_code`,
                `customer_id`,
                `price_level`,
                `customer_firstname`,
				`customer_lastname`,
				`customer_company`,
				`customer_phone`,
				`customer_email`,
				`ship_first_name`,
				`ship_last_name`,
				`ship_email`,
				`ship_phone`,
				`ship_address`,
				`ship_city`,
				`ship_zipcode`,
				`ship_state_code`,
				`ship_country_code`,
				`bill_first_name`,
				`bill_last_name`,
				`bill_email`,
				`bill_phone`,
				`bill_address`,
				`bill_city`,
				`bill_zipcode`,
				`bill_state_code`,
				`bill_country_code`,
				`admin_comment`,
				`customer_comment`,
				`invoice_comment`,
				`cr_date`,
				`cr_by`,
				`md_date`,
				`md_by`)
				select  
					o.`id` as `id`,
                    endoca_id as `mega_id`,
					
					case `status` when 15 then 1
								  when 16 then 2
					              when 17 then 4
					              when 7324 then 3
								  else `status` end  as `order_status_id`,
					case `status_ship` when 'sending' then 4
								  when 'finished' then 5
					              when 'deleted' then 5
					              else 1 end  
								  as `shipping_status_id`, 
					currency as `currency_code`,
					region as `region_id`,
					`language` as `language_code`,
					payment_method as `payment_method`, 
					ot.title as  `shipping_method`,
                    ot.subtitle as  `shipping_method_item`,
					date_added as `date`,
                    '' as `coupon_code`,
                    user_id as `customer_id`,
                    '' as price_level,
					user_firstname as `customer_firstname`,
					user_lastname as `customer_lastname`,
					user_company as `customer_company`,
					user_phone as `customer_phone`,
					user_email as `customer_email`,
					ship_firstname as `ship_first_name`,
					ship_lastname as `ship_last_name`,
					ship_email as `ship_email`,
					ship_phone as `ship_phone`,
					ship_address as `ship_address`,
					ship_city as `ship_city`,
					ship_zip as `ship_zipcode`,
					ship_state as `ship_state_code`,
					ship_country as `ship_country_code`,
					bill_firstname as `bill_first_name`,
					bill_lastname as `bill_last_name`,
					bill_email as `bill_email`,
					bill_phone as `bill_phone`,
					bill_address as `bill_address`,
					bill_city as `bill_city`,
					bill_zip as `bill_zipcode`,
					bill_state as `bill_state_code`,
					bill_country as `bill_country_code`,
					admin_comment as `admin_comment`,
					user_comment as `customer_comment`,
					invoice_comment as `invoice_comment`,
					date_added as `cr_date`,
					0  as `cr_by`,
					date_modified as `md_date`,
					0 as `md_by`
					from endoca_purl.`order`  o
					left join endoca_purl.content  c on o.id = c.id
					left join (select c.pid, ot.* from endoca_purl.ordertotal ot  inner join endoca_purl.content c on c.id = ot.id  where ot.type = 'shipping') ot on ot.pid = c.id 
					order by o.id desc");
		
		$connection->query ( "update `$this->targetDbName`.`order` set  currency_code  = 'EUR' where (currency_code = '' or currency_code is null) and region_id = 4429;");
		$connection->query ( "update `$this->targetDbName`.`order` set currency_code  = 'USD' where (currency_code = '' or currency_code is null) and region_id <> 4429;");
		$this->updateCrMdDate("`$this->targetDbName`.`order`");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`order`" );
	}
	
	
	private function migrateOrderProduct($connection) {
		echo "order_product ";
		$connection->query ( "truncate table  `$this->targetDbName`.`order_product`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`order_product`
				(`order_id`,
				`product_id`,
				`name`,
				`quantity`,
				`base_price`,
				`price`,
				`discount`,
				`tax`)
				select 
				c.pid as `order_id`,
				op.product_id as `product_id`,
				op.`name` as `name`,
				sum(op.quantity) as `quantity`,
				op.price_base as `base_price`,
				op.price as `price`,
				op.discount as `discount`,
				op.tax_rate as `tax`
				from endoca_purl.orderproduct op
				inner join endoca_purl.content c on c.id = op.id
				group by c.pid,op.product_id 
				" );
		//$this->updateAutoIncrement ( "`$this->targetDbName`.`order_product`" );
	}

	private function migrateOrderShipingInfo($connection) {
		echo "order_shiping_info ";
		$connection->query ( "truncate table  `$this->targetDbName`.`order_shiping_info`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`order_shiping_info`
						(`order_id`,
						`ship_by`,
						`ship_date`,
						`tracking_code`,
						`txn_id`,
						`secret`)
						select 
						id as `order_id`,
						'shiprush' as `ship_by`,
						date_shiprush as `ship_date`,
						'' as `tracking_code`,
						shiprush_id as `txn_id`,
						secret as `secret`
						from endoca_purl.order o where shiprush_id <> '' 
						union
						select 
						id as `order_id`,
						'erdt' as `ship_by`,
						date_erdt as `ship_date`,
						'' as `tracking_code`,
						'' as `txn_id`,
						'' as `secret`
						from endoca_purl.order o where date_erdt is not null and erdt_send = 1 ;
				" );
	}
	
	private function migrateOrderTotal($connection) {
		echo "order_total ";
		$connection->query ( "truncate table  `$this->targetDbName`.`order_total`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`order_total`
				(`id`,
				`order_id`,
				`type`,
				`title`,
				`subtitle`,
				`value`)
				select 
				ot.id as `id`,
				c.pid as `order_id`,
				ot.`type`,
				ot.`title`,
				ot.`subtitle`,
				ot.`value`
				from endoca_purl.ordertotal ot inner join endoca_purl.content c on ot.id = c.id and c.section = 'OrderTotal'
				");
		$connection->query ( "update `$this->targetDbName`.`order` o set coupon_code =  ifnull((select ot.subtitle from `$this->targetDbName`.order_total ot where ot.`type` = 'coupon' and ot.order_id = o.id limit 0,1 ),'')");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`order_total`" );
	}
	
	private function migrateOrderHistory($connection) {
		echo "order_history ";
		$connection->query ( "truncate table  `$this->targetDbName`.`order_history`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`order_history`
				(`id`,
				`order_id`,
				`status`,
				`description`,
				`cus_notified`,
				`cr_date`,
				`cr_by`)
				select 
				oh.id as `id`,
				c.pid as `order_id`,
				case `status` when 15 then 1
								  when 16 then 2
					              when 17 then 4
					              when 7324 then 3
								  else `status` end  as `status`,
				comment as `description`,
				case `user_notified` when 1 then 'yes' else 'no' end as `cus_notified`,
				c.date_added as `cr_date`,
				'0' as `cr_by`
				from endoca_purl.orderhistory oh inner join endoca_purl.content c on c.id = oh.id and section = 'OrderHistory'
				");
		$this->updateCrMdDate( "`$this->targetDbName`.`order_history`" );
		$this->updateAutoIncrement ( "`$this->targetDbName`.`order_history`" );
	}
	
	private function migrateOrderRefund($connection) {
		echo "order_refund ";
		$connection->query ( "truncate table  `$this->targetDbName`.`order_refund`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`order_refund`
				(
					`order_id`,
					`order_history_id`,
					`amount`,
					`cr_by`,
					`cr_date`
					)
					select  c.pid as `order_id`,t1.ohd_id as `order_history_id`,  t1.amount as `amount`, '0' as `cr_by`, t1.date_added as `cr_date` from 
					(select oh.id as oh_id, ohd.id as ohd_id, ohd.`value` as amount, c.date_added from endoca_purl.orderhistorydetail ohd 
					inner join  endoca_purl.content c on c.id = ohd.id and ohd.key = 'PURL.Balance'
					inner join endoca_purl.orderhistory oh on oh.id = c.pid and oh.status = 17
					) as t1
					inner join  endoca_purl.content c on c.id = t1.oh_id 
					order by t1.oh_id desc
					");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`order_refund`" );
	}
	
	private function migrateDiscountCoupon($connection) {
		echo "discount_coupon ";
		$connection->query ( "truncate table  `$this->targetDbName`.`discount_coupon`" );
		$connection->query ( "truncate table  `$this->targetDbName`.`discount_coupon_product`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`discount_coupon`
				(`id`,
				`code`,
				`name`,
				`discount`,
				`status`,
				`min_order_total`,
				`valid_from`,
				`valid_to`,
				`max_use`,
				`use_per_customer`,
				`user_per_product`,
				`cr_by`,
				`cr_date`,
				`md_by`,
				`md_date`)
				select 
				`id`,
				code as `code`,
				title as `name`,
				substring_index(`value`,'%', 1)  as `discount`,
				case `status` when 1 then 'active' else 'inactive' end as `status`, 
				min_order_total as `min_order_total`,
				valid_from as `valid_from`,
				valid_to as `valid_to`,
				uses_per_coupon as `max_use`,
				uses_per_user as `use_per_customer`,
				'any_product' as `user_per_product`,
				0 as `cr_by`,
				now() as `cr_date`,
				0 as `md_by`,
				now() as `md_date`
				 from 
				(SELECT 
				    d.*,
				    dc.code
				FROM
				    `discountcoupon` d
				        JOIN
				    content dc ON dc.id = d.id
				        AND dc.section = 'DiscountCoupon'
				        LEFT JOIN
				    contentpid dp ON dp.id = d.id AND dp.pid = 0
				        LEFT JOIN
				    `discountcoupon_lng` dl ON d.id = dl.id AND dl.lang = 1
				WHERE
				    dc.ref = '' AND dc.pid = 0) R	
				 " );
		$this->updateCrMdDate("`$this->targetDbName`.`discount_coupon`");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`discount_coupon`" );
	}
	
	private function updateCrMdDate($tableName){
		$host = ApplicationConfig::get ( "db.host" );
		$user = ApplicationConfig::get ( "db.username" );
		$pass = ApplicationConfig::get ( "db.password" );
		$dbName = "endoca_purl";
		$connection = new \mysqli ( $host, $user, $pass, $dbName );
		$connection->set_charset ( "utf8" );
		$connection->query ("update $tableName src set
		cr_date = IFNULL((select date_added from endoca_purl.content c where src.id = c.id),now()),
		md_date = IFNULL((select date_modified from endoca_purl.content c where src.id = c.id),now())"); 
	}
	
	private function migrateBulkDiscount($connection) {
		echo "bulk_discount ";
		$connection->query ( "truncate table  `$this->targetDbName`.`bulk_discount`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`bulk_discount`
				(`id`,
					`name`,
					`status`,
					`discount`,
					`valid_from`,
					`valid_to`,
					`cr_date`,
					`cr_by`,
					`md_date`,
					`md_by`)
					select
					`id`,
					title as `name`,
					case `status` when 1 then 'active' else 'inactive' end as `status`, 
					discount as `discount`,
					valid_from as `valid_from`,
					valid_to as `valid_to`,
					now() as `cr_date`,
					0 as `cr_by`,
					now() as `md_date`,
					0 as `md_by`
					from 
					endoca_purl.bulkdiscount" );
		$this->updateCrMdDate("`$this->targetDbName`.`bulk_discount`");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`bulk_discount`" );
	}
	
	private function migrateBulkDiscountProduct($connection) {
		echo "bulk_discount_product ";
		$connection->query ( "truncate table  `$this->targetDbName`.`bulk_discount_product`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`bulk_discount_product`
				(`bulk_discount_id`,
				`product_id`,
				`quantity`)
				select 
				R.pid as `bulk_discount_id`,
				R.product as `product_id`,
				R.quantity as `quantity`
				from 
				(SELECT 
				  dc.pid, d.product, d.quantity
				FROM
				    `productspecialentry` d
				    JOIN content dc ON d.id = dc.id
				WHERE
				    dc.section = 'ProductSpecialEntry'
				        AND dc.ref = '') R" );
		//$this->updateAutoIncrement ( "`$this->targetDbName`.`bulk_discount_product`" );
	}
	
	
	private function migrateAddress($connection) {
		echo "address ";
		$connection->query ( "truncate table  `$this->targetDbName`.`address`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`address`
								(`id`,
								`first_name`,
								`last_name`,
								`address`,
								`country`,
								`city`,
								`state`,
								`postal_code`,
								`phone`,
								`latitude`,
								`longitude`,
								`email`,
								`type`,
								`group_id`,
								`cr_date`,
								`cr_by`,
								`md_date`,
								`md_by`)
								select
								`id`,
								firstname as `first_name`,
								lastname as `last_name`,
								address as `address`,
								country_id as `country`,
								`city`,
								state_id as `state`,
								zip as `postal_code`,
								phone as `phone`,
								lat as `latitude`,
								lng as `longitude`,
								`email`,
								2 as `type`,
								customer_id as `group_id`,
								now() as `cr_date`,
								0 as `cr_by`,
								now() as `md_date`,
								0 `md_by`
								from
								(select
								ac.pid as customer_id,
								s.id as state_id,
								c.id as country_id,
								a.* from (endoca_purl.`address` a join endoca_purl.content ac on a.id=ac.id left join endoca_purl.`geostate` s on s.iso2 = substring_index(a.state,':', 1) and s.country_iso = a.country left join endoca_purl.geocountry c on c.iso2 = a.country )  order by a.id) as R" );
		$this->updateCrMdDate("`$this->targetDbName`.`address`");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`address`" );
	}
	private function migratePriceLevel($connection) {
		echo "price_level ";
		$connection->query ( "truncate table `$this->targetDbName`.`price_level`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`price_level`
				(`id`,
				`name`,
				`value`,
				`cr_date`,
				`cr_by`,
				`md_date`,
				`md_by`)
				VALUES(
				0,
				'Retail',
				0 ,
				now() ,
				0 ,
				now(),
				0
				);" );
		$connection->query ( "update `$this->targetDbName`.`price_level`
				set id = 0 where id = 1" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`price_level`
							(`id`,
							`name`,
							`value`,
							`cr_date`,
							`cr_by`,
							`md_date`,
							`md_by`)
							select 
							`id`,
							`name`,
							`discount` as `value`,
							now() as `cr_date`,
							0 as `cr_by`,
							now() as `md_date`,
							0 as `md_by`
							from endoca_purl.pricelevel;" );
		$this->updateCrMdDate("`$this->targetDbName`.`price_level`");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`price_level`" );
	}
	private function migrateSubscriber($connection) {
		echo "subscriber ";
		$connection->query ( "truncate table `$this->targetDbName`.`subscriber`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`subscriber`
								(`id`,
								`email`,
								`first_name`,
								`last_name`,
								`status`,
								`cr_date`,
								`cr_by`,
								`md_date`,
								`md_by`)
								select 
								`id`,
								`email`,
								firstname as `first_name`,
								lastname as `last_name`,
								case `enabled` when 1 then 'active' else 'inactive' end as `status`, 
								now() as `cr_date`,
								0 as `cr_by`,
								now() as `md_date`,
								0 as `md_by`
								from  endoca_purl.newslettersubscriber" );
		$this->updateCrMdDate("`$this->targetDbName`.`subscriber`");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`subscriber`" );
	}
	private function migrateShippingStatus($connection) {
		echo "shipping_status ";
		$connection->query ( "truncate table `$this->targetDbName`.`shipping_status`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`shipping_status` (`id`,`name`,`status`,`description`) VALUES (1,'New','active',NULL);" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`shipping_status` (`id`,`name`,`status`,`description`) VALUES (2,'Ordered','active',NULL);" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`shipping_status` (`id`,`name`,`status`,`description`) VALUES (3,'Reserved','active',NULL);" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`shipping_status` (`id`,`name`,`status`,`description`) VALUES (4,'Sending','active',NULL);" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`shipping_status` (`id`,`name`,`status`,`description`) VALUES (5,'Finished','active',NULL);" );
		$this->updateAutoIncrement ( "`$this->targetDbName`.`shipping_status`" );
	}
	private function migrateLanguage($connection) {
		echo "language ";
		$connection->query ( "truncate table $this->targetDbName.language" );
		$connection->query ( "INSERT INTO $this->targetDbName.`language`
							(`code`,
							`name`,
							`locale_name`,
							`flag`,
							`status`,
							`cr_date`,
							`cr_by`,
							`md_date`,
							`md_by`)
							select 
							iso2 as `code`,
							`name`,
							locale as `locale_name`,
							`flag`,
							case `enabled` when 1 then 'active' else 'inactive' end as `status`, 
							now() as `cr_date`,
							0 as `cr_by`,
							now() as  `md_date`,
							0 as `md_by`
							from  endoca_purl.language" );
	}
	private function migrateUsers($connection) {
		echo "`user` ";
		$connection->query ( "truncate table $this->targetDbName.`user`" );
		$connection->query ( "INSERT INTO $this->targetDbName.`user`
							(
							id,
							`user_name`,
							`password`,
							`email`,
							`phone`,
							`full_name`,
							`status`,
							`user_group_id`,
							`cr_date`,
							`cr_by`,
							`md_date`,
							`md_by`)
							select
							id,
							username,
							CONCAT('{md5}',`password`) as `password`,
							`email`,
							`phone`,
							fullname, 
							case `status` when 1 then 'active' else 'inactive' end as `status`, 
							case `level` when -1 then 1 else `level` end  as user_group_id, 
							now() as cr_date, 
							1 as cr_by, 
							now() as md_date,
							1 as md_by 
							from endoca_purl.administrator" );
		$this->updateCrMdDate("$this->targetDbName.`user`");
		$this->updateAutoIncrement ( "$this->targetDbName.`user`" );
	}
	private function migrateUserGroups($connection) {
		echo "user_group ";
		$connection->query ( "truncate table $this->targetDbName.`user_group`" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`user_group`
								(`id`,
								`name`,
								`description`,
								`status`,
								`cr_date`,
								`cr_by`,
								`md_date`,
								`md_by`)
								values(
								1,
								'Super Administrator',
								'Super Administrator' ,
								'active',
								now(),
								0,
								now(),
								0 
								)" );
		$connection->query ( "INSERT INTO `$this->targetDbName`.`user_group`
								(`id`,
								`name`,
								`description`,
								`status`,
								`cr_date`,
								`cr_by`,
								`md_date`,
								`md_by`)
								
								select 
								`id`,
								`name`,
								`name` as `description`,
								'active' as `status`,
								now() as `cr_date`,
								0 as `cr_by`,
								now() as `md_date`,
								0 as `md_by`
								from endoca_purl.administratorgroup
								" );
		$this->updateCrMdDate("$this->targetDbName.`user_group`");
		$this->updateAutoIncrement ( "$this->targetDbName.`user_group`" );
	}
	private function migrateCurrency($connection) {
		echo "currency ";
		$connection->query ( "truncate table $this->targetDbName.currency" );
		$connection->query ( "INSERT INTO $this->targetDbName.`currency` (`code`, `name`, `symbol`, `placement`, `status`, `decimal`, `cr_date`, `cr_by`, `md_date`, `md_by`) VALUES ('EUR', 'Euro', '€', 'before', 'active', '2', now(), '1', now(), '1');" );
		$connection->query ( "INSERT INTO $this->targetDbName.`currency` (`code`, `name`, `symbol`, `placement`, `status`, `decimal`, `cr_date`, `cr_by`, `md_date`, `md_by`) VALUES ('USD', 'US Dollar', '$', 'before', 'active', '2', now(), '1', now(), '1')" );
	}
	private function migrateRegion($connection) {
		echo "region ";
		echo "region_country ";
		echo "region_payment_method ";
		echo "region_shipping_method ";
		
		$connection->query ( "truncate table `$this->targetDbName`.`region`;" );
		$connection->query ( "truncate table `$this->targetDbName`.`region_country`;" );
		$connection->query ( "truncate table `$this->targetDbName`.`region_payment_method`;" );
		$connection->query ( "truncate table `$this->targetDbName`.`region_shipping_method`;" );
		
		$result = $connection->query ( "SELECT 
									    r.id,
									    r.enabled,
									    r.title,
									    r.currency,
									    r.warehouse,
									    r.email,
									    r.invoice_logo,
									    r.invoice_header,
									    r.invoice_comment,
										r.fallback
									FROM
									    endoca_purl.region r" );
		
		$regionDao = new RegionBaseDao ();
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			$regionVo = new RegionVo ();
			$regionVo->id = $row ["id"];
			$regionVo->name = $row ["title"];
			$regionVo->contactEmail = $row ["email"];
			$regionVo->invoiceLogo = $row ["invoice_logo"];
			$this->updateImage ( 'default', $regionVo->invoiceLogo );
			$regionVo->invoiceHeader = $row ["invoice_header"];
			$regionVo->invoiceComment = $row ["invoice_comment"];
			$regionVo->status = $row ["enabled"] == '1' ? 'active' : 'inactive';
			$regionVo->currencyCode = $row ["currency"] == '439' ? 'USD' : 'EUR';
			$regionVo->fallbackRegion = $row ["fallback"] == '1' ? 'yes' : 'no';
			$regionVo->crBy = 0;
			$regionVo->crDate = date ( 'Y-m-d H:i:s' );
			$regionVo->mdBy = 0;
			$regionVo->mdDate = date ( 'Y-m-d H:i:s' );
			$regionDao->insertDynamicWithId ( $regionVo );
		}
		$result->close ();
		$this->updateCrMdDate( "`$this->targetDbName`.`region`" );
		$this->updateAutoIncrement ( "`$this->targetDbName`.`region`" );
		// SHOW TABLE STATUS LIKE 'product'
	}
	private function migrateEmailTemplate($connection) {
		echo "email_template ";
		echo "email_template_lang ";
		$connection->query ( "truncate table `$this->targetDbName`.`email_template`" );
		$connection->query ( "truncate table `$this->targetDbName`.`email_template_lang`;" );
		$result = $connection->query ( "select 
					`id`,
					`lang` as `lang`, 
					`title`,
					subject as `subject`,
					`body`,
					email_from as `from`,
					email_to as `to`,
					email_reply as `reply`,
					email_cc as `cc`,
					email_bcc as `bcc`,
					tags
					from  
					(select * from 
					(select t1.*, t2.subject, t2.body,t3.iso2 as lang from  endoca_purl.emailtemplate t1
					inner join endoca_purl.emailtemplate_lng t2 on t1.id = t2.id
					inner join endoca_purl.language t3 on t2.lang = t3.id
					) as temp_table) as R" );
		
		$emailTemplateDao = new EmailTemplateBaseDao ();
		$emailTemplateLangDao = new EmailTemplateLangBaseDao ();
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			if ($row ["lang"] == 'en') {
				$emailTemplateVo = new EmailTemplateVo ();
				$emailTemplateVo->id = $row ["id"];
				$emailTemplateVo->title = $row ["title"];
				$emailTemplateVo->sendTo = AppUtil::startsWith ( $emailTemplateVo->title, "Admin" ) ? 'admin' : 'customer';
				// emailTemplateVo->send_to = 'customer';
				$emailTemplateVo->subject = $row ["subject"];
				$emailTemplateVo->body = $row ["body"];
				$emailTemplateVo->from = $row ["from"];
				$emailTemplateVo->to = $row ["to"];
				$emailTemplateVo->reply = $row ["reply"];
				$emailTemplateVo->cc = $row ["cc"];
				$emailTemplateVo->bcc = $row ["bcc"];
				$emailTemplateVo->tags = $row ["tags"];
				$emailTemplateVo->crBy = 0;
				$emailTemplateVo->crDate = date ( 'Y-m-d H:i:s' );
				$emailTemplateVo->mdBy = 0;
				$emailTemplateVo->mdDate = date ( 'Y-m-d H:i:s' );
				$emailTemplateDao->insertDynamicWithId ( $emailTemplateVo );
			}
			
			$emailTemplateLangVo = new EmailTemplateLangVo ();
			$emailTemplateLangVo->emailTemplateId = $row ["id"];
			$emailTemplateLangVo->title = $row ["title"];
			$emailTemplateLangVo->subject = $row ["subject"];
			$emailTemplateLangVo->languageCode = $row ["lang"];
			$emailTemplateLangVo->body = $row ["body"];
			$emailTemplateLangVo->from = $row ["from"];
			$emailTemplateLangVo->reply = $row ["reply"];
			$emailTemplateLangVo->cc = $row ["cc"];
			$emailTemplateLangVo->bcc = $row ["bcc"];
			$emailTemplateLangDao->insertDynamic ( $emailTemplateLangVo );
		}
		$result->close ();
		$this->updateCrMdDate("`$this->targetDbName`.`email_template`" );
		$this->updateAutoIncrement ( "`$this->targetDbName`.`email_template`" );
	}
	private function migrateCategory($connection) {
		echo "category ";
		echo "category_lang ";
		echo "seo_info_lang ";
		$connection->query ( "truncate table `$this->targetDbName`.`category`;" );
		$connection->query ( "truncate table `$this->targetDbName`.`category_lang`;" );
		$connection->query ( "delete from `$this->targetDbName`.`seo_info_lang` where `type`='category';" );
		$result = $connection->query ( "select * from
										(select 
										t1.id,
										t1.photo, 
										t1.icons, 
										t1.enabled, 
										t2.name, 
										t2.intro,
										t2.description,
										t2.seo_url,
										t2.html_title,
										t2.html_keywords,
										t2.html_description,
										t3.iso2 as lang from  endoca_purl.productcategory t1
										inner join endoca_purl.productcategory_lng t2 on t1.id = t2.id
										inner join endoca_purl.language t3 on t2.lang = t3.id
										) as temp_table" );
		
		$categoryDao = new CategoryBaseDao ();
		$categoryLangDao = new CategoryLangBaseDao ();
		$seoInfoDao = new SeoInfoLangBaseDao ();
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			if ($row ["lang"] == 'en') {
				$categoryVo = new CategoryVo ();
				$categoryVo->id = $row ["id"];
				$categoryVo->code = $row ["name"];
				$categoryVo->name = $row ["name"];
				$categoryVo->featured = "no";
				$categoryVo->status = $row ["enabled"] == '1' ? 'active' : 'inactive';
				if (isset ( $row ["icons"] )) {
					$icons = explode ( ",", $row ["icons"]) ;
					$categoryVo->bigIcon = $icons[0];
					$this->updateImage ( 'category', $categoryVo->bigIcon );
					
					if (count ($icons)>1) {
						$categoryVo->smallIcon = explode ( ",", $row ["icons"] ) [1];
						$this->updateImage ( 'category', $categoryVo->smallIcon );
					}
				}
				$categoryVo->bgImg = $row ["photo"];
				$this->updateImage ( 'category', $categoryVo->bgImg );
				$categoryVo->description = $row ["description"];
				$categoryVo->introduction = $row ["intro"];
				$categoryVo->crBy = 0;
				$categoryVo->crDate = date ( 'Y-m-d H:i:s' );
				$categoryVo->mdBy = 0;
				$categoryVo->mdDate = date ( 'Y-m-d H:i:s' );
				$categoryDao->insertDynamicWithId ( $categoryVo );
			}
			
			$categoryLangVo = new CategoryLangVo ();
			$categoryLangVo->categoryId = $row ["id"];
			$categoryLangVo->description = $row ["description"];
			$categoryLangVo->introduction = $row ["intro"];
			$categoryLangVo->languageCode = $row ["lang"];
			$categoryLangVo->name = $row ["name"];
			$categoryLangDao->insertDynamic ( $categoryLangVo );
			$seoInfoVo = new SeoInfoLangVo ();
			$seoInfoVo->itemId = $row ["id"];
			$seoInfoVo->type = 'category';
			$seoInfoVo->languageCode = $row ["lang"];
			$seoInfoVo->url = $row ["seo_url"];
			$seoInfoVo->title = $row ["html_title"];
			$seoInfoVo->keywords = $row ["html_keywords"];
			$seoInfoVo->description = $row ["html_description"];
			$seoInfoDao->insertDynamic ( $seoInfoVo );
		}
		$result->close ();
		$this->updateCrMdDate("`$this->targetDbName`.`category`");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`category`" );
		// SHOW TABLE STATUS LIKE 'category'
	}
	private function migrateProduct($connection) {
		echo "product ";
		echo "product_lang ";
		echo "product_region ";
		echo "product_price ";
		$connection->query ( "truncate table `$this->targetDbName`.`product`;" );
		$connection->query ( "truncate table `$this->targetDbName`.`product_lang`;" );
		$connection->query ( "truncate table `$this->targetDbName`.`product_region`;" );
		$connection->query ( "truncate table `$this->targetDbName`.`product_price`;" );
		$connection->query ( "delete from `$this->targetDbName`.`seo_info_lang` where `type`='product';" );
		$result = $connection->query ( "SELECT 
		    *
		FROM
		    (SELECT 
		        t1.id,
		            t1.pid AS category_id,
		            t1.code,
		            t1.enabled,
		            t1.barcode,
		            t1.featured,
		            t1.photos,
		            t1.cbd_amount,
		            t1.regions,
		            t1.tax_class,
		            t1.weight,
		            t1.import_id,
		            t2.name,
		            t2.description,
		            t2.composition,
					t2.seo_url,
		            t2.html_title,
		            t2.html_keywords,
		            t2.html_description,
		            t3.iso2 AS lang
		    FROM
		        (SELECT 
		        d.*, dc.code AS code, dc.pid
		    FROM
		        endoca_purl.`product` d
		    JOIN endoca_purl.content dc ON dc.id = d.id AND dc.section = 'Product'
		    LEFT JOIN endoca_purl.contentpid dp ON dp.id = d.id
		    WHERE
		        dc.ref = '') t1
		    INNER JOIN endoca_purl.product_lng t2 ON t1.id = t2.id
		    INNER JOIN endoca_purl.language t3 ON t2.lang = t3.id) AS temp_table" );
		
		$productDao = new ProductBaseDao ();
		$productLangDao = new ProductLangBaseDao ();
		$seoInfoDao = new SeoInfoLangBaseDao ();
		$productRegionDao = new ProductRegionBaseDao ();
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			if ($row ["lang"] == 'en') {
				$productVo = new ProductVo ();
				$productVo->id = $row ["id"];
				$productVo->categoryId = $row ["category_id"];
				$productVo->code = $row ["code"];
				$productVo->name = $row ["name"];
				$productVo->status = $row ["enabled"] == '1' ? 'active' : 'inactive';
				
				$productVo->itemCode = $row ["code"];
				$productVo->barCode = $row ["barcode"];
				if (strlen ( $row ["weight"] ) >1){
					$productVo->weight = substr ( $row ["weight"], 0, strlen ( $row ["weight"] ) - 2 );
					$productVo->weightUnit = substr ( $row ["weight"], strlen ( $row ["weight"] ) - 2,  strlen ($row ["weight"]));
				}
				$productVo->description = $row ["description"];
				$productVo->composition = $row ["composition"];
				$productVo->featured = $row ["featured"] == '1' ? 'yes' : 'no';
				$productVo->cbdAmount = $row ["cbd_amount"];
				$productVo->images = $row ["photos"];
				$images = array ();
				foreach ( explode ( ",", $row ["photos"] ) as $imgid ) {
					$images [] = $imgid;
					//$this->updateImage ( 'product', $imgid );
				}
				$productVo->images = json_encode ( $images );
				$productVo->taxRateId = 2;
				$productVo->crBy = 0;
				$productVo->crDate = date ( 'Y-m-d H:i:s' );
				$productVo->mdBy = 0;
				$productVo->mdDate = date ( 'Y-m-d H:i:s' );
				$productDao->insertDynamicWithId ( $productVo );
				foreach ( explode ( ",", $row ["regions"] ) as $regionId ) {
					$productRegionVo = new ProductRegionVo ();
					$productRegionVo->productId = $row ["id"];
					$productRegionVo->regionId = $regionId;
					$productRegionDao->insertDynamic ( $productRegionVo );
				}
				
				$this->updateProductPrice ( $row ["id"] );
			}
			
			$productLangVo = new ProductLangVo ();
			$productLangVo->productId = $row ["id"];
			$productLangVo->description = $row ["description"];
			$productLangVo->composition = $row ["composition"];
			$productLangVo->languageCode = $row ["lang"];
			$productLangVo->name = $row ["name"];
			$productLangDao->insertDynamic ( $productLangVo );
			$seoInfoVo = new SeoInfoLangVo ();
			$seoInfoVo->itemId = $row ["id"];
			$seoInfoVo->type = 'product';
			$seoInfoVo->languageCode = $row ["lang"];
			$seoInfoVo->url = $row ["seo_url"];
			$seoInfoVo->title = $row ["html_title"];
			$seoInfoVo->keywords = $row ["html_keywords"];
			$seoInfoVo->description = $row ["html_description"];
			$seoInfoDao->insertDynamic ( $seoInfoVo );
		}
		$result->close ();
		$this->updateCrMdDate("`$this->targetDbName`.`product`");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`product`" );
		// SHOW TABLE STATUS LIKE 'product'
	}
	private function updateImage($profile, $imageId) {
		if (AppUtil::isEmptyString ( $imageId )) {
			return;
		}
		if (strlen ( $imageId ) <= 4) {
			$orgDir = "D:/Working/Workspace/pproject/endoca_com/var/images/$imageId/$imageId/";
		} else {
			$orgDir = "D:/Working/Workspace/pproject/endoca_com/var/images/" . substr ( $imageId, 0, 4 ) . "/" . substr ( $imageId, 4, strlen ( $imageId ) - 4 ) . "/" . $imageId . "/";
		}
		$orgFileName = "";
		$imageService = new ImageService ();
		$imageVo = new ImageVo ();
		$imageVo->id = $imageId;
		$imageVo = $imageService->selectByKey ( $imageVo );
		if (! is_null ( $imageVo )) {
			return;
		}
		
		$host = ApplicationConfig::get ( "db.host" );
		$user = ApplicationConfig::get ( "db.username" );
		$pass = ApplicationConfig::get ( "db.password" );
		$dbName = "endoca_purl";
		$connection = new \mysqli ( $host, $user, $pass, $dbName );
		$connection->set_charset ( "utf8" );
		$result = $connection->query ( "select * from endoca_purl.image where id = " . $imageId );
		$rowCount = $result->num_rows;
		if ($rowCount > 0) {
			$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
			$orgFileName = $row ["filename"];
			$orgFullPath = $orgDir . $orgFileName;
			if (! file_exists ( $orgFullPath )) {
				return;
			}
		} else {
			return;
		}
		
		$cfgs = FileManagerHelper::getProfileCfg ( $profile );
		$fileInfo = FileUploadUtil::prepareFileInfo ( $orgFileName, null );
		$newFileName = $fileInfo ['filename'] . $fileInfo ['extension'];
		$imageVo = new ImageVo ();
		$imageVo->id = $imageId;
		$imageVo->fileName = $newFileName;
		$imageVo->mineType = mime_content_type ( $orgFullPath );
		$imageVo->profile = $profile;
		$imageVo->relativePath = FileManagerHelper::getRelativepath ( $cfgs, "" );
		$isImage = FileUploadUtil::isImage ( $orgFullPath );
		if ($isImage) {
			$imageVo->relativeSmallPath = FileManagerHelper::getRelativepath ( $cfgs, "small" );
		} else {
			$imageVo->relativeSmallPath = FileManagerHelper::getRelativepath ( $cfgs, "small" );
		}
		$imageVo->relativeMediumPath = FileManagerHelper::getRelativepath ( $cfgs, "medium" );
		$imageVo->relativeLargePath = FileManagerHelper::getRelativepath ( $cfgs, "large" );
		
		$sourceFile = FileManagerHelper::getRealpath ( $cfgs ) . $newFileName;
		// AppUtil::debugInfo($orgFullPath);
		FileUploadUtil::copyFile ( $orgFullPath, $sourceFile );
		if ($isImage) {
			FileUploadUtil::resizeImage ( $sourceFile, FileManagerHelper::getRealpath ( $cfgs, "small" ) . $newFileName, FileManagerHelper::getWidth ( $cfgs, "small" ) );
			FileUploadUtil::resizeImage ( $sourceFile, FileManagerHelper::getRealpath ( $cfgs, "medium" ) . $newFileName, FileManagerHelper::getWidth ( $cfgs, "medium" ) );
			FileUploadUtil::resizeImage ( $sourceFile, FileManagerHelper::getRealpath ( $cfgs, "large" ) . $newFileName, FileManagerHelper::getWidth ( $cfgs, "large" ) );
		}
		$imageVo->crDate = date ( 'Y-m-d H:i:s' );
		$imageVo->mdDate = date ( 'Y-m-d H:i:s' );
		$imageVo->crBy = 0;
		$imageVo->mdBy = 0;
		$imageVo->status = 'active';
		$imageService->createImage ( $imageVo );
	}
	private function migrateCustomer($connection) {
		echo "customer ";
		$connection->query ( "truncate table `$this->targetDbName`.`customer`;" );
		$result = $connection->query ( "select * from endoca_purl.user group by `email`;" );
		
		$customerDao = new CustomerBaseDao ();
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			$customerVo = new CustomerVo ();
			$customerVo->id = $row ["id"];
			$customerVo->userName = $row ["username"];
			$customerVo->password = "{md5}" . $row ["password"];
			$customerVo->firstName = $row ["firstname"];
			$customerVo->lastName = $row ["lastname"];
			$customerVo->email = $row ["email"];
			$customerVo->priceLevelId = $row ["pricelevel"];
			
			switch ($row ["type"]) {
				case "customer" :
					$customerVo->accountTypeId = 1;
					break;
				case "reseller" :
					$customerVo->accountTypeId = 2;
					break;
				default :
					$customerVo->accountTypeId = 0;
					break;
			}
			
			switch ($row ["cust_type"]) {
				case "us_retail" :
					$customerVo->customerTypeId = 1;
					break;
				case "us_wholesale" :
					$customerVo->customerTypeId = 2;
					break;
				case "us_distributor" :
					$customerVo->customerTypeId = 3;
					break;
				case "us_drop_ship" :
					$customerVo->customerTypeId = 4;
					break;
				case "us_bulk" :
					$customerVo->customerTypeId = 5;
					break;
				case "eu_retail" :
					$customerVo->customerTypeId = 6;
					break;
				case "eu_wholesale" :
					$customerVo->customerTypeId = 7;
					break;
				case "individual" :
					$customerVo->customerTypeId = 8;
					break;
				case "organisation" :
					$customerVo->customerTypeId = 9;
					break;
				case "online_ws" :
					$customerVo->customerTypeId = 10;
					break;
				case "offline_ws" :
					$customerVo->customerTypeId = 11;
					break;
				case "distributor" :
					$customerVo->customerTypeId = 12;
					break;
				case "med_pro" :
					$customerVo->customerTypeId = 13;
					break;
				case "foundation" :
					$customerVo->customerTypeId = 14;
					break;
				default :
					$customerVo->customerTypeId = 0;
					break;
			}
			
			$customerVo->companyName = $row ["company"];
			$customerVo->registrationNo = $row ["company_code"];
			$customerVo->resellerCertNo = $row ["reseller_cert"];
			$customerVo->vatNo = $row ["taxnr"];
			$customerVo->phone = $row ["phone"];
			$customerVo->fax = $row ["fax"];
			$customerVo->saleRepId = $row ["reseller"];
			$customerVo->languageCode = $row ["language"];
			// $customerVo->defaultShippingAddressId = $row[""];
			// $customerVo->defaultBillingAddressId = $row[""];
			$customerVo->crDate = date ( 'Y-m-d H:i:s' );
			$customerVo->crBy = 0;
			$customerVo->mdDate = date ( 'Y-m-d H:i:s' );
			$customerVo->mdBy = 0;
			$customerDao->insertDynamicWithId ( $customerVo );
		}
		$result->close ();
		$this->updateCrMdDate("`$this->targetDbName`.`customer`");
		$this->updateAutoIncrement ( "`$this->targetDbName`.`customer`" );
		// SHOW TABLE STATUS LIKE 'product'
	}
	private function updateAutoIncrement($table) {
		
		$host = ApplicationConfig::get ( "db.host" );
		$user = ApplicationConfig::get ( "db.username" );
		$pass = ApplicationConfig::get ( "db.password" );
		$dbName = "endoca_purl";
		$connection = new \mysqli ( $host, $user, $pass, $dbName );
		$connection->set_charset ( "utf8" );
		if (! $connection->query ( "call $this->targetDbName.reset_autoincrement('$table');" )) {
			echo "failed: (" . $connection->errno . ") " . $connection->error;
			die ();
		}
		mysqli_close ( $connection );
	}
	private function updateProductPrice($id) {
		$host = ApplicationConfig::get ( "db.host" );
		$user = ApplicationConfig::get ( "db.username" );
		$pass = ApplicationConfig::get ( "db.password" );
		$dbName = "endoca_purl";
		$connection = new \mysqli ( $host, $user, $pass, $dbName );
		$connection->set_charset ( "utf8" );
		$productPriceResult = $connection->query ( "SELECT
														    cc.code,
														    p.price
														FROM
														    (`currency` c
														    JOIN content cc ON c.id = cc.id
														    LEFT JOIN `currency_lng` cl ON c.id = cl.id AND cl.lang = 1)
														        LEFT JOIN
														    (`productprice` p
														    JOIN content pc ON p.id = pc.id
														    LEFT JOIN `productprice_lng` pl ON p.id = pl.id AND pl.lang = 1) ON p.currency = cc.code AND pc.pid = " . $id );
		$productPriceDao = new ProductPriceBaseDao ();
		while ( $productPriceRow = mysqli_fetch_array ( $productPriceResult, MYSQLI_ASSOC ) ) {
			$productPriceVo = new ProductPriceVo ();
			$productPriceVo->productId = $id;
			$productPriceVo->price = $productPriceRow ["price"];
			$productPriceVo->currencyCode = $productPriceRow ["code"];
			$productPriceDao->insertDynamic ( $productPriceVo );
		}
		mysqli_close ( $connection );
	}
	private function updateImageAutoId($connection){
		$connection->query ("ALTER TABLE $this->targetDbName.`image` AUTO_INCREMENT = 1000000");
	}
	
}