<?php
define("PATH_PROC", PATH."/res/sql/procedures/");
define("PATH_TRIGGER", PATH."/res/sql/triggers/");

$app->get("/install", function(){

	unsetLocalCookie(COOKIE_KEY);

	if (isset($_SESSION)) unset($_SESSION);
	session_destroy();
	$page = new Page(array(
		'header'=>false,
		'footer'=>false
	));
	$page->setTpl("install/index");
});

$app->get("/install-admin/sql/clear", function(){
	$sql = new Sql();
	$procs = $sql->arrays("SHOW PROCEDURE STATUS WHERE Db = '".DB_NAME."';");
	foreach ($procs as $row) {
		$sql->query("DROP PROCEDURE IF EXISTS ".$row['Name'].";");
	}
	$sql->query("DROP TABLE IF EXISTS tb_contatos;");
	$sql->query("DROP TABLE IF EXISTS tb_contatostipos;");
	$sql->query("DROP TABLE IF EXISTS tb_contatossubtipos;");
	$sql->query("DROP TABLE IF EXISTS tb_documentos;");
	$sql->query("DROP TABLE IF EXISTS tb_documentostipos;");
	$sql->query("DROP TABLE IF EXISTS tb_enderecos;");
	$sql->query("DROP TABLE IF EXISTS tb_enderecostipos;");	
	$sql->query("DROP TABLE IF EXISTS tb_permissoesmenus;");
	$sql->query("DROP TABLE IF EXISTS tb_permissoesusuarios;");
	$sql->query("DROP TABLE IF EXISTS tb_permissoes;");
	$sql->query("DROP TABLE IF EXISTS tb_menus;");
	$sql->query("DROP TABLE IF EXISTS tb_pessoasdados;");
	$sql->query("DROP TABLE IF EXISTS tb_usuarios;");
	$sql->query("DROP TABLE IF EXISTS tb_usuariostipos;");
	$sql->query("DROP TABLE IF EXISTS tb_pessoas;");
	$sql->query("DROP TABLE IF EXISTS tb_pessoastipos;");
	$sql->query("DROP TABLE IF EXISTS tb_produtos;");
	$sql->query("DROP TABLE IF EXISTS tb_produtostipos;");
	$sql->query("DROP TABLE IF EXISTS tb_produtosprecos;");
	$sql->query("DROP TABLE IF EXISTS tb_carrinhos;");
	$sql->query("DROP TABLE IF EXISTS tb_carrinhosprodutos;");
	$sql->query("DROP TABLE IF EXISTS tb_cartoesdecreditos;");
	$sql->query("DROP TABLE IF EXISTS tb_gateways;");
	$sql->query("DROP TABLE IF EXISTS tb_formaspagamentos;");
	$sql->query("DROP TABLE IF EXISTS tb_pagamentosstatus;");
	$sql->query("DROP TABLE IF EXISTS tb_pagamentos;");
	$sql->query("DROP TABLE IF EXISTS tb_pagamentosprodutos;");
	$sql->query("DROP TABLE IF EXISTS tb_pagamentosrecibos;");
	$sql->query("DROP TABLE IF EXISTS tb_sitecontatos;");

	echo success();
});
$app->get("/install-admin/sql/pessoas/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_pessoastipos (
		  idpessoatipo int(11) NOT NULL AUTO_INCREMENT,
		  despessoatipo varchar(64) NOT NULL,
		  PRIMARY KEY (idpessoatipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_pessoas (
		  idpessoa int(11) NOT NULL AUTO_INCREMENT,
		  idpessoatipo int(1) NOT NULL,
		  despessoa varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (idpessoa),
		  KEY FK_pessoastipos (idpessoatipo),
		  CONSTRAINT FK_pessoas_pessoastipos FOREIGN KEY (idpessoatipo) REFERENCES tb_pessoastipos (idpessoatipo) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/pessoas/triggers", function(){
	$sql = new Sql();
	$name = "tg_pessoas_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_pessoas_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_pessoas_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/pessoas/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_pessoastipos (despessoatipo) VALUES
		(?),
		(?);
	", array(
		'Física',
		'Jurídica'
	));
	$sql->query("
		INSERT INTO tb_pessoas (despessoa, idpessoatipo) VALUES
		(?, ?);
	", array(
		'Super Usuário (root)', 1
	));
	echo success();
});
$app->get("/install-admin/sql/pessoas/get", function(){
	$sql = new Sql();
	$name = "sp_pessoas_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_pessoasdados_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_pessoasdados_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");	
	echo success();
});
$app->get("/install-admin/sql/pessoas/list", function(){
	$sql = new Sql();
	$name = "sp_pessoas_list";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
});
$app->get("/install-admin/sql/pessoas/save", function(){
	$sql = new Sql();
	$name = "sp_pessoas_save";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
});
$app->get("/install-admin/sql/pessoas/remove", function(){
	$sql = new Sql();
	$name = "sp_pessoas_remove";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
});

