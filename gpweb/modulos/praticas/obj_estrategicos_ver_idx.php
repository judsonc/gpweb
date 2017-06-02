<?php 
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/



if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');

global $estilo_interface, $Aplic, $pesquisar_texto, $usuario_id, $cia_id, $dept_id, $lista_depts, $lista_cias, $tab, $pg_id, $pg_perspectiva_id, $favorito_id, $dialogo, $podeEditar, $filtro_prioridade_objetivo;

$sql = new BDConsulta;

$seta=array('0'=>'seta-cima.gif', '1'=>'seta-baixo.gif');

$impressao=getParam($_REQUEST, 'sem_cabecalho', 0);

$pagina = getParam($_REQUEST, 'pagina', 1);

$xtamanhoPagina = ($dialogo ? 90000 : $config['qnt_objetivos']);
$xmin = $xtamanhoPagina * ($pagina - 1); 

$df = '%d/%m/%Y';
$tf = $Aplic->getPref('formatohora');

$ordenar = getParam($_REQUEST, 'ordenar', 'objetivo_nome');
$ordem = getParam($_REQUEST, 'ordem', '0');


$sql->adTabela('objetivo');

$sql->adCampo('count(DISTINCT objetivo.objetivo_id) as soma');


if ($filtro_prioridade_objetivo){
	$sql->esqUnir('priorizacao', 'priorizacao', 'objetivo.objetivo_id=priorizacao_objetivo');
	$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_objetivo.')');
	}
	
if ($favorito_id){
	$sql->internoUnir('favorito_lista', 'favorito_lista', 'objetivo.objetivo_id=favorito_lista_campo');
	$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
	$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
	}	
elseif ($dept_id && !$lista_depts) {
	$sql->esqUnir('objetivo_dept','objetivo_dept', 'objetivo_dept_objetivo=objetivo.objetivo_id');
	$sql->adOnde('objetivo_dept='.(int)$dept_id.' OR objetivo_dept_dept='.(int)$dept_id);
	}
elseif ($lista_depts) {
	$sql->esqUnir('objetivo_dept','objetivo_dept', 'objetivo_dept_objetivo=objetivo.objetivo_id');
	$sql->adOnde('objetivo_dept IN ('.$lista_depts.') OR objetivo_dept_dept IN ('.$lista_depts.')');
	}	
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('objetivo_cia', 'objetivo_cia', 'objetivo.objetivo_id=objetivo_cia_objetivo');
	$sql->adOnde('objetivo_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR objetivo_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
	}
elseif ($cia_id && !$lista_cias) $sql->adOnde('objetivo_cia='.(int)$cia_id);
elseif ($lista_cias) $sql->adOnde('objetivo_cia IN ('.$lista_cias.')');

if ($pg_perspectiva_id) {
	$sql->esqUnir('objetivo_perspectiva', 'objetivo_perspectiva', 'objetivo.objetivo_id=objetivo_perspectiva_objetivo');
	$sql->adOnde('objetivo_perspectiva_perspectiva='.(int)$pg_perspectiva_id);
	}

if ($tab==0) $sql->adOnde('objetivo_ativo=1');
elseif ($tab==1) $sql->adOnde('objetivo_ativo!=1 OR objetivo_ativo IS NULL');
if ($usuario_id) {
	$sql->esqUnir('objetivo_usuario', 'objetivo_usuario', 'objetivo_usuario_objetivo = objetivo.objetivo_id');
	$sql->adOnde('objetivo_usuario = '.(int)$usuario_id.' OR objetivo_usuario_usuario='.(int)$usuario_id);
	}
if ($pesquisar_texto) $sql->adOnde('objetivo_nome LIKE \'%'.$pesquisar_texto.'%\' OR objetivo_descricao LIKE \'%'.$pesquisar_texto.'%\'');


if ($pg_id){
	$sql->esqUnir('plano_gestao_objetivo','plano_gestao_objetivo','plano_gestao_objetivo_objetivo=objetivo.objetivo_id');
	$sql->adOnde('plano_gestao_objetivo_plano_gestao='.(int)$pg_id);
	}
