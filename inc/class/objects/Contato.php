<?php

class Contato extends Model {

    public $required = array('idcontatotipo', 'idpessoa', 'descontato', 'inprincipal');
    protected $pk = "idcontato";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_contatos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_contatos_save(?, ?, ?, ?, ?);", array(
                $this->getidcontato(),
                $this->getidcontatotipo(),
                $this->getidpessoa(),
                $this->getdescontato(),
                $this->getinprincipal()
            ));

            return $this->getidcontato();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_contatos_remove(".$this->getidcontato().")");

        return true;
        
    }

}

?>