<?php 
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');

global $estilo_interface, $sql, $perms, $dialogo, $Aplic, $cia_id, $dept_id, $lista_depts, $tab, $lista_cias, $favorito_id, $usuario_id, $pesquisar_texto, $pg_id, $podeEditar, $filtro_prioridade_meta,
	$tarefa_id, 
	$projeto_id, 
	$pg_perspectiva_id, 
	$tema_id, 
	$objetivo_id, 
	$fator_id, 
	$pg_estrategia_id,
	$link_id, 
	$pratica_id, 
	$pratica_indicador_id, 
	$plano_acao_id, 
	$canvas_id, 
	$risco_id,
	$risco_resposta_id,
	$calendario_id, 
	$monitoramento_id, 
	$ata_id,
	$mswot_id, 
	$swot_id, 
	$operativo_id,
	$instrumento_id,
	$recurso_id,
	$problema_id,
	$demanda_id,
	$programa_id,
	$licao_id,
	$evento_id,
	$avaliacao_id,
	$tgn_id,
	$brainstorm_id,
	$gut_id,
	$causa_efeito_id,
	$arquivo_id,
	$forum_id,
	$checklist_id,
	$agenda_id,
	$agrupamento_id,
	$patrocinador_id,
	$template_id,
	$painel_id,
	$painel_odometro_id,
	$painel_composicao_id,
	$tr_id,
	$me_id;


$seta=array('0'=>'seta-cima.gif', '1'=>'seta-baixo.gif');

$impressao=getParam($_REQUEST, 'sem_cabecalho', 0);

$pagina = getParam($_REQUEST, 'pagina', 1);

$xtamanhoPagina = ($impressao || $dialogo ? 90000 : $config['qnt_metas']);
$xmin = $xtamanhoPagina * ($pagina - 1); 

$df = '%d/%m/%Y';
$tf = $Aplic->getPref('formatohora');

$ordenar = getParam($_REQUEST, 'ordenar', 'pg_meta_nome');
$ordem = getParam($_REQUEST, 'ordem', '0');

$sql->adTabela('metas');
$sql->adCampo('count(DISTINCT metas.pg_meta_id)');
if ($Aplic->profissional){
	$sql->esqUnir('meta_gestao','meta_gestao','meta_gestao_meta = metas.pg_meta_id');
	if ($tarefa_id) $sql->adOnde('meta_gestao_tarefa='.$tarefa_id);
	elseif ($projeto_id) $sql->adOnde('meta_gestao_projeto='.(int)$projeto_id);
	elseif ($pg_perspectiva_id) $sql->adOnde('meta_gestao_perspectiva='.$pg_perspectiva_id);
	elseif ($tema_id) $sql->adOnde('meta_gestao_tema='.(int)$tema_id);
	elseif ($objetivo_id) $sql->adOnde('meta_gestao_objetivo='.(int)$objetivo_id);
	elseif ($fator_id) $sql->adOnde('meta_gestao_fator='.(int)$fator_id);
	elseif ($pg_estrategia_id) $sql->adOnde('meta_gestao_estrategia='.(int)$pg_estrategia_id);
	elseif ($link_id) $sql->adOnde('meta_gestao_link='.(int)$link_id);
	elseif ($pratica_id) $sql->adOnde('meta_gestao_pratica='.(int)$pratica_id);
	elseif ($pratica_indicador_id) $sql->adOnde('meta_gestao_indicador='.(int)$pratica_indicador_id);
	elseif ($plano_acao_id) $sql->adOnde('meta_gestao_acao='.(int)$plano_acao_id);
	elseif ($canvas_id) $sql->adOnde('meta_gestao_canvas='.(int)$canvas_id);
	elseif ($risco_id) $sql->adOnde('meta_gestao_risco='.(int)$risco_id);
	elseif ($risco_resposta_id) $sql->adOnde('meta_gestao_risco_resposta='.(int)$risco_resposta_id);
	elseif ($calendario_id) $sql->adOnde('meta_gestao_calendario='.(int)$calendario_id);
	elseif ($monitoramento_id) $sql->adOnde('meta_gestao_monitoramento='.(int)$monitoramento_id);
	elseif ($ata_id) $sql->adOnde('meta_gestao_ata='.(int)$ata_id);
	elseif ($mswot_id) $sql->adOnde('meta_gestao_mswot='.(int)$mswot_id);
	elseif ($swot_id) $sql->adOnde('meta_gestao_swot='.(int)$swot_id);
	elseif ($operativo_id) $sql->adOnde('meta_gestao_operativo='.(int)$operativo_id);
	elseif ($instrumento_id) $sql->adOnde('meta_gestao_instrumento='.(int)$instrumento_id);
	elseif ($recurso_id) $sql->adOnde('meta_gestao_recurso='.(int)$recurso_id);
	elseif ($problema_id) $sql->adOnde('meta_gestao_problema='.(int)$problema_id);
	elseif ($demanda_id) $sql->adOnde('meta_gestao_demanda='.(int)$demanda_id);
	elseif ($programa_id) $sql->adOnde('meta_gestao_programa='.(int)$programa_id);
	elseif ($licao_id) $sql->adOnde('meta_gestao_licao='.(int)$licao_id);
	elseif ($evento_id) $sql->adOnde('meta_gestao_evento='.(int)$evento_id);
	elseif ($avaliacao_id) $sql->adOnde('meta_gestao_avaliacao='.(int)$avaliacao_id);
	elseif ($tgn_id) $sql->adOnde('meta_gestao_tgn='.(int)$tgn_id);
	elseif ($brainstorm_id) $sql->adOnde('meta_gestao_brainstorm='.(int)$brainstorm_id);
	elseif ($gut_id) $sql->adOnde('meta_gestao_gut='.(int)$gut_id);
	elseif ($causa_efeito_id) $sql->adOnde('meta_gestao_causa_efeito='.(int)$causa_efeito_id);
	elseif ($arquivo_id) $sql->adOnde('meta_gestao_arquivo='.(int)$arquivo_id);
	elseif ($forum_id) $sql->adOnde('meta_gestao_forum='.(int)$forum_id);
	elseif ($checklist_id) $sql->adOnde('meta_gestao_checklist='.(int)$checklist_id);
	elseif ($agenda_id) $sql->adOnde('meta_gestao_agenda='.(int)$agenda_id);
	elseif ($agrupamento_id) $sql->adOnde('meta_gestao_agrupamento='.(int)$agrupamento_id);
	elseif ($patrocinador_id) $sql->adOnde('meta_gestao_patrocinador='.(int)$patrocinador_id);
	elseif ($template_id) $sql->adOnde('meta_gestao_template='.(int)$template_id);
	elseif ($painel_id) $sql->adOnde('meta_gestao_painel='.(int)$painel_id);
	elseif ($painel_odometro_id) $sql->adOnde('meta_gestao_painel_odometro='.(int)$painel_odometro_id);
	elseif ($painel_composicao_id) $sql->adOnde('meta_gestao_painel_composicao='.(int)$painel_composicao_id);	
	elseif ($tr_id) $sql->adOnde('meta_gestao_tr='.(int)$tr_id);
	elseif ($me_id) $sql->adOnde('meta_gestao_me='.(int)$me_id);
	}


