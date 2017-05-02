CREATE TABLE `tb_personsdata` (
  `idperson` int(11) NOT NULL,
  `desperson` varchar(128) NOT NULL,
  `desname` varchar(32) NOT NULL,
  `desfirstname` varchar(64) NOT NULL,
  `deslastname` varchar(64) NOT NULL,
  `idpersontype` int(11) NOT NULL,
  `despersontype` varchar(64) NOT NULL,
  `desuser` varchar(128) DEFAULT NULL,
  `despassword` varchar(256) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `inblocked` bit(1) DEFAULT NULL,
  `desemail` varchar(128) DEFAULT NULL,
  `idemail` int(11) DEFAULT NULL,
  `desphone` varchar(32) DEFAULT NULL,
  `idphone` int(11) DEFAULT NULL,
  `descpf` char(11) DEFAULT NULL,
  `idcpf` int(11) DEFAULT NULL,
  `descnpj` char(14) DEFAULT NULL,
  `idcnpj` int(11) DEFAULT NULL,
  `desrg` varchar(16) DEFAULT NULL,
  `idrg` int(11) DEFAULT NULL,
  `dtupdate` datetime NOT NULL,
  `dessex` enum('M','F') DEFAULT NULL,
  `dtbirth` date DEFAULT NULL,
  `desphoto` varchar(128) DEFAULT NULL,
  `inclient` bit(1) NOT NULL DEFAULT b'0',
  `inprovider` bit(1) NOT NULL DEFAULT b'0',
  `incollaborator` bit(1) NOT NULL DEFAULT b'0',
  `idaddress` int(11) DEFAULT NULL,
  `idaddresstype` int(11) DEFAULT NULL,
  `desaddresstype` varchar(64) DEFAULT NULL,
  `desaddress` varchar(64) DEFAULT NULL,
  `desnumber` varchar(16) DEFAULT NULL,
  `desdistrict` varchar(64) DEFAULT NULL,
  `descity` varchar(64) DEFAULT NULL,
  `desstate` varchar(32) DEFAULT NULL,
  `descountry` varchar(32) DEFAULT NULL,
  `descep` char(8) DEFAULT NULL,
  `descomplement` varchar(32) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idperson`),
  KEY `FK_personsdata_personstypes_idx` (`idpersontype`),
  KEY `FK_personsdata_users_idx` (`iduser`),
  CONSTRAINT `FK_personsdata_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_personsdata_personstypes` FOREIGN KEY (`idpersontype`) REFERENCES `tb_personstypes` (`idpersontype`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_personsdata_users` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8