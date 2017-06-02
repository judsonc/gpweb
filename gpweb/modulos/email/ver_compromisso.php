<?php
/* Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/
 
if (!defined('BASE_DIR')) die('Voc� n�o deveria acessar este arquivo diretamente.');
global $config;
$base_dir=($config['dir_arquivo'] ? $config['dir_arquivo'] : BASE_DIR);

require_once (BASE_DIR.'/modulos/email/email.class.php');
$agenda_id = intval(getParam($_REQUEST, 'agenda_id', null));
$sql = new BDConsulta;
$podeEditar = true;
$msg = '';
$obj = new CAgenda();


if (!$obj->load($agenda_id)) {
	$Aplic->setMsg('Compromisso');
	$Aplic->setMsg('informa��es erradas', UI_MSG_ERRO, true);
	$Aplic->redirecionar('m=email&a=ver_mes');
	} 
else $Aplic->salvarPosicao();

$podeExcluir = $obj->podeExcluir();
$tipos = getSisValor('TipoCompromisso');
$recorrencia = array('Nunca', 'A cada hora', 'Diario', 'Semanalmente', 'Quinzenal', 'Mensal', 'Quadrimensal', 'Semestral', 'Anual');

if ($obj->agenda_dono != $Aplic->usuario_id) $podeEditar = false;
$df = '%d/%m/%Y';
$tf = $Aplic->getPref('formatohora');
$data_inicio = $obj->agenda_inicio ? new CData($obj->agenda_inicio) : new CData();
$data_fim = $obj->agenda_fim ? new CData($obj->agenda_fim) : new CData();


if (!$dialogo){	
	$Aplic->salvarPosicao();
	$botoesTitulo = new CBlocoTitulo('Detalhes do Compromisso', 'calendario.png', $m, $m.'.'.$a);
	$botoesTitulo->mostrar();
	echo estiloTopoCaixa();
	echo '<table align="center" cellspacing=0 cellpadding=0 width="100%">'; 
	echo '<tr><td colspan=2 style="background-color: #e6e6e6" width="100%">';
	require_once BASE_DIR.'/lib/coolcss/CoolControls/CoolMenu/coolmenu.php';
	$km = new CoolMenu("km");
	$km->scriptFolder ='lib/coolcss/CoolControls/CoolMenu';
	$km->styleFolder="default";
	$km->Add("root","ver",dica('Ver','Menu de op��es de visualiza��o').'Ver'.dicaF(), "javascript: void(0);");
	$km->Add("ver","ver_lista_compromissos",dica('Vis�o Mensal','Visualizar a lista de todos os compromisso cadastrados na vis�o mensal.').'Vis�o Mensal'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=email&a=ver_mes&data=".$data_inicio->format(FMT_TIMESTAMP_DATA)."\");");
	$km->Add("ver","ver_lista_compromissos",dica('Vis�o Semanal','Visualizar a lista de todos os compromisso cadastrados na vis�o semanal.').'Vis�o Semanal'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=email&a=ver_semana&data=".$data_inicio->format(FMT_TIMESTAMP_DATA)."\");");
	$km->Add("ver","ver_lista_compromissos",dica('Vis�o Di�ria','Visualizar a lista de todos os compromisso cadastrados na vis�o di�ria.').'Vis�o Mensal'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=email&a=ver_dia&tab=0&data=".$data_inicio->format(FMT_TIMESTAMP_DATA)."\");");
	if ($podeEditar) {
		$km->Add("root","inserir",dica('Inserir','Menu de op��es').'Inserir'.dicaF(), "javascript: void(0);'");
		$km->Add("inserir","inserir_compromisso",dica('Novo Compromisso', 'Criar um novo compromisso.').'Novo Compromisso'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=email&a=editar_compromisso\");");
		}	
	$km->Add("root","acao",dica('A��o','Menu de a��es.').'A��o'.dicaF(), "javascript: void(0);'");
	if ($podeEditar) $km->Add("acao","acao_editar",dica('Editar Compromisso','Editar os detalhes deste compromisso.').'Editar Compromisso'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=email&a=editar_compromisso&agenda_id=".$agenda_id."\");");
	if ($podeExcluir) $km->Add("acao","acao_excluir",dica('Excluir','Excluir este compromisso do sistema.').'Excluir Compromisso'.dicaF(), "javascript: void(0);' onclick='excluir()");	
	echo $km->Render();
	echo '</td></tr></table>';
	}













echo '<form name="env" method="POST">';
echo '<input type="hidden" name="m" value="email" />';
echo '<input type="hidden" name="a" value="ver_compromisso" />';
echo '<input type="hidden" name="u" value="" />';
echo '<input type="hidden" name="agenda_id" value="'.$agenda_id.'" />';	
echo '<input type="hidden" name="sem_cabecalho" value="" />';
echo '<input type="hidden" name="agenda_arquivo_id" value="" />';
echo '</form>';


echo '<form name="frmExcluir" method="post">';
echo '<input type="hidden" name="m" value="email" />';
echo '<input type="hidden" name="fazerSQL" value="fazer_agenda_aed" />';
echo '<input type="hidden" name="del" value="1" />';
echo '<input type="hidden" name="agenda_id" value="'.$agenda_id.'" />';
echo '</form>';


echo '<table cellpadding=0 cellspacing=1 width="100%" class="std">';


echo '<tr><td align="right" nowrap="nowrap">'.dica('Nome do Compromisso', 'Qual o nome do compromisso que foi cadastrado.').'Nome do Compromisso:'.dicaF().'</td><td class="realce" width="100%">'.$obj->agenda_titulo.'</td></tr>';
echo '<tr><td align="right" nowrap="nowrap">'.dica('In�cio', 'Data e hora do in�io do compromisso.').'In�cio:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.($data_inicio ? $data_inicio->format($df.' '.$tf) : '&nbsp;').'</td></tr>';
echo '<tr><td align="right" nowrap="nowrap">'.dica('T�rmino', 'Data e hora de t�rmino do compromisso.').'T�rmino:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.($data_fim ? $data_fim->format($df.' '.$tf) : '&nbsp;').'</td></tr>';
echo '<tr><td align="right" nowrap="nowrap">'.dica('Recorr�ncia', 'De quanto em quanto tempo este compromisso se repete.').'Recorr�ncia:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$recorrencia[$obj->agenda_recorrencias].($obj->agenda_recorrencias ? ' ('.$obj->agenda_nr_recorrencias.' vez'.((int)$obj->agenda_nr_recorrencias > 1 ? 'es':''). ')' : '').'</td></tr>';

if ($obj->agenda_dono!=$Aplic->usuario_id) echo '<tr><td align="right" nowrap="nowrap">'.dica('Criador', 'O criador do compromisso.').'Criador:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_usuario($obj->agenda_dono,'','','esquerda').'</td></tr>';




$participantes = $obj->getDesignado('nao_decidiu', false);
$saida_quem='';
		if ($participantes && count($participantes)) {
			$saida_quem.= '<table cellspacing=0 cellpadding=0 border=0 width="100%">';
			$saida_quem.= '<tr><td>'.link_usuario($participantes[0]['usuario_id'], '','','esquerda');
			$qnt_participantes=count($participantes);
			if ($qnt_participantes > 1) {		
					$lista='';
					for ($i = 1, $i_cmp = $qnt_participantes; $i < $i_cmp; $i++) $lista.=link_usuario($participantes[$i]['usuario_id'], '','','esquerda').'<br>';		
					$saida_quem.= dica('Outros Participantes', 'Clique para visualizar os demais participantes.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'nao_decidiu\');">(+'.($qnt_participantes - 1).')</a>'.dicaF(). '<span style="display: none" id="nao_decidiu"><br>'.$lista.'</span>';
					}
			$saida_quem.= '</td></tr></table>';
			} 
if ($saida_quem) echo '<tr><td align="right" nowrap="nowrap">'.dica('Sem Confirma��o', 'Quais '.$config['genero_usuario'].'s '.$config['usuarios'].' que tem ainda n�o confirmaram presen�a neste compromisso.').'Sem confirma��o:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$saida_quem.'</td></tr>';



$participantes = $obj->getDesignado('aceitou', false);
$saida_quem='';
		if ($participantes && count($participantes)) {
			$saida_quem.= '<table cellspacing=0 cellpadding=0 border=0 width="100%">';
			$saida_quem.= '<tr><td>'.link_usuario($participantes[0]['usuario_id'], '','','esquerda');
			$qnt_participantes=count($participantes);
			if ($qnt_participantes > 1) {		
					$lista='';
					for ($i = 1, $i_cmp = $qnt_participantes; $i < $i_cmp; $i++) $lista.=link_usuario($participantes[$i]['usuario_id'], '','','esquerda').'<br>';		
					$saida_quem.= dica('Outros Participantes', 'Clique para visualizar os demais participantes.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'aceitou\');">(+'.($qnt_participantes - 1).')</a>'.dicaF(). '<span style="display: none" id="aceitou"><br>'.$lista.'</span>';
					}
			$saida_quem.= '</td></tr></table>';
			} 
if ($saida_quem) echo '<tr><td align="right" nowrap="nowrap">'.dica('Confirma��o', 'Quais '.$config['genero_usuario'].'s '.$config['usuarios'].' que tem confirmaram presen�a neste compromisso.').'Confirmou:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$saida_quem.'</td></tr>';



$participantes = $obj->getDesignado('recusou', false);
$saida_quem='';
		if ($participantes && count($participantes)) {
			$saida_quem.= '<table cellspacing=0 cellpadding=0 border=0 width="100%">';
			$saida_quem.= '<tr><td>'.link_usuario($participantes[0]['usuario_id'], '','','esquerda');
			$qnt_participantes=count($participantes);
			if ($qnt_participantes > 1) {		
					$lista='';
					for ($i = 1, $i_cmp = $qnt_participantes; $i < $i_cmp; $i++) $lista.=link_usuario($participantes[$i]['usuario_id'], '','','esquerda').'<br>';		
					$saida_quem.= dica('Outros Participantes', 'Clique para visualizar os demais participantes.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'recusou\');">(+'.($qnt_participantes - 1).')</a>'.dicaF(). '<span style="display: none" id="recusou"><br>'.$lista.'</span>';
					}
			$saida_quem.= '</td></tr></table>';
			} 
if ($saida_quem) echo '<tr><td align="right" nowrap="nowrap">'.dica('Recusa', 'Quais '.$config['genero_usuario'].'s '.$config['usuarios'].' que tem recusaram participar neste compromisso.').'Recusou:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$saida_quem.'</td></tr>';





if ($obj->agenda_descricao) echo '<tr><td align="right" nowrap="nowrap">'.dica('Descri��o', 'Um resumo sobre o compromisso.').'Descri��o:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->agenda_descricao.'</td></tr>';


require_once $Aplic->getClasseSistema('CampoCustomizados');
$campos_customizados = new CampoCustomizados('agenda', $obj->agenda_id, 'ver');
$campos_customizados->imprimirHTML();




//arquivo anexo
$sql->adTabela('agenda_arquivos');
$sql->adCampo('agenda_arquivo_id, agenda_arquivo_usuario, agenda_arquivo_data, agenda_arquivo_ordem, agenda_arquivo_nome, agenda_arquivo_endereco');
$sql->adOnde('agenda_arquivo_agenda_id='.$agenda_id);
$sql->adOrdem('agenda_arquivo_ordem ASC');
$arquivos=$sql->Lista();
$sql->limpar();
if ($arquivos && count($arquivos))echo '<tr><td colspan=2><b>'.(count($arquivos)>1 ? 'Arquivos anexados':'Arquivo anexado').'</b></td></tr>';
foreach ($arquivos as $arquivo) {
	$dentro = '<table cellspacing="4" cellpadding="2" border=0 width="100%">';
	$dentro .= '<tr><td align="center" style="border: 1px solid;-webkit-border-radius:3.5px;" width="120"><b>Remetente</b></td><td>'.nome_funcao('', '', '', '',$arquivo['agenda_arquivo_usuario']).'</td></tr>';
	$dentro .= '<tr><td align="center" style="border: 1px solid;-webkit-border-radius:3.5px;"><b>Anexado em</b></td><td>'.retorna_data($arquivo['agenda_arquivo_data']).'</td></tr>';
	$dentro .= '</table>';
	$dentro .= '<br>Clique neste compromisso para visualizar o arquivo no Navegador Web.';
	echo '<tr><td colspan=2><table cellpadding=0 cellspacing=0><tr>';
	echo '<td><a href="javascript:void(0);" onclick="javascript:env.a.value=\'download_agenda\';  env.u.value=\'\'; env.sem_cabecalho.value=1; env.agenda_arquivo_id.value='.$arquivo['agenda_arquivo_id'].'; env.submit();">'.dica($arquivo['agenda_arquivo_nome'],$dentro).$arquivo['agenda_arquivo_nome'].'</a></td>';
	echo '</tr></table></td></tr>';
	}




echo '<tr><td align="right" colspan="2">'.botao('sair', 'Sair', 'Sair do detalhe de compromisso.','','url_passar(0, \'m=email&a=ver_mes\');').'</td></tr>';
echo '</table>';
echo estiloFundoCaixa();
?>
<script type="text/javascript">
function excluir() {
	if (confirm( "Tem certeza que deseja excluir o compromisso?" )) document.frmExcluir.submit();
	}
	
function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}	
</script>