if ($filtro_prioridade_meta){
	$sql->esqUnir('priorizacao', 'priorizacao', 'metas.pg_meta_id=priorizacao_meta');
	$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_meta.')');
	}

if ($favorito_id){
	$sql->internoUnir('favorito_lista', 'favorito_lista', 'metas.pg_meta_id=favorito_lista_campo');
	$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
	$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
	}
elseif ($dept_id && !$lista_depts) {
	$sql->esqUnir('metas_depts','metas_depts', 'metas_depts.pg_meta_id=metas.pg_meta_id');
	$sql->adOnde('pg_meta_dept='.(int)$dept_id.' OR metas_depts.dept_id='.(int)$dept_id);
	}
elseif ($lista_depts) {
	$sql->esqUnir('metas_depts','metas_depts', 'metas_depts.pg_meta_id=metas.pg_meta_id');
	$sql->adOnde('pg_meta_dept IN ('.$lista_depts.') OR metas_depts.dept_id IN ('.$lista_depts.')');
	}	
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('meta_cia', 'meta_cia', 'metas.pg_meta_id=meta_cia_meta');
	$sql->adOnde('pg_meta_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR meta_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
	}
elseif ($cia_id && !$lista_cias) $sql->adOnde('pg_meta_cia='.(int)$cia_id);
elseif ($lista_cias) $sql->adOnde('pg_meta_cia IN ('.$lista_cias.')');	

if ($tab==0) $sql->adOnde('pg_meta_ativo=1');
elseif ($tab==1) $sql->adOnde('pg_meta_ativo!=1 OR pg_meta_ativo IS NULL');

if ($pg_id){
	$sql->esqUnir('plano_gestao_metas','plano_gestao_metas','plano_gestao_metas.pg_meta_id=metas.pg_meta_id');
	$sql->esqUnir('plano_gestao','plano_gestao','plano_gestao.pg_id=plano_gestao_metas.pg_id');
	$sql->adOnde('plano_gestao.pg_id='.(int)$pg_id);
	}
