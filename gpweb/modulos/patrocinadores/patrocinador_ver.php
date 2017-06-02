<?php 
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');

if (!($podeAcessar || $Aplic->usuario_super_admin)) $Aplic->redirecionar('m=publico&a=acesso_negado');

$patrocinador_id = intval(getParam($_REQUEST, 'patrocinador_id', 0));

$sql = new BDConsulta;

$sql->adTabela('campo_formulario');
$sql->adCampo('campo_formulario_campo, campo_formulario_ativo');
$sql->adOnde('campo_formulario_tipo = \'patrocinador\'');
$sql->adOnde('campo_formulario_usuario IS NULL OR campo_formulario_usuario=0');
$exibir = $sql->listaVetorChave('campo_formulario_campo','campo_formulario_ativo');
$sql->limpar();


if ($Aplic->profissional){
	$sql->adTabela('assinatura');
	$sql->adCampo('assinatura_id, assinatura_data, assinatura_aprova');
	$sql->adOnde('assinatura_usuario='.(int)$Aplic->usuario_id);
	$sql->adOnde('assinatura_patrocinador='.(int)$patrocinador_id);
	$assinar = $sql->linha();
	$sql->limpar();
	
	//tem assinatura que aprova
	$sql->adTabela('assinatura');
	$sql->adCampo('count(assinatura_id)');
	$sql->adOnde('assinatura_aprova=1');
	$sql->adOnde('assinatura_patrocinador='.(int)$patrocinador_id);
	$tem_aprovacao = $sql->resultado();
	$sql->limpar();
	}



$obj = new CPatrocinador;
$obj->load($patrocinador_id);


if (!permiteAcessarPatrocinador($obj->patrocinador_acesso,$patrocinador_id)) $Aplic->redirecionar('m=publico&a=acesso_negado');

$paises = array('' => '(Selecione um país)') + getPais('Paises');

if (!$dialogo) $Aplic->salvarPosicao();
if (isset($_REQUEST['tab'])) $Aplic->setEstado('VerPatrocinadorTab', getParam($_REQUEST, 'tab', null));
$tab = $Aplic->getEstado('VerPatrocinadorTab') !== null ? $Aplic->getEstado('VerPatrocinadorTab') : 0;
$msg = '';

$editar=($podeEditar && permiteEditarPatrocinador($obj->patrocinador_acesso,$patrocinador_id));

echo '<form name="env" method="post">';
echo '<input type="hidden" name="m" value="patrocinadores" />';
echo '<input type="hidden" name="a" value="patrocinador_ver" />';
echo '<input type="hidden" name="patrocinador_id" value="'.$patrocinador_id.'" />';
echo '<input type="hidden" name="del" value="" />';
echo '<input type="hidden" name="modulo" value="" />';
echo '</form>';




if (!$dialogo && !$Aplic->profissional){
	$botoesTitulo = new CBlocoTitulo('Detalhes do Patrocinador', '../../../modulos/Patrocinadores/imagens/patrocinador.gif', $m, $m.'.'.$a);
	$botoesTitulo->adicionaBotao('m=patrocinadores&a=index', 'lista','','Lista de Metas','Clique neste botão para visualizar a lista de patrocinadores.');
	if ($editar) {
		$botoesTitulo->adicionaBotao('m=patrocinadores&a=patrocinador_editar&patrocinador_id='.$patrocinador_id, 'editar','','Editar este Meta','Editar os detalhes deste patrocinador.');
		if ($podeExcluir && $editar) $botoesTitulo->adicionaBotaoExcluir('excluir', $podeExcluir, $msg,'Excluir','Excluir este patrocinador do sistema.');
		}
	$botoesTitulo->mostrar();
	echo estiloTopoCaixa();
	}

