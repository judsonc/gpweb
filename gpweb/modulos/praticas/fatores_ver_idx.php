<?php 
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');

global $estilo_interface, $sql, $perms, $dialogo, $Aplic, $cia_id, $dept_id, $lista_depts, $tab, $lista_cias, $favorito_id, $usuario_id, $pesquisar_texto, $pg_id, $podeEditar, $filtro_prioridade_fator;

$seta=array('0'=>'seta-cima.gif', '1'=>'seta-baixo.gif');

$impressao=getParam($_REQUEST, 'sem_cabecalho', 0);



$pagina = getParam($_REQUEST, 'pagina', 1);

$xtamanhoPagina = ($impressao || $dialogo ? 90000 : $config['qnt_fatores']);
$xmin = $xtamanhoPagina * ($pagina - 1); 

$df = '%d/%m/%Y';
$tf = $Aplic->getPref('formatohora');

$ordenar = getParam($_REQUEST, 'ordenar', 'fator_nome');
$ordem = getParam($_REQUEST, 'ordem', '0');

$sql->adTabela('fator');
$sql->adCampo('count(DISTINCT fator.fator_id)');
if ($filtro_prioridade_fator){
	$sql->esqUnir('priorizacao', 'priorizacao', 'fator.fator_id=priorizacao_fator');
	$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_fator.')');
	}
	
if ($favorito_id){
	$sql->internoUnir('favorito_lista', 'favorito_lista', 'fator.fator_id=favorito_lista_campo');
	$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
	$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
	}
elseif ($dept_id && !$lista_depts) {
	$sql->esqUnir('fator_dept','fator_dept', 'fator_dept_fator=fator.fator_id');
	$sql->adOnde('fator_dept='.(int)$dept_id.' OR fator_dept_dept='.(int)$dept_id);
	}
elseif ($lista_depts) {
	$sql->esqUnir('fator_dept','fator_dept', 'fator_dept_fator=fator.fator_id');
	$sql->adOnde('fator_dept IN ('.$lista_depts.') OR fator_dept_dept IN ('.$lista_depts.')');
	}	
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('fator_cia', 'fator_cia', 'fator.fator_id=fator_cia_fator');
	$sql->adOnde('fator_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR fator_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
	}
elseif  ($cia_id && !$lista_cias) $sql->adOnde('fator_cia='.(int)$cia_id);
elseif ($lista_cias) $sql->adOnde('fator_cia IN ('.$lista_cias.')');	


if ($tab==0) $sql->adOnde('fator_ativo=1');
elseif ($tab==1) $sql->adOnde('fator_ativo!=1 OR fator_ativo IS NULL');

if ($pg_id){
	$sql->esqUnir('plano_gestao_fator','plano_gestao_fator','plano_gestao_fator_fator=fator.fator_id');
	$sql->esqUnir('plano_gestao','plano_gestao','plano_gestao.pg_id=plano_gestao_fator_plano_gestao');
	$sql->adOnde('plano_gestao.pg_id='.(int)$pg_id);
	}
if ($usuario_id) {
	$sql->esqUnir('fator_usuario', 'fator_usuario', 'fator_usuario_fator = fator.fator_id');
	$sql->adOnde('fator_usuario = '.(int)$usuario_id.' OR fator_usuario_usuario='.(int)$usuario_id);
	}
if ($pesquisar_texto) $sql->adOnde('fator_nome LIKE \'%'.$pesquisar_texto.'%\' OR fator_descricao LIKE \'%'.$pesquisar_texto.'%\'');



$xtotalregistros = $sql->Resultado();
$sql->limpar();


$sql->adTabela('fator');

$sql->adCampo('fator.fator_id, fator_nome, fator_usuario, fator_acesso, fator_cor, fator_descricao, fator_percentagem, fator_aprovado');

if ($filtro_prioridade_fator){
	$sql->esqUnir('priorizacao', 'priorizacao', 'fator.fator_id=priorizacao_fator');
	if ($config['metodo_priorizacao']) $sql->adCampo('(SELECT round(exp(sum(log(coalesce(priorizacao_valor,1))))) FROM priorizacao WHERE priorizacao_fator = fator.fator_id AND priorizacao_modelo IN ('.$filtro_prioridade_fator.')) AS priorizacao');
	else $sql->adCampo('(SELECT SUM(priorizacao_valor) FROM priorizacao WHERE priorizacao_fator = fator.fator_id AND priorizacao_modelo IN ('.$filtro_prioridade_fator.')) AS priorizacao');
	$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_fator.')');
	}

if ($favorito_id){
	$sql->internoUnir('favorito_lista', 'favorito_lista', 'fator.fator_id=favorito_lista_campo');
	$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
	$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
	}
elseif ($dept_id && !$lista_depts) {
	$sql->esqUnir('fator_dept','fator_dept', 'fator_dept_fator=fator.fator_id');
	$sql->adOnde('fator_dept='.(int)$dept_id.' OR fator_dept_dept='.(int)$dept_id);
	}