if ($usuario_id) {
	$sql->esqUnir('metas_usuarios', 'metas_usuarios', 'metas_usuarios.pg_meta_id = metas.pg_meta_id');
	$sql->adOnde('pg_meta_responsavel = '.(int)$usuario_id.' OR metas_usuarios.usuario_id='.(int)$usuario_id);
	}
if ($pesquisar_texto) $sql->adOnde('pg_meta_nome LIKE \'%'.$pesquisar_texto.'%\' OR pg_meta_descricao LIKE \'%'.$pesquisar_texto.'%\'');

	
$xtotalregistros = $sql->Resultado();
$sql->limpar();


$sql->adTabela('metas');
$sql->adCampo('metas.pg_meta_id, pg_meta_nome, pg_meta_responsavel, pg_meta_acesso, pg_meta_cor, pg_meta_descricao, pg_meta_percentagem, pg_meta_aprovado');
if ($Aplic->profissional){
	$sql->esqUnir('meta_gestao','meta_gestao','meta_gestao_meta = metas.pg_meta_id');
	if ($tarefa_id) $sql->adOnde('meta_gestao_tarefa='.$tarefa_id);
	elseif ($projeto_id) $sql->adOnde('meta_gestao_projeto='.(int)$projeto_id);
	elseif ($pg_perspectiva_id) $sql->adOnde('meta_gestao_perspectiva='.$pg_perspectiva_id);
	elseif ($tema_id) $sql->adOnde('meta_gestao_tema='.(int)$tema_id);
	elseif ($objetivo_id) $sql->adOnde('meta_gestao_objetivo='.(int)$objetivo_id);
	elseif ($fator_id) $sql->adOnde('meta_gestao_fator='.(int)$fator_id);
	elseif ($pg_estrategia_id) $sql->adOnde('meta_gestao_estrategia='.(int)$pg_estrategia_id);
	elseif ($link_id) $sql->adOnde('meta_gestao_link='.(int)$link_id);
	elseif ($pratica_id) $sql->adOnde('meta_gestao_pratica='.(int)$pratica_id);
	elseif ($pratica_indicador_id) $sql->adOnde('meta_gestao_indicador='.(int)$pratica_indicador_id);
	elseif ($plano_acao_id) $sql->adOnde('meta_gestao_acao='.(int)$plano_acao_id);
	elseif ($canvas_id) $sql->adOnde('meta_gestao_canvas='.(int)$canvas_id);
	elseif ($risco_id) $sql->adOnde('meta_gestao_risco='.(int)$risco_id);
	elseif ($risco_resposta_id) $sql->adOnde('meta_gestao_risco_resposta='.(int)$risco_resposta_id);
	elseif ($calendario_id) $sql->adOnde('meta_gestao_calendario='.(int)$calendario_id);
	elseif ($monitoramento_id) $sql->adOnde('meta_gestao_monitoramento='.(int)$monitoramento_id);
	elseif ($ata_id) $sql->adOnde('meta_gestao_ata='.(int)$ata_id);
	elseif ($mswot_id) $sql->adOnde('meta_gestao_mswot='.(int)$mswot_id);
	elseif ($swot_id) $sql->adOnde('meta_gestao_swot='.(int)$swot_id);
	elseif ($operativo_id) $sql->adOnde('meta_gestao_operativo='.(int)$operativo_id);
	elseif ($instrumento_id) $sql->adOnde('meta_gestao_instrumento='.(int)$instrumento_id);
	elseif ($recurso_id) $sql->adOnde('meta_gestao_recurso='.(int)$recurso_id);
	elseif ($problema_id) $sql->adOnde('meta_gestao_problema='.(int)$problema_id);
	elseif ($demanda_id) $sql->adOnde('meta_gestao_demanda='.(int)$demanda_id);
	elseif ($programa_id) $sql->adOnde('meta_gestao_programa='.(int)$programa_id);
	elseif ($licao_id) $sql->adOnde('meta_gestao_licao='.(int)$licao_id);
	elseif ($evento_id) $sql->adOnde('meta_gestao_evento='.(int)$evento_id);
	elseif ($avaliacao_id) $sql->adOnde('meta_gestao_avaliacao='.(int)$avaliacao_id);
	elseif ($tgn_id) $sql->adOnde('meta_gestao_tgn='.(int)$tgn_id);
	elseif ($brainstorm_id) $sql->adOnde('meta_gestao_brainstorm='.(int)$brainstorm_id);
	elseif ($gut_id) $sql->adOnde('meta_gestao_gut='.(int)$gut_id);
	elseif ($causa_efeito_id) $sql->adOnde('meta_gestao_causa_efeito='.(int)$causa_efeito_id);
	elseif ($arquivo_id) $sql->adOnde('meta_gestao_arquivo='.(int)$arquivo_id);
	elseif ($forum_id) $sql->adOnde('meta_gestao_forum='.(int)$forum_id);
	elseif ($checklist_id) $sql->adOnde('meta_gestao_checklist='.(int)$checklist_id);
	elseif ($agenda_id) $sql->adOnde('meta_gestao_agenda='.(int)$agenda_id);
	elseif ($agrupamento_id) $sql->adOnde('meta_gestao_agrupamento='.(int)$agrupamento_id);
	elseif ($patrocinador_id) $sql->adOnde('meta_gestao_patrocinador='.(int)$patrocinador_id);
	elseif ($template_id) $sql->adOnde('meta_gestao_template='.(int)$template_id);
	elseif ($painel_id) $sql->adOnde('meta_gestao_painel='.(int)$painel_id);
	elseif ($painel_odometro_id) $sql->adOnde('meta_gestao_painel_odometro='.(int)$painel_odometro_id);
	elseif ($painel_composicao_id) $sql->adOnde('meta_gestao_painel_composicao='.(int)$painel_composicao_id);	
	elseif ($tr_id) $sql->adOnde('meta_gestao_tr='.(int)$tr_id);
	elseif ($me_id) $sql->adOnde('meta_gestao_me='.(int)$me_id);
	}
	
