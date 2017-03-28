<?php

class Produto extends Model {

    public $required = array('idproduto', 'desproduto', 'idprodutotipo', 'inremovido');
    protected $pk = "idproduto";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_produto_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            if ($this->getinremovido() === NULL) $this->setinremovido(false);

            $this->queryToAttr("CALL sp_produto_save(?, ?, ?, ?, ?);", array(
                $this->getidproduto(),
                $this->getidprodutotipo(),
                $this->getdesproduto(),
                $this->getinremovido(),
                $this->getvlpreco()
            ));

            return $this->getidproduto();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->execute("CALL sp_produto_remove(".$this->getidproduto().")");

        return true;
        
    }

    public function getCarrinhos(){

        $carrinhos = new Produtos();

        $carrinhos->loadFromQuery("CALL sp_carrinhosfromproduto_list(?);", array(
            $this->getidproduto()
        ));

        return $carrinhos;

    }

    public function getPedidos(){

        $pagamentos = new Produtos();

        $pagamentos->loadFromQuery("CALL sp_pagamentosfromproduto_list(?);", array(
            $this->getidproduto()
        ));

        return $pagamentos;

    }

    public function getProdutosPrecos(){

        $precos = new ProdutosPrecos();

        $precos->loadFromQuery("CALL sp_precosfromproduto_list(?);", array(
            $this->getidproduto()
        ));

        return $precos;

    }

    public function getArquivos():Arquivos
    {

        $arquivos = new Arquivos();

        $arquivos->loadFromQuery("
            SELECT * 
            FROM tb_arquivos a
            INNER JOIN tb_produtosarquivos b ON a.idarquivo = b.idarquivo
            WHERE b.idproduto = ?
        ", array(
            $this->getidproduto()
        ));

        return $arquivos;

    }

    public function addArquivo(Arquivo $arquivo):bool
    {

        $this->execute("
            INSERT INTO tb_produtosarquivos (idproduto, idarquivo)
            VALUES(?, ?);
        ", array(
            $this->getidproduto(),
            $arquivo->getidarquivo()
        ));

        return true;

    }

}

?>