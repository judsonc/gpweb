<?php 
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');

$pg_estrategia_id = intval(getParam($_REQUEST, 'pg_estrategia_id', 0));

$sql = new BDConsulta;

require_once (BASE_DIR.'/modulos/praticas/estrategia.class.php');
$obj= new CEstrategia();
$obj->load($pg_estrategia_id);


if (!permiteAcessarEstrategia($obj->pg_estrategia_acesso,$pg_estrategia_id)) $Aplic->redirecionar('m=publico&a=acesso_negado');

$sql->adTabela('campo_formulario');
$sql->adCampo('campo_formulario_campo, campo_formulario_ativo');
$sql->adOnde('campo_formulario_tipo = \'estrategia\'');
$sql->adOnde('campo_formulario_usuario IS NULL OR campo_formulario_usuario=0');
$exibir = $sql->listaVetorChave('campo_formulario_campo','campo_formulario_ativo');
$sql->limpar();

if ($Aplic->profissional){
	$sql->adTabela('assinatura');
	$sql->adCampo('assinatura_id, assinatura_data, assinatura_aprova');
	$sql->adOnde('assinatura_usuario='.(int)$Aplic->usuario_id);
	$sql->adOnde('assinatura_estrategia='.(int)$pg_estrategia_id);
	$assinar = $sql->linha();
	$sql->limpar();
	
	//tem assinatura que aprova
	$sql->adTabela('assinatura');
	$sql->adCampo('count(assinatura_id)');
	$sql->adOnde('assinatura_aprova=1');
	$sql->adOnde('assinatura_estrategia='.(int)$pg_estrategia_id);
	$tem_aprovacao = $sql->resultado();
	$sql->limpar();
	}

if (isset($_REQUEST['tab'])) $Aplic->setEstado('EstrategiaVerTab', getParam($_REQUEST, 'tab', null));
$tab = $Aplic->getEstado('EstrategiaVerTab') !== null ? $Aplic->getEstado('EstrategiaVerTab') : 0;
$msg = '';

$editar=($podeEditar&& permiteEditarEstrategia($obj->pg_estrategia_acesso,$pg_estrategia_id));