if (!$dialogo && $Aplic->profissional){	
	$botoesTitulo = new CBlocoTitulo('Detalhes do Patrocinador', '../../../modulos/Patrocinadores/imagens/patrocinador.gif', $m, $m.'.'.$a);
	$botoesTitulo->mostrar();
	echo estiloTopoCaixa();
	echo '<table align="center" cellspacing=0 cellpadding=0 width="100%">'; 
	echo '<tr><td colspan=2 style="background-color: #e6e6e6" width="100%">';
	require_once BASE_DIR.'/lib/coolcss/CoolControls/CoolMenu/coolmenu.php';
	$km = new CoolMenu("km");
	$km->scriptFolder ='lib/coolcss/CoolControls/CoolMenu';
	$km->styleFolder="default";
	$km->Add("root","ver",dica('Ver','Menu de opções de visualização').'Ver'.dicaF(), "javascript: void(0);");
	$km->Add("ver","ver_lista",dica('Lista de Patrocinadores','Clique neste botão para visualizar a lista de patrocinadores.').'Lista de Patrocinadores'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=patrocinadores&a=index\");");
	if ($editar){
		$km->Add("root","inserir",dica('Inserir','Menu de opções').'Inserir'.dicaF(), "javascript: void(0);'");
		$km->Add("inserir","inserir_tarefa",dica('Novo Patrocinador', 'Criar um novo patrocinador.').'Novo Patrocinador'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=patrocinadores&a=patrocinador_editar\");");
		
		$km->Add("inserir","inserir_registro",dica('Registro de Ocorrência','Inserir um novo registro de ocorrência.').'Registro de Ocorrência'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=log_editar_pro&patrocinador_id=".$patrocinador_id."\");");
		if ($Aplic->modulo_ativo('calendario') && $Aplic->checarModulo('calendario', 'adicionar')) $km->Add("inserir","inserir_evento",dica('Novo Evento', 'Criar um novo evento relacionado.').'Evento'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=calendario&a=editar&evento_patrocinador=".$patrocinador_id."\");");
		if ($Aplic->modulo_ativo('arquivos') && $Aplic->checarModulo('arquivos', 'adicionar')) $km->Add("inserir","inserir_arquivo",dica('Novo Arquivo', 'Inserir um novo arquivo relacionado.').'Arquivo'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=arquivos&a=editar&arquivo_patrocinador=".$patrocinador_id."\");");
		if ($Aplic->modulo_ativo('links') && $Aplic->checarModulo('links', 'adicionar')) $km->Add("inserir","inserir_link",dica('Novo Link', 'Inserir um novo link relacionado.').'Link'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=links&a=editar&link_patrocinador=".$patrocinador_id."\");");
		if ($Aplic->modulo_ativo('foruns') && $Aplic->checarModulo('foruns', 'adicionar')) $km->Add("inserir","inserir_forum",dica('Novo Fórum', 'Inserir um novo fórum relacionado.').'Fórum'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=foruns&a=editar&forum_patrocinador=".$patrocinador_id."\");");
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'adicionar', null, 'indicador')) 	$km->Add("inserir","inserir_indicador",dica('Novo Indicador', 'Inserir um novo indicador relacionado.').'Indicador'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=indicador_editar&pratica_indicador_patrocinador=".$patrocinador_id."\");");
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'adicionar', null, 'plano_acao')) $km->Add("inserir","inserir_acao",dica('Nov'.$config['genero_acao'].' '.ucfirst($config['acao']), 'Criar nov'.$config['genero_acao'].' '.$config['acao'].' relacionad'.$config['genero_acao'].'.').ucfirst($config['acao']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=plano_acao_editar&plano_acao_patrocinador=".$patrocinador_id."\");");
		if ($Aplic->modulo_ativo('projetos') && $Aplic->checarModulo('projetos', 'adicionar')) $km->Add("inserir","inserir_projeto", dica('Nov'.$config['genero_projeto'].' '.ucfirst($config['projeto']), 'Inserir nov'.$config['genero_projeto'].' '.$config['projeto'].' relacionad'.$config['genero_projeto'].'.').ucfirst($config['projeto']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=projetos&a=editar&projeto_patrocinador=".$patrocinador_id."\");");	
		if ($Aplic->modulo_ativo('email') && $Aplic->checarModulo('email', 'adicionar')) $km->Add("inserir","inserir_mensagem",dica('Nov'.$config['genero_mensagem'].' '.ucfirst($config['mensagem']), 'Inserir '.($config['genero_mensagem']=='a' ? 'uma' : 'um').' nov'.$config['genero_mensagem'].' '.$config['mensagem'].' relacionad'.$config['genero_mensagem'].'.').ucfirst($config['mensagem']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=email&a=nova_mensagem_pro&msg_patrocinador=".$patrocinador_id."\");");
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
				foreach($modelos as $rs) $km->Add("criar_documentos","novodocumento",$rs['modelo_tipo_nome'].'&nbsp;&nbsp;&nbsp;&nbsp;',	"javascript: void(0);' onclick='url_passar(0, \"m=email&a=modelo_editar&editar=1&novo=1&modelo_id=0&modelo_tipo_id=".$rs['modelo_tipo_id']."&modelo_patrocinador=".$patrocinador_id."\");", ($rs['imagem'] ? "estilo/rondon/imagens/icones/".$rs['imagem'] : ''));
				}
			}
		if ($Aplic->modulo_ativo('atas') && $Aplic->checarModulo('atas', 'adicionar')) $km->Add("inserir","inserir_ata",dica('Nova Ata de Reunião', 'Inserir uma nova ata de reunião relacionada.').'Ata de reunião'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=atas&a=ata_editar&ata_patrocinador=".$patrocinador_id."\");");
		if ($Aplic->modulo_ativo('problema') && $Aplic->checarModulo('problema', 'adicionar')) $km->Add("inserir","inserir_problema",dica('Nov'.$config['genero_problema'].' '.ucfirst($config['problema']), 'Inserir um'.($config['genero_problema']=='a' ? 'a' : '').' nov'.$config['genero_problema'].' '.$config['problema'].' relacionad'.$config['genero_problema'].'.').ucfirst($config['problema']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=problema&a=problema_editar&problema_patrocinador=".$patrocinador_id."\");");
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'adicionar', null, 'risco')) $km->Add("inserir","inserir_risco", dica('Nov'.$config['genero_risco'].' '.ucfirst($config['risco']), 'Inserir um'.($config['genero_risco']=='a' ? 'a' : '').' nov'.$config['genero_risco'].' '.$config['risco'].' relacionad'.$config['genero_risco'].'.').ucfirst($config['risco']).dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=praticas&a=risco_pro_editar&risco_patrocinador=".$patrocinador_id."\");");

		}	
	$km->Add("root","acao",dica('Ação','Menu de ações.').'Ação'.dicaF(), "javascript: void(0);'");
	
	$bloquear=($obj->patrocinador_aprovado && $config['trava_aprovacao'] && $tem_aprovacao && !$Aplic->usuario_super_admin);
	if (isset($assinar['assinatura_id']) && $assinar['assinatura_id'] && !$bloquear) $km->Add("acao","acao_assinar", ($assinar['assinatura_data'] ? dica('Mudar Assinatura', 'Entrará na tela em que se pode mudar a assinatura.').'Mudar Assinatura'.dicaF() : dica('Assinar', 'Entrará na tela em que se pode assinar.').'Assinar'.dicaF()), "javascript: void(0);' onclick='url_passar(0, \"m=sistema&u=assinatura&a=assinatura_assinar&patrocinador_id=".$patrocinador_id."\");"); 
	
	
	if ($editar) $km->Add("acao","acao_editar",dica('Editar Patrocinador','Editar os detalhes deste patrocinador.').'Editar Patrocinador'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"m=patrocinadores&a=patrocinador_editar&patrocinador_id=".$patrocinador_id."\");");
	if ($podeExcluir &&$editar) $km->Add("acao","acao_excluir",dica('Excluir','Excluir este patrocinador do sistema.').'Excluir Patrocinador'.dicaF(), "javascript: void(0);' onclick='excluir()");
	$km->Add("acao","acao_imprimir",dica('Imprimir', 'Clique neste ícone '.imagem('imprimir_p.png').' para visualizar as opções de relatórios.').imagem('imprimir_p.png').' Imprimir'.dicaF(), "javascript: void(0);'");	
	$km->Add("acao_imprimir","acao_imprimir1",dica('Detalhes deste Patrocinador', 'Visualize os detalhes deste patrocinador.').' Detalhes deste patrocinador'.dicaF(), "javascript: void(0);' onclick='url_passar(1, \"m=".$m."&a=".$a."&dialogo=1&patrocinador_id=".$patrocinador_id."\");");	
	$km->Add("acao","acao_exportar",dica('Exportar Link', 'Clique neste ícone '.imagem('icones/exporta_p.png').' para criar um endereço web para visualização em ambiente externo.').imagem('icones/exporta_p.png').' Exportar Link'.dicaF(), "javascript: void(0);' onclick='exportar_link();");	

	echo $km->Render();
	echo '</td></tr></table>';
	}

