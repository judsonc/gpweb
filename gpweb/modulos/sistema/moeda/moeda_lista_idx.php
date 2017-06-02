<?php 
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');

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
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&u='.$u.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=moeda_nome&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='moeda_nome' ? imagem('icones/'.$seta[$ordem]) : '').dica('Nome', 'Neste campo fica um nome para identificação da moeda.').'Nome'.dicaF().'</a></th>';
echo '<th nowrap="nowrap"><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&u='.$u.'&a='.$a.($tab ? '&tab='.$tab : '').'&ordenar=moeda_simbolo&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='moeda_simbolo' ? imagem('icones/'.$seta[$ordem]) : '').dica('Símbolo', 'Neste campo fica o símbolo que identifica a moeda.').'Símbolo'.dicaF().'</a></th>';
echo '<th nowrap="nowrap">'.dica('Data', 'Neste campo fica a última data de cotação da moeda.').'Data'.dicaF().'</a></th>';
echo '<th nowrap="nowrap">'.dica('Cotação', 'Neste campo fica a última cotação da moeda.').'Cotação'.dicaF().'</a></th>';
echo '</tr>';

foreach ($moeda as $linha) {
	echo '<tr>';
	if (!$dialogo) echo '<td nowrap="nowrap" width="16">'.dica('Editar', 'Clique neste ícone '.imagem('icones/editar.gif').' para editar a moeda.').'<a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&u='.$u.'&a=moeda_editar&moeda_id='.$linha['moeda_id'].'\');">'.imagem('icones/editar.gif').'</a>'.dicaF().'</td>';
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