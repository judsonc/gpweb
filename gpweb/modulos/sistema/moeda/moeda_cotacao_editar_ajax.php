<?php
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

include_once $Aplic->getClasseBiblioteca('xajax/xajax_core/xajax.inc');
$xajax = new xajax();
$xajax->configure('defaultMode', 'synchronous');
//$xajax->setFlag('debug',true);
//$xajax->setFlag('outputEntities',true);

function excluir_valor($moeda_cotacao_id=null, $moeda_cotacao_moeda=null, $pagina=null, $ordem=null, $ordenar=null){
	$sql = new BDConsulta;
	$sql->setExcluir('moeda_cotacao');
	$sql->adOnde('moeda_cotacao_id='.(int)$moeda_cotacao_id);
	$sql->exec();
	$sql->limpar();
	
	$saida=exibir_lista($moeda_cotacao_moeda, $pagina, $ordem, $ordenar);
	$objResposta = new xajaxResponse();
	$objResposta->assign('combo_valores',"innerHTML", utf8_encode($saida));
	return $objResposta;
	}

$xajax->registerFunction("excluir_valor");	


function incluir_valor($moeda_cotacao_id=null, $moeda_cotacao_moeda=null, $moeda_cotacao_data=null, $moeda_cotacao_cotacao=null, $pagina=null, $ordem=null, $ordenar=null){
	$sql = new BDConsulta;
	
	$moeda_cotacao_cotacao=float_americano($moeda_cotacao_cotacao);
	
	if ($moeda_cotacao_id){
		$sql->adTabela('moeda_cotacao');
		$sql->adAtualizar('moeda_cotacao_data', $moeda_cotacao_data);
		$sql->adAtualizar('moeda_cotacao_cotacao', $moeda_cotacao_cotacao);
		$sql->adOnde('moeda_cotacao_id ='.(int)$moeda_cotacao_id);	
		$sql->exec();
		}
	else{	
		$sql->adTabela('moeda_cotacao');
		$sql->adInserir('moeda_cotacao_moeda', $moeda_cotacao_moeda);
		$sql->adInserir('moeda_cotacao_data', $moeda_cotacao_data);
		$sql->adInserir('moeda_cotacao_cotacao', $moeda_cotacao_cotacao);
		$sql->exec();
		$sql->limpar();
		}

	atualizar_cotacao($moeda_cotacao_moeda, $moeda_cotacao_data, $moeda_cotacao_cotacao);
	
		
	$saida=exibir_lista($moeda_cotacao_moeda, $pagina, $ordem, $ordenar);
	$objResposta = new xajaxResponse();
	$objResposta->assign('combo_valores',"innerHTML", utf8_encode($saida));
	return $objResposta;
	}

$xajax->registerFunction("incluir_valor");	

