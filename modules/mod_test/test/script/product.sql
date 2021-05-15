CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(4) DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*
-- Query: SELECT * FROM simplemvc.product
-- Date: 2017-02-17 17:00
*/
INSERT INTO `product` (`product_id`,`product_name`,`price`,`quantity`) VALUES (1,'Săm lốp Oto',1000000.00,1);
INSERT INTO `product` (`product_id`,`product_name`,`price`,`quantity`) VALUES (2,'Bao cao su',15000.00,3);
INSERT INTO `product` (`product_id`,`product_name`,`price`,`quantity`) VALUES (3,'Kẹo bim bim',5000.00,7);
