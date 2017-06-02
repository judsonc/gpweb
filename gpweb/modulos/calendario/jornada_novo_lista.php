<?php 
/* 
Copyright (c) 2007-2011 The web2Project Development Team <w2p-developers@web2project.net>
Copyright (c) 2003-2007 The dotProject Development Team <core-developers@dotproject.net>
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');
global $estilo_interface;

if (isset($_REQUEST['expedientetextobusca'])) $Aplic->setEstado('expedientetextobusca', getParam($_REQUEST, 'expedientetextobusca', null));
$pesquisar_texto = ($Aplic->getEstado('expedientetextobusca') ? $Aplic->getEstado('expedientetextobusca') : '');

$painel_filtro = $Aplic->getEstado('painel_filtro') !== null ? $Aplic->getEstado('painel_filtro') : 0;

echo '<form name="frm_filtro" method="POST">';
echo '<input type="hidden" name="m" value="'.$m.'" />';
echo '<input type="hidden" name="a" value="'.$a.'" />';
echo '<input type="hidden" name="u" value="" />';

if (!$dialogo && $Aplic->profissional){
	$Aplic->salvarPosicao();
	$botoesTitulo = new CBlocoTitulo('Lista de Bases de Expedientes', 'calendario.png', $m, $m.'.'.$a);
	$saida='<div id="filtro_container" style="border: 1px solid #'.($estilo_interface=='metro' ? '006fc2' : 'a6a6a6').'; margin-bottom: 2px; -webkit-border-radius: 4px; border-radius:4px; -moz-border-radius: 4px;">';
  $saida.=dica('Filtros e Ações','Clique nesta barra para esconder/mostrar os filtros e as ações permitidas.').'<div id="filtro_titulo" style="background-color: #'.($estilo_interface=='metro' ? '006fc2' : 'a6a6a6').'; font-size: 8pt; font-weight: bold;" onclick="$jq(\'#filtro_content\').toggle(); xajax_painel_filtro(document.getElementById(\'filtro_content\').style.display);"><a class="aba" href="javascript:void(0);">'.imagem('icones/calendario_p.png').'&nbsp;Filtros e Ações</a></div>'.dicaF();
  $saida.='<div id="filtro_content" style="display:'.($painel_filtro ? '' : 'none').'">';
  $saida.='<table cellspacing=0 cellpadding=0>';
	$vazio='<tr><td colspan=2>&nbsp;</td></tr>';
	$procuraBuffer = '<tr><td align=right nowrap="nowrap">'.dica('Pesquisar', 'Pesquisar pelo nome e campos de descrição').'Pesquisar:'.dicaF().'</td><td><input type="text" class="texto" style="width:250px;" name="expedientetextobusca" onChange="document.env.submit();" value="'.$pesquisar_texto.'"/></td><td><a href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&u='.$u.'&expedientetextobusca=\');">'.imagem('icones/limpar_p.gif','Limpar Pesquisa', 'Clique neste ícone '.imagem('icones/limpar_p.gif').' para limpar a caixa texto de pesquisa.').'</a></td></tr>';
	$novo_expediente='<tr><td nowrap="nowrap" align=right><a href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=calendario&a=jornada_novo_editar\');" >'.imagem('icones/calendario_novo.png', 'Nova Base de Expediente', 'Clique neste ícone '.imagem('icones/calendario_novo.png').' para criar uma nova base de expediente').'</a></td></tr>';
	$saida.='<tr><td><table cellspacing=0 cellpadding=0>'.$procuraBuffer.'</table></td><td><table cellspacing=0 cellpadding=0>'.$novo_expediente.'</table></td></tr></table>';
	$saida.= '</div></div>';
	$botoesTitulo->adicionaBotao('', 'expediente','','Expediente','Clique neste botão para ver a interface do expediente.', 'url_passar(0, \'m=calendario&a=jornada\');');
	$botoesTitulo->adicionaCelula($saida);
	$botoesTitulo->mostrar();
	}
elseif (!$dialogo && !$Aplic->profissional){
	$botoesTitulo = new CBlocoTitulo('Lista de Bases de Expedientes', 'calendario.png', $m, $m.'.'.$a);
	$botoesTitulo->adicionaBotao('', 'expediente','','Expediente','Clique neste botão para ver a interface do expediente.', 'url_passar(0, \'m=calendario&a=jornada\');');
	$botoesTitulo->adicionaCelula('<table width=75><tr><td nowrap="nowrap">'.dica('Nova Base de Expediente', 'Criar uma nova base de expediente.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=calendario&a=jornada_novo_editar\');" ><span>nova&nbsp;base</span></a>'.dicaF().'</td></tr></table>');
	$botoesTitulo->mostrar();
	}

echo '</form>';




$pagina = getParam($_REQUEST, 'pagina', 1);
$ordem = getParam($_REQUEST, 'ordem', '0');
$seta=array('0'=>'seta-cima.gif', '1'=>'seta-baixo.gif');

$ordenar='jornada_nome';


$xpg_tamanhoPagina = 20;
$xpg_min = $xpg_tamanhoPagina * ($pagina - 1); 


$sql = new BDConsulta();
$sql->adTabela('jornada');
$sql->adCampo('jornada.*');
if ($pesquisar_texto) $sql->adOnde('jornada_nome LIKE \'%'.$pesquisar_texto.'%\'');
$sql->adOrdem($ordenar);
$jornadas = $sql->Lista();
$sql->limpar();

echo estiloTopoCaixa();

$xpg_totalregistros = ($jornadas ? count($jornadas) : 0);
$xpg_total_paginas = ($xpg_totalregistros > $xpg_tamanhoPagina) ? ceil($xpg_totalregistros / $xpg_tamanhoPagina) : 0;
if ($xpg_total_paginas > 1) mostrarBarraNav($xpg_totalregistros, $xpg_tamanhoPagina, $xpg_total_paginas, $pagina, 'Base de Expedientes', 'Bases de Expedientes','','',($estilo_interface=='classico' ? 'a6a6a6' : '006fc2'));
echo '<table width="100%" cellpadding=0 cellspacing=0 class="tbl1">';
$qnt=0;
for ($i = ($pagina - 1) * $xpg_tamanhoPagina; $i < $pagina * $xpg_tamanhoPagina && $i < $xpg_totalregistros; $i++) {
	$linha = $jornadas[$i];
	echo '<tr>';
	echo '<td nowrap="nowrap" width="16">'.dica('Editar Link', 'Clique neste ícone '.imagem('icones/editar.gif').' para editar a base de expediente.').'<a href="javascript:void(0);" onclick="url_passar(0, \'m=calendario&a=jornada_novo_editar&jornada_id='.$linha['jornada_id'].'\');">'.imagem('icones/editar.gif').'</a>'.dicaF().'</td>';
	echo '<td >'.dica($linha['jornada_nome'], 'Clique para visualizar os detalhes desta base de expediente.').'<a href="javascript:void(0);" onclick="url_passar(0, \'m=calendario&a=jornada&jornada_id='.$linha['jornada_id'].'\');">'.$linha['jornada_nome'].'</a>'.dicaF().'</td>';
	echo '</tr>';
	}
if (!count($jornadas)) echo '<tr><td colspan=20><p>Nenhuma base de expediente encontrada.</p></td></tr>';
echo '</table>';



echo estiloFundoCaixa();
?>
<script type="text/javascript">


</script>