/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - superapps_officewill_jp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`superapps_officewill_jp` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `superapps_officewill_jp`;

/*Table structure for table `affiliation_information` */

DROP TABLE IF EXISTS `affiliation_information`;

CREATE TABLE `affiliation_information` (
  `affiliation_code` int(9) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `affiliation_name` varchar(15) DEFAULT NULL,
  `display_order` varchar(3) DEFAULT NULL,
  `organization_type` char(1) DEFAULT NULL,
  PRIMARY KEY (`affiliation_code`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `affiliation_information_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `affiliation_information` */

/*Table structure for table `attendance_todo_answer_selection_information` */

DROP TABLE IF EXISTS `attendance_todo_answer_selection_information`;

CREATE TABLE `attendance_todo_answer_selection_information` (
  `atiasi_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `employee_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `attendance_setting_id` int(10) NOT NULL,
  `todo_items_id` int(10) NOT NULL,
  `todo_option_id` int(10) NOT NULL,
  `selection` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `other_text_answer` varchar(255) NOT NULL,
  PRIMARY KEY (`atiasi_id`),
  KEY `CompanyID` (`company_id`),
  KEY `EmployeeID` (`employee_id`),
  KEY `CourseID` (`course_id`),
  KEY `AttendanceSettingID` (`attendance_setting_id`),
  KEY `ToDo_items_id` (`todo_items_id`),
  KEY `ToDo_option_ID` (`todo_option_id`),
  CONSTRAINT `attendance_todo_answer_selection_information_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `company_information` (`company_id`),
  CONSTRAINT `attendance_todo_answer_selection_information_ibfk_2` FOREIGN KEY (`Employee_ID`) REFERENCES `employee_information` (`employee_id`),
  CONSTRAINT `attendance_todo_answer_selection_information_ibfk_3` FOREIGN KEY (`Course_ID`) REFERENCES `course_information` (`course_ID`),
  CONSTRAINT `attendance_todo_answer_selection_information_ibfk_4` FOREIGN KEY (`Attendance_Setting_ID`) REFERENCES `course_schedule_results_information` (`Attendance_setting_id`),
  CONSTRAINT `attendance_todo_answer_selection_information_ibfk_5` FOREIGN KEY (`ToDo_items_id`) REFERENCES `course_todo_item_information` (`ToDo_item_id`),
  CONSTRAINT `attendance_todo_answer_selection_information_ibfk_6` FOREIGN KEY (`ToDo_option_ID`) REFERENCES `course_todo_items_choice_information` (`ToDo_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `attendance_todo_answer_selection_information` */

/*Table structure for table `attendance_todo_item_answer_information` */

DROP TABLE IF EXISTS `attendance_todo_item_answer_information`;

CREATE TABLE `attendance_todo_item_answer_information` (
  `atiai_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `employee_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `attendance_settings_id` int(10) NOT NULL,
  `todo_items_id` int(10) NOT NULL,
  `text_answer` varchar(255) DEFAULT NULL,
  `report` longtext DEFAULT NULL,
  PRIMARY KEY (`atiai_id`),
  KEY `CompanyID` (`company_id`),
  KEY `EmployeeID` (`employee_id`),
  KEY `CourseID` (`course_id`),
  KEY `Attendance_settings_id` (`attendance_settings_id`),
  KEY `todo_items_id` (`todo_items_id`),
  CONSTRAINT `attendance_todo_item_answer_information_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `company_information` (`company_id`),
  CONSTRAINT `attendance_todo_item_answer_information_ibfk_2` FOREIGN KEY (`Employee_ID`) REFERENCES `employee_information` (`employee_id`),
  CONSTRAINT `attendance_todo_item_answer_information_ibfk_3` FOREIGN KEY (`Course_ID`) REFERENCES `course_information` (`course_ID`),
  CONSTRAINT `attendance_todo_item_answer_information_ibfk_4` FOREIGN KEY (`Attendance_settings_id`) REFERENCES `course_schedule_results_information` (`Attendance_setting_id`),
  CONSTRAINT `attendance_todo_item_answer_information_ibfk_5` FOREIGN KEY (`todo_items_id`) REFERENCES `course_todo_item_information` (`ToDo_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `attendance_todo_item_answer_information` */

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `company_information` */

DROP TABLE IF EXISTS `company_information`;

CREATE TABLE `company_information` (
  `company_id` int(20) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(20) NOT NULL,
  `login_screen_url` varchar(255) NOT NULL,
  `icon_storage_file_path` varchar(255) NOT NULL,
  `teaching_material_storage_file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`company_id`),
  KEY `company_information_company_id_foreign` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `company_information` */

/*Table structure for table `course_attribute_pulldown_settings` */

DROP TABLE IF EXISTS `course_attribute_pulldown_settings`;

CREATE TABLE `course_attribute_pulldown_settings` (
  `capsi_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `course_attribute_number` decimal(2,0) DEFAULT NULL,
  `pulldown_list_1` varchar(20) DEFAULT NULL,
  `pulldown_list_2` varchar(20) DEFAULT NULL,
  `pulldown_list_3` varchar(20) DEFAULT NULL,
  `pulldown_list_4` varchar(20) DEFAULT NULL,
  `pulldown_list_5` varchar(20) DEFAULT NULL,
  `pulldown_list_6` varchar(20) DEFAULT NULL,
  `pulldown_list_7` varchar(20) DEFAULT NULL,
  `pulldown_list_8` varchar(20) DEFAULT NULL,
  `pulldown_list_9` varchar(20) DEFAULT NULL,
  `pulldown_list_10` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`capsi_id`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `course_attribute_pulldown_settings_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `course_attribute_pulldown_settings` */

/*Table structure for table `course_attribute_setting_information` */

DROP TABLE IF EXISTS `course_attribute_setting_information`;

CREATE TABLE `course_attribute_setting_information` (
  `casi_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `course_attribute01_displayname` varchar(20) DEFAULT NULL,
  `course_attribute01_displayrank` varchar(3) DEFAULT NULL,
  `course_attribute01_screentype` char(1) DEFAULT NULL,
  `course_attribute01_numberofscreen_digits` decimal(3,0) DEFAULT NULL,
  `course_attribute01_attendance_selection` char(1) DEFAULT NULL,
  `course_attribute02_displayname` varchar(20) DEFAULT NULL,
  `course_attribute02_displayrank` varchar(3) DEFAULT NULL,
  `course_attribute02_screentype` char(1) DEFAULT NULL,
  `course_attribute02_numberofscreen_digits` decimal(3,0) DEFAULT NULL,
  `course_attribute02_attendance_selection` char(1) DEFAULT NULL,
  `course_attribute03_displayname` varchar(20) DEFAULT NULL,
  `course_attribute03_displayrank` varchar(3) DEFAULT NULL,
  `course_attribute03_screentype` char(1) DEFAULT NULL,
  `course_attribute03_numberofscreen_digits` decimal(3,0) DEFAULT NULL,
  `course_attribute03_attendance_selection` char(1) DEFAULT NULL,
  `course_attribute04_displayname` varchar(20) DEFAULT NULL,
  `course_attribute04_displayrank` varchar(3) DEFAULT NULL,
  `course_attribute04_screentype` char(1) DEFAULT NULL,
  `course_attribute04_numberofscreen_digits` decimal(3,0) DEFAULT NULL,
  `course_attribute04_attendance_selection` char(1) DEFAULT NULL,
  `course_attribute05_displayname` varchar(20) DEFAULT NULL,
  `course_attribute05_displayrank` varchar(3) DEFAULT NULL,
  `course_attribute05_screentype` char(1) DEFAULT NULL,
  `course_attribute05_screen_columncount` decimal(3,0) DEFAULT NULL,
  `course_attributes05_enrollment_selection` char(1) DEFAULT NULL,
  PRIMARY KEY (`casi_id`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `course_attribute_setting_information_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `course_attribute_setting_information` */

/*Table structure for table `course_classification_detail_information` */

DROP TABLE IF EXISTS `course_classification_detail_information`;

CREATE TABLE `course_classification_detail_information` (
  `course_classification_details_id` int(10) NOT NULL AUTO_INCREMENT,
  `Course_classification_id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `course_classification_detailsname` varchar(15) DEFAULT NULL,
  `icon_file_path` varchar(255) DEFAULT NULL,
  `display_order` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`course_classification_details_id`),
  KEY `CourseclassificationID` (`Course_classification_id`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `course_classification_detail_information_ibfk_1` FOREIGN KEY (`Course_classification_id`) REFERENCES `course_classification_information` (`course_classification_id`),
  CONSTRAINT `course_classification_detail_information_ibfk_2` FOREIGN KEY (`Company_ID`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `course_classification_detail_information` */

/*Table structure for table `course_classification_information` */

DROP TABLE IF EXISTS `course_classification_information`;

CREATE TABLE `course_classification_information` (
  `course_classification_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `course_classification_name` varchar(10) DEFAULT NULL,
  `icon_file_path` varchar(255) DEFAULT NULL,
  `displayorder` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`course_classification_id`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `course_classification_information_ibfk_1` FOREIGN KEY (`Company_id`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `course_classification_information` */

/*Table structure for table `course_information` */

DROP TABLE IF EXISTS `course_information`;

CREATE TABLE `course_information` (
  `course_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `Course_classification_id` int(10) NOT NULL,
  `course_classification_details_id` int(10) NOT NULL,
  `coursename` varchar(30) NOT NULL,
  `coursename_kana` varchar(30) NOT NULL,
  `course_description` longtext DEFAULT NULL,
  `possible_retake_course_deadline` char(3) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `todo_type` char(3) DEFAULT NULL,
  `todo_description` longtext DEFAULT NULL,
  `repeated_retest` char(3) DEFAULT NULL,
  `test_passed_score` decimal(6,0) NOT NULL,
  `course_attributes_01` varchar(255) NOT NULL,
  `course_attributes_02` varchar(255) NOT NULL,
  `course_attributes_03` varchar(255) NOT NULL,
  `course_attributes_04` varchar(255) NOT NULL,
  `course_attributes_05` varchar(255) NOT NULL,
  PRIMARY KEY (`course_id`),
  KEY `CompanyID` (`company_id`),
  KEY `CourseclassificationID` (`Course_classification_id`),
  KEY `ccdi_id` (`course_classification_details_id`),
  CONSTRAINT `course_information_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company_information` (`company_id`),
  CONSTRAINT `course_information_ibfk_2` FOREIGN KEY (`Course_classification_id`) REFERENCES `course_classification_information` (`course_classification_id`),
  CONSTRAINT `course_information_ibfk_3` FOREIGN KEY (`course_classification_details_id`) REFERENCES `course_classification_detail_information` (`course_classification_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `course_information` */

/*Table structure for table `course_material_information` */

DROP TABLE IF EXISTS `course_material_information`;

CREATE TABLE `course_material_information` (
  `material_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `Course_id` int(10) NOT NULL,
  `display_order` varchar(3) NOT NULL,
  `teaching_material_name` varchar(20) NOT NULL,
  `material_type` char(2) DEFAULT NULL,
  `youtube_video_url` varchar(255) DEFAULT NULL,
  `book_file_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`material_id`),
  KEY `CompanyID` (`company_id`),
  KEY `CourseID` (`Course_id`),
  CONSTRAINT `course_material_information_ibfk_1` FOREIGN KEY (`Company_id`) REFERENCES `company_information` (`company_id`),
  CONSTRAINT `course_material_information_ibfk_2` FOREIGN KEY (`Course_id`) REFERENCES `course_information` (`course_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `course_material_information` */

/*Table structure for table `course_schedule_results_information` */

DROP TABLE IF EXISTS `course_schedule_results_information`;

CREATE TABLE `course_schedule_results_information` (
  `attendance_setting_id` int(10) NOT NULL AUTO_INCREMENT,
  `course_id` int(10) NOT NULL,
  `employee_id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `schedule_course` datetime DEFAULT NULL,
  `course_information` datetime DEFAULT NULL,
  `deadline_enrollment` date DEFAULT NULL,
  `todo_progress` char(3) DEFAULT NULL,
  `todo_complete` datetime DEFAULT NULL,
  `number_test_conducted` varchar(3) DEFAULT NULL,
  `first_test_correct_answer_rate` varchar(6) DEFAULT NULL,
  `latest_test_number_correct_answer` varchar(3) DEFAULT NULL,
  `latest_test_accuracy_rate` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`attendance_setting_id`),
  KEY `CourseID` (`course_id`),
  KEY `EmployeeID` (`employee_id`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `course_schedule_results_information_ibfk_1` FOREIGN KEY (`Course_id`) REFERENCES `course_information` (`course_ID`),
  CONSTRAINT `course_schedule_results_information_ibfk_2` FOREIGN KEY (`Employee_id`) REFERENCES `employee_information` (`employee_id`),
  CONSTRAINT `course_schedule_results_information_ibfk_3` FOREIGN KEY (`Company_id`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `course_schedule_results_information` */

/*Table structure for table `course_todo_item_information` */

DROP TABLE IF EXISTS `course_todo_item_information`;

CREATE TABLE `course_todo_item_information` (
  `todo_item_id` int(10) NOT NULL AUTO_INCREMENT,
  `course_id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `display_order` varchar(3) NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer_type` char(3) DEFAULT NULL,
  `required_settings` char(3) DEFAULT NULL,
  `test_explained` longtext DEFAULT NULL,
  PRIMARY KEY (`todo_item_id`),
  KEY `CourseID` (`course_id`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `course_todo_item_information_ibfk_1` FOREIGN KEY (`Course_id`) REFERENCES `course_information` (`course_ID`),
  CONSTRAINT `course_todo_item_information_ibfk_2` FOREIGN KEY (`Company_id`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `course_todo_item_information` */

/*Table structure for table `course_todo_items_choice_information` */

DROP TABLE IF EXISTS `course_todo_items_choice_information`;

CREATE TABLE `course_todo_items_choice_information` (
  `todo_option_id` int(10) NOT NULL AUTO_INCREMENT,
  `todo_items_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `display_order` varchar(3) DEFAULT NULL,
  `choices` varchar(50) DEFAULT NULL,
  `test_choice_correct_answer` char(1) DEFAULT NULL,
  PRIMARY KEY (`todo_option_id`),
  KEY `ToDo_items_id` (`todo_items_id`),
  KEY `CourseID` (`course_id`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `course_todo_items_choice_information_ibfk_1` FOREIGN KEY (`ToDo_items_id`) REFERENCES `course_todo_item_information` (`ToDo_item_id`),
  CONSTRAINT `course_todo_items_choice_information_ibfk_2` FOREIGN KEY (`Course_id`) REFERENCES `course_information` (`course_ID`),
  CONSTRAINT `course_todo_items_choice_information_ibfk_3` FOREIGN KEY (`Company_id`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `course_todo_items_choice_information` */

/*Table structure for table `employee_affiliation_information` */

DROP TABLE IF EXISTS `employee_affiliation_information`;

CREATE TABLE `employee_affiliation_information` (
  `eai_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `affiliation_code` int(9) NOT NULL,
  `job_id` int(3) NOT NULL,
  `application_startdate` date DEFAULT NULL,
  `enddate_of_application` date DEFAULT NULL,
  `system_administrator_privileges` char(1) DEFAULT NULL,
  `employee_registration_authority` char(1) DEFAULT NULL,
  `course_enrollment_privileges` char(1) DEFAULT NULL,
  `attendance_setting_authority` char(1) DEFAULT NULL,
  `authority_validity_scope` char(1) DEFAULT NULL,
  `authority_validity_code` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`eai_id`),
  KEY `AffiliationCode` (`affiliation_code`),
  KEY `CompanyID` (`company_id`),
  KEY `JobID` (`job_id`),
  CONSTRAINT `employee_affiliation_information_ibfk_1` FOREIGN KEY (`Affiliation_Code`) REFERENCES `affiliation_information` (`Affiliation_Code`),
  CONSTRAINT `employee_affiliation_information_ibfk_2` FOREIGN KEY (`Company_id`) REFERENCES `company_information` (`company_id`),
  CONSTRAINT `employee_affiliation_information_ibfk_3` FOREIGN KEY (`Job_ID`) REFERENCES `job_information` (`Job_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `employee_affiliation_information` */

/*Table structure for table `employee_attribute_dropdown_settings_information` */

DROP TABLE IF EXISTS `employee_attribute_dropdown_settings_information`;

CREATE TABLE `employee_attribute_dropdown_settings_information` (
  `eadsi_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `employee_attribute_number` decimal(2,0) DEFAULT NULL,
  `pulldown_list_1` varchar(20) DEFAULT NULL,
  `pulldown_list_2` varchar(20) DEFAULT NULL,
  `pulldown_list_3` varchar(20) DEFAULT NULL,
  `pulldown_list_4` varchar(20) DEFAULT NULL,
  `pulldown_list_5` varchar(20) DEFAULT NULL,
  `pulldown_list_6` varchar(20) DEFAULT NULL,
  `pulldown_list_7` varchar(20) DEFAULT NULL,
  `pulldown_list_8` varchar(20) DEFAULT NULL,
  `pulldown_list_9` varchar(20) DEFAULT NULL,
  `pulldown_list_10` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`eadsi_id`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `employee_attribute_dropdown_settings_information_ibfk_1` FOREIGN KEY (`Company_id`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `employee_attribute_dropdown_settings_information` */

/*Table structure for table `employee_attribute_setting_information` */

DROP TABLE IF EXISTS `employee_attribute_setting_information`;

CREATE TABLE `employee_attribute_setting_information` (
  `easi_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `employee_attribute01_displayname` varchar(20) DEFAULT NULL,
  `employee_attribute01_displayorder` char(3) DEFAULT NULL,
  `employee_attribute01_screentype` varchar(20) DEFAULT NULL,
  `employee_attribute01_screencolumn_count` decimal(3,0) DEFAULT NULL,
  `employee_attribute01_courseselection` char(3) DEFAULT NULL,
  `employee_attribute02_displayname` varchar(20) DEFAULT NULL,
  `employee_attribute02_displayorder` char(3) DEFAULT NULL,
  `employee_attribute02_screentype` varchar(20) DEFAULT NULL,
  `employee_attribute02_screencolumn_count` decimal(3,0) DEFAULT NULL,
  `employee_attribute02_courseselection` char(3) DEFAULT NULL,
  `employee_attribute03_displayname` varchar(20) DEFAULT NULL,
  `employee_attribute03_displayorder` char(3) DEFAULT NULL,
  `employee_attribute03_screentype` varchar(20) DEFAULT NULL,
  `employee_attribute03_screencolumn_count` decimal(3,0) DEFAULT NULL,
  `employee_attribute03_courseselection` char(3) DEFAULT NULL,
  `employee_attribute04_displayname` varchar(20) DEFAULT NULL,
  `employee_attribute04_displayrank` char(3) DEFAULT NULL,
  `employee_attribute04_screentype` varchar(20) DEFAULT NULL,
  `employee_attribute04_screencolumn_count` decimal(3,0) DEFAULT NULL,
  `employee_attribute04_attendance_selection` char(3) DEFAULT NULL,
  `employee_attribute05_displayname` varchar(20) DEFAULT NULL,
  `employee_attribute05_displayrank` char(3) DEFAULT NULL,
  `employee_attribute05_screentype` varchar(20) DEFAULT NULL,
  `employee_attribute05_screencolumn_count` decimal(3,0) DEFAULT NULL,
  `employee_attribute05_courseselection` char(3) DEFAULT NULL,
  PRIMARY KEY (`easi_id`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `employee_attribute_setting_information_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `employee_attribute_setting_information` */

/*Table structure for table `employee_information` */

DROP TABLE IF EXISTS `employee_information`;

CREATE TABLE `employee_information` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `fullname` varchar(20) DEFAULT NULL,
  `kananame` varchar(20) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `contact_phonenumber` varchar(13) DEFAULT NULL,
  `employee_code` varchar(10) DEFAULT NULL,
  `sex` char(1) DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `dateofjoining` date DEFAULT NULL,
  `retirementdate` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `encrypted_password` varchar(255) DEFAULT NULL,
  `account_status` char(1) DEFAULT NULL,
  `password_expiration` date DEFAULT NULL,
  `numberofincorrect_passwords` int(10) DEFAULT NULL,
  `account_lock_datetime` datetime DEFAULT NULL,
  `employee_attribute01` varchar(255) DEFAULT NULL,
  `employee_attribute02` varchar(255) DEFAULT NULL,
  `employee_attribute03` varchar(255) DEFAULT NULL,
  `employee_attribute04` varchar(255) DEFAULT NULL,
  `employee_attribute05` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`employee_id`),
  KEY `CompanyID` (`company_id`),
  CONSTRAINT `employee_information_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company_information` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `employee_information` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_batches` */

/*Table structure for table `job_information` */

DROP TABLE IF EXISTS `job_information`;

CREATE TABLE `job_information` (
  `Job_id` int(3) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `job_title` varchar(10) DEFAULT NULL,
  `display_order` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`Job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `job_information` */

insert  into `job_information`(`Job_id`,`company_id`,`job_title`,`display_order`) values 
(1,0,'employee','080');

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2024_05_05_154528_create_company_information_table',2);

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('JdJFjL0tH0R7NBXJhQlLaMaDBfvh8TXRmcZLcy8g',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:125.0) Gecko/20100101 Firefox/125.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTEtGQ0xOOUNvM0ZadEZaVnFWMEpIWklKeERBbzBld2gzNTNONjQwbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb3Vyc2UtY2xhc3NpZmljYXRpb24tZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==',1715328689);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(2,'Amirul Putra Justicia, A.Md., S.Kom.','amirul@m2group.co.id',NULL,'$2y$12$chCPlH84FquLHxjb5e1EGeZHWdh/12OsNH6T49j0e1xWjDDneh86O',NULL,'2024-05-06 01:33:30','2024-05-06 01:33:30');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
