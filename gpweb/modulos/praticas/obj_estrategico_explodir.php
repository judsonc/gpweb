<?php
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
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