<?php

namespace Hcode\Stand\Material\Stock;
 
 use Hcode\Model;
 use Hcode\Exception;

class Tag extends Model {

    public $required = array('idtag');
    protected $pk = array('idstock', 'idtag');

    public function get(){

        $args = func_get_args();
                        if(!isset($args[0])) throw new Exception($->pk[0]." não informado");
                if(!isset($args[1])) throw new Exception($->pk[1]." não informado");
                $this->queryToAttr("CALL sp_materialsstockstags_get(".$args[0].". ".$args[1].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_materialsstockstags_save(?, ?, ?);", array(
                $this->getidstock(),
                $this->getidtag(),
                $this->getdtregister()
            ));

            return $this->getidstock();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_materialsstockstags_remove", array(
            $this->getidstock()
        ));

        return true;
        
    }

}

?>