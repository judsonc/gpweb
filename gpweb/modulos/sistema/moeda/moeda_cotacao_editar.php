<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*/

if (!defined('BASE_DIR'))	die('Você não deveria acessar este arquivo diretamente.');

global $Aplic, $cal_sdf;

$Aplic->carregarCalendarioJS();

$moeda_cotacao_id = getParam($_REQUEST, 'moeda_cotacao_id', 0);
$moeda_id = getParam($_REQUEST, 'moeda_id', null);

$salvar = getParam($_REQUEST, 'salvar', 0);
$excluir = getParam($_REQUEST, 'excluir', 0);


$ordenar = getParam($_REQUEST, 'ordenar', 'moeda_cotacao_data');
$ordem = getParam($_REQUEST, 'ordem', 1);
$seta=array('0'=>'seta-cima.gif', '1'=>'seta-baixo.gif');
$pagina = getParam($_REQUEST, 'pagina', 1);
$xtamanhoPagina = ($dialogo ? 90000 : 30);
$xmin = $xtamanhoPagina * ($pagina - 1); 

$sql = new BDConsulta;

if (!$moeda_id){
	$sql->adTabela('moeda_cotacao');
	$sql->adCampo('moeda_cotacao_moeda');
	$sql->adOnde('moeda_cotacao_id = '.(int)$moeda_cotacao_id);
	$moeda_id = $sql->Resultado();
	$sql->limpar();
	}


$botoesTitulo = new CBlocoTitulo('Editar Cotação da Moeda', 'moeda.png', $m, $m.'.'.$a);
$botoesTitulo->adicionaBotao($Aplic->getPosicao(), 'voltar','','Voltar','Voltar a tela anterior.');
$botoesTitulo->mostrar();


$sql->adTabela('moeda_cotacao');
$sql->adCampo('moeda_cotacao.*');
$sql->adOnde('moeda_cotacao_id='.$moeda_cotacao_id);
$moeda_valor=$sql->Linha();
$sql->limpar();

$sql->adTabela('moeda');
$sql->adCampo('moeda_nome');
$sql->adOnde('moeda_id='.(int)$moeda_id);
$moeda=$sql->Linha();
$sql->limpar();


$data = isset($moeda_valor['moeda_cotacao_data']) ? new CData($moeda_valor['moeda_cotacao_data']) : new CData();
echo '<form name="env" method="post">';
echo '<input type="hidden" name="m" value="sistema" />';
echo '<input type="hidden" name="u" value="moeda" />';
echo '<input type="hidden" name="a" value="moeda_cotacao_editar" />';
echo '<input type="hidden" name="moeda_cotacao_id" id="moeda_cotacao_id" value="'.$moeda_cotacao_id.'" />';
echo '<input type="hidden" name="moeda_id" id="moeda_id" value="'.$moeda_id.'" />';

echo '<input type="hidden" name="pagina" id="pagina" value="'.$pagina.'" />';
echo '<input type="hidden" name="ordem" id="ordem" value="'.$ordem.'" />';
echo '<input type="hidden" name="ordenar" id="ordenar" value="'.$ordenar.'" />';


echo estiloTopoCaixa();
echo '<table cellspacing=0 cellpadding=0 width="100%" class="std">';
echo '<tr><td align="center" colspan="2"><h1>'.$moeda['moeda_nome'].'</h1></td></tr>';

echo '<tr><td colspan=2><table cellspacing=0 cellpadding=0>';
echo '<tr><td><fieldset><legend class=texto style="color: black;">'.dica('Valor','Valor a ser inserido ou editado.').'&nbsp;<b>Valor</b>&nbsp'.dicaF().'</legend><table cellspacing=0 cellpadding=0>';
echo '<tr><td align="right" nowrap="nowrap">'.dica('Data', 'Data da cotação.').'Data:'.dicaF().'</td><td><input type="hidden" name="moeda_cotacao_data" id="moeda_cotacao_data" value="'.($data ? $data->format(FMT_TIMESTAMP_DATA) : '').'" /><input type="text" name="data" style="width:70px;" id="data" onchange="setData(\'env\', \'data\', \'moeda_cotacao_data\');" value="'.($data ? $data->format('%d/%m/%Y') : '').'" class="texto" />'.dica('Data', 'Clique neste ícone '.imagem('icones/calendario.gif').' para abrir um calendário onde poderá selecionar a data em que foi aferido o valor.').'<a href="javascript: void(0);" ><img id="f_btn1" src="'.acharImagem('calendario.gif').'" style="vertical-align:middle" width="18" height="12" alt="Calendário" border=0 /></a>'.dicaF().'</td></tr>';
echo '<tr><td align="right" nowrap="nowrap">'.dica('Valor', 'O valor da cotação.').'Valor:'.dicaF().'</td><td><input type="text" name="moeda_cotacao_cotacao" id="moeda_cotacao_cotacao" onkeypress="return entradaNumerica(event, this, true, true);" value="'.($moeda_valor['moeda_cotacao_cotacao'] ? number_format($moeda_valor['moeda_cotacao_cotacao'], 5, ',', '.') : '').'" class="texto" /></td></tr>';

