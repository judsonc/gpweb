<?php
/* Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*/

if (!defined('BASE_DIR'))	die('Voc� n�o deveria acessar este arquivo diretamente.');

global $Aplic, $cal_sdf;


$moeda_id =getParam($_REQUEST, 'moeda_id', null);

$sql = new BDConsulta;

require_once (BASE_DIR.'/modulos/sistema/moeda/moeda.class.php');

$obj= new CMoeda();
$obj->load($moeda_id);

$cia_id = ($Aplic->getEstado('cia_id') !== null ? $Aplic->getEstado('cia_id') : $Aplic->usuario_cia);

if(!($podeEditar || $Aplic->usuario_admin)) $Aplic->redirecionar('m=publico&a=acesso_negado');


$ttl = ($moeda_id ? 'Editar Moeda' : 'Criar Moeda');
$botoesTitulo = new CBlocoTitulo($ttl, 'moeda.png', $m, $m.'.'.$a);
$botoesTitulo->mostrar();


echo '<form name="env" id="env" method="post">';
echo '<input type="hidden" name="m" value="'.$m.'" />';
echo '<input type="hidden" name="u" value="'.$u.'" />';
echo '<input type="hidden" name="a" value="vazio" />';
echo '<input type="hidden" name="fazerSQL" value="moeda_fazer_sql" />';
echo '<input type="hidden" name="dialogo" value="1" />';
echo '<input type="hidden" name="moeda_id" id="moeda_id" value="'.$moeda_id.'" />';
echo '<input type="hidden" name="salvar" value="" />';
echo '<input type="hidden" name="del" value="" />';
echo '<input type="hidden" name="modulo" value="" />';




echo estiloTopoCaixa();
echo '<table cellspacing=0 cellpadding=0 border=0 width="100%" class="std">';
echo '<tr><td align="right" width="50">'.dica('Nome da Moeda', 'Toda moeda necessita ter um nome para identifica��o.').'Nome:'.dicaF().'</td><td><input type="text" name="moeda_nome" value="'.$obj->moeda_nome.'" style="width:284px;" class="texto" /></td></tr>';
echo '<tr><td align="right">'.dica('S�mbolo da Moeda', 'Toda moeda necessita ter um s�mbolo para identifica��o.').'S�mbolo:'.dicaF().'</td><td><input type="text" name="moeda_simbolo" value="'.$obj->moeda_simbolo.'" style="width:284px;" class="texto" /></td></tr>';
echo '<tr><td align="right">'.dica('Ativa', 'Caso a moeda ainda esteja ativa dever� estar marcado este campo.').'Ativa:'.dicaF().'</td><td><input type="checkbox" value="1" name="moeda_ativo" '.($obj->moeda_ativo || !$moeda_id ? 'checked="checked"' : '').' /></td></tr>';
echo '<tr><td colspan=2><table cellspacing=0 cellpadding=0 width="100%"><tr><td width="100%">'.botao('salvar', 'Salvar', 'Salvar os dados.','','enviarDados()').'</td><td align="right">'.botao('cancelar', 'Cancelar', 'Cancelar a '.($moeda_id ? 'edi��o' : 'cria��o').' da moeda.','','if(confirm(\'Tem certeza que deseja cancelar?\')){url_passar(0, \''.$Aplic->getPosicao().'\');}').'</td></tr></table></td></tr>';

echo '</table>';
echo '</form>';

echo estiloFundoCaixa();

?>
<script type="text/javascript">

function excluir() {
	if (confirm( "Tem certeza que deseja excluir?")) {
		var f = document.env;
		f.del.value=1;
		f.submit();
		}
	}


function enviarDados() {
	var f = document.env;

	if (f.moeda_nome.value.length < 3) {
		alert('Escreva um nome v�lido');
		f.moeda_nome.focus();
		}
	if (f.moeda_simbolo.value.length < 1) {
		alert('Escreva um s�mbolo v�lido');
		f.moeda_simbolo.focus();
		}	
	else {
		f.salvar.value=1;
		f.submit();
		}
	}
</script>

