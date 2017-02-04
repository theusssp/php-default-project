<?php

$app->get("/lugares/all", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	echo success(array("data"=>Lugares::listAll()->getFields()));

});

$app->post("/lugares", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idlugar') > 0){
		$lugar = new Lugar((int)post('idlugar'));
	}else{
		$lugar = new Lugar();
	}

	foreach ($_POST as $key => $value) {
		$lugar->{'set'.$key}($value);
	}

	$lugar->save();

	echo success(array("data"=>$lugar->getFields()));

});

$app->delete("/lugares/:idlugar", function($idlugar){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idlugar){
		throw new Exception("Lugar não informado", 400);		
	}

	$lugar = new Lugar((int)$idlugar);

	if(!(int)$lugar->getidlugar() > 0){
		throw new Exception("Lugar não encontrado", 404);		
	}

	$lugar->remove();

	echo success();

});
/////////////////////////////////////////////////////////////

// lugares tipos
$app->get("/lugares/tipos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	echo success(array("data"=>LugaresTipos::listAll()->getFields()));

});

$app->post("/lugares-tipos", function(){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(post('idlugartipo') > 0){
		$lugartipo = new LugarTipo((int)post('idlugartipo'));
	}else{
		$lugartipo = new LugarTipo();
	}

	foreach ($_POST as $key => $value) {
		$lugartipo->{'set'.$key}($value);
	}

	$lugartipo->save();

	echo success(array("data"=>$lugartipo->getFields()));

});

$app->delete("/lugares-tipos/:idlugartipo", function($idlugartipo){

	Permissao::checkSession(Permissao::ADMIN, true);

	if(!(int)$idlugartipo){
		throw new Exception("Tipo de lugar não informado", 400);	
	}

	$lugartipo = new LugarTipo((int)$idlugartipo);

	if(!(int)$lugartipo->getidlugartipo() > 0){
		throw new Exception("Tipo de lugur não encontrado", 404);		
	}

	$lugartipo->remove();
	
	echo success();

});

?>