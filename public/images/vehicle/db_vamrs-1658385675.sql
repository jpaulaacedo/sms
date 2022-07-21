/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 10.4.22-MariaDB : Database - db_vamrs
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_vamrs` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `db_vamrs`;

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `messengerial` */

DROP TABLE IF EXISTS `messengerial`;

CREATE TABLE `messengerial` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `recipient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `control_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `out_date` datetime DEFAULT NULL,
  `returned_date` datetime DEFAULT NULL,
  `approvedcao_date` datetime DEFAULT NULL,
  `count_file` int(11) DEFAULT NULL,
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_time` datetime DEFAULT NULL,
  `accomplished_date` datetime DEFAULT NULL,
  `date_needed` datetime DEFAULT NULL,
  `destination` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instruction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_pickupdate` datetime DEFAULT NULL,
  `outfordel_date` datetime DEFAULT NULL,
  `approveddc_date` datetime DEFAULT NULL,
  `resched_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urgency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_date_needed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `messengerial` */

insert  into `messengerial`(`id`,`recipient`,`control_num`,`user_id`,`status`,`created_at`,`updated_at`,`remarks`,`attachment`,`cancel_reason`,`out_date`,`returned_date`,`approvedcao_date`,`count_file`,`driver`,`pickup_time`,`accomplished_date`,`date_needed`,`destination`,`agency`,`contact`,`delivery_item`,`instruction`,`assigned_pickupdate`,`outfordel_date`,`approveddc_date`,`resched_reason`,`urgency`,`old_date_needed`) values 
(87,'DBM','2022-07-0001',17,'Filing','2022-07-04 14:01:02','2022-07-11 16:21:01','aaaaaaaa','','change of mind',NULL,NULL,NULL,0,'Elmo',NULL,'2022-07-08 15:12:00','2022-07-11 15:00:00','DBM','DBM','093497934','docs','asap',NULL,'2022-07-08 14:26:38','2022-07-04 14:01:48','Rescheduled from: 2022-07-11 15:00:00 to 2022-07-11T15:00 due to no driver','urgent',NULL),
(88,'Lee Min Ho','2022-07-0002',19,'Filing','2022-07-11 10:21:36','2022-07-12 14:52:42','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-07-18 15:55:00','LBP','Landbank of the Philippines','4843598345','docs',NULL,NULL,NULL,NULL,'Rescheduled from: 2022-07-11 15:55:00 to 2022-07-18T15:55 due to no driver','urgent',NULL),
(90,'1','2022-07-0003',19,'For Rescheduling','2022-07-11 11:13:03','2022-07-12 08:43:06','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-07-18 08:42:00','1','1','1','1',NULL,NULL,NULL,NULL,'Rescheduled from: 2022-07-15 12:12:00 to 2022-07-18T08:42 due to no driver available','urgent','2022-07-15 12:12:00'),
(91,'12','2022-07-0004',19,'For Assignment','2022-07-12 11:52:36','2022-07-12 13:39:01','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-07-12 11:52:00','1','1','1','1','1',NULL,NULL,NULL,NULL,'urgent',NULL);

/*Table structure for table `messengerial_file` */

DROP TABLE IF EXISTS `messengerial_file`;

