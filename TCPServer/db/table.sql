CREATE TABLE `t_account` (
  `_id` bigint(13) NOT NULL,
  `nShopID` bigint(13) default NULL,
  `nAccountID` bigint(13) default NULL,
  `nAccountType` bigint(13) default NULL,
  `sAccountName` varchar(512) default NULL,
  `fAccountValue` double default NULL,
  `nDateTime` bigint(13) default NULL,
  `nUserID` bigint(13) default NULL,
  `sText` varchar(512) default NULL,
  `nUpdateFlag` bigint(13) default NULL,
  PRIMARY KEY  (`_id`),
  KEY `nShopID` (`nShopID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `t_accountdoc` (
  `_id` bigint(13) NOT NULL,
  `nShopID` bigint(13) default NULL,
  `nAccountID` bigint(13) default NULL,
  `sAccountName` varchar(512) default NULL,
  `nAccountTransacType` bigint(13) default NULL,
  `nMoneyDirection` bigint(13) default NULL,
  `fAccountAmount` double default NULL,
  `sText` varchar(512) default NULL,
  `nUserID` bigint(13) default NULL,
  `nDateTime` bigint(13) default NULL,
  `nDeletionFlag` bigint(13) default NULL,
  `nProductdocID` bigint(13) default NULL,
  `nUpdateFlag` bigint(13) default NULL,
  PRIMARY KEY  (`_id`),
  KEY `nShopID` (`nShopID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