if ($filtro_prioridade_meta){
	$sql->esqUnir('priorizacao', 'priorizacao', 'metas.pg_meta_id=priorizacao_meta');
	if ($config['metodo_priorizacao']) $sql->adCampo('(SELECT round(exp(sum(log(coalesce(priorizacao_valor,1))))) FROM priorizacao WHERE priorizacao_meta = metas.pg_meta_id AND priorizacao_modelo IN ('.$filtro_prioridade_meta.')) AS priorizacao');
	else $sql->adCampo('(SELECT SUM(priorizacao_valor) FROM priorizacao WHERE priorizacao_meta = metas.pg_meta_id AND priorizacao_modelo IN ('.$filtro_prioridade_meta.')) AS priorizacao');
	$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_meta.')');
	}

if ($favorito_id){
	$sql->internoUnir('favorito_lista', 'favorito_lista', 'metas.pg_meta_id=favorito_lista_campo');
	$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
	$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
	}	
elseif ($dept_id && !$lista_depts) {
	$sql->esqUnir('metas_depts','metas_depts', 'metas_depts.pg_meta_id=metas.pg_meta_id');
	$sql->adOnde('pg_meta_dept='.(int)$dept_id.' OR metas_depts.dept_id='.(int)$dept_id);
	}
elseif ($lista_depts) {
	$sql->esqUnir('metas_depts','metas_depts', 'metas_depts.pg_meta_id=metas.pg_meta_id');
	$sql->adOnde('pg_meta_dept IN ('.$lista_depts.') OR metas_depts.dept_id IN ('.$lista_depts.')');
	}	
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('meta_cia', 'meta_cia', 'metas.pg_meta_id=meta_cia_meta');
	$sql->adOnde('pg_meta_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR meta_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
	}
elseif ($cia_id && !$lista_cias) $sql->adOnde('pg_meta_cia='.(int)$cia_id);
elseif ($lista_cias) $sql->adOnde('pg_meta_cia IN ('.$lista_cias.')');	
if ($tab==0) $sql->adOnde('pg_meta_ativo=1');
elseif ($tab==1) $sql->adOnde('pg_meta_ativo!=1 OR pg_meta_ativo IS NULL');

if ($pg_id){
	$sql->esqUnir('plano_gestao_metas','plano_gestao_metas','plano_gestao_metas.pg_meta_id=metas.pg_meta_id');
	$sql->esqUnir('plano_gestao','plano_gestao','plano_gestao.pg_id=plano_gestao_metas.pg_id');
	$sql->adOnde('plano_gestao.pg_id='.(int)$pg_id);
	}
if ($usuario_id) {
	$sql->esqUnir('metas_usuarios', 'metas_usuarios', 'metas_usuarios.pg_meta_id = metas.pg_meta_id');
	$sql->adOnde('pg_meta_responsavel = '.(int)$usuario_id.' OR metas_usuarios.usuario_id='.(int)$usuario_id);
	}
if ($pesquisar_texto) $sql->adOnde('pg_meta_nome LIKE \'%'.$pesquisar_texto.'%\' OR pg_meta_descricao LIKE \'%'.$pesquisar_texto.'%\'');

if ($Aplic->profissional) $sql->adCampo('(SELECT count(assinatura_id) FROM assinatura WHERE assinatura_aprova=1 AND assinatura_meta=metas.pg_meta_id) AS tem_aprovacao');

$sql->adGrupo('metas.pg_meta_id');

$sql->adOrdem($ordenar.($ordem ? ' DESC' : ' ASC'));
$sql->setLimite($xmin, $xtamanhoPagina);
$metas=$sql->Lista();
$sql->limpar();




