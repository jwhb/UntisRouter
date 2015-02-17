SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `groups` (
`id` mediumint(8) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'moderators', 'Moderators');

CREATE TABLE IF NOT EXISTS `login_attempts` (
`id` int(11) unsigned NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `subjects` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `substitutions` (
`id` int(10) unsigned NOT NULL,
  `grade` varchar(20) NOT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(10) DEFAULT NULL,
  `teacher` varchar(20) DEFAULT NULL,
  `class` varchar(20) DEFAULT NULL,
  `room` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `room_old` varchar(20) DEFAULT NULL,
  `info_text` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `subst_texts` (
`id` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `text` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) unsigned NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fav_subjects` varchar(200) DEFAULT NULL,
  `fav_hobbies` varchar(200) DEFAULT NULL,
  `fav_child_job` varchar(200) DEFAULT NULL,
  `fav_occupation` varchar(200) DEFAULT NULL,
  `fav_lifegoal` varchar(200) DEFAULT NULL,
  `fav_cite` varchar(200) DEFAULT NULL,
  `mem_events` varchar(200) DEFAULT NULL,
  `photo1_id` varchar(64) DEFAULT NULL,
  `photo2_id` varchar(64) DEFAULT NULL,
  `q1_q` tinyint(4) NOT NULL,
  `q1_a` text NOT NULL,
  `q2_q` tinyint(4) NOT NULL,
  `q2_a` text NOT NULL,
  `q3_q` tinyint(4) NOT NULL,
  `q3_a` text NOT NULL,
  `q4_q` tinyint(4) NOT NULL,
  `q4_a` text NOT NULL,
  `q5_q` tinyint(4) NOT NULL,
  `q5_a` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `fav_subjects`, `fav_hobbies`, `fav_child_job`, `fav_occupation`, `fav_lifegoal`, `fav_cite`, `mem_events`, `fav_abimotto`, `photo1_id`, `photo2_id`, `q1_q`, `q1_a`, `q2_q`, `q2_a`, `q3_q`, `q3_a`, `q4_q`, `q4_a`, `q5_q`, `q5_a`) VALUES
(1, '::1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', NULL, 'admin@admin.com', NULL, NULL, NULL, 'ZWnOQJglbrFrgua.C6NL0.', 0, 1424174057, 1, 'Admin', 'Istrator', 'Sys', '0000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', 0, '', 0, '', 0, '', 0, '');

CREATE TABLE IF NOT EXISTS `users_comments` (
`id` int(11) NOT NULL,
  `user_for_id` int(11) NOT NULL,
  `user_from_id` int(11) NOT NULL,
  `text` varchar(400) NOT NULL,
  `time` int(11) NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` int(10) unsigned DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `users_groups` (
`id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 2);

CREATE TABLE IF NOT EXISTS `users_subjects` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `login_attempts`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `subjects`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `substitutions`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `subst_texts`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `users_comments`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `users_groups`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`), ADD KEY `fk_users_groups_users1_idx` (`user_id`), ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

ALTER TABLE `users_subjects`
 ADD PRIMARY KEY (`id`);


ALTER TABLE `groups`
MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
ALTER TABLE `login_attempts`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `subjects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `substitutions`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `subst_texts`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
ALTER TABLE `users_comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users_groups`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
ALTER TABLE `users_subjects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