$xtotalregistros = $sql->Resultado();
$sql->limpar();


$sql->adTabela('objetivo');



$sql->adCampo('objetivo.objetivo_id, objetivo_descricao, objetivo_nome, objetivo_usuario, objetivo_acesso, objetivo_cor, objetivo_percentagem, objetivo_aprovado');

if ($filtro_prioridade_objetivo){
	$sql->esqUnir('priorizacao', 'priorizacao', 'objetivo.objetivo_id=priorizacao_objetivo');
	if ($config['metodo_priorizacao']) $sql->adCampo('(SELECT round(exp(sum(log(coalesce(priorizacao_valor,1))))) FROM priorizacao WHERE priorizacao_objetivo = objetivo.objetivo_id AND priorizacao_modelo IN ('.$filtro_prioridade_objetivo.')) AS priorizacao');
	else $sql->adCampo('(SELECT SUM(priorizacao_valor) FROM priorizacao WHERE priorizacao_objetivo = objetivo.objetivo_id AND priorizacao_modelo IN ('.$filtro_prioridade_objetivo.')) AS priorizacao');
	$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_objetivo.')');
	}
	
if ($favorito_id){
	$sql->internoUnir('favorito_lista', 'favorito_lista', 'objetivo.objetivo_id=favorito_lista_campo');
	$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
	$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
	}
elseif ($dept_id && !$lista_depts) {
	$sql->esqUnir('objetivo_dept','objetivo_dept', 'objetivo_dept_objetivo=objetivo.objetivo_id');
	$sql->adOnde('objetivo_dept='.(int)$dept_id.' OR objetivo_dept_dept='.(int)$dept_id);
	}
elseif ($lista_depts) {
	$sql->esqUnir('objetivo_dept','objetivo_dept', 'objetivo_dept_objetivo=objetivo.objetivo_id');
	$sql->adOnde('objetivo_dept IN ('.$lista_depts.') OR objetivo_dept_dept IN ('.$lista_depts.')');
	}	
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('objetivo_cia', 'objetivo_cia', 'objetivo.objetivo_id=objetivo_cia_objetivo');
	$sql->adOnde('objetivo_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR objetivo_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
	}
elseif ($cia_id && !$lista_cias) $sql->adOnde('objetivo_cia='.(int)$cia_id);
elseif ($lista_cias) $sql->adOnde('objetivo_cia IN ('.$lista_cias.')');


if ($pg_perspectiva_id) {
	$sql->esqUnir('objetivo_perspectiva', 'objetivo_perspectiva', 'objetivo.objetivo_id=objetivo_perspectiva_objetivo');
	$sql->adOnde('objetivo_perspectiva_perspectiva='.(int)$pg_perspectiva_id);
	}

if ($tab==0) $sql->adOnde('objetivo_ativo=1');
if ($tab==1) $sql->adOnde('objetivo_ativo!=1 OR objetivo_ativo IS NULL');
if ($usuario_id) {
	$sql->esqUnir('objetivo_usuario', 'objetivo_usuario', 'objetivo_usuario_objetivo = objetivo.objetivo_id');
	$sql->adOnde('objetivo_usuario = '.(int)$usuario_id.' OR objetivo_usuario_usuario='.(int)$usuario_id);
	}
if ($pesquisar_texto) $sql->adOnde('objetivo_nome LIKE \'%'.$pesquisar_texto.'%\' OR objetivo_descricao LIKE \'%'.$pesquisar_texto.'%\'');
if ($pg_id){
	$sql->esqUnir('plano_gestao_objetivo','plano_gestao_objetivo','plano_gestao_objetivo_objetivo=objetivo.objetivo_id');
	$sql->adOnde('plano_gestao_objetivo_plano_gestao='.(int)$pg_id);
	}
if ($Aplic->profissional) $sql->adCampo('(SELECT count(assinatura_id) FROM assinatura WHERE assinatura_aprova=1 AND assinatura_objetivo=objetivo.objetivo_id) AS tem_aprovacao');
$sql->adOrdem($ordenar.($ordem ? ' DESC' : ' ASC'));
$sql->adGrupo('objetivo.objetivo_id');
$sql->setLimite($xmin, $xtamanhoPagina);
$objetivos=$sql->Lista();
$sql->limpar();


