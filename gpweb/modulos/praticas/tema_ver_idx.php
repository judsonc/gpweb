<?php 
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


if (!defined('BASE_DIR')) die('Voc� n�o deveria acessar este arquivo diretamente.');

global $estilo_interface, $sql, $perms, $dialogo, $Aplic, $cia_id, $dept_id, $lista_depts, $tab, $lista_cias, $favorito_id, $usuario_id, $pesquisar_texto, $pg_id, $pg_perspectiva_id, $podeEditar, $filtro_prioridade_tema;

$seta=array('0'=>'seta-cima.gif', '1'=>'seta-baixo.gif');

$impressao=getParam($_REQUEST, 'sem_cabecalho', 0);

$pagina = getParam($_REQUEST, 'pagina', 1);

$xtamanhoPagina = ($impressao || $dialogo ? 90000 : $config['qnt_tema']);
$xmin = $xtamanhoPagina * ($pagina - 1); 

$df = '%d/%m/%Y';
$tf = $Aplic->getPref('formatohora');

$ordenar = getParam($_REQUEST, 'ordenar', 'tema_nome');
$ordem = getParam($_REQUEST, 'ordem', '0');




$sql->adTabela('tema');
$sql->adCampo('count(DISTINCT tema.tema_id)');

if ($filtro_prioridade_tema){
	$sql->esqUnir('priorizacao', 'priorizacao', 'tema.tema_id=priorizacao_tema');
	$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_tema.')');
	}

if ($favorito_id){
	$sql->internoUnir('favorito_lista', 'favorito_lista', 'tema.tema_id=favorito_lista_campo');
	$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
	$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
	}
elseif ($dept_id && !$lista_depts) {
	$sql->esqUnir('tema_depts','tema_depts', 'tema_depts.tema_id=tema.tema_id');
	$sql->adOnde('tema_dept='.(int)$dept_id.' OR tema_depts.dept_id='.(int)$dept_id);
	}
elseif ($lista_depts) {
	$sql->esqUnir('tema_depts','tema_depts', 'tema_depts.tema_id=tema.tema_id');
	$sql->adOnde('tema_dept IN ('.$lista_depts.') OR tema_depts.dept_id IN ('.$lista_depts.')');
	}	
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('tema_cia', 'tema_cia', 'tema.tema_id=tema_cia_tema');
	$sql->adOnde('tema_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR tema_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
	}
else if ($cia_id && !$lista_cias) $sql->adOnde('tema_cia='.(int)$cia_id);
elseif ($lista_cias) $sql->adOnde('tema_cia IN ('.$lista_cias.')');	

if ($pg_perspectiva_id) {
	$sql->esqUnir('tema_perspectiva', 'tema_perspectiva', 'tema.tema_id=tema_perspectiva_tema');
	$sql->adOnde('tema_perspectiva_perspectiva='.(int)$pg_perspectiva_id);
	}


if ($tab==0) $sql->adOnde('tema_ativo=1');
elseif ($tab==1) $sql->adOnde('tema_ativo!=1 OR tema_ativo IS NULL'); 	

if ($pg_id){
	$sql->esqUnir('plano_gestao_tema','plano_gestao_tema','plano_gestao_tema.tema_id=tema.tema_id');
	$sql->esqUnir('plano_gestao','plano_gestao','plano_gestao.pg_id=plano_gestao_tema.pg_id');
	$sql->adOnde('plano_gestao.pg_id='.(int)$pg_id);
	}
if ($usuario_id) {
	$sql->esqUnir('tema_usuarios', 'tema_usuarios', 'tema_usuarios.tema_id = tema.tema_id');
	$sql->adOnde('tema_usuario = '.(int)$usuario_id.' OR tema_usuarios.usuario_id='.(int)$usuario_id);
	}
if ($pesquisar_texto) $sql->adOnde('tema_nome LIKE \'%'.$pesquisar_texto.'%\' OR tema_descricao LIKE \'%'.$pesquisar_texto.'%\'');

