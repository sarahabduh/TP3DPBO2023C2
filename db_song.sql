/*
Navicat MySQL Data Transfer

Source Server         : db
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_song

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-05-25 04:17:46
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `album`
-- ----------------------------
DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of album
-- ----------------------------
INSERT INTO `album` VALUES ('1', 'Be the Cowboy');
INSERT INTO `album` VALUES ('2', 'UNFORGIVEN');
INSERT INTO `album` VALUES ('3', 'LILAC');
INSERT INTO `album` VALUES ('4', 'Palette');
INSERT INTO `album` VALUES ('5', 'Encore');
INSERT INTO `album` VALUES ('11', 'ANTIFRAGILE');
INSERT INTO `album` VALUES ('12', 'Bury Me at Makeout Creek');
INSERT INTO `album` VALUES ('13', 'Laurel Hell');
INSERT INTO `album` VALUES ('15', 'folklore');
INSERT INTO `album` VALUES ('16', 'Kaikai Kitan / Ao no Waltz');

-- ----------------------------
-- Table structure for `artist`
-- ----------------------------
DROP TABLE IF EXISTS `artist`;
CREATE TABLE `artist` (
  `artist_id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of artist
-- ----------------------------
INSERT INTO `artist` VALUES ('1', 'Mitski');
INSERT INTO `artist` VALUES ('2', 'LE SSERAFIM');
INSERT INTO `artist` VALUES ('3', 'back number');
INSERT INTO `artist` VALUES ('5', 'IU');
INSERT INTO `artist` VALUES ('6', 'Taylor Swift');
INSERT INTO `artist` VALUES ('7', 'Eve');

-- ----------------------------
-- Table structure for `song`
-- ----------------------------
DROP TABLE IF EXISTS `song`;
CREATE TABLE `song` (
  `song_id` int(11) NOT NULL AUTO_INCREMENT,
  `song_pic` varchar(255) DEFAULT NULL,
  `song_name` varchar(100) DEFAULT NULL,
  `song_year` int(4) DEFAULT NULL,
  `artist_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`song_id`),
  KEY `fk_artist` (`artist_id`),
  KEY `album_id` (`album_id`),
  CONSTRAINT `fk_artist` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`artist_id`) ON UPDATE CASCADE,
  CONSTRAINT `song_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of song
-- ----------------------------
INSERT INTO `song` VALUES ('2', null, null, null, null, null);
INSERT INTO `song` VALUES ('5', 'Bury_Me_At_Makeout_Creek.jpg', 'First Love / Late Spring', '2014', '1', '12');
INSERT INTO `song` VALUES ('6', 'unforgiven.png', 'Fire in the belly', '2023', '2', '2');
INSERT INTO `song` VALUES ('7', 'Be_the_Cowboy.jpg', 'Geyser', '2018', '1', '1');
INSERT INTO `song` VALUES ('8', 'aonowaltz.jpg', 'Ao no Waltz', '2020', '7', '16');
INSERT INTO `song` VALUES ('9', '9145Qjhv4cL._SL1500_.jpg', 'Shiawase', '2016', '3', '5');
INSERT INTO `song` VALUES ('10', 'IU_Palette.jpg', 'Through the Night', '2017', '5', '4');
INSERT INTO `song` VALUES ('11', 'Taylor_Swift_-_Folklore.png', 'my tears ricochet', '2020', '6', '15');
INSERT INTO `song` VALUES ('12', 'IU_-_Lilac.png', 'My sea', '2021', '5', '3');
