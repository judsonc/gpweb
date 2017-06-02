<?php 
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


if (!defined('BASE_DIR')) die('Voc� n�o deveria acessar este arquivo diretamente.');

$plano_acao_id = intval(getParam($_REQUEST, 'plano_acao_id', 0));

$sql = new BDConsulta;

require_once BASE_DIR.'/modulos/praticas/plano_acao.class.php';

$obj = new CPlanoAcao();
$obj->load($plano_acao_id);


if (!permiteAcessarPlanoAcao($obj->plano_acao_acesso,$obj->plano_acao_id)) $Aplic->redirecionar('m=publico&a=acesso_negado');

$sql->adTabela('campo_formulario');
$sql->adCampo('campo_formulario_campo, campo_formulario_ativo');
$sql->adOnde('campo_formulario_tipo = \'acao\'');
$sql->adOnde('campo_formulario_usuario IS NULL OR campo_formulario_usuario=0');
$exibir = $sql->listaVetorChave('campo_formulario_campo','campo_formulario_ativo');
$sql->limpar();

$sql->adTabela('moeda');
$sql->adCampo('moeda_id, moeda_simbolo');
$sql->adOrdem('moeda_id');
$moedas=$sql->listaVetorChave('moeda_id','moeda_simbolo');
$sql->limpar();

$plano_acao_acesso = getSisValor('NivelAcesso','','','sisvalor_id');


if (isset($_REQUEST['tab'])) $Aplic->setEstado('VerPlanoAcaoTab', getParam($_REQUEST, 'tab', null));

$tab = $Aplic->getEstado('VerPlanoAcaoTab') !== null ? $Aplic->getEstado('VerPlanoAcaoTab') : 0;
$msg = '';
$editar=($podeEditar&& permiteEditarPlanoAcao($obj->plano_acao_acesso,$obj->plano_acao_id));


if ($Aplic->profissional){
	$sql->adTabela('assinatura');
	$sql->adCampo('assinatura_id, assinatura_data, assinatura_aprova');
	$sql->adOnde('assinatura_usuario='.(int)$Aplic->usuario_id);
	$sql->adOnde('assinatura_acao='.(int)$plano_acao_id);
	$assinar = $sql->linha();
	$sql->limpar();
	
	//tem assinatura que aprova
	$sql->adTabela('assinatura');
	$sql->adCampo('count(assinatura_id)');
	$sql->adOnde('assinatura_aprova=1');
	$sql->adOnde('assinatura_acao='.(int)$plano_acao_id);
	$tem_aprovacao = $sql->resultado();
	$sql->limpar();
	}