CREATE TABLE `messengerial_file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `messengerial_id` int(11) NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `returned_date` datetime DEFAULT NULL,
  `count_file` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `messengerial_file` */

insert  into `messengerial_file`(`id`,`messengerial_id`,`attachment`,`remarks`,`created_at`,`updated_at`,`returned_date`,`count_file`) values 
(14,22,'PSRTI - Training-1654734510.pdf','done','2022-06-09 08:28:30','2022-06-09 08:28:30',NULL,NULL),
(15,48,'280735773_1190047731749591_1854513140397535258_n-1656375777.html','jhj','2022-06-28 08:22:57','2022-06-28 08:22:57',NULL,NULL),
(16,48,'280735773_1190047731749591_1854513140397535258_n-1656375931.jpg',NULL,'2022-06-28 08:25:31','2022-06-28 08:25:31',NULL,NULL),
(21,71,'WebLaunchRecorder-1656492123.exe','j','2022-06-29 16:42:03','2022-06-29 16:42:03',NULL,NULL),
(22,77,'269853123_469801808000152_7810387993131864430_n-1656550241.jpg','12','2022-06-30 08:50:41','2022-06-30 08:50:41',NULL,NULL),
(23,84,'1-1656898557.png',NULL,'2022-07-04 09:35:57','2022-07-04 09:35:57',NULL,NULL),
(30,87,'external-eye-computer-and-laptop-itim2101-lineal-color-itim2101-1657266121.png',NULL,'2022-07-08 15:42:01','2022-07-08 15:42:01',NULL,NULL),
(31,87,'footer-1657266187.png',NULL,'2022-07-08 15:43:07','2022-07-08 15:43:07',NULL,NULL),
(36,87,'eye-1657500468.png',NULL,'2022-07-11 08:47:48','2022-07-11 08:47:48',NULL,NULL),
(40,87,'iso-fad-1657500809.png',NULL,'2022-07-11 08:53:29','2022-07-11 08:53:29',NULL,NULL),
(59,87,'eye-1657582638.png',NULL,'2022-07-12 07:37:18','2022-07-12 07:37:18',NULL,NULL),
(60,87,'',NULL,'2022-07-12 07:39:01','2022-07-12 07:39:01',NULL,NULL),
(61,87,'',NULL,'2022-07-12 07:39:22','2022-07-12 07:39:22',NULL,NULL),
(62,87,'',NULL,'2022-07-12 07:47:10','2022-07-12 07:47:10',NULL,NULL),
(63,87,'',NULL,'2022-07-12 07:47:26','2022-07-12 07:47:26',NULL,NULL);

/*Table structure for table `messengerial_items` */

DROP TABLE IF EXISTS `messengerial_items`;

CREATE TABLE `messengerial_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `messengerial_id` int(11) NOT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_item` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instruction` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `messengerial_items` */

