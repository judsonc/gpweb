<?php 
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');


if(!($podeAcessar || $Aplic->usuario_admin)) $Aplic->redirecionar('m=publico&a=acesso_negado');

$moeda_id = intval(getParam($_REQUEST, 'moeda_id', 0));



if (isset($_REQUEST['tab'])) $Aplic->setEstado('MoedaTab', getParam($_REQUEST, 'tab', null));
$tab = $Aplic->getEstado('MoedaTab') !== null ? $Aplic->getEstado('MoedaTab') : 0;


require_once (BASE_DIR.'/modulos/sistema/moeda/moeda.class.php');
$obj= new CMoeda();
$obj->load($moeda_id);

$sql = new BDConsulta;

echo '<form name="env" method="post">';
echo '<input type="hidden" name="m" value="'.$m.'" />';
echo '<input type="hidden" name="a" value="'.$a.'" />';
echo '<input type="hidden" name="u" value="'.$u.'" />';
echo '<input type="hidden" name="fazerSQL" value="" />';
echo '<input type="hidden" name="moeda_id" value="'.$moeda_id.'" />';
echo '<input type="hidden" name="del" value="" />';
echo '</form>';



if (!$dialogo && $Aplic->profissional){	
	$Aplic->salvarPosicao();
	$botoesTitulo = new CBlocoTitulo('Detalhes da Moeda', 'moeda.png', $m, $m.'.'.$a);
	$botoesTitulo->mostrar();
	echo estiloTopoCaixa();
	echo '<table align="center" cellspacing=0 cellpadding=0 width="100%">'; 
	echo '<tr><td colspan=2 style="background-color: #e6e6e6" width="100%">';
	require_once BASE_DIR.'/lib/coolcss/CoolControls/CoolMenu/coolmenu.php';
	$km = new CoolMenu("km");
	$km->scriptFolder ='lib/coolcss/CoolControls/CoolMenu';
	$km->styleFolder="default";
	$km->Add("root","ver",dica('Ver','Menu de opções de visualização').'Ver'.dicaF(), "javascript: void(0);");
	$km->Add("ver","ver_lista",dica('Lista de Moeda','Clique neste botão para visualizar a lista de moeda.').'Lista de Moeda'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=sistema&u=moeda&a=moeda_lista\");");
	$km->Add("root","inserir",dica('Inserir','Menu de opções').'Inserir'.dicaF(), "javascript: void(0);'");
	$km->Add("inserir","inserir_tarefa",dica('Nova Moeda', 'Criar um nova moeda.').'Nova Moeda'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=sistema&u=moeda&a=moeda_editar\");");
	if ($moeda_id!=1) $km->Add("inserir","inserir_cotacao",dica('Cotação','Inserir cotação desta moeda.').'Inserir Cotação'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=sistema&u=moeda&a=moeda_cotacao_editar&moeda_id=".$moeda_id."\");");
	$km->Add("root","acao",dica('Ação','Menu de ações.').'Ação'.dicaF(), "javascript: void(0);'");
	if ($moeda_id!=1) $km->Add("acao","acao_editar",dica('Editar Moeda','Editar os detalhes desta moeda.').'Editar Moeda'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=sistema&u=moeda&a=moeda_editar&moeda_id=".$moeda_id."\");");
	if ($moeda_id!=1) $km->Add("acao","acao_excluir",dica('Excluir','Excluir esta moeda do sistema.').'Excluir Moeda'.dicaF(), "javascript: void(0);' onclick='excluir()");
	$km->Add("acao","acao_imprimir",dica('Imprimir', 'Clique neste ícone '.imagem('imprimir_p.png').' para visualizar as opções de relatórios.').imagem('imprimir_p.png').' Imprimir'.dicaF(), "javascript: void(0);'");	
	$km->Add("acao_imprimir","acao_imprimir1",dica('Detalhes desta Moeda', 'Visualize os detalhes desta moeda.').' Detalhes desta moeda'.dicaF(), "javascript: void(0);' onclick='url_passar(1, \"m=".$m."&a=".$a."&u=".$u."&dialogo=1&moeda_id=".$moeda_id."\");");	
	echo $km->Render();
	echo '</td></tr></table>';
	}
	
	
echo '<table id="tblObjetivos" cellpadding=0 cellspacing=1 '.(!$dialogo ? 'class="std" ' : '').' width="100%"  >';

if ($obj->moeda_nome) echo '<tr><td align="right" nowrap="nowrap">'.dica('Nome', 'Nome para identificação da moeda.').'Nome:'.dicaF().'</td></td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->moeda_nome.'</td></tr>';
if ($obj->moeda_simbolo) echo '<tr><td align="right" nowrap="nowrap">'.dica('Símbolo', 'Símbolo para identificação da moeda.').'Símbolo:'.dicaF().'</td></td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->moeda_simbolo.'</td></tr>';
echo '<tr><td align="right" nowrap="nowrap">'.dica('Ativa', 'Se a moeda está ativa.').'Ativa:'.dicaF().'</td></td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.($obj->moeda_ativo ? ' Sim' : 'Não').'</td></tr>';
echo '</table>';

if (!$dialogo) {
	echo estiloFundoCaixa();
	if ($moeda_id!=1){
		$caixaTab = new CTabBox('m='.$m.'&a='.$a.'&u='.$u.'&moeda_id='.$moeda_id, '', $tab);
		$caixaTab->adicionar(BASE_DIR.'/modulos/sistema/moeda/moeda_cotacao', 'Cotação',null,null,'Cotação','Visualizar a cotação da moeda na linha de tempo.');
		$caixaTab->mostrar('','','','',true);
		echo estiloFundoCaixa('','', $tab);
		}
	}
else {
	include_once (BASE_DIR.'/modulos/sistema/moeda/moeda_cotacao.php');
	echo '<script type="text/javascript">self.print();</script>';
	}

?>
<script type="text/javascript">

function excluir() {
	if (confirm('Tem certeza que deseja excluir?')) {
		var f = document.env;
		f.del.value=1;
		f.fazerSQL.value='moeda_fazer_sql';
		f.a.value='vazio';
		f.submit();
		}
	}

</script>