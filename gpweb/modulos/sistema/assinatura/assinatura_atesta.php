<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb profissional - registrado no INPI sob o número RS 11802-5 e protegido pelo direito de autor. 
É expressamente proibido utilizar este script em parte ou no todo sem o expresso consentimento do autor.
*/
$botoesTitulo = new CBlocoTitulo('Parecer', 'log.png', $m, $m.'.'.$a);
$botoesTitulo->adicionaBotao('m=sistema', 'sistema','','Administração do Sistema','Voltar à tela de Administração do Sistema.');
$botoesTitulo->mostrar();
if (!$dialogo) $Aplic->salvarPosicao();


echo '
<style type="text/css">
div.vertical
{
 margin-left: -100px;
 margin-top: -10px;
 position: absolute;
 width: 215px;
 transform: rotate(-90deg);
 -webkit-transform: rotate(-90deg); /* Safari/Chrome */
 -moz-transform: rotate(-90deg); /* Firefox */
 -o-transform: rotate(-90deg); /* Opera */
 -ms-transform: rotate(-90deg); /* IE 9 */
}

th.vertical
{
 height: 215px;
}
</style>';

echo '<form name="env" method="post">';	
echo '<input type="hidden" name="apoio1" id="apoio1" value="" />';	
echo '<input type="hidden" id="assinatura_atesta_id" name="assinatura_atesta_id" value="" />';
	
echo estiloTopoCaixa();
echo '<table cellspacing=0 cellpadding=0 border=0 width="100%" class="std">';
echo '<tr><td colspan=20><table cellspacing=0 cellpadding=0>';
echo '<tr><td><table cellspacing=0 cellpadding=0>';
echo '<tr><td><table cellspacing=0 cellpadding=0>';
echo '<tr><td align="right">'.dica('Tipo de Parecer', 'Nome do tipo de parecer para a assinatura.').'Tipo de Parecer:'.dicaF().'</td><td colspan="2"><input type="text" class="texto" id="assinatura_atesta_nome" name="assinatura_atesta_nome" value="" style="width:400px;" /></td></tr>';
echo '</table></td>';
echo '<td id="adicionar_priorizacao" style="display:"><a href="javascript: void(0);" onclick="incluir_priorizacao();">'.imagem('icones/adicionar_g.png','Incluir','Clique neste ícone '.imagem('icones/adicionar.png').' para incluir o priorizacao.').'</a></td>';
echo '<td id="confirmar_priorizacao" style="display:none"><a href="javascript: void(0);" onclick="limpar_priorizacao();">'.imagem('icones/cancelar_g.png','Cancelar','Clique neste ícone '.imagem('icones/cancelar.png').' para cancelar a edição do priorizacao.').'</a><a href="javascript: void(0);" onclick="incluir_priorizacao();">'.imagem('icones/ok_g.png','Confirmar','Clique neste ícone '.imagem('icones/ok.png').' para confirmar a edição do priorizacao.').'</a></td>';
echo '</tr>';
echo '</table></td></tr>';








