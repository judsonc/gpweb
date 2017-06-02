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

function mudar_posicao_atesta_opcao($assinatura_atesta_opcao_ordem, $assinatura_atesta_opcao_id, $direcao, $assinatura_atesta_opcao_atesta){
	//ordenar membro da equipe
	$sql = new BDConsulta;
	if($direcao&&$assinatura_atesta_opcao_id) {
		$novo_ui_assinatura_atesta_opcao_ordem = $assinatura_atesta_opcao_ordem;
		$sql->adTabela('assinatura_atesta_opcao');
		$sql->adOnde('assinatura_atesta_opcao_id != '.(int)$assinatura_atesta_opcao_id);
		$sql->adOnde('assinatura_atesta_opcao_atesta = '.(int)$assinatura_atesta_opcao_atesta);
		$sql->adOrdem('assinatura_atesta_opcao_ordem');
		$membros = $sql->Lista();
		$sql->limpar();
		
		if ($direcao == 'moverParaCima') {
			$outro_novo = $novo_ui_assinatura_atesta_opcao_ordem;
			$novo_ui_assinatura_atesta_opcao_ordem--;
			} 
		elseif ($direcao == 'moverParaBaixo') {
			$outro_novo = $novo_ui_assinatura_atesta_opcao_ordem;
			$novo_ui_assinatura_atesta_opcao_ordem++;
			} 
		elseif ($direcao == 'moverPrimeiro') {
			$outro_novo = $novo_ui_assinatura_atesta_opcao_ordem;
			$novo_ui_assinatura_atesta_opcao_ordem = 1;
			} 
		elseif ($direcao == 'moverUltimo') {
			$outro_novo = $novo_ui_assinatura_atesta_opcao_ordem;
			$novo_ui_assinatura_atesta_opcao_ordem = count($membros) + 1;
			}
		if ($novo_ui_assinatura_atesta_opcao_ordem && ($novo_ui_assinatura_atesta_opcao_ordem <= count($membros) + 1)) {
			$sql->adTabela('assinatura_atesta_opcao');
			$sql->adAtualizar('assinatura_atesta_opcao_ordem', $novo_ui_assinatura_atesta_opcao_ordem);
			$sql->adOnde('assinatura_atesta_opcao_id = '.(int)$assinatura_atesta_opcao_id);
			$sql->exec();
			$sql->limpar();
			$idx = 1;
			foreach ($membros as $acao) {
				if ((int)$idx != (int)$novo_ui_assinatura_atesta_opcao_ordem) {
					$sql->adTabela('assinatura_atesta_opcao');
					$sql->adAtualizar('assinatura_atesta_opcao_ordem', $idx);
					$sql->adOnde('assinatura_atesta_opcao_id = '.(int)$acao['assinatura_atesta_opcao_id']);
					$sql->exec();
					$sql->limpar();
					$idx++;
					} 
				else {
					$sql->adTabela('assinatura_atesta_opcao');
					$sql->adAtualizar('assinatura_atesta_opcao_ordem', $idx + 1);
					$sql->adOnde('assinatura_atesta_opcao_id = '.(int)$acao['assinatura_atesta_opcao_id']);
					$sql->exec();
					$sql->limpar();
					$idx = $idx + 2;
					}
				}		
			}
		}
	
	$saida=atualizar_atestas_opcao($assinatura_atesta_opcao_atesta);
	$objResposta = new xajaxResponse();
	$objResposta->assign("atestas_opcao","innerHTML", $saida);
	return $objResposta;
	}
$xajax->registerFunction("mudar_posicao_atesta_opcao");		
	

function incluir_atesta_opcao(
	$assinatura_atesta_opcao_id, 
	$assinatura_atesta_opcao_nome, 
	$assinatura_atesta_opcao_aprova,
	$assinatura_atesta_opcao_atesta
	){
	
	$sql = new BDConsulta;
	$assinatura_atesta_opcao_nome=previnirXSS(utf8_decode($assinatura_atesta_opcao_nome));

	if ($assinatura_atesta_opcao_id){
		$sql->adTabela('assinatura_atesta_opcao');
		$sql->adAtualizar('assinatura_atesta_opcao_nome', $assinatura_atesta_opcao_nome);	
		$sql->adAtualizar('assinatura_atesta_opcao_aprova', (int)$assinatura_atesta_opcao_aprova);	
		$sql->adOnde('assinatura_atesta_opcao_id ='.(int)$assinatura_atesta_opcao_id);
		$sql->exec();
	  $sql->limpar();
		}
	else {	
		$sql->adTabela('assinatura_atesta_opcao');
		$sql->adCampo('count(assinatura_atesta_opcao_id) AS soma');
	  $soma_total = 1+(int)$sql->Resultado();
	  $sql->limpar();
		$sql->adTabela('assinatura_atesta_opcao');
		$sql->adInserir('assinatura_atesta_opcao_ordem', $soma_total);
		$sql->adInserir('assinatura_atesta_opcao_nome', $assinatura_atesta_opcao_nome);	
		$sql->adInserir('assinatura_atesta_opcao_aprova', (int)$assinatura_atesta_opcao_aprova);	
		$sql->adInserir('assinatura_atesta_opcao_atesta', (int)$assinatura_atesta_opcao_atesta);	
		$sql->exec();
		}
	$saida=atualizar_atestas_opcao($assinatura_atesta_opcao_atesta);
	$objResposta = new xajaxResponse();
	$objResposta->assign("atestas_opcao","innerHTML", $saida);
	return $objResposta;
	}