if (!$dialogo && !$Aplic->profissional){
	$Aplic->salvarPosicao();
	$botoesTitulo = new CBlocoTitulo('Detalhes do '.ucfirst($config['acao']), 'plano_acao.png', $m, $m.'.'.$a);
	$botoesTitulo->adicionaBotao('m=praticas&a=plano_acao_lista', 'lista','','Lista de '.$config['acoes'],'Clique neste bot�o para visualizar a lista de '.$config['acoes'].'.');
	if ($editar) {
		$botoesTitulo->adicionaBotao('m=praticas&a=plano_acao_editar&plano_acao_id='.(int)$plano_acao_id, 'editar','','Editar este Plano de A��o','Editar os detalhes d'.($config['genero_acao']=='a' ? 'esta ': 'este ').$config['acao'].'.');
		$botoesTitulo->adicionaBotao('m=praticas&a=plano_acao_editar_item&plano_acao_id='.(int)$plano_acao_id, 'lista de a��es','','Lista de A��es','Inserir ou editar lista de a��es n'.($config['genero_acao']=='a' ? 'esta ': 'este ').$config['acao'].'.');
		if ($podeExcluir && $editar) $botoesTitulo->adicionaBotaoExcluir('excluir', $podeExcluir, $msg,'Excluir '.ucfirst($config['acao']),'Excluir '.($config['genero_acao']=='a' ? 'esta ': 'este ').$config['acao'].' do sistema.');
		}
	$linha_inserir='';
	if ($editar && !$Aplic->profissional){
		if ($Aplic->modulo_ativo('projetos') && $Aplic->checarModulo('projetos', 'adicionar')) $linha_inserir.='<td nowrap="nowrap">'.dica('Novo '.ucfirst($config['projeto']), 'Inserir '.($config['genero_projeto']=='o' ? 'um novo ' : 'uma nova ').$config['projeto'].' relacionad'.$config['genero_projeto'].' a '.($config['genero_acao']=='o' ? 'este' : 'esta').' '.$config['acao'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=projetos&a=editar&projeto_acao='.(int)$plano_acao_id.'\');" ><span>'.$config['projeto'].'</span></a>'.dicaF().'</td>';
		if ($Aplic->modulo_ativo('calendario') && $Aplic->checarModulo('calendario', 'adicionar')) $linha_inserir.='<td nowrap="nowrap">'.dica('Novo Evento', 'Criar '.($config['genero_acao']=='o' ? 'um novo ' : 'uma nova ').$config['acao'].'.<br><br>Os plano_acaos s�o atividades com data e hora espec�ficas podendo estar relacionados com '.$config['projetos'].','.$config['tarefas'].' e '.$config['usuarios'].' espec�ficos.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=calendario&a=editar&evento_acao='.(int)$plano_acao_id.'\');" ><span>evento</span></a>'.dicaF().'</td>';
		if ($Aplic->modulo_ativo('arquivos') && $Aplic->checarModulo('arquivos', 'adicionar')) $linha_inserir.='<td nowrap="nowrap">'.dica('Novo Arquivo', 'Inserir um novo arquivo relacionado a '.($config['genero_acao']=='o' ? 'este' : 'esta').' '.$config['acao'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=arquivos&a=editar&arquivo_acao='.(int)$plano_acao_id.'\');" ><span>arquivo</span></a>'.dicaF().'</td>';
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'adicionar')) $linha_inserir.='<td nowrap="nowrap">'.dica('Novo Indicador', 'Inserir um novo indicador relacionado a '.($config['genero_acao']=='o' ? 'este' : 'esta').' '.$config['acao'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=praticas&a=indicador_editar&pratica_indicador_acao='.(int)$plano_acao_id.'\');" ><span>indicador</span></a>'.dicaF().'</td>';
		if ($Aplic->modulo_ativo('foruns') && $Aplic->checarModulo('foruns', 'adicionar')) $linha_inserir.='<td nowrap="nowrap">'.dica('Novo F�rum', 'Inserir um novo f�rum relacionado a '.($config['genero_acao']=='o' ? 'este' : 'esta').' '.$config['acao'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=foruns&a=editar&forum_acao='.(int)$plano_acao_id.'\');" ><span>forum</span></a>'.dicaF().'</td>';
		if ($Aplic->modulo_ativo('links') && $Aplic->checarModulo('links', 'adicionar')) $linha_inserir.='<td nowrap="nowrap">'.dica('Novo Link', 'Inserir um novo link relacionado a '.($config['genero_acao']=='o' ? 'este' : 'esta').' '.$config['acao'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=links&a=editar&link_acao='.(int)$plano_acao_id.'\');" ><span>link</span></a>'.dicaF().'</td>';
		if ($linha_inserir)	$botoesTitulo->adicionaCelula('<table cellpadding=1 cellspacing=0><tr>'.$linha_inserir.'</tr></table>');
		}
	$botoesTitulo->adicionaCelula('<a href="javascript: void(0);" onclick ="url_passar(1, \'m='.$m.'&a='.$a.'&dialogo=1&plano_acao_id='.(int)$plano_acao_id.'\');">'.imagem('imprimir_p.png', 'Imprimir', 'Clique neste �cone '.imagem('imprimir_p.png').' para imprimir '.$config['genero_acao'].' '.$config['acao'].'.').'</a>');
	$botoesTitulo->mostrar();
	echo estiloTopoCaixa();
	}
elseif (!$dialogo && $Aplic->profissional){	
	$Aplic->salvarPosicao();
	$botoesTitulo = new CBlocoTitulo('Detalhes d'.$config['genero_acao'].' '.ucfirst($config['acao']).'', 'plano_acao.png', $m, $m.'.'.$a);
	$botoesTitulo->mostrar();
	echo estiloTopoCaixa();
	echo '<table align="center" cellspacing=0 cellpadding=0 width="100%">'; 
	echo '<tr><td colspan=2 style="background-color: #e6e6e6" width="100%">';
	require_once BASE_DIR.'/lib/coolcss/CoolControls/CoolMenu/coolmenu.php';
	$km = new CoolMenu("km");
	$km->scriptFolder ='lib/coolcss/CoolControls/CoolMenu';
	$km->styleFolder="default";
	$km->Add("root","ver",dica('Ver','Menu de op��es de visualiza��o').'Ver'.dicaF(), "javascript: void(0);");
	$km->Add("ver","ver_lista",dica('Lista de '.ucfirst($config['acoes']),'Clique neste bot�o para visualizar a lista de '.$config['acoes'].'.').'Lista de '.ucfirst($config['acoes']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=plano_acao_lista\");");
	if ($editar){
		$km->Add("root","inserir",dica('Inserir','Menu de op��es').'Inserir'.dicaF(), "javascript: void(0);'");
		$km->Add("inserir","inserir_tarefa",dica('Nov'.$config['genero_acao'].' '.ucfirst($config['acao']), 'Criar um nov'.$config['genero_acao'].' '.$config['acao'].'.').'Nov'.$config['genero_acao'].' '.ucfirst($config['acao']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=plano_acao_editar\");");
		
		$km->Add("inserir","inserir_registro",dica('Registro de Ocorr�ncia','Inserir um novo registro de ocorr�ncia.').'Registro de Ocorr�ncia'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=log_editar_pro&plano_acao_id=".$plano_acao_id."\");");
		if ($Aplic->modulo_ativo('calendario') && $Aplic->checarModulo('calendario', 'adicionar')) $km->Add("inserir","inserir_evento",dica('Novo Evento', 'Criar um novo evento relacionado.').'Evento'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=calendario&a=editar&evento_acao=".$plano_acao_id."\");");
		if ($Aplic->modulo_ativo('arquivos') && $Aplic->checarModulo('arquivos', 'adicionar')) $km->Add("inserir","inserir_arquivo",dica('Novo Arquivo', 'Inserir um novo arquivo relacionado.').'Arquivo'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=arquivos&a=editar&arquivo_acao=".$plano_acao_id."\");");
		if ($Aplic->modulo_ativo('links') && $Aplic->checarModulo('links', 'adicionar')) $km->Add("inserir","inserir_link",dica('Novo Link', 'Inserir um novo link relacionado.').'Link'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=links&a=editar&link_acao=".$plano_acao_id."\");");
		if ($Aplic->modulo_ativo('foruns') && $Aplic->checarModulo('foruns', 'adicionar')) $km->Add("inserir","inserir_forum",dica('Novo F�rum', 'Inserir um novo f�rum relacionado.').'F�rum'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=foruns&a=editar&forum_acao=".$plano_acao_id."\");");
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'adicionar', null, 'indicador')) 	$km->Add("inserir","inserir_indicador",dica('Novo Indicador', 'Inserir um novo indicador relacionado.').'Indicador'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=indicador_editar&pratica_indicador_acao=".$plano_acao_id."\");");
		if ($Aplic->modulo_ativo('projetos') && $Aplic->checarModulo('projetos', 'adicionar')) $km->Add("inserir","inserir_projeto", dica('Nov'.$config['genero_projeto'].' '.ucfirst($config['projeto']), 'Inserir nov'.$config['genero_projeto'].' '.$config['projeto'].' relacionad'.$config['genero_projeto'].'.').ucfirst($config['projeto']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=projetos&a=editar&projeto_acao=".$plano_acao_id."\");");	
		if ($Aplic->modulo_ativo('email') && $Aplic->checarModulo('email', 'adicionar')) $km->Add("inserir","inserir_mensagem",dica('Nov'.$config['genero_mensagem'].' '.ucfirst($config['mensagem']), 'Inserir '.($config['genero_mensagem']=='a' ? 'uma' : 'um').' nov'.$config['genero_mensagem'].' '.$config['mensagem'].' relacionad'.$config['genero_mensagem'].'.').ucfirst($config['mensagem']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=email&a=nova_mensagem_pro&msg_acao=".$plano_acao_id."\");");
		if ($config['doc_interno'] && $Aplic->checarModulo('email', 'adicionar', $Aplic->usuario_id, 'criar_modelo')){
			$sql->adTabela('modelos_tipo');
			$sql->esqUnir('modelo_cia', 'modelo_cia', 'modelo_cia_tipo=modelo_tipo_id');
			$sql->adCampo('modelo_tipo_id, modelo_tipo_nome, imagem');
			$sql->adOnde('organizacao='.(int)$config['militar']);
			$sql->adOnde('modelo_cia_cia='.(int)$Aplic->usuario_cia);
			$modelos = $sql->Lista();
			$sql->limpar();
			if (count($modelos)){
				$km->Add("inserir","criar_documentos","Documento");
				foreach($modelos as $rs) $km->Add("criar_documentos","novodocumento",$rs['modelo_tipo_nome'].'&nbsp;&nbsp;&nbsp;&nbsp;',	"javascript: void(0);' onclick='url_passar(0, \"m=email&a=modelo_editar&editar=1&novo=1&modelo_id=0&modelo_tipo_id=".$rs['modelo_tipo_id']."&modelo_acao=".$plano_acao_id."\");", ($rs['imagem'] ? "estilo/rondon/imagens/icones/".$rs['imagem'] : ''));
				}
			}
		if ($Aplic->modulo_ativo('atas') && $Aplic->checarModulo('atas', 'adicionar')) $km->Add("inserir","inserir_ata",dica('Nova Ata de Reuni�o', 'Inserir uma nova ata de reuni�o relacionada.').'Ata de reuni�o'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=atas&a=ata_editar&ata_acao=".$plano_acao_id."\");");
		if ($Aplic->modulo_ativo('problema') && $Aplic->checarModulo('problema', 'adicionar')) $km->Add("inserir","inserir_problema",dica('Nov'.$config['genero_problema'].' '.ucfirst($config['problema']), 'Inserir um'.($config['genero_problema']=='a' ? 'a' : '').' nov'.$config['genero_problema'].' '.$config['problema'].' relacionad'.$config['genero_problema'].'.').ucfirst($config['problema']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=problema&a=problema_editar&problema_acao=".$plano_acao_id."\");");
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'adicionar', null, 'risco')) $km->Add("inserir","inserir_risco", dica('Nov'.$config['genero_risco'].' '.ucfirst($config['risco']), 'Inserir um'.($config['genero_risco']=='a' ? 'a' : '').' nov'.$config['genero_risco'].' '.$config['risco'].' relacionad'.$config['genero_risco'].'.').ucfirst($config['risco']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=risco_pro_editar&risco_acao=".$plano_acao_id."\");");

		}	
	$km->Add("root","acao",dica('A��o','Menu de a��es.').'A��o'.dicaF(), "javascript: void(0);'");
	
	$bloquear=($obj->plano_acao_aprovado && $config['trava_aprovacao'] && $tem_aprovacao && !$Aplic->usuario_super_admin);
	
	if (isset($assinar['assinatura_id']) && $assinar['assinatura_id'] && !$bloquear) $km->Add("acao","acao_assinar", ($assinar['assinatura_data'] ? dica('Mudar Assinatura', 'Entrar� na tela em que se pode mudar a assinatura.').'Mudar Assinatura'.dicaF() : dica('Assinar', 'Entrar� na tela em que se pode assinar.').'Assinar'.dicaF()), "javascript: void(0);' onclick='url_passar(0, \"m=sistema&u=assinatura&a=assinatura_assinar&plano_acao_id=".$plano_acao_id."\");"); 
	
	if ($podeEditar && $editar && !$bloquear) {
		$km->Add("acao","acao_editar",dica('Editar '.ucfirst($config['acao']),'Editar os detalhes d'.($config['genero_acao']=='a' ? 'esta' : 'este').' '.$config['acao'].'.').'Editar '.ucfirst($config['acao']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=plano_acao_editar&plano_acao_id=".$plano_acao_id."\");");
		$km->Add("acao","acao_editar_item",dica('Editar Lista de A��es','Inserir ou editar lista de a��es n'.($config['genero_acao']=='a' ? 'esta ': 'este ').$config['acao'].'.').'Editar Lista de A��es'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=plano_acao_editar_item&plano_acao_id=".$plano_acao_id."\");");
		}
	
	if ($podeExcluir && $editar && !$bloquear) $km->Add("acao","acao_excluir",dica('Excluir','Excluir '.($config['genero_acao']=='a' ? 'esta' : 'este').' '.$config['acao'].' do sistema.').'Excluir '.ucfirst($config['acao']).dicaF(), "javascript: void(0);' onclick='excluir()");
	
	$km->Add("acao","acao_imprimir",dica('Imprimir', 'Clique neste �cone '.imagem('imprimir_p.png').' para visualizar as op��es de relat�rios.').imagem('imprimir_p.png').' Imprimir'.dicaF(), "javascript: void(0);'");	
	$km->Add("acao_imprimir","acao_imprimir1",dica(ucfirst($config['acao']), 'Imprimir '.$config['genero_acao'].' '.$config['acao'].'.').ucfirst($config['acao']).dicaF(), "javascript: void(0);' onclick='url_passar(1, \"m=".$m."&a=".$a."&dialogo=1&plano_acao_id=".$plano_acao_id."\");");
	$km->Add("acao_imprimir","acao_imprimir2",dica('Registro de Ocorr�ncia', 'Imprimir os registros de ocorr�ncia  d'.$config['genero_acao'].' '.$config['acao'].'.').'Registro de Ocorr�ncia'.dicaF(), "javascript: void(0);' onclick='url_passar(1, \"m=".$m."&a=log_ver_pro&dialogo=1&cia_id=".$obj->plano_acao_cia."&plano_acao_id=".$plano_acao_id."\");");
	
	
	$km->Add("acao","acao_exportar",dica('Exportar Link', 'Clique neste �cone '.imagem('icones/exporta_p.png').' para criar um endere�o web para visualiza��o em ambiente externo.').imagem('icones/exporta_p.png').' Exportar Link'.dicaF(), "javascript: void(0);' onclick='exportar_link();");	

	echo $km->Render();
	echo '</td></tr></table>';
	}	
else{
	if ($Aplic->profissional) {
		$barra=codigo_barra('acao', $plano_acao_id, null, 1080);
		if ($barra['cabecalho']) echo $barra['imagem'];
		}
	}
	
if($dialogo && $Aplic->profissional) {
	include_once BASE_DIR.'/modulos/projetos/artefato.class.php';
	include_once BASE_DIR.'/modulos/projetos/artefato_template.class.php';
	$dados=array();
	$dados['projeto_cia'] = $obj->plano_acao_cia;
	$sql->adTabela('artefatos_tipo');
	$sql->adCampo('artefato_tipo_campos, artefato_tipo_endereco, artefato_tipo_html');
	$sql->adOnde('artefato_tipo_civil=\''.$config['anexo_civil'].'\'');
	$sql->adOnde('artefato_tipo_arquivo=\'cabecalho_simples_pro.html\'');
	$linha = $sql->linha();
	$sql->limpar();
	$campos = unserialize($linha['artefato_tipo_campos']);
	$modelo= new Modelo;
	$modelo->set_modelo_tipo(1);
	foreach((array)$campos['campo'] as $posicao => $campo) $modelo->set_campo($campo['tipo'], str_replace('\"','"',$campo['dados']), $posicao);
	$tpl = new Template($linha['artefato_tipo_html'],false,false, false, true);
	$modelo->set_modelo($tpl);
	echo '<table align="left" cellspacing=0 cellpadding=0 width=100%><tr><td>';
	for ($i=1; $i <= $modelo->quantidade(); $i++){
		$campo='campo_'.$i;
		$tpl->$campo = $modelo->get_campo($i);
		} 
	echo $tpl->exibir($modelo->edicao); 
	echo '</td></tr></table>';
	echo 	'<font size="4"><center>'.ucfirst($config['acao']).'</center></font>';
	}	
	
	
echo '<form name="env" method="post">';
echo '<input type="hidden" name="m" value="praticas" />';
echo '<input type="hidden" name="a" value="plano_acao_ver" />';
echo '<input type="hidden" name="plano_acao_id" value="'.$plano_acao_id.'" />';
echo '<input type="hidden" name="del" value="" />';
echo '<input type="hidden" name="modulo" value="" />';
echo '</form>';

echo '<table cellpadding=0 cellspacing=1 width="100%" '.($dialogo ? '' : 'class="std"').'>';


$cor_indicador=cor_indicador('plano_acao', null, null, null, null, $obj->plano_acao_principal_indicador);

echo '<tr><td style="border: outset #d1d1cd 1px;background-color:#'.$obj->plano_acao_cor.'" colspan="2"><font color="'.melhorCor($obj->plano_acao_cor).'"><b>'.$obj->plano_acao_nome.'<b></font>'.$cor_indicador.'</td></tr>';


$sql->adTabela('plano_acao_usuarios');
$sql->adCampo('usuario_id');
$sql->adOnde('plano_acao_id = '.(int)$plano_acao_id);
$participantes = $sql->carregarColuna();
$sql->limpar();

$sql->adTabela('plano_acao_depts');
$sql->adCampo('dept_id');
$sql->adOnde('plano_acao_id = '.(int)$plano_acao_id);
$departamentos = $sql->carregarColuna();
$sql->limpar();


$sql->adTabela('plano_acao_contatos');
$sql->adCampo('contato_id');
$sql->adOnde('plano_acao_id = '.(int)$plano_acao_id);
$lista_contatos = $sql->carregarColuna();
$sql->limpar();


if ($obj->plano_acao_cia) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['organizacao']).' Respons�vel', ucfirst($config['genero_organizacao']).' '.$config['organizacao'].' respons�vel.').ucfirst($config['organizacao']).' respons�vel:'.dicaF().'</td><td class="realce" width="100%">'.link_cia($obj->plano_acao_cia).'</td></tr>';
if ($Aplic->profissional){
	$sql->adTabela('plano_acao_cia');
	$sql->adCampo('plano_acao_cia_cia');
	$sql->adOnde('plano_acao_cia_plano_acao = '.(int)$plano_acao_id);
	$cias_selecionadas = $sql->carregarColuna();
	$sql->limpar();	
	$saida_cias='';
	if (count($cias_selecionadas)) {
		$saida_cias.= '<table cellpadding=0 cellspacing=0 width=100%>';
		$saida_cias.= '<tr><td>'.link_cia($cias_selecionadas[0]);
		$qnt_lista_cias=count($cias_selecionadas);
		if ($qnt_lista_cias > 1) {
				$lista='';
				for ($i = 1, $i_cmp = $qnt_lista_cias; $i < $i_cmp; $i++) $lista.=link_cia($cias_selecionadas[$i]).'<br>';
				$saida_cias.= dica('Outr'.$config['genero_organizacao'].'s '.ucfirst($config['organizacoes']), 'Clique para visualizar '.$config['genero_organizacao'].'s demais '.strtolower($config['organizacoes']).'.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_cias\');">(+'.($qnt_lista_cias - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_cias"><br>'.$lista.'</span>';
				}
		$saida_cias.= '</td></tr></table>';
		}
	if ($saida_cias) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['organizacoes']).' Envolvid'.$config['genero_organizacao'].'s', 'Quais '.strtolower($config['organizacoes']).' est�o envolvid'.$config['genero_organizacao'].'s.').ucfirst($config['organizacoes']).' envolvid'.$config['genero_organizacao'].'s:'.dicaF().'</td><td width="100%" colspan="2" class="realce">'.$saida_cias.'</td></tr>';
	}

if ($obj->plano_acao_dept) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['departamento']).' Respons�vel', ucfirst($config['genero_dept']).' '.$config['departamento'].' respons�vel por est'.($config['genero_acao']=='a' ? 'a' : 'e').' '.$config['acao'].'.').ucfirst($config['departamento']).' respons�vel:'.dicaF().'</td><td class="realce" width="100%">'.link_secao($obj->plano_acao_dept).'</td></tr>';


$saida_depts='';
if ($departamentos && count($departamentos)) {
		$saida_depts.= '<table cellspacing=0 cellpadding=0 width="100%">';
		$saida_depts.= '<tr><td>'.link_secao($departamentos[0]);
		$qnt_lista_depts=count($departamentos);
		if ($qnt_lista_depts > 1) {		
				$lista='';
				for ($i = 1, $i_cmp = $qnt_lista_depts; $i < $i_cmp; $i++) $lista.=link_secao($departamentos[$i]).'<br>';		
				$saida_depts.= dica('Outr'.$config['genero_dept'].'s '.ucfirst($config['departamentos']), 'Clique para visualizar '.$config['genero_dept'].'s demais '.strtolower($config['departamentos']).'.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_depts\');">(+'.($qnt_lista_depts - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_depts"><br>'.$lista.'</span>';
				}
		$saida_depts.= '</td></tr></table>';
		} 
if ($saida_depts) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['departamentos']).' Envolvid'.$config['genero_dept'].'s', 'Quais '.strtolower($config['departamento']).' est�o relacionad'.$config['genero_dept'].'s � este '.$config['acao'].'.').ucfirst($config['departamentos']).' envolvid'.$config['genero_dept'].'s:'.dicaF().'</td><td width="100%" colspan="2" class="realce">'.$saida_depts.'</td></tr>';


if ($obj->plano_acao_responsavel) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Respons�vel pel'.$config['genero_acao'].' '.ucfirst($config['acao']).'', ucfirst($config['usuario']).' respons�vel por gerenciar '.$config['genero_acao'].' '.$config['acao'].'.').'Respons�vel:'.dicaF().'</td><td class="realce" width="100%">'.link_usuario($obj->plano_acao_responsavel, '','','esquerda').'</td></tr>';		

$saida_quem='';
if ($participantes && count($participantes)) {
		$saida_quem.= '<table cellspacing=0 cellpadding=0 width="100%">';
		$saida_quem.= '<tr><td>'.link_usuario($participantes[0], '','','esquerda');
		$qnt_participantes=count($participantes);
		if ($qnt_participantes > 1) {		
				$lista='';
				for ($i = 1, $i_cmp = $qnt_participantes; $i < $i_cmp; $i++) $lista.=link_usuario($participantes[$i], '','','esquerda').'<br>';		
				$saida_quem.= dica('Outros Participantes', 'Clique para visualizar os demais designados.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'participantes\');">(+'.($qnt_participantes - 1).')</a>'.dicaF(). '<span style="display: none" id="participantes"><br>'.$lista.'</span>';
				}
		$saida_quem.= '</td></tr></table>';
		} 
if ($saida_quem) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Designados', 'Quais '.$config['usuarios'].' est�o designados para '.$config['genero_acao'].' '.$config['acao'].'.').'Designados:'.dicaF().'</td><td width="100%" colspan="2" class="realce">'.$saida_quem.'</td></tr>';


$saida_contato='';
if ($lista_contatos && count($lista_contatos)) {
		$saida_contato.= '<table cellspacing=0 cellpadding=0 width="100%">';
		$saida_contato.= '<tr><td>'.link_contato($lista_contatos[0], '','','esquerda');
		$qnt_lista_contatos=count($lista_contatos);
		if ($qnt_lista_contatos > 1) {		
				$lista='';
				for ($i = 1, $i_cmp = $qnt_lista_contatos; $i < $i_cmp; $i++) $lista.=link_contato($lista_contatos[$i], '','','esquerda').'<br>';		
				$saida_contato.= dica('Outros Contatos', 'Clique para visualizar os demais contatos.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_contatos\');">(+'.($qnt_lista_contatos - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_contatos"><br>'.$lista.'</span>';
				}
		$saida_contato.= '</td></tr></table>';
		} 
if ($saida_contato) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Contatos', 'Quem s�o os contatos d'.$config['genero_acao'].' '.$config['acao'].'.').'Contatos:'.dicaF().'</td><td width="100%" colspan="2" class="realce">'.$saida_contato.'</td></tr>';




if ($obj->plano_acao_descricao) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Descri��o', 'Descri��o d'.$config['genero_acao'].' '.$config['acao'].'.').'Descri��o:'.dicaF().'</td><td colspan="2" class="realce">'.$obj->plano_acao_descricao.'</td></tr>';


if (isset($obj->plano_acao_codigo) && $obj->plano_acao_codigo) echo '<tr><td align="right" nowrap="nowrap">'.dica('C�digo', 'O c�digo d'.$config['genero_acao'].' '.$config['acao'].'.').'C�digo:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->plano_acao_codigo.'</td></tr>';
if (isset($obj->plano_acao_setor) && $obj->plano_acao_setor) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['setor']), 'A qual '.$config['setor'].' perternce '.$config['genero_acao'].' '.$config['acao'].'.').ucfirst($config['setor']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->getSetor().'</td></tr>';
if (isset($obj->plano_acao_segmento) && $obj->plano_acao_segmento) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['segmento']), 'A qual '.$config['segmento'].' perternce '.$config['genero_acao'].' '.$config['acao'].'.').ucfirst($config['segmento']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->getSegmento().'</td></tr>';
if (isset($obj->plano_acao_intervencao) && $obj->plano_acao_intervencao) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['intervencao']), 'A qual '.$config['intervencao'].' perternce '.$config['genero_acao'].' '.$config['acao'].'.').ucfirst($config['intervencao']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->getIntervencao().'</td></tr>';
if (isset($obj->plano_acao_tipo_intervencao) && $obj->plano_acao_tipo_intervencao) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['tipo']), 'A qual '.$config['tipo'].' pertence '.$config['genero_acao'].' '.$config['acao'].'.').ucfirst($config['tipo']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->getTipoIntervencao().'</td></tr>';


if ($Aplic->profissional){
	$sql->adTabela('plano_acao_gestao');
	$sql->adCampo('plano_acao_gestao.*');
	$sql->adOnde('plano_acao_gestao_acao ='.(int)$plano_acao_id);
	$sql->adOrdem('plano_acao_gestao_ordem');	
	$lista = $sql->Lista();
	$sql->limpar();
	$qnt=0;
	if (count($lista)){	
		if ($Aplic->profissional) require_once BASE_DIR.'/modulos/projetos/template_pro.class.php';
		$ata_ativo=$Aplic->modulo_ativo('atas');
		if ($ata_ativo) require_once BASE_DIR.'/modulos/atas/funcoes.php';
		$swot_ativo=$Aplic->modulo_ativo('swot');
		if ($swot_ativo) {
			require_once BASE_DIR.'/modulos/swot/swot.class.php';
			require_once BASE_DIR.'/modulos/swot/mswot.class.php';
			}
		$operativo_ativo=$Aplic->modulo_ativo('operativo');
		if ($operativo_ativo) require_once BASE_DIR.'/modulos/operativo/funcoes.php';
		$problema_ativo=$Aplic->modulo_ativo('problema');
		if ($problema_ativo) require_once BASE_DIR.'/modulos/problema/funcoes.php';
		$agrupamento_ativo=$Aplic->modulo_ativo('agrupamento');
		if($agrupamento_ativo) require_once BASE_DIR.'/modulos/agrupamento/funcoes.php';
		$patrocinador_ativo=$Aplic->modulo_ativo('patrocinadores');
		if($patrocinador_ativo) require_once BASE_DIR.'/modulos/patrocinadores/patrocinadores.class.php';
		echo '<tr><td align="right">'.dica('Relacionad'.$config['genero_mensagem'],'�reas as quais est� relacionad'.$config['genero_mensagem'].'.').'Relacionad'.$config['genero_mensagem'].':'.dicaF().'</td><td class="realce" width="100%">';
		foreach($lista as $gestao_data){	
			if ($gestao_data['plano_acao_gestao_tarefa']) echo ($qnt++ ? '<br>' : '').imagem('icones/tarefa_p.gif').link_tarefa($gestao_data['plano_acao_gestao_tarefa']);
			elseif ($gestao_data['plano_acao_gestao_projeto']) echo ($qnt++ ? '<br>' : '').imagem('icones/projeto_p.gif').link_projeto($gestao_data['plano_acao_gestao_projeto']);
			elseif ($gestao_data['plano_acao_gestao_pratica']) echo ($qnt++ ? '<br>' : '').imagem('icones/pratica_p.gif').link_pratica($gestao_data['plano_acao_gestao_pratica']);
			elseif ($gestao_data['plano_acao_gestao_perspectiva']) echo ($qnt++ ? '<br>' : '').imagem('icones/perspectiva_p.png').link_perspectiva($gestao_data['plano_acao_gestao_perspectiva']);
			elseif ($gestao_data['plano_acao_gestao_tema']) echo ($qnt++ ? '<br>' : '').imagem('icones/tema_p.png').link_tema($gestao_data['plano_acao_gestao_tema']);
			elseif ($gestao_data['plano_acao_gestao_objetivo']) echo ($qnt++ ? '<br>' : '').imagem('icones/obj_estrategicos_p.gif').link_objetivo($gestao_data['plano_acao_gestao_objetivo']);
			elseif ($gestao_data['plano_acao_gestao_fator']) echo ($qnt++ ? '<br>' : '').imagem('icones/fator_p.gif').link_fator($gestao_data['plano_acao_gestao_fator']);
			elseif ($gestao_data['plano_acao_gestao_estrategia']) echo ($qnt++ ? '<br>' : '').imagem('icones/estrategia_p.gif').link_estrategia($gestao_data['plano_acao_gestao_estrategia']);
			elseif ($gestao_data['plano_acao_gestao_meta']) echo ($qnt++ ? '<br>' : '').imagem('icones/meta_p.gif').link_meta($gestao_data['plano_acao_gestao_meta']);
			elseif ($gestao_data['plano_acao_gestao_canvas']) echo ($qnt++ ? '<br>' : '').imagem('icones/canvas_p.png').link_canvas($gestao_data['plano_acao_gestao_canvas']);
			elseif ($gestao_data['plano_acao_gestao_risco']) echo ($qnt++ ? '<br>' : '').imagem('icones/risco_p.png').link_risco($gestao_data['plano_acao_gestao_risco']);
			elseif ($gestao_data['plano_acao_gestao_risco_resposta']) echo ($qnt++ ? '<br>' : '').imagem('icones/risco_resposta_p.png').link_risco_resposta($gestao_data['plano_acao_gestao_risco_resposta']);
			elseif ($gestao_data['plano_acao_gestao_indicador']) echo ($qnt++ ? '<br>' : '').imagem('icones/indicador_p.gif').link_indicador($gestao_data['plano_acao_gestao_indicador']);
			elseif ($gestao_data['plano_acao_gestao_calendario']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_calendario($gestao_data['plano_acao_gestao_calendario']);
			elseif ($gestao_data['plano_acao_gestao_monitoramento']) echo ($qnt++ ? '<br>' : '').imagem('icones/monitoramento_p.gif').link_monitoramento($gestao_data['plano_acao_gestao_monitoramento']);
			elseif ($gestao_data['plano_acao_gestao_ata']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/atas/imagens/ata_p.png').link_ata_pro($gestao_data['plano_acao_gestao_ata']);
			elseif ($gestao_data['plano_acao_gestao_mswot']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/swot/imagens/mswot_p.png').link_mswot($gestao_data['plano_acao_gestao_mswot']);
			elseif ($gestao_data['plano_acao_gestao_swot']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/swot/imagens/swot_p.png').link_swot($gestao_data['plano_acao_gestao_swot']);
			elseif ($gestao_data['plano_acao_gestao_operativo']) echo ($qnt++ ? '<br>' : '').imagem('icones/operativo_p.png').link_operativo($gestao_data['plano_acao_gestao_operativo']);
			elseif ($gestao_data['plano_acao_gestao_instrumento']) echo ($qnt++ ? '<br>' : '').imagem('icones/instrumento_p.png').link_instrumento($gestao_data['plano_acao_gestao_instrumento']);
			elseif ($gestao_data['plano_acao_gestao_recurso']) echo ($qnt++ ? '<br>' : '').imagem('icones/recursos_p.gif').link_recurso($gestao_data['plano_acao_gestao_recurso']);
			elseif ($gestao_data['plano_acao_gestao_problema']) echo ($qnt++ ? '<br>' : '').imagem('icones/problema_p.png').link_problema_pro($gestao_data['plano_acao_gestao_problema']);
			elseif ($gestao_data['plano_acao_gestao_demanda']) echo ($qnt++ ? '<br>' : '').imagem('icones/demanda_p.gif').link_demanda($gestao_data['plano_acao_gestao_demanda']);
			elseif ($gestao_data['plano_acao_gestao_programa']) echo ($qnt++ ? '<br>' : '').imagem('icones/programa_p.png').link_programa($gestao_data['plano_acao_gestao_programa']);
			elseif ($gestao_data['plano_acao_gestao_licao']) echo ($qnt++ ? '<br>' : '').imagem('icones/licoes_p.gif').link_licao($gestao_data['plano_acao_gestao_licao']);
			elseif ($gestao_data['plano_acao_gestao_evento']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_evento($gestao_data['plano_acao_gestao_evento']);
			elseif ($gestao_data['plano_acao_gestao_link']) echo ($qnt++ ? '<br>' : '').imagem('icones/links_p.gif').link_link($gestao_data['plano_acao_gestao_link']);
			elseif ($gestao_data['plano_acao_gestao_avaliacao']) echo ($qnt++ ? '<br>' : '').imagem('icones/avaliacao_p.gif').link_avaliacao($gestao_data['plano_acao_gestao_avaliacao']);
			elseif ($gestao_data['plano_acao_gestao_tgn']) echo ($qnt++ ? '<br>' : '').imagem('icones/tgn_p.png').link_tgn($gestao_data['plano_acao_gestao_tgn']);
			elseif ($gestao_data['plano_acao_gestao_brainstorm']) echo ($qnt++ ? '<br>' : '').imagem('icones/brainstorm_p.gif').link_brainstorm_pro($gestao_data['plano_acao_gestao_brainstorm']);
			elseif ($gestao_data['plano_acao_gestao_gut']) echo ($qnt++ ? '<br>' : '').imagem('icones/gut_p.gif').link_gut_pro($gestao_data['plano_acao_gestao_gut']);
			elseif ($gestao_data['plano_acao_gestao_causa_efeito']) echo ($qnt++ ? '<br>' : '').imagem('icones/causaefeito_p.png').link_causa_efeito_pro($gestao_data['plano_acao_gestao_causa_efeito']);
			elseif ($gestao_data['plano_acao_gestao_arquivo']) echo ($qnt++ ? '<br>' : '').imagem('icones/arquivo_p.png').link_arquivo($gestao_data['plano_acao_gestao_arquivo']);
			elseif ($gestao_data['plano_acao_gestao_forum']) echo ($qnt++ ? '<br>' : '').imagem('icones/forum_p.gif').link_forum($gestao_data['plano_acao_gestao_forum']);
			elseif ($gestao_data['plano_acao_gestao_checklist']) echo ($qnt++ ? '<br>' : '').imagem('icones/todo_list_p.png').link_checklist($gestao_data['plano_acao_gestao_checklist']);
			elseif ($gestao_data['plano_acao_gestao_agenda']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_agenda($gestao_data['plano_acao_gestao_agenda']);
			elseif ($gestao_data['plano_acao_gestao_agrupamento']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/agrupamento/imagens/agrupamento_p.png').link_agrupamento($gestao_data['plano_acao_gestao_agrupamento']);
			elseif ($gestao_data['plano_acao_gestao_patrocinador']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/patrocinadores/imagens/patrocinador_p.gif').link_patrocinador($gestao_data['plano_acao_gestao_patrocinador']);
			elseif ($gestao_data['plano_acao_gestao_template']) echo ($qnt++ ? '<br>' : '').imagem('icones/template_p.gif').link_template($gestao_data['plano_acao_gestao_template']);
			elseif ($gestao_data['plano_acao_gestao_painel']) echo ($qnt++ ? '<br>' : '').imagem('icones/indicador_p.gif').link_painel($gestao_data['plano_acao_gestao_painel']);
			elseif ($gestao_data['plano_acao_gestao_painel_odometro']) echo ($qnt++ ? '<br>' : '').imagem('icones/odometro_p.png').link_painel_odometro($gestao_data['plano_acao_gestao_painel_odometro']);
			elseif ($gestao_data['plano_acao_gestao_painel_composicao']) echo ($qnt++ ? '<br>' : '').imagem('icones/painel_p.gif').link_painel_composicao($gestao_data['plano_acao_gestao_painel_composicao']);		
			elseif ($gestao_data['plano_acao_gestao_tr']) echo ($qnt++ ? '<br>' : '').imagem('icones/tr_p.png').link_tr($gestao_data['plano_acao_gestao_tr']);			
			elseif ($gestao_data['plano_acao_gestao_me']) echo ($qnt++ ? '<br>' : '').imagem('icones/me_p.png').link_me($gestao_data['plano_acao_gestao_me']);			
			}
		echo '</td></tr>';	
		}	
	}
else{
	if ($obj->plano_acao_estrategia) {
		$objetivo_estrategico_id=0;
		$perspectiva_id =0;
		$fator_critico_id=0;
		$tema_id=0;
		$sql->adTabela('estrategias');
		$sql->adCampo('pg_estrategia_fator');
		$sql->adOnde('pg_estrategia_id ='.(int)$obj->plano_acao_estrategia);
		$fator_critico_id = $sql->resultado();
		$sql->limpar();
	
		if ($fator_critico_id){
			$sql->adTabela('fator');
			$sql->adCampo('fator_objetivo');
			$sql->adOnde('fator_id ='.(int)$fator_critico_id);
			$objetivo_estrategico_id = $sql->resultado();
			$sql->limpar();
			}
		if ($objetivo_estrategico_id){
			$sql->adTabela('objetivo');
			$sql->adCampo('objetivo_perspectiva');
			$sql->adOnde('objetivo_id ='.(int)$objetivo_estrategico_id);
			$perspectiva_id = $sql->resultado();
			$sql->limpar();
			}
		if ($objetivo_estrategico_id) {
			$sql->adTabela('objetivo');
			$sql->adCampo('objetivo_tema');
			$sql->adOnde('objetivo_id ='.(int)$objetivo_estrategico_id);
			$tema_id = $sql->resultado();
			$sql->limpar();
			}
		if ($tema_id){
			$sql->adTabela('tema');
			$sql->adCampo('tema_perspectiva');
			$sql->adOnde('tema_id ='.(int)$tema_id);
			$perspectiva_id = $sql->resultado();
			$sql->limpar();
			}	
		if ($perspectiva_id) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['perspectiva']), 'A perspectiva estrat�gica � qual atende.').ucfirst($config['perspectiva']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_perspectiva($perspectiva_id).'</td></tr>';
		if ($tema_id) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['tema']), ucfirst($config['genero_tema']).' '.$config['tema'].' ao qual atende.').ucfirst($config['tema']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_tema($tema_id).'</td></tr>';
		if ($objetivo_estrategico_id) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['objetivo']), ucfirst($config['genero_objetivo']).' '.$config['objetivo'].' ao qual atende, por meio do fator cr�tico ao sucesso.').''.ucfirst($config['objetivo']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_objetivo($objetivo_estrategico_id).'</td></tr>';
		if ($fator_critico_id ) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['fator']), ucfirst($config['genero_fator']).' '.$config['fator'].' que atende, por meio da iniciativa.').ucfirst($config['fator']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_fator($fator_critico_id).'</td></tr>';
		echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Iniciativa', 'A iniciativa a qual atende.').'Iniciativa:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_estrategia($obj->plano_acao_estrategia).'</td></tr>';
		}
	
	if ($obj->plano_acao_fator) {
		$objetivo_estrategico_id=0;
		$perspectiva_id =0;
		$tema_id=0;
		$fator_critico_id=$obj->plano_acao_fator;
		$sql->adTabela('fator');
		$sql->adCampo('fator_objetivo');
		$sql->adOnde('fator_id ='.(int)$obj->plano_acao_fator);
		$objetivo_estrategico_id = $sql->resultado();
		$sql->limpar();
		if ($objetivo_estrategico_id){
			$sql->adTabela('objetivo');
			$sql->adCampo('objetivo_perspectiva');
			$sql->adOnde('objetivo_id ='.(int)$objetivo_estrategico_id);
			$perspectiva_id = $sql->resultado();
			$sql->limpar();
			}
		if ($objetivo_estrategico_id){
			$sql->adTabela('objetivo');
			$sql->adCampo('objetivo_tema');
			$sql->adOnde('objetivo_id ='.(int)$objetivo_estrategico_id);
			$tema_id = $sql->resultado();
			$sql->limpar();
			}
		if ($tema_id){
			$sql->adTabela('tema');
			$sql->adCampo('tema_perspectiva');
			$sql->adOnde('tema_id ='.(int)$tema_id);
			$perspectiva_id = $sql->resultado();
			$sql->limpar();
			}		
		if ($perspectiva_id) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['perspectiva']), 'A perspectiva estrat�gica � qual atende.').ucfirst($config['perspectiva']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_perspectiva($perspectiva_id).'</td></tr>';
		if ($tema_id) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['tema']), ucfirst($config['genero_tema']).' '.$config['tema'].' ao qual atende.').ucfirst($config['tema']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_tema($tema_id).'</td></tr>';
		if ($objetivo_estrategico_id) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['objetivo']), ucfirst($config['genero_objetivo']).' '.$config['objetivo'].' ao qual atende, por meio do fator cr�tico ao sucesso.').''.ucfirst($config['objetivo']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_objetivo($objetivo_estrategico_id).'</td></tr>';
		echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['fator']), ucfirst($config['genero_fator']).' '.$config['fator'].' que atende, por meio da iniciativa.').ucfirst($config['fator']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_fator($obj->plano_acao_fator).'</td></tr>';
		}
	elseif ($obj->plano_acao_objetivo) {
		$sql->adTabela('objetivo');
		$sql->adCampo('objetivo_perspectiva');
		$sql->adOnde('objetivo_id ='.(int)$obj->plano_acao_objetivo);
		$perspectiva_id = $sql->resultado();
		$sql->limpar();
		$sql->adTabela('objetivo');
		$sql->adCampo('objetivo_tema');
		$sql->adOnde('objetivo_id ='.(int)$obj->plano_acao_objetivo);
		$tema_id = $sql->resultado();
		$sql->limpar();
		
		if ($tema_id){
			$sql->adTabela('tema');
			$sql->adCampo('tema_perspectiva');
			$sql->adOnde('tema_id ='.(int)$tema_id);
			$perspectiva_id = $sql->resultado();
			$sql->limpar();
			}		
		if ($perspectiva_id) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['perspectiva']), 'A perspectiva estrat�gica � qual atende.').ucfirst($config['perspectiva']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_perspectiva($perspectiva_id).'</td></tr>';
		if ($tema_id) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['tema']), ucfirst($config['genero_tema']).' '.$config['tema'].' ao qual atende.').ucfirst($config['tema']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_tema($tema_id).'</td></tr>';
		echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['objetivo']), ucfirst($config['genero_objetivo']).' '.$config['objetivo'].' ao qual atende, por meio do fator cr�tico ao sucesso.').''.ucfirst($config['objetivo']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_objetivo($obj->plano_acao_objetivo).'</td></tr>';
		}
	
	
	elseif ($obj->plano_acao_tema) {
		$sql->adTabela('tema');
		$sql->adCampo('tema_perspectiva');
		$sql->adOnde('tema_id ='.(int)$obj->plano_acao_tema);
		$perspectiva_id = $sql->resultado();
		$sql->limpar();
		if ($perspectiva_id) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['perspectiva']), 'A perspectiva estrat�gica � qual atende.').ucfirst($config['perspectiva']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_perspectiva($perspectiva_id).'</td></tr>';
		echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['tema']), ucfirst($config['genero_tema']).' '.$config['tema'].' ao qual atende.').ucfirst($config['tema']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_tema($obj->plano_acao_tema).'</td></tr>';
		}
	
	elseif ($obj->plano_acao_perspectiva) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['perspectiva']), 'A perspectiva estrat�gica � qual atende.').ucfirst($config['perspectiva']).':'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.link_perspectiva($obj->plano_acao_perspectiva).'</td></tr>';
		
	$objetivo_estrategico_id=0;
	$fator_critico_id=0;
	}
	
	