echo '<tr><td colspan=20><table cellspacing=0 cellpadding=0>';
echo '<tr>';
$coluna=array();
$coluna[strtolower($config['projeto'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['projeto']), 'Caso a questão seja específica de '.ucfirst($config['projeto']).'.').ucfirst($config['projeto']).dicaF().'</div></th>';
$coluna[strtolower($config['tarefa'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['tarefa']), 'Caso a questão seja específica de '.$config['tarefa'].'.').ucfirst($config['tarefa']).dicaF().'</div></th>';
$coluna[strtolower($config['pratica'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['pratica']), 'Caso a questão seja específica de '.$config['pratica'].'.').ucfirst($config['pratica']).dicaF().'</div></th>';
$coluna[strtolower($config['acao'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['acao']), 'Caso a questão seja específica de '.$config['acao'].'.').ucfirst($config['acao']).dicaF().'</div></th>';
$coluna[strtolower($config['perspectiva'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['perspectiva']), 'Caso a questão seja específica de '.$config['perspectiva'].'.').ucfirst($config['perspectiva']).dicaF().'</div></th>';
$coluna[strtolower($config['tema'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['tema']), 'Caso a questão seja específica de '.$config['tema'].'.').ucfirst($config['tema']).dicaF().'</div></th>';
$coluna[strtolower($config['objetivo'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['objetivo']), 'Caso a questão seja específica de '.$config['objetivo'].'.').ucfirst($config['objetivo']).dicaF().'</div></th>';
$coluna[strtolower($config['iniciativa'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['iniciativa']), 'Caso a questão seja específica de '.$config['iniciativa'].'.').ucfirst($config['iniciativa']).dicaF().'</div></th>';
$coluna[strtolower($config['fator'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['fator']), 'Caso a questão seja específica de '.$config['fator'].'.').ucfirst($config['fator']).dicaF().'</div></th>';
$coluna[strtolower($config['meta'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['meta']), 'Caso a questão seja específica de '.$config['meta'].'.').ucfirst($config['meta']).dicaF().'</div></th>';
$coluna['indicador']='<th class="vertical"><div class="vertical" align=left>'.dica('Indicador', 'Caso a questão seja específica de indicador.').'Indicador'.dicaF().'</div></th>';
$coluna['monitoramento']='<th class="vertical"><div class="vertical" align=left>'.dica('Monitoramento', 'Caso a questão seja específica de monitoramento.').'Monitoramento'.dicaF().'</div></th>';
$coluna['agrupamento']='<th class="vertical"><div class="vertical" align=left>'.dica('Agrupamento', 'Caso a questão seja específica de agrupamento.').'Agrupamento'.dicaF().'</div></th>';
$coluna['patrocinador']='<th class="vertical"><div class="vertical" align=left>'.dica('Patrocinador', 'Caso a questão seja específica de patrocinador.').'Patrocinador'.dicaF().'</div></th>';
$coluna['modelo']='<th class="vertical"><div class="vertical" align=left>'.dica('Modelo', 'Caso a questão seja específica de modelo.').'Modelo'.dicaF().'</div></th>';
$coluna['agenda']='<th class="vertical"><div class="vertical" align=left>'.dica('Agenda', 'Caso a questão seja específica de agenda.').'Agenda'.dicaF().'</div></th>';
$coluna[strtolower($config['instrumento'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['instrumento']), 'Caso a questão seja específica de '.$config['instrumento'].'.').ucfirst($config['instrumento']).dicaF().'</div></th>';
$coluna[strtolower($config['recurso'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['recurso']), 'Caso a questão seja específica de '.$config['recurso'].'.').ucfirst($config['recurso']).dicaF().'</div></th>';
$coluna[strtolower($config['problema'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['problema']), 'Caso a questão seja específica de '.$config['problema'].'.').ucfirst($config['problema']).dicaF().'</div></th>';
$coluna['demanda']='<th class="vertical"><div class="vertical" align=left>'.dica('Demanda', 'Caso a questão seja específica de demanda.').'Demanda'.dicaF().'</div></th>';
$coluna[strtolower($config['programa'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['programa']), 'Caso a questão seja específica de '.$config['programa'].'.').ucfirst($config['programa']).dicaF().'</div></th>';
$coluna[strtolower($config['licao'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['licao']), 'Caso a questão seja específica de lição aprendida.').'Lição Aprendida'.dicaF().'</div></th>';
$coluna['evento']='<th class="vertical"><div class="vertical" align=left>'.dica('Evento', 'Caso a questão seja específica de evento.').'Evento'.dicaF().'</div></th>';
$coluna['link']='<th class="vertical"><div class="vertical" align=left>'.dica('link', 'Caso a questão seja específica de link.').'Link'.dicaF().'</div></th>';
$coluna['avaliação']='<th class="vertical"><div class="vertical" align=left>'.dica('Avaliação', 'Caso a questão seja específica de avaliação.').'Avaliação'.dicaF().'</div></th>';
$coluna[strtolower($config['tgn'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['tgn']), 'Caso a questão seja específica de '.$config['tgn'].'.').ucfirst($config['tgn']).dicaF().'</div></th>';
$coluna['brainstorm']='<th class="vertical"><div class="vertical" align=left>'.dica('Brainstorm', 'Caso a questão seja específica de brainstorm.').'Brainstorm'.dicaF().'</div></th>';
$coluna['matriz G.U.T.']='<th class="vertical"><div class="vertical" align=left>'.dica('Matriz G.U.T.', 'Caso a questão seja específica de matriz G.U.T..').'Matriz G.U.T.'.dicaF().'</div></th>';
$coluna['diagrama de Cusa-Efeito']='<th class="vertical"><div class="vertical" align=left>'.dica('Diagrama de Cusa-Efeito', 'Caso a questão seja específica de diagrama de causa-efeito.').'Diagrama de Cusa-Efeito'.dicaF().'</div></th>';
$coluna['arquivo']='<th class="vertical"><div class="vertical" align=left>'.dica('Arquivo', 'Caso a questão seja específica de arquivo.').'Arquivo'.dicaF().'</div></th>';
$coluna['fórum']='<th class="vertical"><div class="vertical" align=left>'.dica('Fórum', 'Caso a questão seja específica de fórum.').'Fórum'.dicaF().'</div></th>';
$coluna['checklist']='<th class="vertical"><div class="vertical" align=left>'.dica('Checklist', 'Caso a questão seja específica de checklist.').'Checklist'.dicaF().'</div></th>';
$coluna['compromisso']='<th class="vertical"><div class="vertical" align=left>'.dica('Compromisso', 'Caso a questão seja específica de compromisso.').'Compromisso'.dicaF().'</div></th>';
$coluna[strtolower($config['risco'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['risco']), 'Caso a questão seja específica de '.$config['risco'].'.').ucfirst($config['risco']).dicaF().'</div></th>';
$coluna[strtolower($config['risco_resposta'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['risco_resposta']), 'Caso a questão seja específica de '.$config['risco_resposta'].'.').ucfirst($config['risco_resposta']).dicaF().'</div></th>';
$coluna[strtolower($config['canvas'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['canvas']), 'Caso a questão seja específica de '.$config['canvas'].'.').ucfirst($config['canvas']).dicaF().'</div></th>';
$coluna['matriz SWOT']='<th class="vertical"><div class="vertical" align=left>'.dica('Matriz SWOT', 'Caso a questão seja específica de uma matriz SWOT.').'Matriz SWOT'.dicaF().'</div></th>';
$coluna['campo SWOT']='<th class="vertical"><div class="vertical" align=left>'.dica('Campo SWOT', 'Caso a questão seja específica de campo de matriz SWOT.').'Campo SWOT'.dicaF().'</div></th>';
$coluna['ata de Reunião']='<th class="vertical"><div class="vertical" align=left>'.dica('Ata de Reunião', 'Caso a questão seja específica de ata de reunião.').'Ata de Reunião'.dicaF().'</div></th>';
$coluna['plano operativo']='<th class="vertical"><div class="vertical" align=left>'.dica('Plano operativo', 'Caso a questão seja específica de plano operativo.').'Plano Operativo'.dicaF().'</div></th>';
$coluna['painel de indicador']='<th class="vertical"><div class="vertical" align=left>'.dica('Painel de Indicador', 'Caso a questão seja específica de painel de indicador.').'Painel de Indicador'.dicaF().'</div></th>';
$coluna['composição de painéis']='<th class="vertical"><div class="vertical" align=left>'.dica('Composição de Painéi', 'Caso a questão seja específica de composição de painéia.').'Composição de Painéis'.dicaF().'</div></th>';
$coluna['odômetro']='<th class="vertical"><div class="vertical" align=left>'.dica('Odômetro', 'Caso a questão seja específica de termo de odômetro.').'Odômetro'.dicaF().'</div></th>';
$coluna[strtolower($config['tr'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['tr']), 'Caso a questão seja específica de '.$config['tr'].'.').ucfirst($config['tr']).dicaF().'</div></th>';
$coluna[strtolower($config['me'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['me']), 'Caso a questão seja específica de '.$config['me'].'.').ucfirst($config['me']).dicaF().'</div></th>';
$coluna['estudo de Viabilidade']='<th class="vertical"><div class="vertical" align=left>'.dica('Estudo de Viabilidade', 'Caso a questão seja específica de estudo de viabilidade.').'Estudo de Viabilidade'.dicaF().'</div></th>';
$coluna['termo de Abertura']='<th class="vertical"><div class="vertical" align=left>'.dica('Termo de Abertura', 'Caso a questão seja específica de termo de abertura.').'Termo de Abertura'.dicaF().'</div></th>';

ksort($coluna);
foreach($coluna as $valor) echo $valor;
echo '</tr>';
echo '<tr>';
$coluna=array();
$coluna[strtolower($config['projeto'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_projeto" id="assinatura_atesta_projeto" /></td>';
$coluna[strtolower($config['tarefa'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_tarefa" id="assinatura_atesta_tarefa" /></td>';
$coluna[strtolower($config['pratica'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_pratica" id="assinatura_atesta_pratica" /></td>';
$coluna[strtolower($config['acao'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_acao" id="assinatura_atesta_acao" /></td>';
$coluna[strtolower($config['perspectiva'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_perspectiva" id="assinatura_atesta_perspectiva" /></td>';
$coluna[strtolower($config['tema'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_tema" id="assinatura_atesta_tema" /></td>';
$coluna[strtolower($config['objetivo'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_objetivo" id="assinatura_atesta_objetivo" /></td>';
$coluna[strtolower($config['iniciativa'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_estrategia" id="assinatura_atesta_estrategia" /></td>';
$coluna[strtolower($config['fator'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_fator" id="assinatura_atesta_fator" /></td>';
$coluna[strtolower($config['meta'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_meta" id="assinatura_atesta_meta" /></td>';
$coluna['indicador']='<td><input type="checkbox" value="1" name="assinatura_atesta_indicador" id="assinatura_atesta_indicador" /></td>';
$coluna['monitoramento']='<td><input type="checkbox" value="1" name="assinatura_atesta_monitoramento" id="assinatura_atesta_monitoramento" /></td>';
$coluna['agrupamento']='<td><input type="checkbox" value="1" name="assinatura_atesta_agrupamento" id="assinatura_atesta_agrupamento" /></td>';
$coluna['patrocinador']='<td><input type="checkbox" value="1" name="assinatura_atesta_patrocinador" id="assinatura_atesta_patrocinador" /></td>';
$coluna['modelo']='<td><input type="checkbox" value="1" name="assinatura_atesta_template" id="assinatura_atesta_template" /></td>';
$coluna['agenda']='<td><input type="checkbox" value="1" name="assinatura_atesta_calendario" id="assinatura_atesta_calendario" /></td>';
$coluna[strtolower($config['instrumento'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_instrumento" id="assinatura_atesta_instrumento" /></td>';
$coluna[strtolower($config['recurso'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_recurso" id="assinatura_atesta_recurso" /></td>';
$coluna[strtolower($config['problema'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_problema" id="assinatura_atesta_problema" /></td>';
$coluna['demanda']='<td><input type="checkbox" value="1" name="assinatura_atesta_demanda" id="assinatura_atesta_demanda" /></td>';
$coluna[strtolower($config['programa'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_programa" id="assinatura_atesta_programa" /></td>';
$coluna[strtolower($config['licao'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_licao" id="assinatura_atesta_licao" /></td>';
$coluna['evento']='<td><input type="checkbox" value="1" name="assinatura_atesta_evento" id="assinatura_atesta_evento" /></td>';
$coluna['link']='<td><input type="checkbox" value="1" name="assinatura_atesta_link" id="assinatura_atesta_link" /></td>';
$coluna['avaliação']='<td><input type="checkbox" value="1" name="assinatura_atesta_avaliacao" id="assinatura_atesta_avaliacao" /></td>';
$coluna[strtolower($config['tgn'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_tgn" id="assinatura_atesta_tgn" /></td>';
$coluna['brainstorm']='<td><input type="checkbox" value="1" name="assinatura_atesta_brainstorm" id="assinatura_atesta_brainstorm" /></td>';
$coluna['matriz G.U.T.']='<td><input type="checkbox" value="1" name="assinatura_atesta_gut" id="assinatura_atesta_gut" /></td>';
$coluna['diagrama de Cusa-Efeito']='<td><input type="checkbox" value="1" name="assinatura_atesta_causa_efeito" id="assinatura_atesta_causa_efeito" /></td>';
$coluna['arquivo']='<td><input type="checkbox" value="1" name="assinatura_atesta_arquivo" id="assinatura_atesta_arquivo" /></td>';
$coluna['fórum']='<td><input type="checkbox" value="1" name="assinatura_atesta_forum" id="assinatura_atesta_forum" /></td>';
$coluna['checklist']='<td><input type="checkbox" value="1" name="assinatura_atesta_checklist" id="assinatura_atesta_checklist" /></td>';
$coluna['compromisso']='<td><input type="checkbox" value="1" name="assinatura_atesta_agenda" id="assinatura_atesta_agenda" /></td>';
$coluna[strtolower($config['risco'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_risco" id="assinatura_atesta_risco" /></td>';
$coluna[strtolower($config['risco_resposta'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_risco_resposta" id="assinatura_atesta_risco_resposta" /></td>';
$coluna[strtolower($config['canvas'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_canvas" id="assinatura_atesta_canvas" /></td>';
$coluna['matriz SWOT']='<td><input type="checkbox" value="1" name="assinatura_atesta_mswot" id="assinatura_atesta_mswot" /></td>';
$coluna['campo SWOT']='<td><input type="checkbox" value="1" name="assinatura_atesta_swot" id="assinatura_atesta_swot" /></td>';
$coluna['ata de Reunião']='<td><input type="checkbox" value="1" name="assinatura_atesta_ata" id="assinatura_atesta_ata" /></td>';
$coluna['plano operativo']='<td><input type="checkbox" value="1" name="assinatura_atesta_operativo" id="assinatura_atesta_operativo" /></td>';
$coluna['painel de indicador']='<td><input type="checkbox" value="1" name="assinatura_atesta_painel" id="assinatura_atesta_painel" /></td>';
$coluna['composição de painéis']='<td><input type="checkbox" value="1" name="assinatura_atesta_painel_composicao" id="assinatura_atesta_painel_composicao" /></td>';
$coluna['odômetro']='<td><input type="checkbox" value="1" name="assinatura_atesta_painel_odometro" id="assinatura_atesta_painel_odometro" /></td>';
$coluna[strtolower($config['tr'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_tr" id="assinatura_atesta_tr" /></td>';
$coluna[strtolower($config['me'])]='<td><input type="checkbox" value="1" name="assinatura_atesta_me" id="assinatura_atesta_me" /></td>';
$coluna['estudo de Viabilidade']='<td><input type="checkbox" value="1" name="assinatura_atesta_viabilidade" id="assinatura_atesta_viabilidade" /></td>';
$coluna['termo de Abertura']='<td><input type="checkbox" value="1" name="assinatura_atesta_abertura" id="assinatura_atesta_abertura" /></td>';
ksort($coluna);
foreach($coluna as $valor) echo $valor;
echo '</tr>';
echo '</table></td></tr>';














echo '<tr><td colspan=20><table cellspacing=0 cellpadding=0><tr><td align=left><div id="atestas">';
$sql = new BDConsulta;
$sql->adTabela('assinatura_atesta');
$sql->adCampo('assinatura_atesta.*');
$sql->adOrdem('assinatura_atesta_ordem');
$atestas=$sql->ListaChave('assinatura_atesta_id');
$sql->limpar();
if (count($atestas)) {
	echo '<table cellspacing=0 cellpadding=0><tr><td></td><td><table cellspacing=0 cellpadding=0 class="tbl1" align=left><tr><th></th><th>Tipo de Parecer</th><th></th></tr>';
	foreach ($atestas as $assinatura_atesta_id => $linha) {
		echo '<tr align="center">';
		echo '<td nowrap="nowrap" width="40" align="center">';
		echo '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_priorizacao('.$linha['assinatura_atesta_ordem'].', '.$linha['assinatura_atesta_id'].', \'moverPrimeiro\');"><img src="'.acharImagem('icones/2setacima.gif').'" border=0/></a>';
		echo '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_priorizacao('.$linha['assinatura_atesta_ordem'].', '.$linha['assinatura_atesta_id'].', \'moverParaCima\');"><img src="'.acharImagem('icones/1setacima.gif').'" border=0/></a>';
		echo '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_priorizacao('.$linha['assinatura_atesta_ordem'].', '.$linha['assinatura_atesta_id'].', \'moverParaBaixo\');"><img src="'.acharImagem('icones/1setabaixo.gif').'" border=0/></a>';
		echo '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_priorizacao('.$linha['assinatura_atesta_ordem'].', '.$linha['assinatura_atesta_id'].', \'moverUltimo\');"><img src="'.acharImagem('icones/2setabaixo.gif').'" border=0/></a>';
		echo '</td>';
		echo '<td align="left"><a href="javascript:void(0);" onclick="javascript:exibir_opcoes('.$linha['assinatura_atesta_id'].');">'.$linha['assinatura_atesta_nome'].'</a></td>';
		echo '<td><a href="javascript: void(0);" onclick="editar_priorizacao('.$linha['assinatura_atesta_id'].');">'.imagem('icones/editar.gif').'</a>';
		echo '<a href="javascript: void(0);" onclick="if (confirm(\'Tem certeza que deseja excluir este tópico?\')) {excluir_priorizacao('.$linha['assinatura_atesta_id'].');}">'.imagem('icones/remover.png').'</a></td>';
		echo '</tr>';
		}
	echo '</table></td></tr></table>';
	}

echo '</div></td></tr></table></td></tr></table></td></tr>';	  








echo '<tr><td colspan=20><table cellspacing=0 cellpadding=0 class="tbl1" id="colunas">';

echo '<tr>';
$coluna=array();
$coluna[strtolower($config['projeto'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['projeto']), 'Caso a questão seja específica de '.ucfirst($config['projeto']).'.').ucfirst($config['projeto']).dicaF().'</th>';
$coluna[strtolower($config['tarefa'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['tarefa']), 'Caso a questão seja específica de '.$config['tarefa'].'.').ucfirst($config['tarefa']).dicaF().'</th>';
$coluna[strtolower($config['pratica'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['pratica']), 'Caso a questão seja específica de '.$config['pratica'].'.').ucfirst($config['pratica']).dicaF().'</th>';
$coluna[strtolower($config['acao'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['acao']), 'Caso a questão seja específica de '.$config['acao'].'.').ucfirst($config['acao']).dicaF().'</th>';
$coluna[strtolower($config['perspectiva'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['perspectiva']), 'Caso a questão seja específica de '.$config['perspectiva'].'.').ucfirst($config['perspectiva']).dicaF().'</td>';
$coluna[strtolower($config['tema'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['tema']), 'Caso a questão seja específica de '.$config['tema'].'.').ucfirst($config['tema']).dicaF().'</th>';
$coluna[strtolower($config['objetivo'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['objetivo']), 'Caso a questão seja específica de '.$config['objetivo'].'.').ucfirst($config['objetivo']).dicaF().'</th>';
$coluna[strtolower($config['iniciativa'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['iniciativa']), 'Caso a questão seja específica de '.$config['iniciativa'].'.').ucfirst($config['iniciativa']).dicaF().'</th>';
$coluna[strtolower($config['fator'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['fator']), 'Caso a questão seja específica de '.$config['fator'].'.').ucfirst($config['fator']).dicaF().'</th>';
$coluna[strtolower($config['meta'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['meta']), 'Caso a questão seja específica de '.$config['meta'].'.').ucfirst($config['meta']).dicaF().'</th>';
$coluna['indicador']='<th class="vertical"><div class="vertical" align=left>'.dica('Indicador', 'Caso a questão seja específica de indicador.').'Indicador'.dicaF().'</th>';
$coluna['monitoramento']='<th class="vertical"><div class="vertical" align=left>'.dica('Monitoramento', 'Caso a questão seja específica de monitoramento.').'Monitoramento'.dicaF().'</th>';
$coluna['agrupamento']='<th class="vertical"><div class="vertical" align=left>'.dica('Agrupamento', 'Caso a questão seja específica de agrupamento.').'Agrupamento'.dicaF().'</th>';
$coluna['patrocinador']='<th class="vertical"><div class="vertical" align=left>'.dica('Patrocinador', 'Caso a questão seja específica de patrocinador.').'Patrocinador'.dicaF().'</th>';
$coluna['modelo']='<th class="vertical"><div class="vertical" align=left>'.dica('Modelo', 'Caso a questão seja específica de modelo.').'Modelo'.dicaF().'</th>';
$coluna['agenda']='<th class="vertical"><div class="vertical" align=left>'.dica('Agenda', 'Caso a questão seja específica de agenda.').'Agenda'.dicaF().'</th>';
$coluna[strtolower($config['instrumento'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['instrumento']), 'Caso a questão seja específica de '.$config['instrumento'].'.').ucfirst($config['instrumento']).dicaF().'</th>';
$coluna[strtolower($config['recurso'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['recurso']), 'Caso a questão seja específica de '.$config['recurso'].'.').ucfirst($config['recurso']).dicaF().'</th>';
$coluna[strtolower($config['problema'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['problema']), 'Caso a questão seja específica de '.$config['problema'].'.').ucfirst($config['problema']).dicaF().'</th>';
$coluna['demanda']='<th class="vertical"><div class="vertical" align=left>'.dica('Demanda', 'Caso a questão seja específica de demanda.').'Demanda'.dicaF().'</th>';
$coluna[strtolower($config['programa'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['programa']), 'Caso a questão seja específica de '.$config['programa'].'.').ucfirst($config['programa']).dicaF().'</th>';
$coluna[strtolower($config['licao'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['licao']), 'Caso a questão seja específica de lição aprendida.').'Lição Aprendida'.dicaF().'</th>';
$coluna['evento']='<th class="vertical"><div class="vertical" align=left>'.dica('Evento', 'Caso a questão seja específica de evento.').'Evento'.dicaF().'</th>';
$coluna['link']='<th class="vertical"><div class="vertical" align=left>'.dica('link', 'Caso a questão seja específica de link.').'Link'.dicaF().'</th>';
$coluna['avaliação']='<th class="vertical"><div class="vertical" align=left>'.dica('Avaliação', 'Caso a questão seja específica de avaliação.').'Avaliação'.dicaF().'</th>';
$coluna[strtolower($config['tgn'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['tgn']), 'Caso a questão seja específica de '.$config['tgn'].'.').ucfirst($config['tgn']).dicaF().'</th>';
$coluna['brainstorm']='<th class="vertical"><div class="vertical" align=left>'.dica('Brainstorm', 'Caso a questão seja específica de brainstorm.').'Brainstorm'.dicaF().'</th>';
$coluna['matriz G.U.T.']='<th class="vertical"><div class="vertical" align=left>'.dica('Matriz G.U.T.', 'Caso a questão seja específica de matriz G.U.T..').'Matriz G.U.T.'.dicaF().'</th>';
$coluna['diagrama de Cusa-Efeito']='<th class="vertical"><div class="vertical" align=left>'.dica('Diagrama de Cusa-Efeito', 'Caso a questão seja específica de diagrama de causa-efeito.').'Diagrama de Cusa-Efeito'.dicaF().'</th>';
$coluna['arquivo']='<th class="vertical"><div class="vertical" align=left>'.dica('Arquivo', 'Caso a questão seja específica de arquivo.').'Arquivo'.dicaF().'</th>';
$coluna['fórum']='<th class="vertical"><div class="vertical" align=left>'.dica('Fórum', 'Caso a questão seja específica de fórum.').'Fórum'.dicaF().'</th>';
$coluna['checklist']='<th class="vertical"><div class="vertical" align=left>'.dica('Checklist', 'Caso a questão seja específica de checklist.').'Checklist'.dicaF().'</th>';
$coluna['compromisso']='<th class="vertical"><div class="vertical" align=left>'.dica('Compromisso', 'Caso a questão seja específica de compromisso.').'Compromisso'.dicaF().'</th>';
$coluna[strtolower($config['risco'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['risco']), 'Caso a questão seja específica de '.$config['risco'].'.').ucfirst($config['risco']).dicaF().'</th>';
$coluna[strtolower($config['risco_resposta'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['risco_resposta']), 'Caso a questão seja específica de '.$config['risco_resposta'].'.').ucfirst($config['risco_resposta']).dicaF().'</th>';
$coluna[strtolower($config['canvas'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['canvas']), 'Caso a questão seja específica de '.$config['canvas'].'.').ucfirst($config['canvas']).dicaF().'</th>';
$coluna['matriz SWOT']='<th class="vertical"><div class="vertical" align=left>'.dica('Matriz SWOT', 'Caso a questão seja específica de uma matriz SWOT.').'Matriz SWOT'.dicaF().'</th>';
$coluna['campo SWOT']='<th class="vertical"><div class="vertical" align=left>'.dica('Campo SWOT', 'Caso a questão seja específica de campo de matriz SWOT.').'Campo SWOT'.dicaF().'</th>';
$coluna['ata de Reunião']='<th class="vertical"><div class="vertical" align=left>'.dica('Ata de Reunião', 'Caso a questão seja específica de ata de reunião.').'Ata de Reunião'.dicaF().'</th>';
$coluna['plano operativo']='<th class="vertical"><div class="vertical" align=left>'.dica('Plano operativo', 'Caso a questão seja específica de plano operativo.').'Plano Operativo'.dicaF().'</th>';
$coluna['painel de indicador']='<th class="vertical"><div class="vertical" align=left>'.dica('Painel de Indicador', 'Caso a questão seja específica de painel de indicador.').'Painel de Indicador'.dicaF().'</th>';
$coluna['composição de painéis']='<th class="vertical"><div class="vertical" align=left>'.dica('Composição de Painéi', 'Caso a questão seja específica de composição de painéia.').'Composição de Painéis'.dicaF().'</th>';
$coluna['odômetro']='<th class="vertical"><div class="vertical" align=left>'.dica('Odômetro', 'Caso a questão seja específica de termo de odômetro.').'Odômetro'.dicaF().'</th>';
$coluna[strtolower($config['tr'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['tr']), 'Caso a questão seja específica de '.$config['tr'].'.').ucfirst($config['tr']).dicaF().'</th>';
$coluna[strtolower($config['me'])]='<th class="vertical"><div class="vertical" align=left>'.dica(ucfirst($config['me']), 'Caso a questão seja específica de '.$config['me'].'.').ucfirst($config['me']).dicaF().'</th>';
$coluna['estudo de Viabilidade']='<th class="vertical"><div class="vertical" align=left>'.dica('Estudo de Viabilidade', 'Caso a questão seja específica de estudo de viabilidade.').'Estudo de Viabilidade'.dicaF().'</th>';
$coluna['termo de Abertura']='<th class="vertical"><div class="vertical" align=left>'.dica('Termo de Abertura', 'Caso a questão seja específica de termo de abertura.').'Termo de Abertura'.dicaF().'</th>';



ksort($coluna);
foreach($coluna as $valor) echo $valor;
echo '</tr>';
echo '<tr>';
$coluna=array();
$coluna[strtolower($config['projeto'])]='<td><div name="projeto" id="projeto">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['tarefa'])]='<td><div name="tarefa" id="tarefa">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['pratica'])]='<td><div name="pratica" id="pratica">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['acao'])]='<td><div name="acao" id="acao">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['perspectiva'])]='<td><div name="perspectiva" id="perspectiva">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['tema'])]='<td><div name="tema" id="tema">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['objetivo'])]='<td><div name="objetivo" id="objetivo">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['iniciativa'])]='<td><div name="estrategia" id="estrategia">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['fator'])]='<td><div name="fator" id="fator">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['meta'])]='<td><div name="meta" id="meta">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['indicador']='<td><div name="indicador" id="indicador">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['monitoramento']='<td><div name="monitoramento" id="monitoramento">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['agrupamento']='<td><div name="agrupamento" id="agrupamento">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['patrocinador']='<td><div name="patrocinador" id="patrocinador">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['modelo']='<td><div name="template" id="template">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['agenda']='<td><div name="calendario" id="calendario">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['instrumento'])]='<td><div name="instrumento" id="instrumento">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['recurso'])]='<td><div name="recurso" id="recurso">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['problema'])]='<td><div name="problema" id="problema">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['demanda']='<td><div name="demanda" id="demanda">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['programa'])]='<td><div name="programa" id="programa">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['licao'])]='<td><div name="licao" id="licao">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['evento']='<td><div name="evento" id="evento">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['link']='<td><div name="link" id="link">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['avaliação']='<td><div name="avaliacao" id="avaliacao">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['tgn'])]='<td><div name="tgn" id="tgn">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['brainstorm']='<td><div name="brainstorm" id="brainstorm">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['matriz G.U.T.']='<td><div name="gut" id="gut">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['diagrama de Cusa-Efeito']='<td><div name="causa_efeito" id="causa_efeito">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['arquivo']='<td><div name="arquivo" id="arquivo">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['fórum']='<td><div name="forum" id="forum">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['checklist']='<td><div name="checklist" id="checklist">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['compromisso']='<td><div name="agenda" id="agenda">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['risco'])]='<td><div name="risco" id="risco">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['risco_resposta'])]='<td><div name="risco_resposta" id="risco_resposta">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['canvas'])]='<td><div name="canvas" id="canvas">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['matriz SWOT']='<td><div name="mswot" id="mswot">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['campo SWOT']='<td><div name="swot" id="swot">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['ata de Reunião']='<td><div name="ata" id="ata">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['plano operativo']='<td><div name="operativo" id="operativo">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['painel de indicador']='<td><div name="painel" id="painel">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['composição de painéis']='<td><div name="painel_composicao" id="painel_composicao">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['odômetro']='<td><div name="painel_odometro" id="painel_odometro">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['tr'])]='<td><div name="tr" id="tr">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna[strtolower($config['me'])]='<td><div name="me" id="me">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['estudo de Viabilidade']='<td><div name="viabilidade" id="viabilidade">&nbsp;&nbsp;&nbsp;</div></td>';
$coluna['termo de Abertura']='<td><div name="abertura" id="abertura">&nbsp;&nbsp;&nbsp;</div></td>';



ksort($coluna);
foreach($coluna as $valor) echo $valor;
echo '</tr>';
echo '</table></td></tr>';











echo '<input type="hidden" id="assinatura_atesta_opcao_id" name="assinatura_atesta_opcao_id" value="" />';
echo '<input type="hidden" id="assinatura_atesta_opcao_atesta" name="assinatura_atesta_opcao_atesta" value="" />';
echo '<tr><td colspan=20 id="ver_opcoes" style="display:none"><table cellspacing=0 cellpadding=0>';
echo '<tr><td><table cellspacing=0 cellpadding=0>';
echo '<tr><td align="right">'.dica('Parecer', 'O que será informado quando da assinatura.').'Parecer:'.dicaF().'</td><td colspan="2"><input type="text" class="texto" id="assinatura_atesta_opcao_nome" name="assinatura_atesta_opcao_nome" value="" style="width:400px;" /></td></tr>';
$tipo=array(1 => 'Aprova', -1 => 'Reprova');
echo '<tr><td align="right">'.dica('Resultado', 'O resultado do wqu será atestado.').'Resultado:'.dicaF().'</td><td colspan="2">'.selecionaVetor($tipo, 'assinatura_atesta_opcao_aprova', 'size="1" class="texto"').'</td></tr>';
echo '</table></td>';
echo '<td id="adicionar_atesta_opcao" style="display:"><a href="javascript: void(0);" onclick="incluir_atesta_opcao();">'.imagem('icones/adicionar_g.png','Incluir','Clique neste ícone '.imagem('icones/adicionar.png').' para incluir a resposta.').'</a></td>';
echo '<td id="confirmar_atesta_opcao" style="display:none"><a href="javascript: void(0);" onclick="limpar_atesta_opcao();">'.imagem('icones/cancelar_g.png','Cancelar','Clique neste ícone '.imagem('icones/cancelar.png').' para cancelar a edição da resposta.').'</a><a href="javascript: void(0);" onclick="incluir_atesta_opcao();">'.imagem('icones/ok_g.png','Confirmar','Clique neste ícone '.imagem('icones/ok.png').' para confirmar a edição da resposta.').'</a></td>';
echo '</tr>';
echo '</table>';	



echo '<tr><td colspan=20><table cellspacing=0 cellpadding=0><tr><td><div id="atestas_opcao"></div></td></tr></table></td></tr>';




echo estiloFundoCaixa();




?>



<script type="text/javascript">

function exibir_opcoes(assinatura_atesta_id){
	xajax_exibir_opcoes(assinatura_atesta_id);
	document.getElementById('ver_opcoes').style.display="";
	document.getElementById('colunas').style.visibility="";
	}

function mudar_posicao_atesta_opcao(assinatura_atesta_opcao_ordem, assinatura_atesta_opcao_id, direcao){
	var assinatura_atesta_opcao_atesta=document.getElementById('assinatura_atesta_opcao_atesta').value;
	xajax_mudar_posicao_atesta_opcao(assinatura_atesta_opcao_ordem, assinatura_atesta_opcao_id, direcao, assinatura_atesta_opcao_atesta); 	
	}	

function editar_atesta_opcao(assinatura_atesta_opcao_id){
	xajax_editar_atesta_opcao(assinatura_atesta_opcao_id);
	document.getElementById('adicionar_atesta_opcao').style.display="none";
	document.getElementById('confirmar_atesta_opcao').style.display="";
	}
	
function incluir_atesta_opcao(){
	if (document.getElementById('assinatura_atesta_opcao_nome').value){
		xajax_incluir_atesta_opcao(
			document.getElementById('assinatura_atesta_opcao_id').value, 
			document.getElementById('assinatura_atesta_opcao_nome').value, 
			document.getElementById('assinatura_atesta_opcao_aprova').value,
			document.getElementById('assinatura_atesta_opcao_atesta').value
			);
		limpar_atesta_opcao();
		}
	else alert('Escolha um atesta_opcao.');	
	}	
	
function excluir_atesta_opcao(assinatura_atesta_opcao_id){
	xajax_excluir_atesta_opcao(assinatura_atesta_opcao_id, document.getElementById('assinatura_atesta_opcao_atesta').value);
	}		

function limpar_atesta_opcao(){
	document.getElementById('assinatura_atesta_opcao_id').value=null;
	document.getElementById('assinatura_atesta_opcao_nome').value=null;
	document.getElementById('assinatura_atesta_opcao_aprova').value='';
	document.getElementById('adicionar_atesta_opcao').style.display='';	
	document.getElementById('confirmar_atesta_opcao').style.display='none';
	}
	
	
	
	
	

function mudar_posicao_priorizacao(assinatura_atesta_ordem, assinatura_atesta_id, direcao){
	xajax_mudar_posicao_priorizacao(assinatura_atesta_ordem, assinatura_atesta_id, direcao); 	
	document.getElementById('ver_opcoes').style.display="none";
	}	

function editar_priorizacao(assinatura_atesta_id){
	xajax_editar_priorizacao(assinatura_atesta_id);
	document.getElementById('adicionar_priorizacao').style.display="none";
	document.getElementById('confirmar_priorizacao').style.display="";
	document.getElementById('ver_opcoes').style.display="none";
	}
		

function limpar_priorizacao(){
	document.getElementById('assinatura_atesta_id').value=null;
	document.getElementById('assinatura_atesta_nome').value=null;
	document.getElementById('adicionar_priorizacao').style.display='';	
	document.getElementById('confirmar_priorizacao').style.display='none';
	}
		
	
function excluir_priorizacao(assinatura_atesta_id){
	xajax_excluir_priorizacao(assinatura_atesta_id);
	}		
	

function incluir_priorizacao(){
	if (document.getElementById('assinatura_atesta_nome').value){
		xajax_incluir_priorizacao(
			document.getElementById('assinatura_atesta_id').value, 
			document.getElementById('assinatura_atesta_nome').value,
			document.getElementById('assinatura_atesta_projeto').checked,
			document.getElementById('assinatura_atesta_tarefa').checked,
			document.getElementById('assinatura_atesta_pratica').checked,
			document.getElementById('assinatura_atesta_acao').checked,
			document.getElementById('assinatura_atesta_perspectiva').checked,
			document.getElementById('assinatura_atesta_tema').checked,
			document.getElementById('assinatura_atesta_objetivo').checked,
			document.getElementById('assinatura_atesta_estrategia').checked,
			document.getElementById('assinatura_atesta_fator').checked,
			document.getElementById('assinatura_atesta_meta').checked,
			document.getElementById('assinatura_atesta_indicador').checked,
			document.getElementById('assinatura_atesta_monitoramento').checked,
			document.getElementById('assinatura_atesta_agrupamento').checked,
			document.getElementById('assinatura_atesta_patrocinador').checked,
			document.getElementById('assinatura_atesta_template').checked,
			document.getElementById('assinatura_atesta_calendario').checked,
			document.getElementById('assinatura_atesta_instrumento').checked,
			document.getElementById('assinatura_atesta_recurso').checked,
			document.getElementById('assinatura_atesta_problema').checked,
			document.getElementById('assinatura_atesta_demanda').checked,
			document.getElementById('assinatura_atesta_programa').checked,
			document.getElementById('assinatura_atesta_licao').checked,
			document.getElementById('assinatura_atesta_evento').checked,
			document.getElementById('assinatura_atesta_link').checked,
			document.getElementById('assinatura_atesta_avaliacao').checked,
			document.getElementById('assinatura_atesta_tgn').checked,
			document.getElementById('assinatura_atesta_brainstorm').checked,
			document.getElementById('assinatura_atesta_gut').checked,
			document.getElementById('assinatura_atesta_causa_efeito').checked,
			document.getElementById('assinatura_atesta_arquivo').checked,
			document.getElementById('assinatura_atesta_forum').checked,
			document.getElementById('assinatura_atesta_checklist').checked,
			document.getElementById('assinatura_atesta_agenda').checked,
			document.getElementById('assinatura_atesta_risco').checked,
			document.getElementById('assinatura_atesta_risco_resposta').checked,
			document.getElementById('assinatura_atesta_canvas').checked,
			document.getElementById('assinatura_atesta_mswot').checked,
			document.getElementById('assinatura_atesta_swot').checked,
			document.getElementById('assinatura_atesta_ata').checked,
			document.getElementById('assinatura_atesta_operativo').checked,
			document.getElementById('assinatura_atesta_painel').checked,
			document.getElementById('assinatura_atesta_painel_composicao').checked,
			document.getElementById('assinatura_atesta_painel_odometro').checked,
			document.getElementById('assinatura_atesta_tr').checked,
			document.getElementById('assinatura_atesta_me').checked,
			document.getElementById('assinatura_atesta_viabilidade').checked,
			document.getElementById('assinatura_atesta_abertura').checked
			);
		limpar_priorizacao();
		}
	else alert('Escolha um priorizacao.');	
	}			
	
document.getElementById('colunas').style.visibility="hidden";		
</script>