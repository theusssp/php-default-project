<?php

namespace Hcode;

class SitesContatos extends Collection {

    protected $class = "Hcode\SiteContato";
    protected $saveQuery = "sp_sitescontatos_save";
    protected $saveArgs = array("idsitecontato", "idpessoa", "desmensagem", "inlido", "idpessoaresposta");
    protected $pk = "idsitecontato";
    public function get(){}

    public static function listAll(){

    	$contatos = new sitescontatos();

    	$contatos->loadFromQuery("CALL sp_sitescontatos_list();");

    	return $contatos;

    }

      public function getByPessoa(Pessoa $pessoa):sitescontatos
      
    {
    
         $this->loadFromQuery("CALL sp_sitescontatosfrompessoa_list(?)",array(
               $pessoa->getidpessoa()
               
        ));

         return $this;

    }


}

?>