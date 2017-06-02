<?php 
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');

global $Aplic, $config;
$df = '%d/%m/%Y';
$tf = $Aplic->getPref('formatohora');
$projeto_id=getParam($_REQUEST, 'projeto_id', 0);
$tipo=getParam($_REQUEST, 'tipo', '');
$unidade=getSisValor('TipoUnidade');
if (!$podeAcessar) $Aplic->redirecionar('m=publico&a=acesso_negado&err=noedit');
$nd=array(0 => '');
$nd+= getSisValorND();
echo '<link rel="stylesheet" type="text/css" href="estilo/rondon/estilo_'.$config['estilo_css'].'.css">';
echo '<a href=\'javascript:self.print()\'><center><h1>'.($tipo=='estimado' ? 'Custos Estimados' : 'Gastos').'  - '.nome_projeto($projeto_id).'<h1></center></a>';
echo '<table width="100%" border=0 cellpadding=0 cellspacing=0 class="std2">';
echo '<tr><td valign="top" align="center">';
$sql = new BDConsulta;

$sql->adTabela('campo_formulario');
$sql->adCampo('campo_formulario_campo, campo_formulario_ativo');
$sql->adOnde('campo_formulario_tipo = \'valor\'');
$sql->adOnde('campo_formulario_usuario IS NULL OR campo_formulario_usuario=0');
$exibir = $sql->listaVetorChave('campo_formulario_campo','campo_formulario_ativo');
$sql->limpar();


if ($tipo=='estimado'){
	$sql->adTabela('tarefa_custos', 't');
	$sql->adCampo('t.*,((tarefa_custos_quantidade*tarefa_custos_custo*tarefa_custos_cotacao)*((100+tarefa_custos_bdi)/100)) AS valor ');
	$sql->adOnde('t.tarefa_custos_tarefa IN (select tarefa_id from tarefas WHERE tarefa_projeto='.$projeto_id.')');
	if ($Aplic->profissional && $config['aprova_custo']) $sql->adOnde('tarefa_custos_aprovado = 1');
	$sql->adOrdem('tarefa_custos_tarefa, tarefa_custos_ordem');	
	}
else {
	$sql->adTabela('tarefa_gastos', 't');
	$sql->adCampo('t.*,((tarefa_gastos_quantidade*tarefa_gastos_custo*tarefa_gastos_cotacao)*((100+tarefa_gastos_bdi)/100)) AS valor ');
	$sql->adOnde('t.tarefa_gastos_tarefa IN (select tarefa_id from tarefas WHERE tarefa_projeto='.$projeto_id.')');
	if ($Aplic->profissional && $config['aprova_gasto']) $sql->adOnde('tarefa_gastos_aprovado = 1');
	$sql->adOrdem('tarefa_gastos_tarefa, tarefa_gastos_ordem');
	}