$xtotal_paginas = ($xtotalregistros > $xtamanhoPagina) ? ceil($xtotalregistros / $xtamanhoPagina) : 0;
if ($xtotal_paginas > 1) mostrarBarraNav($xtotalregistros, $xtamanhoPagina, $xtotal_paginas, $pagina, ucfirst($config['meta']), ucfirst($config['metas']),'','&ordenar='.$ordenar.'&ordem='.$ordem,($estilo_interface=='classico' ? 'a6a6a6' : '006fc2'));


echo '<table width="100%" cellpadding=0 cellspacing=0 class="tbl1">';
echo '<tr>';

if (!$impressao && !$dialogo) echo '<th nowrap="nowrap">&nbsp;</th>';
echo '<th width=16><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=pg_meta_cor&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='pg_meta_cor' ? imagem('icones/'.$seta[$ordem]) : '').dica('Cor', 'Neste campo fica a cor de identificação d'.$config['genero_meta'].' '.$config['meta'].'.').'Cor'.dicaF().'</a></th>';
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=pg_meta_nome&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='pg_meta_nome' ? imagem('icones/'.$seta[$ordem]) : '').dica('Nome', 'Neste campo fica um nome para identificação d'.$config['genero_meta'].' '.$config['meta'].'.').'Nome'.dicaF().'</a></th>';

if ($Aplic->profissional) echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=pg_meta_aprovado&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='pg_meta_aprovado' ? imagem('icones/'.$seta[$ordem]) : '').dica('Aprovad'.$config['genero_meta'], 'Neste campo consta se '.$config['genero_meta'].' '.$config['meta'].' foi aprovad'.$config['genero_meta'].'.').'Aprovad'.$config['genero_meta'].dicaF().'</a></th>';
if ($filtro_prioridade_meta) echo '<th nowrap="nowrap"><a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($tab ? '&tab='.$tab : '').'&a='.$a.'&ordenar=priorizacao&ordem='.($ordem ? '0' : '1').'\');" class="hdr">'.dica('Priorização', 'Clique para ordenar pela priorização.').($ordenar=='priorizacao' ? imagem('icones/'.$seta[$ordem]) : '').'Prio.'.dicaF().'</a></th>';


echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=pg_meta_descricao&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='pg_meta_descricao' ? imagem('icones/'.$seta[$ordem]) : '').dica('Descrição', 'Neste campo fica a descrição d'.$config['genero_meta'].' '.$config['meta'].'.').'Descrição'.dicaF().'</a></th>';
if ($Aplic->profissional) echo '<th nowrap="nowrap">'.dica('Relacionados', 'Objetos relacionados a est'.($config['genero_meta']=='a' ? 'a' : 'e').'s '.$config['metas'].'.').'Relacionados'.dicaF().'</th>';
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($a ? '&a='.$a : '').($tab ? '&tab='.$tab : '').'&ordenar=pg_meta_responsavel&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='pg_meta_responsavel' ? imagem('icones/'.$seta[$ordem]) : '').dica('Responsável', 'O '.$config['usuario'].' responsável pel'.$config['genero_meta'].' '.$config['meta'].'.').'Responsável'.dicaF().'</a></th>';
echo '<th nowrap="nowrap">'.dica('Designados', 'Neste campo fica os designados para '.$config['genero_meta'].'s '.$config['metas'].'.').'Designados'.dicaF().'</th>';

if ($Aplic->profissional) echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($a ? '&a='.$a : '').($tab ? '&tab='.$tab : '').'&ordenar=pg_meta_percentagem&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='pg_meta_percentagem' ? imagem('icones/'.$seta[$ordem]) : '').dica('Percentagem', 'A percentagem d'.$config['genero_meta'].' '.$config['meta'].' executad'.$config['genero_meta'].'.').'%'.dicaF().'</a></th>';

