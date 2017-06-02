<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


include_once BASE_DIR.'/modulos/praticas/indicador_simples.class.php';


require "lib/coolcss/CoolControls/CoolTreeView/cooltreeview.php";
$arvore = new CoolTreeView("treeview");
$arvore->scriptFolder = "lib/coolcss/CoolControls/CoolTreeView";
$arvore->imageFolder="lib/coolcss/CoolControls/CoolTreeView/icons";
$arvore->styleFolder="default";
$arvore->showLines = true;
$arvore->EditNodeEnable = false;
$arvore->DragAndDropEnable=true;
$arvore->multipleSelectEnable = true;


$objetivo_id=getParam($_REQUEST, 'objetivo_id', 0);


vetor_arvore($objetivo_id, TRUE);

//nova tabela
echo '<table id="geral" width="100%" cellspacing="0" cellpadding="0">';
	
echo '<tr><td colspan=20>'.$arvore->Render().'</td></tr></table>';
	
echo '<script>treeview.expandAll();</script>';	


function vetor_arvore($objetivo_composicao_pai, $inicio=false, $pai=''){
	global $tipo,  $cor_pontuacao, $arvore, $Aplic;
	$sql = new BDConsulta;
	$saida='';
	$sql->adTabela('objetivo');
	$sql->esqUnir('cias','cias','cia_id=objetivo_cia');
	$sql->adCampo('objetivo_nome, cia_nome, cia_id');
	$sql->adOnde('objetivo_id='.$objetivo_composicao_pai);
	$atual=$sql->Linha();
	$sql->limpar();

	$sql->adTabela('objetivo_composicao');
	$sql->esqUnir('objetivo','objetivo','objetivo_composicao_filho=objetivo_id');
	$sql->adCampo('objetivo_composicao_filho');
	$sql->adOnde('objetivo_composicao_pai='.$objetivo_composicao_pai);
	$sql->adOrdem('objetivo_nome');
	$linhas=$sql->Lista();
	$sql->limpar();	
	
	
	if ($inicio){
		$root = $arvore->getRootNode();
		$root->text=$atual['objetivo_nome'].($atual['cia_id']!=$Aplic->usuario_cia ? ' - '.$atual['cia_nome'] : '');
		$root->expand=true;
		$root->addData("id", $objetivo_composicao_pai);
		foreach ((array)$linhas as $valor) vetor_arvore($valor['objetivo_composicao_filho'],false, 'root');	
		}
	else{
		$nodulo=$arvore->Add($pai, $objetivo_composicao_pai, $atual['objetivo_nome'].($atual['cia_id']!=$Aplic->usuario_cia ? ' - '.$atual['cia_nome'] : ''),false);
		$nodulo->addData("id", $objetivo_composicao_pai);
		foreach ((array)$linhas as $valor) vetor_arvore($valor['objetivo_composicao_filho'],false, $objetivo_composicao_pai);	
		}
	}


?>
<script type="text/javascript">
function nodeSelect_handle(sender,arg){	
		var treenode = treeview.getNode(arg.NodeId);
		var objetivo=treenode.getData("id");	
		if (objetivo >0) window.opener.url_passar(0, "m=praticas&a=obj_estrategico_ver&objetivo_id="+objetivo);
    }
    treeview.registerEvent("OnSelect",nodeSelect_handle);
</script>