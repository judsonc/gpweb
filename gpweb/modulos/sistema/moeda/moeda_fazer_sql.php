<?php
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


require_once (BASE_DIR.'/modulos/sistema/moeda/moeda.class.php');

$sql = new BDConsulta;

$_REQUEST['moeda_ativo']=(isset($_REQUEST['moeda_ativo']) ? 1 : 0);

$moeda_id = getParam($_REQUEST, 'moeda_id', null);

$del = intval(getParam($_REQUEST, 'del', 0));

$obj = new CMoeda();
if ($moeda_id) $obj->_mensagem = 'atualizada';
else $obj->_mensagem = 'adicionada';

if (!$obj->join($_REQUEST)) {
	$Aplic->setMsg($obj->getErro(), UI_MSG_ERRO);
	$Aplic->redirecionar('m=sistema&u=moeda&a=moeda_lista');
	}
$Aplic->setMsg('Moeda');
if ($del) {
	$obj->load($moeda_id);
	if (($msg = $obj->excluir())) {
		$Aplic->setMsg($msg, UI_MSG_ERRO);
		$Aplic->redirecionar('m=sistema&u=moeda&a=moeda_ver&moeda_id='.$moeda_id);
		} 
	else {
		$Aplic->setMsg('exclu�da', UI_MSG_ALERTA, true);
		$Aplic->redirecionar('m=sistema&u=moeda&a=moeda_lista');
		}
	}

if (($msg = $obj->armazenar())) $Aplic->setMsg($msg, UI_MSG_ERRO);
else {
	$Aplic->setMsg($moeda_id ? 'atualizada' : 'adicionada', UI_MSG_OK, true);
	}
	
	
$Aplic->redirecionar('m=sistema&u=moeda&a=moeda_ver&moeda_id='.$obj->moeda_id);

?>