$app->get("/install-admin/sql/produtos/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_produtostipos(
			idprodutotipo INT NOT NULL AUTO_INCREMENT,
			desprodutotipo VARCHAR(64) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idprodutotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_produtos(
			idproduto INT NOT NULL AUTO_INCREMENT,
			idprodutotipo INT NOT NULL,
			desproduto VARCHAR(64) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY(idproduto),
			CONSTRAINT FOREIGN KEY(idprodutotipo) REFERENCES tb_produtostipos(idprodutotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_produtosprecos(
			idpreco INT NOT NULL AUTO_INCREMENT,
			idproduto INT NOT NULL,
			dtinicio DATETIME NOT NULL,
			dttermino DATETIME NOT NULL,
			vlpreco DECIMAL(10,2) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idpreco),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/produtos/triggers", function(){
	$sql = new Sql();
	$name = "tg_produtos_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_produtos_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_produtos_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");

	$name = "tg_produtosprecos_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_produtosprecos_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_produtosprecos_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/produtos/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_produtostipos (desprodutotipo) VALUES
		(?),
		(?);
	", array(
		'Eletrônicos',
		'Informática'
	));
	$sql->query("
		INSERT INTO tb_produtos (desproduto, idprodutotipo) VALUES
		(?, ?);
	", array(
		'Computador', 2
	));
	$sql->query("
		INSERT INTO tb_produtosprecos(idproduto, dtinicio, dttermino, vlpreco) VALUES
		(?, ?, ?, ?);
	", array(
		1, '2016-12-12', '2018-12-12', 50
	));
	echo success();
});
$app->get("/install-admin/sql/produtos/get", function(){
	$sql = new Sql();
	$name = "sp_produto_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_produtotipo_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_produtosdados_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_produtosdados_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_produtosprecos_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");	
	echo success();
});
$app->get("/install-admin/sql/produtos/list", function(){
	$sql = new Sql();
	$name = "sp_produtos_list";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_produtostipos_list";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_produtosprecos_list";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
});
$app->get("/install-admin/sql/produtos/save", function(){
	$sql = new Sql();
	$name = "sp_produto_save";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_produtotipo_save";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_produtosprecos_save";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
});
$app->get("/install-admin/sql/produtos/remove", function(){
	$sql = new Sql();
	$name = "sp_produto_remove";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_produtotipo_remove";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_produtosprecos_remove";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
});