insert  into `messengerial_items`(`id`,`messengerial_id`,`agency`,`recipient`,`contact`,`destination`,`delivery_item`,`instruction`,`created_at`,`updated_at`,`due_date`) values 
(23,20,'Landbank of the Philippines','Jang','038493843','lbp qc','payslip','asap','2022-06-09 07:32:35','2022-06-09 07:32:35','2022-06-16 07:32:00'),
(24,22,'Landbank of the Philippines','Jan','3480384','lbp qc','checks. payslip','asap po thanks','2022-06-09 08:18:31','2022-06-09 08:18:39','2022-06-09 08:18:00'),
(25,23,'Landbank of the Philippines','jang','590348503','asr','ads','dsd','2022-06-09 08:36:27','2022-06-09 08:36:27','2022-06-09 08:36:00'),
(26,24,'ds','dsd','dsd','sd','dsd','sdsd','2022-06-09 08:38:06','2022-06-09 08:38:06','2022-06-09 08:38:00'),
(27,25,'Landbank of the Philippines','dsd','dsd','ds','sd','sd','2022-06-09 08:41:51','2022-06-09 08:41:51','2022-06-09 08:41:00'),
(28,26,'2','a','a','a','a','a','2022-06-09 08:43:34','2022-06-09 08:43:34','2022-06-09 08:43:00'),
(29,27,'sdsdsdsdsds','dsd','dsd','ds','d',NULL,'2022-06-09 15:01:02','2022-06-09 15:01:02','2022-06-09 15:00:00'),
(30,30,'Landbank of the Philippines','LBP','84739743','lbp','payslips','asap','2022-06-13 14:06:40','2022-06-13 14:06:40','2022-06-30 13:00:00');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2022_03_10_082417_user_tbl_division',1),
(5,'2022_03_15_014427_user_type',1),
(6,'2022_03_16_070351_messengerial_tbl',1),
(7,'2022_03_16_070759_messengerial_items_tbl',1),
(8,'2022_03_17_022338_messengerial_remarks_into_subject',1),
(9,'2022_03_17_072232_create_vehicle_tbl',1),
(10,'2022_03_17_073345_create_vehicle_passengers_tbl',1),
(11,'2022_03_28_071317_recipient_list',2),
(12,'2022_04_07_030527_add_cols',3),
(13,'2022_04_07_032101_reason_for_cancellation',4),
(14,'2022_04_11_015720_alter_tbl_messengerial',5),
(16,'2022_04_12_010308_alter_canreason_col',7),
(18,'2022_04_11_030302_add_tbl_file',8),
(19,'2022_04_12_054812_alter_tbl_mfile',9),
(20,'2022_04_20_014234_add_recipient_duedate',10),
(21,'2022_04_21_020801_add_messengerial_duedate',11),
(22,'2022_04_21_035502_change_msg_duedate',12),
(23,'2022_04_22_013355_messengerial_maxduedate',13),
(24,'2022_04_22_052207_messengerial_deletemaxduedate',14),
(25,'2022_04_22_052406_messengerial_deletemsgduedate',15),
(26,'2022_04_22_052525_messengerial_countrecipient',16),
(27,'2022_04_29_010927_add_out_date',17),
(28,'2022_04_29_011032_add_returned_date',18),
(29,'2022_04_29_012150_add_col_returned_date',19),
(30,'2022_04_29_015325_add_approve_cao_date',20),
(31,'2022_04_29_015614_add_approve_cao_date',21),
(32,'2022_04_29_025019_add_count_file',22),
(33,'2022_04_29_030314_addcount',23),
(34,'2022_05_11_110621_add_driver_messengerial',24),
(35,'2022_05_11_143221_delete_date_vehicle',25),
(36,'2022_05_11_143351_add_cols_vehicle',26),
(37,'2022_05_11_145059_add_passenger_tbl',27),
(38,'2022_05_11_145733_add_subj_vehicle',28),
(39,'2022_05_11_150833_add_cancel_vehicle',29),
(40,'2022_05_11_151400_add_status_vehicle',29),
(41,'2022_05_12_094657_delete_cols_vehicle',30),
(42,'2022_05_12_094914_add_cols_vehiclepassengers',31),
(43,'2022_05_12_095040_del_cols_vehiclepassengers',32),
(44,'2022_05_12_103333_del_fkey_vehiclepassengers',33),
(45,'2022_05_12_103753_rename_vehiclepassengers',33),
(46,'2022_05_12_105233_add_more_cols_vehicle',34),
(47,'2022_05_12_110043_edit_nullable_cols_vehicle',35),
(48,'2022_05_12_143453_remarks_file_vehicle',36),
(49,'2022_05_12_144544_edit_trip_nullable_vehicle',37),
(50,'2022_05_12_144656_delete_trip_vehicle',38),
(51,'2022_05_12_145235_create_vehicle_file_tbl',39),
(52,'2022_05_13_080807_create_colid_vehicle_file_tbl',40),
(53,'2022_05_13_081118_add_vehicle_id_file',41),
(54,'2022_05_13_102204_add_passenger_tbl',42),
(55,'2022_05_13_102912_add_passenger_to_itemtbl',43),
(56,'2022_05_16_131915_add_xxxcols_vehicle',44),
(57,'2022_05_16_134702_delete_subject',45),
(58,'2022_05_19_162956_add_count_psg',46),
(59,'2022_06_15_093347_add_pickup_acc_time',47),
(60,'2022_06_15_151333_add_cols_recipient',48),
(61,'2022_06_15_152811_delete_no_rec',49),
(62,'2022_06_15_155033_migrate_rec_msg',50),
(63,'2022_06_17_141014_add_assignedpickupdate',51),
(64,'2022_06_17_141130_del_assignedpickupdate',52),
(65,'2022_06_17_141152_addl_assignedpickupdate',53),
(66,'2022_06_27_083145_add_outfordel_pdate',54),
(67,'2022_06_28_115050_add_psg_vehicle',55),
(68,'2022_06_29_075128_add_assigned_pdate',55),
(69,'2022_06_29_082611_add_otw_pdate',56),
(70,'2022_06_29_083250_del_outfordel',57),
(71,'2022_06_29_083336_add_otw_pickdate',58),
(72,'2022_06_29_091815_add_acc_date',59),
(73,'2022_06_29_105535_add_approveddc_date',60),
(74,'2022_06_29_112728_add_approveddc_date_vhl',61),
(75,'2022_06_29_163122_rename_acc_time',62),
(76,'2022_06_29_164117_drop_rec_file',63),
(77,'2022_07_04_113719_add_resched',64),
(78,'2022_07_04_120124_add_resched_vhl',65),
(79,'2022_07_08_104105_rename_outfordel_pickupdate',66),
(80,'2022_07_08_105617_rename_otw_pickupdate',67),
(81,'2022_07_11_110923_urgency',68),
(82,'2022_07_11_143936_urgency_vhl',69),
(83,'2022_07_12_083936_add_old_date_needed_msg',70),
(84,'2022_07_12_084049_add_old_date_needed_vhl',71),
(85,'2022_07_12_084142_renale_old_date_needed_vhl',72),
(86,'2022_07_12_084226_rename_old_date_needed_msg',73);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `recipient_list_tbl` */

DROP TABLE IF EXISTS `recipient_list_tbl`;

