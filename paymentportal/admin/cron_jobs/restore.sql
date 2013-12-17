-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: 10.6.186.104
-- Generation Time: Aug 17, 2010 at 12:04 PM
-- Server version: 5.0.91
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `skyhighcmsdemo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` tinyint(3) NOT NULL auto_increment,
  `email` varchar(70) NOT NULL default '',
  `password` varchar(15) NOT NULL default '',
  `admin_lvl` tinyint(3) NOT NULL default '0',
  `first_name` varchar(40) NOT NULL default '',
  `last_name` varchar(40) NOT NULL default '',
  `create_date` date NOT NULL default '0000-00-00',
  `update_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` VALUES(1, 'sara@skyhighsoftware.com', 'saralee7', 9, 'Sara', 'Swafford', '2008-01-29', '2009-04-14');
INSERT INTO `admin` VALUES(2, 'demo', 'demo', 3, 'Admin ', 'Admin', '2009-07-27', '2010-07-08');
INSERT INTO `admin` VALUES(3, 'arlene@agdesigngroup.net', 'passw0rd', 9, 'Arlene', 'Santos', '2010-02-27', '2010-02-27');
INSERT INTO `admin` VALUES(4, 'perlita@agdesigngroup.net', 'passw0rd', 9, 'Perlita', 'Sahaji', '2010-07-08', '2010-07-08');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=342 ;

--
-- Dumping data for table `admin_log`
--