$app->get("/install-admin/sql/usuarios/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_usuariostipos (
		  idusuariotipo int(11) NOT NULL AUTO_INCREMENT,
		  desusuariotipo varchar(32) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idusuariotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_usuarios (
		  idusuario int(11) NOT NULL AUTO_INCREMENT,
		  idpessoa int(11) NOT NULL,
		  desusuario varchar(128) NOT NULL,
		  dessenha varchar(256) NOT NULL,
		  inbloqueado bit(1) NOT NULL DEFAULT b'0',
		  idusuariotipo int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idusuario),
		  CONSTRAINT FK_usuarios_pessoas FOREIGN KEY (idpessoa) REFERENCES tb_pessoas (idpessoa) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_usuarios_usuariostipos FOREIGN KEY (idusuariotipo) REFERENCES tb_usuariostipos (idusuariotipo) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();
});
$app->get("/install-admin/sql/usuarios/triggers", function(){
	$sql = new Sql();
	$name = "tg_usuarios_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_usuarios_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_usuarios_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/usuarios/inserts", function(){
	$sql = new Sql();
	$hash = Usuario::getPasswordHash("root");

	$sql->proc("sp_usuariostipos_save", array(
		0,
		'Administrativo'
	));
	$sql->proc("sp_usuariostipos_save", array(
		0,
		'Cliente'
	));
	
	$sql->query("
		INSERT INTO tb_usuarios (idpessoa, desusuario, dessenha, idusuariotipo) VALUES
		(?, ?, ?, ?);
	", array(
		1, 'root', $hash, 1
	));

	echo success();
});
$app->get("/install-admin/sql/usuarios/get", function(){
	$sql = new Sql();
	$name = "sp_usuarios_get";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_usuarioslogin_get";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_usuariosfromemail_get";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_usuariosfrommenus_list";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_usuariostipos_get";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/usuarios/remove", function(){
	$sql = new Sql();
	$name = "sp_usuarios_remove";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_usuariostipos_remove";	
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/usuarios/save", function(){
	$sql = new Sql();
	$name = "sp_usuarios_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_usuariostipos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/usuarios/list", function(){
	$sql = new Sql();
	$name = "sp_usuariostipos_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/menus/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_menus (
		  idmenu int(11) NOT NULL AUTO_INCREMENT,
		  idmenupai int(11) DEFAULT NULL,
		  desmenu varchar(128) NOT NULL,
		  desicone varchar(64) NOT NULL,
		  deshref varchar(64) NOT NULL,
		  nrordem int(11) NOT NULL,
		  nrsubmenus int(11) DEFAULT '0' NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (idmenu),
		  CONSTRAINT FK_menus_menus FOREIGN KEY (idmenupai) REFERENCES tb_menus (idmenu) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_menususuarios (
		  idmenu int(11) NOT NULL,
		  idusuario int(11) NOT NULL,
		  CONSTRAINT FOREIGN KEY FK_usuariosmenuspessoas (idusuario) REFERENCES tb_usuarios(idusuario),
		  CONSTRAINT FOREIGN KEY FK_usuariosmenusmenus (idmenu) REFERENCES tb_menus(idmenu)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();
});
$app->get("/install-admin/sql/menus/inserts", function(){
	$sql = new Sql();
	$sql->proc("sp_menus_save", array(
		NULL,
		0,
		'md-view-dashboard', 
		'/', 
		0, 
		'Dashboard'
	));
	$sql->proc("sp_menus_save", array(
		NULL,
		0,
		'md-settings', 
		'', 
		0, 
		'Sistema'
	));
	$sql->proc("sp_menus_save", array(
		NULL,
		0,
		'md-accounts', 
		'/pessoas', 
		0, 
		'Pessoas'
	));
	$sql->proc("sp_menus_save", array(
		2,
		0,
		'', 
		'/sistema/menu', 
		0, 
		'Menu'
	));
	$sql->proc("sp_menus_save", array(
		2,
		0,
		'', 
		'/sistema/usuarios', 
		0, 
		'Usuários'
	));
	$sql->proc("sp_menus_save", array(
		2,
		0,
		'', 
		'/sistema/sql-to-class', 
		1, 
		'SQL to CLASS'
	));
	$sql->proc("sp_menus_save", array(
		2,
		0,
		'', 
		'/../res/theme/material/base/html/index.html', 
		2, 
		'Template'
	));
	
	echo success();
});
$app->get("/install-admin/sql/menus/get", function(){
	$sql = new Sql();
	$name = "sp_menus_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/menus/list", function(){
	$sql = new Sql();
	$name = "sp_menus_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/menus/remove", function(){
	$sql = new Sql();
	$name = "sp_menus_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/menus/save", function(){
	$sql = new Sql();
	$name = "sp_menusfromusuario_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_menustrigger_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_menus_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/contatos/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_contatossubtipos (
		  idcontatosubtipo int(11) NOT NULL AUTO_INCREMENT,
		  descontatosubtipo varchar(32) NOT NULL,
		  descontatotipo varchar(32) NOT NULL,
		  idusuario int(11) DEFAULT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcontatosubtipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_contatostipos (
		  idcontatotipo int(11) NOT NULL AUTO_INCREMENT,
		  descontatotipo varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcontatotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_contatos (
		  idcontato int(11) NOT NULL AUTO_INCREMENT,
		  idcontatotipo int(11) NOT NULL,
		  idcontatosubtipo int(11) NOT NULL,
		  idpessoa int(11) NOT NULL,
		  descontato varchar(128) NOT NULL,
		  inprincipal bit(1) NOT NULL DEFAULT b'0',
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (idcontato),
		  CONSTRAINT FOREIGN KEY FK_contatostipos (idcontatotipo) REFERENCES tb_contatostipos(idcontatotipo),
		  CONSTRAINT FOREIGN KEY FK_contatossubtipos (idcontatosubtipo) REFERENCES tb_contatossubtipos(idcontatosubtipo),
		  CONSTRAINT FOREIGN KEY FK_pessoascontatos (idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/contatos/triggers", function(){
	$sql = new Sql();
	$name = "tg_contatos_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_contatos_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_contatos_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/contatos/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_contatostipos (descontatotipo) VALUES
		(?),
		(?);
	", array(
		'E-mail',
		'Telefone'
	));

	$sql->query("
		INSERT INTO tb_contatossubtipos (idcontatotipo, descontatosubtipo) VALUES
		(?, ?),
		(?, ?),
		(?, ?),
		(?, ?),
		(?, ?),
		(?, ?),
		(?, ?),
		(?, ?);
	", array(
		2, 'Casa',		
		2, 'Trabalho',		
		2, 'Celular',		
		2, 'Fax',		
		2, 'Outro',		
		1, 'Pessoal',		
		1, 'Trabalho',		
		1, 'Outro'		
	));

	echo success();
});
$app->get("/install-admin/sql/contatos/get", function(){
	$sql = new Sql();

	$procs = array(
		"sp_contatos_get",
		"sp_contatossubtipos_get"
	);

	foreach ($procs as $name){
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}

	echo success();
});
$app->get("/install-admin/sql/contatos/list", function(){
	$sql = new Sql();
	$name = "sp_contatosfrompessoa_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_contatostipos_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/contatos/save", function(){
	$sql = new Sql();
	$name = "sp_contatos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_contatossubtipos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	echo success();
});
$app->get("/install-admin/sql/contatos/remove", function(){
	$sql = new Sql();
	$name = "sp_contatos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_contatossubtipos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");	

	echo success();
});
$app->get("/install-admin/sql/documentos/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_documentostipos (
		  iddocumentotipo int(11) NOT NULL AUTO_INCREMENT,
		  desdocumentotipo varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (iddocumentotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_documentos (
		  iddocumento int(11) NOT NULL AUTO_INCREMENT,
		  iddocumentotipo int(11) NOT NULL,
		  idpessoa int(11) NOT NULL,
		  desdocumento varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (iddocumento),
		  CONSTRAINT FK_pessoasdocumentos FOREIGN KEY (idpessoa) REFERENCES tb_pessoas(idpessoa),
		  CONSTRAINT FK_documentos FOREIGN KEY (iddocumentotipo) REFERENCES tb_documentostipos(iddocumentotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/documentos/triggers", function(){
	$sql = new Sql();
	$name = "tg_documentos_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_documentos_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_documentos_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/documentos/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_documentostipos (desdocumentotipo) VALUES
		(?),
		(?),
		(?);
	", array(
		'CPF',
		'CNPJ',
		'RG'
	));
	echo success();
});
$app->get("/install-admin/sql/documentos/get", function(){
	$sql = new Sql();
	$name = "sp_documentos_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/documentos/list", function(){
	$sql = new Sql();
	$name = "sp_documentosfrompessoa_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_documentostipos_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/documentos/save", function(){
	$sql = new Sql();
	$name = "sp_documentos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/documentos/remove", function(){
	$sql = new Sql();
	$name = "sp_documentos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/enderecos/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_enderecostipos (
		  idenderecotipo int(11) NOT NULL AUTO_INCREMENT,
		  desenderecotipo varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (idenderecotipo)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_enderecos (
		  idendereco int(11) NOT NULL AUTO_INCREMENT,
		  idenderecotipo int(11) NOT NULL,
		  idpessoa int(11) NOT NULL,
		  desendereco varchar(64) NOT NULL,
		  desnumero varchar(16) NOT NULL,
		  desbairro varchar(64) NOT NULL,
		  descidade varchar(64) NOT NULL,
		  desestado varchar(32) NOT NULL,
		  despais varchar(32) NOT NULL,
		  descep char(8) NOT NULL,
		  descomplemento varchar(32) DEFAULT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (idendereco),
		   CONSTRAINT FK_enderecostipos FOREIGN KEY (idenderecotipo) REFERENCES tb_enderecostipos(idenderecotipo),
		  CONSTRAINT FK_pessoasenderecos FOREIGN KEY (idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/enderecos/triggers", function(){
	$sql = new Sql();
	$name = "tg_enderecos_AFTER_INSERT";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_enderecos_AFTER_UPDATE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	$name = "tg_enderecos_BEFORE_DELETE";
	$sql->query("DROP TRIGGER IF EXISTS {$name};");
	$sql->queryFromFile(PATH_TRIGGER."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/enderecos/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_enderecostipos (desenderecotipo) VALUES
		(?),
		(?),
		(?),
		(?);
	", array(
		'Residencial',
		'Comercial',
		'Cobrança',
		'Entrega'
	));
	echo success();
});
$app->get("/install-admin/sql/enderecos/get", function(){
	$sql = new Sql();
	$name = "sp_enderecos_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/enderecos/list", function(){
	$sql = new Sql();
	$name = "sp_enderecosfrompessoa_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/enderecos/save", function(){
	$sql = new Sql();
	$name = "sp_enderecos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/enderecos/remove", function(){
	$sql = new Sql();
	$name = "sp_enderecos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	echo success();
});
$app->get("/install-admin/sql/permissoes/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_permissoes (
		  idpermissao int(11) NOT NULL AUTO_INCREMENT,
		  despermissao varchar(64) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idpermissao)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_permissoesmenus (
		  idpermissao int(11) NOT NULL,
		  idmenu int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT FK_menuspermissoes FOREIGN KEY (idmenu) REFERENCES tb_menus (idmenu),
		  CONSTRAINT FK_permissoesmenus FOREIGN KEY (idpermissao) REFERENCES tb_permissoes (idpermissao)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	$sql->query("
		CREATE TABLE tb_permissoesusuarios (
		  idpermissao int(11) NOT NULL,
		  idusuario int(11) NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  CONSTRAINT FK_permissoesusuarios FOREIGN KEY (idpermissao) REFERENCES tb_permissoes (idpermissao),
		  CONSTRAINT FK_usuariospermissoes FOREIGN KEY (idusuario) REFERENCES tb_usuarios (idusuario)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});
$app->get("/install-admin/sql/permissoes/inserts", function(){
	$sql = new Sql();
	$sql->query("
		INSERT INTO tb_permissoes (despermissao) VALUES
		(?),
		(?),
		(?);
	", array(
		'Super Usuário',
		'Acesso Administrativo',
		'Acesso Autenticado de Cliente'
	));
	$sql->query("
		INSERT INTO tb_permissoesmenus (idmenu, idpermissao)
		SELECT idmenu, 1 FROM tb_menus;
	", array());

	$sql->query("
		INSERT INTO tb_permissoesusuarios (idusuario, idpermissao) VALUES
		(?, ?),
		(?, ?);
	", array(
		1, 1,
		1, 2
	));
	echo success();
});
$app->get("/install-admin/sql/permissoes/get", function(){
	$sql = new Sql();

	$procs = array(
		'sp_permissoes_get',
		'sp_permissoesfrommenus_list',
		'sp_permissoesfrommenusfaltantes_list',
		'sp_permissoes_list'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	

	echo success();
});
$app->get("/install-admin/sql/permissoes/list", function(){
	echo success();
});
$app->get("/install-admin/sql/permissoes/save", function(){
	$sql = new Sql();
	$name = "sp_permissoes_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_permissoesmenus_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
});
$app->get("/install-admin/sql/permissoes/remove", function(){
	$sql = new Sql();
	$name = "sp_permissoes_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	$name = "sp_permissoesmenus_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");	
	
	echo success();
});
$app->get("/install-admin/sql/pessoasdados/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_pessoasdados (
		  idpessoa int(11) NOT NULL,
		  despessoa varchar(128) NOT NULL,
		  desnome varchar(32) NOT NULL,
		  desprimeironome varchar(64) NOT NULL,
		  desultimonome varchar(64) NOT NULL,
		  idpessoatipo int(11) NOT NULL,
		  despessoatipo varchar(64) NOT NULL,
		  desusuario varchar(128) DEFAULT NULL,
		  dessenha varchar(256) DEFAULT NULL,
		  idusuario int(11) DEFAULT NULL,
		  inbloqueado bit(1) DEFAULT NULL,
		  desemail varchar(128) DEFAULT NULL,
		  idemail int(11) DEFAULT NULL,
		  destelefone varchar(32) DEFAULT NULL,
		  idtelefone int(11) DEFAULT NULL,
		  descpf char(11) DEFAULT NULL,
		  idcpf int(11) DEFAULT NULL,
		  descnpj char(14) DEFAULT NULL,
		  idcnpj int(11) DEFAULT NULL,
		  desrg varchar(16) DEFAULT NULL,
		  idrg int(11) DEFAULT NULL,
		  dtatualizacao datetime NOT NULL,
		  dtcadastro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (idpessoa),
		  KEY FK_pessoasdados_pessoastipos_idx (idpessoatipo),
		  KEY FK_pessoasdados_usuarios_idx (idusuario),
		  CONSTRAINT FK_pessoasdados_pessoas FOREIGN KEY (idpessoa) REFERENCES tb_pessoas (idpessoa) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_pessoasdados_pessoastipos FOREIGN KEY (idpessoatipo) REFERENCES tb_pessoastipos (idpessoatipo) ON DELETE NO ACTION ON UPDATE NO ACTION,
		  CONSTRAINT FK_pessoasdados_usuarios FOREIGN KEY (idusuario) REFERENCES tb_usuarios (idusuario) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});

$app->get("/install-admin/sql/produtosdados/tables", function(){
	$sql = new Sql();
	$sql->query("
		CREATE TABLE tb_produtosdados(
			idproduto INT NOT NULL,
			idprodutotipo INT NOT NULL,
			desproduto VARCHAR(64) NOT NULL,
			vlpreco DEC(10,2),
			desprodutotipo VARCHAR(64) NOT NULL,
			dtinicio DATE,
			dttermino DATE,
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto),
			CONSTRAINT FOREIGN KEY(idprodutotipo) REFERENCES tb_produtostipos(idprodutotipo)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	echo success();
});

$app->get("/install-admin/sql/carrinhos/tables", function(){

	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_carrinhos(
			idcarrinho INT NOT NULL AUTO_INCREMENT,
			idpessoa INT NOT NULL,
			dessession VARCHAR(128) NOT NULL,
			infechado BIT(1),
			nrprodutos INT NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			vltotalbruto DECIMAL(10,2),
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcarrinho),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_carrinhosprodutos(
			idcarrinho INT NOT NULL,
			idproduto INT NOT NULL,
			inremovido BIT(1) NOT NULL,
			dtremovido DATETIME NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idcarrinho) REFERENCES tb_carrinhos(idcarrinho),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	echo success();

});

$app->get("/install-admin/sql/carrinhos/list", function(){
	
	$sql = new Sql();

	$name = "sp_carrinhos_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_carrinhosprodutos_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/carrinhos/get", function(){
	
	$sql = new Sql();

	$name = "sp_carrinhos_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_carrinhosprodutos_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();

});

$app->get("/install-admin/sql/carrinhos/save", function(){
	
	$sql = new Sql();

	$name = "sp_carrinhos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_carrinhosprodutos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/carrinhos/remove", function(){
	
	$sql = new Sql();

	$name = "sp_carrinhos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");

	$name = "sp_carrinhosprodutos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/cartoesdecreditos/tables", function(){
	
	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_cartoesdecreditos(
			idcartao INT NOT NULL AUTO_INCREMENT,
			idpessoa INT NOT NULL,
			desnome VARCHAR(64) NOT NULL,
			dtvalidade DATE NOT NULL,
			nrcds VARCHAR(8) NOT NULL,
			desnumero CHAR(16) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idcartao),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});

$app->get("/install-admin/sql/cartoesdecreditos/list", function(){
	
	$sql = new Sql();

	$name = "sp_cartoesdecreditos_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/cartoesdecreditos/get", function(){
	
	$sql = new Sql();

	$name = "sp_cartoesdecreditos_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/cartoesdecreditos/save", function(){
	
	$sql = new Sql();

	$name = "sp_cartoesdecreditos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/cartoesdecreditos/remove", function(){
	
	$sql = new Sql();

	$name = "sp_cartoesdecreditos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/tables", function(){
	
	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_gateways(
			idgateway INT NOT NULL AUTO_INCREMENT,
			desgateway VARCHAR(128) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			CONSTRAINT PRIMARY KEY(idgateway)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/inserts", function(){
	
	$sql = new Sql();

	$sql->query("
		INSERT INTO tb_gateways(desgateway) VALUES(?);
	", array(
		'PagSeguro'
	));
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/list", function(){
	
	$sql = new Sql();

	$name = "sp_gateways_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/get", function(){
	
	$sql = new Sql();

	$name = "sp_gateways_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/save", function(){
	
	$sql = new Sql();

	$name = "sp_gateways_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/gateways/remove", function(){
	
	$sql = new Sql();

	$name = "sp_gateways_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/tables", function(){
	
	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_formaspagamentos(
			idformapagamento INT NOT NULL AUTO_INCREMENT,
			idgateway INT NOT NULL,
			desformapagamento VARCHAR(128) NOT NULL,
			nrparcelasmax INT NOT NULL,
			instatus BIT(1),
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idformapagamento),
			CONSTRAINT FOREIGN KEY(idgateway) REFERENCES tb_gateways(idgateway)
		) ENGINE=".DB_ENGINE." AUTO_INCREMENT=1 DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_pagamentosstatus(
			idstatus INT NOT NULL AUTO_INCREMENT,
			desstatus VARCHAR(128) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idstatus)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_pagamentos(
			idpagamento INT NOT NULL AUTO_INCREMENT,
			idpessoa INT NOT NULL,
			idformapagamento INT NOT NULL,
			idstatus INT NOT NULL,
			dessession VARCHAR(128) NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			nrparcelas INT NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idpagamento),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa),
			CONSTRAINT FOREIGN KEY(idformapagamento) REFERENCES tb_formaspagamentos(idformapagamento),
			CONSTRAINT FOREIGN KEY(idstatus) REFERENCES tb_pagamentosstatus(idstatus)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_pagamentosprodutos(
			idpagamento INT NOT NULL,
			idproduto INT NOT NULL,
			nrqtd INT NOT NULL,
			vlpreco DECIMAL(10,2) NOT NULL,
			vltotal DECIMAL(10,2) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idpagamento) REFERENCES tb_pagamentos(idpagamento),
			CONSTRAINT FOREIGN KEY(idproduto) REFERENCES tb_produtos(idproduto)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");

	$sql->query("
		CREATE TABLE tb_pagamentosrecibos(
			idpagamento INT NOT NULL,
			desautenticacao VARCHAR(256) NOT NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT FOREIGN KEY(idpagamento) REFERENCES tb_pagamentos(idpagamento)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/inserts", function(){
	
	$sql = new Sql();

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Visa', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'MasterCard', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Diners Club', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Amex', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'HiperCard', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Aura', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Elo', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Boleto', 1, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Débito Online Itaú', 1, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Débito Online Banco do Brasil', 1, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Débito Online Banrisul', 1, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Débito Online Bradesco', 1, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Débito Online HSBC', 1, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'PlenoCard', 3, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'PersonalCard', 3, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'JCB', 1, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Discover', 1, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'BrasilCard', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'FortBrasil', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'CardBan', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'ValeCard', 3, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Cabal', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Mais', 10, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Avista', 6, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'GRANDCARD', 12, 1
	));

	$sql->proc("sp_formaspagamentos_save", array(
		0, 1, 'Sorocred', 12, 1
	));
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/list", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_formaspagamentos_list',
		'sp_pagamentos_list',
		'sp_pagamentosprodutos_list',
		'sp_pagamentosrecibos_list',
		'sp_pagamentosstatus_list'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/get", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_formaspagamentos_get',
		'sp_pagamentos_get',
		'sp_pagamentosprodutos_get',
		'sp_pagamentosrecibos_get',
		'sp_pagamentosstatus_get'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/save", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_formaspagamentos_save',
		'sp_pagamentos_save',
		'sp_pagamentosprodutos_save',
		'sp_pagamentosrecibos_save',
		'sp_pagamentosstatus_save'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/pagamentos/remove", function(){
	
	$sql = new Sql();

	$procs = array(
		'sp_formaspagamentos_remove',
		'sp_pagamentos_remove',
		'sp_pagamentosprodutos_remove',
		'sp_pagamentosrecibos_remove',
		'sp_pagamentosstatus_remove'
	);

	foreach ($procs as $name) {
		$sql->query("DROP PROCEDURE IF EXISTS {$name};");
		$sql->queryFromFile(PATH_PROC."{$name}.sql");
	}	
	
	echo success();
	
});

$app->get("/install-admin/sql/sitecontatos/tables", function(){
	
	$sql = new Sql();

	$sql->query("
		CREATE TABLE tb_sitecontatos(
			idsitecontato INT NOT NULL AUTO_INCREMENT,
			idpessoa INT NOT NULL,
			desmensagem VARCHAR(2048) NOT NULL,
			inlido BIT(1) NULL,
			dtcadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
			CONSTRAINT PRIMARY KEY(idsitecontato),
			CONSTRAINT FOREIGN KEY(idpessoa) REFERENCES tb_pessoas(idpessoa)
		) ENGINE=".DB_ENGINE." DEFAULT CHARSET=".DB_COLLATE.";
	");
	
	echo success();
	
});

$app->get("/install-admin/sql/sitecontatos/list", function(){
	
	$sql = new Sql();

	$name = "sp_sitecontatos_list";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/sitecontatos/get", function(){
	
	$sql = new Sql();

	$name = "sp_sitecontatos_get";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/sitecontatos/save", function(){
	
	$sql = new Sql();

	$name = "sp_sitecontatos_save";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

$app->get("/install-admin/sql/sitecontatos/remove", function(){
	
	$sql = new Sql();

	$name = "sp_sitecontatos_remove";
	$sql->query("DROP PROCEDURE IF EXISTS {$name};");
	$sql->queryFromFile(PATH_PROC."{$name}.sql");
	
	echo success();
	
});

?>