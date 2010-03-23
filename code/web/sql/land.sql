DROP DATABASE IF EXISTS `land`;
CREATE DATABASE `land`;
USE `land`;

CREATE TABLE `problems`
(
 `problem_id` int primary key auto_increment,
 `title` varchar(200) NOT NULL,
 `description` text NOT NULL,
 `input` text,
 `output` text,
 `sample_input` text,
 `sample_output` text,
 `hint` text default NULL,
 `source` text default NULL,
 `contest_id` int default 0,
 `contest_seq` int default 0,
 `time_limit` int default 1000,
 `memory_limit` int default 65536,
 `accepted` int default 0,
 `submitted` int default 0,
 `enabled` tinyint default 1,
 `reserved` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1001; 

INSERT INTO `problems` 
(`problem_id`, `title`, `description`, `input`, `output`, `sample_input`, `sample_output`) VALUES
(NULL, "A+B Problem", "count a + b", "2 numbers", "their sum", "1 2", "3");

CREATE TABLE `users`
(
 `user_id` int primary key auto_increment,
 `username` char(20) NOT NULL,
 `password` char(50) NOT NULL,
 `nickname` varchar(100),
 `email` varchar(100),
 `school` varchar(100),
 `reg_time` datetime,
 `last_ip` char(20) default NULL,
 `submit` int default 0,
 `solved` int default 0,
 `enabled` tinyint DEFAULT 1,
 `preferred_lang` tinyint DEFAULT 1,
 `share_code` tinyint DEFAULT 1,
 `group_ids` varchar(200) DEFAULT ""
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 
ALTER TABLE  `users` ADD INDEX (  `username` );

INSERT INTO `users`
(`user_id`, `username`, `password`, `nickname`, `email`, `school`, `reg_time`, `group_ids`) VALUES
(NULL, "root", MD5("123456"), "root", "acm@whu.edu.cn", "whu", "2010-3-22 14:29:00", "1"),
(NULL, "anonymous", MD5(""), "anonymous", "acm@whu.edu.cn", "whu", "2010-3-22 14:29:00", "");

CREATE TABLE `groups`
(
 `group_id` int primary key auto_increment,
 `group_name` char(50) NOT NULL,
 `description` varchar(200),
 `view_src` tinyint DEFAULT 0,
 `private_contest` tinyint DEFAULT 0,
 `admin` tinyint DEFAULT 0,
 `reserved` text default ""
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 

INSERT INTO `groups` VALUES
(1, "root", "privileged user group", 1, 1, 1, "");

CREATE TABLE `sources`
(
 `source_id` int primary key auto_increment,
 `problem_id` int,
 `user_id` int,
 `contest_id` int,
 `source_code` text,
 `submit_time` datetime,
 `submit_ip` char(20),
 `lang` tinyint NOT NULL,
 `share` tinyint NOT NULL,
 `momery_usage` int NOT NULL,
 `time_usage` int NOT NULL,
 `result` int NOT NULL DEFAULT 0,
 `extra_info` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 

CREATE TABLE `contests`
(
 `contest_id` int primary key auto_increment,
 `title` varchar(200),
 `description` text,
 `private` tinyint DEFAULT 0,
 `start_time` datetime,
 `end_time` datetime,
 `enabled` tinyint DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 

CREATE TABLE `user_at_contest`
(
 `user_id` int,
 `contest_id` int,
 `accepts` int,
 `penalty` int,
 `info_json` text,
 primary key (`user_id`, `contest_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 

CREATE TABLE `problem_at_contest`
(
 `problem_id` int,
 `contest_id` int,
 `AC` int,
 `PE` int,
 `CE` int,
 `WA` int,
 `RE` int,
 `TLE` int,
 `MLE` int,
 `OLE` int,
 `total` int
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 

CREATE TABLE `mails`
(
 `mail_id` int primary key auto_increment,
 `from_user_id` int,
 `to_user_id` int,
 `send_time` datetime,
 `title` char(100),
 `content` text,
 `unread` tinyint NOT NULL DEFAULT 1,
 `reader_del` tinyint NOT NULL DEFAULT 0,
 `writer_del` tinyint NOT NULL DEFAULT 0
);
