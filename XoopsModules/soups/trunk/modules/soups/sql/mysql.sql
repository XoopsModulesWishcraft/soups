CREATE TABLE `soups` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `chain_id` int(12) unsigned NOT NULL DEFAULT '0',
  `uid` int(12) unsigned DEFAULT '0',
  `created` int(13) unsigned DEFAULT '0',
  `updated` int(13) unsigned DEFAULT '0',
  `chem_tags` varchar(255) DEFAULT NULL,
  `comments` int(10) unsigned DEFAULT '0',
  `votes` int(6) unsigned DEFAULT '0',
  `stars` float(10,5) unsigned DEFAULT '0.00000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `soups_chain_compounds` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `chain_id` int(12) unsigned DEFAULT '0',
  `compound_id` int(15) unsigned DEFAULT '0',
  `uid` int(12) unsigned DEFAULT '0',
  `weight` int(5) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `soups_chain_link` (
  `chain_id` int(13) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(12) unsigned DEFAULT '0',
  `compounds` int(5) unsigned DEFAULT '0',
  PRIMARY KEY (`chain_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `soups_language` (
  `id` int(36) unsigned NOT NULL AUTO_INCREMENT,
  `language` varchar(255) DEFAULT NULL,
  `soup_id` int(16) unsigned NOT NULL DEFAULT '0',
  `chain_id` int(16) unsigned NOT NULL DEFAULT '0',
  `compound_id` int(16) unsigned NOT NULL DEFAULT '0',
  `chain_compound_id` int(16) unsigned NOT NULL DEFAULT '0',
  `symbol` varchar(4) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `hyposise` mediumtext,
  `process` mediumtext,
  `synopsise` mediumtext,
  `uid` int(12) unsigned DEFAULT '0',
  `created` int(13) unsigned DEFAULT '0',
  `updated` int(13) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `soups_uid_link` (
  `uid` int(12) unsigned NOT NULL DEFAULT '0',
  `votes` int(6) unsigned DEFAULT '0',
  `stars` float(10,5) unsigned DEFAULT NULL,
  `hits` int(6) unsigned DEFAULT '0',
  `runners` int(6) unsigned DEFAULT '0',
  `soups` int(6) unsigned DEFAULT '0',
  `comments` int(6) unsigned DEFAULT '0',
  `edits` int(6) unsigned DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `soups_votedata` (        
        `id` INT(13) DEFAULT '0',           
        `ip` TINYTEXT,     
        `addy` VARCHAR(255) DEFAULT NULL,   
        `created` INT(13) DEFAULT '0'       
) ENGINE=InnoDB DEFAULT CHARSET=utf8;