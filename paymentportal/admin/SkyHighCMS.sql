-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: 10.6.166.75
-- Generation Time: Dec 15, 2010 at 03:31 PM
-- Server version: 5.0.91
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rhetoricdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` tinyint(3) NOT NULL auto_increment,
  `email` varchar(70) NOT NULL default '',
  `password` varchar(20) NOT NULL,
  `admin_lvl` tinyint(3) NOT NULL default '0',
  `first_name` varchar(40) NOT NULL default '',
  `last_name` varchar(40) NOT NULL default '',
  `create_date` date NOT NULL default '0000-00-00',
  `update_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` VALUES(1, 'sara@skyhighsoftware.com', 'L1veL0veG1ve', 9, 'Sara', 'Swafford', '2008-01-29', '2010-12-15');
INSERT INTO `admin` VALUES(15, 'basic', 'basic', 1, 'Basic', 'Basic', '2010-12-13', '2010-12-13');
INSERT INTO `admin` VALUES(3, 'arlene@agdesigngroup.net', 'passw0rd', 9, 'Arlene', 'Santos', '2010-02-27', '2010-02-27');
INSERT INTO `admin` VALUES(4, 'perlita@agdesigngroup.net', 'passw0rd', 9, 'Perlita', 'Sajadi', '2010-07-08', '2010-11-11');
INSERT INTO `admin` VALUES(14, 'hello@agdesigngroup.net', 'admin', 3, 'AGD', 'Test', '2010-12-08', '2010-12-08');
INSERT INTO `admin` VALUES(16, 'admin', 'admin', 3, 'Admin', 'Admin', '2010-12-13', '2010-12-13');

-- --------------------------------------------------------

--
-- Table structure for table `admin_log`
--

CREATE TABLE `admin_log` (
  `log_id` int(7) NOT NULL auto_increment,
  `admin_id` tinyint(3) NOT NULL default '0',
  `log_date` date NOT NULL default '0000-00-00',
  `start_time` time NOT NULL default '00:00:00',
  `exp_time` time NOT NULL default '00:00:00',
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=391 ;

--
-- Dumping data for table `admin_log`
--

INSERT INTO `admin_log` VALUES(341, 2, '2010-08-16', '00:44:24', '01:14:24');
INSERT INTO `admin_log` VALUES(390, 1, '2010-12-14', '15:47:10', '16:17:10');
INSERT INTO `admin_log` VALUES(365, 4, '2010-11-15', '11:16:55', '11:46:55');
INSERT INTO `admin_log` VALUES(369, 13, '2010-11-17', '18:15:57', '18:45:57');
INSERT INTO `admin_log` VALUES(371, 12, '2010-11-18', '19:25:39', '19:55:39');
INSERT INTO `admin_log` VALUES(374, 3, '2010-12-08', '10:17:12', '10:47:12');
INSERT INTO `admin_log` VALUES(375, 14, '2010-12-08', '10:22:51', '10:52:51');
INSERT INTO `admin_log` VALUES(377, 15, '2010-12-13', '17:18:47', '17:48:47');
INSERT INTO `admin_log` VALUES(378, 16, '2010-12-13', '17:19:01', '17:49:01');

-- --------------------------------------------------------

--
-- Table structure for table `admin_lvls`
--

CREATE TABLE `admin_lvls` (
  `admin_lvl` tinyint(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`admin_lvl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_lvls`
--

INSERT INTO `admin_lvls` VALUES(1, 'Basic');
INSERT INTO `admin_lvls` VALUES(3, 'Master Admin');
INSERT INTO `admin_lvls` VALUES(9, 'Webmaster');

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE `campus` (
  `campus_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `image_file` varchar(255) default NULL,
  `other` varchar(255) default NULL,
  `create_date` date NOT NULL,
  `show_on_events` tinyint(1) default '1',
  PRIMARY KEY  (`campus_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `campus`
--


-- --------------------------------------------------------

--
-- Table structure for table `case_studies`
--

CREATE TABLE `case_studies` (
  `case_study_id` int(10) unsigned NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `post_date` date NOT NULL,
  `title` varchar(65) NOT NULL default '',
  `objective` varchar(182) default NULL,
  `client` varchar(182) default NULL,
  `complete_text` text NOT NULL,
  `image_file` varchar(255) default NULL,
  `pdf_file` varchar(255) default NULL,
  `quote` text,
  `author` text,
  `author_title` text,
  `active` int(2) default '1',
  `last_update` datetime NOT NULL default '0000-00-00 00:00:00',
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`case_study_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `case_studies`
--

INSERT INTO `case_studies` VALUES(4, 1030, '2010-12-25', 'sample case 1', '<p>objective or problem statement here</p>', NULL, '<p>main text here</p>', NULL, NULL, 'quote here', 'quote author', NULL, NULL, '2010-12-14 18:41:54', '2010-12-14 18:41:54');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(10) unsigned NOT NULL auto_increment,
  `page_id` int(11) default NULL,
  `event_type` tinyint(2) default '1',
  `event_name` varchar(100) default NULL,
  `event_date` date NOT NULL default '0000-00-00',
  `event_time` time default NULL,
  `duration` time default NULL,
  `place` varchar(50) default NULL,
  `description` text,
  `course_id` int(3) default NULL,
  `event_coordinator` int(5) default '0',
  `event_cost` float default NULL,
  `member_cost` float default '0',
  `deadline` date default NULL,
  `holes` tinyint(2) default '2',
  `cart` tinyint(1) default '0',
  `cart_cost` float default NULL,
  `play_type` tinyint(2) default NULL,
  `start_date` date default NULL,
  `end_date` date default NULL,
  `day_of_week` tinyint(2) default NULL,
  `deadline_day` tinyint(1) default NULL,
  `deadline_time` time default NULL,
  `accept_late_reg` tinyint(1) default '1',
  `update_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `spaces_avail` int(5) default '0',
  `add_info` varchar(200) default NULL,
  `start_show` date default '0000-00-00',
  `stop_show` date default '0000-00-00',
  `active` tinyint(1) default NULL,
  PRIMARY KEY  (`event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` VALUES(12, 1027, NULL, 'special event', '2010-12-17', NULL, NULL, '<p>right here</p>', '<p>party!</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2010-12-14 18:14:14', NULL, 'now', NULL, NULL, 1);
INSERT INTO `events` VALUES(13, 1027, NULL, 'test', '2010-12-25', NULL, NULL, '<p>asdf</p>', '<p>asdf</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2010-12-14 18:09:32', NULL, 'asdf', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `display_order` varchar(10) default NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY  (`faq_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` VALUES(51, 111, '4', '<p><b>Affidavit of Death</b></p>', '<p>When a person dies, there are several methods of transferring property,   and the method you use depends on how the person held title to that   property. In many cases, an Affidavit of Death is used to transfer   property to the surviving co-owner. California Document Preparers can   prepare an Affidavit of Death of Trustee, Affidavit of Death of Joint   Tenant, and Affidavit of Death of Spouse for a reasonable cost.</p>', '2010-11-02 23:40:40', '2010-11-02 23:40:40');
INSERT INTO `faqs` VALUES(50, 111, '3', '<p><b>Interspousal Transfer Deed</b></p>', '<p>A special grant or a quitclaim deed that transfers ownership between spouses.           </p>', '2010-11-02 23:40:16', '2010-11-02 23:40:16');
INSERT INTO `faqs` VALUES(48, 111, '1', '<p><b>Quitclaim Deed</b></p>', '<p>Transfers ownership and implies certain promises including that the  transferor has the legal right to transfer the property.</p>', '2010-11-02 23:39:29', '2010-11-02 23:39:29');
INSERT INTO `faqs` VALUES(49, 111, '2', '<p><b>Grant Deed</b></p>', '<p>Transfers whatever ownership interest a person may have in a property.   It makes no guarantees about the extent of the person\\''s interest.</p>', '2010-11-02 23:39:53', '2010-11-02 23:39:53');
INSERT INTO `faqs` VALUES(52, 112, '1', '<p><strong>Joint Tenancy    </strong></p>', '<p>Joint tenancy is when two or more people hold title together with equal   shares in the property. The main feature of joint tenancy is the   automatic right of survivorship, meaning that if one of the joint   tenants passes away, the interest in the property passes to the other   joint tenant.</p>', '2010-11-03 00:00:00', '2010-11-02 23:59:03');
INSERT INTO `faqs` VALUES(54, 112, '3', '<p><strong>Tenancy in Common</strong></p>', '<p>Tenancy in common is when two or more persons hold title together but,   in contrast with joint tenancy, do not have the feature of right of   survivorship and the interests in the property do not have to be in   equal shares. For example, one owner could hold eighty percent while the   second would hold twenty percent. This method of holding title is more   common for investment properties with multiple share holders than it  is  for an owner occupied residence that has a single family home. When a   tenant in common dies, his share is subject to probate and is passed  in  accordance with his will or according to the laws of intestate   succession if he does not have a will.</p>', '2010-11-03 00:00:48', '2010-11-03 00:00:20');
INSERT INTO `faqs` VALUES(53, 112, '2', '<p><strong>Community Property</strong></p>', '<p>Community property is a method of holding title to manage assets that   are acquired during a marriage. This method can only be held by a   husband and wife. When a community property tenant dies, his interest   either passes automatically to the surviving spouse, or according to his   will if he has one. Both husband and wife must agree to any transfer   when title is held this way. There may be tax advantages to holding   property with your spouse as Community Property, but you should consult   your tax advisor on such matters.</p>', '2010-11-02 23:59:46', '2010-11-02 23:59:46');
INSERT INTO `faqs` VALUES(55, 112, '4', '<p><strong>Community Property with Right of Survivorship</strong></p>', '<p>This method is very similar to Community Property, but it always   includes the automatic right of survivorship, much like joint tenancy.   When one owner dies, his or her interest passes to the surviving spouse.</p>', '2010-11-03 00:00:39', '2010-11-03 00:00:39');
INSERT INTO `faqs` VALUES(56, 1031, '1', '<p>How is this done?</p>', '<p>Like this!</p>', '2010-12-14 18:46:54', '2010-12-14 18:46:54');
INSERT INTO `faqs` VALUES(57, 2, '1', '<p>a common question</p>', '<p>a fabulous answer!</p>', '2010-12-14 18:56:03', '2010-12-14 18:56:03');

-- --------------------------------------------------------

--
-- Table structure for table `headers`
--

CREATE TABLE `headers` (
  `header_id` tinyint(4) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `last_update` date NOT NULL,
  PRIMARY KEY  (`header_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `headers`
--


-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE `help` (
  `help_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `sort_by` varchar(20) default NULL,
  `help_cat_id` tinyint(4) default NULL,
  `title` varchar(255) default NULL,
  `description` text,
  `resource_link` varchar(255) default NULL,
  `resource_file` varchar(255) default NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY  (`help_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `help`
--

INSERT INTO `help` VALUES(6, 3, '2', 1, 'How to copy and paste from MS Word', '<p>\r\n<table cellspacing=\\"0\\" cellpadding=\\"0\\" border=\\"0\\" style=\\"border: medium none;\\">\r\n    <tbody>\r\n        <tr>\r\n            <td><strong class=\\"categorytitle\\">Step 1</strong><br />\r\n            Click on the &quot;Paste from Word&quot; icon.<br />\r\n            &nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td><img alt=\\"\\" src=\\"userfiles/image/help_02a(2).jpg\\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n            <p><strong><img height=\\"332\\" width=\\"590\\" src=\\"/userfiles/image/help_02a.jpg\\" alt=\\"\\" /><br />\r\n            <span class=\\"categorytitle\\"><br />\r\n            Step 2</span></strong><br />\r\n            Be sure &quot;Ignore Font Face definitions&quot; is checked.<br />\r\n            Check  &quot;Remove Styles definitions&quot; to remove font and background colors (recommended).</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td><img height=\\"335\\" width=\\"651\\" src=\\"/userfiles/image/help_02e.jpg\\" alt=\\"\\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <td><strong><br />\r\n            <span class=\\"categorytitle\\">Step 3</span></strong><br />\r\n            Open up your Word document. Select the area you wish to copy. Use Ctrl C to copy your selection. (Mac use Open Apple C).<br />\r\n            &nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td><img height=\\"502\\" width=\\"840\\" alt=\\"\\" src=\\"/userfiles/image/help_02c.jpg\\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n            <p><strong><br />\r\n            <span class=\\"categorytitle\\">Step 4</span></strong><br />\r\n            Return to your open &quot;Paste from Word&quot; dialog box and use Ctrl V to  paste your content into the box. Then click &quot;OK&quot; to complete the copy  and paste. Make any additional edits you\\''d like to the content.<span class=\\"accentColor\\"> <strong>To complete the update of this page, you must click on the &quot;Update&quot; button to save the changes you\\''ve made.</strong></span><br />\r\n            <br />\r\n            Notice that the table formatting is perserved as well as some of the basic text formatting.<br />\r\n            &nbsp;</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td><img height=\\"536\\" width=\\"626\\" alt=\\"\\" src=\\"/userfiles/image/help_02f.jpg\\" /></td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</p>', NULL, NULL, '2010-12-14 16:00:03', '2010-12-14 13:29:43');
INSERT INTO `help` VALUES(8, 3, '1', 1, 'CMS Manual - PDF', '<p>Description of PDF&nbsp;file here...</p>', NULL, 'help_20101214153858.pdf', '2010-12-14 15:38:58', '2010-12-14 15:38:58');
INSERT INTO `help` VALUES(9, 3, '3', 1, 'How to copy and paste from MS Word and retaining formatting', '<table cellspacing=\\"0\\" cellpadding=\\"0\\" border=\\"0\\">\r\n    <tbody>\r\n        <tr>\r\n            <td><strong class=\\"categorytitle\\">Step 1</strong><br />\r\n            Click on the &quot;Paste from Word&quot; icon.</td>\r\n        </tr>\r\n        <tr>\r\n            <td><img src=\\"../../userfiles/image/help_02a%282%29.jpg\\" alt=\\"\\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n            <p><strong><img height=\\"332\\" width=\\"590\\" alt=\\"\\" src=\\"../../../../../userfiles/image/help_02a.jpg\\" /><br />\r\n            <span class=\\"categorytitle\\">Step 2</span></strong><br />\r\n            Be sure &quot;Ignore Font Face definitions&quot; is checked.<br />\r\n            Do not check  &quot;Remove Styles definitions&quot;.</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td><img height=\\"343\\" width=\\"631\\" src=\\"/userfiles/image/help_02b.jpg\\" alt=\\"\\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <td><strong><br />\r\n            <span class=\\"categorytitle\\">Step 3</span></strong><br />\r\n            Open up your Word document. Select the area you wish to  copy. Use Ctrl C to copy your selection. (Mac use Open Apple C).</td>\r\n        </tr>\r\n        <tr>\r\n            <td><img height=\\"502\\" width=\\"840\\" src=\\"../../../../../userfiles/image/help_02c.jpg\\" alt=\\"\\" /></td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n            <p><strong><br />\r\n            <span class=\\"categorytitle\\">Step 4</span></strong><br />\r\n            Return to your open &quot;Paste from Word&quot; dialog box and use  Ctrl V to  paste your content into the box. Then click &quot;OK&quot; to complete  the copy  and paste. Make any additional edits you\\''d like to the  content.<span class=\\"accentColor\\"> <strong>To complete the update of this page, you must click on the &quot;Update&quot; button to save the changes you\\''ve made.</strong></span><br />\r\n            <br />\r\n            Notice that the table formatting is perserved as well as some of the basic text formatting.</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td><img height=\\"531\\" width=\\"632\\" src=\\"/userfiles/image/help_02d.jpg\\" alt=\\"\\" /></td>\r\n        </tr>\r\n    </tbody>\r\n</table>', NULL, NULL, '2010-12-14 16:02:52', '2010-12-14 16:01:13');
INSERT INTO `help` VALUES(10, 3, '2', 1, 'How to generate strong passwords', '<p>An ideal password is long and has letters, punctuation, symbols, and numbers.</p>\r\n<ul>\r\n    <li>Whenever possible, use at least 14 characters or more.</li>\r\n    <li>The greater the variety of characters in your password, the better.</li>\r\n    <li>Use the entire keyboard, not just the letters and characters you use or see most often.</li>\r\n    <li>Create a password you can remember</li>\r\n</ul>\r\n<p>For more ideas and suggestions, view the suggestions from Microsoft at the link provided.</p>', 'http://www.microsoft.com/protect/fraud/passwords/create.aspx', NULL, '2010-12-15 13:40:35', '2010-12-15 13:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `help_cats`
--

CREATE TABLE `help_cats` (
  `help_cat_id` bigint(20) NOT NULL auto_increment,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`help_cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `help_cats`
--

INSERT INTO `help_cats` VALUES(1, 'General');

-- --------------------------------------------------------

--
-- Table structure for table `image_types`
--

CREATE TABLE `image_types` (
  `image_type_id` int(11) NOT NULL auto_increment,
  `prefix` varchar(10) NOT NULL,
  `maxsize` bigint(20) NOT NULL,
  `maximagesize` bigint(20) NOT NULL,
  `maxthumbsize` bigint(20) NOT NULL,
  `imagefolder` varchar(100) NOT NULL,
  `thumb_width` int(11) NOT NULL,
  `thumb_height` int(11) NOT NULL,
  `image_width` int(11) NOT NULL,
  `image_height` int(11) NOT NULL,
  `full_width` int(11) NOT NULL,
  `full_height` int(11) NOT NULL,
  `crop_thumb` tinyint(4) default NULL,
  `crop_image` tinyint(4) default NULL,
  `manual_crop` tinyint(4) default NULL,
  `select_size` tinyint(4) default '1',
  `select_pos` tinyint(4) default '1',
  `other_flag` tinyint(4) default NULL,
  `other2` varchar(255) default NULL,
  PRIMARY KEY  (`image_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `image_types`
--

INSERT INTO `image_types` VALUES(1, 'page', 3500000, 3500000, 90000, 'cms/pages/', 50, 150, 300, 460, 1000, 800, 1, 1, 1, 1, 1, NULL, NULL);
INSERT INTO `image_types` VALUES(2, 'home', 3500000, 3500000, 90000, 'cms/pages/', 50, 150, 300, 550, 1000, 800, 1, 1, 1, 1, 1, NULL, NULL);
INSERT INTO `image_types` VALUES(3, 'photo', 3500000, 3500000, 90000, 'cms/photos/', 60, 60, 250, 250, 700, 500, NULL, NULL, NULL, 1, 1, NULL, NULL);
INSERT INTO `image_types` VALUES(4, 'logo', 1524288, 1524288, 90000, 'cms/logos/', 60, 60, 175, 250, 353, 555, NULL, NULL, NULL, 1, 1, NULL, NULL);
INSERT INTO `image_types` VALUES(5, 'news', 1524288, 1524288, 90000, 'cms/news/', 200, 40, 400, 400, 650, 650, NULL, NULL, NULL, 1, 1, NULL, NULL);
INSERT INTO `image_types` VALUES(6, 'campus', 1524288, 1524288, 90000, 'cms/campus/', 92, 74, 280, 240, 337, 365, NULL, NULL, NULL, 1, 1, NULL, NULL);
INSERT INTO `image_types` VALUES(7, 'study', 1524288, 1524288, 90000, 'cms/study/', 148, 160, 280, 400, 337, 400, 1, NULL, 1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(10) unsigned NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `news_date` date NOT NULL,
  `title` varchar(65) NOT NULL default '',
  `snippet` varchar(182) default NULL,
  `complete_text` text NOT NULL,
  `image_file` varchar(255) default NULL,
  `pdf_file` varchar(255) default NULL,
  `contact_email` varchar(255) default NULL,
  `active` int(2) NOT NULL default '1',
  `last_update` datetime NOT NULL default '0000-00-00 00:00:00',
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` VALUES(19, 1032, '2010-12-16', 'news 1', '<p>snippet here</p>', '<p>text here</p>', NULL, NULL, NULL, 1, '2010-12-14 19:04:39', '2010-12-14 19:04:39');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `org_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `sort_by` varchar(4) default NULL,
  `image_file` varchar(255) default NULL COMMENT 'logo',
  `name` varchar(50) NOT NULL,
  `short_desc` varchar(255) default NULL,
  `description` text,
  `phone` varchar(20) default NULL,
  `address` varchar(50) default NULL,
  `city` varchar(40) default NULL,
  `state` varchar(2) default NULL,
  `zip` varchar(10) default NULL,
  `website` varchar(255) default NULL,
  `email` varchar(50) default NULL,
  `extra_1` varchar(255) default NULL,
  `extra_2` varchar(255) default NULL,
  `extra_3` varchar(255) default NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY  (`org_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` VALUES(23, 1033, '1', NULL, 'jane doe', 'asdf', '<p>asdf</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2010-12-14 19:09:11', '2010-12-14 19:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `left_nav_pos` tinyint(4) default NULL,
  `alt_landing_page` int(11) default NULL COMMENT 'when children present, alternate landing page other than this page',
  `page_type_id` int(11) NOT NULL,
  `header_id` tinyint(4) default NULL,
  `main_menu` tinyint(1) default NULL,
  `footer` tinyint(1) default NULL,
  `title` varchar(65) NOT NULL default '',
  `sub_title` varchar(255) default NULL,
  `sub_nav_title` varchar(255) NOT NULL,
  `snippet` varchar(255) default NULL,
  `other` text,
  `other2` text,
  `other3` text,
  `other4` text,
  `other5` text,
  `other6` text,
  `other7` text,
  `other8` varchar(255) default NULL,
  `other9` varchar(255) default NULL,
  `complete_text` text,
  `image_file` varchar(255) default NULL,
  `image_size` tinyint(4) default NULL,
  `image_pos` tinyint(4) default NULL COMMENT '1=left,2=right',
  `pdf_file` varchar(255) default NULL,
  `active` tinyint(1) default '1',
  `back_button` tinyint(1) default NULL,
  `admin_lvls` varchar(255) NOT NULL default '1,2,3,9',
  `last_update` datetime NOT NULL default '0000-00-00 00:00:00',
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1037 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` VALUES(10, NULL, 1, NULL, 90, NULL, NULL, 1, 'Home', NULL, 'Home', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>Our website has not been reviewed or approved by the California  Department of Corporations. Any complaints concerning the content of  this website may be directed to the California Department of  Corporations at http://www.corp.ca.gov. <br />\r\n<br />\r\nWe are not attorneys. We can only provide self-help services at your  specific direction. California Document Preparers is not a law firm, and  cannot represent customers, select legal forms, or give advice on  rights or laws. Services are provided at customers'' request and are not  substitute for advice of a lawyer. Prices do not include court costs.  Not all products are available in all stores.Contact your local store  for a list of products. <br />\r\n<br />\r\nFiling fees are not included. More than one form may be required.  California Document Preparers can provide and type only at your specific  request the following estate planning documents: Living Trust, Wills,  Medical and Financial Powers of Attorney, Living Wills, Deeds and other  asset transfer documents. California Document Preparers cannot provide  any tax, insurance, financial, medical, legal or any other professional  advice. Because estate planning needs vary from individual to  individual, you should seek the advice of trained professionals on these  and other topics for your complete estate planning purposes. Costa  County LDA #54 expires 08/2012. Alameda County LDA # 71 expires 12/2010.  Alameda County LDA # 30 expires 4/6/2011.   Alameda County LDA # 30  expires 04/6/2011.</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-11-14 23:01:44', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(13, NULL, 2, NULL, 12, NULL, 1, 1, 'Contact Us', NULL, 'Contact Us', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '9', '2010-12-13 16:50:26', '2010-12-08 00:00:00');
INSERT INTO `pages` VALUES(1, NULL, NULL, NULL, 98, NULL, NULL, NULL, '_Admin Home', NULL, 'Administration Home', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>This is content for the CMS&nbsp;home page.</p>', NULL, NULL, NULL, NULL, 1, NULL, '9', '2010-12-13 16:47:50', '2010-12-13 00:00:00');
INSERT INTO `pages` VALUES(2, NULL, NULL, NULL, 96, NULL, NULL, NULL, '_Admin FAQS', NULL, '_Admin FAQS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '9', '2010-12-13 16:49:12', '2010-12-13 00:00:00');
INSERT INTO `pages` VALUES(3, NULL, NULL, NULL, 97, NULL, NULL, NULL, '_Admin Help', NULL, '_Admin Help', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '9', '2010-12-13 16:48:36', '2010-12-13 00:00:00');
INSERT INTO `pages` VALUES(1026, NULL, NULL, NULL, 2, NULL, 1, 1, 'Sample Text with Image', NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>test</p>', 'page__20101214164040.jpg', 2, 2, NULL, 1, NULL, '3,9', '2010-12-14 18:45:25', '2010-12-14 00:00:00');
INSERT INTO `pages` VALUES(1027, NULL, NULL, NULL, 7, NULL, 1, 1, 'Sample Events ', NULL, 'Events (test)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>This is a test event page</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-12-14 18:45:09', '2010-12-14 00:00:00');
INSERT INTO `pages` VALUES(1028, NULL, NULL, NULL, 9, NULL, 1, 1, 'Sample Video Page', NULL, 'Sample Video Page', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-12-14 18:28:25', '2010-12-14 00:00:00');
INSERT INTO `pages` VALUES(1029, NULL, NULL, NULL, 5, NULL, NULL, NULL, 'Sample Quote', 'Success!', 'Sample Quote', '\\"some famous quote here\\"', 'me', 'not famous', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>safsdf</p>', NULL, 2, 2, NULL, NULL, NULL, '3,9', '2010-12-14 18:29:27', '2010-12-14 00:00:00');
INSERT INTO `pages` VALUES(1030, NULL, NULL, NULL, 11, NULL, 1, 1, 'Sample Case Studies', NULL, 'Sample Case Studies', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>sample case studies</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-12-14 18:29:53', '2010-12-14 00:00:00');
INSERT INTO `pages` VALUES(1031, NULL, NULL, NULL, 6, NULL, 1, 1, 'Sample FAQ', NULL, 'Sample FAQ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>faq intro</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-12-14 18:45:54', '2010-12-14 00:00:00');
INSERT INTO `pages` VALUES(1032, NULL, NULL, NULL, 8, NULL, 1, 1, 'Sample News', NULL, 'Sample News', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>Sample News</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-12-14 18:57:26', '2010-12-14 00:00:00');
INSERT INTO `pages` VALUES(1033, NULL, NULL, NULL, 4, NULL, 1, 1, 'Sample Partners', NULL, 'Sample Partners', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>asdfasdf</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-12-14 19:05:10', '2010-12-14 00:00:00');
INSERT INTO `pages` VALUES(1034, NULL, NULL, NULL, 3, NULL, 1, NULL, 'Sample People Page', NULL, 'Sample People Page', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>asdfasdf</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-12-14 19:10:14', '2010-12-14 00:00:00');
INSERT INTO `pages` VALUES(1035, NULL, NULL, NULL, 10, NULL, 1, 1, 'Sample Resources Page', NULL, 'Sample Resources Page', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>resources intro</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-12-15 12:09:43', '2010-12-15 00:00:00');
INSERT INTO `pages` VALUES(1036, NULL, NULL, NULL, 99, NULL, 1, 1, 'Sample Special Page - Webmaster Only', 'Map Page', 'Sample Special Page - Webmaster Only', 'sample_body.php', 'sample_header.php', 'just testing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>asdfasdf</p>', NULL, NULL, NULL, '20101215121747.pdf', 1, NULL, '3,9', '2010-12-15 12:17:47', '2010-12-15 00:00:00');
INSERT INTO `pages` VALUES(11, NULL, 12, NULL, 2, NULL, NULL, 1, 'Site Credits', NULL, 'Site Credits', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>Site Designed by <a target="_blank" href="http://www.agdesigngroup.net/">AG DESIGN</a></p>', 'page__20101130163727.jpg', 2, 2, NULL, 1, NULL, '3,9', '2010-11-30 14:48:34', '2010-10-31 00:00:00');
INSERT INTO `pages` VALUES(12, NULL, 11, NULL, 99, NULL, NULL, 1, 'Site Index', NULL, 'Site Index', 'sitemap.php', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-10-31 11:02:20', '2010-10-31 00:00:00');
INSERT INTO `pages` VALUES(999, NULL, NULL, NULL, 999, NULL, NULL, NULL, '_TEST PAGE ONLY', NULL, 'TEST PAGE ONLY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'page__20101129184655.jpg', NULL, NULL, NULL, NULL, NULL, '9', '2010-12-13 16:45:10', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `page_types`
--

CREATE TABLE `page_types` (
  `page_type_id` int(4) NOT NULL auto_increment,
  `image_type_id` int(11) default '1',
  `display_order` tinyint(4) NOT NULL default '1',
  `title` varchar(55) NOT NULL,
  `description` text,
  `edit_page` varchar(50) NOT NULL default 'page_edit.php',
  `display_page` varchar(50) NOT NULL,
  `activated` tinyint(1) default NULL,
  `table_name` varchar(25) NOT NULL default 'pages',
  `table_id` varchar(25) NOT NULL default 'page_id',
  PRIMARY KEY  (`page_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

--
-- Dumping data for table `page_types`
--

INSERT INTO `page_types` VALUES(71, 1, 71, 'Sub Menu', NULL, 'page_edit.php', 'page_text.php', NULL, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(2, 1, 4, 'Text with Image', NULL, 'page_edit.php', 'page_text.php', 1, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(3, 3, 20, 'Staff / Employee / People', NULL, 'page_ppl.php', 'page_ppl.php', 1, 'people', 'people_id');
INSERT INTO `page_types` VALUES(4, 4, 16, 'Partners / Sponsors / Organizations', NULL, 'page_orgs.php', 'page_orgs.php', 1, 'organizations', 'org_id');
INSERT INTO `page_types` VALUES(5, 1, 8, 'Text with Image, Quote', NULL, 'page_edit.php', 'page_full.php', 1, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(6, 1, 12, 'FAQs', NULL, 'page_faqs.php', 'page_faqs.php', 1, 'faqs', 'faq_id');
INSERT INTO `page_types` VALUES(7, 5, 11, 'Events', NULL, 'page_events.php', 'page_events.php', 1, 'events', 'event_id');
INSERT INTO `page_types` VALUES(99, 1, 99, 'Special Functions', 'Webmaster use only', 'page_edit.php', 'page_spec.php', 1, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(8, 5, 14, 'News', 'News, Press & Media Pages', 'page_news.php', 'press_media.php', 1, 'news', 'news_id');
INSERT INTO `page_types` VALUES(10, 1, 18, 'Resources', 'page for links, pdfs, docs, etc', 'page_resources.php', 'page_res.php', 1, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(90, 2, 90, 'Custom (Home)', NULL, 'page_home.php', 'index.php', 1, 'specials', 'special_id');
INSERT INTO `page_types` VALUES(9, 1, 6, 'Text with Video', NULL, 'page_videos.php', 'page_videos.php', 1, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(70, 1, 70, 'Main Menu', NULL, 'page_edit.php', 'page_text.php', NULL, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(11, 7, 9, 'Case Studies', NULL, 'page_case_studies.php', 'page_case_studies.php', 1, 'case_studies', 'case_study_id');
INSERT INTO `page_types` VALUES(12, 1, 10, 'Contact', NULL, 'page_edit.php', 'page_contact.php', 1, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(999, 1, 127, 'TEST PAGE ONLY', NULL, 'page_edit.php', 'page_test.php', 1, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(98, 1, 98, 'CMS Home Page', 'Content on CMS Home Page', 'page_edit.php', 'admin/home.php', 1, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(96, 1, 96, 'CMS Admin FAQS', NULL, 'page_faqs.php', 'admin/faqs.php', 1, 'pages', 'page_id');
INSERT INTO `page_types` VALUES(97, 1, 97, 'CMS Admin Help', NULL, 'page_help.php', 'admin/help.php', 1, 'pages', 'page_id');

-- --------------------------------------------------------

--
-- Table structure for table `pdfs`
--

CREATE TABLE `pdfs` (
  `pdf_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `display_order` varchar(20) default NULL,
  `title` varchar(255) default NULL,
  `pdf_file` varchar(255) NOT NULL,
  `flipbook` varchar(255) default NULL,
  PRIMARY KEY  (`pdf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pdfs`
--


-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `people_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `sort_by` varchar(20) default NULL,
  `first_name` varchar(20) default NULL,
  `middle_name` varchar(20) default NULL,
  `last_name` varchar(50) NOT NULL,
  `title` varchar(50) default NULL,
  `phone` varchar(20) default NULL,
  `email` varchar(50) default NULL,
  `short_desc` varchar(255) default NULL,
  `description` text NOT NULL,
  `desc_2` text,
  `desc_3` text,
  `desc_4` text,
  `desc_5` text,
  `table_1` varchar(255) default NULL,
  `table_2` varchar(255) default NULL,
  `other_1` varchar(255) default NULL,
  `image_file` varchar(255) default NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY  (`people_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` VALUES(2, 1034, '1', 'Arlene', NULL, 'Santos', 'Creative Director, Founder', '925 123 1234', 'arlene@agdesigngroup.net', NULL, '<p>this is a test</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'photo__20101215110308.jpg', '2010-12-15 11:12:23', '2010-12-15 11:03:10');
INSERT INTO `people` VALUES(3, 1034, '2', 'Perli', NULL, 'S', 'asdf', 'asdf', 'asdf', NULL, '<p>asdf</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'photo__20101215120833.jpg', '2010-12-15 12:08:34', '2010-12-15 12:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

CREATE TABLE `pricing` (
  `pricing_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `short_desc` varchar(255) default NULL,
  `description` text,
  `price` double NOT NULL,
  `display_order` varchar(50) default NULL,
  PRIMARY KEY  (`pricing_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pricing`
--


-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `resource_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `sort_by` varchar(20) default NULL,
  `resource_cat_id` tinyint(4) default NULL,
  `title` varchar(255) default NULL,
  `short_desc` varchar(255) default NULL,
  `resource_link` varchar(255) default NULL,
  `resource_file` varchar(255) default NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY  (`resource_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` VALUES(2, 3, '1', 1, 'CMS Manual - PDF', NULL, NULL, 'res_20101213173450.pdf', '2010-12-13 17:34:50', '2010-12-13 17:34:50');
INSERT INTO `resources` VALUES(3, 1035, '1', 1, 'resource pdf', NULL, NULL, 'res_20101215121009.pdf', '2010-12-15 12:10:09', '2010-12-15 12:10:09');
INSERT INTO `resources` VALUES(4, 1035, '2', 1, 'x', NULL, NULL, 'res_20101215121105.pdf', '2010-12-15 12:11:05', '2010-12-15 12:11:05');
INSERT INTO `resources` VALUES(5, 1035, '3', 1, 'asdf', NULL, NULL, 'res_20101215121240.pdf', '2010-12-15 12:12:40', '2010-12-15 12:12:40');
INSERT INTO `resources` VALUES(6, 1035, '4', 1, 'asdf', NULL, 'http://www.yahoo.com', NULL, '2010-12-15 12:12:59', '2010-12-15 12:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `resource_cats`
--

CREATE TABLE `resource_cats` (
  `resource_cat_id` tinyint(4) NOT NULL auto_increment,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`resource_cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `resource_cats`
--

INSERT INTO `resource_cats` VALUES(1, 'General');
INSERT INTO `resource_cats` VALUES(6, 'Social Media');
INSERT INTO `resource_cats` VALUES(7, 'Blogs');
INSERT INTO `resource_cats` VALUES(8, 'Website Hosting');
INSERT INTO `resource_cats` VALUES(9, 'Other Resources');

-- --------------------------------------------------------

--
-- Table structure for table `searches`
--

CREATE TABLE `searches` (
  `search_id` bigint(20) NOT NULL auto_increment,
  `create_date` datetime NOT NULL,
  `text` varchar(255) NOT NULL,
  `IP` varchar(25) NOT NULL,
  PRIMARY KEY  (`search_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=249 ;

--
-- Dumping data for table `searches`
--


-- --------------------------------------------------------

--
-- Table structure for table `specials`
--

CREATE TABLE `specials` (
  `special_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `step1_title` varchar(255) NOT NULL,
  `step1_sub1_title` varchar(255) NOT NULL,
  `step1_sub1` varchar(255) NOT NULL,
  `step1_sub2_title` varchar(255) default NULL,
  `step1_sub2` varchar(255) default NULL,
  `step1_sub3_title` varchar(255) default NULL,
  `step1_sub3` varchar(255) default NULL,
  `step1_consider` text NOT NULL,
  `step2_title` varchar(255) NOT NULL,
  `step2_sub1_title` varchar(255) NOT NULL,
  `step2_sub1` varchar(255) NOT NULL,
  `step2_sub2_title` varchar(255) default NULL,
  `step2_sub2` varchar(255) default NULL,
  `step2_sub3_title` varchar(255) default NULL,
  `step2_sub3` varchar(255) default NULL,
  `step2_consider` text NOT NULL,
  `step3_title` varchar(255) NOT NULL,
  `step3_sub1_title` varchar(255) NOT NULL,
  `step3_sub1` varchar(255) NOT NULL,
  `step3_sub2_title` varchar(255) default NULL,
  `step3_sub2` varchar(255) default NULL,
  `step3_sub3_title` varchar(255) default NULL,
  `step3_sub3` varchar(255) default NULL,
  `step3_consider` text NOT NULL,
  `quick_links` text NOT NULL,
  `other1` text,
  `other2` text,
  `other3` text,
  `image1_filename` varchar(255) default NULL,
  `image2_filename` varchar(255) default NULL,
  `image3_filename` varchar(255) default NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY  (`special_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `specials`
--

INSERT INTO `specials` VALUES(1, 82, '', 'Fast', 'Most documents ready in less than a week!', '', 'Save 50-70% off typical lawyer fees.', NULL, 'We''re here to answer your questions about the preparation process. ', NULL, '<p><strong><span class="homeTitle">California Document Preparers</span></strong><span class="homeTitle"><sup class="homtTitleSM">SM</sup>: Your local resource for common legal documents.<br />\r\n</span></p>\r\n<p>We help people every day with <strong>Revocable Living Trusts, Divorces, Deeds,</strong> and other common uncontested legal matters.</p>', 'Affordable', '', '', NULL, NULL, NULL, NULL, '<p>We''re in your neighborhood! California Document Preparers (formerly For  The People) has been helping Bay Area families and small business owners  with their legal document needs for 7 years. With our 3 convenient  locations in Walnut Creek, Oakland and Dublin, CDP is able to extend our  services to the entire East Bay.    <br />\r\n<br />\r\nOur job is to walk you through the process of filling out your  documents. We then take your documents and prepare them for court&mdash;we  even take your documents to court. Whether you&rsquo;re filing for  incorporation or going through an amicable divorce, California Document  Preparers can help!</p>', 'Straightforward', '', '', NULL, NULL, NULL, NULL, '', '', 'Locally Owned & Operated', 'Knowledgeable and friendly staff who truly care about their customers.', NULL, 'success__20100816184248.jpg', 'success__20100816184231.jpg', 'success__20100816184527.jpg', '2010-11-15 14:22:07', '2010-08-12 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) default NULL,
  `sort_by` varchar(20) default NULL,
  `active` tinyint(1) default NULL,
  `first_name` varchar(20) default NULL,
  `middle_name` varchar(20) default NULL,
  `last_name` varchar(50) NOT NULL,
  `title` varchar(50) default NULL,
  `phone` varchar(20) default NULL,
  `email` varchar(50) default NULL,
  `short_desc` varchar(255) default NULL,
  `description` text NOT NULL,
  `desc_2` text,
  `desc_3` text,
  `desc_4` text,
  `desc_5` text,
  `table_1` varchar(255) default NULL,
  `table_2` varchar(255) default NULL,
  `other_1` varchar(255) default NULL,
  `image_file` varchar(255) default NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY  (`staff_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=349 ;

--
-- Dumping data for table `staff`
--


-- --------------------------------------------------------

--
-- Table structure for table `staff_types`
--

CREATE TABLE `staff_types` (
  `staff_type_id` tinyint(4) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`staff_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `staff_types`
--

INSERT INTO `staff_types` VALUES(1, 'Board');
INSERT INTO `staff_types` VALUES(2, 'Principal');
INSERT INTO `staff_types` VALUES(3, 'Manager');
INSERT INTO `staff_types` VALUES(4, 'Senior Associate');
INSERT INTO `staff_types` VALUES(5, 'Associate');
INSERT INTO `staff_types` VALUES(6, 'Recovery Service');
INSERT INTO `staff_types` VALUES(7, 'Administration');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `display_order` varchar(10) default NULL,
  `title` varchar(255) default NULL,
  `swf` varchar(255) default NULL,
  `flv` varchar(255) default NULL,
  `other1` varchar(255) default NULL,
  `other2` varchar(255) default NULL,
  `other3` varchar(255) default NULL,
  `other4` varchar(255) default NULL,
  `last_update` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY  (`video_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `videos`
--

