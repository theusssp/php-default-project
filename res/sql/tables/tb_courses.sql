CREATE TABLE `tb_courses` (
  `idcourse` int(11) NOT NULL AUTO_INCREMENT,
  `descourse` varchar(64) NOT NULL,
  `destitle` varchar(256) DEFAULT NULL,
  `vlworkload` time NOT NULL DEFAULT '00:00:00',
  `nrlessons` int(11) NOT NULL DEFAULT '0',
  `nrexercises` int(11) NOT NULL DEFAULT '0',
<<<<<<< HEAD
  `idbanner` int(11) NOT NULL DEFAULT '0',
  `idbrasao` int(11) NOT NULL DEFAULT '0',
  `desdescription` text DEFAULT NULL,
  `desshortdescription` varchar(512) DEFAULT NULL,
  `deswhatlearn` text DEFAULT NULL,
  `desrequirements` text DEFAULT NULL,
  `destargetaudience` text DEFAULT NULL,
  `inremoved` tinyint(1) NOT NULL DEFAULT '0',
  `desurludemy` varchar(128) DEFAULT NULL,
  `nralunosudemy` int(11) NOT NULL DEFAULT '0',
  `nrreviewsudemy` int(11) DEFAULT NULL,
  `vlreviewsudemy` decimal(10,2) DEFAULT NULL,
  `idcourseudemy` int(11) DEFAULT NULL,
=======
  `desdescription` varchar(10240) DEFAULT NULL,
  `inremoved` tinyint(1) NOT NULL DEFAULT 0,
>>>>>>> b50bb097b1c67643f67cbe83f6f931a3b898a1bf
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcourse`),
  CONSTRAINT `FK_courses_files_banner` FOREIGN KEY(`idbanner`) REFERENCES tb_files(idfile),
  CONSTRAINT `FK_courses_files_brasao` FOREIGN KEY(`idbrasao`) REFERENCES tb_files(idfile)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