echo '</table></fieldset></td>';

echo '<td id="adicionar_valor" style="display:'.($moeda_cotacao_id ? 'none' : '').'"><a href="javascript: void(0);" onclick="incluir_valor();">'.imagem('icones/adicionar_g.png','Incluir','Clique neste ícone '.imagem('icones/adicionar.png').' para incluir o valor.').'</a></td>';
echo '<td id="confirmar_valor" style="display:'.($moeda_cotacao_id ? '' : 'none').'"><a href="javascript: void(0);" onclick="limpar();">'.imagem('icones/cancelar_g.png','Cancelar','Clique neste ícone '.imagem('icones/cancelar.png').' para cancelar a edição do valor.').'</a><a href="javascript: void(0);" onclick="incluir_valor();">'.imagem('icones/ok_g.png','Confirmar','Clique neste ícone '.imagem('icones/ok.png').' para confirmar a edição do valor.').'</a></td>';
echo '</tr>';
echo '</table></td></tr>';

echo '<tr><td colspan=20>&nbsp;</td></tr>';



$sql = new BDConsulta;


$sql->adTabela('moeda_cotacao');
$sql->adCampo('count(DISTINCT moeda_cotacao_id) AS soma');
$sql->adOnde('moeda_cotacao_moeda ='.(int)$moeda_id);	
$xtotalregistros = $sql->Resultado();
$sql->limpar();

$sql->adTabela('moeda_cotacao');
$sql->adCampo('moeda_cotacao_id, formatar_data(moeda_cotacao_data, \'%d/%m/%Y\') AS data, moeda_cotacao_cotacao');
$sql->adOnde('moeda_cotacao_moeda ='.(int)$moeda_id);	
$sql->adOrdem($ordenar.($ordem ? ' DESC' : ' ASC'));
$sql->setLimite($xmin, $xtamanhoPagina);
$lista = $sql->lista();
$sql->limpar();

$xtotal_paginas = ($xtotalregistros > $xtamanhoPagina) ? ceil($xtotalregistros / $xtamanhoPagina) : 0;


if ($xtotal_paginas > 1) '<tr><td colspan=20>'.mostrarBarraNav($xtotalregistros, $xtamanhoPagina, $xtotal_paginas, $pagina, 'Cotações', 'Cotação','','',($estilo_interface=='classico' ? 'a6a6a6' : '006fc2')).'</td></tr>';

echo '<tr><td colspan=20><div id="combo_valores">';




echo '<table width="100%" cellpadding=0 cellspacing=0 '.(!$dialogo ? 'class="std"' : '').'><tr><td>';
echo '<table cellpadding=0 cellspacing=0 class="tbl1">';
echo '<tr>';


echo '<th nowrap="nowrap" width=70><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&u='.$u.'&pagina='.$pagina.'&moeda_id='.$moeda_id.'&ordenar=moeda_cotacao_data&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='moeda_cotacao_data' ? imagem('icones/'.$seta[$ordem]) : '').dica('Data', 'Neste campo fica a data da cotação da moeda.').'Data'.dicaF().'</a></th>';
echo '<th nowrap="nowrap" width=70><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&u='.$u.'&pagina='.$pagina.'&moeda_id='.$moeda_id.'&ordenar=moeda_cotacao_cotacao&ordem='.($ordem ? '0' : '1').'\');">'.($ordenar=='moeda_cotacao_cotacao' ? imagem('icones/'.$seta[$ordem]) : '').dica('Cotação', 'Neste campo fica o valor da cotação da moeda.').'Cotação'.dicaF().'</a></th>';
if (!$dialogo) echo '<th nowrap="nowrap">&nbsp;</th>';
echo '</tr>';

foreach($lista as $linha){
	echo '<tr>';
	echo '<td align=center>'.$linha['data'].'</td>';
	echo '<td align=right>'.number_format($linha['moeda_cotacao_cotacao'], 4, ',', '.').'</td>';
	
	echo '<td width="32" align=center>';
	echo '<a href="javascript: void(0);" onclick="editar_valor('.$linha['moeda_cotacao_id'].');">'.imagem('icones/editar.gif', 'Editar', 'Clique neste ícone '.imagem('icones/editar.gif').' para editar o valor.').'</a>';
	echo '<a href="javascript: void(0);" onclick="if (confirm(\'Tem certeza que deseja excluir esta cotação?\')) {excluir_valor('.$linha['moeda_cotacao_id'].');}">'.imagem('icones/remover.png', 'Excluir', 'Clique neste ícone '.imagem('icones/remover.png').' para excluir este valor.').'</a>';
	echo '</td>';
	
	echo '</tr>';
	}	
echo '</table>';	


echo '</div></table></td></tr>';

echo '</table>';