$xtotalregistros = $sql->Resultado();
$sql->limpar();


$sql->adTabela('tema');
$sql->adCampo('tema.tema_id, tema_nome, tema_usuario, tema_acesso, tema_cor, tema_descricao, tema_percentagem, tema_aprovado');

if ($filtro_prioridade_tema){
	$sql->esqUnir('priorizacao', 'priorizacao', 'tema.tema_id=priorizacao_tema');
	if ($config['metodo_priorizacao']) $sql->adCampo('(SELECT round(exp(sum(log(coalesce(priorizacao_valor,1))))) FROM priorizacao WHERE priorizacao_tema = tema.tema_id AND priorizacao_modelo IN ('.$filtro_prioridade_tema.')) AS priorizacao');
	else $sql->adCampo('(SELECT SUM(priorizacao_valor) FROM priorizacao WHERE priorizacao_tema = tema.tema_id AND priorizacao_modelo IN ('.$filtro_prioridade_tema.')) AS priorizacao');
	$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_tema.')');
	}

if ($favorito_id){
	$sql->internoUnir('favorito_lista', 'favorito_lista', 'tema.tema_id=favorito_lista_campo');
	$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
	$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
	}
elseif ($dept_id && !$lista_depts) {
	$sql->esqUnir('tema_depts','tema_depts', 'tema_depts.tema_id=tema.tema_id');
	$sql->adOnde('tema_dept='.(int)$dept_id.' OR tema_depts.dept_id='.(int)$dept_id);
	}
elseif ($lista_depts) {
	$sql->esqUnir('tema_depts','tema_depts', 'tema_depts.tema_id=tema.tema_id');
	$sql->adOnde('tema_dept IN ('.$lista_depts.') OR tema_depts.dept_id IN ('.$lista_depts.')');
	}	
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('tema_cia', 'tema_cia', 'tema.tema_id=tema_cia_tema');
	$sql->adOnde('tema_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR tema_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
	}
else if ($cia_id && !$lista_cias) $sql->adOnde('tema_cia='.(int)$cia_id);
elseif ($lista_cias) $sql->adOnde('tema_cia IN ('.$lista_cias.')');	

if ($pg_perspectiva_id) {
	$sql->esqUnir('tema_perspectiva', 'tema_perspectiva', 'tema.tema_id=tema_perspectiva_tema');
	$sql->adOnde('tema_perspectiva_perspectiva='.(int)$pg_perspectiva_id);
	}
	
if ($tab==0) $sql->adOnde('tema_ativo=1');
elseif ($tab==1) $sql->adOnde('tema_ativo!=1 OR tema_ativo IS NULL');	

if ($pg_id){
	$sql->esqUnir('plano_gestao_tema','plano_gestao_tema','plano_gestao_tema.tema_id=tema.tema_id');
	$sql->esqUnir('plano_gestao','plano_gestao','plano_gestao.pg_id=plano_gestao_tema.pg_id');
	$sql->adOnde('plano_gestao.pg_id='.(int)$pg_id);
	}
if ($usuario_id) {
	$sql->esqUnir('tema_usuarios', 'tema_usuarios', 'tema_usuarios.tema_id = tema.tema_id');
	$sql->adOnde('tema_usuario = '.(int)$usuario_id.' OR tema_usuarios.usuario_id='.(int)$usuario_id);
	}
if ($pesquisar_texto) $sql->adOnde('tema_nome LIKE \'%'.$pesquisar_texto.'%\' OR tema_descricao LIKE \'%'.$pesquisar_texto.'%\'');

if ($Aplic->profissional) $sql->adCampo('(SELECT count(assinatura_id) FROM assinatura WHERE assinatura_aprova=1 AND assinatura_tema=tema.tema_id) AS tem_aprovacao');

$sql->adOrdem($ordenar.($ordem ? ' DESC' : ' ASC'));

