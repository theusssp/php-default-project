<?php

// produtos
$app->get("/panel/produtos/:idproduto", function($idproduto){

	$conf = Session::getConfiguracoes();

	$produto = new Produto((int)$idproduto);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto", array(
		"produto"=>$produto->getFields(),
		"diretorio"=>$conf->getByName("UPLOAD_DIR")
	));

});

$app->get("/panel/produto-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto-criar");

});

// pagamentos
$app->get("/panel/pagamentos/:idpagamento", function($idpagamento){

	$pagamento = new Pagamento((int)$idpagamento);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pagamento", array(
		"pagamento"=>$pagamento->getFields()
	));

});

$app->get("/panel/pagamento-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pagamento-criar");

});

// Contatos-tipos
$app->get("/panel/contatos-tipos-salvar/:idcontatotipo", function($idcontatotipo){

	$contato = new ContatoTipo((int)$idcontatotipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/contato-tipo-salvar", array(
		"contato"=>$contato->getFields()
	));

});

$app->get("/panel/contatos-tipos-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/contato-tipo-criar");

});

// pessoas-tipos
$app->get("/panel/pessoas-tipos/:idpessoatipo", function($idpessoatipo){

	$pessoa = new PessoaTipo((int)$idpessoatipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pessoa-tipo-salvar", array( // nome do arquivo panel, vai no html no plural
		"pessoa"=>$pessoa->getFields()
	));

});

$app->get("/panel/pessoas-tipos-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pessoa-tipo-criar");

});

// gateways

$app->get("/panel/gateways-salvar/:idgateway", function($idgateway){

	$gateway = new Gateway((int)$idgateway);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/gateway-salvar", array( 
		"gateway"=>$gateway->getFields()
	));

});

$app->get("/panel/gateways-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/gateways-criar");

});

// pagamentos-status
$app->get("/panel/pedidos-status/:idstatus", function($idstatus){

	$status = new PedidoStatus((int)$idstatus);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pedidos-status-salvar", array(
		"status"=>$status->getFields()
	));

});

$app->get("/panel/pedidos-status-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pedidos-status-criar");

});

// site contatos
$app->get("/panel/sites-contatos/:idsitecontato", function($idsitecontato){

	$site = new SiteContato((int)$idsitecontato);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/site-contato", array(
		"sitecontato"=>$site->getFields()
	));

});
///////////////////////////////////////////////////////////////

// formas de pagamento
$app->get("/panel/formas-pagamentos/:idformapagamento", function($idformapagamento){

	$forma = new FormaPagamento((int)$idformapagamento);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/forma-pagamento", array(
		"formapagamento"=>$forma->getFields()
	));

});

$app->get("/panel/forma-pagamento-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/forma-pagamento-criar");

});
///////////////////////////////////////////////////////////

// cartoes de credito
$app->get("/panel/cartoes/:idcartao", function($idcartao){

	$cartao = new CartaoCredito((int)$idcartao);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cartao", array(
		"cartao"=>$cartao->getFields()
	));

});

$app->get("/panel/cartao-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cartao-criar");

});

// permissoes
$app->get("/panel/permissao-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/permissao-criar");

});

///////////////////////////////////////////////////////////

// cupons
$app->get("/panel/cupons/:idcupom", function($idcupom){

	$cupom = new Cupom((int)$idcupom);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupom", array(
		"cupom"=>$cupom->getFields()
	));

});

$app->get("/panel/cupom-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupom-criar");

});
////////////////////////////////
//cupons-tipos

$app->get("/panel/cupons-tipos/:idcupomtipo", function($idcupomtipo){

	$cupom = new CupomTipo((int)$idcupomtipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupons-tipos-salvar", array(
		"cupom"=>$cupom->getFields()
	));

});

$app->get("/panel/cupons-tipos-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cupons-tipos-criar");

});

// Permissao Salvar
$app->get("/panel/permissoes/:idpermissao", function($idpermissao){

	$permissao = new Permissao((int)$idpermissao);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/permissao-salvar", array(
		"permissao"=>$permissao->getFields()
	));

});

