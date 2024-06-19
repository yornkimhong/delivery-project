/*
 Navicat Premium Data Transfer

 Source Server         : MYSQL
 Source Server Type    : MySQL
 Source Server Version : 100428
 Source Host           : localhost:3306
 Source Schema         : delivery

 Target Server Type    : MySQL
 Target Server Version : 100428
 File Encoding         : 65001

 Date: 19/06/2024 09:19:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for branch
-- ----------------------------
DROP TABLE IF EXISTS `branch`;
CREATE TABLE `branch`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alt_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of branch
-- ----------------------------
INSERT INTO `branch` VALUES (1, 'phonh penh', '1234654', '4564646', 'PP');
INSERT INTO `branch` VALUES (3, 'preah vihea', '0973476642', '0887454387', 'pvh');
INSERT INTO `branch` VALUES (7, 'preyveng', '0128763498', '0977354287', 'pv');
INSERT INTO `branch` VALUES (10, 'kompongtom', '076287694', '0991247476', 'kpt');
INSERT INTO `branch` VALUES (11, 'kompot', '0663476523', '09676583455', 'kp');
INSERT INTO `branch` VALUES (12, 'keb', '09723568234', '07187687343', 'keb');
INSERT INTO `branch` VALUES (13, 'kompongcham', '012894764', '097786874', 'kpm');

-- ----------------------------
-- Table structure for branch_confirm
-- ----------------------------
DROP TABLE IF EXISTS `branch_confirm`;
CREATE TABLE `branch_confirm`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `invoice_id` int NOT NULL,
  `branch_id` int NOT NULL,
  `confirm_status` int NULL DEFAULT 0 COMMENT '0=not yet,1=confirm',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `invoice_id`(`invoice_id` ASC) USING BTREE,
  INDEX `branch_id`(`branch_id` ASC) USING BTREE,
  CONSTRAINT `branch_confirm_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `branch_confirm_ibfk_3` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of branch_confirm
-- ----------------------------
INSERT INTO `branch_confirm` VALUES (19, 5, 1, 0);
INSERT INTO `branch_confirm` VALUES (20, 6, 1, 0);
INSERT INTO `branch_confirm` VALUES (21, 7, 1, 0);
INSERT INTO `branch_confirm` VALUES (28, 14, 11, 0);
INSERT INTO `branch_confirm` VALUES (29, 15, 1, 0);
INSERT INTO `branch_confirm` VALUES (30, 16, 1, 0);
INSERT INTO `branch_confirm` VALUES (31, 17, 1, 0);

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `receiver_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `receiver_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `current_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (22, 'kimhong', '0988764732', 'thearith', '09778235487', 'pvh');
INSERT INTO `customer` VALUES (23, 'thida', '0127687345', 'nita', '0972453522', 'pvh');
INSERT INTO `customer` VALUES (24, 'sela', '01279876345', 'kunthea', '0766523754', 'pvh');
INSERT INTO `customer` VALUES (31, 'maly', '01876485', 'thida', '097176564', 'kompot');
INSERT INTO `customer` VALUES (32, 'chheang', '09776834', 'thea', '097786343', 'pp');
INSERT INTO `customer` VALUES (33, 'theary', '097682716', 'thearith', '076172356', 'pp');
INSERT INTO `customer` VALUES (34, 'vid', '012874798', 'dy', '0661735643', 'pp');

-- ----------------------------
-- Table structure for insurance
-- ----------------------------
DROP TABLE IF EXISTS `insurance`;
CREATE TABLE `insurance`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fee` decimal(12, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of insurance
-- ----------------------------
INSERT INTO `insurance` VALUES (2, 'type A', 10.20);
INSERT INTO `insurance` VALUES (3, 'type BA', 10.20);
INSERT INTO `insurance` VALUES (6, 'type 2', 432.00);

-- ----------------------------
-- Table structure for invoice
-- ----------------------------
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NULL DEFAULT NULL,
  `receiver_id` int NULL DEFAULT NULL,
  `sender_branch_id` int NULL DEFAULT NULL,
  `receiver_branch_id` int NULL DEFAULT NULL,
  `item_detail_id` int NULL DEFAULT NULL,
  `payment_responsibiity` int UNSIGNED NULL DEFAULT NULL COMMENT '0=false,1=true',
  `approve_by_user_id` int NULL DEFAULT NULL,
  `payment_method` int NULL DEFAULT NULL,
  `take_out_date` datetime NULL DEFAULT NULL,
  `insurance_id` int NULL DEFAULT NULL COMMENT '1=safe,2=lose,3=broken',
  `penalty_id` int NULL DEFAULT NULL COMMENT '1=no penalty 2=first penalty 3= second penalty',
  `delivery_cost` decimal(12, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sender_branch_id`(`sender_branch_id` ASC) USING BTREE,
  INDEX `receiver_branch_id`(`receiver_branch_id` ASC) USING BTREE,
  INDEX `payment_method`(`payment_method` ASC) USING BTREE,
  INDEX `item_detail_id`(`item_detail_id` ASC) USING BTREE,
  INDEX `approve_by_user_id`(`approve_by_user_id` ASC) USING BTREE,
  INDEX `sender_id`(`sender_id` ASC) USING BTREE,
  INDEX `receiver_id`(`receiver_id` ASC) USING BTREE,
  INDEX `insurance_id`(`insurance_id` ASC) USING BTREE,
  INDEX `penalty_id`(`penalty_id` ASC) USING BTREE,
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`payment_method`) REFERENCES `payment_method` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`insurance_id`) REFERENCES `insurance` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`penalty_id`) REFERENCES `penalty` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoice_ibfk_4` FOREIGN KEY (`item_detail_id`) REFERENCES `item_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoice_ibfk_5` FOREIGN KEY (`sender_branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoice_ibfk_6` FOREIGN KEY (`receiver_branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoice_ibfk_7` FOREIGN KEY (`sender_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoice_ibfk_8` FOREIGN KEY (`receiver_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of invoice
-- ----------------------------
INSERT INTO `invoice` VALUES (5, 22, 22, 1, 3, 38, 0, NULL, 4, NULL, 3, 2, 1.00);
INSERT INTO `invoice` VALUES (6, 23, 23, 1, 3, 39, 0, NULL, 4, NULL, 2, 2, 1.00);
INSERT INTO `invoice` VALUES (7, 24, 24, 3, 3, 40, 0, NULL, 4, NULL, 2, 2, 3.00);
INSERT INTO `invoice` VALUES (14, 31, 31, 11, 3, 47, 1, NULL, 3, NULL, 2, 2, 10000.00);
INSERT INTO `invoice` VALUES (15, 32, 32, 1, 7, 48, 1, NULL, 4, NULL, 2, 2, 15000.00);
INSERT INTO `invoice` VALUES (16, 33, 33, 1, 3, 49, 0, NULL, 4, NULL, 2, 2, 20000.00);
INSERT INTO `invoice` VALUES (17, 34, 34, 1, 10, 50, 1, NULL, 4, NULL, 2, 2, 5000.00);

-- ----------------------------
-- Table structure for item_detail
-- ----------------------------
DROP TABLE IF EXISTS `item_detail`;
CREATE TABLE `item_detail`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of item_detail
-- ----------------------------
INSERT INTO `item_detail` VALUES (38, NULL, 3);
INSERT INTO `item_detail` VALUES (39, NULL, 2);
INSERT INTO `item_detail` VALUES (40, 'fdsa', 3);
INSERT INTO `item_detail` VALUES (43, 'dsad', 3);
INSERT INTO `item_detail` VALUES (47, NULL, 1);
INSERT INTO `item_detail` VALUES (48, NULL, 2);
INSERT INTO `item_detail` VALUES (49, NULL, 1);
INSERT INTO `item_detail` VALUES (50, NULL, 1);

-- ----------------------------
-- Table structure for payment_method
-- ----------------------------
DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE `payment_method`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payment_method
-- ----------------------------
INSERT INTO `payment_method` VALUES (3, 'ABA');
INSERT INTO `payment_method` VALUES (4, 'Cash');
INSERT INTO `payment_method` VALUES (5, 'ACLEDA');

-- ----------------------------
-- Table structure for penalty
-- ----------------------------
DROP TABLE IF EXISTS `penalty`;
CREATE TABLE `penalty`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of penalty
-- ----------------------------
INSERT INTO `penalty` VALUES (2, 'first penalty', 'past a week');
INSERT INTO `penalty` VALUES (6, 'secound penalty', 'past 2 week');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rememer_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'sokheng', 'sokheng@gmail.com', '0886549727', NULL, '$2y$10$wqSH0GyRI7oo5PCeDKQZseTRWYjZ.AgG8qZTW5nmIgcF/ICECYSXC', NULL, '2024-06-17 08:39:44', '2024-06-19 01:53:58');
INSERT INTO `users` VALUES (2, 'kimhonggg', 'kimhonggg@gmail.com', '076457895', NULL, '$2y$10$By5O3GLAVNneNiDHPu/UvOndIEx9H.pxGEngSmTFqvGfSDCnZsNsi', NULL, '2024-06-17 08:40:21', '2024-06-19 01:53:35');
INSERT INTO `users` VALUES (3, 'Panha', 'Panha@gmail.com', '0973645187', NULL, '$2y$10$QYbcV1y/CRoTvtpm90QhPeWq63MmtiEZTlrTN41AG4OEnrekFzdWG', NULL, '2024-06-17 08:48:06', '2024-06-19 01:53:10');
INSERT INTO `users` VALUES (4, 'Rin Thearith', 'thearith@gmail.com', '012585748', NULL, '$2y$10$dJksaaDHjC6DXq/z4lof3uY2bqOY5JgflRbKI7w9lcvSCYxIQZELK', NULL, '2024-06-17 08:50:04', '2024-06-19 01:52:10');

SET FOREIGN_KEY_CHECKS = 1;
