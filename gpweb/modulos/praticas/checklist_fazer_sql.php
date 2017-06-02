<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb profissional - registrado no INPI sob o número RS 11802-5 e protegido pelo direito de autor. 
É expressamente proibido utilizar este script em parte ou no todo sem o expresso consentimento do autor.
*/

require_once (BASE_DIR.'/modulos/praticas/checklist.class.php');

$sql = new BDConsulta;

$_REQUEST['checklist_ativo']=(isset($_REQUEST['checklist_ativo']) ? 1 : 0);



$del = intval(getParam($_REQUEST, 'del', 0));
$checklist_id = getParam($_REQUEST, 'checklist_id', null);
$obj = new CChecklist();

if ($checklist_id) $obj->_mensagem = 'atualizado';
else $obj->_mensagem = 'adicionado';

if (!$obj->join($_REQUEST)) {
	$Aplic->setMsg($obj->getErro(), UI_MSG_ERRO);
	$Aplic->redirecionar('m=praticas&a=checklist_lista');
	}
$Aplic->setMsg('Checklist');
if ($del) {
	$obj->load($checklist_id);

	if (($msg = $obj->excluir())) {
		$Aplic->setMsg($msg, UI_MSG_ERRO);
		$Aplic->redirecionar('m=praticas&a=checklist_ver&checklist_id='.$checklist_id);
		} 
	else {
		$obj->notificar($_REQUEST);
		$Aplic->setMsg('excluído', UI_MSG_ALERTA, true);
		$Aplic->redirecionar('m=praticas&a=checklist_lista');
		}
	}

if (($msg = $obj->armazenar())) $Aplic->setMsg($msg, UI_MSG_ERRO);
else {
	$obj->notificar($_REQUEST);
	$Aplic->setMsg($checklist_id ? 'atualizado' : 'adicionado', UI_MSG_OK, true);
	}
	

$Aplic->redirecionar('m=praticas&a=checklist_ver&checklist_id='.$obj->checklist_id);

?>