/////////////////////////////////////////
// produto-tipo salvar

$app->get("/panel/produtos-tipos/:idprodutotipo", function($idprodutotipo){

	$produto = new ProdutoTipo((int)$idprodutotipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto-tipo-salvar", array(
		"produto"=>$produto->getFields()
	));

});

$app->get("/panel/produtos-tipos-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/produto-tipo-criar");

});
/////////////////////////////////////////
// Usuario-tipo salvar

$app->get("/panel/usuarios-tipos/:idusuariotipo", function($idusuariotipo){

	$usuariotipo = new UsuarioTipo((int)$idusuariotipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/usuario-tipo-salvar", array(
		"usuariotipo"=>$usuariotipo->getFields()
	));

});

$app->get("/panel/usuario-tipo-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/usuario-tipo-criar");

});

// Pessoas-valores-campos

$app->get("/panel/pessoas-valorescampos/:idcampo", function($idcampo){

	$pessoavalor = new PessoaValorCampo((int)$idcampo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pessoa-valorcampo-salvar", array(
		"pessoavalor"=>$pessoavalor->getFields()
	));

});

$app->get("/panel/pessoas-valorescampos-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pessoa-valorcampo-criar");

});

// Configuracoes-tipos

$app->get("/panel/configuracoes-tipos/:idconfiguracaotipo", function($idconfiguracaotipo){

	$configuracao = new ConfiguracaoTipo((int)$idconfiguracaotipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/configuracao-tipo-salvar", array(
		"configuracao"=>$configuracao->getFields()
	));

});

$app->get("/panel/configuracoes-tipos-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/configuracao-tipo-criar");

});

/////////////////////////////////////////
// Lugares-tipos salvar

$app->get("/panel/lugares-tipos/:idlugartipo", function($idlugartipo){

	$lugartipo = new LugarTipo((int)$idlugartipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/lugares-tipos-salvar", array(
		"lugartipo"=>$lugartipo->getFields()
	));

});

$app->get("/panel/lugares-tipos-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/lugares-tipos-criar");

});

////////////////////////////////////////////////////
// Documentos-tipos

$app->get("/panel/documentos/tipos/:iddocumentotipo", function($iddocumentotipo){

	$documento = new DocumentoTipo((int)$iddocumentotipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/documento-tipo-salvar", array(
		"documento"=>$documento->getFields()
	));

});

$app->get("/panel/documento-tipo-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/documento-tipo-criar");

});

// Enderecos-tipos

$app->get("/panel/enderecos/tipos/:idenderecotipo", function($idenderecotipo){

	$endereco = new EnderecoTipo((int)$idenderecotipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/endereco-tipo-salvar", array(
		"endereco"=>$endereco->getFields()
	));

});

$app->get("/panel/endereco-tipo-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/endereco-tipo-criar");

});

// Historicos-tipos

$app->get("/panel/historicos-tipos/:idhistoricotipo", function($idhistoricotipo){

	$historicotipo = new HistoricoTipo((int)$idhistoricotipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/historico-tipo-salvar", array(
		"historicotipo"=>$historicotipo->getFields()
	));

});

$app->get("/panel/historico-tipo-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/historico-tipo-criar");

});
////////////////////////////////////////////////////////////////

// pessoas
$app->get("/panel/pessoas/:idpessoa", function($idpessoa){

	$pessoa = new Pessoa((int)$idpessoa);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$contatos = $pessoa->getContatos();

	$telefones = $contatos->filterBy(array(
		"idcontatotipo"=>Contato::TELEFONE
	), true); // filtrando os contatos que são telefones

	$emails = $contatos->filterBy(array(
		"idcontatotipo"=>Contato::EMAIL
	), true); // filtrando os contatos que são emails

	$documentos = $pessoa->getDocumentos();

	$pessoa->setDocumentos($documentos);
	$pessoa->setTelefones($telefones);
	$pessoa->setEmails($emails);

	$page->setTpl("panel/pessoa", array(
		"pessoa"=>$pessoa->getFields()
	));

});