$xtotal_paginas = ($xtotalregistros > $xtamanhoPagina) ? ceil($xtotalregistros / $xtamanhoPagina) : 0;

if ($xtotal_paginas > 1) mostrarBarraNav($xtotalregistros, $xtamanhoPagina, $xtotal_paginas, $pagina, ucfirst($config['objetivo']), ucfirst($config['objetivos']),'','',($estilo_interface=='classico' ? 'a6a6a6' : '006fc2'));
echo '<table width="100%" cellpadding=0 cellspacing=0 class="tbl1">';
echo '<tr>';

if (!$impressao && !$dialogo) echo '<th nowrap="nowrap">&nbsp;</th>';
echo '<th width=16><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=objetivo_cor&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='objetivo_cor' ? imagem('icones/'.$seta[$ordem]) : '').dica('Cor d'.$config['genero_objetivo'].' '.ucfirst($config['objetivo']).'', 'Neste campo fica a cor de identificação d'.$config['genero_objetivo'].' '.$config['objetivo'].'.').'Cor'.dicaF().'</a></th>';
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=objetivo_nome&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='objetivo_nome' ? imagem('icones/'.$seta[$ordem]) : '').dica('Nome d'.$config['genero_objetivo'].' '.ucfirst($config['objetivo']).'', 'Neste campo fica um nome para identificação d'.$config['genero_objetivo'].' '.$config['objetivo'].'.').'Nome'.dicaF().'</a></th>';

if ($Aplic->profissional) echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=objetivo_aprovado&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='objetivo_aprovado' ? imagem('icones/'.$seta[$ordem]) : '').dica('Aprovado', 'Neste campo consta se foi aprovado.').'Ap.'.dicaF().'</a></th>';
if ($filtro_prioridade_objetivo) echo '<th nowrap="nowrap"><a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($tab ? '&tab='.$tab : '').'&a='.$a.'&ordenar=priorizacao&ordem='.($ordem ? '0' : '1').'\');" class="hdr">'.dica('Priorização', 'Clique para ordenar pela priorização.').($ordenar=='priorizacao' ? imagem('icones/'.$seta[$ordem]) : '').'Prio.'.dicaF().'</a></th>';

echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=objetivo_descricao&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='objetivo_descricao' ? imagem('icones/'.$seta[$ordem]) : '').dica('Descrição d'.$config['genero_objetivo'].' '.ucfirst($config['objetivo']).'', 'Neste campo fica a descrição d'.$config['genero_objetivo'].' '.$config['objetivo'].'.').'Descrição'.dicaF().'</a></th>';
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($a ? '&a='.$a : '').($tab ? '&tab='.$tab : '').'&ordenar=objetivo_usuario&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='objetivo_usuario' ? imagem('icones/'.$seta[$ordem]) : '').dica('Responsável', 'O '.$config['usuario'].' responsável pel'.$config['genero_objetivo'].' '.$config['objetivo'].'.').'Responsável'.dicaF().'</a></th>';
echo '<th nowrap="nowrap">'.dica('Designados', 'Neste campo fica os designados para '.$config['genero_objetivo'].'s '.$config['objetivos'].'.').'Designados'.dicaF().'</th>';