elseif ($lista_depts) {
	$sql->esqUnir('fator_dept','fator_dept', 'fator_dept_fator=fator.fator_id');
	$sql->adOnde('fator_dept IN ('.$lista_depts.') OR fator_dept_dept IN ('.$lista_depts.')');
	}	
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('fator_cia', 'fator_cia', 'fator.fator_id=fator_cia_fator');
	$sql->adOnde('fator_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR fator_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
	}
elseif  ($cia_id && !$lista_cias) $sql->adOnde('fator_cia='.(int)$cia_id);
elseif ($lista_cias) $sql->adOnde('fator_cia IN ('.$lista_cias.')');	

if ($tab==0) $sql->adOnde('fator_ativo=1');
elseif ($tab==1) $sql->adOnde('fator_ativo!=1 OR fator_ativo IS NULL');

if ($pg_id){
	$sql->esqUnir('plano_gestao_fator','plano_gestao_fator','plano_gestao_fator_fator=fator.fator_id');
	$sql->esqUnir('plano_gestao','plano_gestao','plano_gestao.pg_id=plano_gestao_fator_plano_gestao');
	$sql->adOnde('plano_gestao.pg_id='.(int)$pg_id);
	}
if ($usuario_id) {
	$sql->esqUnir('fator_usuario', 'fator_usuario', 'fator_usuario_fator = fator.fator_id');
	$sql->adOnde('fator_usuario = '.(int)$usuario_id.' OR fator_usuario_usuario='.(int)$usuario_id);
	}
if ($pesquisar_texto) $sql->adOnde('fator_nome LIKE \'%'.$pesquisar_texto.'%\' OR fator_descricao LIKE \'%'.$pesquisar_texto.'%\'');
if ($Aplic->profissional) $sql->adCampo('(SELECT count(assinatura_id) FROM assinatura WHERE assinatura_aprova=1 AND assinatura_fator=fator.fator_id) AS tem_aprovacao');
$sql->adOrdem($ordenar.($ordem ? ' DESC' : ' ASC'));
$sql->adGrupo('fator.fator_id');
$sql->setLimite($xmin, $xtamanhoPagina);
$fatores=$sql->Lista();
$sql->limpar();



$xtotal_paginas = ($xtotalregistros > $xtamanhoPagina) ? ceil($xtotalregistros / $xtamanhoPagina) : 0;
if ($xtotal_paginas > 1) mostrarBarraNav($xtotalregistros, $xtamanhoPagina, $xtotal_paginas, $pagina, ucfirst($config['fator']), ucfirst($config['fatores']),'','&ordenar='.$ordenar.'&ordem='.$ordem,($estilo_interface=='classico' ? 'a6a6a6' : '006fc2'));

echo '<table width="100%" border=0 cellpadding=0 cellspacing=0 class="tbl1">';
echo '<tr>';

if (!$impressao && !$dialogo) echo '<th nowrap="nowrap">&nbsp;</th>';
echo '<th width=16><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=fator_cor&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='fator_cor' ? imagem('icones/'.$seta[$ordem]) : '').dica('Cor d'.$config['genero_fator'].' '.ucfirst($config['fator']), 'Neste campo fica a cor de identificação d'.$config['genero_fator'].' '.$config['fator'].'.').'Cor'.dicaF().'</a></th>';
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=fator_nome&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='fator_nome' ? imagem('icones/'.$seta[$ordem]) : '').dica('Nome d'.$config['genero_fator'].' '.ucfirst($config['fator']), 'Neste campo fica um nome para identificação d'.$config['genero_fator'].' '.$config['fator'].'.').'Nome'.dicaF().'</a></th>';

if ($Aplic->profissional) echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=fator_aprovado&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='fator_aprovado' ? imagem('icones/'.$seta[$ordem]) : '').dica('Aprovado', 'Neste campo consta se foi aprovado.').'Ap.'.dicaF().'</a></th>';
if ($filtro_prioridade_fator) echo '<th nowrap="nowrap"><a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($tab ? '&tab='.$tab : '').'&a='.$a.'&ordenar=priorizacao&ordem='.($ordem ? '0' : '1').'\');" class="hdr">'.dica('Priorização', 'Clique para ordenar pela priorização.').($ordenar=='priorizacao' ? imagem('icones/'.$seta[$ordem]) : '').'Prio.'.dicaF().'</a></th>';

echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=fator_descricao&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='fator_descricao' ? imagem('icones/'.$seta[$ordem]) : '').dica('Descrição d'.$config['genero_fator'].' '.ucfirst($config['fator']), 'Neste campo fica a descrição d'.$config['genero_fator'].' '.$config['fator'].'.').'Descrição'.dicaF().'</a></th>';
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($a ? '&a='.$a : '').($tab ? '&tab='.$tab : '').'&ordenar=fator_usuario&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='fator_usuario' ? imagem('icones/'.$seta[$ordem]) : '').dica('Responsável', 'O '.$config['usuario'].' responsável pel'.$config['genero_fator'].' '.$config['fator'].'.').'Responsável'.dicaF().'</a></th>';
echo '<th nowrap="nowrap">'.dica('Designados', 'Neste campo fica os designados para '.$config['genero_fator'].'s '.$config['fatores'].'.').'Designados'.dicaF().'</th>';
if ($Aplic->profissional) echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($a ? '&a='.$a : '').($tab ? '&tab='.$tab : '').'&ordenar=fator_percentagem&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='fator_percentagem' ? imagem('icones/'.$seta[$ordem]) : '').dica('Percentagem', 'A percentagem d'.$config['genero_fator'].' '.$config['fator'].' executada.').'%'.dicaF().'</a></th>';
echo '</tr>';

$qnt=0;

foreach ($fatores as $linha) {
	if (permiteAcessarFator($linha['fator_acesso'], $linha['fator_id'])){
		$editar=permiteEditarFator($linha['fator_acesso'], $linha['fator_id']);
		$qnt++;
		if ($Aplic->profissional) $bloquear=($linha['fator_aprovado'] && $config['trava_aprovacao'] && $linha['tem_aprovacao'] && !$Aplic->usuario_super_admin);
		else $bloquear=0;
		
		echo '<tr>';
		if (!$impressao && !$dialogo) echo '<td nowrap="nowrap" width="16">'.($podeEditar && $editar && !$bloquear ? dica('Editar Fator Crítico', 'Clique neste ícone '.imagem('icones/editar.gif').' para editar '.$config['genero_fator'].' '.$config['fator'].'.').'<a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a=fator_editar&fator_id='.$linha['fator_id'].'\');">'.imagem('icones/editar.gif').'</a>'.dicaF() : '&nbsp;').'</td>';
		echo '<td id="ignore_td_" width="15" align="right" style="background-color:#'.$linha['fator_cor'].'"><font color="'.melhorCor($linha['fator_cor']).'">&nbsp;&nbsp;</font></td>';
		echo '<td>'.link_fator($linha['fator_id'], true).'</td>';
		
		if ($Aplic->profissional) echo '<td width=30 align="center">'.($linha['fator_aprovado'] && $linha['tem_aprovacao'] ? 'Sim' : ($linha['tem_aprovacao'] ? 'Não' : 'N/A')).'</td>';
		if ($filtro_prioridade_fator) echo '<td align="right" nowrap="nowrap" width=50>'.($linha['priorizacao']).'</td>';

		echo '<td>'.($linha['fator_descricao'] ? $linha['fator_descricao'] : '&nbsp;').'</td>';
		echo '<td nowrap="nowrap">'.link_usuario($linha['fator_usuario'],'','','esquerda').'</td>';
		
		$sql->adTabela('fator_usuario');
		$sql->adCampo('fator_usuario_usuario');
		$sql->adOnde('fator_usuario_fator = '.(int)$linha['fator_id']);
		$participantes = $sql->carregarColuna();
		$sql->limpar();
		
		$saida_quem='';
		if ($participantes && count($participantes)) {
				$saida_quem.= link_usuario($participantes[0], '','','esquerda');
				$qnt_participantes=count($participantes);
				if ($qnt_participantes > 1) {		
						$lista='';
						for ($i = 1, $i_cmp = $qnt_participantes; $i < $i_cmp; $i++) $lista.=link_usuario($participantes[$i], '','','esquerda').'<br>';		
						$saida_quem.= dica('Outros Participantes', 'Clique para visualizar os demais participantes.').'<a href="javascript: void(0);" onclick="expandir_colapsar(\'participantes_'.$linha['fator_id'].'\');">(+'.($qnt_participantes - 1).')</a>'.dicaF(). '<span style="display: none" id="participantes_'.$linha['fator_id'].'"><br>'.$lista.'</span>';
						}
				} 
		echo '<td align="left" nowrap="nowrap">'.($saida_quem ? $saida_quem : '&nbsp;').'</td>';
		
		if ($Aplic->profissional) echo '<td nowrap="nowrap" align=right width=30>'.number_format($linha['fator_percentagem'], 2, ',', '.').'</td>';
		echo '</tr>';
		}
	}
if (!count($fatores)) echo '<tr><td colspan=20><p>Nenhum'.($config['genero_fator']=='a' ? 'a' : '').' '.$config['fator'].' encontrad'.$config['genero_fator'].'.</p></td></tr>';
elseif(count($fatores) && !$qnt) echo '<tr><td colspan="20"><p>Não teve permissão de visualizar qualquer d'.$config['genero_fator'].'s '.$config['fatores'].'.</p></td></tr>';
echo '</table>';

?>
<script type="text/javascript">
function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}
</script>	