$sql->adGrupo('tema.tema_id');
$sql->setLimite($xmin, $xtamanhoPagina);
$temas=$sql->Lista();
$sql->limpar();


$xtotal_paginas = ($xtotalregistros > $xtamanhoPagina) ? ceil($xtotalregistros / $xtamanhoPagina) : 0;
if ($xtotal_paginas > 1) mostrarBarraNav($xtotalregistros, $xtamanhoPagina, $xtotal_paginas, $pagina, ucfirst($config['tema']), ucfirst($config['temas']),'','&ordenar='.$ordenar.'&ordem='.$ordem,($estilo_interface=='classico' ? 'a6a6a6' : '006fc2'));


echo '<table width="100%" cellpadding=0 cellspacing=0 class="tbl1">';
echo '<tr>';

if (!$impressao && !$dialogo) echo '<th nowrap="nowrap">&nbsp;</th>';
echo '<th width=16><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=tema_cor&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='tema_cor' ? imagem('icones/'.$seta[$ordem]) : '').dica('Cor d'.$config['genero_tema'].' '.ucfirst($config['tema']).'', 'Neste campo fica a cor de identifica��o d'.$config['genero_tema'].' '.$config['tema'].'.').'Cor'.dicaF().'</a></th>';
echo '<th><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=tema_nome&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='tema_nome' ? imagem('icones/'.$seta[$ordem]) : '').dica('Nome d'.$config['genero_tema'].' '.ucfirst($config['tema']).'', 'Neste campo fica um nome para identifica��o d'.$config['genero_tema'].' '.$config['tema'].'.').'Nome'.dicaF().'</a></th>';

if ($Aplic->profissional) echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=tema_aprovado&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='tema_aprovado' ? imagem('icones/'.$seta[$ordem]) : '').dica('Aprovado', 'Neste campo consta se foi aprovado.').'Ap.'.dicaF().'</a></th>';
if ($filtro_prioridade_tema) echo '<th nowrap="nowrap"><a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($tab ? '&tab='.$tab : '').'&a='.$a.'&ordenar=priorizacao&ordem='.($ordem ? '0' : '1').'\');" class="hdr">'.dica('Prioriza��o', 'Clique para ordenar pela prioriza��o.').($ordenar=='priorizacao' ? imagem('icones/'.$seta[$ordem]) : '').'Prio.'.dicaF().'</a></th>';

echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=tema_descricao&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='tema_descricao' ? imagem('icones/'.$seta[$ordem]) : '').dica('Descri��o d'.$config['genero_tema'].' '.ucfirst($config['tema']).'', 'Neste campo fica a descri��o d'.$config['genero_tema'].' '.$config['tema'].'.').'Descri��o'.dicaF().'</a></th>';
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($a ? '&a='.$a : '').($tab ? '&tab='.$tab : '').'&ordenar=tema_usuario&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='tema_usuario' ? imagem('icones/'.$seta[$ordem]) : '').dica('Respons�vel', 'O '.$config['usuario'].' respons�vel pel'.$config['genero_tema'].' '.$config['tema'].'.').'Respons�vel'.dicaF().'</a></th>';
echo '<th nowrap="nowrap">'.dica('Designados', 'Neste campo fica os designados para '.$config['genero_tema'].'s '.$config['temas'].'.').'Designados'.dicaF().'</th>';
if ($Aplic->profissional) echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.($a ? '&a='.$a : '').($tab ? '&tab='.$tab : '').'&ordenar=tema_percentagem&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='tema_percentagem' ? imagem('icones/'.$seta[$ordem]) : '').dica('Percentagem', 'A percentagem d'.$config['genero_tema'].' '.$config['tema'].' executada.').'%'.dicaF().'</a></th>';

echo '</tr>';
$qnt=0;