echo '<tr><td align="right" nowrap="nowrap">'.dica('Data de In�cio', 'Data de in�cio d'.$config['genero_acao'].' '.$config['acao'].'.').'Data de in�cio:'.dicaF().'</td><td class="realce" width="300">'.retorna_data($obj->plano_acao_inicio).'</td></tr>';
echo '<tr><td align="right" nowrap="nowrap">'.dica('Data de t�rmino', 'Data estimada de t�rmino d'.$config['genero_acao'].' '.$config['acao'].'.').'Data de t�rmino:'.dicaF().'</td><td class="realce" width="300">'.retorna_data($obj->plano_acao_fim).'</td></tr>';
if ($obj->plano_acao_duracao) echo '<tr><td align="right" nowrap="nowrap">'.dica('Dura��o', 'A dura��o d'.$config['genero_acao'].' '.$config['acao'].' em dias.').'Dura��o:'.dicaF().'</td><td width="100%" class="realce">'.number_format(($obj->plano_acao_duracao/($config['horas_trab_diario'] ? $config['horas_trab_diario'] : 8)), 2, ',', '.').'</td></tr>';



echo '<tr><td align="right" nowrap="nowrap">'.dica('Progresso', $config['acao'].' pode ir de 0% (n�o iniciado) at� 100% (completado).').'Progresso:'.dicaF().'</td><td class="realce" width="300">'.number_format($obj->plano_acao_percentagem, 2, ',', '.').'%'.($obj->plano_acao_calculo_porcentagem ? ' (calculado)' : '').'</td></tr>';
if ($obj->plano_acao_principal_indicador) echo '<tr><td align="right" nowrap="nowrap">'.dica('Indicador Principal', 'Dentre os indicadores d'.$config['genero_acao'].' '.$config['acao'].' mais representativo da situa��o geral do mesmo.').'Indicador principal:'.dicaF().'</td><td width="100%" class="realce">'.link_indicador($obj->plano_acao_principal_indicador).'</td></tr>';
if ($obj->plano_acao_ano) echo '<tr><td align="right" nowrap="nowrap">'.dica('Ano', 'O ano  base d'.$config['genero_acao'].' '.$config['acao'].'.').'Ano:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->plano_acao_ano.'</td></tr>';
if ($obj->plano_acao_codigo) echo '<tr><td align="right" nowrap="nowrap">'.dica('C�digo', 'O  c�digo d'.$config['genero_acao'].' '.$config['acao'].'.').'C�digo:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->plano_acao_codigo.'</td></tr>';
echo '<tr><td align="right" nowrap="nowrap">'.dica('N�vel de Acesso', 'O link pode ter cinco n�veis de acesso:<ul><li><b>P�blico</b> - Todos podem ver e editar.</li><li><b>Protegido</b> - Todos podem ver, porem apenas o respons�vel e os designado podem editar.</li><li><b>Protegido II</b> - Todos podem ver, porem apenas o respons�vel pode editar.</li><li><b>Participante</b> - Somente o respons�vel os designados podem ver e editar</li><li><b>Privado</b> - Somente o respons�vel os designados podem ver, e o respons�vel editar.</li></ul>').'N�vel de acesso:'.dicaF().'</td><td width="100%" class="realce">'.$plano_acao_acesso[$obj->plano_acao_acesso].'</td></tr>';
	


