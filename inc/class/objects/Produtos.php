<?php

class Produtos extends Collection {

    protected $class = "Produto";
    protected $saveQuery = "CALL sp_produto_save(?, ?, ?, ?);";
    protected $saveArgs = array("idproduto", "idprodutotipo", "desproduto", "vlpreco", "inremovido");
    protected $pk = "idproduto";

    public function get(){}

    public static function listAll(){

    	$produtos = new Produtos();

    	$produtos->loadFromQuery("CALL sp_produtos_list();");

    	return $produtos;

    }

    public function getByCarrinho(Carrinho $carrinho):Produtos
    {

        $this->loadFromQuery("CALL sp_produtosfromcarrinho_list(?);", array(
            $carrinho->getidcarrinho()
        ));

        return $this;

    }

}
?>