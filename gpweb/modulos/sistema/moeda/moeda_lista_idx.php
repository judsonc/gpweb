<?php 
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

if (!defined('BASE_DIR')) die('Voc� n�o deveria acessar este arquivo diretamente.');

global $estilo_interface, $sql, $perms, $dialogo, $Aplic, $tab, $u, $a, $m, $pesquisar_texto;

$seta=array('0'=>'seta-cima.gif', '1'=>'seta-baixo.gif');

$impressao=getParam($_REQUEST, 'sem_cabecalho', 0);

$pagina = getParam($_REQUEST, 'pagina', 1);

$xtamanhoPagina = 90000;
$xmin = $xtamanhoPagina * ($pagina - 1); 


$ordenar = getParam($_REQUEST, 'ordenar', 'moeda_nome');
$ordem = getParam($_REQUEST, 'ordem', '0');

$sql->adTabela('moeda');
$sql->adCampo('count(DISTINCT moeda.moeda_id)');
if ($tab==0) $sql->adOnde('moeda_ativo=1');
elseif ($tab==1) $sql->adOnde('moeda_ativo!=1 OR moeda_ativo IS NULL');	
if ($pesquisar_texto) $sql->adOnde('moeda_nome LIKE \'%'.$pesquisar_texto.'%\' OR moeda_simbolo LIKE \'%'.$pesquisar_texto.'%\'');
$xtotalregistros = $sql->Resultado();
$sql->limpar();


$sql->adTabela('moeda');
$sql->adCampo('moeda_id, moeda_nome, moeda_simbolo');
if ($tab==0) $sql->adOnde('moeda_ativo=1');
elseif ($tab==1) $sql->adOnde('moeda_ativo!=1 OR moeda_ativo IS NULL');	
if ($pesquisar_texto) $sql->adOnde('moeda_nome LIKE \'%'.$pesquisar_texto.'%\' OR moeda_simbolo LIKE \'%'.$pesquisar_texto.'%\'');
$sql->adOrdem($ordenar.($ordem ? ' DESC' : ' ASC'));
$sql->setLimite($xmin, $xtamanhoPagina);
$moeda=$sql->Lista();
$sql->limpar();



$xtotal_paginas = ($xtotalregistros > $xtamanhoPagina) ? ceil($xtotalregistros / $xtamanhoPagina) : 0;
if ($xtotal_paginas > 1) mostrarBarraNav($xtotalregistros, $xtamanhoPagina, $xtotal_paginas, $pagina, 'Moeda', 'Moeda','','&ordenar='.$ordenar.'&ordem='.$ordem,($estilo_interface=='classico' ? 'a6a6a6' : '006fc2'));


echo '<table width="100%" cellpadding=0 cellspacing=0 class="tbl1">';
echo '<tr>';
if (!$impressao && !$dialogo) echo '<th nowrap="nowrap">&nbsp;</th>';
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&u='.$u.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=moeda_nome&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='moeda_nome' ? imagem('icones/'.$seta[$ordem]) : '').dica('Nome', 'Neste campo fica um nome para identifica��o da moeda.').'Nome'.dicaF().'</a></th>';
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&u='.$u.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=moeda_simbolo&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='moeda_simbolo' ? imagem('icones/'.$seta[$ordem]) : '').dica('S�mbolo', 'Neste campo fica o s�mbolo que identifica a moeda.').'S�mbolo'.dicaF().'</a></th>';
echo '<th nowrap="nowrap">'.dica('Data', 'Neste campo fica a �ltima data de cota��o da moeda.').'Data'.dicaF().'</a></th>';
echo '<th nowrap="nowrap">'.dica('Cota��o', 'Neste campo fica a �ltima cota��o da moeda.').'Cota��o'.dicaF().'</a></th>';
echo '</tr>';

foreach ($moeda as $linha) {
	echo '<tr>';
	if (!$dialogo) echo '<td nowrap="nowrap" width="16">'.dica('Editar', 'Clique neste �cone '.imagem('icones/editar.gif').' para editar a moeda.').'<a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&u='.$u.'&a=moeda_editar&moeda_id='.$linha['moeda_id'].'\');">'.imagem('icones/editar.gif').'</a>'.dicaF().'</td>';
	echo '<td>'.dica($linha['moeda_nome'], 'Clique para visualizar os detalhes desta moeda.').'<a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&u='.$u.'&a=moeda_ver&moeda_id='.$linha['moeda_id'].'\');">'.$linha['moeda_nome'].'</a></td>';
	echo '<td>'.$linha['moeda_simbolo'].'</td>';
	
	$sql->adTabela('moeda_cotacao');
	$sql->adCampo('formatar_data(moeda_cotacao_data, \'%d/%m/%Y\') AS data, moeda_cotacao_cotacao');
	$sql->adOnde('moeda_cotacao_moeda ='.(int)$linha['moeda_id']);	
	$sql->adOrdem('moeda_cotacao_data DESC');
	$sql->setLimite(0, 1);
	$valor = $sql->linha();
	$sql->limpar();
	
	echo '<td align=center>'.($linha['moeda_id'] !=1 ? $valor['data'] : 'N/A').'</td><td align=right>'.($linha['moeda_id'] !=1 ? number_format($valor['moeda_cotacao_cotacao'], 4, ',', '.') : 'N/A').'</td>';
	
	echo '</tr>';
	}
if (!count($moeda)) echo '<tr><td colspan=20><p>Nenhuma moeda encontrada.</p></td></tr>';
echo '</table>';

?>