if ($obj->plano_acao_indicador) echo '<tr><td align="right" nowrap="nowrap">'.dica('Indicador', 'Para qual indicador foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').'Indicador:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_indicador($obj->plano_acao_indicador).'</td></tr>';
elseif ($obj->plano_acao_objetivo) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['objetivo']), 'Para qual '.$config['genero_objetivo'].' foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').''.ucfirst($config['objetivo']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_objetivo($obj->plano_acao_objetivo).'</td></tr>';
elseif ($obj->plano_acao_estrategia) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['iniciativa']), 'Para qual '.$config['iniciativa'].' foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').'Iniciativa:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_estrategia($obj->plano_acao_estrategia).'</td></tr>';
elseif ($obj->plano_acao_pratica) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['pratica']), 'Para qual '.$config['pratica'].' foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').ucfirst($config['pratica']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_pratica($obj->plano_acao_pratica).'</td></tr>';
elseif ($obj->plano_acao_tarefa) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['tarefa']), 'Para qual '.$config['tarefa'].' foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').'Tarefa:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_tarefa($obj->plano_acao_tarefa).'</td></tr>';
elseif ($obj->plano_acao_projeto) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['projeto']), 'Para qual '.$config['projeto'].' foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').ucfirst($config['projeto']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_projeto($obj->plano_acao_projeto).'</td></tr>';
elseif ($obj->plano_acao_tema) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['tema']), 'Para qual '.$config['tema'].' foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').ucfirst($config['tema']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_tema($obj->plano_acao_tema).'</td></tr>';
elseif ($obj->plano_acao_fator) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['fator']), 'Para qual '.$config['fator'].' foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').'Fator cr�tico de sucesso:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_fator($obj->plano_acao_fator).'</td></tr>';
elseif ($obj->plano_acao_meta) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['meta']), 'Para qual '.$config['meta'].' foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').ucfirst($config['meta']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_meta($obj->plano_acao_meta).'</td></tr>';
elseif ($obj->plano_acao_perspectiva) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['perspectiva']), 'Para qual '.$config['perspectiva'].' foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').ucfirst($config['perspectiva']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_perspectiva($obj->plano_acao_perspectiva).'</td></tr>';
elseif ($obj->plano_acao_canvas) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['canvas']), 'Para qual '.$config['canvas'].' foi vinculad'.$config['genero_acao'].' '.($config['genero_acao']=='a' ? 'esta' : ' este').' '.$config['acao'].'.').ucfirst($config['canvas']).':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.link_canvas($obj->plano_acao_canvas).'</td></tr>';
	
