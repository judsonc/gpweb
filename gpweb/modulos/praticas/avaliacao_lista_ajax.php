<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb profissional - registrado no INPI sob o número RS 11802-5 e protegido pelo direito de autor. 
É expressamente proibido utilizar este script em parte ou no todo sem o expresso consentimento do autor.
*/

include_once $Aplic->getClasseBiblioteca('xajax/xajax_core/xajax.inc');
$xajax = new xajax();
$xajax->configure('defaultMode', 'synchronous');
//$xajax->setFlag('debug',true);
//$xajax->setFlag('outputEntities',true);

function travar($tipo){
	global $Aplic;
	$sql = new BDConsulta;
	$sql->setExcluir('favorito_trava');
	$sql->adOnde('favorito_trava_avaliacao=1');
	$sql->adOnde('favorito_trava_usuario='.(int)$Aplic->usuario_id);
	$sql->exec();
	$sql->limpar();
		
	if ($tipo){
		$sql->adTabela('favorito_trava');
		$sql->adInserir('favorito_trava_usuario', $Aplic->usuario_id);
		$sql->adInserir('favorito_trava_avaliacao', 1);
		$sql->adInserir('favorito_trava_campo', $Aplic->getPosicao());
		$sql->exec();
		$sql->limpar();
		}
	}
$xajax->registerFunction("travar");

function painel_filtro($visao){
	global $Aplic;
	if ($visao=='none') $painel_filtro=0; 
	else  $painel_filtro=1;
	$Aplic->setEstado('painel_filtro',$painel_filtro);
	}
$xajax->registerFunction("painel_filtro");


function selecionar_om_ajax($cia_id=1, $campo, $posicao, $script,  $vazio='', $acesso=0, $externo=0 ){
	$saida=selecionar_om_para_ajax($cia_id, $campo, $script,  $vazio, $acesso, $externo);
	$objResposta = new xajaxResponse();
	$objResposta->assign($posicao,"innerHTML", $saida);
	return $objResposta;
	}
$xajax->registerFunction("selecionar_om_ajax");

$xajax->processRequest();

?>