function exibir_lista($moeda_cotacao_moeda=null, $pagina=null, $ordem=null, $ordenar=null){
	global $Aplic, $config, $estilo_interface;
	$sql = new BDConsulta;
	
	$xtamanhoPagina = 30;
	$xmin = $xtamanhoPagina * ($pagina - 1);

	$seta=array('0'=>'seta-cima.gif', '1'=>'seta-baixo.gif');


	$sql->adTabela('moeda_cotacao');
	$sql->adCampo('count(DISTINCT moeda_cotacao_id) AS soma');
	$sql->adOnde('moeda_cotacao_moeda ='.(int)$moeda_cotacao_moeda);	
	$xtotalregistros = $sql->Resultado();
	$sql->limpar();
	
	$sql->adTabela('moeda_cotacao');
	$sql->adCampo('moeda_cotacao_id, formatar_data(moeda_cotacao_data, \'%d/%m/%Y\') AS data, moeda_cotacao_cotacao');
	$sql->adOnde('moeda_cotacao_moeda ='.(int)$moeda_cotacao_moeda);	
	$sql->adOrdem($ordenar.($ordem ? ' DESC' : ' ASC'));
	$sql->setLimite($xmin, $xtamanhoPagina);
	$lista = $sql->lista();
	$sql->limpar();
	
	$xtotal_paginas = ($xtotalregistros > $xtamanhoPagina) ? ceil($xtotalregistros / $xtamanhoPagina) : 0;
	
	$saida='';

	$saida.= '<table width="100%" cellpadding=0 cellspacing=0 class="std"><tr><td>';
	$saida.= '<table cellpadding=0 cellspacing=0 class="tbl1">';
	$saida.= '<tr>';
	
	
	$saida.= '<th nowrap="nowrap" width=70><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m=sistema&a=moeda_cotacao_editar&u=moeda&pagina='.$pagina.'&moeda_id='.$moeda_cotacao_moeda.'&ordenar=moeda_cotacao_data&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='moeda_cotacao_data' ? imagem('icones/'.$seta[$ordem]) : '').dica('Data', 'Neste campo fica a data da cota��o da moeda.').'Data'.dicaF().'</a></th>';
	$saida.= '<th nowrap="nowrap" width=70><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m=sistema&a=moeda_cotacao_editar&u=moeda&pagina='.$pagina.'&moeda_id='.$moeda_cotacao_moeda.'&ordenar=moeda_cotacao_cotacao&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='moeda_cotacao_cotacao' ? imagem('icones/'.$seta[$ordem]) : '').dica('Cota��o', 'Neste campo fica o valor da cota��o da moeda.').'Cota��o'.dicaF().'</a></th>';
	$saida.= '<th nowrap="nowrap">&nbsp;</th>';
	$saida.= '</tr>';
	
	foreach($lista as $linha){
		$saida.= '<tr>';
		$saida.= '<td align=center>'.$linha['data'].'</td>';
		$saida.= '<td align=right>'.number_format($linha['moeda_cotacao_cotacao'], 4, ',', '.').'</td>';
		
		$saida.= '<td width="32" align=center>';
		$saida.= '<a href="javascript: void(0);" onclick="editar_valor('.$linha['moeda_cotacao_id'].');">'.imagem('icones/editar.gif', 'Editar', 'Clique neste �cone '.imagem('icones/editar.gif').' para editar o valor.').'</a>';
		$saida.= '<a href="javascript: void(0);" onclick="if (confirm(\'Tem certeza que deseja excluir esta cota��o?\')) {excluir_valor('.$linha['moeda_cotacao_id'].');}">'.imagem('icones/remover.png', 'Excluir', 'Clique neste �cone '.imagem('icones/remover.png').' para excluir este valor.').'</a>';
		$saida.= '</td>';
		
		$saida.= '</tr>';
		}	
	$saida.= '</table>';	

	return $saida;
	}

$xajax->registerFunction("exibir_lista");	


function editar_valor($moeda_cotacao_id){
	global $Aplic;

	$sql = new BDConsulta;
	$sql->adTabela('moeda_cotacao');
	$sql->adCampo('moeda_cotacao.*');
	$sql->adOnde('moeda_cotacao_id = '.(int)$moeda_cotacao_id);
	$linha=$sql->Linha();
	$sql->limpar();

	$objResposta = new xajaxResponse();
	$objResposta->assign("moeda_cotacao_id","value", $moeda_cotacao_id);
	$objResposta->assign("moeda_cotacao_data","value", $linha['moeda_cotacao_data']);
	$valor=($linha['moeda_cotacao_cotacao']==(int)$linha['moeda_cotacao_cotacao'] ? (int)$linha['moeda_cotacao_cotacao'] : $linha['moeda_cotacao_cotacao']);
	$objResposta->assign("moeda_cotacao_cotacao","value", str_replace('.', ',', $valor));
	return $objResposta;
	}	
$xajax->registerFunction("editar_valor");	



$xajax->processRequest();

?>