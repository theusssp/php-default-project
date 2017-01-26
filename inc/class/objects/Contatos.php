<?php
class Contatos extends Collection {
    protected $class = "Contato";
    protected $saveQuery = "sp_contatos_save";
    protected $saveArgs = array("idcontato", "idcontatosubtipo", "idpessoa", "descontato", "inprincipal");
    protected $pk = "idcontato";
    public function get(){}

    public static function listFromPessoa($idpessoa){

    	$contatos = new Contatos();

    	$contatos->loadFromQuery("CALL sp_contatosfrompessoa_list(?)", array(
    		(int)$idpessoa
    	));

    	return $contatos;

    }

}
?>