if ($Aplic->profissional) echo '<tr><td align="right" nowrap="nowrap">'.dica('Moeda', 'A moeda padr�o utilizada n'.$config['genero_acao'].' '.$config['acao'].'.').'Moeda:'.dicaF().'</td><td class="realce" width="100%">'.$moedas[$obj->plano_acao_moeda].'</td></tr>';	
if ($Aplic->profissional && $tem_aprovacao) echo '<tr><td align="right" nowrap="nowrap">'.dica('Aprovado', 'Se '.$config['genero_acao'].' '.$config['acao'].' se encontra aprovad'.$config['genero_acao'].'.').'Aprovad'.$config['genero_acao'].':'.dicaF().'</td><td  class="realce" width="100%">'.($obj->plano_acao_aprovado ? 'Sim' : '<span style="color:red; font-weight:bold">N�o</span>').'</td></tr>';

echo '<tr><td align="right" nowrap="nowrap">'.dica('Ativ'.$config['genero_acao'], ucfirst($config['genero_acao']).' '.$config['acao'].' se encontra ativ'.$config['genero_acao'].'.').'Ativ'.$config['genero_acao'].':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.($obj->plano_acao_ativo ? 'Sim' : 'N�o').'</td></tr>';
	
	
if ($Aplic->profissional) include_once BASE_DIR.'/modulos/praticas/plano_acao_ver_pro.php';	


	
$sql->adTabela('plano_acao_item');
$sql->adCampo('plano_acao_item.*');
$sql->adCampo('(CASE
			WHEN plano_acao_item_percentagem=100 THEN "#aaddaa"
			WHEN plano_acao_item_inicio > NOW() OR plano_acao_item_inicio IS NULL OR plano_acao_item_fim IS NULL THEN "#ffffff"
			WHEN plano_acao_item_fim < NOW() AND plano_acao_item_percentagem<100 THEN "#cc6666"
			WHEN plano_acao_item_fim > NOW() AND plano_acao_item_inicio< NOW() AND plano_acao_item_percentagem > 0 THEN "#e6eedd"
			WHEN 1>0 THEN "#ffeebb"
			END) AS acao_situacao');