///////////////////////////////////////////////////////////
// carrinhos
$app->get("/panel/carrinhos/:idcarrinho", function($idcarrinho){

	$carrinho = new Carrinho((int)$idcarrinho);

	$frete = new CarrinhoFrete((int)$idcarrinho);

	$carrinho->setProdutos($carrinho->getProdutos()->getFields());
	$carrinho->setCupons($carrinho->getCupons()->getFields());
	$carrinho->setFrete($frete->getFields());

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carrinho", array(
		"carrinho"=>$carrinho->getFields()
	));

});

////////////////////////////////////////////////////////////
// lugares
$app->get("/panel/lugares/:idlugar", function($idlugar){

	$lugar = new Lugar((int)$idlugar);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$data = $lugar->getFields();

	$horarios = $lugar->getLugaresHorarios()->getFields();

	if(!count($horarios) > 0) $horarios = Language::getWeekdays();

	$data['Horarios'] = $horarios;

	$page->setTpl("panel/lugar", array(
		"lugar"=>$data
	));

});

$app->get("/panel/lugar-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/lugar-criar");

});

$app->get("/panel/lugar-horarios", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/lugar-horarios", array(
		"ids"=>$_GET['ids'],
		"horarios"=>Language::getWeekdays()
	));

});
/////////////////////////////////////////////////////////////

// cursos
$app->get("/panel/cursos/:idcurso", function($idcurso){

	$curso = new Curso((int)$idcurso);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/curso", array(
		"curso"=>$curso->getFields()
	));

});

$app->get("/panel/curso-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/curso-criar");

});
//////////////////////////////////////////////////////////////////////

// carousels
$app->get("/panel/carousels/:idcarousel", function($idcarousel){

	$carousel = new Carousel((int)$idcarousel);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel", array(
		"carousel"=>$carousel->getFields()
	));

});

$app->get("/panel/carousel-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel-criar");

});
//////////////////////////////////////////////////////////////////

// carousels items tipos
$app->get("/panel/carousels-items-tipos/:idtipo", function($idtipo){

	$tipo = new CarouselItemTipo((int)$idtipo);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel-item-tipo-salvar", array(
		"tipo"=>$tipo->getFields()
	));

});

$app->get("/panel/carousel-item-tipo-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/carousel-item-tipo-criar");

});
////////////////////////////////////////////////////////////////

// paises
$app->get("/panel/paises/:idpais", function($idpais){

	$pais = new Pais((int)$idpais);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pais", array(
		"pais"=>$pais->getFields()
	));

});

$app->get("/panel/pais-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pais-criar");

});
/////////////////////////////////////////////////////

// estados
$app->get("/panel/estados/:idestado", function($idestado){

	$estado = new Estado((int)$idestado);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/estado", array(
		"estado"=>$estado->getFields()
	));

});

$app->get("/panel/estado-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/estado-criar");

});
///////////////////////////////////////////////////////

// cidades
$app->get("/panel/cidades/:idcidade", function($idcidade){

	$cidade = new Cidade((int)$idcidade);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cidade", array(
		"cidade"=>$cidade->getFields()
	));

});

$app->get("/panel/cidade-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/cidade-criar");

});
////////////////////////////////////////////////////

// pessoas categorias tipos
$app->get("/panel/pessoas-categorias-tipos/:idcategoria", function($idcategoria){

	$categoria = new PessoaCategoriaTipo((int)$idcategoria);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pessoa-categoria-tipo", array(
		"categoria"=>$categoria->getFields()
	));

});

$app->get("/panel/pessoa-categoria-tipo-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/pessoa-categoria-tipo-criar");

});
///////////////////////////////////////////////////////////

// urls
$app->get("/panel/urls/:idurl", function($idurl){

	$url = new Url((int)$idurl);

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/url", array(
		"url"=>$url->getFields()
	));

});

$app->get("/panel/url-criar", function(){

	$page = new Page(array(
		"header"=>false,
		"footer"=>false
	));

	$page->setTpl("panel/url-criar");

});

?>