INSERT INTO `admin_log` VALUES(341, 2, '2010-08-16', '00:44:24', '01:14:24');

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
  `active` int(2) NOT NULL default '1',
  `last_update` datetime NOT NULL default '0000-00-00 00:00:00',
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`case_study_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `case_studies`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `events`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` VALUES(45, 77, '05', '<p>What is CMS?</p>', '<p>A <b>content management system</b> (<b>CMS</b>) is the system to manage website content including:</p>\r\n<ul>\r\n    <li>Text content</li>\r\n    <li>Image content, either singally on a page or in photo galleries</li>\r\n    <li>Lists of people or organizations</li>\r\n    <li>Video content</li>\r\n    <li>Audio Content</li>\r\n    <li>PDFs, MS&nbsp;Word Docs, and more</li>\r\n</ul>', '2010-08-16 16:33:09', '2010-08-16 16:33:09');
INSERT INTO `faqs` VALUES(46, 77, '10', '<p>Can I have a photo gallery that I can manage myself?</p>', '<p>Yes!</p>', '2010-08-16 16:55:05', '2010-08-16 16:55:05');
INSERT INTO `faqs` VALUES(47, 77, '15', '<p>Does it cost more to get a website with CMS?</p>', '<p>With CMS your initial website cost is higher.&nbsp; However, in the long run you will most likely save time and money because you will be able to avoid calling your webmaster to make simple changes for you.&nbsp; You also won\\''t have to wait for your webmaster to find the time to make critical changes.</p>', '2010-08-16 16:59:10', '2010-08-16 16:57:28');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` VALUES(17, 79, '2010-08-14', 'New Sky High CMS Demo Site!', '<p>The new Sky High CMS demo site is under construction and will be ready soon.</p>', '<p>The new Sky High CMS demo site is under construction and will be ready soon.&nbsp; You will be able to log into the admin area and make changes to the site and see the results right away!&nbsp; </p>', NULL, NULL, NULL, 1, '2010-08-14 09:13:34', '2010-08-14 09:13:34');
INSERT INTO `news` VALUES(18, 79, '2010-08-16', 'New Sky High CMS Demo Site Works!', '<p>The new Sky High CMS demo site is working.</p>', '<p>The new Sky High CMS demo site is working and ready to use.&nbsp; Site enhancements will be ongoing as we make enhancements and improve visuals.</p>', NULL, NULL, NULL, 1, '2010-08-14 09:20:42', '2010-08-14 09:20:42');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` VALUES(21, 78, NULL, 'logo_For The People_20100816181402.jpg', 'For The People', 'For The People has been helping Bay Area families and businesses with their legal document preparation.', '<div id="homeIntro"><strong>For The People</strong> has been helping Bay Area families  and businesses with their legal document preparation for 7 years.   Contact one of our Bay Area locations for more information on how we can  help you.\r\n<ul>\r\n    <li><b>Fast:</b> Same Day Appointments.  Documents in a  week or less!</li>\r\n    <li><b>Affordable:</b> Save 50-70% of the typical costs.</li>\r\n    <li><b>Simple:</b> We make it simple for you in a  difficult time.  Call Today!</li>\r\n    <li><b>Locally Owned &amp; Operated</b> to better serve you.</li>\r\n</ul>\r\n</div>', '925.407.1010', '2061 Mt. Diablo Boulevard', 'Walnut Creek', 'CA', '94596', 'http://www.forthepeopleusa.com', 'ftpwc@forthepeopleusa.com', NULL, NULL, NULL, '2010-08-16 17:14:03', '2010-08-16 17:14:03');
INSERT INTO `organizations` VALUES(22, 78, NULL, 'logo_East Bay Score_20100816181934.jpg', 'East Bay Score', 'SCORE is an Organization of successful business entrepreneurs and industry executives who volunteer to counsel and mentor businesses at no cost - from start-up to success. ', NULL, ' 510-273-6611', '492 - 9th Street, Suite 350', 'Oakland', 'CA', '94607', 'http://www.eastbayscore.org', 'info@eastbayscore.org', NULL, NULL, NULL, '2010-08-16 17:19:56', '2010-08-16 17:19:34');

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
  `sub_nav_title` varchar(65) NOT NULL,
  `snippet` varchar(255) default NULL,
  `other` varchar(255) default NULL,
  `other2` varchar(255) default NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` VALUES(82, NULL, 99, NULL, 90, NULL, 1, 1, 'Home', NULL, 'Home', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-08-14 08:53:15', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(71, NULL, 1, NULL, 2, NULL, 1, 1, 'About This Demo', NULL, 'About This Demo', NULL, NULL, NULL, '<p>This site is your demo!&nbsp; It''s not meant to be pretty, but to  demonstrate how our CMS system works.  Sky High Software works with  graphic designers to integrate their design work wtih our CMS.<br />\r\n<br />\r\nEvery page on this demo site is updateable via the<a href="../../../admin"> Demo Admin</a>.</p>\r\n<p>Make changes in the</p>\r\n<strong>Admin</strong>\r\n<p>area and the switch over to view how it looks on the</p>\r\n<strong>Demo Site</strong>\r\n<p>.</p>\r\n<p>Feel free to contact us <a href="mailto:sara@skyhighsoftware.com">sara@skyhighsoftware.com</a> if you have any questions or comments.</p>\r\n<p>&nbsp;</p>', NULL, 2, 2, NULL, 1, NULL, '3,9', '2010-08-16 17:21:36', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(83, NULL, 5, NULL, 2, NULL, 1, 1, 'Standard Pages', NULL, 'Standard Pages', NULL, NULL, NULL, '<p>Standard page types include:</p>\r\n<ul>\r\n    <li>Plain text</li>\r\n    <li>Text with image</li>\r\n    <li>News &amp; Media</li>\r\n    <li>People (ie Staff)</li>\r\n    <li>Organizations (Sponsors, Partners, etc)</li>\r\n    <li>Resources (PDFs, Links, etc)</li>\r\n    <li>FAQs</li>\r\n</ul>', NULL, 2, 2, NULL, 1, NULL, '3,9', '2010-08-17 09:30:15', '2010-08-17 00:00:00');
INSERT INTO `pages` VALUES(72, 71, 1, NULL, 2, NULL, NULL, 1, 'How It Works', NULL, 'How It Works', NULL, NULL, NULL, '<p>Sky High Content Management Systems provide an easy-to-use administrative area where you can add text and image content to your website.&nbsp;&nbsp; </p>\r\n<p>Just log into the admin area, choose &quot;Manage Pages&quot;, and then click the &quot;Edit&quot; button for the page you want to edit.</p>\r\n<p>Once you save your changes, they are instantly live.&nbsp; </p>\r\n<p>Feel free to give it a try.&nbsp; <a href="http://www.skyhighsoftware.com/SkyHighCMS/admin" target="_blank">Click here</a> to log into the admin area.&nbsp; A new window will open and you can make changes in the admin area, then come back to this window to view the results!</p>', 'page__20100816163341.jpg', 2, 2, NULL, 1, NULL, '3,9', '2010-08-16 15:17:06', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(73, NULL, 3, NULL, 2, NULL, 1, 1, 'About Us', NULL, 'About Us', NULL, NULL, NULL, '<p>At Sky High Software, we have over 20 years of software development  experience and have specialized in web programming since 2005.</p>\r\n<p class="pagesubtitle"><strong>Our Mission </strong></p>\r\n<p>Our mission is to provide creative, high quality technical  solutions that communicate your vision and enhance your personal or  business productivity.</p>\r\n<p class="pagesubtitle"><strong>Our Process </strong></p>\r\n<p>We provide a free initial consultation and written estimate. We  listen to your needs and provide a detailed cost breakdown so that you  can choose the features you want.</p>\r\n<p class="pagesubtitle"><strong>Technologies &amp; Tools </strong></p>\r\n<table width="500">\r\n    <tbody>\r\n        <tr>\r\n            <td valign="top">\r\n            <ul>\r\n                <li>HMTL</li>\r\n                <li>XHTML</li>\r\n                <li>JavaScript</li>\r\n                <li>CSS</li>\r\n            </ul>\r\n            </td>\r\n            <td valign="top">\r\n            <ul>\r\n                <li>Dreamweaver CS3</li>\r\n                <li>Fireworks CS3</li>\r\n                <li>Flash CS3</li>\r\n                <li>Photoshop CS3</li>\r\n            </ul>\r\n            </td>\r\n            <td valign="top">\r\n            <ul>\r\n                <li><strong>PHP</strong></li>\r\n                <li><strong>MySQL</strong></li>\r\n                <li>XML<strong><br />\r\n                </strong></li>\r\n            </ul>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>', NULL, 2, 2, NULL, 1, NULL, '3,9', '2010-08-16 15:37:07', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(74, 83, 4, NULL, 3, NULL, NULL, NULL, 'Our Staff', NULL, 'Our Staff', NULL, NULL, NULL, '<p>This is an introductory paragraph that is optional for pages with repeating information such as staff, sponsors, partners, etc.</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-08-16 23:56:22', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(75, 73, 1, NULL, 2, NULL, NULL, NULL, 'Our Company', NULL, 'Our Company', NULL, NULL, NULL, '<p>Sky High Software was established in 2005.&nbsp; Leveraging over 20 years of programming experience, we began developing websites for small businesses.&nbsp; <br />\r\n<br />\r\nDuring the years since we have developed a variety of tools to create engaging and useful websites.&nbsp; Our goal is to create and provide tools that can be integrated in professionally designed websites that also give business owners the ability to keep their website content up-to-date with easy to use content management systems.</p>', NULL, 2, 2, NULL, 1, NULL, '3,9', '2010-08-16 15:42:08', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(76, NULL, 4, NULL, 2, NULL, 1, 1, 'Testimonials', NULL, 'Testimonials', NULL, NULL, NULL, '<p><em><strong>About Sky High CMS</strong><br />\r\n<br />\r\nI changed my pic and bio ... &nbsp;&nbsp; yahoo was that ever <span style="color: rgb(255, 0, 0);">EASY</span>!!!<br />\r\n<br />\r\n- Marlise K.<br />\r\n</em></p>', NULL, 2, 2, NULL, 1, NULL, '3,9', '2010-08-16 16:25:45', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(77, 83, 7, NULL, 6, NULL, NULL, NULL, 'FAQs', NULL, 'FAQs', NULL, NULL, NULL, '<p>Optional introductory paragraph for FAQ page.</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-08-16 23:58:06', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(78, 83, 5, NULL, 4, NULL, NULL, NULL, 'Organizations', NULL, 'Organizations', NULL, NULL, NULL, '<p>Optional introduction to&nbsp; your list of sponsors, partners, or other organizations.</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-08-16 23:58:18', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(79, 83, 3, NULL, 8, NULL, NULL, NULL, 'News & Media', NULL, 'News & Media', NULL, NULL, NULL, '<p>Latest articles from the news and media page can be featured on the home page.</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-08-16 23:59:11', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(80, 83, 6, NULL, 10, NULL, NULL, NULL, 'Resources', NULL, 'Resources', NULL, NULL, NULL, '<p>The resources page can include links to website resources or PDFs for articles and other material.</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-08-16 23:57:55', '2010-08-12 00:00:00');
INSERT INTO `pages` VALUES(87, NULL, 7, NULL, 12, NULL, 1, 1, 'Contact Us', NULL, 'Contact Us', 'CMS; Event Registration; eCommerce; Photo Gallery; Videos; Other', '2', NULL, '<p>We welcome all inquiries.&nbsp; Please fill out the form below and let us know your area of interest.</p>', NULL, NULL, NULL, NULL, 1, NULL, '3,9', '2010-08-17 10:17:13', '2010-08-17 00:00:00');
INSERT INTO `pages` VALUES(84, 83, 1, NULL, 2, NULL, NULL, NULL, 'Plain Text', NULL, 'Plain Text', NULL, NULL, NULL, '<p><strong>This is a plain text page sample.&nbsp; Image is omitted.&nbsp; The basic editor allows bolding, italic, bullet point lists, numbered lists, and links.&nbsp; The advanced editor allow many more features.</strong></p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus  lobortis elit in magna dapibus lacinia. Phasellus gravida dui eget  tellus mattis ac ultrices magna fringilla. Integer suscipit dapibus  augue et malesuada. Sed dictum malesuada vestibulum.</p>\r\n<p>Class aptent taciti  sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.  Mauris ultrices leo mi, in rutrum massa.</p>\r\n<p>Nunc a feugiat orci.  Suspendisse congue, massa sit amet vulputate vestibulum, felis arcu  consectetur nulla, ut lacinia ligula ante vitae lacus. Sed dignissim  turpis eu nulla suscipit in congue velit pulvinar. Vestibulum molestie  mi a nibh tempus a fringilla elit scelerisque. Curabitur tincidunt  aliquam risus.</p>\r\n<p>Nunc sed justo lacus. Curabitur elit odio, vulputate at  egestas sollicitudin, iaculis eu erat.</p>\r\n<p>&nbsp;</p>', NULL, 2, 2, NULL, 1, NULL, '3,9', '2010-08-17 10:15:44', '2010-08-17 00:00:00');
INSERT INTO `pages` VALUES(85, 83, 2, NULL, 2, NULL, NULL, NULL, 'Text With Image', NULL, 'Text With Image', NULL, NULL, NULL, '<p>Text With Image pages allow you to upload an image that will automatically be sized appropriately for the page.&nbsp; You can also specify left or right alignment.</p>\r\n<p>When the advanced editor is turned on, you can upload and embed many images within the text content.</p>\r\n<p>Image to the right is DandHAutoRepair.com, an award winning site designed by <a href="http://www.agdesigngroup.net">AG&nbsp;Design</a> and powered by Sky High&nbsp;CMS.</p>\r\n<p>&nbsp;</p>', 'page__20100817005458.jpg', 2, 2, NULL, 1, NULL, '3,9', '2010-08-16 23:54:58', '2010-08-17 00:00:00');
INSERT INTO `pages` VALUES(86, NULL, 6, NULL, 2, NULL, 1, 1, 'Custom Pages', NULL, 'Custom Pages', NULL, NULL, NULL, '<p>Common custom pages include:</p>\r\n<ul>\r\n    <li>Contact Us</li>\r\n    <li>Events</li>\r\n    <li>Expandable Text</li>\r\n</ul>\r\n<p>We can also create custom pages for special layouts.&nbsp; Examples are:</p>\r\n<ul>\r\n    <li><a target="_blank" href="http://www.triageconsulting.com/page_map.php?page_id=45">Map Page</a></li>\r\n    <li><a target="_blank" href="http://eastbayscore.org/success_stories.php">Success Page</a></li>\r\n</ul>', NULL, 2, 2, NULL, 1, NULL, '3,9', '2010-08-17 00:04:57', '2010-08-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `page_types`
--

CREATE TABLE `page_types` (
  `page_type_id` tinyint(4) NOT NULL auto_increment,
  `display_order` tinyint(4) NOT NULL default '1',
  `title` varchar(55) NOT NULL,
  `description` text,
  `edit_page` varchar(50) NOT NULL default 'page_edit.php',
  `display_page` varchar(50) NOT NULL,
  PRIMARY KEY  (`page_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `page_types`
