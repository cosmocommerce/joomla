# $Id: mambo.sql,v 1.6 2005/08/29 21:28:56 alekandreev Exp $

#
# Table structure for table `#__banner`
#

CREATE TABLE `#__banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default 'banner',
  `name` varchar(50) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `showBanner` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `custombannercode` text,
  PRIMARY KEY  (`bid`),
  KEY `viewbanner` (`showBanner`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Table structure for table `#__bannerclient`
#

CREATE TABLE `#__bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `contact` varchar(60) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) TYPE=MyISAM;

#
# Table structure for table `#__bannerfinish`
#

CREATE TABLE `#__bannerfinish` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `impressions` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(50) NOT NULL default '',
  `datestart` datetime default NULL,
  `dateend` datetime default NULL,
  PRIMARY KEY  (`bid`)
) TYPE=MyISAM;

#
# Table structure for table `#__categories`
#

CREATE TABLE `#__categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default 0,
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `image` varchar(100) NOT NULL default '',
  `section` varchar(50) NOT NULL default '',
  `image_position` varchar(10) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_section` (`section`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) TYPE=MyISAM;

#
# Table structure for table `#__components`
#

CREATE TABLE `#__components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` varchar(255) NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__components`
#

INSERT INTO `#__components` VALUES (1, 'Banners', '', 0, 0, '', 'Banner Management', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (2, 'Manage Banners', '', 0, 1, 'option=com_banners', 'Active Banners', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `#__components` VALUES (3, 'Manage Clients', '', 0, 1, 'option=com_banners&task=listclients', 'Manage Clients', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `#__components` VALUES (4, 'Web Links', 'option=com_weblinks', 0, 0, '', 'Manage Weblinks', 'com_weblinks', 0, 'js/ThemeOffice/globe2.png', 0, '');
INSERT INTO `#__components` VALUES (5, 'Weblink Items', '', 0, 4, 'option=com_weblinks', 'View existing weblinks', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `#__components` VALUES (6, 'Weblink Categories', '', 0, 4, 'option=com_categories&section=com_weblinks', 'Manage weblink categories', '', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `#__components` VALUES (7, 'Contacts', 'option=com_contact', 0, 0, '', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/user.png', 0, '');
INSERT INTO `#__components` VALUES (8, 'Manage Contacts', '', 0, 7, 'option=com_contact', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/edit.png', 1, '');
INSERT INTO `#__components` VALUES (9, 'Contact Categories', '', 0, 7, 'option=com_categories&section=com_contact_details', 'Manage contact categories', '', 2, 'js/ThemeOffice/categories.png', 1, '');
INSERT INTO `#__components` VALUES (10, 'FrontPage', 'option=com_frontpage', 0, 0, '', 'Manage Front Page Items', 'com_frontpage', 0, 'js/ThemeOffice/component.png', 1, '');
INSERT INTO `#__components` VALUES (11, 'Polls', 'option=com_poll', 0, 0, 'option=com_poll', 'Manage Polls', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (12, 'News Feeds', 'option=com_newsfeeds', 0, 0, '', 'News Feeds Management', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (13, 'Manage News Feeds', '', 0, 12, 'option=com_newsfeeds', 'Manage News Feeds', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `#__components` VALUES (14, 'Manage Categories', '', 0, 12, 'option=com_categories&section=com_newsfeeds', 'Manage Categories', '', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `#__components` VALUES (15, 'Login', 'option=com_login', 0, 0, '', '', 'com_login', 0, '', 1, '');
INSERT INTO `#__components` VALUES (16, 'Search', 'option=com_search', 0, 0, '', '', 'com_search', 0, '', 1, '');
INSERT INTO `#__components` VALUES (17, 'Syndicate','',0,0,'option=com_syndicate','Manage Syndication Settings','com_syndicate',0,'js/ThemeOffice/component.png',0,'');
INSERT INTO `#__components` VALUES (18, 'Mass Mail', '', 0, 0, 'option=com_massmail', 'Send Mass Mail', 'com_massmail', 0, 'js/ThemeOffice/mass_email.png', 0, '');
INSERT INTO `#__components` VALUES (19, 'Media Manager', '', 0, 0, 'option=com_media', 'Manage Media', 'com_media', 0, '', 1, 'enable_thumbnailer_adm=1\r\njpg_quality_admin=50\r\nimages_filetypes=jpg png gif bmp\r\ndocs_filetypes=pdf doc zip xls ppt sxw\r\nmax_upload_size=2097152\r\nroot_directories=images');
INSERT INTO `#__components` VALUES (20, 'Mambo Update Server', 'option=com_update_server', 0, 0, '', '', 'com_update_server', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (21, 'Products', '', 0, 20, 'option=com_update_server', 'Manage Products', '', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (22, 'Releases', '', 0, 20, 'option=com_update_server&task=listreleases', 'Manage Releases', '', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (23, 'Remote Sites', '', 0, 20, 'option=com_update_server&task=listremotesites', 'Manage Remote Sites', '', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (24, 'Dependencies', '', 0, 20, 'option=com_update_server&task=listdependencies', 'Manage Package Dependencies', '', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (25, 'Mambo Update Client', 'option=com_update_client', 0, 0, '', '', 'com_update_client', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (26, 'View Installed Packages', '', 0, 25, 'option=com_update_client', 'Shows a listing of all components capable of being installed', '', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (27, 'Update Package Lists', '', 0, 25, 'option=com_update_client&task=update', 'Downloads package lists from component websites and remote sites', '', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (28, 'Initialise Manager', '', 0, 0, 'option=com_initialise&task=list', '', 'com_initialise', 0, 'js/ThemeOffice/component.png', 0, '');


# --------------------------------------------------------

#
# Table structure for table `#__contact_details`
#

CREATE TABLE `#__contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `con_position` varchar(50) default NULL,
  `address` text,
  `suburb` varchar(50) default NULL,
  `state` varchar(20) default NULL,
  `country` varchar(50) default NULL,
  `postcode` varchar(10) default NULL,
  `telephone` varchar(25) default NULL,
  `fax` varchar(25) default NULL,
  `misc` mediumtext,
  `image` varchar(100) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(100) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Table structure for table `#__content`
#

CREATE TABLE `#__content` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `title_alias` varchar(255) NOT NULL default '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(11) unsigned NOT NULL default '0',
  `mask` int(11) unsigned NOT NULL default '0',
  `catid` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL default '0',
  `created_by_alias` varchar(100) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL default '1',
  `parentid` int(11) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `active` tinyint(4) NOT NULL default '0',
  `revision` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`,`revision`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_mask` (`mask`)
) TYPE=MyISAM;

#
# Table structure for table `#__content_frontpage`
#

CREATE TABLE `#__content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) TYPE=MyISAM;

#
# Table structure for table `#__content_rating`
#

CREATE TABLE `#__content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) unsigned NOT NULL default '0',
  `rating_count` int(11) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) TYPE=MyISAM;

#
# Table structure for table `#__core_log_items`
#
# To be implemented in Version 4.6

CREATE TABLE `#__core_log_items` (
  `time_stamp` date NOT NULL default '0000-00-00',
  `item_table` varchar(50) NOT NULL default '',
  `item_id` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0'
) TYPE=MyISAM;

#
# Table structure for table `#__core_log_searches`
#
# To be implemented in Version 4.6

CREATE TABLE `#__core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(11) unsigned NOT NULL default '0'
) TYPE=MyISAM;

#
# Table structure for table `#__groups`
#

CREATE TABLE `#__groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__groups`
#

INSERT INTO `#__groups` VALUES (0, 'Public');
INSERT INTO `#__groups` VALUES (1, 'Registered');
INSERT INTO `#__groups` VALUES (2, 'Special');
# --------------------------------------------------------

#
# Table structure for table `#__mambots`
#

CREATE TABLE `#__mambots` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `element` varchar(100) NOT NULL default '',
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) TYPE=MyISAM;

INSERT INTO `#__mambots` VALUES (1,'MOS Image','mosimage','content',0,-10000,1,1,0,0,'0000-00-00 00:00:00','margin=5\r\npadding=5\r\nenable_thumbnailer_frontend=1\r\nprocess_img=1\r\nprocess_img_this_domain=1\r\nprocess_img_other_domains=0\r\nmax_image_width=300\r\nmax_image_height=300\r\ndefault_image_width=150\r\ndefault_image_height=150\r\nenforce_default_size=0\r\njpg_quality_frontend=70\r\noutput_all_as_jpg=0');
INSERT INTO `#__mambots` VALUES (2,'MOS Pagination','mospaging','content',0,10000,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (3,'Legacy Mambot Includer','legacybots','content',0,1,0,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (4,'SEF','mossef','content',0,3,1,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (5,'MOS Rating','mosvote','content',0,4,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (6,'Search Content','content.searchbot','search',0,1,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (7,'Search Weblinks','weblinks.searchbot','search',0,2,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (8,'Code support','moscode','content',0,2,0,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (9,'No WYSIWYG Editor','none','editors',0,0,0,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (10,'TinyMCE WYSIWYG Editor','tinymce','editors',0,0,1,1,0,0,'0000-00-00 00:00:00','theme=advanced');
INSERT INTO `#__mambots` VALUES (11,'MOS Image Editor Button','mosimage.btn','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (12,'MOS Pagebreak Editor Button','mospage.btn','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (13,'Search Contacts','contacts.searchbot','search',0,3,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO `#__mambots` VALUES (14, 'Search Categories', 'categories.searchbot', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (15, 'Search Sections', 'sections.searchbot', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (16, 'Email Cloaking', 'mosemailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (17, 'GeSHi', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (18, 'Search Newsfeeds', 'newsfeeds.searchbot', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (19, 'Load Module Positions', 'mosloadposition', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (20, 'Mambo Userbot', 'mambo.userbot', 'user', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (21, 'LDAP Userbot', 'ldap.userbot', 'user', 0, 2, 0, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (22, 'Visitor Statistics', 'visitors', 'system', 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (23, 'Mambo Update Server', 'mambo_update', 'xmlrpc', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (24, 'Dependency Checker', 'dependency.check', 'system', 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (25, 'Initialiser', 'initialise', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
INSERT INTO `#__mambots` VALUES (26, 'Update Cache Rebuilder', 'update.buildcache', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');
# --------------------------------------------------------

#
# Table structure for table `#__menu`
#

CREATE TABLE `#__menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(25) default NULL,
  `name` varchar(100) default NULL,
  `link` text,
  `type` varchar(50) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `componentid` int(11) unsigned NOT NULL default '0',
  `sublevel` int(11) default '0',
  `ordering` int(11) default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL default '0',
  `browserNav` tinyint(4) default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `utaccess` tinyint(3) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) TYPE=MyISAM;

INSERT INTO `#__menu` VALUES (1, 'mainmenu', 'Home', 'index.php?option=com_frontpage', 'components', 1, 0, 10, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'leading=1\r\nintro=2\r\nlink=1\r\nimage=1\r\npage_title=0\r\nheader=Welcome to the Frontpage\r\norderby_sec=front\r\nprint=0\r\npdf=0\r\nemail=0');
# --------------------------------------------------------

#
# Table structure for table `#__messages`
#

CREATE TABLE `#__messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` int(10) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` int(11) NOT NULL default '0',
  `priority` int(1) unsigned NOT NULL default '0',
  `subject` varchar(230) NOT NULL default '',
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`)
) TYPE=MyISAM;

#
# Table structure for table `#__messages_cfg`
#

CREATE TABLE `#__messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE `idx_user_var_name` (`user_id`,`cfg_name`)
) TYPE=MyISAM;

#
# Table structure for table `#__modules`
#

CREATE TABLE `#__modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(10) default NULL,
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `numnews` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) TYPE=MyISAM;

#
# Dumping data for table `#__modules`
#

INSERT INTO `#__modules` VALUES (1, 'Polls', '', 1, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_poll', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (2, 'User Menu', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 1, 1, 'menutype=usermenu', 1, 0);
INSERT INTO `#__modules` VALUES (3, 'Main Menu', '', 1, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=mainmenu', 1, 0);
INSERT INTO `#__modules` VALUES (4, 'Login Form', '', 3, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (5, 'Syndicate', '', 4, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_rssfeed', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (6, 'Latest News', '', 4, 'user1', 0, '0000-00-00 00:00:00', 1, 'mod_latestnews', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (7, 'Statistics', '', 4, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_stats', 0, 0, 1, 'serverinfo=1\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=', 0, 0);
INSERT INTO `#__modules` VALUES (8, 'Who\'s Online', '', 1, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_whosonline', 0, 0, 1, 'online=1\nusers=1\nmoduleclass_sfx=', 0, 0);
INSERT INTO `#__modules` VALUES (9, 'Popular', '', 6, 'user2', 0, '0000-00-00 00:00:00', 1, 'mod_mostread', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (10, 'Template Chooser','',6,'left',0,'0000-00-00 00:00:00',0,'mod_templatechooser', 0, 0, 1, 'show_preview=1', 0, 0);
INSERT INTO `#__modules` VALUES (11, 'Archive', '', 7, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_archive', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (12, 'Sections', '', 8, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_sections', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (13, 'Newsflash', '', 1, 'top', 0, '0000-00-00 00:00:00', 1, 'mod_newsflash', 0, 0, 1, 'catid=3\r\nstyle=random\r\nitems=\r\nmoduleclass_sfx=', 0, 0);
INSERT INTO `#__modules` VALUES (14, 'Related Items', '', 9, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_related_items', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (15, 'Search', '', 1, 'user4', 0, '0000-00-00 00:00:00', 1, 'mod_search', 0, 0, 0, '', 0, 0);
INSERT INTO `#__modules` VALUES (16, 'Random Image', '', 9, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_random_image', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (17, 'Top Menu', '', 1, 'user3', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=topmenu\nmenu_style=list_flat\nmenu_images=n\nmenu_images_align=left\nexpand_menu=n\nclass_sfx=-nav\nmoduleclass_sfx=\nindent_image1=0\nindent_image2=0\nindent_image3=0\nindent_image4=0\nindent_image5=0\nindent_image6=0', 1, 0);
INSERT INTO `#__modules` VALUES (18, 'Banners', '', 1, 'banner', 0, '0000-00-00 00:00:00', 1, 'mod_banners', 0, 0, 0, 'banner_cids=\nmoduleclass_sfx=\n', 1, 0);
INSERT INTO `#__modules` VALUES (0,'Components','',2,'cpanel',0,'0000-00-00 00:00:00',1,'mod_components',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Popular','',3,'cpanel',0,'0000-00-00 00:00:00',1,'mod_popular',0,99,1,'',0, 1);
INSERT INTO `#__modules` VALUES (0,'Latest Items','',4,'cpanel',0,'0000-00-00 00:00:00',1,'mod_latest',0,99,1,'',0, 1);
INSERT INTO `#__modules` VALUES (0,'Menu Stats','',5,'cpanel',0,'0000-00-00 00:00:00',1,'mod_menustats',0,99,1,'',0, 1);
INSERT INTO `#__modules` VALUES (0,'Unread Messages','',1,'header',0,'0000-00-00 00:00:00',1,'mod_unread',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Online Users','',2,'header',0,'0000-00-00 00:00:00',1,'mod_online',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Full Menu','',1,'top',0,'0000-00-00 00:00:00',1,'mod_fullmenu',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Pathway','',1,'pathway',0,'0000-00-00 00:00:00',0,'mod_pathway',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Toolbar','',1,'toolbar',0,'0000-00-00 00:00:00',1,'mod_toolbar',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'System Message','',1,'inset',0,'0000-00-00 00:00:00',1,'mod_mosmsg',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'Quick Icons','',1,'icon',0,'0000-00-00 00:00:00',1,'mod_quickicon',0,99,1,'',1,1);
INSERT INTO `#__modules` VALUES (0, 'Mamboforge','',1,'cpanel',0,'0000-00-00 00:00:00',0,'',0,99,1,'rssurl=http://mamboforge.net/export/rss_sfnews.php\nrssitems=5\nrssdesc=1\ncache=0\nmoduleclass_sfx=',0,1);
INSERT INTO `#__modules` VALUES (31, 'Other Menu', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=othermenu\nmenu_style=vert_indent\ncache=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nclass_sfx=\nmoduleclass_sfx=\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=', 0, 0);
INSERT INTO `#__modules` VALUES (0,'Wrapper','',10,'left',0,'0000-00-00 00:00:00',1,'mod_wrapper',0,0,1,'',0, 0);
INSERT INTO `#__modules` VALUES (33,'Logged','',0,'cpanel',0,'0000-00-00 00:00:00',1,'mod_logged',0,99,1,'',0,1);
INSERT INTO `#__modules` VALUES (34, 'RSS', '', 4, 'right', 0, '0000-00-00 00:00:00', 0, 'mod_rss', 0, 0, 1, 'moduleclass_sfx=\nrssurl=http://news.mamboserver.com/index2.php?option=com_rss&feed=RSS1.0&no_html=1\nrssdesc=1\nrssimage=1\nrssitems=3\nrssitemdesc=1\nword_count=10\ncache=0', 0, 0);
INSERT INTO `#__modules` VALUES (35, 'Linkbar', '', 0, 'user1', 0, '0000-00-00 00:00:00', 1, 'mod_linkbar', 0, 0, 0, '', 0, 1);        
INSERT INTO `#__modules` VALUES (36, 'Footer', '', 1, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (0, 'Footer', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 1, '', 1, 1);
INSERT INTO `#__modules` VALUES (0, 'Logout Button', '', 3, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_logoutbutton', 0, 0, 1, '', 1, 1);
# --------------------------------------------------------

#
# Table structure for table `#__modules_menu`
#

CREATE TABLE `#__modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) TYPE=MyISAM;

#
# Dumping data for table `#__modules_menu`
#

INSERT INTO `#__modules_menu` VALUES (1,1);
INSERT INTO `#__modules_menu` VALUES (2,0);
INSERT INTO `#__modules_menu` VALUES (3,0);
INSERT INTO `#__modules_menu` VALUES (4,1);
INSERT INTO `#__modules_menu` VALUES (5,1);
INSERT INTO `#__modules_menu` VALUES (6,1);
INSERT INTO `#__modules_menu` VALUES (6,2);
INSERT INTO `#__modules_menu` VALUES (6,4);
INSERT INTO `#__modules_menu` VALUES (6,27);
INSERT INTO `#__modules_menu` VALUES (6,36);
INSERT INTO `#__modules_menu` VALUES (8,1);
INSERT INTO `#__modules_menu` VALUES (9,1);
INSERT INTO `#__modules_menu` VALUES (9,2);
INSERT INTO `#__modules_menu` VALUES (9,4);
INSERT INTO `#__modules_menu` VALUES (9,27);
INSERT INTO `#__modules_menu` VALUES (9,36);
INSERT INTO `#__modules_menu` VALUES (10,1);
INSERT INTO `#__modules_menu` VALUES (13,0);
INSERT INTO `#__modules_menu` VALUES (15,0);
INSERT INTO `#__modules_menu` VALUES (17,0);
INSERT INTO `#__modules_menu` VALUES (18,0);
INSERT INTO `#__modules_menu` VALUES (31, 0);
INSERT INTO `#__modules_menu` VALUES (36, 0);

# --------------------------------------------------------

#
# Table structure for table `#__newsfeeds`
#

CREATE TABLE `#__newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(11) unsigned NOT NULL default '1',
  `cache_time` int(11) unsigned NOT NULL default '3600',
  `checked_out` tinyint(3) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`)
) TYPE=MyISAM;

#
# Table structure for table `#__poll_data`
#

CREATE TABLE `#__poll_data` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(4) NOT NULL default '0',
  `text` text NOT NULL default '',
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) TYPE=MyISAM;

#
# Table structure for table `#__poll_date`
#

CREATE TABLE `#__poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) TYPE=MyISAM;

#
# Table structure for table `#__polls`
#

CREATE TABLE `#__polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `lag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Table structure for table `#__poll_menu`
#

CREATE TABLE `#__poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) TYPE=MyISAM;

#
# Table structure for table `#__sections`
#

CREATE TABLE `#__sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `image` varchar(100) NOT NULL default '',
  `scope` varchar(50) NOT NULL default '',
  `image_position` varchar(10) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_scope` (`scope`)
) TYPE=MyISAM;

#
# Table structure for table `#__session`
#

CREATE TABLE `#__session` (
  `username` varchar(50) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(50) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`)
) TYPE=MyISAM;

#
# Table structure for table `#__stats_agents`
#

CREATE TABLE `#__stats_agents` (
  `agent` varchar(255) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '1'
) TYPE=MyISAM;

#
# Table structure for table `#__templates_menu`
#

CREATE TABLE `#__templates_menu` (
  `template` varchar(50) NOT NULL default '',
  `menuid` int(11) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`template`,`menuid`)
) TYPE=MyISAM;

# Dumping data for table `#__templates_menu`

INSERT INTO `#__templates_menu` VALUES ('rhuk_solarflare_ii', '0', '0');
INSERT INTO `#__templates_menu` VALUES ('mambo_admin_blue', '0', '1');

# --------------------------------------------------------

#
# Table structure for table `#__template_positions`
#

CREATE TABLE `#__template_positions` (
  `id` int(11) NOT NULL auto_increment,
  `position` varchar(10) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__template_positions`
#

INSERT INTO `#__template_positions` VALUES (0, 'left', '');
INSERT INTO `#__template_positions` VALUES (0, 'right', '');
INSERT INTO `#__template_positions` VALUES (0, 'top', '');
INSERT INTO `#__template_positions` VALUES (0, 'bottom', '');
INSERT INTO `#__template_positions` VALUES (0, 'inset', '');
INSERT INTO `#__template_positions` VALUES (0, 'banner', '');
INSERT INTO `#__template_positions` VALUES (0, 'header', '');
INSERT INTO `#__template_positions` VALUES (0, 'footer', '');
INSERT INTO `#__template_positions` VALUES (0, 'newsflash', '');
INSERT INTO `#__template_positions` VALUES (0, 'legals', '');
INSERT INTO `#__template_positions` VALUES (0, 'pathway', '');
INSERT INTO `#__template_positions` VALUES (0, 'toolbar', '');
INSERT INTO `#__template_positions` VALUES (0, 'cpanel', '');
INSERT INTO `#__template_positions` VALUES (0, 'user1', '');
INSERT INTO `#__template_positions` VALUES (0, 'user2', '');
INSERT INTO `#__template_positions` VALUES (0, 'user3', '');
INSERT INTO `#__template_positions` VALUES (0, 'user4', '');
INSERT INTO `#__template_positions` VALUES (0, 'user5', '');
INSERT INTO `#__template_positions` VALUES (0, 'user6', '');
INSERT INTO `#__template_positions` VALUES (0, 'user7', '');
INSERT INTO `#__template_positions` VALUES (0, 'user8', '');
INSERT INTO `#__template_positions` VALUES (0, 'user9', '');
INSERT INTO `#__template_positions` VALUES (0, 'advert1', '');
INSERT INTO `#__template_positions` VALUES (0, 'advert2', '');
INSERT INTO `#__template_positions` VALUES (0, 'advert3', '');
INSERT INTO `#__template_positions` VALUES (0, 'icon', '');
INSERT INTO `#__template_positions` VALUES (0, 'debug', '');
# --------------------------------------------------------

#
# Table structure for table `#__users`
#

CREATE TABLE `#__users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `username` varchar(25) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`)
) TYPE=MyISAM;

#
# Table structure for table `#__usertypes`
#

CREATE TABLE `#__usertypes` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `mask` varchar(11) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__usertypes`
#

INSERT INTO `#__usertypes` VALUES (0, 'superadministrator', '');
INSERT INTO `#__usertypes` VALUES (1, 'administrator', '');
INSERT INTO `#__usertypes` VALUES (2, 'editor', '');
INSERT INTO `#__usertypes` VALUES (3, 'user', '');
INSERT INTO `#__usertypes` VALUES (4, 'author', '');
INSERT INTO `#__usertypes` VALUES (5, 'publisher', '');
INSERT INTO `#__usertypes` VALUES (6, 'manager', '');
# --------------------------------------------------------

#
# Table structure for table `#__weblinks`
#

CREATE TABLE `#__weblinks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) TYPE=MyISAM;


-- --------------------------------------------------------

-- 
-- Table structure for table `#__update_cache`
-- 

CREATE TABLE `#__update_cache` (
  `cacheid` int(10) unsigned NOT NULL auto_increment,
  `productname` varchar(50) default NULL,
  `productid` int(11) NOT NULL default '0',
  `type` varchar(20) NOT NULL default '',
  `directory` varchar(50) default NULL,
  `versionstring` varchar(20) default NULL,
  `updateurl` text,
  `lastupdate` date default NULL,
  `updated` int(11) NOT NULL default '0',
  `updatedversion` varchar(20) NOT NULL default '',
  `releaseid` int(11) NOT NULL default '0',
  `releaseinfourl` text NOT NULL,
  `downloadurl` text NOT NULL,
  `remoteapp` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cacheid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `#__versions`
-- Duplicate of #__update_cache but designed to be there all the time
-- 

CREATE TABLE `#__versions` (
  `cacheid` int(10) unsigned NOT NULL auto_increment,
  `productname` varchar(50) default NULL,
  `productid` int(11) NOT NULL default '0',
  `type` varchar(20) NOT NULL default '',
  `directory` varchar(50) default NULL,
  `versionstring` varchar(20) default NULL,
  `updateurl` text,
  `lastupdate` date default NULL,
  `updated` int(11) NOT NULL default '0',
  `updatedversion` varchar(20) NOT NULL default '',
  `releaseid` int(11) NOT NULL default '0',
  `releaseinfourl` text NOT NULL,
  `downloadurl` text NOT NULL,
  `remoteapp` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cacheid`)
) TYPE=MyISAM;


-- --------------------------------------------------------

-- 
-- Table structure for table `#__update_dependencies`
-- 

CREATE TABLE `#__update_dependencies` (
  `dependencyid` int(10) unsigned NOT NULL auto_increment,
  `currentrelease` int(10) unsigned default NULL,
  `depprodname` varchar(50) default NULL,
  `depversionstring` varchar(20) default NULL,
  `depremotesite` int(10) unsigned default NULL,
  `upgradeonly` int(10) NOT NULL default '0',
  PRIMARY KEY  (`dependencyid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `#__update_product`
-- 

CREATE TABLE `#__update_product` (
  `productid` int(10) unsigned NOT NULL auto_increment,
  `productname` varchar(50) default NULL,
  `producttype` varchar(20) NOT NULL default '',
  `productdescription` text,
  `producturl` text,
  `productdetailsurl` text,
  `published` int(11) NOT NULL default '0',
  PRIMARY KEY  (`productid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `#__update_releases`
-- 

CREATE TABLE `#__update_releases` (
  `releaseid` int(10) unsigned NOT NULL auto_increment,
  `productid` int(11) default NULL,
  `releasetitle` varchar(30) default NULL,
  `releasedescription` text,
  `releasesurl` text,
  `releasechangelog` text,
  `releasenotes` text,
  `versionstring` varchar(20) default NULL,
  `updateurl` text,
  `releaseurl` text,
  `releasedate` date default NULL,
  `published` int(11) NOT NULL default '0',
  PRIMARY KEY  (`releaseid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `#__update_remotesite`
-- 

CREATE TABLE `#__update_remotesite` (
  `remotesiteid` int(10) unsigned NOT NULL auto_increment,
  `remotesitename` varchar(30) default NULL,
  `remotesiteurl` text,
  PRIMARY KEY  (`remotesiteid`)
) TYPE=MyISAM;