if($dialogo && $Aplic->profissional) {
	include_once BASE_DIR.'/modulos/projetos/artefato.class.php';
	include_once BASE_DIR.'/modulos/projetos/artefato_template.class.php';
	$dados=array();
	$dados['projeto_cia'] = $obj->patrocinador_cia;
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
	echo 	'<font size="4"><center>Patrocinador</center></font>';
	}



echo '<table id="tblObjetivos" cellpadding=0 cellspacing=1 width="100%"'.($dialogo ? '' : ' class="std"').'>';




echo '<tr><td style="border: outset #d1d1cd 1px;background-color:#'.$obj->patrocinador_cor.'" colspan="2"><font color="'.melhorCor($obj->patrocinador_cor).'"><b>'.$obj->patrocinador_nome.'<b></font></td></tr>';

if ($obj->patrocinador_cia) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['organizacao']).' Responsável', ucfirst($config['genero_organizacao']).' '.$config['organizacao'].' responsável.').ucfirst($config['organizacao']).' responsável:'.dicaF().'</td><td class="realce" width="100%">'.link_cia($obj->patrocinador_cia).'</td></tr>';
if ($Aplic->profissional){
	$sql->adTabela('patrocinador_cia');
	$sql->adCampo('patrocinador_cia_cia');
	$sql->adOnde('patrocinador_cia_patrocinador = '.(int)$patrocinador_id);
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
if ($obj->patrocinador_dept) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['departamento']).' Responsável', ucfirst($config['genero_dept']).' '.$config['departamento'].' responsável por este patrocinador.').ucfirst($config['departamento']).' responsável:'.dicaF().'</td><td class="realce" width="100%">'.link_secao($obj->patrocinador_dept).'</td></tr>';



$sql->adTabela('patrocinadores_usuarios');
$sql->adUnir('usuarios','usuarios','usuarios.usuario_id=patrocinadores_usuarios.usuario_id');
$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
$sql->adCampo('usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_funcao, contato_dept');
$sql->adOnde('patrocinador_id = '.(int)$patrocinador_id);
$participantes = $sql->Lista();
$sql->limpar();

$sql->adTabela('patrocinadores_depts');
$sql->adCampo('dept_id');
$sql->adOnde('patrocinador_id = '.(int)$patrocinador_id);
$departamentos = $sql->carregarColuna();
$sql->limpar();


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
if ($saida_depts) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['departamentos']), 'Qual '.strtolower($config['departamento']).' está envolvid'.$config['genero_dept'].' com '.($config['genero_objetivo']=='o' ? 'este' : 'esta').' '.$config['objetivo'].'.').ucfirst($config['departamentos']).' envolvid'.$config['genero_dept'].'s:'.dicaF().'</td><td width="100%" colspan="2" class="realce">'.$saida_depts.'</td></tr>';




if ($obj->patrocinador_responsavel) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Responsável pelo Patrocinador', ucfirst($config['usuario']).' responsável por gerenciar o patrocinador.').'Responsável:'.dicaF().'</td><td class="realce" width="100%">'.link_usuario($obj->patrocinador_responsavel, '','','esquerda').'</td></tr>';		