foreach ($temas as $linha) {
	if (permiteAcessarTema($linha['tema_acesso'],$linha['tema_id'])){
		$qnt++;
		$editar=permiteEditarTema($linha['tema_acesso'],$linha['tema_id']);
		
		if ($Aplic->profissional) $bloquear=($linha['tema_aprovado'] && $config['trava_aprovacao'] && $linha['tem_aprovacao'] && !$Aplic->usuario_super_admin);
		else $bloquear=0;
		
		echo '<tr>';
		if (!$impressao && !$dialogo) echo '<td nowrap="nowrap" width="16">'.($podeEditar && $editar && !$bloquear ? dica('Editar '.ucfirst($config['tema']), 'Clique neste �cone '.imagem('icones/editar.gif').' para editar '.$config['genero_tema'].' '.$config['tema'].'.').'<a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a=tema_editar&tema_id='.$linha['tema_id'].'\');">'.imagem('icones/editar.gif').'</a>'.dicaF() : '&nbsp;').'</td>';
		echo '<td id="ignore_td_" width="16" align="right" style="background-color:#'.$linha['tema_cor'].'"><font color="'.melhorCor($linha['tema_cor']).'">&nbsp;&nbsp;</font></td>';
		echo '<td>'.link_tema($linha['tema_id'],'','','','','',true).'</td>';
		
		if ($Aplic->profissional) echo '<td width=30 align="center">'.($linha['tema_aprovado'] && $linha['tem_aprovacao'] ? 'Sim' : ($linha['tem_aprovacao'] ? 'N�o' : 'N/A')).'</td>';
		if ($filtro_prioridade_tema) echo '<td align="right" nowrap="nowrap" width=50>'.($linha['priorizacao']).'</td>';

		echo '<td>'.($linha['tema_descricao'] ? $linha['tema_descricao']: '&nbsp;').'</td>';
		echo '<td nowrap="nowrap">'.link_usuario($linha['tema_usuario'],'','','esquerda').'</td>';
		
		$sql->adTabela('tema_usuarios');
		$sql->adCampo('usuario_id');
		$sql->adOnde('tema_id = '.(int)$linha['tema_id']);
		$participantes = $sql->carregarColuna();
		$sql->limpar();
		
		$saida_quem='';
		if ($participantes && count($participantes)) {
				$saida_quem.= link_usuario($participantes[0], '','','esquerda');
				$qnt_participantes=count($participantes);
				if ($qnt_participantes > 1) {		
						$lista='';
						for ($i = 1, $i_cmp = $qnt_participantes; $i < $i_cmp; $i++) $lista.=link_usuario($participantes[$i], '','','esquerda').'<br>';		
						$saida_quem.= dica('Outros Participantes', 'Clique para visualizar os demais participantes.').'<a href="javascript: void(0);" onclick="expandir_colapsar(\'participantes_'.$linha['tema_id'].'\');">(+'.($qnt_participantes - 1).')</a>'.dicaF(). '<span style="display: none" id="participantes_'.$linha['tema_id'].'"><br>'.$lista.'</span>';
						}
				} 
		echo '<td align="left" nowrap="nowrap">'.($saida_quem ? $saida_quem : '&nbsp;').'</td>';
		
		if ($Aplic->profissional) echo '<td nowrap="nowrap" align=right width=30>'.number_format($linha['tema_percentagem'], 2, ',', '.').'</td>';
		echo '</tr>';
		}
	}
if (!count($temas)) echo '<tr><td colspan="8"><p>Nenh'.($config['genero_tema']=='o' ? 'um' : 'uma').' '.$config['tema'].' encontrado.</p></td></tr>';
elseif(count($temas) && !$qnt) echo '<tr><td colspan="20"><p>N�o teve permiss�o de visualizar qualquer d'.$config['genero_tema'].'s '.$config['temas'].'.</p></td></tr>';
echo '</table>';

if ($impressao) echo '<script language=Javascript>self.print();</script>';

?>
<script type="text/javascript">
function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}
</script>	