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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `department_vaccine` */

DROP TABLE IF EXISTS `department_vaccine`;

CREATE TABLE `department_vaccine` (
  `dep_vac_id` int(20) NOT NULL AUTO_INCREMENT,
  `department_id` int(20) DEFAULT NULL,
  `vaccine_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`dep_vac_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

/*Table structure for table `employee_department` */

DROP TABLE IF EXISTS `employee_department`;

CREATE TABLE `employee_department` (
  `emp_dept_id` int(20) NOT NULL AUTO_INCREMENT,
  `employee_id` int(20) NOT NULL,
  `dept_id` int(20) NOT NULL,
  `date_of_join` datetime NOT NULL,
  `from_module` enum('M','DC') DEFAULT NULL COMMENT 'M=''Employee-Master'' DC=''Department-charge''',
  `isActive` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`emp_dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

/*Table structure for table `employee_fileinfo` */

DROP TABLE IF EXISTS `employee_fileinfo`;

CREATE TABLE `employee_fileinfo` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `systemname` varchar(255) DEFAULT NULL,
  `userfilename` varchar(255) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `employee_vaccination_detail` */

DROP TABLE IF EXISTS `employee_vaccination_detail`;

CREATE TABLE `employee_vaccination_detail` (
  `employe_vaccine_id` int(20) NOT NULL AUTO_INCREMENT,
  `employee_dept_id` int(20) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

/*Table structure for table `hospital_master` */

DROP TABLE IF EXISTS `hospital_master`;

CREATE TABLE `hospital_master` (
  `hospital_id` int(20) NOT NULL AUTO_INCREMENT,
  `hospital_name` varchar(255) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hospital_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

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

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