echo '</form>';


echo estiloFundoCaixa();

?>
<script type="text/javascript">


function limpar(){
	document.getElementById('moeda_cotacao_id').value=null;
	document.getElementById('moeda_cotacao_cotacao').value='';
	document.getElementById('adicionar_valor').style.display='';
	document.getElementById('confirmar_valor').style.display='none';
	}

function editar_valor(moeda_cotacao_id){
	xajax_editar_valor(moeda_cotacao_id);
	document.getElementById('adicionar_valor').style.display="none";
	document.getElementById('confirmar_valor').style.display="";
	}

function incluir_valor(){
	if (document.getElementById('moeda_cotacao_cotacao').value.length > 0){
		xajax_incluir_valor(
			document.getElementById('moeda_cotacao_id').value,
			document.getElementById('moeda_id').value,
			document.getElementById('moeda_cotacao_data').value,
			document.getElementById('moeda_cotacao_cotacao').value,
			document.getElementById('pagina').value,
			document.getElementById('ordem').value,
			document.getElementById('ordenar').value
			);
		limpar();
		__buildTooltip();
		}
	else alert('Insira um valor.');
	}

function excluir_valor(moeda_cotacao_id){

	xajax_excluir_valor(
	moeda_cotacao_id, 
	document.getElementById('moeda_id').value, 
	document.getElementById('pagina').value,
	document.getElementById('ordem').value,
	document.getElementById('ordenar').value
	);
	__buildTooltip();
	}



function enviarDados() {
	var f = document.env;

	if (f.moeda_cotacao_cotacao.value.length < 1) {
		alert('Escreva um valor válido');
		f.moeda_cotacao_cotacao.focus();
		}
	else {
		f.salvar.value=1;
		f.submit();
		}
	}


function entradaNumerica(event, campo, virgula, menos) {
  var unicode = event.charCode;
  var unicode1 = event.keyCode;
	if(virgula && campo.value.indexOf(",")!=campo.value.lastIndexOf(",")){
			campo.value=campo.value.substr(0,campo.value.lastIndexOf(",")) + campo.value.substr(campo.value.lastIndexOf(",")+1);
			}
	if(menos && campo.value.indexOf("-")!=campo.value.lastIndexOf("-")){
			campo.value=campo.value.substr(0,campo.value.lastIndexOf("-")) + campo.value.substr(campo.value.lastIndexOf("-")+1);
			}
	if(menos && campo.value.lastIndexOf("-") > 0){
			campo.value=campo.value.substr(0,campo.value.lastIndexOf("-")) + campo.value.substr(campo.value.lastIndexOf("-")+1);
			}
  if (navigator.userAgent.indexOf("Firefox") != -1 || navigator.userAgent.indexOf("Safari") != -1) {
    if (unicode1 != 8) {
       if ((unicode >= 48 && unicode <= 57) || unicode1 == 37 || unicode1 == 39 || unicode1 == 35 || unicode1 == 36 || unicode1 == 9 || unicode1 == 46) return true;
       else if((virgula && unicode == 44) || (menos && unicode == 45))	return true;
       return false;
      }
  	}
  if (navigator.userAgent.indexOf("MSIE") != -1 || navigator.userAgent.indexOf("Opera") == -1) {
    if (unicode1 != 8) {
      if (unicode1 >= 48 && unicode1 <= 57) return true;
      else {
      	if( (virgula && unicode == 44) || (menos && unicode == 45))	return true;
      	return false;
      	}
    	}
  	}
	}


 var cal1 = Calendario.setup({
  	trigger    : "f_btn1",
    inputField : "moeda_cotacao_data",
  	date :  <?php echo $data->format("%Y%m%d")?>,
  	selection: <?php echo $data->format("%Y%m%d")?>,
    onSelect: function(cal1) {
    var date = cal1.selection.get();
    if (date){
    	date = Calendario.intToDate(date);
      document.getElementById("data").value = Calendario.printDate(date, "%d/%m/%Y");
      document.getElementById("moeda_cotacao_data").value = Calendario.printDate(date, "%Y-%m-%d");
      }
  	cal1.hide();
  	}
  });


function setData( frm_nome, f_data, f_data_real ) {
	campo_data = eval( 'document.' + frm_nome + '.' + f_data );
	campo_data_real = eval( 'document.' + frm_nome + '.' + f_data_real );
	if (campo_data.value.length>0) {
    if ((parsfimData(campo_data.value))==null) {
      alert('A data/hora digitada não corresponde ao formato padrão. Redigite, por favor.');
      campo_data_real.value = '';
      campo_data.style.backgroundColor = 'red';
    	}
    else {
    	campo_data_real.value = formatarData(parsfimData(campo_data.value), 'yyyy-MM-dd');
    	campo_data.value = formatarData(parsfimData(campo_data.value), 'dd/MM/Y');
      campo_data.style.backgroundColor = '';
			}
		}
	else campo_data_real.value = '';
	}

</script>