$sql->adOnde('plano_acao_item_acao = '.(int)$plano_acao_id);
$sql->adOrdem('plano_acao_item_ordem ASC');
$plano_acao_item = $sql->Lista();
$sql->limpar();	
	
$qnt_com_tempo=0;	
if (count($plano_acao_item)){
	echo '<tr><td colspan=20><table cellpadding=0 cellspacing=0 class="tbl1" align=center width=100%>';
	echo '<tr>';
	echo '<th>'.dica('N�mero','O n�mero da a��o.').'Nr'.dicaF().'</th>';
	echo '<th>'.dica('O Que','O que ser� feito.').'O Que'.dicaF().'</th>';
	echo '<th>'.dica('Por que','Por que ser� feito.').'Por que'.dicaF().'</th>';
	echo '<th>'.dica('Onde','Onde ser� feito.').'Onde'.dicaF().'</th>';
	echo '<th>'.dica('Quando','Quando ser� feito.').'Quando'.dicaF().'</th>';
	echo '<th>'.dica('Quem','Por quem ser� feito.').'Quem'.dicaF().'</th>';
	echo '<th>'.dica('Como','Como ser� feito.').'Como'.dicaF().'</th>';
	echo '<th>'.dica('Quanto','Quanto custar� fazer').'Quanto'.dicaF().'</th>';
	echo ($Aplic->profissional && $exibir['porcentagem_item'] ? '<th>'.dica('Peso','Peso do item executada para o c�lculo da percentagem geral.').'Peso'.dicaF().'</th><th>'.dica('Percentagem','Percentagem executada do item.').'%'.dicaF().'</th>' : '');
	echo '</tr>';
	$qnt_acao=0;
	
	foreach($plano_acao_item as $linha_plano_acao_item) {
		$qnt_acao++;
		if ($linha_plano_acao_item['plano_acao_item_inicio'] && $linha_plano_acao_item['plano_acao_item_fim']) $qnt_com_tempo++;
		echo '<tr>';
		echo '<td style="margin-bottom:0cm; margin-top:0cm; width:10px;">'.($qnt_acao < 100 ? '0' : '').($qnt_acao < 10 ? '0' : '').$qnt_acao.'</td>';
		echo '<td style="margin-bottom:0cm; margin-top:0cm;">'.($linha_plano_acao_item['plano_acao_item_oque'] ? $linha_plano_acao_item['plano_acao_item_oque'] : '&nbsp;').'</td>';
		echo '<td style="margin-bottom:0cm; margin-top:0cm;">'.($linha_plano_acao_item['plano_acao_item_porque'] ? $linha_plano_acao_item['plano_acao_item_porque'] : '&nbsp;').'</td>';
		echo '<td style="margin-bottom:0cm; margin-top:0cm;">'.($linha_plano_acao_item['plano_acao_item_onde'] ? $linha_plano_acao_item['plano_acao_item_onde'] : '&nbsp;').'</td>';
		echo '<td style="margin-bottom:0cm; margin-top:0cm;'.($Aplic->profissional && ($linha_plano_acao_item['plano_acao_item_inicio'] && $linha_plano_acao_item['plano_acao_item_fim']) ? ' background: '.$linha_plano_acao_item['acao_situacao'].';' : '').'">'.$linha_plano_acao_item['plano_acao_item_quando'];
		if ($linha_plano_acao_item['plano_acao_item_quando'] && ($linha_plano_acao_item['plano_acao_item_inicio'] || $linha_plano_acao_item['plano_acao_item_fim'])) echo '<br>';
		if ($linha_plano_acao_item['plano_acao_item_inicio']) echo retorna_data($linha_plano_acao_item['plano_acao_item_inicio'], false);
		if ($linha_plano_acao_item['plano_acao_item_inicio'] && $linha_plano_acao_item['plano_acao_item_fim']) echo ' - ';
		if ($linha_plano_acao_item['plano_acao_item_fim']) echo retorna_data($linha_plano_acao_item['plano_acao_item_fim'], false);
		if (!$linha_plano_acao_item['plano_acao_item_quando'] && !$linha_plano_acao_item['plano_acao_item_inicio'] && !$linha_plano_acao_item['plano_acao_item_fim']) echo '&nbsp;';	
		echo '</td>';
	
	echo '<td style="margin-bottom:0cm; margin-top:0cm;">'.$linha_plano_acao_item['plano_acao_item_quem'];
	
	$sql->adTabela('plano_acao_item_designados');
	$sql->adCampo('usuario_id');
	$sql->adOnde('plano_acao_item_id ='.(int)$linha_plano_acao_item['plano_acao_item_id']);
	$participantes = $sql->carregarColuna();
	$sql->limpar();

	$saida_quem='';
	if ($participantes && count($participantes)) {
		$saida_quem.= link_usuario($participantes[0], '','','esquerda');
		$qnt_participantes=count($participantes);
		if ($qnt_participantes > 1) {		
			$lista='';
			for ($i = 1, $i_cmp = $qnt_participantes; $i < $i_cmp; $i++) $lista.=link_usuario($participantes[$i], '','','esquerda').'<br>';		
			$saida_quem.= dica('Outros Participantes', 'Clique para visualizar os demais participantes.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'participantes_'.$linha_plano_acao_item['plano_acao_item_id'].'\');">(+'.($qnt_participantes - 1).')</a>'.dicaF(). '<span style="display: none" id="participantes_'.$linha_plano_acao_item['plano_acao_item_id'].'"><br>'.$lista.'</span>';
			}
		} 	
	$sql->adTabela('plano_acao_item_depts');
	$sql->adCampo('dept_id');
	$sql->adOnde('plano_acao_item_id ='.(int)$linha_plano_acao_item['plano_acao_item_id']);
	$depts = $sql->carregarColuna();
	$sql->limpar();

	$saida_dept='';
	if ($depts && count($depts)) {
		$saida_dept.= link_secao($depts[0]);
		$qnt_depts=count($depts);
		if ($qnt_depts > 1) {		
			$lista='';
			for ($i = 1, $i_cmp = $qnt_depts; $i < $i_cmp; $i++) $lista.=link_secao($depts[$i]).'<br>';		
			$saida_dept.= dica('Outr'.$config['genero_dept'].'s '.ucfirst($config['departamentos']), 'Clique para visualizar '.$config['genero_dept'].'s demais '.$config['departamentos'].'.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'depts_'.$linha_plano_acao_item['plano_acao_item_id'].'\');">(+'.($qnt_depts - 1).')</a><span style="display: none" id="depts_'.$linha_plano_acao_item['plano_acao_item_id'].'"><br>'.$lista.'</span>';
			}
		} 		
	if ($saida_quem) echo ($linha_plano_acao_item['plano_acao_item_quem'] ? '<br>' : '').$saida_quem;
	if ($saida_dept) echo ($linha_plano_acao_item['plano_acao_item_quem'] || $saida_quem ? '<br>' : '').$saida_dept;
	if (!$saida_quem && !$linha_plano_acao_item['plano_acao_item_quem']&& !$saida_dept) echo '&nbsp;';

	
	echo '</td>';
	echo '<td style="margin-bottom:0cm; margin-top:0cm;">'.($linha_plano_acao_item['plano_acao_item_como'] ? $linha_plano_acao_item['plano_acao_item_como'] : '&nbsp;').'</td>';
	echo '<td style="margin-bottom:0cm; margin-top:0cm;">'.$linha_plano_acao_item['plano_acao_item_quanto'];
	$sql->adTabela('plano_acao_item_custos');
	$sql->adCampo('SUM(((plano_acao_item_custos_quantidade*plano_acao_item_custos_custo*plano_acao_item_custos_cotacao)*((100+plano_acao_item_custos_bdi)/100))) as total');
	$sql->adOnde('plano_acao_item_custos_plano_acao_item ='.(int)$linha_plano_acao_item['plano_acao_item_id']);
	$custo = $sql->Resultado();
	$sql->limpar();
	if ($custo) echo ($linha_plano_acao_item['plano_acao_item_quanto']? '<br>' : '').$moedas[$obj->plano_acao_moeda].' '.number_format(($obj->plano_acao_moeda!=1 ? $custo/cotacao($obj->plano_acao_moeda, date('Y-m-d')) : $custo), 2, ',', '.').'<a href="javascript: void(0);" onclick="javascript:'.($Aplic->profissional ? 'parent.gpwebApp.popUp(\'Planilha de Custos\', 1000, 600, \'m=praticas&a=estimado&dialogo=1&id='.(int)$linha_plano_acao_item['plano_acao_item_id'].'\', null, window);' : 'window.open(\'./index.php?m=praticas&a=estimado&dialogo=1&id='.(int)$linha_plano_acao_item['plano_acao_item_id'].'\', \'Planilha de Custos\',\'height=500,width=1024,resizable,scrollbars=yes\')').'">'.dica('Planilha de Custos', 'Clique neste �cone '.imagem('icones/planilha_estimado.gif').' para visualizar a planilha de custos estimados.').imagem('icones/planilha_estimado.gif').dicaF().'</a>';
	$sql->adTabela('plano_acao_item_gastos');
	$sql->adCampo('SUM(((plano_acao_item_gastos_quantidade*plano_acao_item_gastos_custo)*((100+plano_acao_item_gastos_bdi)/100))) as total');
	$sql->adOnde('plano_acao_item_gastos_plano_acao_item ='.(int)$linha_plano_acao_item['plano_acao_item_id']);
	$gasto = $sql->Resultado();
	$sql->limpar();
	if ($gasto) echo ($linha_plano_acao_item['plano_acao_item_quanto'] || $custo ? '<br>' : '').$config['simbolo_moeda'].' '.number_format($gasto, 2, ',', '.').'<a href="javascript: void(0);" onclick="javascript:'.($Aplic->profissional ? 'parent.gpwebApp.popUp(\'Planilha de Gastos\', 1000, 600, \'m=praticas&a=gasto&dialogo=1&id='.(int)$linha_plano_acao_item['plano_acao_item_id'].'\', null, window);' : 'window.open(\'./index.php?m=praticas&a=gasto&dialogo=1&id='.(int)$linha_plano_acao_item['plano_acao_item_id'].'\', \'Planilha\',\'height=500,width=1024,resizable,scrollbars=yes\')').'">'.dica('Planilha de Gastos', 'Clique neste �cone '.imagem('icones/planilha_gasto.gif').' para visualizar a planilha de gastos.').imagem('icones/planilha_gasto.gif').dicaF().'</a>';
	if (!$linha_plano_acao_item['plano_acao_item_quanto']) echo '&nbsp;';
	echo '</td>';
	
	if ($Aplic->profissional && $exibir['porcentagem_item']){
			echo '<td style="margin-bottom:0cm; margin-top:0cm; text-align: right; vertical-align:text-top;">'.($linha_plano_acao_item['plano_acao_item_peso'] ? number_format($linha_plano_acao_item['plano_acao_item_peso'], 2, ',', '.') : '&nbsp;').'</td>';
			echo '<td style="margin-bottom:0cm; margin-top:0cm; text-align: right; vertical-align:text-top;">'.(int)$linha_plano_acao_item['plano_acao_item_percentagem'].'</td>';
			}
	
	echo '</tr>';
	}
	

	echo '</table></td></tr>';
	if ($Aplic->profissional && $qnt_com_tempo){
		echo '<tr><td colspan="20"><table border=0 cellpadding=0 cellspacing=0 '.($dialogo ? '' : 'class="std2"').' width="100%"><tr>';
		echo '<td nowrap="nowrap" style="border-style:solid;border-width:1px; background: #ffffff;">&nbsp; &nbsp;</td><td nowrap="nowrap">'.dica('Prevista', 'Prevista � quando a data de �nicio da a��o ainda n�o passou.').'&nbsp;Para o futuro'.dicaF().'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		echo '<td nowrap="nowrap" style="border-style:solid;border-width:1px; background: #e6eedd;">&nbsp; &nbsp;</td><td nowrap="nowrap">'.dica('Iniciada e Dentro do Prazo', 'A��o iniciada e dentro do prazo � quando a data de �nicio da mesma j� ocorreu, e a mesma j� est� acima de 0% executada, entretanto ainda n�o se chegou na data de t�rmino.').'&nbsp;Iniciada e dentro do prazo'.dicaF().'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		echo '<td nowrap="nowrap" style="border-style:solid;border-width:1px; background: #ffeebb;">&nbsp; &nbsp;</td><td nowrap="nowrap">'.dica('Deveria ter Iniciada', 'A��o deveria ter iniciada � quando a data de �nicio da mesma j� ocorreu, entretanto ainda se encontra em 0% executada.').'&nbsp;Deveria ter iniciada'.dicaF().'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		echo '<td nowrap="nowrap" style="border-style:solid;border-width:1px; background: #cc6666;">&nbsp; &nbsp;</td><td nowrap="nowrap">'.dica('Em Atraso', 'A��o em atraso � quando a data de t�rmino da mesma j� ocorreu, entretanto ainda n�o se encontra em 100% executada.').'&nbsp;Em atraso'.dicaF().'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		echo '<td nowrap="nowrap" style="border-style:solid;border-width:1px; background: #aaddaa;">&nbsp; &nbsp;</td><td nowrap="nowrap">'.dica('Terminada', 'A��o terminada � quando est� 100% executada.').'&nbsp;Terminada'.dicaF().'</td>';
		echo '<td width="100%">&nbsp;</td>';
		echo '</tr></table>';
		echo '</td></tr>';
		}
	}



	
echo '</table></td></tr></table>';




if (!$dialogo) echo estiloFundoCaixa();
else if ($dialogo && !($Aplic->usuario_nomeguerra=='Visitante' && $Aplic->usuario_id=1)) echo '<script language=Javascript>self.print();</script>';
if (!$dialogo){
	$caixaTab = new CTabBox('m=praticas&a=plano_acao_ver&plano_acao_id='.(int)$plano_acao_id, '', $tab);
	$texto_consulta = '?m=praticas&a=plano_acao_ver&plano_acao_id='.(int)$plano_acao_id;
	
	
	if ($Aplic->profissional){
		$qnt_aba=0;
		if ($Aplic->profissional) {
			$sql->adTabela('log');
			$sql->adCampo('count(log_id)');
			$sql->adOnde('log_acao = '.(int)$plano_acao_id);
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/log_ver_pro', 'Registros',null,null,'Registros das Ocorr�ncias','Visualizar os registros das ocorr�ncias.');
				}
			}
	
		if ($Aplic->modulo_ativo('calendario') && $Aplic->checarModulo('calendario', 'acesso')) {
			if ($Aplic->profissional) {
				$sql->adTabela('evento_gestao','evento_gestao');
				$sql->adOnde('evento_gestao_acao = '.(int)$plano_acao_id);
				$sql->adCampo('count(evento_gestao_acao)');
				$existe=$sql->resultado();
				$sql->limpar();
				}
			else $existe=true;	
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/ver_eventos', 'Eventos',null,null,'Eventos','Visualizar os eventos relacionados.');
				}
			}
			
		if ($Aplic->modulo_ativo('arquivos') && $Aplic->checarModulo('arquivos', 'acesso')) {
			if ($Aplic->profissional) {
				$sql->adTabela('arquivo_gestao','arquivo_gestao');
				$sql->adOnde('arquivo_gestao_acao = '.(int)$plano_acao_id);
				$sql->adCampo('count(arquivo_gestao_acao)');
				$existe=$sql->resultado();
				$sql->limpar();
				}
			else $existe=true;	
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/ver_arquivos', 'Arquivos',null,null,'Arquivos','Visualizar os arquivos relacionados.');
				}
			}
		
		if ($Aplic->modulo_ativo('links') && $Aplic->checarModulo('links', 'acesso')) {
			if ($Aplic->profissional) {
				$sql->adTabela('link_gestao','link_gestao');
				$sql->adOnde('link_gestao_acao = '.(int)$plano_acao_id);
				$sql->adCampo('count(link_gestao_acao)');
				$existe=$sql->resultado();
				$sql->limpar();
				}
			else $existe=true;	
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/links/index_tabela', 'Links',null,null,'Links','Visualizar os links relacionados.');
				}
			}
		
		if ($Aplic->modulo_ativo('foruns') && $Aplic->checarModulo('foruns', 'acesso')) {
			if ($Aplic->profissional) {
				$sql->adTabela('forum_gestao','forum_gestao');
				$sql->adOnde('forum_gestao_acao = '.(int)$plano_acao_id);
				$sql->adCampo('count(forum_gestao_acao)');
				$existe=$sql->resultado();
				$sql->limpar();
				}
			else $existe=true;	
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/foruns/forum_tabela', 'F�runs',null,null,'F�runs','Visualizar os f�runs relacionados.');
				}
			}
			
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'indicador')) {
			if ($Aplic->profissional) {
				$sql->adTabela('pratica_indicador_gestao','pratica_indicador_gestao');
				$sql->adOnde('pratica_indicador_gestao_acao = '.(int)$plano_acao_id);
				$sql->adCampo('count(pratica_indicador_gestao_acao)');
				$existe=$sql->resultado();
				$sql->limpar();
				}
			else $existe=true;	
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/indicadores_ver', 'Indicadores',null,null,'Indicadores','Visualizar os indicadores relacionados.');
				}
			}
			
			
		if ($Aplic->modulo_ativo('projetos') && $Aplic->checarModulo('projetos', 'acesso')) {
			if ($Aplic->profissional) {
				$sql->adTabela('projeto_gestao');
				$sql->adOnde('projeto_gestao_acao = '.(int)$plano_acao_id);
				$sql->adCampo('count(projeto_gestao_id)');
				$existe=$sql->resultado();
				$sql->limpar();
				}
			else $existe=true;	
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/projetos/ver_idx_projetos', ucfirst($config['projetos']),null,null,ucfirst($config['projetos']),'Visualizar '.$config['genero_projeto'].'s '.$config['projetos'].' relacionad'.$config['genero_projeto'].'s.');
				}
			}	
			
		if ($Aplic->profissional && $Aplic->modulo_ativo('email') && $Aplic->checarModulo('email', 'acesso')) {
			$sql->adTabela('msg_gestao','msg_gestao');
			$sql->adOnde('msg_gestao_acao = '.(int)$plano_acao_id);
			$sql->adCampo('count(msg_gestao_acao)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) $caixaTab->adicionar(BASE_DIR.'/modulos/email/ver_msg_pro', ucfirst($config['mensagens']),null,null,ucfirst($config['mensagens']),ucfirst($config['genero_mensagem']).'s '.$config['mensagens'].' relacionad'.$config['genero_mensagem'].'s.');
			if ($config['doc_interno']) {
				$sql->adTabela('modelo_gestao','modelo_gestao');
				$sql->adOnde('modelo_gestao_acao = '.(int)$plano_acao_id);
				$sql->adCampo('count(modelo_gestao_acao)');
				$existe=$sql->resultado();
				$sql->limpar();
				if ($existe) {
					$qnt_aba++;
					$caixaTab->adicionar(BASE_DIR.'/modulos/email/ver_modelo_pro', 'Documentos',null,null,'Documentos','Os documentos relacionados.');
					}
				}
			}
		
		if ($Aplic->profissional && $Aplic->modulo_ativo('atas') && $Aplic->checarModulo('atas', 'acesso')) {
			$sql->adTabela('ata_gestao','ata_gestao');
			$sql->adOnde('ata_gestao_acao = '.(int)$plano_acao_id);
			$sql->adCampo('count(ata_gestao_acao)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/atas/ata_tabela', 'Atas',null,null,'Atas','Visualizar as atas de reuni�o relacionadas.');
				}
			}
			
		if ($Aplic->profissional && $Aplic->modulo_ativo('problema') && $Aplic->checarModulo('problema', 'acesso')) {
			$sql->adTabela('problema_gestao','problema_gestao');
			$sql->adOnde('problema_gestao_acao = '.(int)$plano_acao_id);
			$sql->adCampo('count(problema_gestao_acao)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/problema/problema_tabela', ucfirst($config['problemas']),null,null,ucfirst($config['problemas']),'Visualizar '.$config['genero_problema'].'s '.$config['problemas'].' relacionad'.$config['genero_problema'].'s.');
				}
			}
			
		if ($Aplic->profissional && $Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'risco')) {
			$sql->adTabela('risco_gestao','risco_gestao');
			$sql->adOnde('risco_gestao_acao = '.(int)$plano_acao_id);
			$sql->adCampo('count(risco_gestao_acao)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/risco_pro_ver_idx', ucfirst($config['riscos']),null,null,ucfirst($config['riscos']),'Visualizar '.$config['genero_risco'].'s '.$config['riscos'].' relacionad'.$config['genero_risco'].'s.');
				}	
			$sql->adTabela('risco_resposta_gestao', 'risco_resposta_gestao');
			$sql->esqUnir('risco_gestao','risco_gestao', 'risco_resposta_gestao_risco=risco_gestao_risco');
			$sql->adOnde('risco_resposta_gestao_acao = '.(int)$plano_acao_id.' OR risco_gestao_acao = '.(int)$plano_acao_id);
			$sql->adCampo('count(risco_resposta_gestao_id)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/risco_resposta_pro_ver_idx', ucfirst($config['risco_respostas']),null,null,ucfirst($config['risco_respostas']),'Visualizar '.$config['genero_risco_resposta'].'s '.$config['risco_respostas'].' relacionad'.$config['genero_risco_resposta'].'s.');
				}
			}
	
		if ($Aplic->profissional && $Aplic->modulo_ativo('instrumento')  && $Aplic->checarModulo('instrumento', 'acesso')) {
			$sql->adTabela('instrumento_gestao','instrumento_gestao');
			$sql->adOnde('instrumento_gestao_acao = '.(int)$plano_acao_id);
			$sql->adCampo('count(instrumento_gestao_acao)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/instrumento/instrumento_lista_idx', ucfirst($config['instrumentos']),null,null,ucfirst($config['instrumentos']),'Visualizar '.$config['genero_instrumento'].'s '.$config['instrumentos'].' relacionad'.$config['genero_instrumento'].'s.');
				}
			}
		
		
		if ($qnt_aba) {
			$caixaTab->mostrar('','','','',true);
			echo estiloFundoCaixa('','', $tab);
			}
	
		}
	else {
		if ($Aplic->profissional) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/log_ver_pro', 'Registros',null,null,'Registros','Visualizar os registros das ocorr�ncias.');
		else {
			$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/plano_acao_log_ver', 'Registros',null,null,'Registros','Visualizar os registros das ocorr�ncias.<br><br>O registro � a forma padr�o dos designados das a��es informarem sobre o andamento e avisarem sobre problemas.');
			if ($editar) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/plano_acao_log_editar', 'Registrar',null,null,'Registrar','Inserir uma ocorr�ncia.');
			}
		if ($Aplic->modulo_ativo('calendario') && $Aplic->checarModulo('calendario', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/ver_eventos', 'Eventos',null,null,'Eventos','Visualizar os eventos relacionados.');
		if ($Aplic->modulo_ativo('arquivos') && $Aplic->checarModulo('arquivos', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/ver_arquivos', 'Arquivos',null,null,'Arquivos','Visualizar os arquivos relacionados.');
		if ($Aplic->modulo_ativo('links') && $Aplic->checarModulo('links', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/links/index_tabela', 'Links',null,null,'Links','Visualizar os links relacionados.');
		if ($Aplic->modulo_ativo('foruns') && $Aplic->checarModulo('foruns', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/foruns/forum_tabela', 'F�runs',null,null,'F�runs','Visualizar os f�runs relacionados.');
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'indicador')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/indicadores_ver', 'Indicadores',null,null,'Indicadores','Visualizar os indicadores relacionados.');
		if ($Aplic->modulo_ativo('projetos') && $Aplic->checarModulo('projetos', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/projetos/ver_projetos', ucfirst($config['projetos']),null,null,ucfirst($config['projetos']),'Visualizar '.$config['genero_projeto'].'s '.$config['projetos'].' relacionad'.$config['genero_projeto'].'s.');
		if ($Aplic->profissional && $Aplic->modulo_ativo('email') && $Aplic->checarModulo('email', 'acesso')) {
			$caixaTab->adicionar(BASE_DIR.'/modulos/email/ver_msg_pro', ucfirst($config['mensagens']),null,null,ucfirst($config['mensagens']),ucfirst($config['genero_mensagem']).'s '.$config['mensagens'].' relacionad'.$config['genero_mensagem'].'s.');
			if ($config['doc_interno']) $caixaTab->adicionar(BASE_DIR.'/modulos/email/ver_modelo_pro', 'Documentos',null,null,'Documentos','Os documentos relacionados.');
			}
		if ($Aplic->profissional && $Aplic->modulo_ativo('atas') && $Aplic->checarModulo('atas', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/atas/ata_tabela', 'Atas',null,null,'Atas','Visualizar as atas de reuni�o relacionadas.');
		if ($Aplic->profissional && $Aplic->modulo_ativo('problema') && $Aplic->checarModulo('problema', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/problema/problema_tabela', ucfirst($config['problemas']),null,null,ucfirst($config['problemas']),'Visualizar '.$config['genero_problema'].'s '.$config['problemas'].' relacionad'.$config['genero_problema'].'s.');
		if ($Aplic->profissional && $Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'risco')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/risco_pro_ver_idx', ucfirst($config['riscos']),null,null,ucfirst($config['riscos']),'Visualizar '.$config['genero_risco'].'s '.$config['riscos'].' relacionad'.$config['genero_risco'].'s.');
		$caixaTab->mostrar('','','','',true);
		echo estiloFundoCaixa();
		}
	}	
else {
	if ($Aplic->profissional && $barra['rodape']) echo $barra['imagem'];
	echo '<script>self.print();</script>';
	}	
?>
<script type="text/javascript">

function exportar_link() {
	parent.gpwebApp.popUp('Link', 900, 100, 'm=publico&a=exportar_link&dialogo=1&tipo=generico', null, window);
	}	

function excluir() {
	if (confirm('Tem certeza que deseja excluir este <?php echo $config["acao"] ?>?')) {
		var f = document.env;
		f.del.value=1;
		f.a.value='plano_acao_fazer_sql';
		f.submit();
		}
	}

function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}
</script>