--

INSERT INTO `page_types` VALUES(71, 71, 'Sub Menu', NULL, 'page_edit.php', 'page_text.php');
INSERT INTO `page_types` VALUES(2, 4, 'Text with Image', NULL, 'page_edit.php', 'page_text.php');
INSERT INTO `page_types` VALUES(3, 20, 'Staff / Employee / People', NULL, 'page_ppl.php', 'page_ppl.php');
INSERT INTO `page_types` VALUES(4, 16, 'Partners / Sponsors / Organizations', NULL, 'page_orgs.php', 'page_orgs.php');
INSERT INTO `page_types` VALUES(5, 8, 'Text with Image, Quote', NULL, 'page_edit.php', 'page_full.php');
INSERT INTO `page_types` VALUES(6, 12, 'FAQs', NULL, 'page_faqs.php', 'page_faqs.php');
INSERT INTO `page_types` VALUES(7, 11, 'Events', NULL, 'page_events.php', 'page_events.php');
INSERT INTO `page_types` VALUES(99, 99, 'Special Functions', 'Webmaster use only', 'page_edit.php', 'page_spec.php');
INSERT INTO `page_types` VALUES(8, 14, 'News', 'News, Press & Media Pages', 'page_news.php', 'press_media.php');
INSERT INTO `page_types` VALUES(10, 18, 'Resources', 'page for links, pdfs, docs, etc', 'page_resources.php', 'page_res.php');
INSERT INTO `page_types` VALUES(90, 90, 'Custom (Home)', NULL, 'page_home.php', 'index.php');
INSERT INTO `page_types` VALUES(9, 6, 'Text with Video', NULL, 'page_videos.php', 'page_videos.php');
INSERT INTO `page_types` VALUES(70, 70, 'Main Menu', NULL, 'page_edit.php', 'page_text.php');
INSERT INTO `page_types` VALUES(11, 9, 'Case Studies', NULL, 'page_case_studies.php', 'page_case_studies.php');
INSERT INTO `page_types` VALUES(12, 10, 'Contact', NULL, 'page_contact.php', 'page_contact.php');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` VALUES(1, 74, NULL, 'Sara', NULL, 'Swafford', 'CTO / Founder', '925 759 4405', 'sara@skyhighsoftware.com', NULL, '<p>\r\n<meta content=\\"\\\\&quot;text/html;\\" charset=\\"utf-8\\\\&quot;\\" http-equiv=\\"\\\\&quot;Content-Type\\\\&quot;\\">\r\n<meta content=\\"\\\\&quot;Word.Document\\\\&quot;\\" name=\\"\\\\&quot;ProgId\\\\&quot;\\">\r\n<meta content=\\"\\\\&quot;Microsoft\\" word=\\"\\" name=\\"\\\\&quot;Generator\\\\&quot;\\">\r\n<meta content=\\"\\\\&quot;Microsoft\\" word=\\"\\" name=\\"\\\\&quot;Originator\\\\&quot;\\">\r\n<link href=\\"\\\\&quot;file:///C:\\\\\\\\Users\\\\\\\\Sara\\\\\\\\AppData\\\\\\\\Local\\\\\\\\Temp\\\\\\\\msohtmlclip1\\\\\\\\01\\\\\\\\clip_filelist.xml\\\\&quot;\\" rel=\\"\\\\&quot;File-List\\\\&quot;\\" />\r\n<link href=\\"\\\\&quot;file:///C:\\\\\\\\Users\\\\\\\\Sara\\\\\\\\AppData\\\\\\\\Local\\\\\\\\Temp\\\\\\\\msohtmlclip1\\\\\\\\01\\\\\\\\clip_themedata.thmx\\\\&quot;\\" rel=\\"\\\\&quot;themeData\\\\&quot;\\" />\r\n<link href=\\"\\\\&quot;file:///C:\\\\\\\\Users\\\\\\\\Sara\\\\\\\\AppData\\\\\\\\Local\\\\\\\\Temp\\\\\\\\msohtmlclip1\\\\\\\\01\\\\\\\\clip_colorschememapping.xml\\\\&quot;\\" rel=\\"\\\\&quot;colorSchemeMapping\\\\&quot;\\" /><!--[if gte mso 9]><xml>\r\n<w:WordDocument>\r\n<w:View>Normal</w:View>\r\n<w:Zoom>0</w:Zoom>\r\n<w:TrackMoves />\r\n<w:TrackFormatting />\r\n<w:PunctuationKerning />\r\n<w:ValidateAgainstSchemas />\r\n<w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>\r\n<w:IgnoreMixedContent>false</w:IgnoreMixedContent>\r\n<w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>\r\n<w:DoNotPromoteQF />\r\n<w:LidThemeOther>EN-US</w:LidThemeOther>\r\n<w:LidThemeAsian>X-NONE</w:LidThemeAsian>\r\n<w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>\r\n<w:Compatibility>\r\n<w:BreakWrappedTables />\r\n<w:SnapToGridInCell />\r\n<w:WrapTextWithPunct />\r\n<w:UseAsianBreakRules />\r\n<w:DontGrowAutofit />\r\n<w:SplitPgBreakAndParaMark />\r\n<w:DontVertAlignCellWithSp />\r\n<w:DontBreakConstrainedForcedTables />\r\n<w:DontVertAlignInTxbx />\r\n<w:Word11KerningPairs />\r\n<w:CachedColBalance />\r\n</w:Compatibility>\r\n<w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>\r\n<m:mathPr>\r\n<m:mathFont m:val=\\\\\\"Cambria Math\\\\\\" />\r\n<m:brkBin m:val=\\\\\\"before\\\\\\" />\r\n<m:brkBinSub m:val=\\\\\\"&#45;-\\\\\\" />\r\n<m:smallFrac m:val=\\\\\\"off\\\\\\" />\r\n<m:dispDef />\r\n<m:lMargin m:val=\\\\\\"0\\\\\\" />\r\n<m:rMargin m:val=\\\\\\"0\\\\\\" />\r\n<m:defJc m:val=\\\\\\"centerGroup\\\\\\" />\r\n<m:wrapIndent m:val=\\\\\\"1440\\\\\\" />\r\n<m:intLim m:val=\\\\\\"subSup\\\\\\" />\r\n<m:naryLim m:val=\\\\\\"undOvr\\\\\\" />\r\n</m:mathPr></w:WordDocument>\r\n</xml><![endif]--><!--[if gte mso 9]><xml>\r\n<w:LatentStyles DefLockedState=\\\\\\"false\\\\\\" DefUnhideWhenUsed=\\\\\\"true\\\\\\"\r\nDefSemiHidden=\\\\\\"true\\\\\\" DefQFormat=\\\\\\"false\\\\\\" DefPriority=\\\\\\"99\\\\\\"\r\nLatentStyleCount=\\\\\\"267\\\\\\">\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"0\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Normal\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"9\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"heading 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"9\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"heading 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"9\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"heading 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"9\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"heading 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"9\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"heading 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"9\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"heading 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"9\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"heading 7\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"9\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"heading 8\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"9\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"heading 9\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"39\\\\\\" Name=\\\\\\"toc 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"39\\\\\\" Name=\\\\\\"toc 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"39\\\\\\" Name=\\\\\\"toc 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"39\\\\\\" Name=\\\\\\"toc 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"39\\\\\\" Name=\\\\\\"toc 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"39\\\\\\" Name=\\\\\\"toc 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"39\\\\\\" Name=\\\\\\"toc 7\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"39\\\\\\" Name=\\\\\\"toc 8\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"39\\\\\\" Name=\\\\\\"toc 9\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"35\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"caption\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"10\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Title\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"1\\\\\\" Name=\\\\\\"Default Paragraph Font\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"11\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Subtitle\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"22\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Strong\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"20\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Emphasis\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"59\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Table Grid\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" UnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Placeholder Text\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"1\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"No Spacing\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"60\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Shading\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"61\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light List\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"62\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Grid\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"63\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"64\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"65\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"66\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"67\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"68\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"69\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"70\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Dark List\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"71\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Shading\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"72\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful List\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"73\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Grid\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"60\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Shading Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"61\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light List Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"62\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Grid Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"63\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 1 Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"64\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 2 Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"65\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 1 Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" UnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Revision\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"34\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"List Paragraph\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"29\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Quote\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"30\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Intense Quote\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"66\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 2 Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"67\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 1 Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"68\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 2 Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"69\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 3 Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"70\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Dark List Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"71\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Shading Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"72\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful List Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"73\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Grid Accent 1\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"60\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Shading Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"61\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light List Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"62\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Grid Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"63\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 1 Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"64\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 2 Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"65\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 1 Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"66\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 2 Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"67\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 1 Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"68\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 2 Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"69\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 3 Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"70\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Dark List Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"71\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Shading Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"72\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful List Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"73\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Grid Accent 2\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"60\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Shading Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"61\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light List Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"62\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Grid Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"63\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 1 Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"64\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 2 Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"65\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 1 Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"66\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 2 Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"67\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 1 Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"68\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 2 Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"69\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 3 Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"70\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Dark List Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"71\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Shading Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"72\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful List Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"73\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Grid Accent 3\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"60\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Shading Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"61\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light List Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"62\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Grid Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"63\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 1 Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"64\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 2 Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"65\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 1 Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"66\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 2 Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"67\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 1 Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"68\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 2 Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"69\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 3 Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"70\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Dark List Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"71\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Shading Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"72\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful List Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"73\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Grid Accent 4\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"60\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Shading Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"61\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light List Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"62\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Grid Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"63\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 1 Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"64\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 2 Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"65\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 1 Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"66\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 2 Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"67\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 1 Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"68\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 2 Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"69\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 3 Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"70\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Dark List Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"71\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Shading Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"72\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful List Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"73\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Grid Accent 5\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"60\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Shading Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"61\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light List Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"62\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Light Grid Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"63\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 1 Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"64\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Shading 2 Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"65\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 1 Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"66\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium List 2 Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"67\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 1 Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"68\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 2 Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"69\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Medium Grid 3 Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"70\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Dark List Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"71\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Shading Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"72\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful List Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"73\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" Name=\\\\\\"Colorful Grid Accent 6\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"19\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Subtle Emphasis\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"21\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Intense Emphasis\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"31\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Subtle Reference\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"32\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Intense Reference\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"33\\\\\\" SemiHidden=\\\\\\"false\\\\\\"\r\nUnhideWhenUsed=\\\\\\"false\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"Book Title\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"37\\\\\\" Name=\\\\\\"Bibliography\\\\\\" />\r\n<w:LsdException Locked=\\\\\\"false\\\\\\" Priority=\\\\\\"39\\\\\\" QFormat=\\\\\\"true\\\\\\" Name=\\\\\\"TOC Heading\\\\\\" />\r\n</w:LatentStyles>\r\n</xml><![endif]--><style type=\\"\\\\&quot;text/css\\\\&quot;\\">\r\n<!--\r\n /* Font Definitions */\r\n @font-face\r\n	{font-family:\\\\\\"Cambria Math\\\\\\";\r\n	panose-1:2 4 5 3 5 4 6 3 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:roman;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:-1610611985 1107304683 0 0 159 0;}\r\n /* Style Definitions */\r\n p.MsoNormal, li.MsoNormal, div.MsoNormal\r\n	{mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	mso-style-parent:\\\\\\"\\\\\\";\r\n	margin:0in;\r\n	margin-bottom:.0001pt;\r\n	mso-pagination:widow-orphan;\r\n	font-size:12.0pt;\r\n	font-family:\\\\\\"Times New Roman\\\\\\",\\\\\\"serif\\\\\\";\r\n	mso-fareast-font-family:\\\\\\"Times New Roman\\\\\\";}\r\n.MsoChpDefault\r\n	{mso-style-type:export-only;\r\n	mso-default-props:yes;\r\n	font-size:10.0pt;\r\n	mso-ansi-font-size:10.0pt;\r\n	mso-bidi-font-size:10.0pt;}\r\n@page WordSection1\r\n	{size:8.5in 11.0in;\r\n	margin:1.0in 1.0in 1.0in 1.0in;\r\n	mso-header-margin:.5in;\r\n	mso-footer-margin:.5in;\r\n	mso-paper-source:0;}\r\ndiv.WordSection1\r\n	{page:WordSection1;}\r\n-->\r\n</style><!--[if gte mso 10]>\r\n<style>\r\n/* Style Definitions */\r\ntable.MsoNormalTable\r\n{mso-style-name:\\\\\\"Table Normal\\\\\\";\r\nmso-tstyle-rowband-size:0;\r\nmso-tstyle-colband-size:0;\r\nmso-style-noshow:yes;\r\nmso-style-priority:99;\r\nmso-style-qformat:yes;\r\nmso-style-parent:\\\\\\"\\\\\\";\r\nmso-padding-alt:0in 5.4pt 0in 5.4pt;\r\nmso-para-margin:0in;\r\nmso-para-margin-bottom:.0001pt;\r\nmso-pagination:widow-orphan;\r\nfont-size:11.0pt;\r\nfont-family:\\\\\\"Calibri\\\\\\",\\\\\\"sans-serif\\\\\\";\r\nmso-ascii-font-family:Calibri;\r\nmso-ascii-theme-font:minor-latin;\r\nmso-fareast-font-family:\\\\\\"Times New Roman\\\\\\";\r\nmso-fareast-theme-font:minor-fareast;\r\nmso-hansi-font-family:Calibri;\r\nmso-hansi-theme-font:minor-latin;\r\nmso-bidi-font-family:\\\\\\"Times New Roman\\\\\\";\r\nmso-bidi-theme-font:minor-bidi;}\r\n</style>\r\n<![endif]-->             </meta>\r\n</meta>\r\n</meta>\r\n</meta>\r\n</p>\r\n<p style=\\"\\" class=\\"\\\\&quot;MsoNormal\\\\&quot;\\">Sara Swafford is a website designer and the founder of Sky High Software.&nbsp; With over 25 years of experience as a software developer, she has a unique ability to create innovative technical solutions to business challenges.&nbsp; Translating&nbsp;these years of experience into top-notch skills for web design and development, Sara&nbsp;creates websites that are not only visually appealing but also technically advanced, including&nbsp;such features&nbsp;as&nbsp;members-only areas and custom e-commerce solutions.&nbsp;</p>\r\n<p class=\\"\\\\&quot;MsoNormal\\\\&quot;\\">&nbsp;</p>\r\n<p style=\\"\\" class=\\"\\\\&quot;MsoNormal\\\\&quot;\\">Sara believes the key to her success is in leveraging her technical skills to support her client&rsquo;s business vision and productivity.</p>\r\n<p>&nbsp;</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'photo__20100816164831.jpg', '2010-08-16 15:58:46', '2010-08-16 15:48:32');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` VALUES(41, 80, '1', 6, 'Facebook', NULL, 'http://www.facebook.com', NULL, '2010-08-12 11:29:48', '2010-08-12 11:29:48');
INSERT INTO `resources` VALUES(42, 80, '2', 6, 'LinkedIn', NULL, 'http://www.linkedin.com', NULL, '2010-08-12 11:30:09', '2010-08-12 11:30:09');
INSERT INTO `resources` VALUES(43, 80, '3', 6, 'Plaxo', NULL, 'http://www.plaxo.com', NULL, '2010-08-12 11:30:27', '2010-08-12 11:30:27');
INSERT INTO `resources` VALUES(44, 80, '4', 6, 'Twitter', NULL, 'http://www.twitter.com/skyhighsoftware', NULL, '2010-08-12 11:30:46', '2010-08-12 11:30:46');
INSERT INTO `resources` VALUES(45, 80, '1', 9, 'Sample PDF', NULL, NULL, 'res_20100812123643.pdf', '2010-08-12 11:36:44', '2010-08-12 11:36:44');
INSERT INTO `resources` VALUES(46, 80, '1', 7, 'Sky High Software Blog', NULL, 'http://www.skyhighsoftware.com/blog', NULL, '2010-08-12 11:37:37', '2010-08-12 11:37:37');
INSERT INTO `resources` VALUES(47, 80, '2', 7, 'For The People Blog', NULL, 'http://www.forthepeopleusa.com/blog', NULL, '2010-08-12 11:38:09', '2010-08-12 11:38:03');
INSERT INTO `resources` VALUES(48, 80, '3', 7, 'High Tech Exec Blog', NULL, 'http://www.hightechexecblog.com', NULL, '2010-08-12 11:38:45', '2010-08-12 11:38:45');
INSERT INTO `resources` VALUES(49, 80, '1', 8, 'Affordable Hosting', NULL, 'http://www.skyhighwebsites.com', NULL, '2010-08-12 11:40:24', '2010-08-12 11:39:18');
INSERT INTO `resources` VALUES(50, 80, '2', 9, 'Authorize.net', NULL, 'http://reseller.authorize.net/application/?id=192775', NULL, '2010-08-12 11:40:18', '2010-08-12 11:40:06');

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

