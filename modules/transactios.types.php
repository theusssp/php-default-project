<?php 

$app->get('/transactions-types',function(){

 	$transaction = TransactionsTypes::listAll();

 	$currentPage = (int)get("pagina");
	$itemsPerPage = (int)get("limite");

	$where = array();

	if(get('destransactiontype')) {
		array_push($where, "destransactiontype LIKE '%".get('destransactiontype')."%'");
	}

	if (count($where) > 0) {
		$where = ' WHERE '.implode(' AND ', $where);
	} else {
		$where = '';
	}

	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_transactionstypes
	".$where." limit ?, ?;";

	$pagination = new Pagination(
        $query,
        array(),
        "TransactionsTypes",
        $itemsPerPage
    );

    $transaction = $pagination->getPage($currentPage);

    echo success(array(
    	"data"=>$transaction ->getFields(),
        "currentPage"=>$currentPage,
        "itemsPerPage"=>$itemsPerPage,
        "total"=>$pagination->getTotal(),

    ));

});

$app->post("/transactions-types", function(){

	if(post('idtransactiontype') > 0){
		$transaction = new TransactionType((int)post('idtransactiontype'));
	}else{
		$transaction = new TransactionType();
	}

	$transaction->set($_POST);

	$transaction->save();

	echo success(array("data"=>$transaction->getFields()));

});

$app->delete("/transactions-types/:idtransactiontype", function($idtransactiontype){

	Permission::checkSession(Permission::ADMIN, true);

	if(!(int)$idtransactiontype > 0){
		throw new Exception("Tipo de Transações não informado.", 400);		
	}

	$transaction = new TransactionType((int)$idtransactiontype);

	$transaction->remove();

	echo success();

});
 
?>