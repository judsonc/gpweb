<?php
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*/

if (!defined('BASE_DIR')) die('Voc� n�o deveria acessar este arquivo diretamente.');

if (!($usuario_id = getParam($_REQUEST, 'usuario_id', 0))) $usuario_id = $Aplic->usuario_id;
global $config;


$podeEditar=($usuario_id == $Aplic->usuario_id || $Aplic->usuario_admin || $Aplic->usuario_super_admin);
if (!$podeEditar)	$Aplic->redirecionar('m=publico&a=acesso_negado');


$sql = new BDConsulta;

if ($usuario_id) {
	$usuario_frase = getParam($_REQUEST, 'usuario_frase', null);
	$usuario_resposta = getParam($_REQUEST, 'usuario_resposta', null);
	
	if ($usuario_frase && $usuario_resposta) {

		$sql->adTabela('usuarios');
		$sql->adAtualizar('usuario_frase', $usuario_frase);
		$sql->adAtualizar('usuario_resposta', $usuario_resposta);
		$sql->adOnde('usuario_id = '.(int)$usuario_id);
		if (!$sql->exec()) die('N�o foi poss�vel alterar a pergunta/resposta.');
		$sql->limpar();
		echo '<h1>Mudar Pergunta/Resposta de '.ucfirst($config['usuario']).'</h1>';
		echo estiloTopoCaixa();
		echo '<table width="100%" cellspacing=0 cellpadding=0 class="std"><tr><td>A pergunta/resposta foi alterada</td></tr></table>';
		}
	else {
		$sql->adTabela('usuarios');
		$sql->adCampo('usuario_frase');
		$sql->adOnde('usuario_id = '.(int)$usuario_id);
		$usuario_frase=$sql->resultado();
		$sql->limpar();

		echo '<h1>Mudar Pergunta/Resposta de '.ucfirst($config['usuario']).'</h1>';
		echo estiloTopoCaixa();
		echo '<form name="env" method="post" onsubmit="return false">';
		echo '<input type="hidden" name="usuario_id" value="'.$usuario_id.'" />';
		echo '<table width="100%" cellspacing=0 cellpadding=0 class="std">';
		echo '<tr><td align="right" width="150">'.dica('Pergunta', 'Escreva uma pergunta para a eventualidade de esquecer o login/senha de acesso ao sistema.').'Pergunta:'.dicaF().'</td><td colspan="2"><input type="text" class="texto" name="usuario_frase" value="'.$usuario_frase.'" maxlength="255" style="width:260px;" /></td></tr>';
		echo '<tr><td align="right" width="150">'.dica('Resposta', 'Escreva uma resposta a pergunta para a eventualidade de esquecer o login/senha de acesso ao sistema.').'Resposta:'.dicaF().'</td><td colspan="2"><input type="password" class="texto" name="usuario_resposta" value="" maxlength="255" style="width:260px;" /></td></tr>';
		echo '<tr><td align="right" width="150">'.dica('Confirmar Resposta', 'Escreva novamennte a resposta a pergunta para a eventualidade de esquecer o login/senha de acesso ao sistema.').'Confirmar resposta:'.dicaF().'</td><td colspan="2"><input type="password" class="texto" name="usuario_resposta_confirmar" value="" maxlength="255" style="width:260px;" /></td></tr>';
		echo '<tr><td>&nbsp;</td><td align="right" nowrap="nowrap">'.botao('salvar', '', '','','enviarDados()').'</td></tr>';
		echo '<form></table>';
		}
	}
else {
	echo '<h1>Mudar Pergunta/Resposta de '.ucfirst($config['usuario']).'</h1>';
	echo estiloTopoCaixa();
	echo '<table width="100%" cellspacing=0 cellpadding=0 class="std"><tr><td>'.ucfirst($config['usuario']).' n�o existe</td></tr></table>';
	}
echo estiloFundoCaixa();
?>
<script type="text/javascript">
function enviarDados() {
	var f = document.env;
	if (f.usuario_frase.value.length < 3) {
    alert('Por favor insira uma pergunta com ao menos 3 caracteres');
		f.usuario_frase.focus();
		return;
		}
	if (f.usuario_resposta.value.length < 3) {
    alert('Por favor insira uma resposta com ao menos 3 caracteres');
		f.usuario_resposta.focus();
		return;
		}	
	if (f.usuario_resposta.value != f.usuario_resposta_confirmar.value) {
		alert("A resposta n�o est� igual em ambos os campos.");
		f.usuario_resposta.focus();
		return;
		}
	f.submit();
	}


function submitenter(campo,e){
	var codigo;
	if (window.event) codigo = window.event.keyCode;
	else if (e) codigo = e.which;
	else return true;

	if (codigo == 13) {
	   enviarDados();
	   return false;
	   }
	else return true;
	}

</script>