INSERT INTO `specials` VALUES(1, 82, '', 'http://www.triageconsulting.com', '', '', NULL, NULL, NULL, NULL, '<p><strong>What is CMS?</strong><br />\r\n<br />\r\nCMS stands for Content Management Systems. And what that means is you getting control over the content of your website. CMS provides you a secure website administrative area where you can update text, images, video, audio, and other content on your site.  <br />\r\n<strong><br />\r\nHow is Sky High CMS different?</strong><br />\r\n<br />\r\n* Easy to use</p>\r\n<p>* Custom CMS pages for custom or complex layouts</p>\r\n<p>* Fully integrated into your custom designed site  <br />\r\n<br />\r\nSky High CMS provides you not only with the easy to use tools to update your content but is customized for your specific needs. So if you have a simple site and don''t want to plough through a complex system to be able to update your site, Sky High CMS provides just the tools you need to do that. If you have a complex site with specially formatted pages, Sky High CMS can create custom CMS pages for you.  Our goal is to also maintain website branding and design integraty. No need to choose a template or find widgets for functionality that might or might not work well. Sky High CMS is integrated into your custom design website. <br />\r\n<br />\r\n<strong>Demo  </strong><br />\r\n<br />\r\nThis site is a demo!&nbsp;  It''s not meant to be pretty, but to demonstrate how our CMS system works. Sky High Software works with graphic designers to integrate their design work wtih our CMS.</p>', 'http://www.eastbayscore.org', '', '', NULL, NULL, NULL, NULL, '', 'http://www.dandhautorepair.com', '', '', NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 'success__20100816184248.jpg', 'success__20100816184231.jpg', 'success__20100816184527.jpg', '2010-08-12 15:38:27', '2010-08-12 00:00:00');

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

