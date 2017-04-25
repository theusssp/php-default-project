<?php 

$app->get("/", function(){

    $page = new Hcode\Site\Page();

    $page->setTpl('index');

});

$app->get("/blog", function(){

	$page = (int)get("page");
	$itemsPerPage = (int)get("limit");

	$where = array();

	array_push($where, "a.dtpublished <= NOW()");

	if(get("destitle") != ""){
		array_push($where, "a.destitle LIKE '%".utf8_encode(get("destitle"))."%'");
	}

	if(get("desauthor") != ""){
		array_push($where, "b.desauthor LIKE '%".utf8_encode(get("desauthor"))."%'");
	}

	if(get("dtpublished") != ""){
		array_push($where, "a.dtpublished = '".get("dtpublished")."'");
	}

	if(get("idsCategories")){
		array_push($where, "c.idcategory IN(".get("idcategory").")");
	}

	if(get("idsTags")){
		array_push($where, "d.idtag IN(".get("idtag").")");
	}

	if(count($where) > 0){
		$where = " WHERE ".implode(" AND ", $where)."";
	}else{
		$where = "";
	}

	$query = "
		SELECT SQL_CALC_FOUND_ROWS a.*, b.desauthor, f.desurl, CONCAT(e.desdirectory, e.desfile, '.', e.desextension) AS descover, 
			(
				SELECT COUNT(idcomment) FROM tb_blogcomments WHERE idpost = a.idpost
			) AS nrcomments,
			(
				SELECT GROUP_CONCAT(b.destag)
				FROM tb_blogpoststags a
				LEFT JOIN tb_blogtags b ON a.idtag = b.idtag
				WHERE idpost = a.idpost
			) AS destags FROM tb_blogposts a
			INNER JOIN tb_blogauthors b ON a.idauthor = b.idauthor
			LEFT JOIN tb_blogpostscategories c ON a.idpost = c.idpost
			LEFT JOIN tb_blogpoststags d ON a.idpost = d.idpost
            LEFT JOIN tb_files e ON a.idcover = e.idfile
            LEFT JOIN tb_urls f ON a.idurl = f.idurl
            LEFT JOIN tb_blogcomments g ON a.idpost = g.idpost
		".$where." GROUP BY a.idpost LIMIT ?, ?;
	";

	$pagination = new Hcode\Pagination(
		$query,
		array(),
		"Hcode\Site\Blog\Posts",
		$itemsPerPage
	);

	$posts = $pagination->getPage($page);

	$page = new Hcode\Site\Page();

	$page->setTpl("blog", array(
		"posts"=>$posts->getFields(),
		"total"=>$pagination->getTotal(),
		"currentPage"=>$page,
		"itemsPerPage"=>$itemsPerPage,
		"categories"=>Hcode\Site\Blog\Categories::listAll()->getFields()
	));

});

$app->get("/login", function(){

	$page = new Hcode\Site\Page();

	$page->setTpl("login");

});

$app->get("/forget", function(){

	$page = new Hcode\Site\Page();

	$page->setTpl("forget");

});

$app->post("/login", function(){

	$user = Hcode\System\User::login(strtolower(post("username")), post("password"));

	$user->getPerson();

	Hcode\Session::setUser($user, (isset($_POST['remember'])));
	
	$configurations = Hcode\System\Configurations::listAll();

	Hcode\Session::setConfigurations($configurations);

	echo success(array(
		"token"=>session_id()
	));

});

$app->post("/logout", function(){

	unsetLocalCookie(COOKIE_KEY);

	if (isset($_SESSION)) unset($_SESSION);

	session_destroy();

	echo success();

});

$app->post("/register", function(){

	if(!post("despassword")){
		throw new Exception("Preencha a senha", 400);		
	}

	if($_POST["despassword"] != $_POST['despassword2']){
		throw new Exception("As senhas devem ser idênticas", 400);		
	}

	$person = new Hcode\Person\Person(array(
		"desperson"=>post("desperson"),
		"idpersontype"=>Hcode\Person\Type::FISICA
	));

	$person->save();

	$user = new Hcode\System\User(array(
		"idperson"=>$person->getidperson(),
		"desuser"=>post("desuser"),
		"despassword"=>Hcode\System\User::getPasswordHash(post('despassword')),
		"inblocked"=>0,
		"idusertype"=>Hcode\System\User\Type::CLIENTE
	));

	$user->save();

	$person->addContact(post("desuser"), Hcode\Contact\SubType::EMAIL_PESSOAL);

	$user->getPerson();

	Hcode\Session::setUser($user, (isset($_POST['remember'])));
	
	$configurations = Hcode\System\Configurations::listAll();

	Hcode\Session::setConfigurations($configurations);

	echo success(array(
		'token'=>session_id()
	));

});

$app->post("/login", function(){

	$user = Hcode\System\User::login(strtolower(post("username")), post("password"));

	$user->getPerson();

});

?>