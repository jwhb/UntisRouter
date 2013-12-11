SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `substitutions`
-- ----------------------------
DROP TABLE IF EXISTS `substitutions`;
CREATE TABLE `substitutions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grade` varchar(20) NOT NULL,
  `date` date DEFAULT NULL,
  `time` tinyint(2) DEFAULT NULL,
  `teacher` varchar(20) DEFAULT NULL,
  `class` varchar(20) DEFAULT NULL,
  `room` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `room_old` varchar(20) DEFAULT NULL,
  `info_text` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;