CREATE TABLE `recipient_list_tbl` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `recipient_list_tbl` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` int(11) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `division` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`user_type`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`,`division`) values 
(17,'Jennie Kim','staff@gmail.com',1,NULL,'$2y$10$/lNPQ23T0I39.sT3XsKhpuWxt3kZZktd/QjctvpsfdGRgpiGC7I3C',NULL,'2022-04-18 06:06:12','2022-04-18 06:06:12','Training Division'),
(18,'Pinky Praxedes','dc@gmail.com',2,NULL,'$2y$10$LVz.u6oelnm6Nwn9M55CGO.CZ1GC/LD5FZx0BmC.TsSSN5ow46mXW',NULL,'2022-04-18 06:09:01','2022-04-18 06:09:01','Training Division'),
(19,'Percus Imperio','agent@gmail.com',3,NULL,'$2y$10$fSR2KtPlSVg.RRSeUtCVyuhbngF9RI7qZOUxr.wYa5b.BtZAhGAl2',NULL,'2022-04-18 06:10:38','2022-04-18 06:10:38','Finance and Administrative Division'),
(20,'Josefina Almeda','ed@gmail.com',4,NULL,'$2y$10$.sc8gSSV6y4HMKfk6bxEPuizqR2NJFvmCMDb8c2vCrZ9kfG/m2BSG',NULL,'2022-04-18 06:12:39','2022-04-18 06:12:39','Office of the Executive Director'),
(21,'Paula Acedo','admin@gmail.com',5,NULL,'$2y$10$mJrQlyVlQpxYCAEZuQ7WE.dmaRJ./YHsLDMTwcZvzWSyA013GZIuS',NULL,'2022-04-18 06:14:28','2022-04-18 06:14:28','Knowledge Management Division'),
(22,'Lolit Oreo','cao@gmail.com',6,NULL,'$2y$10$gA1HVFNM3o6dlk.c/CCEve15VfRyz9UgM96cgw1cogWRwG9MQUTa.',NULL,'2022-04-18 06:15:32','2022-04-18 06:15:32','Finance and Administrative Division');

/*Table structure for table `vehicle` */

DROP TABLE IF EXISTS `vehicle`;

CREATE TABLE `vehicle` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cancel_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count_rec` int(11) DEFAULT NULL,
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approvedcao_date` datetime DEFAULT NULL,
  `out_date` datetime DEFAULT NULL,
  `returned_date` datetime DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destination` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passenger` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_needed` datetime DEFAULT NULL,
  `count_psg` int(11) DEFAULT NULL,
  `assigned_pickupdate` datetime DEFAULT NULL,
  `otw_date` datetime DEFAULT NULL,
  `accomplished_date` datetime DEFAULT NULL,
  `approveddc_date` datetime DEFAULT NULL,
  `resched_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urgency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_date_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vehicle` */

insert  into `vehicle`(`id`,`user_id`,`created_at`,`updated_at`,`cancel_reason`,`status`,`count_rec`,`driver`,`approvedcao_date`,`out_date`,`returned_date`,`attachment`,`remarks`,`purpose`,`destination`,`passenger`,`date_needed`,`count_psg`,`assigned_pickupdate`,`otw_date`,`accomplished_date`,`approveddc_date`,`resched_reason`,`urgency`,`old_date_date`) values 
(47,17,'2022-07-08 09:32:19','2022-07-11 16:17:24','change of mind hehe','For CAO Approval',NULL,'Elmo',NULL,NULL,NULL,NULL,'bbbbbbbbbbb','Service','DBM',NULL,'2022-07-11 09:32:00',1,NULL,'2022-07-11 16:17:24','2022-07-11 10:04:00',NULL,NULL,'urgent',NULL),
(48,19,'2022-07-11 14:40:01','2022-07-11 16:32:24',NULL,'Filing',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'service','moa',NULL,'2022-07-18 14:39:00',NULL,NULL,NULL,NULL,NULL,'Rescheduled from: 2022-07-18 14:39:00 to 2022-07-18T14:39 due to full sched','urgent',NULL),
(49,19,'2022-07-11 15:45:25','2022-07-11 15:45:25',NULL,'Filing',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'service','psrti',NULL,'2022-07-11 15:45:00',NULL,NULL,NULL,NULL,NULL,NULL,'urgent',NULL),
(51,19,'2022-07-11 16:04:53','2022-07-12 13:34:12',NULL,'For DC Approval',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'aaa','aa',NULL,'2022-07-11 16:03:00',NULL,NULL,NULL,NULL,NULL,NULL,'not_urgent',NULL),
(52,19,'2022-07-11 16:10:53','2022-07-11 16:11:00',NULL,'For DC Approval',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'AAA','AAAA',NULL,'2022-07-11 16:07:00',NULL,NULL,NULL,NULL,NULL,NULL,'urgent',NULL),
(53,19,'2022-07-12 11:33:34','2022-07-12 14:07:27',NULL,'For DC Approval',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'asdasd','asdasd',NULL,'2022-07-12 11:33:00',NULL,NULL,NULL,NULL,NULL,NULL,'urgent',NULL),
(54,19,'2022-07-12 11:34:03','2022-07-12 14:09:03',NULL,'For Assignment',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'service','lbp',NULL,'2022-07-12 11:33:00',NULL,NULL,NULL,NULL,NULL,NULL,'not_urgent',NULL);

/*Table structure for table `vehicle_file` */

DROP TABLE IF EXISTS `vehicle_file`;

CREATE TABLE `vehicle_file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destination` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vehicle_file` */