echo '</tr>';
$qnt1=0;
foreach ($metas as $linha) {
	if (permiteAcessarMeta($linha['pg_meta_acesso'],$linha['pg_meta_id'])) {
		$qnt1++;
		$editar=permiteEditarMeta($linha['pg_meta_acesso'],$linha['pg_meta_id']);
		if ($Aplic->profissional) $bloquear=($linha['pg_meta_aprovado'] && $config['trava_aprovacao'] && $linha['tem_aprovacao'] && !$Aplic->usuario_super_admin);
		else $bloquear=0;
		
		echo '<tr>';
		if (!$impressao && !$dialogo) echo '<td nowrap="nowrap" width="16">'.($podeEditar && $editar && !$bloquear ? dica('Editar', 'Clique neste ícone '.imagem('icones/editar.gif').' para editar '.$config['genero_meta'].' '.$config['meta'].'.').'<a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a=meta_editar&pg_meta_id='.$linha['pg_meta_id'].'\');">'.imagem('icones/editar.gif').'</a>'.dicaF() : '&nbsp;').'</td>';
		echo '<td id="ignore_td_" width="15" align="right" style="background-color:#'.$linha['pg_meta_cor'].'"><font color="'.melhorCor($linha['pg_meta_cor']).'">&nbsp;&nbsp;</font></td>';
		echo '<td>'.link_meta($linha['pg_meta_id'], true).'</td>';
		
		if ($Aplic->profissional) echo '<td width=30 align="center">'.($linha['pg_meta_aprovado'] && $linha['tem_aprovacao'] ? 'Sim' : ($linha['tem_aprovacao'] ? 'Não' : 'N/A')).'</td>';
		if ($filtro_prioridade_meta) echo '<td align="right" nowrap="nowrap" width=50>'.($linha['priorizacao']).'</td>';
		
		echo '<td>'.($linha['pg_meta_descricao'] ? $linha['pg_meta_descricao'] : '&nbsp;').'</td>';
		
		if ($Aplic->profissional){
		echo '<td>';	
		$sql->adTabela('meta_gestao');
		$sql->adCampo('meta_gestao.*');
		$sql->adOnde('meta_gestao_meta ='.(int)$linha['pg_meta_id']);
		$sql->adOrdem('meta_gestao_ordem');
	  $lista = $sql->Lista();
	  $sql->limpar();
	  if (count($lista)) {
		  if ($Aplic->profissional) require_once BASE_DIR.'/modulos/projetos/template_pro.class.php';
			$ata_ativo=$Aplic->modulo_ativo('atas');
			if ($ata_ativo) require_once BASE_DIR.'/modulos/atas/funcoes.php';
			$swot_ativo=$Aplic->modulo_ativo('swot');
			if ($swot_ativo) {
				require_once BASE_DIR.'/modulos/swot/swot.class.php';
				require_once BASE_DIR.'/modulos/swot/mswot.class.php';
				}
			$operativo_ativo=$Aplic->modulo_ativo('operativo');
			if ($operativo_ativo) require_once BASE_DIR.'/modulos/operativo/funcoes.php';
			$problema_ativo=$Aplic->modulo_ativo('problema');
			if ($problema_ativo) require_once BASE_DIR.'/modulos/problema/funcoes.php';
			$agrupamento_ativo=$Aplic->modulo_ativo('agrupamento');
			if($agrupamento_ativo) require_once BASE_DIR.'/modulos/agrupamento/funcoes.php';
			$patrocinador_ativo=$Aplic->modulo_ativo('patrocinadores');
			if($patrocinador_ativo) require_once BASE_DIR.'/modulos/patrocinadores/patrocinadores.class.php';
			$qnt=0;
			foreach($lista as $gestao_data){
				if ($gestao_data['meta_gestao_tarefa']) echo ($qnt++ ? '<br>' : '').imagem('icones/tarefa_p.gif').link_tarefa($gestao_data['meta_gestao_tarefa']);
				elseif ($gestao_data['meta_gestao_projeto']) echo ($qnt++ ? '<br>' : '').imagem('icones/projeto_p.gif').link_projeto($gestao_data['meta_gestao_projeto']);
				elseif ($gestao_data['meta_gestao_pratica']) echo ($qnt++ ? '<br>' : '').imagem('icones/pratica_p.gif').link_pratica($gestao_data['meta_gestao_pratica']);
				elseif ($gestao_data['meta_gestao_acao']) echo ($qnt++ ? '<br>' : '').imagem('icones/plano_acao_p.gif').link_acao($gestao_data['meta_gestao_acao']);
				elseif ($gestao_data['meta_gestao_perspectiva']) echo ($qnt++ ? '<br>' : '').imagem('icones/perspectiva_p.png').link_perspectiva($gestao_data['meta_gestao_perspectiva']);
				elseif ($gestao_data['meta_gestao_tema']) echo ($qnt++ ? '<br>' : '').imagem('icones/tema_p.png').link_tema($gestao_data['meta_gestao_tema']);
				elseif ($gestao_data['meta_gestao_objetivo']) echo ($qnt++ ? '<br>' : '').imagem('icones/obj_estrategicos_p.gif').link_objetivo($gestao_data['meta_gestao_objetivo']);
				elseif ($gestao_data['meta_gestao_fator']) echo ($qnt++ ? '<br>' : '').imagem('icones/fator_p.gif').link_fator($gestao_data['meta_gestao_fator']);
				elseif ($gestao_data['meta_gestao_estrategia']) echo ($qnt++ ? '<br>' : '').imagem('icones/estrategia_p.gif').link_estrategia($gestao_data['meta_gestao_estrategia']);
				elseif ($gestao_data['meta_gestao_meta2']) echo ($qnt++ ? '<br>' : '').imagem('icones/meta_p.gif').link_meta($gestao_data['meta_gestao_meta2']);
				elseif ($gestao_data['meta_gestao_canvas']) echo ($qnt++ ? '<br>' : '').imagem('icones/canvas_p.png').link_canvas($gestao_data['meta_gestao_canvas']);
				elseif ($gestao_data['meta_gestao_risco']) echo ($qnt++ ? '<br>' : '').imagem('icones/risco_p.png').link_risco($gestao_data['meta_gestao_risco']);
				elseif ($gestao_data['meta_gestao_risco_resposta']) echo ($qnt++ ? '<br>' : '').imagem('icones/risco_resposta_p.png').link_risco_resposta($gestao_data['meta_gestao_risco_resposta']);
				elseif ($gestao_data['meta_gestao_indicador']) echo ($qnt++ ? '<br>' : '').imagem('icones/indicador_p.gif').link_indicador($gestao_data['meta_gestao_indicador']);
				elseif ($gestao_data['meta_gestao_calendario']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_calendario($gestao_data['meta_gestao_calendario']);
				elseif ($gestao_data['meta_gestao_monitoramento']) echo ($qnt++ ? '<br>' : '').imagem('icones/monitoramento_p.gif').link_monitoramento($gestao_data['meta_gestao_monitoramento']);
				elseif ($gestao_data['meta_gestao_ata']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/atas/imagens/ata_p.png').link_ata_pro($gestao_data['meta_gestao_ata']);
				elseif ($gestao_data['meta_gestao_mswot']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/swot/imagens/mswot_p.png').link_mswot($gestao_data['meta_gestao_mswot']);
				elseif ($gestao_data['meta_gestao_swot']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/swot/imagens/swot_p.png').link_swot($gestao_data['meta_gestao_swot']);
				elseif ($gestao_data['meta_gestao_operativo']) echo ($qnt++ ? '<br>' : '').imagem('icones/operativo_p.png').link_operativo($gestao_data['meta_gestao_operativo']);
				elseif ($gestao_data['meta_gestao_instrumento']) echo ($qnt++ ? '<br>' : '').imagem('icones/instrumento_p.png').link_instrumento($gestao_data['meta_gestao_instrumento']);
				elseif ($gestao_data['meta_gestao_recurso']) echo ($qnt++ ? '<br>' : '').imagem('icones/recursos_p.gif').link_recurso($gestao_data['meta_gestao_recurso']);
				elseif ($gestao_data['meta_gestao_problema']) echo ($qnt++ ? '<br>' : '').imagem('icones/problema_p.png').link_problema_pro($gestao_data['meta_gestao_problema']);
				elseif ($gestao_data['meta_gestao_demanda']) echo ($qnt++ ? '<br>' : '').imagem('icones/demanda_p.gif').link_demanda($gestao_data['meta_gestao_demanda']);
				elseif ($gestao_data['meta_gestao_programa']) echo ($qnt++ ? '<br>' : '').imagem('icones/programa_p.png').link_programa($gestao_data['meta_gestao_programa']);
				elseif ($gestao_data['meta_gestao_licao']) echo ($qnt++ ? '<br>' : '').imagem('icones/licoes_p.gif').link_licao($gestao_data['meta_gestao_licao']);
				elseif ($gestao_data['meta_gestao_evento']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_evento($gestao_data['meta_gestao_evento']);
				elseif ($gestao_data['meta_gestao_link']) echo ($qnt++ ? '<br>' : '').imagem('icones/links_p.gif').link_link($gestao_data['meta_gestao_link']);
				elseif ($gestao_data['meta_gestao_avaliacao']) echo ($qnt++ ? '<br>' : '').imagem('icones/avaliacao_p.gif').link_avaliacao($gestao_data['meta_gestao_avaliacao']);
				elseif ($gestao_data['meta_gestao_tgn']) echo ($qnt++ ? '<br>' : '').imagem('icones/tgn_p.png').link_tgn($gestao_data['meta_gestao_tgn']);
				elseif ($gestao_data['meta_gestao_brainstorm']) echo ($qnt++ ? '<br>' : '').imagem('icones/brainstorm_p.gif').link_brainstorm_pro($gestao_data['meta_gestao_brainstorm']);
				elseif ($gestao_data['meta_gestao_gut']) echo ($qnt++ ? '<br>' : '').imagem('icones/gut_p.gif').link_gut_pro($gestao_data['meta_gestao_gut']);
				elseif ($gestao_data['meta_gestao_causa_efeito']) echo ($qnt++ ? '<br>' : '').imagem('icones/causaefeito_p.png').link_causa_efeito_pro($gestao_data['meta_gestao_causa_efeito']);
				elseif ($gestao_data['meta_gestao_arquivo']) echo ($qnt++ ? '<br>' : '').imagem('icones/arquivo_p.png').link_arquivo($gestao_data['meta_gestao_arquivo']);
				elseif ($gestao_data['meta_gestao_forum']) echo ($qnt++ ? '<br>' : '').imagem('icones/forum_p.gif').link_forum($gestao_data['meta_gestao_forum']);
				elseif ($gestao_data['meta_gestao_checklist']) echo ($qnt++ ? '<br>' : '').imagem('icones/todo_list_p.png').link_checklist($gestao_data['meta_gestao_checklist']);
				elseif ($gestao_data['meta_gestao_agenda']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_agenda($gestao_data['meta_gestao_agenda']);
				elseif ($gestao_data['meta_gestao_agrupamento']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/agrupamento/imagens/agrupamento_p.png').link_agrupamento($gestao_data['meta_gestao_agrupamento']);
				elseif ($gestao_data['meta_gestao_patrocinador']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/patrocinadores/imagens/patrocinador_p.gif').link_patrocinador($gestao_data['meta_gestao_patrocinador']);
				elseif ($gestao_data['meta_gestao_template']) echo ($qnt++ ? '<br>' : '').imagem('icones/template_p.gif').link_template($gestao_data['meta_gestao_template']);
				elseif ($gestao_data['meta_gestao_painel']) echo ($qnt++ ? '<br>' : '').imagem('icones/indicador_p.gif').link_painel($gestao_data['meta_gestao_painel']);
				elseif ($gestao_data['meta_gestao_painel_odometro']) echo ($qnt++ ? '<br>' : '').imagem('icones/odometro_p.png').link_painel_odometro($gestao_data['meta_gestao_painel_odometro']);
				elseif ($gestao_data['meta_gestao_painel_composicao']) echo ($qnt++ ? '<br>' : '').imagem('icones/painel_p.gif').link_painel_composicao($gestao_data['meta_gestao_painel_composicao']);
				elseif ($gestao_data['meta_gestao_tr']) echo ($qnt++ ? '<br>' : '').imagem('icones/tr_p.png').link_tr($gestao_data['meta_gestao_tr']);	
				elseif ($gestao_data['meta_gestao_me']) echo ($qnt++ ? '<br>' : '').imagem('icones/me_p.png').link_me($gestao_data['meta_gestao_me']);	
				}
			}
		echo '</td>';	
		}
			
		
		echo '<td nowrap="nowrap">'.link_usuario($linha['pg_meta_responsavel'],'','','esquerda').'</td>';
		
		$sql->adTabela('metas_usuarios');
		$sql->adCampo('usuario_id');
		$sql->adOnde('pg_meta_id = '.(int)$linha['pg_meta_id']);
		$participantes = $sql->carregarColuna();
		$sql->limpar();
		
		$saida_quem='';
		if ($participantes && count($participantes)) {
				$saida_quem.= link_usuario($participantes[0], '','','esquerda');
				$qnt_participantes=count($participantes);
				if ($qnt_participantes > 1) {		
						$lista='';
						for ($i = 1, $i_cmp = $qnt_participantes; $i < $i_cmp; $i++) $lista.=link_usuario($participantes[$i], '','','esquerda').'<br>';		
						$saida_quem.= dica('Outros Participantes', 'Clique para visualizar os demais participantes.').'<a href="javascript: void(0);" onclick="expandir_colapsar(\'participantes_'.$linha['pg_meta_id'].'\');">(+'.($qnt_participantes - 1).')</a>'.dicaF(). '<span style="display: none" id="participantes_'.$linha['pg_meta_id'].'"><br>'.$lista.'</span>';
						}
				} 
		echo '<td align="left" nowrap="nowrap">'.($saida_quem ? $saida_quem : '&nbsp;').'</td>';
		
		if ($Aplic->profissional) echo '<td nowrap="nowrap" align=right width=30>'.number_format($linha['pg_meta_percentagem'], 2, ',', '.').'</td>';
		echo '</tr>';
		}
	}
if (!count($metas)) echo '<tr><td colspan=20><p>Nenhum'.($config['genero_meta']=='a' ? 'a' : '').' '.$config['meta'].' encontrad'.$config['genero_meta'].'.</p></td></tr>';
elseif (count($metas) && !$qnt1) echo '<tr><td colspan="8"><p>Não tem permissão de ver nenhum'.($config['genero_meta']=='a' ? 'a' : '').' '.$config['meta'].'.</p></td></tr>';
echo '</table>';

?>
<script type="text/javascript">
function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}
</script>	