if (!$dialogo && !$Aplic->profissional){
	$Aplic->salvarPosicao();
	$botoesTitulo = new CBlocoTitulo('Detalhes d'.$config['genero_iniciativa'].' '.ucfirst($config['iniciativa']), 'estrategia.gif', $m, $m.'.'.$a);
	if ($Aplic->checarModulo('calendario', 'adicionar')) $botoesTitulo->adicionaCelula('<table cellpadding=1 cellspacing=0><tr><td nowrap="nowrap">'.dica('Novo Evento', 'Criar um novo evento.<br><br>Os eventos são atividades com data e hora específicas.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=calendario&a=editar&evento_estrategia='.$pg_estrategia_id.'\');" ><span>evento</span></a>'.dicaF().'</td></tr></table>');
	if ($Aplic->checarModulo('arquivos', 'adicionar')) $botoesTitulo->adicionaCelula('<table cellpadding=1 cellspacing=0><tr><td nowrap="nowrap">'.dica('Novo Arquivo', 'Inserir um novo arquivo relacionado com '.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=arquivos&a=editar&arquivo_estrategia='.$pg_estrategia_id.'\');" ><span>arquivo</span></a>'.dicaF().'</td></tr></table>');
	if ($Aplic->modulo_ativo('links') && $Aplic->checarModulo('links', 'adicionar')) $botoesTitulo->adicionaCelula('<table cellpadding=1 cellspacing=0><tr><td nowrap="nowrap">'.dica('Novo Link', 'Inserir um novo link relacionado com '.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=links&a=editar&link_estrategia='.$pg_estrategia_id.'\');" ><span>link</span></a>'.dicaF().'</td></tr></table>');

	if ($podeAdicionar)  {
		$botoesTitulo->adicionaCelula('<table cellpadding=1 cellspacing=0><tr><td nowrap="nowrap">'.dica('Novo Indicador', 'Criar um novo indicador.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=praticas&a=indicador_editar&pratica_indicador_estrategia='.$pg_estrategia_id.'\');" ><span>indicador</span></a>'.dicaF().'</td></tr></table>');
		$botoesTitulo->adicionaCelula('<table cellpadding=1 cellspacing=0><tr><td nowrap="nowrap">'.dica('Nov'.$config['genero_acao'].' '.ucfirst($config['acao']), 'Criar '.$config['acao'].' relacionad'.$config['genero_acao'].' com '.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=praticas&a=plano_acao_editar&plano_acao_estrategia='.$pg_estrategia_id.'\');" ><span>'.strtolower($config['acao']).'</span></a>'.dicaF().'</td></tr></table>');
		if(!$config['termo_abertura_obrigatorio'] && $Aplic->checarModulo('projetos', 'adicionar')) $botoesTitulo->adicionaCelula('<table cellpadding=1 cellspacing=0><tr><td nowrap="nowrap">'.dica('Nov'.$config['genero_projeto'].' '.ucfirst($config['projeto']), 'Criar nov'.$config['genero_projeto'].' '.$config['projeto'].' relacionad'.$config['genero_projeto'].' com '.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:url_passar(0, \'m=projetos&a=editar&projeto_estrategia='.$pg_estrategia_id.'\');" ><span>'.strtolower($config['projeto']).'</span></a>'.dicaF().'</td></tr></table>');
		}
	$botoesTitulo->adicionaBotao('m=praticas&a=estrategia_lista', 'lista','','Lista de '.$config['iniciativas'].'','Clique neste botão para visualizar a lista de '.$config['iniciativas'].'.');
	if ($editar) {
		$botoesTitulo->adicionaBotao('m=praticas&a=estrategia_editar&pg_estrategia_id='.$pg_estrategia_id, 'editar','','Editar','Editar os detalhes d'.$config['genero_iniciativa'].' '.$config['iniciativa'].'.');
		if ($podeExcluir) $botoesTitulo->adicionaBotaoExcluir('excluir', $podeExcluir, $msg,'Excluir','Excluir '.$config['genero_iniciativa'].' '.$config['iniciativa'].' do sistema.');
		}
	$botoesTitulo->adicionaCelula(dica('Imprimir '.$config['genero_objetivo'].' '.ucfirst($config['objetivo']).'', 'Clique neste ícone '.imagem('imprimir_p.png').' para imprimir '.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'<a href="javascript: void(0);" onclick ="url_passar(1, \'m='.$m.'&a='.$a.'&dialogo=1&pg_estrategia_id='.$pg_estrategia_id.'\');">'.imagem('imprimir_p.png').'</a>'.dicaF());
	$botoesTitulo->mostrar();

	echo estiloTopoCaixa();
	}

echo '<form name="env" method="post">';
echo '<input type="hidden" name="m" value="praticas" />';
echo '<input type="hidden" name="a" value="estrategia_ver" />';
echo '<input type="hidden" name="pg_estrategia_id" value="'.(int)$pg_estrategia_id.'" />';
echo '<input type="hidden" name="del" value="" />';
echo '<input type="hidden" name="modulo" value="" />';
echo '</form>';
	
if (!$dialogo && $Aplic->profissional){	
	$Aplic->salvarPosicao();
	$botoesTitulo = new CBlocoTitulo('Detalhes d'.$config['genero_iniciativa'].' '.ucfirst($config['iniciativa']), 'estrategia.gif', $m, $m.'.'.$a);
	$botoesTitulo->mostrar();
	echo estiloTopoCaixa();
	echo '<table align="center" cellspacing=0 cellpadding=0 width="100%">'; 
	echo '<tr><td colspan=2 style="background-color: #e6e6e6" width="100%">';
	require_once BASE_DIR.'/lib/coolcss/CoolControls/CoolMenu/coolmenu.php';
	$km = new CoolMenu("km");
	$km->scriptFolder ='lib/coolcss/CoolControls/CoolMenu';
	$km->styleFolder="default";
	$km->Add("root","ver",dica('Ver','Menu de opções de visualização').'Ver'.dicaF(), "javascript: void(0);");
	$km->Add("ver","ver_lista",dica('Lista de '.ucfirst($config['iniciativas']),'Clique neste botão para visualizar a lista de '.$config['iniciativas'].'.').'Lista de '.ucfirst($config['iniciativas']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=estrategia_lista\");");
	if ($editar){
		$km->Add("root","inserir",dica('Inserir','Menu de opções').'Inserir'.dicaF(), "javascript: void(0);'");
		$km->Add("inserir","inserir_tarefa",dica('Nov'.$config['genero_iniciativa'].' '.ucfirst($config['iniciativa']), 'Criar um nov'.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'Nov'.$config['genero_iniciativa'].' '.ucfirst($config['iniciativa']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=estrategia_editar\");");
		
		$km->Add("inserir","inserir_registro",dica('Registro de Ocorrência','Inserir um novo registro de ocorrência.').'Registro de Ocorrência'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=log_editar_pro&pg_estrategia_id=".$pg_estrategia_id."\");");
		if ($Aplic->modulo_ativo('calendario') && $Aplic->checarModulo('calendario', 'adicionar')) $km->Add("inserir","inserir_evento",dica('Novo Evento', 'Criar um novo evento relacionado.').'Evento'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=calendario&a=editar&evento_estrategia=".$pg_estrategia_id."\");");
		if ($Aplic->modulo_ativo('arquivos') && $Aplic->checarModulo('arquivos', 'adicionar')) $km->Add("inserir","inserir_arquivo",dica('Novo Arquivo', 'Inserir um novo arquivo relacionado.').'Arquivo'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=arquivos&a=editar&arquivo_estrategia=".$pg_estrategia_id."\");");
		if ($Aplic->modulo_ativo('links') && $Aplic->checarModulo('links', 'adicionar')) $km->Add("inserir","inserir_link",dica('Novo Link', 'Inserir um novo link relacionado.').'Link'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=links&a=editar&link_estrategia=".$pg_estrategia_id."\");");
		if ($Aplic->modulo_ativo('foruns') && $Aplic->checarModulo('foruns', 'adicionar')) $km->Add("inserir","inserir_forum",dica('Novo Fórum', 'Inserir um novo fórum relacionado.').'Fórum'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=foruns&a=editar&forum_estrategia=".$pg_estrategia_id."\");");
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'adicionar', null, 'indicador')) 	$km->Add("inserir","inserir_indicador",dica('Novo Indicador', 'Inserir um novo indicador relacionado.').'Indicador'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=indicador_editar&pratica_indicador_estrategia=".$pg_estrategia_id."\");");
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'adicionar', null, 'plano_acao')) $km->Add("inserir","inserir_acao",dica('Nov'.$config['genero_acao'].' '.ucfirst($config['acao']), 'Criar nov'.$config['genero_acao'].' '.$config['acao'].' relacionad'.$config['genero_acao'].'.').ucfirst($config['acao']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=plano_acao_editar&plano_acao_estrategia=".$pg_estrategia_id."\");");
		if ($Aplic->modulo_ativo('projetos') && $Aplic->checarModulo('projetos', 'adicionar')) $km->Add("inserir","inserir_projeto", dica('Nov'.$config['genero_projeto'].' '.ucfirst($config['projeto']), 'Inserir nov'.$config['genero_projeto'].' '.$config['projeto'].' relacionad'.$config['genero_projeto'].'.').ucfirst($config['projeto']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=projetos&a=editar&projeto_estrategia=".$pg_estrategia_id."\");");	
		if ($Aplic->modulo_ativo('email') && $Aplic->checarModulo('email', 'adicionar')) $km->Add("inserir","inserir_mensagem",dica('Nov'.$config['genero_mensagem'].' '.ucfirst($config['mensagem']), 'Inserir '.($config['genero_mensagem']=='a' ? 'uma' : 'um').' nov'.$config['genero_mensagem'].' '.$config['mensagem'].' relacionad'.$config['genero_mensagem'].'.').ucfirst($config['mensagem']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=email&a=nova_mensagem_pro&msg_estrategia=".$pg_estrategia_id."\");");
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
				foreach($modelos as $rs) $km->Add("criar_documentos","novodocumento",$rs['modelo_tipo_nome'].'&nbsp;&nbsp;&nbsp;&nbsp;',	"javascript: void(0);' onclick='url_passar(0, \"m=email&a=modelo_editar&editar=1&novo=1&modelo_id=0&modelo_tipo_id=".$rs['modelo_tipo_id']."&modelo_estrategia=".$pg_estrategia_id."\");", ($rs['imagem'] ? "estilo/rondon/imagens/icones/".$rs['imagem'] : ''));
				}
			}
		if ($Aplic->modulo_ativo('atas') && $Aplic->checarModulo('atas', 'adicionar')) $km->Add("inserir","inserir_ata",dica('Nova Ata de Reunião', 'Inserir uma nova ata de reunião relacionada.').'Ata de reunião'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=atas&a=ata_editar&ata_estrategia=".$pg_estrategia_id."\");");
		if ($Aplic->modulo_ativo('problema') && $Aplic->checarModulo('problema', 'adicionar')) $km->Add("inserir","inserir_problema",dica('Nov'.$config['genero_problema'].' '.ucfirst($config['problema']), 'Inserir um'.($config['genero_problema']=='a' ? 'a' : '').' nov'.$config['genero_problema'].' '.$config['problema'].' relacionad'.$config['genero_problema'].'.').ucfirst($config['problema']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=problema&a=problema_editar&problema_estrategia=".$pg_estrategia_id."\");");
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'adicionar', null, 'risco')) $km->Add("inserir","inserir_risco", dica('Nov'.$config['genero_risco'].' '.ucfirst($config['risco']), 'Inserir um'.($config['genero_risco']=='a' ? 'a' : '').' nov'.$config['genero_risco'].' '.$config['risco'].' relacionad'.$config['genero_risco'].'.').ucfirst($config['risco']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=risco_pro_editar&risco_estrategia=".$pg_estrategia_id."\");");

		}	
	$km->Add("root","acao",dica('Ação','Menu de ações.').'Ação'.dicaF(), "javascript: void(0);'");
	
	$bloquear=($obj->pg_estrategia_aprovado && $config['trava_aprovacao'] && $tem_aprovacao && !$Aplic->usuario_super_admin);
	if (isset($assinar['assinatura_id']) && $assinar['assinatura_id'] && !$bloquear) $km->Add("acao","acao_assinar", ($assinar['assinatura_data'] ? dica('Mudar Assinatura', 'Entrará na tela em que se pode mudar a assinatura.').'Mudar Assinatura'.dicaF() : dica('Assinar', 'Entrará na tela em que se pode assinar.').'Assinar'.dicaF()), "javascript: void(0);' onclick='url_passar(0, \"m=sistema&u=assinatura&a=assinatura_assinar&pg_estrategia_id=".$pg_estrategia_id."\");"); 
	
	
	
	if ($editar) $km->Add("acao","acao_editar",dica('Editar '.ucfirst($config['iniciativa']),'Editar os detalhes d'.($config['genero_iniciativa']=='a' ? 'esta' : 'este').' '.$config['iniciativa'].'.').'Editar '.ucfirst($config['iniciativa']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=estrategia_editar&pg_estrategia_id=".$pg_estrategia_id."\");");
	if ($podeExcluir &&$editar) $km->Add("acao","acao_excluir",dica('Excluir','Excluir '.($config['genero_iniciativa']=='a' ? 'esta' : 'este').' '.$config['iniciativa'].' do sistema.').'Excluir '.ucfirst($config['iniciativa']).dicaF(), "javascript: void(0);' onclick='excluir()");
	
	
	if ($obj->pg_estrategia_tipo_pontuacao) $km->Add("acao","acao_percentagem",dica('Recalcular Progresso','Recalcula o progresso '.($config['genero_iniciativa']=='a' ? 'desta' : 'deste').' '.$config['iniciativa'].' para os caso de haver suspeita que o progresso não esteja calculado corretamente.').'Recalcular Progresso'.dicaF(), "javascript: void(0);' onclick='recalcular(".$pg_estrategia_id.",".$obj->pg_estrategia_percentagem.")");
	
	
	
	$km->Add("acao","acao_imprimir",dica('Imprimir', 'Clique neste ícone '.imagem('imprimir_p.png').' para visualizar as opções de relatórios.').imagem('imprimir_p.png').' Imprimir'.dicaF(), "javascript: void(0);'");	
	$km->Add("acao_imprimir","acao_imprimir1",dica('Detalhes d'.($config['genero_iniciativa']=='a' ? 'esta' : 'este').' '.$config['iniciativa'], 'Visualize os detalhes d'.($config['genero_iniciativa']=='a' ? 'esta' : 'este').' '.$config['iniciativa'].'.').' Detalhes d'.($config['genero_iniciativa']=='a' ? 'esta' : 'este').' '.$config['iniciativa'].dicaF(), "javascript: void(0);' onclick='url_passar(1, \"m=".$m."&a=".$a."&dialogo=1&pg_estrategia_id=".$pg_estrategia_id."\");");
	$km->Add("acao_imprimir","acao_imprimir1",dica('Valores', 'Visualize os valores envolvidos n'.$config['genero_projeto'].'s '.$config['projetos'].' subordinad'.$config['genero_projeto'].'s '.($config['genero_iniciativa']=='a' ? 'à' : 'ao').' '.$config['iniciativa'].'.').' Valores envolvidos'.dicaF(), "javascript: void(0);' onclick='url_passar(1, \"m=".$m."&a=iniciativa_valor_pizza_pro&dialogo=1&jquery=1&pg_estrategia_id=".$pg_estrategia_id."\");");
	$km->Add("acao","acao_exportar",dica('Exportar Link', 'Clique neste ícone '.imagem('icones/exporta_p.png').' para criar um endereço web para visualização em ambiente externo.').imagem('icones/exporta_p.png').' Exportar Link'.dicaF(), "javascript: void(0);' onclick='exportar_link();");	

	
	echo $km->Render();
	echo '</td></tr></table>';
	}	
	
if($dialogo && $Aplic->profissional) {
	include_once BASE_DIR.'/modulos/projetos/artefato.class.php';
	include_once BASE_DIR.'/modulos/projetos/artefato_template.class.php';
	$dados=array();
	$dados['projeto_cia'] = $obj->pg_estrategia_cia;
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
	echo 	'<font size="4"><center>'.ucfirst($config['iniciativa']).'</center></font>';
	}
	
echo '<table id="tblObjetivos" cellpadding=0 cellspacing=1 width="100%" '.(!$dialogo ? 'class="std"' : '').' >';
if (!$Aplic->profissional){
	$sql->adTabela('causa_efeito_estrategias');
	$sql->esqUnir('causa_efeito','causa_efeito','causa_efeito.causa_efeito_id=causa_efeito_estrategias.causa_efeito_id');
	$sql->adCampo('causa_efeito_estrategias.causa_efeito_id, causa_efeito_nome, causa_efeito_acesso');
	$sql->adOnde('causa_efeito_estrategias.pg_estrategia_id='.(int)$pg_estrategia_id);
	$causa_efeitos=$sql->Lista();
	$sql->limpar();
	$saida_causa_efeito='';
	foreach($causa_efeitos as $causa_efeito) if (permiteAcessarCausa_efeito($causa_efeito['causa_efeito_acesso'],$causa_efeito['causa_efeito_id'])) $saida_causa_efeito.='&nbsp;<a href="javascript: void(0);" onclick="javascript:window.open(\'./index.php?m=praticas&a=causa_efeito&dialogo=1&causa_efeito_id='.$causa_efeito['causa_efeito_id'].'&pg_estrategia_id='.$pg_estrategia_id.'\', \'Causa_Efeito\',\'height=500,width=1024,resizable,scrollbars=yes\')">'.imagem('icones/causaefeito_p.png',$causa_efeito['causa_efeito_nome'],'Clique neste ícone '.imagem('icones/causaefeito_p.png').' para visualizar o diagrama de causa-efeito.').'</a>';
	}
else{	
	$sql->adTabela('causa_efeito_gestao');
	$sql->esqUnir('causa_efeito','causa_efeito','causa_efeito_id=causa_efeito_gestao_causa_efeito');
	$sql->adCampo('causa_efeito_id, causa_efeito_nome, causa_efeito_acesso');
	$sql->adOnde('causa_efeito_gestao_estrategia='.(int)$pg_estrategia_id);
	$causa_efeitos=$sql->Lista();
	$sql->limpar();
	$saida_causa_efeito='';
	foreach($causa_efeitos as $causa_efeito) if (permiteAcessarCausa_efeito($causa_efeito['causa_efeito_acesso'],$causa_efeito['causa_efeito_id'])) $saida_causa_efeito.='&nbsp;<a href="javascript: void(0);" onclick="javascript:window.open(\'./index.php?m=praticas&a=causa_efeito&dialogo=1&causa_efeito_id='.$causa_efeito['causa_efeito_id'].'&pg_estrategia_id='.$pg_estrategia_id.'\', \'Causa_Efeito\',\'height=500,width=1024,resizable,scrollbars=yes\')">'.imagem('icones/causaefeito_p.png',$causa_efeito['causa_efeito_nome'],'Clique neste ícone '.imagem('icones/causaefeito_p.png').' para visualizar o diagrama de causa-efeito.').'</a>';
	}
	
if (!$Aplic->profissional){	
	$sql->adTabela('gut_estrategias');
	$sql->esqUnir('gut','gut','gut.gut_id=gut_estrategias.gut_id');
	$sql->adCampo('gut_estrategias.gut_id, gut_nome, gut_acesso');
	$sql->adOnde('gut_estrategias.pg_estrategia_id='.(int)$pg_estrategia_id);
	$guts=$sql->Lista();
	$sql->limpar();
	$saida_gut='';
	foreach($guts as $gut) if (permiteAcessarGUT($gut['gut_acesso'],$gut['gut_id'])) $saida_gut.='&nbsp;<a href="javascript: void(0);" onclick="javascript:window.open(\'./index.php?m=praticas&a=gut&dialogo=1&gut_id='.$gut['gut_id'].'&pg_estrategia_id='.$pg_estrategia_id.'\', \'gut\',\'height=500,width=1024,resizable,scrollbars=yes\')">'.imagem('icones/gut_p.gif',$gut['gut_nome'],'Clique neste ícone '.imagem('icones/gut_p.gif').' para visualizar a matriz G.U.T.').'</a>';
	}
else{
	$sql->adTabela('gut_gestao');
	$sql->esqUnir('gut','gut','gut.gut_id=gut_gestao_gut');
	$sql->adCampo('gut_id, gut_nome, gut_acesso');
	$sql->adOnde('gut_gestao_estrategia='.(int)$pg_estrategia_id);
	$guts=$sql->Lista();
	$sql->limpar();
	$saida_gut='';
	foreach($guts as $gut) if (permiteAcessarGUT($gut['gut_acesso'],$gut['gut_id'])) $saida_gut.='&nbsp;<a href="javascript: void(0);" onclick="javascript:window.open(\'./index.php?m=praticas&a=gut&dialogo=1&gut_id='.$gut['gut_id'].'&pg_estrategia_id='.$pg_estrategia_id.'\', \'gut\',\'height=500,width=1024,resizable,scrollbars=yes\')">'.imagem('icones/gut_p.gif',$gut['gut_nome'],'Clique neste ícone '.imagem('icones/gut_p.gif').' para visualizar a matriz G.U.T.').'</a>';
	}

if (!$Aplic->profissional){
	$sql->adTabela('brainstorm_estrategias');
	$sql->esqUnir('brainstorm','brainstorm','brainstorm.brainstorm_id=brainstorm_estrategias.brainstorm_id');
	$sql->adCampo('brainstorm_estrategias.brainstorm_id, brainstorm_nome, brainstorm_acesso');
	$sql->adOnde('brainstorm_estrategias.pg_estrategia_id='.(int)$pg_estrategia_id);
	$brainstorms=$sql->Lista();
	$sql->limpar();
	$saida_brainstorm='';
	foreach($brainstorms as $brainstorm) if (permiteAcessarBrainstorm($brainstorm['brainstorm_acesso'],$brainstorm['brainstorm_id'])) $saida_brainstorm.='&nbsp;<a href="javascript: void(0);" onclick="javascript:window.open(\'./index.php?m=praticas&a=brainstorm&dialogo=1&brainstorm_id='.$brainstorm['brainstorm_id'].'&pg_estrategia_id='.$pg_estrategia_id.'\', \'Brainstorm\',\'height=500,width=1024,resizable,scrollbars=yes\')">'.imagem('icones/brainstorm_p.gif',$brainstorm['brainstorm_nome'],'Clique neste ícone '.imagem('icones/brainstorm_p.gif').' para visualizar o brainstorm.').'</a>';
	}
else{
	$sql->adTabela('brainstorm_gestao');
	$sql->esqUnir('brainstorm','brainstorm','brainstorm.brainstorm_id=brainstorm_gestao_brainstorm');
	$sql->adCampo('brainstorm.brainstorm_id, brainstorm_nome, brainstorm_acesso');
	$sql->adOnde('brainstorm_gestao_estrategia='.(int)$pg_estrategia_id);
	$brainstorms=$sql->Lista();
	$sql->limpar();
	$saida_brainstorm='';
	foreach($brainstorms as $brainstorm) if (permiteAcessarBrainstorm($brainstorm['brainstorm_acesso'],$brainstorm['brainstorm_id'])) $saida_brainstorm.='&nbsp;<a href="javascript: void(0);" onclick="javascript:window.open(\'./index.php?m=praticas&a=brainstorm&dialogo=1&brainstorm_id='.$brainstorm['brainstorm_id'].'&pg_estrategia_id='.$pg_estrategia_id.'\', \'Brainstorm\',\'height=500,width=1024,resizable,scrollbars=yes\')">'.imagem('icones/brainstorm_p.gif',$brainstorm['brainstorm_nome'],'Clique neste ícone '.imagem('icones/brainstorm_p.gif').' para visualizar o brainstorm.').'</a>';
	}

$cor_indicador=cor_indicador('estrategia', null, null, null, null, $obj->pg_estrategia_principal_indicador);

echo '<tr><td style="border: outset #d1d1cd 1px;background-color:#'.$obj->pg_estrategia_cor.'" colspan="2"><font color="'.melhorCor($obj->pg_estrategia_cor).'"><b>'.$obj->pg_estrategia_nome.'</b></font>'.$cor_indicador.$saida_brainstorm.$saida_causa_efeito.$saida_gut.'</td></tr>';


$sql->adTabela('estrategias_usuarios');
$sql->adUnir('usuarios','usuarios','usuarios.usuario_id=estrategias_usuarios.usuario_id');
$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
$sql->adCampo('usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_funcao, contato_dept');
$sql->adOnde('pg_estrategia_id = '.(int)$pg_estrategia_id);
$designados = $sql->Lista();
$sql->limpar();

$sql->adTabela('estrategias_depts');
$sql->adCampo('dept_id');
$sql->adOnde('pg_estrategia_id = '.(int)$pg_estrategia_id);
$departamentos = $sql->carregarColuna();
$sql->limpar();

if ($obj->pg_estrategia_cia) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['organizacao']).' Responsável', ucfirst($config['genero_organizacao']).' '.$config['organizacao'].' responsável.').ucfirst($config['organizacao']).' responsável:'.dicaF().'</td><td class="realce" width="100%">'.link_cia($obj->pg_estrategia_cia).'</td></tr>';
if ($Aplic->profissional){
	$sql->adTabela('estrategia_cia');
	$sql->adCampo('estrategia_cia_cia');
	$sql->adOnde('estrategia_cia_estrategia = '.(int)$pg_estrategia_id);
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
	if ($saida_cias) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['organizacoes']).' Envolvid'.$config['genero_organizacao'].'s', 'Quais '.strtolower($config['organizacoes']).' estão envolvid'.$config['genero_organizacao'].'s.').ucfirst($config['organizacoes']).' envolvid'.$config['genero_organizacao'].'s:'.dicaF().'</td><td width="100%" colspan="2" class="realce">'.$saida_cias.'</td></tr>';
	}

if ($obj->pg_estrategia_dept) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['departamento']).' Responsável', ucfirst($config['genero_dept']).' '.$config['departamento'].' responsável por '.($config['genero_iniciativa']=='a' ? 'esta' : 'este').' '.$config['iniciativa'].'.').ucfirst($config['departamento']).' responsável:'.dicaF().'</td><td class="realce" width="100%">'.link_secao($obj->pg_estrategia_dept).'</td></tr>';
$saida_depts='';
if ($departamentos && count($departamentos)) {
	$saida_depts.= '<table cellspacing=0 cellpadding=0 border=0 width="100%">';
	$saida_depts.= '<tr><td>'.link_secao($departamentos[0]);
	$qnt_lista_depts=count($departamentos);
	if ($qnt_lista_depts > 1) {		
		$lista='';
		for ($i = 1, $i_cmp = $qnt_lista_depts; $i < $i_cmp; $i++) $lista.=link_secao($departamentos[$i]).'<br>';		
		$saida_depts.= dica('Outr'.$config['genero_dept'].'s '.ucfirst($config['departamentos']), 'Clique para visualizar '.$config['genero_dept'].'s demais '.strtolower($config['departamentos']).'.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_depts\');">(+'.($qnt_lista_depts - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_depts"><br>'.$lista.'</span>';
		}
	$saida_depts.= '</td></tr></table>';
	} 
if ($saida_depts) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['departamentos']), 'Qual '.strtolower($config['departamento']).' está envolvid'.$config['genero_dept'].' com '.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').ucfirst($config['departamentos']).' envolvid'.$config['genero_dept'].'s:'.dicaF().'</td><td width="100%" colspan="2" class="realce">'.$saida_depts.'</td></tr>';
if ($obj->pg_estrategia_usuario) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Responsável pel'.$config['genero_objetivo'].' '.ucfirst($config['objetivo']).'', ucfirst($config['usuario']).' responsável por gerenciar '.($config['genero_iniciativa']=='a' ? 'esta' : 'este').' '.$config['iniciativa'].'.').'Responsável:'.dicaF().'</td><td class="realce" width="100%">'.link_usuario($obj->pg_estrategia_usuario, '','','esquerda').'</td></tr>';		
$saida_quem='';
if ($designados && count($designados)) {
	$saida_quem.= '<table cellspacing=0 cellpadding=0 border=0 width="100%">';
	$saida_quem.= '<tr><td>'.link_usuario($designados[0]['usuario_id'], '','','esquerda').($designados[0]['contato_dept']? ' - '.link_secao($designados[0]['contato_dept']) : '');
	$qnt_designados=count($designados);
	if ($qnt_designados > 1) {		
		$lista='';
		for ($i = 1, $i_cmp = $qnt_designados; $i < $i_cmp; $i++) $lista.=link_usuario($designados[$i]['usuario_id'], '','','esquerda').($designados[$i]['contato_dept']? ' - '.link_secao($designados[$i]['contato_dept']) : '').'<br>';		
		$saida_quem.= dica('Outros Designados', 'Clique para visualizar os demais designados.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'designados\');">(+'.($qnt_designados - 1).')</a>'.dicaF(). '<span style="display: none" id="designados"><br>'.$lista.'</span>';
		}
	$saida_quem.= '</td></tr></table>';
	} 
if ($saida_quem) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Designados', 'Quais '.strtolower($config['usuarios']).' estão envolvid'.$config['genero_usuario'].'s.').'Designados:'.dicaF().'</td><td width="100%" colspan="2" class="realce">'.$saida_quem.'</td></tr>';

if ($Aplic->profissional){
	
	$tipo_pontuacao=array(
		''=>'Manual',
		'media_ponderada'=>'Média ponderada das percentagens dos objetos relacionados',
		'pontos_completos'=>'Pontos dos objetos relacionados desde que com percentagens completas',
		'pontos_parcial'=>'Pontos dos objetos relacionados mesmo com percentagens incompletas',
		'indicador'=>'Indicador principal'
		);
	
	echo '<tr><td align="right" nowrap="nowrap">'.dica('Sistema de Percentagem', 'Qual forma a percentagem d'.$config['genero_iniciativa'].' '.$config['iniciativa'].' é calculada.').'Sistema de percentagem:'.dicaF().'</td><td class="realce">'.(isset($tipo_pontuacao[$obj->pg_estrategia_tipo_pontuacao]) ? $tipo_pontuacao[$obj->pg_estrategia_tipo_pontuacao] : '').'</td></tr>';
	
	
	
	$tipo_pontuacao=array('pontos_completos_filhos', 'pontos_parcial_filhos', 'pontos_completos_projetos', 'pontos_parcial_projetos', 'pontos_completos_acoes', 'pontos_parcial_acoes', 'pontos_completos_acoes_projetos', 'pontos_parcial_acoes_projetos');
	if (in_array($obj->pg_estrategia_tipo_pontuacao, $tipo_pontuacao)) echo '<tr><td align=right>'.dica('Pontuação Alvo', 'A pontuação necessária da soma das filhas para que '.$config['genero_iniciativa'].' '.$config['iniciativa'].' fique com progresso em 100%.').'Pontuação Alvo:'.dicaF().'</td><td class="realce">'.number_format((float)$obj->pg_estrategia_ponto_alvo, 2, ',', '.').'</td></tr>';	
	
	if ($obj->pg_estrategia_tipo_pontuacao && $obj->pg_estrategia_tipo_pontuacao!='indicador'){
		$sql->adTabela('estrategia_media');
		$sql->adOnde('estrategia_media_estrategia = '.(int)$pg_estrategia_id);
		$sql->adOnde('estrategia_media_tipo = \''.$obj->pg_estrategia_tipo_pontuacao.'\'');
		$sql->adCampo('estrategia_media.*');
		$sql->adOrdem('estrategia_media_ordem');
		$medias=$sql->Lista();
		$sql->limpar();
		
		$tipo=$obj->pg_estrategia_tipo_pontuacao;
		$inserir_objeto=(($tipo=='media_ponderada' || $tipo=='pontos_completos' || $tipo=='pontos_parcial') ? true : false);
		$inserir_pontuacao=(($tipo=='pontos_completos' || $tipo=='pontos_parcial') ? true : false);
		$inserir_peso=($tipo=='media_ponderada' ? true : false);

		if (count($medias)) {
			echo '<tr><td align="right" nowrap="nowrap"></td><td><table cellspacing=0 cellpadding=0 border=0 class="tbl1" align=left><tr><th>Objeto</th>'.($inserir_peso ? '<th>Peso</th>' : '').($inserir_pontuacao ? '<th>Pontuação</th>' : '').'</tr>';
			foreach ($medias as $contato_id => $media) {
				echo '<tr align="center">';
				if ($inserir_objeto && $media['estrategia_media_projeto']) echo '<td align="left">'.imagem('icones/projeto_p.gif').link_projeto($media['estrategia_media_projeto']).'</td>';
				elseif ($inserir_objeto && $media['estrategia_media_acao']) echo '<td align="left">'.imagem('icones/plano_acao_p.gif').link_acao($media['estrategia_media_acao']).'</td>';
				if ($inserir_peso) echo '<td align="right">'.number_format($media['estrategia_media_peso'], 2, ',', '.').'</td>';
				if ($inserir_pontuacao) echo '<td align="right">'.number_format($media['estrategia_media_ponto'], 2, ',', '.').'</td>';
				echo '</tr>';
				}
			echo '</table></td></tr>';
			}
		}
	echo '<tr><td align="right" nowrap="nowrap">'.dica('Progresso', $config['iniciativa'].' pode ir de 0% (não iniciado) até 100% (completado).').'Progresso:'.dicaF().'</td><td class="realce">'.number_format((float)$obj->pg_estrategia_percentagem, 2, ',', '.').'%</td></tr>';
	}
else echo '<tr><td align="right" nowrap="nowrap">'.dica('Progresso', $config['iniciativa'].' pode ir de 0% (não iniciado) até 100% (completado).').'Progresso:'.dicaF().'</td><td class="realce" width="300">'.number_format($obj->pg_estrategia_percentagem, 2, ',', '.').'%</td></tr>';

if ($obj->pg_estrategia_descricao) echo '<tr><td align="right" nowrap="nowrap">'.dica('Descrição', 'Descrição d'.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'Descrição:'.dicaF().'</td><td class="realce" width="100%">'.$obj->pg_estrategia_descricao.'</td></tr>';


$sql->adTabela('estrategia_fator');
$sql->adCampo('estrategia_fator_perspectiva, estrategia_fator_tema, estrategia_fator_objetivo, estrategia_fator_fator, estrategia_fator_me');
$sql->adOnde('estrategia_fator_estrategia ='.(int)$pg_estrategia_id);
$sql->adOrdem('estrategia_fator_ordem');
$lista_perspectivas = $sql->lista();
$sql->limpar();
$saida_perspectiva='';
if ($lista_perspectivas && count($lista_perspectivas)) {
	echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Relacionad'.$config['genero_iniciativa'],'A quais áreas '.($config['genero_iniciativa']=='o' ? 'este' : 'esta').' '.$config['iniciativa'].' está relacionad'.$config['genero_iniciativa'].'.').'Relacionad'.$config['genero_iniciativa'].':'.dicaF().'</td><td class="realce" width="100%">';
	$qnt=0;
	foreach($lista_perspectivas as $gestao_data){
		if ($gestao_data['estrategia_fator_perspectiva']) echo ($qnt++ ? '<br>' : '').imagem('icones/perspectiva_p.png').link_perspectiva($gestao_data['estrategia_fator_perspectiva']);
		elseif ($gestao_data['estrategia_fator_tema']) echo ($qnt++ ? '<br>' : '').imagem('icones/tema_p.png').link_tema($gestao_data['estrategia_fator_tema']);
		elseif ($gestao_data['estrategia_fator_objetivo']) echo ($qnt++ ? '<br>' : '').imagem('icones/obj_estrategicos_p.gif').link_objetivo($gestao_data['estrategia_fator_objetivo']);
		elseif ($gestao_data['estrategia_fator_me']) echo ($qnt++ ? '<br>' : '').imagem('icones/me_p.png').link_me($gestao_data['estrategia_fator_me']);
		elseif ($gestao_data['estrategia_fator_fator']) echo ($qnt++ ? '<br>' : '').imagem('icones/fator_p.gif').link_fator($gestao_data['estrategia_fator_fator']);
		
		
		}
	echo '</td></tr>';
	} 


if ($obj->pg_estrategia_composicao){
	$sql->adTabela('estrategias_composicao');
	$sql->adCampo('estrategia_filho');
	$sql->adOnde('estrategia_pai = '.(int)$pg_estrategia_id);
	$composicao = $sql->Lista();
	$sql->limpar();
	$saida_composicao='';
	if ($composicao && count($composicao)) {
		$saida_composicao.= '<table cellspacing=0 cellpadding=0 border=0 width="100%">';
		$saida_composicao.= '<tr><td>'.link_objetivo($composicao[0]['estrategia_filho']);
		$qnt_composicao=count($composicao);
		if ($qnt_composicao > 1) {		
				$lista='';
				for ($i = 1, $i_cmp = $qnt_composicao; $i < $i_cmp; $i++) $lista.=link_objetivo($composicao[$i]['estrategia_filho']).'<br>';		
				$saida_composicao.= dica('Outros Designados', 'Clique para visualizar os demais designados.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'composicao\');">(+'.($qnt_composicao - 1).')</a>'.dicaF(). '<span style="display: none" id="composicao"><br>'.$lista.'</span>';
				}
		$saida_composicao.= '</td></tr></table>';
		} 
	if ($saida_composicao) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Composição', 'Este pratica é composto da média ponderada de outros praticas.').'Composição:'.dicaF().'</td><td class="realce" width="100%"><table cellpadding=1 cellspacing=0><tr><td>'.$saida_composicao.'</td><td><a href="javascript: void(0);" onclick="javascript:window.open(\'./index.php?m=praticas&a=pg_estrategia_explodir&dialogo=1&pg_estrategia_id='.$pg_estrategia_id.'\', \'Composição\',\'height=630,width=830,scrollbars=no\')">'.imagem('icones/pg_estrategia_exp_p.png','Composição','Clique neste ícone '.imagem('icones/pg_estrategia_exp_p.png').' para visualizar a composição de praticas.').'</a></td></tr></table></td></tr>';
	}



if ($obj->pg_estrategia_inicio) echo '<tr><td align="right" nowrap="nowrap">'.dica('Data de Início', 'Data de início d'.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'Data de início:'.dicaF().'</td><td class="realce" width="300">'.retorna_data($obj->pg_estrategia_inicio, false).'</td></tr>';
if ($obj->pg_estrategia_fim) echo '<tr><td align="right" nowrap="nowrap">'.dica('Data de término', 'Data estimada de término d'.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'Data de término:'.dicaF().'</td><td class="realce" width="300">'.retorna_data($obj->pg_estrategia_fim, false).'</td></tr>';
if ($obj->pg_estrategia_principal_indicador) echo '<tr><td align="right" nowrap="nowrap">'.dica('Indicador Principal', 'Dentre os indicadores d'.$config['genero_iniciativa'].' '.$config['iniciativa'].' mais representativo da situação geral do mesmo.').'Indicador principal:'.dicaF().'</td><td width="100%" class="realce">'.link_indicador($obj->pg_estrategia_principal_indicador).'</td></tr>';
if ($obj->pg_estrategia_ano) echo '<tr><td align="right" nowrap="nowrap">'.dica('Ano', 'O ano  base d'.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'Ano:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->pg_estrategia_ano.'</td></tr>';
if ($obj->pg_estrategia_codigo) echo '<tr><td align="right" nowrap="nowrap">'.dica('Código', 'O  código d'.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'Código:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->pg_estrategia_codigo.'</td></tr>';
if ($obj->pg_estrategia_oque) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('O Que Fazer', 'Sumário sobre o que se trata '.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'O Que:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_oque.'</td></tr>';
if ($obj->pg_estrategia_porque) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Por Que Fazer', 'Por que '.$config['genero_iniciativa'].' '.$config['iniciativa'].' será executada.').'Por que:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_porque.'</td></tr>';
if ($obj->pg_estrategia_onde) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Onde Fazer', 'Onde '.$config['genero_iniciativa'].' '.$config['iniciativa'].' é executada.').'Onde:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_onde.'</td></tr>';
if ($obj->pg_estrategia_quando) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Quando Fazer', 'Quando '.$config['genero_iniciativa'].' '.$config['iniciativa'].' é executada.').'Quando:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_quando.'</td></tr>';
if ($obj->pg_estrategia_quem) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Quem', 'Quais '.$config['usuarios'].' estarão executando '.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'Quem:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_quem.'</td></tr>';
if ($obj->pg_estrategia_como) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Como Fazer', 'Como '.$config['genero_iniciativa'].' '.$config['iniciativa'].' é executad'.$config['genero_iniciativa'].'.').'Como:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_como.'</td></tr>';
if ($obj->pg_estrategia_quanto) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Quanto Custa', 'Custo para executar '.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'Quanto:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_quanto.'</td></tr>';

echo '<tr><td align="right" nowrap="nowrap">'.dica('Ativ'.$config['genero_iniciativa'], ucfirst($config['genero_iniciativa']).' '.$config['iniciativa'].' se encontra ativ'.$config['genero_iniciativa'].'.').'Ativ'.$config['genero_iniciativa'].':'.dicaF().'</td><td class="realce" style="text-align: justify;">'.($obj->pg_estrategia_ativo ? 'Sim' : 'Não').'</td></tr>';

	
if ($obj->pg_estrategia_desde_quando || $obj->pg_estrategia_controle || $obj->pg_estrategia_metodo_aprendizado || $obj->pg_estrategia_melhorias){	
	echo '<tr><td colspan=20><b>Controle</b></td></tr>';
	if ($obj->pg_estrategia_desde_quando) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Desde Quando é Feita', 'Desde quando '.$config['genero_iniciativa'].' '.$config['iniciativa'].' é executad'.$config['genero_iniciativa'].'.').'Desde quando:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_desde_quando.'</td></tr>';
	if ($obj->pg_estrategia_controle) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Método de Controle', 'Como '.$config['genero_iniciativa'].' '.$config['iniciativa'].' é controlad'.$config['genero_iniciativa'].'.').'Controle:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_controle.'</td></tr>';
	if ($obj->pg_estrategia_metodo_aprendizado) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Método de Aprendizado', 'Como é realizado o aprendizado d'.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').'Aprendizado:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_metodo_aprendizado.'</td></tr>';
	if ($obj->pg_estrategia_melhorias) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Melhorias Efetuadas n'.$config['genero_iniciativa'].' '.ucfirst($config['iniciativa']).'', 'Quais as melhorias realizadas n'.$config['genero_iniciativa'].' '.$config['iniciativa'].' após girar o círculo PDCA.').'Melhorias:'.dicaF().'</td><td class="realce" width="100%" style="margin-bottom:0cm; margin-top:0cm;">'.$obj->pg_estrategia_melhorias.'</td></tr>';
	}



$sql->adTabela('metas');
$sql->adCampo('pg_meta_id');
$sql->adOnde('pg_meta_estrategia ='.(int)$pg_estrategia_id);
$lista_metas = $sql->carregarColuna();
$sql->limpar();

$saida_meta='';
if ($lista_metas && count($lista_metas)) {
		$saida_meta.= '<table cellspacing=0 cellpadding=0 border=0 width="100%">';
		$saida_meta.= '<tr><td>'.link_meta($lista_metas[0]);
		$qnt_lista_metas=count($lista_metas);
		if ($qnt_lista_metas > 1) {		
				$lista='';
				for ($i = 1, $i_cmp = $qnt_lista_metas; $i < $i_cmp; $i++) $lista.=link_meta($lista_metas[$i]).'<br>';		
				$saida_meta.= dica('Outras Metas', 'Clique para visualizar as demais metas vinculadas.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_meta\');">(+'.($qnt_lista_metas - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_meta"><br>'.$lista.'</span>';
				}
		$saida_meta.= '</td></tr></table>';
		} 

if ($saida_meta) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['meta']), 'Qual '.$config['meta'].' está relacionada'.$config['genero_meta'].'  com '.$config['genero_iniciativa'].' '.$config['iniciativa'].'.').ucfirst($config['meta']).':'.dicaF().'</td><td width="100%" colspan="2" class="realce">'.$saida_meta.'</td></tr>';

$acesso = getSisValor('NivelAcesso','','','sisvalor_id');
echo '<tr><td align="right" nowrap="nowrap">'.dica('Nível de Acesso', 'Pode ter cinco níveis de acesso:<ul><li><b>Público</b> - Todos podem ver e editar.</li><li><b>Protegido</b> - Todos podem ver, porem apenas o responsável e os designados podem editar.</li><li><b>Protegido II</b> - Todos podem ver, porem apenas o responsável pode editar.</li><li><b>Participante</b> - Somente o responsável e os designados podem ver e editar</li><li><b>Privado</b> - Somente o responsável e os designados podem ver, e o responsável editar.</li></ul>').'Nível de acesso:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.(isset($acesso[$obj->pg_estrategia_acesso]) ? $acesso[$obj->pg_estrategia_acesso] : '').'</td></tr>';


		
	


if ($Aplic->profissional) {
	$sql->adTabela('moeda');
	$sql->adCampo('moeda_id, moeda_simbolo');
	$sql->adOrdem('moeda_id');
	$moedas=$sql->listaVetorChave('moeda_id','moeda_simbolo');
	$sql->limpar();
	echo '<tr><td align="right" nowrap="nowrap">'.dica('Moeda', 'A moeda padrão utilizada.').'Moeda:'.dicaF().'</td><td class="realce" width="100%">'.$moedas[$obj->pg_estrategia_moeda].'</td></tr>';	
	}
if ($Aplic->profissional && $tem_aprovacao) echo '<tr><td align="right" nowrap="nowrap">'.dica('Aprovado', 'Se '.$config['genero_iniciativa'].' '.$config['iniciativa'].' se encontra aprovad'.$config['genero_iniciativa'].'.').'Aprovad'.$config['genero_iniciativa'].':'.dicaF().'</td><td  class="realce" width="100%">'.($obj->pg_estrategia_aprovado ? 'Sim' : '<span style="color:red; font-weight:bold">Não</span>').'</td></tr>';


require_once ($Aplic->getClasseSistema('CampoCustomizados'));
$campos_customizados = new CampoCustomizados('estrategias', $obj->pg_estrategia_id, 'ver');
if ($campos_customizados->count()) {
		echo '<tr><td colspan="2">';
		$campos_customizados->imprimirHTML();
		echo '</td></tr>';
		}	


if ($Aplic->profissional) include_once BASE_DIR.'/modulos/praticas/estrategia_ver_pro.php';			



				
		
echo '</table>';
if (!$dialogo) echo estiloFundoCaixa();
else if ($dialogo && !($Aplic->usuario_nomeguerra=='Visitante' && $Aplic->usuario_id=1)) echo '<script language=Javascript>self.print();</script>';

if (!$dialogo) {
	$caixaTab = new CTabBox('m=praticas&a=estrategia_ver&pg_estrategia_id='.$pg_estrategia_id, '', $tab);
	
	if ($Aplic->profissional){
		$qnt_aba=0;
		if ($Aplic->profissional) {
			$sql->adTabela('log');
			$sql->adCampo('count(log_id)');
			$sql->adOnde('log_estrategia = '.(int)$pg_estrategia_id);
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/log_ver_pro', 'Registros',null,null,'Registros das Ocorrências','Visualizar os registros das ocorrências.');
				}
			}
	
		if ($Aplic->modulo_ativo('calendario') && $Aplic->checarModulo('calendario', 'acesso')) {
			if ($Aplic->profissional) {
				$sql->adTabela('evento_gestao','evento_gestao');
				$sql->adOnde('evento_gestao_estrategia = '.(int)$pg_estrategia_id);
				$sql->adCampo('count(evento_gestao_estrategia)');
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
				$sql->adOnde('arquivo_gestao_estrategia = '.(int)$pg_estrategia_id);
				$sql->adCampo('count(arquivo_gestao_estrategia)');
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
				$sql->adOnde('link_gestao_estrategia = '.(int)$pg_estrategia_id);
				$sql->adCampo('count(link_gestao_estrategia)');
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
				$sql->adOnde('forum_gestao_estrategia = '.(int)$pg_estrategia_id);
				$sql->adCampo('count(forum_gestao_estrategia)');
				$existe=$sql->resultado();
				$sql->limpar();
				}
			else $existe=true;	
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/foruns/forum_tabela', 'Fóruns',null,null,'Fóruns','Visualizar os fóruns relacionados.');
				}
			}
			
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'indicador')) {
			if ($Aplic->profissional) {
				$sql->adTabela('pratica_indicador_gestao','pratica_indicador_gestao');
				$sql->adOnde('pratica_indicador_gestao_estrategia = '.(int)$pg_estrategia_id);
				$sql->adCampo('count(pratica_indicador_gestao_estrategia)');
				$existe=$sql->resultado();
				$sql->limpar();
				}
			else $existe=true;	
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/indicadores_ver', 'Indicadores',null,null,'Indicadores','Visualizar os indicadores relacionados.');
				}
			}
			
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'plano_acao')) {
			if ($Aplic->profissional) {
				$sql->adTabela('plano_acao_gestao','plano_acao_gestao');
				$sql->adOnde('plano_acao_gestao_estrategia = '.(int)$pg_estrategia_id);
				$sql->adCampo('count(plano_acao_gestao_estrategia)');
				$existe=$sql->resultado();
				$sql->limpar();
				}
			else $existe=true;	
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/plano_acao_ver_idx', ucfirst($config['acoes']),null,null,ucfirst($config['acoes']),'Visualizar '.$config['genero_acao'].'s '.$config['acoes'].' relacionad'.$config['genero_acao'].'s.');
				}
			}
			
		if ($Aplic->modulo_ativo('projetos') && $Aplic->checarModulo('projetos', 'acesso')) {
			if ($Aplic->profissional) {
				$sql->adTabela('projeto_gestao');
				$sql->adOnde('projeto_gestao_estrategia = '.(int)$pg_estrategia_id);
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
			$sql->adOnde('msg_gestao_estrategia = '.(int)$pg_estrategia_id);
			$sql->adCampo('count(msg_gestao_estrategia)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) $caixaTab->adicionar(BASE_DIR.'/modulos/email/ver_msg_pro', ucfirst($config['mensagens']),null,null,ucfirst($config['mensagens']),ucfirst($config['genero_mensagem']).'s '.$config['mensagens'].' relacionad'.$config['genero_mensagem'].'s.');
			if ($config['doc_interno']) {
				$sql->adTabela('modelo_gestao','modelo_gestao');
				$sql->adOnde('modelo_gestao_estrategia = '.(int)$pg_estrategia_id);
				$sql->adCampo('count(modelo_gestao_estrategia)');
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
			$sql->adOnde('ata_gestao_estrategia = '.(int)$pg_estrategia_id);
			$sql->adCampo('count(ata_gestao_estrategia)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/atas/ata_tabela', 'Atas',null,null,'Atas','Visualizar as atas de reunião relacionadas.');
				}
			}
			
		if ($Aplic->profissional && $Aplic->modulo_ativo('problema') && $Aplic->checarModulo('problema', 'acesso')) {
			$sql->adTabela('problema_gestao','problema_gestao');
			$sql->adOnde('problema_gestao_estrategia = '.(int)$pg_estrategia_id);
			$sql->adCampo('count(problema_gestao_estrategia)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/problema/problema_tabela', ucfirst($config['problemas']),null,null,ucfirst($config['problemas']),'Visualizar '.$config['genero_problema'].'s '.$config['problemas'].' relacionad'.$config['genero_problema'].'s.');
				}
			}
			
		if ($Aplic->profissional && $Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'risco')) {
			$sql->adTabela('risco_gestao','risco_gestao');
			$sql->adOnde('risco_gestao_estrategia = '.(int)$pg_estrategia_id);
			$sql->adCampo('count(risco_gestao_estrategia)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/risco_pro_ver_idx', ucfirst($config['riscos']),null,null,ucfirst($config['riscos']),'Visualizar '.$config['genero_risco'].'s '.$config['riscos'].' relacionad'.$config['genero_risco'].'s.');
				}	
			$sql->adTabela('risco_resposta_gestao', 'risco_resposta_gestao');
			$sql->esqUnir('risco_gestao','risco_gestao', 'risco_resposta_gestao_risco=risco_gestao_risco');
			$sql->adOnde('risco_resposta_gestao_estrategia = '.(int)$pg_estrategia_id.' OR risco_gestao_estrategia = '.(int)$pg_estrategia_id);
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
			$sql->adOnde('instrumento_gestao_estrategia = '.(int)$pg_estrategia_id);
			$sql->adCampo('count(instrumento_gestao_estrategia)');
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
		$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/estrategia_log_ver', 'Registros',null,null,'Registros','Visualizar os registros das ocorrências.<br><br>O registro é a forma padrão dos designados das ações informarem sobre o andamento e avisarem sobre problemas.');
		if ($editar) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/estrategia_log_editar', 'Registrar',null,null,'Registrar','Inserir uma ocorrência.');
		if ($Aplic->modulo_ativo('calendario') && $Aplic->checarModulo('calendario', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/ver_eventos', 'Eventos',null,null,'Eventos','Visualizar os eventos relacionados.');
		if ($Aplic->modulo_ativo('arquivos') && $Aplic->checarModulo('arquivos', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/ver_arquivos', 'Arquivos',null,null,'Arquivos','Visualizar os arquivos relacionados.');
		if ($Aplic->modulo_ativo('links') && $Aplic->checarModulo('links', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/links/index_tabela', 'Links',null,null,'Links','Visualizar os links relacionados.');
		if ($Aplic->modulo_ativo('foruns') && $Aplic->checarModulo('foruns', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/foruns/forum_tabela', 'Fóruns',null,null,'Fóruns','Visualizar os fóruns relacionados.');
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'indicador')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/indicadores_ver', 'Indicadores',null,null,'Indicadores','Visualizar os indicadores relacionados.');
		if ($Aplic->modulo_ativo('projetos') && $Aplic->checarModulo('projetos', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/projetos/ver_projetos', ucfirst($config['projetos']),null,null,ucfirst($config['projetos']),'Visualizar '.$config['genero_projeto'].'s '.$config['projetos'].' relacionad'.$config['genero_projeto'].'s.');
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'plano_acao')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/plano_acao_ver_idx', ucfirst($config['acoes']),null,null,ucfirst($config['acoes']),'Visualizar '.$config['genero_acao'].'s '.$config['acoes'].' relacionad'.$config['genero_acao'].'s.');
		$caixaTab->mostrar('','','','',true);
		echo estiloFundoCaixa('','', $tab);
		}
	}
?>
<script type="text/javascript">

function exportar_link() {
	parent.gpwebApp.popUp('Link', 900, 100, 'm=publico&a=exportar_link&dialogo=1&tipo=generico', null, window);
	}	

function recalcular(pg_estrategia_id, percentagem){
	parent.gpwebApp.popUp('Recalculo de Progresso do Físico', 550, 100, 'm=praticas&a=estrategia_recalcular_fisico_pro&dialogo=1&pg_estrategia_id='+pg_estrategia_id+'&percentagem='+percentagem, null, window);
	}

function excluir() {
	if (confirm( "Tem certeza que deseja excluir <?php echo ($config['genero_iniciativa']=='a' ? 'esta' : 'este').' '.$config['iniciativa']?>?")) {
		var f = document.env;
		f.del.value=1;
		f.a.value='estrategia_fazer_sql';
		f.submit();
		}
	}

function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}
</script>