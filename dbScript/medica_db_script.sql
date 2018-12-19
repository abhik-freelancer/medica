/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.1.31-MariaDB : Database - medica_data
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`medica_data` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `medica_data`;

/*Table structure for table `department_master` */

DROP TABLE IF EXISTS `department_master`;

CREATE TABLE `department_master` (
  `department_id` int(20) NOT NULL AUTO_INCREMENT,
  `hospital_id` int(20) DEFAULT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `department_master` */

insert  into `department_master`(`department_id`,`hospital_id`,`department_name`) values (1,1,'HR'),(3,1,'Health Care Staff'),(4,1,'Doctor'),(5,1,'Nurse'),(9,1,'Accounts '),(10,1,'Developer'),(11,1,'Temporary Worker');

/*Table structure for table `department_vaccine` */

DROP TABLE IF EXISTS `department_vaccine`;

CREATE TABLE `department_vaccine` (
  `dep_vac_id` int(20) NOT NULL AUTO_INCREMENT,
  `department_id` int(20) DEFAULT NULL,
  `vaccine_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`dep_vac_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

/*Data for the table `department_vaccine` */

insert  into `department_vaccine`(`dep_vac_id`,`department_id`,`vaccine_id`) values (25,9,4),(26,9,5),(27,4,1),(28,4,2),(35,10,2),(36,10,3),(37,10,5),(38,1,1),(39,1,5),(40,11,3),(41,3,3),(42,3,6),(43,3,7),(44,3,8);

/*Table structure for table `employee_fileinfo` */

DROP TABLE IF EXISTS `employee_fileinfo`;

CREATE TABLE `employee_fileinfo` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `systemname` varchar(255) DEFAULT NULL,
  `userfilename` varchar(255) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `employee_fileinfo` */

insert  into `employee_fileinfo`(`id`,`systemname`,`userfilename`,`upload_date`,`uploaded_by`) values (4,'templateEmployee.xls','','2018-11-24 16:43:33',1),(5,'templateEmployee1.xls','','2018-11-24 16:48:41',1),(6,'templateEmployee2.xls','','2018-11-24 18:28:57',1),(7,'templateEmployee3.xls','','2018-11-24 18:30:22',1),(8,'templateEmployee4.xls','','2018-11-24 18:33:04',1),(9,'templateEmployee5.xls','','2018-11-24 18:34:53',1),(10,'templateEmployee6.xls','','2018-11-27 16:01:34',1);

/*Table structure for table `employee_master` */

DROP TABLE IF EXISTS `employee_master`;

CREATE TABLE `employee_master` (
  `employee_id` int(20) NOT NULL AUTO_INCREMENT,
  `employee_code` varchar(255) DEFAULT NULL,
  `employee_email` varchar(255) DEFAULT NULL,
  `employee_mobile` varchar(255) DEFAULT NULL,
  `hospital_id` int(20) NOT NULL,
  `department_id` int(20) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `employee_doj` datetime DEFAULT NULL,
  `employee_status` enum('Active','Resign','Transfer') DEFAULT NULL,
  `vaccination_cert_given_date` datetime DEFAULT NULL,
  `creat_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `UNIQUE_EMPCODE` (`employee_code`),
  KEY `FK_dept_emp` (`department_id`),
  CONSTRAINT `FK_dept_emp` FOREIGN KEY (`department_id`) REFERENCES `department_master` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `employee_master` */

insert  into `employee_master`(`employee_id`,`employee_code`,`employee_email`,`employee_mobile`,`hospital_id`,`department_id`,`employee_name`,`employee_doj`,`employee_status`,`vaccination_cert_given_date`,`creat_date`) values (17,'M-0001','amir@medica.com','9874141533',1,3,'Amir Khan','2018-10-01 00:00:00','Active',NULL,'2018-12-19 15:25:54'),(18,'M-0000','admin@gmail.com','9874141566',1,10,'Admin','2000-01-01 18:27:16','Active',NULL,'2018-12-19 18:21:25');

/*Table structure for table `employee_vaccination_detail` */

DROP TABLE IF EXISTS `employee_vaccination_detail`;

CREATE TABLE `employee_vaccination_detail` (
  `employe_vaccine_id` int(20) NOT NULL AUTO_INCREMENT,
  `employee_id` int(20) DEFAULT NULL,
  `department_id` int(20) DEFAULT NULL,
  `vaccination_id` int(20) DEFAULT NULL,
  `schedule_date` datetime DEFAULT NULL,
  `actual_given_date` datetime DEFAULT NULL,
  `is_given` enum('N','Y') DEFAULT 'N',
  `parent_vaccineId` int(11) DEFAULT NULL,
  `hospital_id` int(20) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`employe_vaccine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `employee_vaccination_detail` */

insert  into `employee_vaccination_detail`(`employe_vaccine_id`,`employee_id`,`department_id`,`vaccination_id`,`schedule_date`,`actual_given_date`,`is_given`,`parent_vaccineId`,`hospital_id`,`created_date`) values (9,17,3,3,'2018-11-30 00:00:00',NULL,'N',NULL,1,'2018-12-19 15:25:55'),(10,17,3,6,'2018-10-11 00:00:00','2018-12-20 00:00:00','Y',NULL,1,'2018-12-19 15:25:55'),(16,17,3,7,'2019-01-17 00:00:00','2019-01-17 00:00:00','Y',6,NULL,'2018-12-19 18:09:41'),(17,17,3,8,'2019-03-14 00:00:00',NULL,'N',7,NULL,'2018-12-19 18:11:30');

/*Table structure for table `hospital_master` */

DROP TABLE IF EXISTS `hospital_master`;

CREATE TABLE `hospital_master` (
  `hospital_id` int(20) NOT NULL AUTO_INCREMENT,
  `hospital_name` varchar(255) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hospital_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `hospital_master` */

insert  into `hospital_master`(`hospital_id`,`hospital_name`,`create_date`) values (1,'Medica Superspecialty Hospital','2018-11-14 11:48:43');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `hospital_id` int(20) DEFAULT NULL,
  `employee_id` int(20) DEFAULT NULL,
  `department_id` int(20) DEFAULT NULL,
  `user_type` enum('Admin','HR','IC') DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`user_id`,`username`,`password`,`hospital_id`,`employee_id`,`department_id`,`user_type`,`created_by`,`create_date`,`is_active`) values (1,'admin','admin123',1,18,1,'Admin',1,'2018-11-13 19:17:32','Y'),(6,'amir@medica','abc123',1,17,3,'HR',1,'2018-12-19 18:15:08','Y');

/*Table structure for table `vaccine` */

DROP TABLE IF EXISTS `vaccine`;

CREATE TABLE `vaccine` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `vaccine` varchar(255) DEFAULT NULL,
  `parent_vaccine` int(20) DEFAULT NULL,
  `frequency` int(20) DEFAULT NULL,
  `is_depend_doj` enum('Y','N') DEFAULT 'N',
  `hospital_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `vaccine` */

insert  into `vaccine`(`id`,`vaccine`,`parent_vaccine`,`frequency`,`is_depend_doj`,`hospital_id`) values (1,'Hib1',NULL,1,'N',1),(2,'Hib2',1,30,'N',1),(3,'Titanus',NULL,60,'N',1),(4,'RV1',NULL,5,'N',1),(5,'RV2',4,40,'Y',1),(6,'HBsAb-1',NULL,10,'Y',1),(7,'HBsAb-2',6,28,'N',1),(8,'HBsAb-3',7,56,'N',1),(9,'Titenus-2',3,30,'N',NULL),(10,'Varicella',NULL,1,'Y',1),(11,'Measles',NULL,15,'Y',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
