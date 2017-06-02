<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*/

if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');

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
		if (!$sql->exec()) die('Não foi possível alterar a pergunta/resposta.');
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
	echo '<table width="100%" cellspacing=0 cellpadding=0 class="std"><tr><td>'.ucfirst($config['usuario']).' não existe</td></tr></table>';
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
		alert("A resposta não está igual em ambos os campos.");
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
