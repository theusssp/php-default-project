<?php

class PlaceType extends Model {

    public $required = array('desplacetype');
    protected $pk = "idplacetype";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_placeestypes_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_placeestypes_save(?, ?);", array(
                $this->getidplacetype(),
                $this->getdesplacetype()
            ));

            return $this->getidplacetype();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_placeestypes_remove(".$this->getidplacetype().")");

        return true;
        
    }

}

?>