$linhas= $sql->Lista();
$qnt=0;
echo '<table width="100%" cellpadding=0 cellspacing=0 class="tbl1">';
echo '<tr>
<td><b><center>Nome</center></b></td>
<td><b><center>Descrição</center></b></td>
<td><b><center>Unidade</center></b></td>
<td width="40"><b><center>Qnt.</center></b></td>
<td><b><center>Valor</center></b></td>'.
($config['bdi'] ? '<td><b><center>BDI (%)</center></b></td>' : '').
'<td><b><center>ND</center></b></td>
<td width="100"><b><center>Total</center></b></td>'.
(isset($exibir['codigo']) && $exibir['codigo'] ? '<td><b><center>'.ucfirst($config['codigo_valor']).'</center></b></td>' : '').
(isset($exibir['fonte']) && $exibir['fonte'] ? '<td><b><center>'.ucfirst($config['fonte_valor']).'</center></b></td>' : '').
(isset($exibir['regiao']) && $exibir['regiao'] ? '<td><b><center>'.ucfirst($config['regiao_valor']).'</center></b></td>' : '').
'<td><b><center>Responsável</center></b></td>
</tr>';
$total=0;
$custo=array();
$tarefa=0;
foreach ($linhas as $linha) {
	if ($tipo=='estimado'){
		if ($tarefa!=$linha['tarefa_custos_tarefa']){
			echo '<tr><td align="left" colspan=20>'.nome_tarefa($linha['tarefa_custos_tarefa']).'</td></tr>';
			$tarefa=$linha['tarefa_custos_tarefa'];
			$qnt=0;
			}
		echo '<tr align="center"><td align="left">'.++$qnt.' - '.$linha['tarefa_custos_nome'].'</td>
		<td align="left">'.$linha['tarefa_custos_descricao'].'</td>
		<td nowrap="nowrap">'.$unidade[$linha['tarefa_custos_tipo']].'</td>
		<td nowrap="nowrap">'.$linha['tarefa_custos_quantidade'].'</td>
		<td align="right" nowrap="nowrap">'.number_format($linha['tarefa_custos_custo'], 2, ',', '.').'</td>
		<td nowrap="nowrap">'.dica('Natureza da Despesa', $nd[$linha['tarefa_custos_nd']]).$linha['tarefa_custos_nd'].'</td>
		<td align="right" nowrap="nowrap">'.number_format($linha['valor'], 2, ',', '.').'</td>
		<td align="left" nowrap="nowrap">'.nome_usuario($linha['tarefa_custos_usuario'],'','','esquerda').'</td><tr>';
		if (isset($custo[$linha['tarefa_custos_nd']])) $custo[$linha['tarefa_custos_nd']] += (float)$linha['valor'];	
		else $custo[$linha['tarefa_custos_nd']] = (float)$linha['valor'];	
		}
	else{
		if ($tarefa!=$linha['tarefa_gastos_tarefa']){
			echo '<tr><td align="left" colspan=20>'.nome_tarefa($linha['tarefa_gastos_tarefa']).'</td></tr>';
			$tarefa=$linha['tarefa_gastos_tarefa'];
			$qnt=0;
			}
		echo '<tr align="center"><td align="left">'.++$qnt.' - '.
		$linha['tarefa_gastos_nome'].'</td>
		<td align="left">'.$linha['tarefa_gastos_descricao'].'</td>
		<td nowrap="nowrap">'.$unidade[$linha['tarefa_gastos_tipo']].'</td>
		<td nowrap="nowrap">'.$linha['tarefa_gastos_quantidade'].'</td>
		<td align="right" nowrap="nowrap">'.number_format($linha['tarefa_gastos_custo'], 2, ',', '.').'</td>
		<td nowrap="nowrap">'.dica('Natureza da Despesa', (isset($nd[$linha['tarefa_gastos_nd']]) ? $nd[$linha['tarefa_gastos_nd']] : 'Sem natureza de despesa')).$linha['tarefa_gastos_nd'].'</td>
		<td align="right" nowrap="nowrap">'.number_format($linha['valor'], 2, ',', '.').'</td>
		<td align="left" nowrap="nowrap">'.nome_usuario($linha['tarefa_gastos_usuario'],'','','esquerda').'</td>
		<tr>';
		if (isset($custo[$linha['tarefa_gastos_nd']])) $custo[$linha['tarefa_gastos_nd']] += (float)$linha['valor'];	
		else $custo[$linha['tarefa_gastos_nd']] = (float)$linha['valor'];	
		} 
	$total+=$linha['valor'];
	}
if ($qnt) {
	if ($total) {
		echo '<tr><td colspan='.($config['bdi'] ? 7 : 6).' class="std" align="right">';
		foreach ($custo as $indice_nd => $somatorio) if ($somatorio > 0) echo '<br>'.(isset($nd[$indice_nd]) ? $nd[$indice_nd] : 'Sem ND');
		echo '<br><b>Total</td><td align="right">';	
		
		foreach ($custo as $indice_nd => $somatorio) if ($somatorio > 0) echo '<br>'.number_format($somatorio, 2, ',', '.');
		echo '<br><b>'.number_format($total, 2, ',', '.').'</b></td><td colspan="2">&nbsp;</td></tr>';	
		}	
	}
else echo '<tr><td colspan="8" class="std" align="left"><p>Nenhum item encontrado.</p></td></tr>';	
echo '</table></td></tr>';
echo '</td></tr></table></form>';
?>