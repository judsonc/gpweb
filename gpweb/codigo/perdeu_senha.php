<?php 
/* 
Copyright (c) 2007-2011 The web2Project Development Team <w2p-developers@web2project.net>
Copyright (c) 2003-2007 The dotProject Development Team <core-developers@dotproject.net>
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente');
$celular=getParam($_REQUEST, 'celular', 0);

$pesquisa_email=getParam($_REQUEST, 'pesquisa_email', 0);
$usuario_id=getParam($_REQUEST, 'usuario_id', 0);
$checkemail=getParam($_REQUEST, 'checkemail', '');
$pesquisa_frase=getParam($_REQUEST, 'pesquisa_frase', 0);
$resposta=getParam($_REQUEST, 'resposta', 0);
$gravar_senha=getParam($_REQUEST, 'gravar_senha', 0);
$usuario_senha=getParam($_REQUEST, 'usuario_senha', '');

$mudar_senha=0;
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
echo '<head>';
echo '<title>'.(isset($config['gpweb']) ? $config['gpweb'] : 'gpweb').'</title>';
echo '<meta http-equiv="Content-Type" content="text/html;charset='.(isset($localidade_tipo_caract) ? $localidade_tipo_caract : 'iso-8859-1').'" />';

echo '<meta http-equiv="Pragma" content="no-cache" />';
echo '<meta name="Version" content="'.$Aplic->getVersao().'" />';
echo '<link rel="stylesheet" type="text/css" href="./estilo/rondon/estilo_'.(isset($config['estilo_css']) ? $config['estilo_css'] : 'metro').'.css" media="all" />';
echo '<style type="text/css" media="all">@import "./estilo/rondon/estilo_'.(isset($config['estilo_css']) ? $config['estilo_css'] : 'metro').'.css";</style>';
echo '<link rel="shortcut icon" href="./estilo/rondon/imagens/organizacao/10/favicon.ico" type="image/ico" />';
echo '<script type="text/javascript" src="'.str_replace('/codigo', "", BASE_URL).'/lib/jquery/jquery-1.8.3.min.js"></script>';
echo '<script type="text/javascript" src="'.str_replace('/codigo', "", BASE_URL).'/lib/mootools/mootools.js"></script>';
echo '<script type="text/javascript" src="'.str_replace('/codigo', "", BASE_URL).'/js/gpweb.js"></script>';
echo '</head>';
echo '<body>';
echo '<script>$jq = jQuery.noConflict();</script>';

include ('./estilo/rondon/sobrecarga.php');


if (!$celular) {
	echo '<br><center>'.dica('Site do '.$config['gpweb'], 'Clique para entrar no site oficial do '.$config['gpweb'].'.')
        .'<a href="'.((isset($config['endereco_site']) && $config['endereco_site']) ? $config['endereco_site'] : 'http://www.sistemagpweb.com.br').'" target="_blank"><img src="'.$Aplic->gpweb_logo.'" border=0 /></a>'.dicaF().'<center>';
 	echo '<br><br>';
 	}
else echo '<table width="300" cellspacing=0 cellpadding=0 align=center><tr><td></td></tr><tr><td><hr noshade size=5 style="color: #a6a6a6"></td></tr><td align=center style="font-size:35pt; padding-left: 5px; padding-right: 5px;color: #009900"><i><b>gp</b>web</td></i></tr><tr><td><hr noshade size=5 style="color: #a6a6a6"></td></tr><tr><td>&nbsp;</td></tr></table>';


$sql = new BDConsulta;

if (!$usuario_id && $pesquisa_email){
	$sql->adTabela('usuarios');
	$sql->esqUnir('contatos', 'contatos', 'usuario_contato = contato_id');
	$sql->adCampo('usuario_id, usuario_frase, usuario_resposta');
	$sql->adOnde('LOWER(contato_email) = \''.$checkemail.'\' OR LOWER(contato_email2) = \''.$checkemail.'\' OR usuario_login = \''.$checkemail.'\'');
	$usuario = $sql->linha();
	$sql->limpar();
	
	$usuario_id=(isset($usuario['usuario_id']) ? $usuario['usuario_id'] : 0);
	
	if (!$usuario_id) ver2('Nenhuma conta encontrada com e-mail ou login fornecido!');
	}

if ($usuario_id && $pesquisa_frase){
	$sql->adTabela('usuarios');
	$sql->esqUnir('contatos', 'contatos', 'usuario_contato = contato_id');
	$sql->adCampo('usuario_frase, usuario_resposta');
	$sql->adOnde('usuario_id='.(int)$usuario_id);
	$usuario = $sql->linha();
	$sql->limpar();
	
	if (strtolower($resposta)==strtolower($usuario['usuario_resposta'])) {
		$mudar_senha=1;
		}
	else {
		ver2('Resposta incorreta!');
		$mudar_senha=0;
		}
	}


if ($gravar_senha && $usuario_id){
	

	$sql->adTabela('usuarios');
	$sql->adAtualizar('usuario_senha', md5($usuario_senha));
	$sql->adOnde('usuario_id = '.(int)$usuario_id);
	if (!$sql->exec()) die('Não foi possível alterar a senha.');
	else {
		ver2('Senha alterada');
		echo '<form method="post" name="env2">';
		echo '<input type="hidden" name="perdeu_senha" value="" />';
		echo '</form>';
		echo '<script type="text/javascript">env2.submit();</script>';
		}
	$sql->limpar();
	
	}


echo '<form method="post" name="env">';
echo '<input type="hidden" name="celular" value="'.$celular.'" />';
echo '<input type="hidden" name="perdeu_senha" value="1" />';
echo '<input type="hidden" name="pesquisa_email" value="1" />';
echo '<input type="hidden" name="pesquisa_frase" value="0" />';
echo '<input type="hidden" name="gravar_senha" value="0" />';
echo '<input type="hidden" name="usuario_id" value="'.$usuario_id.'" />';


if (isset($redirecionar)) echo '<input type="hidden" name="redirecionar" value="'.$redirecionar.'" />';

echo '<table align="center" width="400" cellpadding=0 cellspacing=0>';
if (!$celular) echo '<tr><td>'.estiloTopoCaixa().'</td></tr>';
else echo '<tr><td width="100%" style="background-color: #a6a6a6">&nbsp;</td></tr>';

echo '<tr><td><table width="100%" cellpadding=0 cellspacing=0 class="std">';
if (!$usuario_id){
	echo '<tr><td  align="right" nowrap="nowrap" width=100>'.dica('E-mail ou Login', 'Escreva seu E-mail ou login cadastrado no '.$config['gpweb'].'.').'E-mail ou login:'.dicaF().'</td><td style="padding:2px" align="left" nowrap="nowrap"><input type="text" size="50" maxlength="255" name="checkemail" class="texto" /></td></tr>';
	echo '<tr><td align="left" nowrap="nowrap">'.botao('buscar', 'Buscar', 'Ao pressionar este botão será apresentada a pergunta atrelada a conta.','','env.submit()').'</td><td align="right">'.botao('cancelar', 'Cancelar','Ao se pressionar este botão irá retornar a tela de login.','','env.perdeu_senha.value=0; env.submit();').'</td></tr>';
	}
elseif ($usuario_id && !$mudar_senha){
	echo '<tr><td  align="right" nowrap="nowrap" width=100>'.dica('Pergunta', 'A pergunta para a eventualidade de esquecer o login/senha de acesso ao sistema.').'Pergunta:'.dicaF().'</td><td style="padding:2px" align="left" nowrap="nowrap">'.(isset($usuario['usuario_frase']) ? $usuario['usuario_frase'] : '').'</td></tr>';
	echo '<tr><td  align="right" nowrap="nowrap" width=100>'.dica('Resposta', 'A resposta a pergunta para a eventualidade de esquecer o login/senha de acesso ao sistema.').'Resposta:'.dicaF().'</td><td style=" padding:2px" align="left" nowrap="nowrap"><input type="text" size="50" maxlength="255" name="resposta" class="texto" /></td></tr>';
	echo '<tr><td align="left" nowrap="nowrap">'.botao('enviar', 'Enviar', 'Ao pressionar este botão será enviada a resposta a pergunta.','','enviar();').'</td><td align="right">'.botao('cancelar', 'Cancelar','Ao se pressionar este botão irá retornar a tela de login.','','env.perdeu_senha.value=0; env.submit();').'</td></tr>';
	}
elseif ($usuario_id && $mudar_senha){
	echo '<tr><td align="right" nowrap="nowrap">'.dica('Senha', 'Escreva a senha de acesso ao sistema.').'Senha:'.dicaF().'</td><td><input type="password" class="texto" name="usuario_senha" value="" maxlength="32" style="width:260px;" /> </td></tr>';
	echo '<tr><td align="right" nowrap="nowrap">'.dica('Confirmar a Senha', 'Escreva novamente a senha de acesso ao sistema.').'Confirmar a Senha:'.dicaF().'</td><td><input type="password" class="texto" name="senha_checar" value="" maxlength="32" style="width:260px;" /></td></tr>';
	echo '<tr><td align="left" nowrap="nowrap">'.botao('salvar', 'Salvar', 'Ao pressionar este botão será salvo a nova senha.','','salvar_senha();').'</td><td align="right">'.botao('cancelar', 'Cancelar','Ao se pressionar este botão irá retornar a tela de login.','','env.perdeu_senha.value=0; env.submit();').'</td></tr>';
	}	
	
	
echo '</table></td></tr>';

if (!$celular) echo '<tr><td colspan="2">'.estiloFundoCaixa().'</td></tr>';
else echo '<tr><td colspan=2 width="100%" style="background-color: #a6a6a6">&nbsp;</td></tr>';
echo '</table>';
if ($Aplic->getVersao()) echo '<div align="center"><span style="font-size:6pt">Versão '.($Aplic->profissional ? 'Pro ' : '').$Aplic->getVersao().'</span></div>';

echo '</form>';

echo '<div align="center">'.'<span class="error">'.$Aplic->getMsg().'</span>';
$msg = '';
$msg .= phpversion() < '5.0' ? '<br /><span class="warning">ATENÇÃO: o '.$config['gpweb'].' não é suportado por esta versão do PHP -  ('.phpversion().')</span>' : '';
$msg .= function_exists('mysql_pconnect') ? '' : '<br /><span class="warning">ATENÇÃO: PHP não está conseguindo se conectar ao MySQL instalado. Verifique as configurações do sistema.</span>';
echo $msg;
$Aplic->carregarRodapeJS();
echo '</div></body></html>';
?>
<script type="text/javascript">

function enviar(){
	if (!env.resposta.value) {
		alert('Necessário escrever uma resposta!');
		env.resposta.focus();
		}	
	else {
		env.pesquisa_frase.value=1; 
		env.submit()
		}
	}
	
function salvar_senha(){
	if (env.usuario_senha.value !=  env.senha_checar.value) {
		alert("Ambos os campos devem conter a mesma senha.");
		env.usuario_senha.focus();
		}	
	else {
		env.gravar_senha.value=1;
		env.submit();
		}
	}	
</script>	