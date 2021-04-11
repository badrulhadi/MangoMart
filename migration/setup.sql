DROP DATABASE IF EXISTS ecommerce;

CREATE DATABASE ecommerce;

USE ecommerce;

CREATE TABLE IF NOT EXISTS `carts_items` (
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `sub_total` double NOT NULL,
  `created` timestamp NULL,
  `modified` timestamp NULL,
  PRIMARY KEY (`user_id`, `product_id`)
);

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_price` double NOT NULL,
  `status` tinyint NOT NULL, /*1-pending; 2-processing; 3-completed*/
  `created` timestamp NULL,
  `modified` timestamp NULL,
  PRIMARY KEY (`order_id`)
);

CREATE TABLE IF NOT EXISTS `orders_items` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `sub_total` double NOT NULL,
  `created` timestamp NULL,
  `modified` timestamp NULL,
  PRIMARY KEY (`order_id`, `product_id`)
);
