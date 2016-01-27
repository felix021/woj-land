-- MySQL dump 10.13  Distrib 5.1.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: starter
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `starter`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `starter` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `starter`;

--
-- Table structure for table `admin_sources`
--

DROP TABLE IF EXISTS `admin_sources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_sources` (
  `source_id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` char(20) NOT NULL,
  `contest_id` int(11) NOT NULL DEFAULT '0',
  `source_code` text,
  `length` int(11) NOT NULL DEFAULT '0',
  `submit_time` datetime DEFAULT NULL,
  `submit_ip` char(20) DEFAULT NULL,
  `lang` tinyint(4) NOT NULL,
  `share` tinyint(4) NOT NULL,
  `judge_time` datetime DEFAULT NULL,
  `memory_usage` int(11) NOT NULL DEFAULT '0',
  `time_usage` int(11) NOT NULL DEFAULT '0',
  `result` int(11) NOT NULL DEFAULT '0',
  `extra_info` text,
  PRIMARY KEY (`source_id`,`problem_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_sources`
--

LOCK TABLES `admin_sources` WRITE;
/*!40000 ALTER TABLE `admin_sources` DISABLE KEYS */;
INSERT INTO `admin_sources` VALUES (1,1001,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n  int a, b;\r\n  scanf(\"%d%d\", &a, &b);\r\n  printf(\"%d\\n\", a + b);\r\n  return 0;\r\n}',116,'2012-03-07 12:32:25','210.42.123.25',1,1,'2012-03-07 15:10:29',1084,20,1,''),(2,1003,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    double h;\r\n    scanf(\"%lf\", &h);\r\n    printf(\"%.4lf %.4lf\\n\", h * 0.393700787, h * 0.032808399);\r\n    return 0;\r\n}',155,'2012-03-07 12:49:21','210.42.123.25',1,1,'2012-03-07 12:49:21',1140,20,1,''),(3,1004,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase-- > 0)\r\n    {\r\n        int a, b;\r\n        scanf(\"%d%d\", &a, &b);\r\n        printf(\"%d %d %d %d %d\\n\",\r\n                a + b, a * b, a - b,\r\n                b == 0 ? -1 : a / b,\r\n                b == 0 ? -1 : a % b);\r\n    }\r\n    return 0;\r\n}',336,'2012-03-07 13:21:32','210.42.123.25',1,1,'2012-03-07 13:21:32',1100,10,1,''),(4,1002,1,'root',0,'#include <stdio.h>\r\n\r\nint main () {\r\n    printf(\"%lu\\n%lu\\n\", sizeof(int), sizeof(double));\r\n    return 0;\r\n}',109,'2012-03-07 13:21:50','210.42.123.25',1,1,'2012-03-07 13:21:50',1064,10,1,''),(5,1005,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase-- > 0)\r\n    {\r\n        int a, b;\r\n        scanf(\"%d%d\", &a, &b);\r\n        if (b == 0)\r\n            printf(\"UNKNOWN\\n\");\r\n        else if (a % b == 0)\r\n            printf(\"YES\\n\");\r\n        else \r\n            printf(\"NO\\n\");\r\n    }\r\n    return 0;\r\n}',344,'2012-03-07 13:27:31','210.42.123.25',1,1,'2012-03-07 13:27:32',1080,10,1,''),(6,1006,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase-- > 0)\r\n    {\r\n        int a;\r\n        scanf(\"%d\", &a);\r\n        if (a % 2 == 0)\r\n            printf(\"even\\n\");\r\n        else \r\n            printf(\"odd\\n\");\r\n    }\r\n    return 0;\r\n}',277,'2012-03-07 13:33:53','210.42.123.25',1,1,'2012-03-07 13:33:53',1076,10,1,''),(7,1007,1,'root',0,'#include <stdio.h>\r\n\r\n#define PI 3.1415926\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase-- > 0)\r\n    {\r\n        double r;\r\n        scanf(\"%lf\", &r);\r\n        printf(\"%.4lf %.4lf %.4lf\\n\",\r\n                2 * r, 2 * PI * r, PI * r * r);\r\n    }\r\n    return 0;\r\n}',292,'2012-03-07 13:43:28','210.42.123.25',1,1,'2012-03-07 13:43:28',1148,10,1,''),(8,1008,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    printf(\r\n        \"********\\n\"\r\n        \" ********\\n\"\r\n        \"********\\n\"\r\n        \" ********\\n\"\r\n        \"********\\n\"\r\n        \" ********\\n\"\r\n        \"********\\n\"\r\n        \" ********\\n\"\r\n    );\r\n    return 0;\r\n}',254,'2012-03-07 13:52:11','210.42.123.25',1,1,'2012-03-07 13:52:11',1040,10,1,''),(9,1009,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int i;\r\n    printf(\"number\\tsquare\\tcube\\n\");\r\n    for (i = 0; i <= 10; i++)\r\n    {\r\n        printf(\"%d\\t%d\\t%d\\n\", i, i * i, i * i * i);\r\n    }\r\n    return 0;\r\n}',203,'2012-03-07 14:02:18','210.42.123.25',1,1,'2012-03-07 14:02:18',1064,10,1,''),(10,1010,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    double price, pay;\r\n    printf(\"请输入价格：\\n\");\r\n    scanf(\"%lf\", &price);\r\n    printf(\"支付金额：\\n\");\r\n    scanf(\"%lf\", &pay);\r\n    printf(\"%.2lf\\n\", price - pay); \r\n    return 0;\r\n}',238,'2012-03-07 15:08:15','210.42.123.25',1,1,'2012-03-07 15:16:01',1140,10,1,''),(11,1011,1,'root',0,'#include <stdio.h>\r\n\r\n#define MAX(a, b) ((a) > (b) ? (a) : (b))\r\n#define MIN(a, b) ((a) < (b) ? (a) : (b))\r\n\r\nint main()\r\n{\r\n    int a, b, c, nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase--)\r\n    {\r\n        scanf(\"%d%d%d\", &a, &b, &c);\r\n        printf(\"%d %.2lf %d %d %d\\n\", a + b + c, (a + b + c) / 3.0,\r\n                a * b * c, MIN(MIN(a, b), c), MAX(MAX(a, b), c));\r\n    }\r\n    return 0;\r\n}',401,'2012-03-07 15:24:31','210.42.123.25',1,1,'2012-03-07 15:24:31',1124,10,1,''),(12,1012,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    char c = getchar();\r\n    printf(\"%c\", c + (\'A\' - \'a\'));\r\n    return 0;\r\n}',114,'2012-03-07 15:31:44','210.42.123.25',1,1,'2012-03-07 15:31:45',1064,10,5,''),(13,1012,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    char c = getchar();\r\n    printf(\"%c\", c - \'A\' + \'a\');\r\n    return 0;\r\n}',112,'2012-03-07 15:32:24','210.42.123.25',1,1,'2012-03-07 15:32:24',1060,260,1,''),(14,1012,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    char c = getchar();\r\n    printf(\"%c\", c - \'A\' + \'a\');\r\n    return 0;\r\n}',112,'2012-03-07 15:49:37','210.42.123.25',1,1,'2012-03-07 15:50:10',1060,260,1,''),(15,1013,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase--)\r\n    {\r\n        double F;\r\n        scanf(\"%lf\", &F);\r\n        printf(\"%.2lf\\n\", (F - 32) * 5 / 9.0);\r\n    }\r\n    return 0;\r\n}',224,'2012-03-07 16:35:19','210.42.123.25',1,1,'2012-03-07 16:42:22',1148,10,1,''),(16,1014,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase--)\r\n    {\r\n        double pound;\r\n        scanf(\"%lf\", &pound);\r\n        printf(\"%.2lf %.2lf\\n\", pound, pound * 454);\r\n    }\r\n    return 0;\r\n}',238,'2012-03-07 16:51:12','210.42.123.25',1,1,'2012-03-07 16:51:12',1152,10,1,''),(17,1014,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase--)\r\n    {\r\n        double distance;\r\n        scanf(\"%lf\", &distance);\r\n        printf(\"%.2lf\\n\", distance * 5280 * 12 * 2.54 / 100000);\r\n    }\r\n    return 0;\r\n}',256,'2012-03-07 16:55:48','210.42.123.25',1,1,'2012-03-07 16:55:48',1148,10,5,''),(18,1015,1,'root',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase--)\r\n    {\r\n        double distance;\r\n        scanf(\"%lf\", &distance);\r\n        printf(\"%.2lf\\n\", distance * 5280 * 12 * 2.54 / 100000);\r\n    }\r\n    return 0;\r\n}',256,'2012-03-07 16:56:15','210.42.123.25',1,1,'2012-03-07 16:56:15',1148,10,1,'');
/*!40000 ALTER TABLE `admin_sources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contests`
--

DROP TABLE IF EXISTS `contests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contests` (
  `contest_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`contest_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contests`
--

LOCK TABLES `contests` WRITE;
/*!40000 ALTER TABLE `contests` DISABLE KEYS */;
/*!40000 ALTER TABLE `contests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` char(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `view_src` tinyint(4) NOT NULL DEFAULT '0',
  `private_contest` tinyint(4) NOT NULL DEFAULT '0',
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `reserved` text NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'root','privileged user group',1,1,1,'');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mails`
--

DROP TABLE IF EXISTS `mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mails` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) NOT NULL DEFAULT '0',
  `from_username` char(20) NOT NULL,
  `to_user_id` int(11) NOT NULL DEFAULT '0',
  `to_username` char(20) NOT NULL DEFAULT '0',
  `send_time` datetime NOT NULL,
  `title` char(100) DEFAULT NULL,
  `content` text,
  `unread` tinyint(4) NOT NULL DEFAULT '1',
  `reader_del` tinyint(4) NOT NULL DEFAULT '0',
  `writer_del` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mails`
--

LOCK TABLES `mails` WRITE;
/*!40000 ALTER TABLE `mails` DISABLE KEYS */;
/*!40000 ALTER TABLE `mails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `problem_at_contest`
--

DROP TABLE IF EXISTS `problem_at_contest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `problem_at_contest` (
  `problem_id` int(11) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `contest_seq` int(11) NOT NULL DEFAULT '0',
  `AC` int(11) NOT NULL DEFAULT '0',
  `PE` int(11) NOT NULL DEFAULT '0',
  `CE` int(11) NOT NULL DEFAULT '0',
  `WA` int(11) NOT NULL DEFAULT '0',
  `RE` int(11) NOT NULL DEFAULT '0',
  `TLE` int(11) NOT NULL DEFAULT '0',
  `MLE` int(11) NOT NULL DEFAULT '0',
  `OLE` int(11) NOT NULL DEFAULT '0',
  `total` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`problem_id`,`contest_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problem_at_contest`
--

LOCK TABLES `problem_at_contest` WRITE;
/*!40000 ALTER TABLE `problem_at_contest` DISABLE KEYS */;
/*!40000 ALTER TABLE `problem_at_contest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `problems`
--

DROP TABLE IF EXISTS `problems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `problems` (
  `problem_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `input` text,
  `output` text,
  `sample_input` text,
  `sample_output` text,
  `hint` text,
  `source` text,
  `contest_id` int(11) NOT NULL DEFAULT '0',
  `contest_seq` int(11) NOT NULL DEFAULT '0',
  `time_limit` int(11) NOT NULL DEFAULT '1000',
  `memory_limit` int(11) NOT NULL DEFAULT '65536',
  `spj` tinyint(4) NOT NULL DEFAULT '0',
  `accepted` int(11) NOT NULL DEFAULT '0',
  `submitted` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  `difficulty` int(11) NOT NULL DEFAULT '0',
  `reserved` text,
  PRIMARY KEY (`problem_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1016 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problems`
--

LOCK TABLES `problems` WRITE;
/*!40000 ALTER TABLE `problems` DISABLE KEYS */;
INSERT INTO `problems` VALUES (1001,'A+B Problem ','<p>Calculate a+b</p>','Two integer a,b (0<=a,b<=10)\r\n','Output a+b\r\n','1 2\r\n\r\n','3\r\n','','',0,0,1000,10000,0,1,1,1,1,NULL),(1002,'上机指导2 (1)','<p>&nbsp;编写程序使用printf和sizeof输出int和double的大小。</p>','(无)','两行，第一行是int的大小，第二行是double的大小','(无)','','','',0,0,1000,65536,0,1,1,1,1,NULL),(1003,'上机指导2 (2)','<p>&nbsp;编写程序将厘米转换为英寸和英尺，精确到小数点后四位。</p>\r\n<p>1 cm = 0.393700787 英寸</p>\r\n<p>1 cm = 0.032808399 英尺</p>','一个数字，单位为厘米','一行两个数字，分别是英寸和英尺，用一个空格分隔。','1','0.3937 0.0328\r\n','','',0,0,1000,65536,0,1,1,1,1,NULL),(1004,'习题2.13','<p>&nbsp;编写程序输入两个数a, b，计算它们的和、积、差、商（整除）、余数。如果被除数是0，则商和余数输出-1。</p>','首先是一个整数n，表示有n组数据。\r\n接下来有n行，每行2个整数a, b。','每组输入数据输出一行，每行5个整数，用空格分隔。','1\r\n1 2','3 2 -1 0 1','<p>使用一个循环来读取多组数据，例如：</p>\r\n<p><span style=\"font-family: \'Courier New\'; \">int nCase;</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">scanf(&quot;%d&quot;, &amp;nCase);</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">while (nCase-- &gt; 0) // nCase-- &gt; 0 这个条件是先判断 nCase&gt;0是否成立，无论是否成立，将nCase减1。</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">{</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">&nbsp; &nbsp; ; //在这里处理每一组数据（输入、处理、输出）</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">}</span></p>\r\n<p>&nbsp;</p>\r\n<p>该循环等同于</p>\r\n<p><span style=\"font-family: \'Courier New\'; \">while (nCase &gt; 0)</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">{</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">&nbsp; &nbsp; nCase--;</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">&nbsp; &nbsp; ; //处理数据</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">}</span></p>','',0,0,1000,65536,0,1,1,1,1,NULL),(1005,'习题2.14','<div style=\"text-align: left;\"><font face=\"Verdana\"><span style=\"line-height: 18px;\">编写程序输入两个数a, b，判断a是否是b的倍数。</span></font></div>','首先是一个整数n，表示有n组数据。\r\n接下来有n行，每行2个整数a, b。\r\n','每组输入数据输出一行，如果a是b的倍数，输出YES，否则输出NO。如果无法判断，输出UNKNOWN。\r\n','1\r\n6 3\r\n7 8','YES\r\nNO','<p>0是所有自然数的倍数。</p>\r\n<p>&nbsp;注意处理b==0的情况。</p>','',0,0,1000,65536,0,1,1,1,1,NULL),(1006,'习题2.15','<p>&nbsp;输入整数，判断是基数还是偶数</p>','首先是一个整数n，表示有n组数据。\r\n接下来有n行，每行1个整数','每组输入数据输出一行，如果a是奇数，输出odd，否则输出even。','2\r\n5\r\n36','odd\r\neven','<p>&nbsp;0是偶数。</p>','',0,0,1000,65536,0,1,1,1,1,NULL),(1007,'习题2.16','<p>编写程序，输入圆的半径，输出 直径、周长、面积。要求定义符号常量PI代表3.1415926。</p>','首先是一个整数n，表示有n组数据。\r\n接下来有n行，每行1个正数，表示圆的半径','每组输入数据输出一行，每行三个数字，分别是直径、周长、面积，用空格分隔，精确到小数点后4位。','3\r\n1\r\n2\r\n0.5','2.0000 6.2832 3.1416\r\n4.0000 12.5664 12.5664\r\n1.0000 3.1416 0.7854','','',0,0,1000,65536,0,1,1,1,1,NULL),(1008,'上机指导3 (1)','<p>&nbsp;<img width=\"521\" height=\"177\" alt=\"\" src=\"/starter/upload/3_1.png\" /></p>','(无)','参见Description','(无)','参见Description','<p>&nbsp;在c语言中，如果两个字符串常量之间只有空格、回车、制表符，那么编译的时候，会将这两个字符串合并成一个字符串。</p>\r\n<p>&nbsp;<span style=\"font-family: \'Courier New\'; \">例如 &nbsp;printf(&quot;abc&quot;); 等同于 </span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">printf(&quot;a&quot; &nbsp; &quot;b&quot;</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">&quot;c&quot;);</span></p>\r\n<p>中间的回车或者空格会被忽略。</p>\r\n<p>&nbsp;</p>\r\n<p>请同学们自己写一个程序测试一下。</p>','',0,0,1000,65536,0,1,1,1,1,NULL),(1009,'上机指导3 (2)','<p>注意：虽然题目要求使用顺序结构，但是本题鼓励大家使用for/while循环语句来完成。</p>\r\n<p>不要使用空格来让每一列对齐，而应该使用<span style=\"font-family: \'Courier New\'; \">&quot;\\t&quot;</span>（制表符）来分隔，例如</p>\r\n<p><span style=\"font-size: medium; \"><span style=\"font-family: \'Courier New\'; \">printf(&quot;number<span style=\"font-size: large; \"><strong>\\t</strong></span>square<span style=\"font-size: large; \"><strong>\\t</strong></span>cube\\n&quot;);</span></span></p>\r\n<p>&nbsp;<img width=\"557\" height=\"239\" alt=\"\" src=\"/starter/upload/32.png\" /></p>','(无)','见图。','(无)','见图。','<p><span style=\"font-family: \'Courier New\'; \">for循环:</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">for (初始化语句; 判断条件; 循环迭代语句)&nbsp;{ /* 循环体 */&nbsp;}</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \"><strong>初始化语句&nbsp;</strong>在for循环开始前执行</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \"><strong>判断条件&nbsp;</strong>在每次循环之前执行，如果为真，执行循环，否则循环结束</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \"><strong>循环迭代语句&nbsp;</strong>在每次循环结束之后执行，通常用来将循环变量 +1 或者 -1 。</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">例如下面这个循环执行5次，输出0～4：</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">int i;</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">for (i = 0; i &lt; 5; i++)</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">{</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">&nbsp; &nbsp; printf(&quot;i = %d\\n&quot;, i);</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">}</span></p>','',0,0,1000,65536,0,1,1,1,1,NULL),(1010,'上机指导3 (3)','<p>&nbsp;<img alt=\"\" src=\"/starter/upload/33.png\" /></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>','只有一组输入数据（不需要循环），一共两行，每行一个正数，分别是物件的价格和用户支付的钱。','第一行是提示语言“请输入价格：\\n”\r\n第二行是提示语言“支付金额：\\n”\r\n第三行是找钱的数目，精确到分。\r\n请直接复制上面的两个字符串，以免打错字。','200\r\n20.1','请输入价格：\r\n支付金额：\r\n179.90','<p>按照题意，本题一共需要3个printf和2个scanf来完成。</p>','',0,0,1000,65536,1,1,1,1,1,NULL),(1011,'上机指导3 (4)','<p><span style=\"font-family: \'Courier New\'; \">&nbsp;<img width=\"560\" height=\"41\" alt=\"\" src=\"/starter/upload/34.png\" /></span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">条件运算符： Condition ? A : B。</span></p>\r\n<p><span style=\"font-family: \'Courier New\'; \">当Condition为真时返回A，否则返回B。</span></p>','首先是一个整数n，表示有n组数据。\r\n接下来有n行，每行3个整数','每组输入数据输出一行，每行5个数字，按题目给出的顺序输出，用空格分隔。平均值应该是个浮点数，精确到小数点后2位。','1\r\n3 4 6','13 4.33 72 3 6','','',0,0,1000,65536,0,1,1,1,1,NULL),(1012,'上机指导3 (5)','<p>&nbsp;编写一个程序，输入一个大写字母，将其转换成小写字母。</p>','一个大写字母','对应的小写字母','A','a','<p>参考ascii码相关知识。</p>\r\n<p>0 =&gt; 48, 0x30</p>\r\n<p>A =&gt; 65, 0x41</p>\r\n<p>a =&gt; 97, 0x61</p>','',0,0,1000,65536,0,1,1,1,1,NULL),(1013,'上机指导3 (6)','<p><img width=\"556\" height=\"65\" alt=\"\" src=\"/starter/upload/36.png\" />&nbsp;</p>','首先是一个整数n，表示有n组数据。\r\n接下来有n行，每行1个数字，表示华氏温度.','每组输入数据输出一行，每行1个数字，输出对应的摄氏温度，精确到小数点后2位。','2\r\n5\r\n8.2','-15\r\n-13.22','','',0,0,1000,65536,0,1,1,1,1,NULL),(1014,'上机指导3 (7)','<p>&nbsp;<img width=\"559\" height=\"43\" alt=\"\" src=\"/starter/upload/37.png\" /></p>','首先是一个整数n，表示有n组数据。\r\n接下来有n行，每行1个数字，表示重量（磅）.\r\n','每组输入数据输出一行，每行2个数字，对应磅和克。精确到小数点后2位。\r\n','2\r\n0.1\r\n1','0.10 45.40\r\n1.00 454.00','<p><span class=\"Apple-tab-span\" style=\"white-space:pre\">	</span>&nbsp;</p>','',0,0,1000,65536,0,1,1,1,1,NULL),(1015,'上机指导3 (8)','<p>&nbsp;<img width=\"561\" height=\"46\" alt=\"\" src=\"/starter/upload/38.png\" /></p>','首先是一个整数n，表示有n组数据。\r\n接下来有n行，每行1个数字，表示距离（英里）','每组输入数据输出一行，每行1个数字，对应距离（公里），精确到小数点后2位。\r\n','2\r\n1\r\n0.5','1.61\r\n0.80','','',0,0,1000,65536,0,1,1,1,1,NULL);
/*!40000 ALTER TABLE `problems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sources`
--

DROP TABLE IF EXISTS `sources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sources` (
  `source_id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` char(20) NOT NULL,
  `contest_id` int(11) NOT NULL DEFAULT '0',
  `source_code` text,
  `length` int(11) NOT NULL DEFAULT '0',
  `submit_time` datetime DEFAULT NULL,
  `submit_ip` char(20) DEFAULT NULL,
  `lang` tinyint(4) NOT NULL,
  `share` tinyint(4) NOT NULL,
  `judge_time` datetime DEFAULT NULL,
  `memory_usage` int(11) NOT NULL,
  `time_usage` int(11) NOT NULL,
  `result` int(11) NOT NULL DEFAULT '0',
  `extra_info` text,
  PRIMARY KEY (`source_id`,`problem_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sources`
--

LOCK TABLES `sources` WRITE;
/*!40000 ALTER TABLE `sources` DISABLE KEYS */;
INSERT INTO `sources` VALUES (1,1001,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int a, b;\r\n    scanf(\"%d%d\", &a, &b);\r\n    printf(\"%d\\n\", a + b);\r\n    return 0;\r\n}',124,'2012-03-07 16:04:10','210.42.123.25',1,1,'2012-03-07 16:04:10',1084,20,1,''),(2,1002,13,'answer',0,'#include <stdio.h>\r\n\r\nint main () {\r\n    printf(\"%lu\\n%lu\\n\", sizeof(int), sizeof(double));\r\n    return 0;\r\n}',109,'2012-03-07 16:04:23','210.42.123.25',1,1,'2012-03-07 16:04:23',1060,10,1,''),(3,1003,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    double h;\r\n    scanf(\"%lf\", &h);\r\n    printf(\"%.4lf %.4lf\\n\", h * 0.393700787, h * 0.032808399);\r\n    return 0;\r\n}',155,'2012-03-07 16:04:33','210.42.123.25',1,1,'2012-03-07 16:04:33',1136,20,1,''),(4,1004,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase-- > 0)\r\n    {\r\n        int a, b;\r\n        scanf(\"%d%d\", &a, &b);\r\n        printf(\"%d %d %d %d %d\\n\",\r\n                a + b, a * b, a - b,\r\n                b == 0 ? -1 : a / b,\r\n                b == 0 ? -1 : a % b);\r\n    }\r\n    return 0;\r\n}',336,'2012-03-07 16:04:46','210.42.123.25',1,1,'2012-03-07 16:04:46',1096,10,1,''),(5,1005,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase-- > 0)\r\n    {\r\n        int a, b;\r\n        scanf(\"%d%d\", &a, &b);\r\n        if (b == 0)\r\n            printf(\"UNKNOWN\\n\");\r\n        else if (a % b == 0)\r\n            printf(\"YES\\n\");\r\n        else \r\n            printf(\"NO\\n\");\r\n    }\r\n    return 0;\r\n}',344,'2012-03-07 16:04:55','210.42.123.25',1,1,'2012-03-07 16:04:55',1076,10,1,''),(6,1006,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase-- > 0)\r\n    {\r\n        int a;\r\n        scanf(\"%d\", &a);\r\n        if (a % 2 == 0)\r\n            printf(\"even\\n\");\r\n        else \r\n            printf(\"odd\\n\");\r\n    }\r\n    return 0;\r\n}',277,'2012-03-07 16:05:03','210.42.123.25',1,1,'2012-03-07 16:05:03',1080,10,1,''),(7,1007,13,'answer',0,'#include <stdio.h>\r\n\r\n#define PI 3.1415926\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase-- > 0)\r\n    {\r\n        double r;\r\n        scanf(\"%lf\", &r);\r\n        printf(\"%.4lf %.4lf %.4lf\\n\",\r\n                2 * r, 2 * PI * r, PI * r * r);\r\n    }\r\n    return 0;\r\n}',292,'2012-03-07 16:05:12','210.42.123.25',1,1,'2012-03-07 16:05:13',1144,10,1,''),(8,1008,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    printf(\r\n        \"********\\n\"\r\n        \" ********\\n\"\r\n        \"********\\n\"\r\n        \" ********\\n\"\r\n        \"********\\n\"\r\n        \" ********\\n\"\r\n        \"********\\n\"\r\n        \" ********\\n\"\r\n    );\r\n    return 0;\r\n}',254,'2012-03-07 16:05:23','210.42.123.25',1,1,'2012-03-07 16:05:23',1040,10,1,''),(9,1009,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int i;\r\n    printf(\"number\\tsquare\\tcube\\n\");\r\n    for (i = 0; i <= 10; i++)\r\n    {\r\n        printf(\"%d\\t%d\\t%d\\n\", i, i * i, i * i * i);\r\n    }\r\n    return 0;\r\n}',203,'2012-03-07 16:05:38','210.42.123.25',1,1,'2012-03-07 16:05:38',1064,10,1,''),(10,1010,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    double price, pay;\r\n    printf(\"请输入价格：\\n\");\r\n    scanf(\"%lf\", &price);\r\n    printf(\"支付金额：\\n\");\r\n    scanf(\"%lf\", &pay);\r\n    printf(\"%.2lf\\n\", price - pay); \r\n    return 0;\r\n}',238,'2012-03-07 16:05:47','210.42.123.25',1,1,'2012-03-07 16:05:47',1132,10,1,''),(11,1011,13,'answer',0,'#include <stdio.h>\r\n\r\n#define MAX(a, b) ((a) > (b) ? (a) : (b))\r\n#define MIN(a, b) ((a) < (b) ? (a) : (b))\r\n\r\nint main()\r\n{\r\n    int a, b, c, nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase--)\r\n    {\r\n        scanf(\"%d%d%d\", &a, &b, &c);\r\n        printf(\"%d %.2lf %d %d %d\\n\", a + b + c, (a + b + c) / 3.0,\r\n                a * b * c, MIN(MIN(a, b), c), MAX(MAX(a, b), c));\r\n    }\r\n    return 0;\r\n}',401,'2012-03-07 16:05:57','210.42.123.25',1,1,'2012-03-07 16:05:57',1124,10,1,''),(12,1012,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    char c = getchar();\r\n    printf(\"%c\", c - \'A\' + \'a\');\r\n    return 0;\r\n}',112,'2012-03-07 16:06:05','210.42.123.25',1,1,'2012-03-07 16:06:06',1060,260,1,''),(13,1013,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase--)\r\n    {\r\n        double F;\r\n        scanf(\"%lf\", &F);\r\n        printf(\"%.2lf\\n\", (F - 32) * 5 / 9.0);\r\n    }\r\n    return 0;\r\n}\r\n',226,'2012-03-07 16:43:17','210.42.123.25',1,1,'2012-03-07 16:43:17',1148,10,1,''),(14,1014,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase--)\r\n    {\r\n        double pound;\r\n        scanf(\"%lf\", &pound);\r\n        printf(\"%.2lf %.2lf\\n\", pound, pound * 454);\r\n    }\r\n    return 0;\r\n}',238,'2012-03-07 16:51:23','210.42.123.25',1,1,'2012-03-07 16:51:23',1144,10,1,''),(15,1015,13,'answer',0,'#include <stdio.h>\r\n\r\nint main()\r\n{\r\n    int nCase;\r\n    scanf(\"%d\", &nCase);\r\n    while (nCase--)\r\n    {\r\n        double distance;\r\n        scanf(\"%lf\", &distance);\r\n        printf(\"%.2lf\\n\", distance * 5280 * 12 * 2.54 / 100000);\r\n    }\r\n    return 0;\r\n}',256,'2012-03-07 16:56:28','210.42.123.25',1,1,'2012-03-07 16:56:28',1148,10,1,'');
/*!40000 ALTER TABLE `sources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_at_contest`
--

DROP TABLE IF EXISTS `user_at_contest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_at_contest` (
  `user_id` int(11) NOT NULL,
  `username` char(20) NOT NULL,
  `contest_id` int(11) NOT NULL,
  `accepts` int(11) NOT NULL DEFAULT '0',
  `penalty` int(11) NOT NULL DEFAULT '0',
  `info_json` text NOT NULL,
  PRIMARY KEY (`user_id`,`contest_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_at_contest`
--

LOCK TABLES `user_at_contest` WRITE;
/*!40000 ALTER TABLE `user_at_contest` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_at_contest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL,
  `password` char(50) NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `school` varchar(100) DEFAULT NULL,
  `reg_time` datetime DEFAULT NULL,
  `last_ip` char(20) DEFAULT NULL,
  `submit` int(11) NOT NULL DEFAULT '0',
  `solved` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  `share_code` tinyint(4) NOT NULL DEFAULT '1',
  `group_ids` varchar(200) DEFAULT '',
  `solved_list` text,
  `easy` int(11) NOT NULL DEFAULT '0',
  `medium` int(11) NOT NULL DEFAULT '0',
  `difficult` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'root','dad3b1c55a54400582c9a3ada65f2c49','root','acm@whu.edu.cn','whu','2010-03-22 14:29:00',NULL,0,0,1,1,'1',NULL,0,0,0),(2,'anonymous','d41d8cd98f00b204e9800998ecf8427e','anonymous','acm@whu.edu.cn','whu','2010-03-22 14:29:00',NULL,1,0,1,1,'','',1,0,0),(13,'answer','dad3b1c55a54400582c9a3ada65f2c49','参考答案','','WHU','2012-03-07 16:03:57','210.42.123.25',15,15,1,1,'','1001|1002|1003|1004|1005|1006|1007|1008|1009|1010|1011|1012|1013|1014|1015',15,0,0),(14,'学号-姓名','e10adc3949ba59abbe56e057f20f883e','抢注','','WHU','2012-03-07 17:01:37','210.42.123.25',0,0,1,1,'','',0,0,0),(15,'2011301500009-申奥','d0c5481edbce57a4043efbd5809a9dd9','','','','2012-03-07 17:20:33','222.20.196.242',0,0,1,1,'','',0,0,0),(16,'LINSU1992','d0970714757783e6cf17b26fb8e2298f','Cathy','385706975@qq.com','武汉大学','2012-03-07 19:57:03','222.20.255.248',0,0,1,1,'','',0,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-03-07 19:59:31

grant all privileges on starter.* to 'starter'@'localhost' identified by 'starter';
