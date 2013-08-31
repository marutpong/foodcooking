CREATE TABLE `files` (
  `FilesID` int(4) NOT NULL auto_increment,
  `Name` varchar(100) NOT NULL,
  `FilesName` varchar(100) NOT NULL,
  PRIMARY KEY  (`FilesID`)
) ENGINE=MyISAM  AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `files`
-- 

INSERT INTO `files` VALUES (1, 'win', 'win.jpg');
INSERT INTO `files` VALUES (2, 'plakrim', 'plakrim.jpg');