$xajax->registerFunction("incluir_atesta_opcao");	


function excluir_atesta_opcao($assinatura_atesta_opcao_id, $assinatura_atesta_opcao_atesta){
	$sql = new BDConsulta;
	$sql->setExcluir('assinatura_atesta_opcao');
	$sql->adOnde('assinatura_atesta_opcao_id='.(int)$assinatura_atesta_opcao_id);
	$sql->exec();
	$saida=atualizar_atestas_opcao($assinatura_atesta_opcao_atesta);
	$objResposta = new xajaxResponse();
	$objResposta->assign("atestas_opcao","innerHTML", $saida);
	return $objResposta;
	}

$xajax->registerFunction("excluir_atesta_opcao");	

function exibir_opcoes($assinatura_atesta_opcao_atesta=0){
	global $config, $Aplic;
	$objResposta = new xajaxResponse();
	$saida=atualizar_atestas_opcao($assinatura_atesta_opcao_atesta);
	$objResposta = new xajaxResponse();
	$objResposta->assign("assinatura_atesta_opcao_atesta","value", $assinatura_atesta_opcao_atesta);
	$objResposta->assign("atestas_opcao","innerHTML", $saida);
	
	$sql = new BDConsulta;
	$sql->adTabela('assinatura_atesta');
	$sql->adCampo('assinatura_atesta.*');
	$sql->adOnde('assinatura_atesta_id='.(int)$assinatura_atesta_opcao_atesta);
	$linha=$sql->linha();
	$sql->limpar();
	
	$objResposta->assign("projeto", "innerHTML", ($linha['assinatura_atesta_projeto'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("tarefa", "innerHTML", ($linha['assinatura_atesta_tarefa'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("pratica", "innerHTML", ($linha['assinatura_atesta_pratica'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("acao", "innerHTML", ($linha['assinatura_atesta_acao'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("perspectiva", "innerHTML", ($linha['assinatura_atesta_perspectiva'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("tema", "innerHTML", ($linha['assinatura_atesta_tema'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("objetivo", "innerHTML", ($linha['assinatura_atesta_objetivo'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("estrategia", "innerHTML", ($linha['assinatura_atesta_estrategia'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("fator", "innerHTML", ($linha['assinatura_atesta_fator'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("meta", "innerHTML", ($linha['assinatura_atesta_meta'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("indicador", "innerHTML", ($linha['assinatura_atesta_indicador'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("monitoramento", "innerHTML", ($linha['assinatura_atesta_monitoramento'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("agrupamento", "innerHTML", ($linha['assinatura_atesta_agrupamento'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("patrocinador", "innerHTML", ($linha['assinatura_atesta_patrocinador'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("template", "innerHTML", ($linha['assinatura_atesta_template'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("calendario", "innerHTML", ($linha['assinatura_atesta_calendario'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("instrumento", "innerHTML", ($linha['assinatura_atesta_instrumento'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("recurso", "innerHTML", ($linha['assinatura_atesta_recurso'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("problema", "innerHTML", ($linha['assinatura_atesta_problema'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("demanda", "innerHTML", ($linha['assinatura_atesta_demanda'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("programa", "innerHTML", ($linha['assinatura_atesta_programa'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("licao", "innerHTML", ($linha['assinatura_atesta_licao'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("evento", "innerHTML", ($linha['assinatura_atesta_evento'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("link", "innerHTML", ($linha['assinatura_atesta_link'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("avaliacao", "innerHTML", ($linha['assinatura_atesta_avaliacao'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("tgn", "innerHTML", ($linha['assinatura_atesta_tgn'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("brainstorm", "innerHTML", ($linha['assinatura_atesta_brainstorm'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("gut", "innerHTML", ($linha['assinatura_atesta_gut'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("causa_efeito", "innerHTML", ($linha['assinatura_atesta_causa_efeito'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("arquivo", "innerHTML", ($linha['assinatura_atesta_arquivo'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("forum", "innerHTML", ($linha['assinatura_atesta_forum'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("checklist", "innerHTML", ($linha['assinatura_atesta_checklist'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("agenda", "innerHTML", ($linha['assinatura_atesta_agenda'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("risco", "innerHTML", ($linha['assinatura_atesta_risco'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("risco_resposta", "innerHTML", ($linha['assinatura_atesta_risco_resposta'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("canvas", "innerHTML", ($linha['assinatura_atesta_canvas'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("mswot", "innerHTML", ($linha['assinatura_atesta_mswot'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("swot", "innerHTML", ($linha['assinatura_atesta_swot'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("ata", "innerHTML", ($linha['assinatura_atesta_ata'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("operativo", "innerHTML", ($linha['assinatura_atesta_operativo'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("painel", "innerHTML", ($linha['assinatura_atesta_painel'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("painel_composicao", "innerHTML", ($linha['assinatura_atesta_painel_composicao'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("painel_odometro", "innerHTML", ($linha['assinatura_atesta_painel_odometro'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("tr", "innerHTML", ($linha['assinatura_atesta_tr'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("me", "innerHTML", ($linha['assinatura_atesta_me'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("viabilidade", "innerHTML", ($linha['assinatura_atesta_viabilidade'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	$objResposta->assign("abertura", "innerHTML", ($linha['assinatura_atesta_abertura'] ? '&nbsp;X&nbsp;' : '&nbsp;&nbsp;&nbsp;'));
	return $objResposta;
	}		
$xajax->registerFunction("exibir_opcoes");		


function atualizar_atestas_opcao($assinatura_atesta_opcao_atesta=0){
	global $config;
	$sql = new BDConsulta;
	$sql->adTabela('assinatura_atesta_opcao');
	$sql->adCampo('assinatura_atesta_opcao.*');
	$sql->adOnde('assinatura_atesta_opcao_atesta='.(int)$assinatura_atesta_opcao_atesta);
	$sql->adOrdem('assinatura_atesta_opcao_ordem');
	$atestas_opcao=$sql->ListaChave('assinatura_atesta_opcao_id');
	$sql->limpar();


	$sql->adTabela('assinatura_atesta');
	$sql->adCampo('assinatura_atesta_nome');
	$sql->adOnde('assinatura_atesta_id='.(int)$assinatura_atesta_opcao_atesta);
	$assinatura_atesta_nome=$sql->Resultado();
	$sql->limpar();


	$saida='<h2>'.$assinatura_atesta_nome.'</h2>';
	if (count($atestas_opcao)) {
		$saida.= '<table cellspacing=0 cellpadding=0><tr><td></td><td><table cellspacing=0 cellpadding=0 class="tbl1" align=left><tr><th></th><th>Parecer</th><th>Resultado</th><th></th></tr>';
		foreach ($atestas_opcao as $assinatura_atesta_opcao_id => $linha) {
			$saida.= '<tr align="center">';
			$saida.= '<td nowrap="nowrap" width="40" align="center">';
			$saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_atesta_opcao('.$linha['assinatura_atesta_opcao_ordem'].', '.$linha['assinatura_atesta_opcao_id'].', \'moverPrimeiro\');"><img src="'.acharImagem('icones/2setacima.gif').'" border=0/></a>';
			$saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_atesta_opcao('.$linha['assinatura_atesta_opcao_ordem'].', '.$linha['assinatura_atesta_opcao_id'].', \'moverParaCima\');"><img src="'.acharImagem('icones/1setacima.gif').'" border=0/></a>';
			$saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_atesta_opcao('.$linha['assinatura_atesta_opcao_ordem'].', '.$linha['assinatura_atesta_opcao_id'].', \'moverParaBaixo\');"><img src="'.acharImagem('icones/1setabaixo.gif').'" border=0/></a>';
			$saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_atesta_opcao('.$linha['assinatura_atesta_opcao_ordem'].', '.$linha['assinatura_atesta_opcao_id'].', \'moverUltimo\');"><img src="'.acharImagem('icones/2setabaixo.gif').'" border=0/></a>';
			$saida.= '</td>';
			$saida.= '<td align="left">'.$linha['assinatura_atesta_opcao_nome'].'</td>';
			$saida.= '<td align="center">'.($linha['assinatura_atesta_opcao_aprova']> 0 ? 'Aprova' : 'Reprova').'</td>';
			$saida.= '<td><a href="javascript: void(0);" onclick="editar_atesta_opcao('.$linha['assinatura_atesta_opcao_id'].');">'.imagem('icones/editar.gif').'</a>';
			$saida.= '<a href="javascript: void(0);" onclick="if (confirm(\'Tem certeza que deseja excluir este atestado?\')) {excluir_atesta_opcao('.$linha['assinatura_atesta_opcao_id'].');}">'.imagem('icones/remover.png').'</a></td>';
			$saida.= '</tr>';
			}
		$saida.= '</table></td></tr></table>';
		}
	else 	$saida.= 'Ainda não possui dados';
	return utf8_encode($saida);
	}	

$xajax->registerFunction("atualizar_atestas_opcao");		
	
function editar_atesta_opcao($assinatura_atesta_opcao_id){
	global $config, $Aplic;
	$objResposta = new xajaxResponse();
	$sql = new BDConsulta;
	$sql->adTabela('assinatura_atesta_opcao');
	$sql->adCampo('assinatura_atesta_opcao.*');
	$sql->adOnde('assinatura_atesta_opcao_id = '.(int)$assinatura_atesta_opcao_id);
	$linha=$sql->Linha();
	$sql->limpar();
	$saida='';	
	$objResposta->assign("assinatura_atesta_opcao_id","value", $assinatura_atesta_opcao_id);
	$objResposta->assign("assinatura_atesta_opcao_nome","value", utf8_encode($linha['assinatura_atesta_opcao_nome']));
	$objResposta->assign("assinatura_atesta_opcao_aprova","value", (int)$linha['assinatura_atesta_opcao_aprova']);
	return $objResposta;
	}	
$xajax->registerFunction("editar_atesta_opcao");	







function mudar_posicao_priorizacao($assinatura_atesta_ordem, $assinatura_atesta_id, $direcao){
	//ordenar membro da equipe
	$sql = new BDConsulta;
	if($direcao&&$assinatura_atesta_id) {
		$novo_ui_assinatura_atesta_ordem = $assinatura_atesta_ordem;
		$sql->adTabela('assinatura_atesta');
		$sql->adOnde('assinatura_atesta_id != '.(int)$assinatura_atesta_id);
		$sql->adOrdem('assinatura_atesta_ordem');
		$membros = $sql->Lista();
		$sql->limpar();
		
		if ($direcao == 'moverParaCima') {
			$outro_novo = $novo_ui_assinatura_atesta_ordem;
			$novo_ui_assinatura_atesta_ordem--;
			} 
		elseif ($direcao == 'moverParaBaixo') {
			$outro_novo = $novo_ui_assinatura_atesta_ordem;
			$novo_ui_assinatura_atesta_ordem++;
			} 
		elseif ($direcao == 'moverPrimeiro') {
			$outro_novo = $novo_ui_assinatura_atesta_ordem;
			$novo_ui_assinatura_atesta_ordem = 1;
			} 
		elseif ($direcao == 'moverUltimo') {
			$outro_novo = $novo_ui_assinatura_atesta_ordem;
			$novo_ui_assinatura_atesta_ordem = count($membros) + 1;
			}
		if ($novo_ui_assinatura_atesta_ordem && ($novo_ui_assinatura_atesta_ordem <= count($membros) + 1)) {
			$sql->adTabela('assinatura_atesta');
			$sql->adAtualizar('assinatura_atesta_ordem', $novo_ui_assinatura_atesta_ordem);
			$sql->adOnde('assinatura_atesta_id = '.(int)$assinatura_atesta_id);
			$sql->exec();
			$sql->limpar();
			$idx = 1;
			foreach ($membros as $acao) {
				if ((int)$idx != (int)$novo_ui_assinatura_atesta_ordem) {
					$sql->adTabela('assinatura_atesta');
					$sql->adAtualizar('assinatura_atesta_ordem', $idx);
					$sql->adOnde('assinatura_atesta_id = '.(int)$acao['assinatura_atesta_id']);
					$sql->exec();
					$sql->limpar();
					$idx++;
					} 
				else {
					$sql->adTabela('assinatura_atesta');
					$sql->adAtualizar('assinatura_atesta_ordem', $idx + 1);
					$sql->adOnde('assinatura_atesta_id = '.(int)$acao['assinatura_atesta_id']);
					$sql->exec();
					$sql->limpar();
					$idx = $idx + 2;
					}
				}		
			}
		}
	
	$saida=atualizar_atestas();
	$objResposta = new xajaxResponse();
	$objResposta->assign("atestas","innerHTML", $saida);
	return $objResposta;
	}
$xajax->registerFunction("mudar_posicao_priorizacao");		
	

function incluir_priorizacao(
	$assinatura_atesta_id, 
	$assinatura_atesta_nome,
	$assinatura_atesta_projeto,
	$assinatura_atesta_tarefa,
	$assinatura_atesta_pratica,
	$assinatura_atesta_acao,
	$assinatura_atesta_perspectiva,
	$assinatura_atesta_tema,
	$assinatura_atesta_objetivo,
	$assinatura_atesta_estrategia,
	$assinatura_atesta_fator,
	$assinatura_atesta_meta,
	$assinatura_atesta_indicador,
	$assinatura_atesta_monitoramento,
	$assinatura_atesta_agrupamento,
	$assinatura_atesta_patrocinador,
	$assinatura_atesta_template,
	$assinatura_atesta_calendario,
	$assinatura_atesta_instrumento,
	$assinatura_atesta_recurso,
	$assinatura_atesta_problema,
	$assinatura_atesta_demanda,
	$assinatura_atesta_programa,
	$assinatura_atesta_licao,
	$assinatura_atesta_evento,
	$assinatura_atesta_link,
	$assinatura_atesta_avaliacao,
	$assinatura_atesta_tgn,
	$assinatura_atesta_brainstorm,
	$assinatura_atesta_gut,
	$assinatura_atesta_causa_efeito,
	$assinatura_atesta_arquivo,
	$assinatura_atesta_forum,
	$assinatura_atesta_checklist,
	$assinatura_atesta_agenda,
	$assinatura_atesta_risco,
	$assinatura_atesta_risco_resposta,
	$assinatura_atesta_canvas,
	$assinatura_atesta_mswot,
	$assinatura_atesta_swot,
	$assinatura_atesta_ata,
	$assinatura_atesta_operativo,
	$assinatura_atesta_painel,
	$assinatura_atesta_painel_composicao,
	$assinatura_atesta_painel_odometro,
	$assinatura_atesta_tr,
	$assinatura_atesta_me,
	$assinatura_atesta_viabilidade,
	$assinatura_atesta_abertura
	){
	
	$sql = new BDConsulta;
	$assinatura_atesta_nome=previnirXSS(utf8_decode($assinatura_atesta_nome));

	if ($assinatura_atesta_id){
		$sql->adTabela('assinatura_atesta');
		$sql->adAtualizar('assinatura_atesta_nome', $assinatura_atesta_nome);	
		
		$sql->adAtualizar("assinatura_atesta_projeto", $assinatura_atesta_projeto);
		$sql->adAtualizar("assinatura_atesta_tarefa", $assinatura_atesta_tarefa);
		$sql->adAtualizar("assinatura_atesta_pratica", $assinatura_atesta_pratica);
		$sql->adAtualizar("assinatura_atesta_acao", $assinatura_atesta_acao);
		$sql->adAtualizar("assinatura_atesta_perspectiva", $assinatura_atesta_perspectiva);
		$sql->adAtualizar("assinatura_atesta_tema", $assinatura_atesta_tema);
		$sql->adAtualizar("assinatura_atesta_objetivo", $assinatura_atesta_objetivo);
		$sql->adAtualizar("assinatura_atesta_estrategia", $assinatura_atesta_estrategia);
		$sql->adAtualizar("assinatura_atesta_fator", $assinatura_atesta_fator);
		$sql->adAtualizar("assinatura_atesta_meta", $assinatura_atesta_meta);
		$sql->adAtualizar("assinatura_atesta_indicador", $assinatura_atesta_indicador);
		$sql->adAtualizar("assinatura_atesta_monitoramento", $assinatura_atesta_monitoramento);
		$sql->adAtualizar("assinatura_atesta_agrupamento", $assinatura_atesta_agrupamento);
		$sql->adAtualizar("assinatura_atesta_patrocinador", $assinatura_atesta_patrocinador);
		$sql->adAtualizar("assinatura_atesta_template", $assinatura_atesta_template);
		$sql->adAtualizar("assinatura_atesta_calendario", $assinatura_atesta_calendario);
		$sql->adAtualizar("assinatura_atesta_instrumento", $assinatura_atesta_instrumento);
		$sql->adAtualizar("assinatura_atesta_recurso", $assinatura_atesta_recurso);
		$sql->adAtualizar("assinatura_atesta_problema", $assinatura_atesta_problema);
		$sql->adAtualizar("assinatura_atesta_demanda", $assinatura_atesta_demanda);
		$sql->adAtualizar("assinatura_atesta_programa", $assinatura_atesta_programa);
		$sql->adAtualizar("assinatura_atesta_licao", $assinatura_atesta_licao);
		$sql->adAtualizar("assinatura_atesta_evento", $assinatura_atesta_evento);
		$sql->adAtualizar("assinatura_atesta_link", $assinatura_atesta_link);
		$sql->adAtualizar("assinatura_atesta_avaliacao", $assinatura_atesta_avaliacao);
		$sql->adAtualizar("assinatura_atesta_tgn", $assinatura_atesta_tgn);
		$sql->adAtualizar("assinatura_atesta_brainstorm", $assinatura_atesta_brainstorm);
		$sql->adAtualizar("assinatura_atesta_gut", $assinatura_atesta_gut);
		$sql->adAtualizar("assinatura_atesta_causa_efeito", $assinatura_atesta_causa_efeito);
		$sql->adAtualizar("assinatura_atesta_arquivo", $assinatura_atesta_arquivo);
		$sql->adAtualizar("assinatura_atesta_forum", $assinatura_atesta_forum);
		$sql->adAtualizar("assinatura_atesta_checklist", $assinatura_atesta_checklist);
		$sql->adAtualizar("assinatura_atesta_agenda", $assinatura_atesta_agenda);
		$sql->adAtualizar("assinatura_atesta_risco", $assinatura_atesta_risco);
		$sql->adAtualizar("assinatura_atesta_risco_resposta", $assinatura_atesta_risco_resposta);
		$sql->adAtualizar("assinatura_atesta_canvas", $assinatura_atesta_canvas);
		$sql->adAtualizar("assinatura_atesta_mswot", $assinatura_atesta_mswot);
		$sql->adAtualizar("assinatura_atesta_swot", $assinatura_atesta_swot);
		$sql->adAtualizar("assinatura_atesta_ata", $assinatura_atesta_ata);
		$sql->adAtualizar("assinatura_atesta_operativo", $assinatura_atesta_operativo);
		$sql->adAtualizar("assinatura_atesta_painel", $assinatura_atesta_painel);
		$sql->adAtualizar("assinatura_atesta_painel_composicao", $assinatura_atesta_painel_composicao);
		$sql->adAtualizar("assinatura_atesta_painel_odometro", $assinatura_atesta_painel_odometro);
		$sql->adAtualizar("assinatura_atesta_tr", $assinatura_atesta_tr);
		$sql->adAtualizar("assinatura_atesta_me", $assinatura_atesta_me);
		$sql->adAtualizar("assinatura_atesta_viabilidade", $assinatura_atesta_viabilidade);
		$sql->adAtualizar("assinatura_atesta_abertura", $assinatura_atesta_abertura);
		$sql->adOnde('assinatura_atesta_id ='.(int)$assinatura_atesta_id);
		$sql->exec();
	  $sql->limpar();
		}
	else {	
		$sql->adTabela('assinatura_atesta');
		$sql->adCampo('count(assinatura_atesta_id) AS soma');
	  $soma_total = 1+(int)$sql->Resultado();
	  $sql->limpar();
		$sql->adTabela('assinatura_atesta');
		$sql->adInserir('assinatura_atesta_ordem', $soma_total);
		$sql->adInserir('assinatura_atesta_nome', $assinatura_atesta_nome);	
		
		$sql->adInserir("assinatura_atesta_projeto", $assinatura_atesta_projeto);
		$sql->adInserir("assinatura_atesta_tarefa", $assinatura_atesta_tarefa);
		$sql->adInserir("assinatura_atesta_pratica", $assinatura_atesta_pratica);
		$sql->adInserir("assinatura_atesta_acao", $assinatura_atesta_acao);
		$sql->adInserir("assinatura_atesta_perspectiva", $assinatura_atesta_perspectiva);
		$sql->adInserir("assinatura_atesta_tema", $assinatura_atesta_tema);
		$sql->adInserir("assinatura_atesta_objetivo", $assinatura_atesta_objetivo);
		$sql->adInserir("assinatura_atesta_estrategia", $assinatura_atesta_estrategia);
		$sql->adInserir("assinatura_atesta_fator", $assinatura_atesta_fator);
		$sql->adInserir("assinatura_atesta_meta", $assinatura_atesta_meta);
		$sql->adInserir("assinatura_atesta_indicador", $assinatura_atesta_indicador);
		$sql->adInserir("assinatura_atesta_monitoramento", $assinatura_atesta_monitoramento);
		$sql->adInserir("assinatura_atesta_agrupamento", $assinatura_atesta_agrupamento);
		$sql->adInserir("assinatura_atesta_patrocinador", $assinatura_atesta_patrocinador);
		$sql->adInserir("assinatura_atesta_template", $assinatura_atesta_template);
		$sql->adInserir("assinatura_atesta_calendario", $assinatura_atesta_calendario);
		$sql->adInserir("assinatura_atesta_instrumento", $assinatura_atesta_instrumento);
		$sql->adInserir("assinatura_atesta_recurso", $assinatura_atesta_recurso);
		$sql->adInserir("assinatura_atesta_problema", $assinatura_atesta_problema);
		$sql->adInserir("assinatura_atesta_demanda", $assinatura_atesta_demanda);
		$sql->adInserir("assinatura_atesta_programa", $assinatura_atesta_programa);
		$sql->adInserir("assinatura_atesta_licao", $assinatura_atesta_licao);
		$sql->adInserir("assinatura_atesta_evento", $assinatura_atesta_evento);
		$sql->adInserir("assinatura_atesta_link", $assinatura_atesta_link);
		$sql->adInserir("assinatura_atesta_avaliacao", $assinatura_atesta_avaliacao);
		$sql->adInserir("assinatura_atesta_tgn", $assinatura_atesta_tgn);
		$sql->adInserir("assinatura_atesta_brainstorm", $assinatura_atesta_brainstorm);
		$sql->adInserir("assinatura_atesta_gut", $assinatura_atesta_gut);
		$sql->adInserir("assinatura_atesta_causa_efeito", $assinatura_atesta_causa_efeito);
		$sql->adInserir("assinatura_atesta_arquivo", $assinatura_atesta_arquivo);
		$sql->adInserir("assinatura_atesta_forum", $assinatura_atesta_forum);
		$sql->adInserir("assinatura_atesta_checklist", $assinatura_atesta_checklist);
		$sql->adInserir("assinatura_atesta_agenda", $assinatura_atesta_agenda);
		$sql->adInserir("assinatura_atesta_risco", $assinatura_atesta_risco);
		$sql->adInserir("assinatura_atesta_risco_resposta", $assinatura_atesta_risco_resposta);
		$sql->adInserir("assinatura_atesta_canvas", $assinatura_atesta_canvas);
		$sql->adInserir("assinatura_atesta_mswot", $assinatura_atesta_mswot);
		$sql->adInserir("assinatura_atesta_swot", $assinatura_atesta_swot);
		$sql->adInserir("assinatura_atesta_ata", $assinatura_atesta_ata);
		$sql->adInserir("assinatura_atesta_operativo", $assinatura_atesta_operativo);
		$sql->adInserir("assinatura_atesta_painel", $assinatura_atesta_painel);
		$sql->adInserir("assinatura_atesta_painel_composicao", $assinatura_atesta_painel_composicao);
		$sql->adInserir("assinatura_atesta_painel_odometro", $assinatura_atesta_painel_odometro);
		$sql->adInserir("assinatura_atesta_tr", $assinatura_atesta_tr);
		$sql->adInserir("assinatura_atesta_me", $assinatura_atesta_tr);
		$sql->adInserir("assinatura_atesta_viabilidade", $assinatura_atesta_viabilidade);
		$sql->adInserir("assinatura_atesta_abertura", $assinatura_atesta_abertura);
		$sql->exec();
		}
	$saida=atualizar_atestas();
	$objResposta = new xajaxResponse();
	$objResposta->assign("atestas","innerHTML", $saida);
	return $objResposta;
	}
$xajax->registerFunction("incluir_priorizacao");	


function excluir_priorizacao($assinatura_atesta_id){
	$sql = new BDConsulta;
	$sql->setExcluir('assinatura_atesta');
	$sql->adOnde('assinatura_atesta_id='.(int)$assinatura_atesta_id);
	$sql->exec();
	$saida=atualizar_atestas();
	$objResposta = new xajaxResponse();
	$objResposta->assign("atestas","innerHTML", $saida);
	return $objResposta;
	}

$xajax->registerFunction("excluir_priorizacao");	


function atualizar_atestas(){
	global $config;
	$sql = new BDConsulta;
	$sql->adTabela('assinatura_atesta');
	$sql->adCampo('assinatura_atesta.*');
	$sql->adOrdem('assinatura_atesta_ordem');
	$atestas=$sql->ListaChave('assinatura_atesta_id');
	$sql->limpar();
	$saida='';


	if (count($atestas)) {
		$saida.= '<table cellspacing=0 cellpadding=0><tr><td></td><td><table cellspacing=0 cellpadding=0 class="tbl1" align=left><tr><th></th><th>Tipo de Parecer</th><th></th></tr>';
		foreach ($atestas as $assinatura_atesta_id => $linha) {
			$saida.= '<tr align="center">';
			$saida.= '<td nowrap="nowrap" width="40" align="center">';
			$saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_priorizacao('.$linha['assinatura_atesta_ordem'].', '.$linha['assinatura_atesta_id'].', \'moverPrimeiro\');"><img src="'.acharImagem('icones/2setacima.gif').'" border=0/></a>';
			$saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_priorizacao('.$linha['assinatura_atesta_ordem'].', '.$linha['assinatura_atesta_id'].', \'moverParaCima\');"><img src="'.acharImagem('icones/1setacima.gif').'" border=0/></a>';
			$saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_priorizacao('.$linha['assinatura_atesta_ordem'].', '.$linha['assinatura_atesta_id'].', \'moverParaBaixo\');"><img src="'.acharImagem('icones/1setabaixo.gif').'" border=0/></a>';
			$saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_priorizacao('.$linha['assinatura_atesta_ordem'].', '.$linha['assinatura_atesta_id'].', \'moverUltimo\');"><img src="'.acharImagem('icones/2setabaixo.gif').'" border=0/></a>';
			$saida.= '</td>';
			$saida.= '<td align="left"><a href="javascript:void(0);" onclick="javascript:exibir_opcoes('.$linha['assinatura_atesta_id'].');">'.$linha['assinatura_atesta_nome'].'</a></td>';
			$saida.= '<td><a href="javascript: void(0);" onclick="editar_priorizacao('.$linha['assinatura_atesta_id'].');">'.imagem('icones/editar.gif').'</a>';
			$saida.= '<a href="javascript: void(0);" onclick="if (confirm(\'Tem certeza que deseja excluir este tópico?\')) {excluir_priorizacao('.$linha['assinatura_atesta_id'].');}">'.imagem('icones/remover.png').'</a></td>';
			$saida.= '</tr>';
			}
		$saida.= '</table></td></tr></table>';
		}
	return utf8_encode($saida);
	}	

$xajax->registerFunction("atualizar_atestas");		
	

	
function editar_priorizacao($assinatura_atesta_id){
	global $config, $Aplic;
	$objResposta = new xajaxResponse();
	$sql = new BDConsulta;
	$sql->adTabela('assinatura_atesta');
	$sql->adCampo('assinatura_atesta.*');
	$sql->adOnde('assinatura_atesta_id = '.(int)$assinatura_atesta_id);
	$linha=$sql->Linha();
	$sql->limpar();
	$saida='';	
	$objResposta->assign("assinatura_atesta_id","value", $assinatura_atesta_id);
	$objResposta->assign("assinatura_atesta_nome","value", utf8_encode($linha['assinatura_atesta_nome']));
	$objResposta->assign("assinatura_atesta_projeto", "checked", ($linha['assinatura_atesta_projeto'] ? true : false));
	$objResposta->assign("assinatura_atesta_tarefa", "checked", ($linha['assinatura_atesta_tarefa'] ? true : false));
	$objResposta->assign("assinatura_atesta_pratica", "checked", ($linha['assinatura_atesta_pratica'] ? true : false));
	$objResposta->assign("assinatura_atesta_acao", "checked", ($linha['assinatura_atesta_acao'] ? true : false));
	$objResposta->assign("assinatura_atesta_perspectiva", "checked", ($linha['assinatura_atesta_perspectiva'] ? true : false));
	$objResposta->assign("assinatura_atesta_tema", "checked", ($linha['assinatura_atesta_tema'] ? true : false));
	$objResposta->assign("assinatura_atesta_objetivo", "checked", ($linha['assinatura_atesta_objetivo'] ? true : false));
	$objResposta->assign("assinatura_atesta_estrategia", "checked", ($linha['assinatura_atesta_estrategia'] ? true : false));
	$objResposta->assign("assinatura_atesta_fator", "checked", ($linha['assinatura_atesta_fator'] ? true : false));
	$objResposta->assign("assinatura_atesta_meta", "checked", ($linha['assinatura_atesta_meta'] ? true : false));
	$objResposta->assign("assinatura_atesta_indicador", "checked", ($linha['assinatura_atesta_indicador'] ? true : false));
	$objResposta->assign("assinatura_atesta_monitoramento", "checked", ($linha['assinatura_atesta_monitoramento'] ? true : false));
	$objResposta->assign("assinatura_atesta_agrupamento", "checked", ($linha['assinatura_atesta_agrupamento'] ? true : false));
	$objResposta->assign("assinatura_atesta_patrocinador", "checked", ($linha['assinatura_atesta_patrocinador'] ? true : false));
	$objResposta->assign("assinatura_atesta_template", "checked", ($linha['assinatura_atesta_template'] ? true : false));
	$objResposta->assign("assinatura_atesta_calendario", "checked", ($linha['assinatura_atesta_calendario'] ? true : false));
	$objResposta->assign("assinatura_atesta_instrumento", "checked", ($linha['assinatura_atesta_instrumento'] ? true : false));
	$objResposta->assign("assinatura_atesta_recurso", "checked", ($linha['assinatura_atesta_recurso'] ? true : false));
	$objResposta->assign("assinatura_atesta_problema", "checked", ($linha['assinatura_atesta_problema'] ? true : false));
	$objResposta->assign("assinatura_atesta_demanda", "checked", ($linha['assinatura_atesta_demanda'] ? true : false));
	$objResposta->assign("assinatura_atesta_programa", "checked", ($linha['assinatura_atesta_programa'] ? true : false));
	$objResposta->assign("assinatura_atesta_licao", "checked", ($linha['assinatura_atesta_licao'] ? true : false));
	$objResposta->assign("assinatura_atesta_evento", "checked", ($linha['assinatura_atesta_evento'] ? true : false));
	$objResposta->assign("assinatura_atesta_link", "checked", ($linha['assinatura_atesta_link'] ? true : false));
	$objResposta->assign("assinatura_atesta_avaliacao", "checked", ($linha['assinatura_atesta_avaliacao'] ? true : false));
	$objResposta->assign("assinatura_atesta_tgn", "checked", ($linha['assinatura_atesta_tgn'] ? true : false));
	$objResposta->assign("assinatura_atesta_brainstorm", "checked", ($linha['assinatura_atesta_brainstorm'] ? true : false));
	$objResposta->assign("assinatura_atesta_gut", "checked", ($linha['assinatura_atesta_gut'] ? true : false));
	$objResposta->assign("assinatura_atesta_causa_efeito", "checked", ($linha['assinatura_atesta_causa_efeito'] ? true : false));
	$objResposta->assign("assinatura_atesta_arquivo", "checked", ($linha['assinatura_atesta_arquivo'] ? true : false));
	$objResposta->assign("assinatura_atesta_forum", "checked", ($linha['assinatura_atesta_forum'] ? true : false));
	$objResposta->assign("assinatura_atesta_checklist", "checked", ($linha['assinatura_atesta_checklist'] ? true : false));
	$objResposta->assign("assinatura_atesta_agenda", "checked", ($linha['assinatura_atesta_agenda'] ? true : false));
	$objResposta->assign("assinatura_atesta_risco", "checked", ($linha['assinatura_atesta_risco'] ? true : false));
	$objResposta->assign("assinatura_atesta_risco_resposta", "checked", ($linha['assinatura_atesta_risco_resposta'] ? true : false));
	$objResposta->assign("assinatura_atesta_canvas", "checked", ($linha['assinatura_atesta_canvas'] ? true : false));
	$objResposta->assign("assinatura_atesta_mswot", "checked", ($linha['assinatura_atesta_mswot'] ? true : false));
	$objResposta->assign("assinatura_atesta_swot", "checked", ($linha['assinatura_atesta_swot'] ? true : false));
	$objResposta->assign("assinatura_atesta_ata", "checked", ($linha['assinatura_atesta_ata'] ? true : false));
	$objResposta->assign("assinatura_atesta_operativo", "checked", ($linha['assinatura_atesta_operativo'] ? true : false));
	$objResposta->assign("assinatura_atesta_painel", "checked", ($linha['assinatura_atesta_painel'] ? true : false));
	$objResposta->assign("assinatura_atesta_painel_composicao", "checked", ($linha['assinatura_atesta_painel_composicao'] ? true : false));
	$objResposta->assign("assinatura_atesta_painel_odometro", "checked", ($linha['assinatura_atesta_painel_odometro'] ? true : false));
	$objResposta->assign("assinatura_atesta_tr", "checked", ($linha['assinatura_atesta_tr'] ? true : false));
	$objResposta->assign("assinatura_atesta_me", "checked", ($linha['assinatura_atesta_me'] ? true : false));
	$objResposta->assign("assinatura_atesta_viabilidade", "checked", ($linha['assinatura_atesta_viabilidade'] ? true : false));
	$objResposta->assign("assinatura_atesta_abertura", "checked", ($linha['assinatura_atesta_abertura'] ? true : false));
	return $objResposta;
	}	
$xajax->registerFunction("editar_priorizacao");	




$xajax->processRequest();

?>