insert  into `vehicle_file`(`id`,`created_at`,`updated_at`,`remarks`,`attachment`,`destination`,`vehicle_id`) values 
(34,'2022-06-09 16:28:44','2022-06-09 16:28:44','sds','_DSF2817-1654763324.JPG',NULL,23),
(41,'2022-06-29 08:10:08','2022-06-29 08:10:08','h','1-1656461408.png',NULL,23),
(42,'2022-06-29 09:24:33','2022-06-29 09:24:33',NULL,'WebLaunchRecorder-1656465873.exe',NULL,29),
(43,'2022-06-29 14:55:58','2022-06-29 14:55:58','jhj','1-1656485758.png',NULL,32),
(44,'2022-06-30 11:43:15','2022-06-30 11:43:15','sss','CS-Form-No.-6-Revised-2020-Application-for-Leave-Fillable_Sample-1 (1)-1656560595.xlsx',NULL,43),
(45,'2022-07-04 13:22:04','2022-07-04 13:22:04',NULL,'1-1656912124.png',NULL,28),
(48,'2022-07-11 08:33:49','2022-07-11 08:33:49',NULL,'deliver-1657499629.jpg',NULL,47),
(57,'2022-07-11 09:36:50','2022-07-11 09:36:50',NULL,'eye-1657503410.png',NULL,47),
(58,'2022-07-11 09:49:51','2022-07-11 09:49:51',NULL,'footer-1657504191.png',NULL,47),
(59,'2022-07-11 09:50:39','2022-07-11 09:50:39',NULL,'dc_signature-1657504239.png',NULL,47),
(60,'2022-07-11 16:41:54','2022-07-11 16:41:54',NULL,'',NULL,49),
(61,'2022-07-11 16:42:02','2022-07-11 16:42:02',NULL,'',NULL,49),
(62,'2022-07-12 07:48:22','2022-07-12 07:48:22',NULL,'',NULL,49),
(63,'2022-07-12 07:48:26','2022-07-12 07:48:26',NULL,'eye-1657583306.png',NULL,49),
(64,'2022-07-12 07:48:31','2022-07-12 07:48:31',NULL,'',NULL,49);

/*Table structure for table `vehicle_items` */

DROP TABLE IF EXISTS `vehicle_items`;

CREATE TABLE `vehicle_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_needed` datetime NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passenger` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vehicle_items` */

insert  into `vehicle_items`(`id`,`vehicle_id`,`created_at`,`updated_at`,`date_needed`,`purpose`,`destination`,`passenger`) values 
(19,9,'2022-05-16 08:39:38','2022-05-16 10:09:34','2022-05-16 08:39:00','fdf','dfd',NULL);

/*Table structure for table `vehicle_passenger` */

DROP TABLE IF EXISTS `vehicle_passenger`;

CREATE TABLE `vehicle_passenger` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passenger` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `vehicle_passenger` */

insert  into `vehicle_passenger`(`id`,`vehicle_id`,`created_at`,`updated_at`,`passenger`) values 
(113,47,'2022-07-08 09:37:21','2022-07-08 09:37:21','nayeon'),
(114,48,'2022-07-11 14:45:18','2022-07-11 14:45:18','pau'),
(133,54,'2022-07-12 14:08:56','2022-07-12 14:08:56','123'),
(134,54,'2022-07-12 14:08:56','2022-07-12 14:08:56','1234');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