if ($Aplic->profissional) echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($a ? '&a='.$a : '').($tab ? '&tab='.$tab : '').'&ordenar=objetivo_percentagem&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='objetivo_percentagem' ? imagem('icones/'.$seta[$ordem]) : '').dica('Percentagem', 'A percentagem d'.$config['genero_objetivo'].' '.$config['objetivo'].' executada.').'%'.dicaF().'</a></th>';
echo '</tr>';
$qnt=0;
foreach ($objetivos as $linha) {
	if (permiteAcessarObjetivo($linha['objetivo_acesso'],$linha['objetivo_id'])){
		$qnt++;
		$editar=permiteEditarObjetivo($linha['objetivo_acesso'],$linha['objetivo_id']);
		
		if ($Aplic->profissional) $bloquear=($linha['objetivo_aprovado'] && $config['trava_aprovacao'] && $linha['tem_aprovacao'] && !$Aplic->usuario_super_admin);
		else $bloquear=0;
		
		echo '<tr>';
		if (!$impressao && !$dialogo) echo '<td nowrap="nowrap" width="16">'.($podeEditar && $editar && !$bloquear ? dica('Editar '.ucfirst($config['objetivo']).'', 'Clique neste ícone '.imagem('icones/editar.gif').' para editar '.$config['genero_objetivo'].' '.$config['objetivo'].'.').'<a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a=obj_estrategico_editar&objetivo_id='.$linha['objetivo_id'].'\');">'.imagem('icones/editar.gif').'</a>'.dicaF() : '&nbsp;').'</td>';
		echo '<td id="ignore_td_" width="15" align="right" style="background-color:#'.$linha['objetivo_cor'].'"><font color="'.melhorCor($linha['objetivo_cor']).'">&nbsp;&nbsp;</font></td>';
		echo '<td>'.link_objetivo($linha['objetivo_id'],'','','','','',true).'</td>';
		
		if ($Aplic->profissional) echo '<td width=30 align="center">'.($linha['objetivo_aprovado'] && $linha['tem_aprovacao'] ? 'Sim' : ($linha['tem_aprovacao'] ? 'Não' : 'N/A')).'</td>';
		if ($filtro_prioridade_objetivo) echo '<td align="right" nowrap="nowrap" width=50>'.($linha['priorizacao']).'</td>';

		
		echo '<td>'.($linha['objetivo_descricao'] ? $linha['objetivo_descricao']: '&nbsp;').'</td>';
		echo '<td nowrap="nowrap">'.link_usuario($linha['objetivo_usuario'],'','','esquerda').'</td>';
		
		$sql->adTabela('objetivo_usuario');
		$sql->adCampo('objetivo_usuario_usuario');
		$sql->adOnde('objetivo_usuario_objetivo = '.(int)$linha['objetivo_id']);
		$participantes = $sql->carregarColuna();
		$sql->limpar();
		
		$saida_quem='';
		if ($participantes && count($participantes)) {
				$saida_quem.= link_usuario($participantes[0], '','','esquerda');
				$qnt_participantes=count($participantes);
				if ($qnt_participantes > 1) {		
						$lista='';
						for ($i = 1, $i_cmp = $qnt_participantes; $i < $i_cmp; $i++) $lista.=link_usuario($participantes[$i], '','','esquerda').'<br>';		
						$saida_quem.= dica('Outros Participantes', 'Clique para visualizar os demais participantes.').'<a href="javascript: void(0);" onclick="expandir_colapsar(\'participantes_'.$linha['objetivo_id'].'\');">(+'.($qnt_participantes - 1).')</a>'.dicaF(). '<span style="display: none" id="participantes_'.$linha['objetivo_id'].'"><br>'.$lista.'</span>';
						}
				} 
		echo '<td align="left" nowrap="nowrap">'.($saida_quem ? $saida_quem : '&nbsp;').'</td>';
		
		if ($Aplic->profissional) echo '<td nowrap="nowrap" align=right width=30>'.number_format($linha['objetivo_percentagem'], 2, ',', '.').'</td>';
		echo '</tr>';
		}
	}
if (!count($objetivos)) echo '<tr><td colspan="8"><p>Nenh'.($config['genero_objetivo']=='o' ? 'um' : 'uma').' '.$config['objetivo'].' encontrado.</p></td></tr>';
elseif(count($objetivos) && !$qnt) echo '<tr><td colspan="20"><p>Não teve permissão de visualizar qualquer d'.$config['genero_objetivo'].'s '.$config['objetivos'].'.</p></td></tr>';
echo '</table>';

if ($impressao) echo '<script language=Javascript>self.print();</script>';

?>
<script type="text/javascript">
function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}
</script>	