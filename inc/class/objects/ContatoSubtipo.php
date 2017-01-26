<?php

class ContatoSubtipo extends Model {

    public $required = array('idcontatotipo', 'descontatosubtipo');
    protected $pk = "idcontatosubtipo";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_contatossubtipos_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_contatossubtipos_save(?, ?, ?);", array(
                $this->getidcontatosubtipo(),
                $this->getidcontatotipo(),
                $this->getdescontatosubtipo(),
                $this->getidusuario()
            ));

            return $this->getidcontatosubtipo();
        }else{
            return false;
        }
        
    }
    public function remove(){
        $this->proc("sp_contatossubtipos_remove", array(
            $this->getidcontatosubtipo()
        ));
        return true;
        
    }
}
?>