$saida_quem='';
if ($participantes && count($participantes)) {
		$saida_quem.= '<table cellspacing=0 cellpadding=0 border=0 width="100%">';
		$saida_quem.= '<tr><td>'.link_usuario($participantes[0]['usuario_id'], '','','esquerda').($participantes[0]['contato_dept']? ' - '.link_secao($participantes[0]['contato_dept']) : '');
		$qnt_participantes=count($participantes);
		if ($qnt_participantes > 1) {		
				$lista='';
				for ($i = 1, $i_cmp = $qnt_participantes; $i < $i_cmp; $i++) $lista.=link_usuario($participantes[$i]['usuario_id'], '','','esquerda').($participantes[$i]['contato_dept']? ' - '.link_secao($participantes[$i]['contato_dept']) : '').'<br>';		
				$saida_quem.= dica('Outros Participantes', 'Clique para visualizar os demais participantes.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'participantes\');">(+'.($qnt_participantes - 1).')</a>'.dicaF(). '<span style="display: none" id="participantes"><br>'.$lista.'</span>';
				}
		$saida_quem.= '</td></tr></table>';
		} 
if ($saida_quem) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Designados', 'Quais '.strtolower($config['usuarios']).' estão envolvid'.$config['genero_usuario'].'s.').'Designados:'.dicaF().'</td><td width="100%" colspan="2" class="realce"><table cellspacing=0 cellpadding=0><tr><td>'.$saida_quem.'</td></tr></table></td></tr>';

if ($obj->patrocinador_descricao) echo '<tr><td align="right" >'.dica('Descrição', 'Descrição do patrocinador.').'Descrição:'.dicaF().'</td><td class="realce">'.$obj->patrocinador_descricao.'</td></tr>';
if ($obj->patrocinador_cpf) echo '<tr><td align="right" nowrap="nowrap">'.dica('CPF', 'O CPF do patrocinador.<br><br>Não tem relevância para o '.$config['gpweb'].' mas pode facilitar na catalogação dos patrocinadors.').'CPF:'.dicaF().'</td><td nowrap="nowrap" class="realce">'.$obj->patrocinador_cpf.'</td></tr>';
if ($obj->patrocinador_cnpj) echo '<tr><td align="right" nowrap="nowrap">'.dica('CNPJ', 'O CNPJ do patrocinador.<br><br>Não tem relevância para o '.$config['gpweb'].' mas pode facilitar na catalogação dos patrocinadors.').'CNPJ:'.dicaF().'</td><td nowrap="nowrap" class="realce">'.$obj->patrocinador_cnpj.'</td></tr>';
if ($obj->patrocinador_endereco1 || $obj->patrocinador_endereco2 || $obj->patrocinador_cidade || $obj->patrocinador_estado) echo '<tr><td align="right" nowrap="nowrap">'.dica('Endereço', 'O endereço do patrocinador.').'Endereço:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.$obj->patrocinador_endereco1.($obj->patrocinador_endereco1 ? '<br />' :'').$obj->patrocinador_endereco2.($obj->patrocinador_endereco2 ? '<br />' :'').$obj->patrocinador_cidade.' '.$obj->patrocinador_estado.' '.$obj->patrocinador_cep.($obj->patrocinador_cidade || $obj->patrocinador_estado || $obj->patrocinador_cep ? '<br />' :'').($paises[$obj->patrocinador_pais] ? $paises[$obj->patrocinador_pais] : $obj->patrocinador_pais).'</td></tr>';
if ($obj->patrocinador_endereco1 || $obj->patrocinador_endereco2 || $obj->patrocinador_cidade || $obj->patrocinador_estado) echo '<tr><td align="right" nowrap="nowrap">'.dica('Visualizar Endereço', 'Clique no símbolo do Google Maps à direita para visualizar o endereço do patrocinador.').'Visualizar Endereço:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.dica('Google Maps', 'Clique nesta imagem para visualizar no Google Maps, aberto em uma nova janela, o endereço do patrocinador.').'<a target="_blank" href="http://maps.google.com/maps?q='.$obj->patrocinador_endereco1.'+'.$obj->patrocinador_endereco2.'+'.$obj->patrocinador_cidade.'+'.$obj->patrocinador_estado.'+'.$obj->patrocinador_cep.'+'.$obj->patrocinador_pais.'"><img align="left" src="'.acharImagem('googlemaps.gif').'" width="55" height="22" alt="Achar no Google Maps" /></a>'.dicaF().'</td></tr>';
if ($obj->patrocinador_tel) echo '<tr><td align="right" nowrap="nowrap">'.dica('Telefone Comercial', 'O telefone comercial do patrocinador, para se comunicar com o mesmo.').'Telefone Comercial:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.($obj->patrocinador_dddtel ? '('.$obj->patrocinador_dddtel.') ' :'').$obj->patrocinador_tel.'</td></tr>';
if ($obj->patrocinador_tel2) echo '<tr><td align="right" nowrap="nowrap">'.dica('Telefone Residencial', 'O telefone residencial do patrocinador, para se comunicar com o mesmo.').'Telefone Residencial:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.($obj->patrocinador_dddtel2 ? '('.$obj->patrocinador_dddtel2.') ' :'').$obj->patrocinador_tel2.'</td></tr>';
if ($obj->patrocinador_fax) echo '<tr><td align="right" nowrap="nowrap">'.dica('Fax', 'O fax do patrocinador, para se comunicar com o mesmo.').'Fax:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.($obj->patrocinador_dddfax ? '('.$obj->patrocinador_dddfax.') ' :'').$obj->patrocinador_fax.'</td></tr>';
if ($obj->patrocinador_cel) echo '<tr><td align="right" nowrap="nowrap">'.dica('Celular', 'O celular do patrocinador, para se comunicar com o mesmo.').'Celular:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.($obj->patrocinador_dddcel ? '('.$obj->patrocinador_dddcel.') ' :'').$obj->patrocinador_cel.'</td></tr>';
if ($obj->patrocinador_email) echo '<tr><td align="right" nowrap="nowrap">'. dica('E-mail', 'O e-mail do patrocinador para se comunicar com o mesmo.').'E-mail:'.dicaF().'</td><td class="realce" nowrap="nowrap">'.link_email($obj->patrocinador_email, $patrocinador_id).'</td></tr>';
if ($obj->patrocinador_url) echo '<tr><td align="right" nowrap="nowrap">'.dica('Página Web', 'A página na Internet do patrocinador.').'Página Web:'.dicaF().'</td><td nowrap="nowrap" class="realce"><a href="http://'.$obj->patrocinador_url.'">'.$obj->patrocinador_url.'</a></td></tr>';


$sql->adTabela('patrocinador_gestao');
$sql->adCampo('patrocinador_gestao.*');
$sql->adOnde('patrocinador_gestao_patrocinador ='.(int)$patrocinador_id);
$sql->adOrdem('patrocinador_gestao_ordem');	
$lista = $sql->Lista();
$sql->limpar();
$qnt=0;
if (count($lista)){	
	
	if ($Aplic->profissional) require_once BASE_DIR.'/modulos/projetos/template_pro.class.php';
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

	echo '<tr><td align="right">'.dica('Relacionado','Áreas as quais está relacionado.').'Relacionado:'.dicaF().'</td><td class="realce" width="100%">';

	foreach($lista as $gestao_data){	
		if ($gestao_data['patrocinador_gestao_tarefa']) echo ($qnt++ ? '<br>' : '').imagem('icones/tarefa_p.gif').link_tarefa($gestao_data['patrocinador_gestao_tarefa']);
		elseif ($gestao_data['patrocinador_gestao_projeto']) echo ($qnt++ ? '<br>' : '').imagem('icones/projeto_p.gif').link_projeto($gestao_data['patrocinador_gestao_projeto']);
		elseif ($gestao_data['patrocinador_gestao_pratica']) echo ($qnt++ ? '<br>' : '').imagem('icones/pratica_p.gif').link_pratica($gestao_data['patrocinador_gestao_pratica']);
		elseif ($gestao_data['patrocinador_gestao_acao']) echo ($qnt++ ? '<br>' : '').imagem('icones/plano_acao_p.gif').link_acao($gestao_data['patrocinador_gestao_acao']);
		elseif ($gestao_data['patrocinador_gestao_perspectiva']) echo ($qnt++ ? '<br>' : '').imagem('icones/perspectiva_p.png').link_perspectiva($gestao_data['patrocinador_gestao_perspectiva']);
		elseif ($gestao_data['patrocinador_gestao_tema']) echo ($qnt++ ? '<br>' : '').imagem('icones/tema_p.png').link_tema($gestao_data['patrocinador_gestao_tema']);
		elseif ($gestao_data['patrocinador_gestao_objetivo']) echo ($qnt++ ? '<br>' : '').imagem('icones/obj_estrategicos_p.gif').link_objetivo($gestao_data['patrocinador_gestao_objetivo']);
		elseif ($gestao_data['patrocinador_gestao_fator']) echo ($qnt++ ? '<br>' : '').imagem('icones/fator_p.gif').link_fator($gestao_data['patrocinador_gestao_fator']);
		elseif ($gestao_data['patrocinador_gestao_estrategia']) echo ($qnt++ ? '<br>' : '').imagem('icones/estrategia_p.gif').link_estrategia($gestao_data['patrocinador_gestao_estrategia']);
		elseif ($gestao_data['patrocinador_gestao_meta']) echo ($qnt++ ? '<br>' : '').imagem('icones/meta_p.gif').link_meta($gestao_data['patrocinador_gestao_meta']);
		elseif ($gestao_data['patrocinador_gestao_canvas']) echo ($qnt++ ? '<br>' : '').imagem('icones/canvas_p.png').link_canvas($gestao_data['patrocinador_gestao_canvas']);
		elseif ($gestao_data['patrocinador_gestao_risco']) echo ($qnt++ ? '<br>' : '').imagem('icones/risco_p.png').link_risco($gestao_data['patrocinador_gestao_risco']);
		elseif ($gestao_data['patrocinador_gestao_risco_resposta']) echo ($qnt++ ? '<br>' : '').imagem('icones/risco_resposta_p.png').link_risco_resposta($gestao_data['patrocinador_gestao_risco_resposta']);
		elseif ($gestao_data['patrocinador_gestao_indicador']) echo ($qnt++ ? '<br>' : '').imagem('icones/indicador_p.gif').link_indicador($gestao_data['patrocinador_gestao_indicador']);
		elseif ($gestao_data['patrocinador_gestao_calendario']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_calendario($gestao_data['patrocinador_gestao_calendario']);
		elseif ($gestao_data['patrocinador_gestao_monitoramento']) echo ($qnt++ ? '<br>' : '').imagem('icones/monitoramento_p.gif').link_monitoramento($gestao_data['patrocinador_gestao_monitoramento']);
		elseif ($gestao_data['patrocinador_gestao_ata']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/atas/imagens/ata_p.png').link_ata_pro($gestao_data['patrocinador_gestao_ata']);
		elseif (isset($gestao_data['patrocinador_gestao_mswot']) && $gestao_data['patrocinador_gestao_mswot']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/swot/imagens/mswot_p.png').link_mswot($gestao_data['patrocinador_gestao_mswot']);
		elseif (isset($gestao_data['patrocinador_gestao_swot']) && $gestao_data['patrocinador_gestao_swot']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/swot/imagens/swot_p.png').link_swot($gestao_data['patrocinador_gestao_swot']);
		elseif (isset($gestao_data['patrocinador_gestao_operativo']) && $gestao_data['patrocinador_gestao_operativo']) echo ($qnt++ ? '<br>' : '').imagem('icones/operativo_p.png').link_operativo($gestao_data['patrocinador_gestao_operativo']);
		elseif ($gestao_data['patrocinador_gestao_instrumento']) echo ($qnt++ ? '<br>' : '').imagem('icones/instrumento_p.png').link_instrumento($gestao_data['patrocinador_gestao_instrumento']);
		elseif ($gestao_data['patrocinador_gestao_recurso']) echo ($qnt++ ? '<br>' : '').imagem('icones/recursos_p.gif').link_recurso($gestao_data['patrocinador_gestao_recurso']);
		elseif ($gestao_data['patrocinador_gestao_problema']) echo ($qnt++ ? '<br>' : '').imagem('icones/problema_p.png').link_problema_pro($gestao_data['patrocinador_gestao_problema']);
		elseif ($gestao_data['patrocinador_gestao_demanda']) echo ($qnt++ ? '<br>' : '').imagem('icones/demanda_p.gif').link_demanda($gestao_data['patrocinador_gestao_demanda']);
		elseif ($gestao_data['patrocinador_gestao_programa']) echo ($qnt++ ? '<br>' : '').imagem('icones/programa_p.png').link_programa($gestao_data['patrocinador_gestao_programa']);
		elseif ($gestao_data['patrocinador_gestao_licao']) echo ($qnt++ ? '<br>' : '').imagem('icones/licoes_p.gif').link_licao($gestao_data['patrocinador_gestao_licao']);
		elseif ($gestao_data['patrocinador_gestao_evento']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_evento($gestao_data['patrocinador_gestao_evento']);
		elseif ($gestao_data['patrocinador_gestao_link']) echo ($qnt++ ? '<br>' : '').imagem('icones/links_p.gif').link_link($gestao_data['patrocinador_gestao_link']);
		elseif ($gestao_data['patrocinador_gestao_avaliacao']) echo ($qnt++ ? '<br>' : '').imagem('icones/avaliacao_p.gif').link_avaliacao($gestao_data['patrocinador_gestao_avaliacao']);
		elseif ($gestao_data['patrocinador_gestao_tgn']) echo ($qnt++ ? '<br>' : '').imagem('icones/tgn_p.png').link_tgn($gestao_data['patrocinador_gestao_tgn']);
		elseif ($gestao_data['patrocinador_gestao_brainstorm']) echo ($qnt++ ? '<br>' : '').imagem('icones/brainstorm_p.gif').link_brainstorm_pro($gestao_data['patrocinador_gestao_brainstorm']);
		elseif ($gestao_data['patrocinador_gestao_gut']) echo ($qnt++ ? '<br>' : '').imagem('icones/gut_p.gif').link_gut_pro($gestao_data['patrocinador_gestao_gut']);
		elseif ($gestao_data['patrocinador_gestao_causa_efeito']) echo ($qnt++ ? '<br>' : '').imagem('icones/causaefeito_p.png').link_causa_efeito_pro($gestao_data['patrocinador_gestao_causa_efeito']);
		elseif ($gestao_data['patrocinador_gestao_arquivo']) echo ($qnt++ ? '<br>' : '').imagem('icones/arquivo_p.png').link_arquivo($gestao_data['patrocinador_gestao_arquivo']);
		elseif ($gestao_data['patrocinador_gestao_forum']) echo ($qnt++ ? '<br>' : '').imagem('icones/forum_p.gif').link_forum($gestao_data['patrocinador_gestao_forum']);
		elseif ($gestao_data['patrocinador_gestao_checklist']) echo ($qnt++ ? '<br>' : '').imagem('icones/todo_list_p.png').link_checklist($gestao_data['patrocinador_gestao_checklist']);
		elseif ($gestao_data['patrocinador_gestao_agenda']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_agenda($gestao_data['patrocinador_gestao_agenda']);
		elseif ($gestao_data['patrocinador_gestao_agrupamento']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/agrupamento/imagens/agrupamento_p.png').link_agrupamento($gestao_data['patrocinador_gestao_agrupamento']);
		elseif ($gestao_data['patrocinador_gestao_template']) echo ($qnt++ ? '<br>' : '').imagem('icones/template_p.gif').link_template($gestao_data['patrocinador_gestao_template']);
		elseif ($gestao_data['patrocinador_gestao_painel']) echo ($qnt++ ? '<br>' : '').imagem('icones/indicador_p.gif').link_painel($gestao_data['patrocinador_gestao_painel']);
		elseif ($gestao_data['patrocinador_gestao_painel_odometro']) echo ($qnt++ ? '<br>' : '').imagem('icones/odometro_p.png').link_painel_odometro($gestao_data['patrocinador_gestao_painel_odometro']);
		elseif ($gestao_data['patrocinador_gestao_painel_composicao']) echo ($qnt++ ? '<br>' : '').imagem('icones/painel_p.gif').link_painel_composicao($gestao_data['patrocinador_gestao_painel_composicao']);		
		elseif ($gestao_data['patrocinador_gestao_tr']) echo ($qnt++ ? '<br>' : '').imagem('icones/tr_p.png').link_tr($gestao_data['patrocinador_gestao_tr']);	
		}
	echo '</td></tr>';	
	}	

if ($Aplic->profissional) {
	$sql->adTabela('moeda');
	$sql->adCampo('moeda_id, moeda_simbolo');
	$sql->adOrdem('moeda_id');
	$moedas=$sql->listaVetorChave('moeda_id','moeda_simbolo');
	$sql->limpar();
	echo '<tr><td align="right" nowrap="nowrap">'.dica('Moeda', 'A moeda padrão utilizada na meta.').'Moeda:'.dicaF().'</td><td class="realce" width="100%">'.$moedas[$obj->patrocinador_moeda].'</td></tr>';	
	}
if ($Aplic->profissional && $tem_aprovacao) echo '<tr><td align="right" nowrap="nowrap">'.dica('Aprovado', 'Se o patrocinador se encontra aprovado.').'Aprovado:'.dicaF().'</td><td  class="realce" width="100%">'.($obj->patrocinador_aprovado ? 'Sim' : '<span style="color:red; font-weight:bold">Não</span>').'</td></tr>';


$acesso = getSisValor('NivelAcesso','','','sisvalor_id');
echo '<tr><td align="right" nowrap="nowrap">'.dica('Nível de Acesso', 'Pode ter cinco níveis de acesso:<ul><li><b>Público</b> - Todos podem ver e editar.</li><li><b>Protegido</b> - Todos podem ver, porem apenas o responsável e os designados podem editar.</li><li><b>Protegido II</b> - Todos podem ver, porem apenas o responsável pode editar.</li><li><b>Participante</b> - Somente o responsável e os designados podem ver e editar</li><li><b>Privado</b> - Somente o responsável e os designados podem ver, e o responsável editar.</li></ul>').'Nível de acesso:'.dicaF().'</td><td class="realce" style="text-align: justify;">'.(isset($acesso[$obj->patrocinador_acesso]) ? $acesso[$obj->patrocinador_acesso] : '').'</td></tr>';

echo '<tr><td align="right" width="100">'.dica('Ativo', 'Se o patrocinador está ativo.').'Ativo:'.dicaF().'</td><td nowrap="nowrap" class="realce">'.($obj->patrocinador_ativo ? 'Sim' : 'Não').'</td></tr>';

require_once ($Aplic->getClasseSistema('CampoCustomizados'));
$campos_customizados = new CampoCustomizados('patrocinadores', $obj->patrocinador_id, 'ver');
if ($campos_customizados->count()) {
		echo '<tr><td colspan="2">';
		$campos_customizados->imprimirHTML();
		echo '</td></tr>';
		}		

if ($Aplic->profissional) include_once BASE_DIR.'/modulos/patrocinadores/patrocinador_ver_pro.php';					
		
echo '</table>';
if (!$dialogo) echo estiloFundoCaixa();
else if ($dialogo && !($Aplic->usuario_nomeguerra=='Visitante' && $Aplic->usuario_id=1)) echo '<script language=Javascript>self.print();</script>';

if (!$dialogo) {
	$caixaTab = new CTabBox('m=patrocinadores&a=patrocinador_ver&patrocinador_id='.$patrocinador_id, '', $tab);
	$texto_consulta = '?m=patrocinadores&a=patrocinador_ver&patrocinador_id='.$patrocinador_id;
	
	if ($Aplic->profissional){
		$qnt_aba=0;
		if ($Aplic->profissional) {
			$sql->adTabela('log');
			$sql->adCampo('count(log_id)');
			$sql->adOnde('log_patrocinador = '.(int)$patrocinador_id);
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
				$sql->adOnde('evento_gestao_patrocinador = '.(int)$patrocinador_id);
				$sql->adCampo('count(evento_gestao_patrocinador)');
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
				$sql->adOnde('arquivo_gestao_patrocinador = '.(int)$patrocinador_id);
				$sql->adCampo('count(arquivo_gestao_patrocinador)');
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
				$sql->adOnde('link_gestao_patrocinador = '.(int)$patrocinador_id);
				$sql->adCampo('count(link_gestao_patrocinador)');
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
				$sql->adOnde('forum_gestao_patrocinador = '.(int)$patrocinador_id);
				$sql->adCampo('count(forum_gestao_patrocinador)');
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
				$sql->adOnde('pratica_indicador_gestao_patrocinador = '.(int)$patrocinador_id);
				$sql->adCampo('count(pratica_indicador_gestao_patrocinador)');
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
				$sql->adOnde('plano_acao_gestao_patrocinador = '.(int)$patrocinador_id);
				$sql->adCampo('count(plano_acao_gestao_patrocinador)');
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
				$sql->adOnde('projeto_gestao_patrocinador = '.(int)$patrocinador_id);
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
			$sql->adOnde('msg_gestao_patrocinador = '.(int)$patrocinador_id);
			$sql->adCampo('count(msg_gestao_patrocinador)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) $caixaTab->adicionar(BASE_DIR.'/modulos/email/ver_msg_pro', ucfirst($config['mensagens']),null,null,ucfirst($config['mensagens']),ucfirst($config['genero_mensagem']).'s '.$config['mensagens'].' relacionad'.$config['genero_mensagem'].'s.');
			if ($config['doc_interno']) {
				$sql->adTabela('modelo_gestao','modelo_gestao');
				$sql->adOnde('modelo_gestao_patrocinador = '.(int)$patrocinador_id);
				$sql->adCampo('count(modelo_gestao_patrocinador)');
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
			$sql->adOnde('ata_gestao_patrocinador = '.(int)$patrocinador_id);
			$sql->adCampo('count(ata_gestao_patrocinador)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/atas/ata_tabela', 'Atas',null,null,'Atas','Visualizar as atas de reunião relacionadas.');
				}
			}
			
		if ($Aplic->profissional && $Aplic->modulo_ativo('problema') && $Aplic->checarModulo('problema', 'acesso')) {
			$sql->adTabela('problema_gestao','problema_gestao');
			$sql->adOnde('problema_gestao_patrocinador = '.(int)$patrocinador_id);
			$sql->adCampo('count(problema_gestao_patrocinador)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/problema/problema_tabela', ucfirst($config['problemas']),null,null,ucfirst($config['problemas']),'Visualizar '.$config['genero_problema'].'s '.$config['problemas'].' relacionad'.$config['genero_problema'].'s.');
				}
			}
			
		if ($Aplic->profissional && $Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'risco')) {
			$sql->adTabela('risco_gestao','risco_gestao');
			$sql->adOnde('risco_gestao_patrocinador = '.(int)$patrocinador_id);
			$sql->adCampo('count(risco_gestao_patrocinador)');
			$existe=$sql->resultado();
			$sql->limpar();
			if ($existe) {
				$qnt_aba++;
				$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/risco_pro_ver_idx', ucfirst($config['riscos']),null,null,ucfirst($config['riscos']),'Visualizar '.$config['genero_risco'].'s '.$config['riscos'].' relacionad'.$config['genero_risco'].'s.');
				}	
			$sql->adTabela('risco_resposta_gestao', 'risco_resposta_gestao');
			$sql->esqUnir('risco_gestao','risco_gestao', 'risco_resposta_gestao_risco=risco_gestao_risco');
			$sql->adOnde('risco_resposta_gestao_patrocinador = '.(int)$patrocinador_id.' OR risco_gestao_patrocinador = '.(int)$patrocinador_id);
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
			$sql->adOnde('instrumento_gestao_patrocinador = '.(int)$patrocinador_id);
			$sql->adCampo('count(instrumento_gestao_patrocinador)');
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

		$caixaTab->adicionar(BASE_DIR.'/modulos/patrocinadores/patrocinador_ver_logs', 'Registros das Ocorrências',null,null,'Registros das Ocorrências','Visualizar os registros das ocorrências.<br><br>O registro é a forma padrão dos participantes das ações informarem sobre o andamento e avisarem sobre problemas.');
		if ($editar) $caixaTab->adicionar(BASE_DIR.'/modulos/patrocinadores/patrocinador_ver_log_atualizar', 'Registrar',null,null,'Registrar','Inserir uma ocorrência.');

		$caixaTab->adicionar(BASE_DIR.'/modulos/patrocinadores/patrocinador_ver_instrumentos', 'Instrumentos',null,null,'Instrumentos','Lista de instrumentos relacionados com este patrocinador.');
		$caixaTab->adicionar(BASE_DIR.'/modulos/patrocinadores/patrocinador_ver_recursos', 'Recursos',null,null,'Recursos','Lista de recursos relacionados com este patrocinador, através dos instrumentos.');
		
		if ($Aplic->modulo_ativo('calendario') && $Aplic->checarModulo('calendario', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/ver_eventos', 'Eventos',null,null,'Eventos','Visualizar os eventos relacionados.');
		if ($Aplic->modulo_ativo('arquivos') && $Aplic->checarModulo('arquivos', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/ver_arquivos', 'Arquivos',null,null,'Arquivos','Visualizar os arquivos relacionados.');
		if ($Aplic->modulo_ativo('links') && $Aplic->checarModulo('links', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/links/index_tabela', 'Links',null,null,'Links','Visualizar os links relacionados.');
		if ($Aplic->modulo_ativo('foruns') && $Aplic->checarModulo('foruns', 'acesso')) $caixaTab->adicionar(BASE_DIR.'/modulos/foruns/forum_tabela', 'Fóruns',null,null,'Fóruns','Visualizar os fóruns relacionados.');
		if ($Aplic->modulo_ativo('praticas') && $Aplic->checarModulo('praticas', 'acesso', null, 'indicador')) $caixaTab->adicionar(BASE_DIR.'/modulos/praticas/indicadores_ver', 'Indicadores',null,null,'Indicadores','Visualizar os indicadores relacionados.');
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
	
function excluir() {
	if (confirm('Tem certeza que deseja excluir este patrocinador')) {
		var f = document.env;
		f.del.value=1;
		f.a.value='patrocinador_fazer_sql';
		f.submit();
		}
	}

function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}
</script>