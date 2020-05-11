/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.7.21-1ubuntu1 : Database - just_travel
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`just_travel` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `just_travel`;

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `contacts` */

LOCK TABLES `contacts` WRITE;

UNLOCK TABLES;

/*Table structure for table `currencies` */

DROP TABLE IF EXISTS `currencies`;

CREATE TABLE `currencies` (
  `usd` double(8,2) NOT NULL,
  `amd` double(8,2) NOT NULL,
  `eur` double(8,2) NOT NULL,
  `rur` double(8,2) NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `currencies` */

LOCK TABLES `currencies` WRITE;

insert  into `currencies`(`usd`,`amd`,`eur`,`rur`,`id`) values (498.00,1.00,502.00,7.90,1);

UNLOCK TABLES;

/*Table structure for table `download_p_d_fs` */

DROP TABLE IF EXISTS `download_p_d_fs`;

CREATE TABLE `download_p_d_fs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pdf_name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pdf_file_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pdf_name_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pdf_file_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pdf_thumbnail_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pdf_thumbnail_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `download_p_d_fs` */

LOCK TABLES `download_p_d_fs` WRITE;

UNLOCK TABLES;

/*Table structure for table `galleries` */

DROP TABLE IF EXISTS `galleries`;

CREATE TABLE `galleries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gallery_name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gallery_name_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gallery_desc_en` text COLLATE utf8_unicode_ci NOT NULL,
  `gallery_desc_ru` text COLLATE utf8_unicode_ci NOT NULL,
  `gallery_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `main_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gallery` enum('on','off') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  `portfolio` enum('on','off') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  `gallery_order` tinyint(4) NOT NULL DEFAULT '0',
  `portfolio_order` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `galleries` */

LOCK TABLES `galleries` WRITE;

insert  into `galleries`(`id`,`created_at`,`updated_at`,`gallery_name_en`,`gallery_name_ru`,`gallery_desc_en`,`gallery_desc_ru`,`gallery_url`,`main_image`,`gallery`,`portfolio`,`gallery_order`,`portfolio_order`) values (1,'2017-06-16 19:19:28','2017-06-16 19:19:28','jgjhghjjkbj','jgjhghjjkbj','<p>jgjhghjjkbj</p>','<p>jgjhghjjkbj</p>','jgjhghjjkbj',NULL,'on','on',0,0);

UNLOCK TABLES;

/*Table structure for table `gallery_photos` */

DROP TABLE IF EXISTS `gallery_photos`;

CREATE TABLE `gallery_photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gallery_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_photos_gallery_id_foreign` (`gallery_id`),
  CONSTRAINT `gallery_photos_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `gallery_photos` */

LOCK TABLES `gallery_photos` WRITE;

insert  into `gallery_photos`(`id`,`created_at`,`updated_at`,`image_name`,`image_path`,`gallery_id`) values (1,NULL,NULL,'59442f408e957.png','images/gallery/1/content/59442f408e957.png',1),(2,NULL,NULL,'59442f4f65945.png','images/gallery/1/content/59442f4f65945.png',1);

UNLOCK TABLES;

/*Table structure for table `guides` */

DROP TABLE IF EXISTS `guides`;

CREATE TABLE `guides` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guide_name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guide_name_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `guides` */

LOCK TABLES `guides` WRITE;

UNLOCK TABLES;

/*Table structure for table `hotels` */

DROP TABLE IF EXISTS `hotels`;

CREATE TABLE `hotels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hotel_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `regions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hotel_name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hotel_name_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc_en` text COLLATE utf8_unicode_ci NOT NULL,
  `desc_ru` text COLLATE utf8_unicode_ci NOT NULL,
  `short_desc_en` text COLLATE utf8_unicode_ci NOT NULL,
  `short_desc_ru` text COLLATE utf8_unicode_ci NOT NULL,
  `tags_en` text COLLATE utf8_unicode_ci NOT NULL,
  `tags_ru` text COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('1_star','2_star','3_star','4_star','5_star','motel','hostel') COLLATE utf8_unicode_ci NOT NULL,
  `images` text COLLATE utf8_unicode_ci NOT NULL,
  `hotel_main_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility` enum('on','off') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `hotels` */

LOCK TABLES `hotels` WRITE;

insert  into `hotels`(`id`,`created_at`,`updated_at`,`hotel_url`,`regions`,`hotel_name_en`,`hotel_name_ru`,`desc_en`,`desc_ru`,`short_desc_en`,`short_desc_ru`,`tags_en`,`tags_ru`,`type`,`images`,`hotel_main_image`,`visibility`) values (3,'2017-06-14 18:12:51','2017-06-16 19:07:56','dfsdf','yerevan','sdfdsf','sdfsf','<p>sdfsdf</p>','<p>dsfsdf</p>','','','social,adverts,sales','social,','4_star',',images/hotels/59442c8c16c47.png','images/hotels/59442c8c16acdScreenshot from 2017-03-30 22-18-27.png','on');

UNLOCK TABLES;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

LOCK TABLES `migrations` WRITE;

insert  into `migrations`(`migration`,`batch`) values ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2017_03_13_143010_create_tour_categories_table',1),('2017_03_17_152956_create_hotels_table',1),('2017_03_23_150008_create_tours_table',1),('2017_03_24_143249_create_tour_hotels_table',1),('2017_03_24_143858_create_tour_custom_days_table',1),('2017_03_27_143229_create_tour_cat_rels_table',1),('2017_03_29_172654_create_video_galleries_table',1),('2017_03_31_122911_create_pages_table',1),('2017_03_31_155319_create_galleries_table',1),('2017_04_03_131858_create_download_p_d_fs_table',1),('2017_04_03_162012_create_guides_table',1),('2017_04_03_172419_create_currencies_table',1),('2017_04_17_164331_create_gallery_photos_table',1),('2017_04_21_221415_create_contacts_table',1),('2017_05_02_084820_create_order_tours_table',1),('2017_05_12_092725_create_payments_table',1),('2017_05_12_100056_create_order_members_table',1),('2017_05_16_094050_create_tour_dates_table',1),('2017_05_25_142758_update_order_tours_table',1),('2017_05_26_094401_update_order_tours',1),('2017_06_01_144307_add_lead_data_to_order_tours',1),('2017_06_09_132419_update_order_members_table',1),('2017_06_13_083846_create_page_orders_table',1),('2017_06_13_090401_alter_page_orders_table',1),('2017_06_13_132740_alter_pages_table',1),('2017_06_14_091122_alter_order_tours_table',2),('2017_06_15_082544_alter_currencies_table',2),('2017_06_16_063553_add_order_column_to_video_photo_gallery_tables',2),('2017_06_16_124607_add_order_column_to_tours_tables',2),('2017_06_22_133214_add_order_column_to_download_p_d_fs',2),('2017_06_23_084613_add_read_column_to_order_tours_table',2),('2017_06_23_153757_alter_table_galleries',2);

UNLOCK TABLES;

/*Table structure for table `order_members` */

DROP TABLE IF EXISTS `order_members`;

CREATE TABLE `order_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `member_prp` enum('adult','child','infant') COLLATE utf8_unicode_ci NOT NULL,
  `member_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `member_surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `member_dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_tour_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_members_order_tour_id_foreign` (`order_tour_id`),
  CONSTRAINT `order_members_order_tour_id_foreign` FOREIGN KEY (`order_tour_id`) REFERENCES `order_tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `order_members` */

LOCK TABLES `order_members` WRITE;

UNLOCK TABLES;

/*Table structure for table `order_tours` */

DROP TABLE IF EXISTS `order_tours`;

CREATE TABLE `order_tours` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_id` int(10) unsigned DEFAULT NULL,
  `hotel_id` int(10) unsigned DEFAULT NULL,
  `date_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adults_count` int(11) NOT NULL,
  `children_count` int(11) NOT NULL,
  `infants_count` int(11) NOT NULL,
  `order_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `lead_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `rooms` int(11) NOT NULL,
  `md_order` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payed` enum('new','payed','devdeclined') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `lead_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lead_surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `read` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_tours_tour_id_foreign` (`tour_id`),
  KEY `order_tours_hotel_id_foreign` (`hotel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `order_tours` */

LOCK TABLES `order_tours` WRITE;

insert  into `order_tours`(`id`,`created_at`,`updated_at`,`tour_id`,`hotel_id`,`date_from`,`adults_count`,`children_count`,`infants_count`,`order_id`,`amount`,`lead_email`,`comment`,`rooms`,`md_order`,`payed`,`lead_name`,`lead_surname`,`read`) values (1,'2017-07-18 16:10:17','2017-07-18 16:10:18',13,3,'21/07/2017',2,0,0,'596e32e9cad76',545,'','',2,'','new','','',0);

UNLOCK TABLES;

/*Table structure for table `page_orders` */

DROP TABLE IF EXISTS `page_orders`;

CREATE TABLE `page_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(10) unsigned NOT NULL,
  `order` int(11) NOT NULL,
  `right_menu` tinyint(4) NOT NULL DEFAULT '0',
  `footer` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `page_orders_page_id_foreign` (`page_id`),
  CONSTRAINT `page_orders_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4294967295 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `page_orders` */

LOCK TABLES `page_orders` WRITE;

insert  into `page_orders`(`id`,`page_id`,`order`,`right_menu`,`footer`) values (747,22,1,1,0),(748,23,2,1,0),(749,25,3,1,0),(750,26,4,1,0),(751,27,5,1,0),(758,25,0,0,1),(759,28,1,0,1),(760,22,2,0,1),(761,23,3,0,1),(762,24,4,0,1),(763,26,5,0,1),(764,27,6,0,1),(4294967295,24,0,1,0);

UNLOCK TABLES;

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `page_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_name_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc_en` text COLLATE utf8_unicode_ci NOT NULL,
  `desc_ru` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility` enum('off','on') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  `footer` enum('off','on') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `pages` */

LOCK TABLES `pages` WRITE;

insert  into `pages`(`id`,`created_at`,`updated_at`,`page_url`,`page_name_en`,`page_name_ru`,`desc_en`,`desc_ru`,`image`,`visibility`,`footer`,`type`) values (22,'2017-06-13 19:08:26','2017-06-13 19:08:26','/tours','Tours','Туры','','','','on','on',1),(23,'2017-06-13 19:08:26','2017-06-13 19:08:26','/galleries','Photo Gallery','Фото Галерея','','','','on','on',1),(24,'2017-06-13 19:08:26','2017-06-13 19:08:26','/portfolio','Portfolio','Портфолио','','','','on','on',1),(25,'2017-06-13 19:08:26','2017-06-13 19:08:26','/video_gallery','Video Gallery','Видео Галерея','','','','on','on',1),(26,'2017-06-13 19:08:26','2017-06-13 19:08:26','/catalogue','Catalogue','Каталог','','','','on','on',1),(27,'2017-06-13 19:08:26','2017-06-13 19:08:26','/contacts','Contacts','Контакты','','','','on','on',1),(28,'2017-06-13 19:08:46','2017-06-16 19:32:39','mm','a1','njjn','<p>a1</p>','<p>jkbjkb</p>','images/pages/59443256f2554.png','off','on',0);

UNLOCK TABLES;

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

LOCK TABLES `password_resets` WRITE;

UNLOCK TABLES;

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `loc_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cardholderName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `depositAmount` int(11) NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `approvalCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `authCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ErrorCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ErrorMessage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OrderStatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OrderNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Pan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Amount` int(11) NOT NULL,
  `Ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `SvfeResponse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_tour_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_tour_id_foreign` (`order_tour_id`),
  CONSTRAINT `payments_order_tour_id_foreign` FOREIGN KEY (`order_tour_id`) REFERENCES `order_tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `payments` */

LOCK TABLES `payments` WRITE;

UNLOCK TABLES;

/*Table structure for table `tour_cat_rels` */

DROP TABLE IF EXISTS `tour_cat_rels`;

CREATE TABLE `tour_cat_rels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_id` int(10) unsigned DEFAULT NULL,
  `cat_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tour_cat_rels_tour_id_foreign` (`tour_id`),
  KEY `tour_cat_rels_cat_id_foreign` (`cat_id`),
  CONSTRAINT `tour_cat_rels_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `tour_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tour_cat_rels_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tour_cat_rels` */

LOCK TABLES `tour_cat_rels` WRITE;

insert  into `tour_cat_rels`(`id`,`created_at`,`updated_at`,`tour_id`,`cat_id`) values (47,NULL,NULL,13,2);

UNLOCK TABLES;

/*Table structure for table `tour_categories` */

DROP TABLE IF EXISTS `tour_categories`;

CREATE TABLE `tour_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_name_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `property` enum('basic','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'custom',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tour_categories` */

LOCK TABLES `tour_categories` WRITE;

insert  into `tour_categories`(`id`,`created_at`,`updated_at`,`category_name_en`,`category_name_ru`,`url`,`property`) values (1,NULL,NULL,'Daily Tours','Ежедневние Туры','','basic'),(2,'2017-06-14 18:55:40','2017-06-14 18:55:40','njkb','nbnbm','bkjb','custom');

UNLOCK TABLES;

/*Table structure for table `tour_custom_days` */

DROP TABLE IF EXISTS `tour_custom_days`;

CREATE TABLE `tour_custom_days` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_id` int(10) unsigned NOT NULL,
  `desc_en` text COLLATE utf8_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc_ru` text COLLATE utf8_unicode_ci NOT NULL,
  `title_ru` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tour_custom_days_tour_id_foreign` (`tour_id`),
  CONSTRAINT `tour_custom_days_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tour_custom_days` */

LOCK TABLES `tour_custom_days` WRITE;

insert  into `tour_custom_days`(`id`,`created_at`,`updated_at`,`tour_id`,`desc_en`,`title_en`,`desc_ru`,`title_ru`) values (10,NULL,NULL,13,'hjghj','ghjg','',''),(11,NULL,NULL,13,'ghjgk','ghjghj','','');

UNLOCK TABLES;

/*Table structure for table `tour_dates` */

DROP TABLE IF EXISTS `tour_dates`;

CREATE TABLE `tour_dates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tour_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tour_dates_tour_id_foreign` (`tour_id`),
  CONSTRAINT `tour_dates_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tour_dates` */

LOCK TABLES `tour_dates` WRITE;

insert  into `tour_dates`(`id`,`tour_id`,`date`) values (41,13,'2017-07-21');

UNLOCK TABLES;

/*Table structure for table `tour_hotels` */

DROP TABLE IF EXISTS `tour_hotels`;

CREATE TABLE `tour_hotels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hotel_id` int(10) unsigned NOT NULL,
  `tour_id` int(10) unsigned NOT NULL,
  `single_adult` int(11) NOT NULL,
  `double_adult` int(11) NOT NULL,
  `triple_adult` int(11) NOT NULL,
  `child` int(11) NOT NULL,
  `infant` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tour_hotels_hotel_id_foreign` (`hotel_id`),
  KEY `tour_hotels_tour_id_foreign` (`tour_id`),
  CONSTRAINT `tour_hotels_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tour_hotels_tour_id_foreign` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tour_hotels` */

LOCK TABLES `tour_hotels` WRITE;

insert  into `tour_hotels`(`id`,`created_at`,`updated_at`,`hotel_id`,`tour_id`,`single_adult`,`double_adult`,`triple_adult`,`child`,`infant`) values (1,NULL,NULL,3,13,454,545,454,5454,0);

UNLOCK TABLES;

/*Table structure for table `tours` */

DROP TABLE IF EXISTS `tours`;

CREATE TABLE `tours` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tour_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tour_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tour_name_en` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tour_name_ru` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc_en` text COLLATE utf8_unicode_ci,
  `desc_ru` text COLLATE utf8_unicode_ci,
  `short_desc_en` text COLLATE utf8_unicode_ci,
  `short_desc_ru` text COLLATE utf8_unicode_ci,
  `tags_en` text COLLATE utf8_unicode_ci,
  `tags_ru` text COLLATE utf8_unicode_ci,
  `basic_price_adult` double(8,2) DEFAULT NULL,
  `basic_price_child` double(8,2) DEFAULT NULL,
  `basic_price_infant` double(8,2) DEFAULT NULL,
  `basic_frequency` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_day_prp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tour_images` text COLLATE utf8_unicode_ci,
  `tour_main_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hot_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visibility` enum('on','off') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  `hot` enum('on','off') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  `type` enum('regular','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'regular',
  `tour_price` int(11) DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `traveler_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `tour_day` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tours` */

LOCK TABLES `tours` WRITE;

insert  into `tours`(`id`,`created_at`,`updated_at`,`tour_url`,`tour_category`,`tour_name_en`,`tour_name_ru`,`desc_en`,`desc_ru`,`short_desc_en`,`short_desc_ru`,`tags_en`,`tags_ru`,`basic_price_adult`,`basic_price_child`,`basic_price_infant`,`basic_frequency`,`custom_day_prp`,`tour_images`,`tour_main_image`,`hot_image`,`visibility`,`hot`,`type`,`tour_price`,`code`,`traveler_email`,`price`,`tour_day`,`order`) values (13,'2017-07-18 15:21:39','2017-07-18 15:21:39','олрлоп','njkb','hjhjkh','bjfhf','<p>jkjghkjghjk</p>','<p>hjhfhjk</p>','njkhjk b','','','',NULL,NULL,NULL,'','custom',NULL,'images/tours/main_image/596e2783a3e66.jpg',NULL,'on','on','regular',NULL,'838FF82',NULL,NULL,NULL,0);

UNLOCK TABLES;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

LOCK TABLES `users` WRITE;

insert  into `users`(`id`,`first_name`,`last_name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values (1,'Just','Travel','admin@jt.com','$2y$10$X9NUdn/.j1LX.5HlHMZg9OsxpYO28Y/y52XdGbg7JFwAmNy4kWOU.',NULL,NULL,NULL);

UNLOCK TABLES;

/*Table structure for table `video_galleries` */

DROP TABLE IF EXISTS `video_galleries`;

CREATE TABLE `video_galleries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `video_url_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `video_url_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `embed_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `embed_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `video_title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `video_title_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `video_thumbnail_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `video_thumbnail_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `video_galleries` */

LOCK TABLES `video_galleries` WRITE;

insert  into `video_galleries`(`id`,`created_at`,`updated_at`,`video_url_en`,`video_url_ru`,`embed_en`,`embed_ru`,`video_title_en`,`video_title_ru`,`video_thumbnail_en`,`video_thumbnail_ru`,`order`) values (1,'2017-06-16 19:20:43','2017-06-16 19:24:21','hggh','ghhj','hggh','ghhj','vhjh','hjhv','images/video_thumbnails/en/594430653eb69.png','images/video_thumbnails/en/594430653eb69.png',0);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
