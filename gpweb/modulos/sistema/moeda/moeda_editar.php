<?php
/* Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*/

if (!defined('BASE_DIR'))	die('Você não deveria acessar este arquivo diretamente.');

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
echo '<tr><td align="right" width="50">'.dica('Nome da Moeda', 'Toda moeda necessita ter um nome para identificação.').'Nome:'.dicaF().'</td><td><input type="text" name="moeda_nome" value="'.$obj->moeda_nome.'" style="width:284px;" class="texto" /></td></tr>';
echo '<tr><td align="right">'.dica('Símbolo da Moeda', 'Toda moeda necessita ter um símbolo para identificação.').'Símbolo:'.dicaF().'</td><td><input type="text" name="moeda_simbolo" value="'.$obj->moeda_simbolo.'" style="width:284px;" class="texto" /></td></tr>';
echo '<tr><td align="right">'.dica('Ativa', 'Caso a moeda ainda esteja ativa deverá estar marcado este campo.').'Ativa:'.dicaF().'</td><td><input type="checkbox" value="1" name="moeda_ativo" '.($obj->moeda_ativo || !$moeda_id ? 'checked="checked"' : '').' /></td></tr>';
echo '<tr><td colspan=2><table cellspacing=0 cellpadding=0 width="100%"><tr><td width="100%">'.botao('salvar', 'Salvar', 'Salvar os dados.','','enviarDados()').'</td><td align="right">'.botao('cancelar', 'Cancelar', 'Cancelar a '.($moeda_id ? 'edição' : 'criação').' da moeda.','','if(confirm(\'Tem certeza que deseja cancelar?\')){url_passar(0, \''.$Aplic->getPosicao().'\');}').'</td></tr></table></td></tr>';

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
		alert('Escreva um nome válido');
		f.moeda_nome.focus();
		}
	if (f.moeda_simbolo.value.length < 1) {
		alert('Escreva um símbolo válido');
		f.moeda_simbolo.focus();
		}	
	else {
		f.salvar.value=1;
		f.submit();
		}
	}
</script>

