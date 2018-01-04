/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : examinationsytem

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-01-04 11:44:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `account` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------

-- ----------------------------
-- Table structure for award
-- ----------------------------
DROP TABLE IF EXISTS `award`;
CREATE TABLE `award` (
  `award_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`award_id`),
  KEY `students` (`student_id`),
  CONSTRAINT `students` FOREIGN KEY (`student_id`) REFERENCES `student` (`stu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of award
-- ----------------------------

-- ----------------------------
-- Table structure for notice
-- ----------------------------
DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `notice_id` int(11) NOT NULL,
  `account` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`notice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of notice
-- ----------------------------

-- ----------------------------
-- Table structure for officer
-- ----------------------------
DROP TABLE IF EXISTS `officer`;
CREATE TABLE `officer` (
  `officer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `notice_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`officer_id`),
  KEY `notice_of` (`notice_id`),
  KEY `admin_of` (`admin_id`),
  CONSTRAINT `admin_of` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `notice_of` FOREIGN KEY (`notice_id`) REFERENCES `notice` (`notice_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of officer
-- ----------------------------

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `stu_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `idcard` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `graduate_time` datetime DEFAULT NULL,
  `stu_style` char(255) DEFAULT NULL,
  `language_style` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `notice_id` int(11) DEFAULT NULL,
  `officer_id` int(11) DEFAULT NULL,
  `test_style_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stu_id`),
  KEY `test_style` (`test_style_id`),
  KEY `notice` (`notice_id`),
  KEY `officer_id` (`officer_id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `admin_id` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `notice` FOREIGN KEY (`notice_id`) REFERENCES `notice` (`notice_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `officer_id` FOREIGN KEY (`officer_id`) REFERENCES `officer` (`officer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `test_style` FOREIGN KEY (`test_style_id`) REFERENCES `test_style` (`test_style_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student
-- ----------------------------

-- ----------------------------
-- Table structure for student_subject
-- ----------------------------
DROP TABLE IF EXISTS `student_subject`;
CREATE TABLE `student_subject` (
  `subject_stu_id` int(11) NOT NULL,
  `sudent_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`subject_stu_id`),
  KEY `student_z` (`sudent_id`),
  KEY `subject_z` (`subject_id`),
  CONSTRAINT `student_z` FOREIGN KEY (`sudent_id`) REFERENCES `student` (`stu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subject_z` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student_subject
-- ----------------------------

-- ----------------------------
-- Table structure for subject
-- ----------------------------
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `score` double DEFAULT NULL,
  `test_time` datetime DEFAULT NULL,
  `test_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of subject
-- ----------------------------

-- ----------------------------
-- Table structure for subject_test_style
-- ----------------------------
DROP TABLE IF EXISTS `subject_test_style`;
CREATE TABLE `subject_test_style` (
  `subject_testyle_id` int(11) NOT NULL,
  `test_style_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`subject_testyle_id`),
  KEY `subject_zh` (`subject_id`),
  KEY `test_style_zh` (`test_style_id`),
  CONSTRAINT `subject_zh` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `test_style_zh` FOREIGN KEY (`test_style_id`) REFERENCES `test_style` (`test_style_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of subject_test_style
-- ----------------------------

-- ----------------------------
-- Table structure for test_card
-- ----------------------------
DROP TABLE IF EXISTS `test_card`;
CREATE TABLE `test_card` (
  `test_card_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`test_card_id`),
  KEY `student` (`student_id`),
  CONSTRAINT `student` FOREIGN KEY (`student_id`) REFERENCES `student` (`stu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_card
-- ----------------------------

-- ----------------------------
-- Table structure for test_style
-- ----------------------------
DROP TABLE IF EXISTS `test_style`;
CREATE TABLE `test_style` (
  `test_style_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `introduce` varchar(255) DEFAULT NULL,
  `start_data` date DEFAULT NULL,
  `end_data` date DEFAULT NULL,
  `officer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`test_style_id`),
  KEY `officer_st` (`officer_id`),
  CONSTRAINT `officer_st` FOREIGN KEY (`officer_id`) REFERENCES `officer` (`officer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_style
-- ----------------------------
