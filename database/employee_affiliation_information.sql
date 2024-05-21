/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.32-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `employee_affiliation_information` (
	`eai_id` int (11),
	`company_id` int (11),
	`affiliation_code` varchar (27),
	`job_id` int (3),
	`application_startdate` date ,
	`enddate_of_application` date ,
	`system_administrator_privileges` char (3),
	`employee_registration_authority` char (3),
	`course_enrollment_privileges` char (3),
	`attendance_setting_authority` char (3),
	`authority_validity_scope` char (3),
	`authority_validity_code` varchar (27)
); 
