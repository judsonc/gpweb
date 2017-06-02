<?php  
/* Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


$favorito_id=getParam($_REQUEST, 'favorito_id', 0);


$projeto=getParam($_REQUEST, 'projeto', 0);
$tarefa=getParam($_REQUEST, 'tarefa', 0);
$perspectiva=getParam($_REQUEST, 'perspectiva', 0);
$tema=getParam($_REQUEST, 'tema', 0);
$objetivo=getParam($_REQUEST, 'objetivo', 0);
$fator=getParam($_REQUEST, 'fator', 0);
$estrategia=getParam($_REQUEST, 'estrategia', 0);
$meta=getParam($_REQUEST, 'meta', 0);
$pratica=getParam($_REQUEST, 'pratica', 0);
$indicador=getParam($_REQUEST, 'indicador', 0);
$acao=getParam($_REQUEST, 'acao', 0);
$canvas=getParam($_REQUEST, 'canvas', 0);
$risco=getParam($_REQUEST, 'risco', 0);
$risco_resposta=getParam($_REQUEST, 'risco_resposta', 0);
$calendario=getParam($_REQUEST, 'calendario', 0);
$monitoramento=getParam($_REQUEST, 'monitoramento', 0);
$ata=getParam($_REQUEST, 'ata', 0);
$mswot=getParam($_REQUEST, 'mswot', 0);
$swot=getParam($_REQUEST, 'swot', 0);
$operativo=getParam($_REQUEST, 'operativo', 0);
$instrumento=getParam($_REQUEST, 'instrumento', 0);
$recurso=getParam($_REQUEST, 'recurso', 0);
$problema=getParam($_REQUEST, 'problema', 0);
$demanda=getParam($_REQUEST, 'demanda', 0);
$programa=getParam($_REQUEST, 'programa', 0);
$licao=getParam($_REQUEST, 'licao', 0);
$evento=getParam($_REQUEST, 'evento', 0);
$link=getParam($_REQUEST, 'link', 0);
$avaliacao=getParam($_REQUEST, 'avaliacao', 0);
$tgn=getParam($_REQUEST, 'tgn', 0);
$brainstorm=getParam($_REQUEST, 'brainstorm', 0);
$gut=getParam($_REQUEST, 'gut', 0);
$causa_efeito=getParam($_REQUEST, 'causa_efeito', 0);
$arquivo=getParam($_REQUEST, 'arquivo', 0);
$forum=getParam($_REQUEST, 'forum', 0);
$checklist=getParam($_REQUEST, 'checklist', 0);
$agenda=getParam($_REQUEST, 'agenda ', 0);
$agrupamento=getParam($_REQUEST, 'agrupamento', 0);
$patrocinador=getParam($_REQUEST, 'patrocinador', 0);
$template=getParam($_REQUEST, 'template', 0);
$painel=getParam($_REQUEST, 'painel', 0);
$painel_odometro=getParam($_REQUEST, 'painel_odometro', 0);
$painel_composicao=getParam($_REQUEST, 'painel_composicao', 0);
$tr=getParam($_REQUEST, 'tr', 0);
$me=getParam($_REQUEST, 'me', 0);


$sql = new BDConsulta;

echo '<form method="POST" id="env" name="env">';
echo '<input type=hidden id="a" name="a" value="favoritos">';
echo '<input type=hidden id="m" name="m" value="publico">';	
echo '<input type=hidden name="favorito_id" id="favorito_id" value="'.$favorito_id.'">';	
echo '<input type="hidden" name="del" id="del" value="" />';

echo '<input type=hidden name="projeto" id="projeto" value="'.$projeto.'">'; 
echo '<input type=hidden name="tarefa" id="tarefa" value="'.$tarefa.'">'; 
echo '<input type=hidden name="perspectiva" id="perspectiva" value="'.$perspectiva.'">'; 
echo '<input type=hidden name="tema" id="tema" value="'.$tema.'">'; 
echo '<input type=hidden name="objetivo" id="objetivo" value="'.$objetivo.'">'; 
echo '<input type=hidden name="fator" id="fator" value="'.$fator.'">'; 
echo '<input type=hidden name="estrategia" id="estrategia" value="'.$estrategia.'">'; 
echo '<input type=hidden name="meta" id="meta" value="'.$meta.'">'; 
echo '<input type=hidden name="pratica" id="pratica" value="'.$pratica.'">'; 
echo '<input type=hidden name="indicador" id="indicador" value="'.$indicador.'">'; 
echo '<input type=hidden name="acao" id="acao" value="'.$acao.'">'; 
echo '<input type=hidden name="canvas" id="canvas" value="'.$canvas.'">'; 
echo '<input type=hidden name="risco" id="risco" value="'.$risco.'">'; 
echo '<input type=hidden name="risco_resposta" id="risco_resposta" value="'.$risco_resposta.'">'; 
echo '<input type=hidden name="calendario" id="calendario" value="'.$calendario.'">'; 
echo '<input type=hidden name="monitoramento" id="monitoramento" value="'.$monitoramento.'">'; 
echo '<input type=hidden name="ata" id="ata" value="'.$ata.'">'; 
echo '<input type=hidden name="mswot" id="mswot" value="'.$mswot.'">'; 
echo '<input type=hidden name="swot" id="swot" value="'.$swot.'">'; 
echo '<input type=hidden name="operativo" id="operativo" value="'.$operativo.'">'; 
echo '<input type=hidden name="instrumento" id="instrumento" value="'.$instrumento.'">'; 
echo '<input type=hidden name="recurso" id="recurso" value="'.$recurso.'">'; 
echo '<input type=hidden name="problema" id="problema" value="'.$problema.'">'; 
echo '<input type=hidden name="demanda" id="demanda" value="'.$demanda.'">'; 
echo '<input type=hidden name="programa" id="programa" value="'.$programa.'">'; 
echo '<input type=hidden name="licao" id="licao" value="'.$licao.'">'; 
echo '<input type=hidden name="evento" id="evento" value="'.$evento.'">'; 
echo '<input type=hidden name="link" id="link" value="'.$link.'">'; 
echo '<input type=hidden name="avaliacao" id="avaliacao" value="'.$avaliacao.'">'; 
echo '<input type=hidden name="tgn" id="tgn" value="'.$tgn.'">'; 
echo '<input type=hidden name="brainstorm" id="brainstorm" value="'.$brainstorm.'">'; 
echo '<input type=hidden name="gut" id="gut" value="'.$gut.'">'; 
echo '<input type=hidden name="causa_efeito" id="causa_efeito" value="'.$causa_efeito.'">'; 
echo '<input type=hidden name="arquivo" id="arquivo" value="'.$arquivo.'">'; 
echo '<input type=hidden name="forum" id="forum" value="'.$forum.'">'; 
echo '<input type=hidden name="checklist" id="checklist" value="'.$checklist.'">'; 
echo '<input type=hidden name="agenda" id="agenda" value="'.$agenda .'">'; 
echo '<input type=hidden name="agrupamento" id="agrupamento" value="'.$agrupamento.'">'; 
echo '<input type=hidden name="patrocinador" id="patrocinador" value="'.$patrocinador.'">'; 
echo '<input type=hidden name="template" id="template" value="'.$template.'">'; 
echo '<input type=hidden name="painel" id="painel" value="'.$painel.'">'; 
echo '<input type=hidden name="painel_odometro" id="painel_odometro" value="'.$painel_odometro.'">'; 
echo '<input type=hidden name="painel_composicao" id="painel_composicao" value="'.$painel_composicao.'">'; 
echo '<input type=hidden name="tr" id="tr" value="'.$tr.'">'; 
echo '<input type=hidden name="me" id="me" value="'.$me.'">';

if ($projeto) $saida='m=projetos&a=index';
elseif ($tarefa) $saida='m=tarefas&a=index';
elseif ($perspectiva) $saida='m=praticas&a=perspectiva_lista';
elseif ($tema) $saida='m=praticas&a=tema_lista';
elseif ($objetivo) $saida='m=praticas&a=obj_estrategico_lista';
elseif ($fator) $saida='m=praticas&a=fator_lista';
elseif ($estrategia) $saida='m=praticas&a=estrategia_lista';
elseif ($meta) $saida='m=praticas&a=meta_lista';
elseif ($pratica) $saida='m=praticas&a=pratica_lista';
elseif ($indicador) $saida='m=praticas&a=indicador_lista';
elseif ($acao) $saida='m=praticas&a=plano_acao_lista';
elseif ($canvas) $saida='m=praticas&a=canvas_pro_lista';
elseif ($risco) $saida='m=praticas&a=risco_pro_lista';
elseif ($risco_resposta) $saida='m=praticas&a=risco_resposta_pro_lista';
elseif ($calendario) $saida='m=praticas&a=XXX_lista';
elseif ($monitoramento) $saida='m=praticas&a=monitoramento_lista_pro';
elseif ($ata) $saida='m=atas&a=ata_lista';
elseif ($mswot) $saida='m=swot&a=mswot_lista';
elseif ($swot) $saida='m=swot&a=swot_lista';
elseif ($operativo) $saida='m=operativo&a=operativo_lista';
elseif ($instrumento) $saida='m=instrumento&a=instrumento_lista';
elseif ($recurso) $saida='m=recursos&a=index';
elseif ($problema) $saida='m=problema&a=problema_lista';
elseif ($demanda) $saida='m=projetos&a=demanda_lista';
elseif ($programa) $saida='m=projetos&a=programa_pro_lista';
elseif ($licao) $saida='m=projetos&a=licao_lista';
elseif ($evento) $saida='m=calendario&a=evento_lista_pro';
elseif ($link) $saida='m=links&a=index';
elseif ($avaliacao) $saida='m=praticas&a=avaliacao_lista';
elseif ($tgn) $saida='m=praticas&a=tgn_pro_lista';
elseif ($brainstorm) $saida='m=praticas&a=brainstorm_pro_lista';
elseif ($gut) $saida='m=praticas&a=gut_pro_lista';
elseif ($causa_efeito) $saida='m=praticas&a=causa_efeito_pro_lista';
elseif ($arquivo) $saida='m=arquivos&a=index';
elseif ($forum) $saida='m=foruns&a=index';
elseif ($checklist) $saida='m=praticas&a=checklist_lista';
elseif ($agenda) $saida='m=email&a=ver_mes';
elseif ($agrupamento) $saida='m=agrupamento&a=agrupamento_lista';
elseif ($patrocinador) $saida='m=patrocinadores&a=index';
elseif ($template) $saida='m=projetos&a=template_pro_lista';
elseif ($painel) $saida='m=praticas&a=painel_pro_lista';
elseif ($painel_odometro) $saida='m=praticas&a=odometro_pro_lista';
elseif ($painel_composicao) $saida='m=praticas&a=painel_composicao_pro_lista';
elseif ($tr) $saida='m=tr&a=tr_lista';
elseif ($me) $saida='m=praticas&a=me_lista_pro';

if ($projeto) $titulo=ucfirst($config['projetos']);
elseif ($tarefa) $titulo=ucfirst($config['tarefas']);
elseif ($perspectiva) $titulo=ucfirst($config['perspectivas']);
elseif ($tema) $titulo=ucfirst($config['temas']);
elseif ($objetivo) $titulo=ucfirst($config['objetivos']);
elseif ($fator) $titulo=ucfirst($config['fatores']);
elseif ($estrategia) $titulo=ucfirst($config['iniciativas']);
elseif ($meta) $titulo=ucfirst($config['metas']);
elseif ($pratica) $titulo=ucfirst($config['praticas']);
elseif ($indicador) $titulo='Indicadores';
elseif ($acao) $titulo=ucfirst($config['acoes']);
elseif ($canvas) $titulo=ucfirst($config['canvass']);
elseif ($risco)$titulo=ucfirst($config['riscos']);
elseif ($risco_resposta) $titulo=ucfirst($config['risco_respostas']);
elseif ($calendario) $titulo='Agendas';
elseif ($monitoramento) $titulo='Monitoramentos';
elseif ($ata) $titulo='Atas de Reunião';
elseif ($mswot) $titulo='Matrizes SWOT';
elseif ($swot) $titulo='Campos SWOT';
elseif ($operativo) $titulo='Planos Operativos';
elseif ($instrumento) $titulo=ucfirst($config['instrumentos']);
elseif ($recurso) $titulo=ucfirst($config['recursos']);
elseif ($problema) $titulo=ucfirst($config['problemas']);
elseif ($demanda) $titulo='Demandas';
elseif ($programa) $titulo=ucfirst($config['programas']);
elseif ($licao) $titulo=ucfirst($config['licoes']);
elseif ($evento) $titulo='Eventos';
elseif ($link) $titulo='Links';
elseif ($avaliacao) $titulo='Avaliações';
elseif ($tgn) $titulo=ucfirst($config['tgns']);
elseif ($brainstorm) $titulo='Brainstorms';
elseif ($gut) $titulo='G.U.T.s';
elseif ($causa_efeito) $titulo='Diagramas de Causa-Efeito';
elseif ($arquivo) $titulo='Arquivos';
elseif ($forum) $titulo='Fóruns';
elseif ($checklist) $titulo='Checklists';
elseif ($agenda) $titulo='Compromissos';
elseif ($agrupamento) $titulo='Agrupamentos';
elseif ($patrocinador) $titulo='Patrocinadores';
elseif ($template) $titulo='Modelos';
elseif ($painel) $titulo='Painéis de Indicador';
elseif ($painel_odometro) $titulo='Odômetros';
elseif ($painel_composicao) $titulo='Composições de Painéis';
elseif ($tr) $titulo=ucfirst($config['trs']);
elseif ($me) $titulo=ucfirst($config['mes']);


if (!$dialogo){	
	$Aplic->salvarPosicao();
	$botoesTitulo = new CBlocoTitulo('Detalhes do Favorito', 'favoritos.png', $m, $m.'.'.$a);
	$botoesTitulo->mostrar();
	echo estiloTopoCaixa();
	echo '<table align="center" cellspacing=0 cellpadding=0 width="100%">'; 
	echo '<tr><td colspan=2 style="background-color: #e6e6e6" width="100%">';
	require_once BASE_DIR.'/lib/coolcss/CoolControls/CoolMenu/coolmenu.php';
	$km = new CoolMenu("km");
	$km->scriptFolder ='lib/coolcss/CoolControls/CoolMenu';
	$km->styleFolder="default";
	$km->Add("root","ver",dica('Ver','Menu de opções de visualização').'Ver'.dicaF(), "javascript: void(0);");
	$km->Add("ver","ver_lista_compromissos",dica('Retornar aos Objetos','Retornar a lista dos objetos.').'Retornar aos objetos'.dicaF(), "javascript: void(0);' onclick='url_passar(0, \"".$saida."\");");
	$km->Add("ver","ver_lista_compromissos",dica('Retornar aos Favoritos','Retornar a lista dos favoroitos.').'Retornar aos favoritos'.dicaF(), "javascript: void(0);' onclick='lista();");
	$km->Add("root","inserir",dica('Inserir','Menu de opções').'Inserir'.dicaF(), "javascript: void(0);'");
	$km->Add("inserir","inserir_compromisso",dica('Novo Favorito', 'Criar um novo favorito.').'Novo favorito'.dicaF(), "javascript: void(0);' onclick='inserir();");
	$km->Add("root","menu_acao",dica('Ação','Menu de ações').'Ação'.dicaF(), "javascript: void(0);'");
	$km->Add("menu_acao","acao_editar",dica('Editar','Editar os detalhes deste favorito.').'Editar'.dicaF(), "javascript: void(0);' onclick='editar();");
	$km->Add("menu_acao","acao_excluir",dica('Excluir','Excluir este favorito do sistema.').'Excluir'.dicaF(), "javascript: void(0);' onclick='excluir();");	
	echo $km->Render();
	echo '</td></tr></table>';
	}


$sql->adTabela('favorito');
$sql->adCampo('favorito_nome, favorito_cia, favorito_dept, favorito_usuario, favorito_geral, favorito_ativo');
$sql->adOnde('favorito_id='.(int)$favorito_id);
$favorito=$sql->linha();
$sql->limpar();

echo '<table width="100%" class="std" align="center" cellspacing=1 cellpadding=0>';
echo '<tr><td align="right" width=100>'.dica('Nome', 'Nome para identificação do favorito.').'Nome:'.dicaF().'</td><td class="realce">'.$favorito['favorito_nome'].'</td></tr>';

if ($favorito['favorito_geral']){
	if ($favorito['favorito_cia']) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['organizacao']).' Responsável', ucfirst($config['genero_organizacao']).' '.$config['organizacao'].' responsável.').ucfirst($config['organizacao']).' responsável:'.dicaF().'</td><td class="realce">'.link_cia($favorito['favorito_cia']).'</td></tr>';
	if ($Aplic->profissional){
		$sql->adTabela('favorito_cia');
		$sql->adCampo('favorito_cia_cia');
		$sql->adOnde('favorito_cia_favorito = '.(int)$favorito_id);
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
		if ($saida_cias) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['organizacoes']).' Envolvid'.$config['genero_organizacao'].'s', 'Quais '.strtolower($config['organizacoes']).' estão envolvid'.$config['genero_organizacao'].'s.').ucfirst($config['organizacoes']).' envolvid'.$config['genero_organizacao'].'s:'.dicaF().'</td><td class="realce">'.$saida_cias.'</td></tr>';
		}
	if ($favorito['favorito_dept']) echo '<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['departamento']).' Responsável', ucfirst($config['genero_dept']).' '.$config['departamento'].' responsável.').ucfirst($config['departamento']).' responsável:'.dicaF().'</td><td class="realce">'.link_secao($favorito['favorito_dept']).'</td></tr>';
	
	$sql->adTabela('favorito_dept');
	$sql->adCampo('favorito_dept_dept');
	$sql->adOnde('favorito_dept_favorito ='.(int)$favorito_id);
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
	if ($saida_depts) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica(ucfirst($config['departamentos']).' Envolvid'.$config['genero_dept'].'s', 'Qual '.strtolower($config['departamento']).' está envolvid'.$config['genero_dept'].' com esta meta.').ucfirst($config['departamento']).' envolvid'.$config['genero_dept'].':'.dicaF().'</td><td class="realce">'.$saida_depts.'</td></tr>';
	
	if ($favorito['favorito_usuario']) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Responsável', 'O '.$config['usuario'].' responsável.').'Responsável:'.dicaF().'</td><td class="realce">'.link_usuario($favorito['favorito_usuario'], '','','esquerda').'</td></tr>';		
	
	$sql->adTabela('favorito_usuario');
	$sql->adUnir('usuarios','usuarios','usuarios.usuario_id=favorito_usuario_usuario');
	$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
	$sql->adCampo('usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_funcao, contato_dept');
	$sql->adOnde('favorito_usuario_favorito = '.(int)$favorito_id);
	$designados = $sql->Lista();
	$sql->limpar();
	
	$saida_quem='';
	if ($designados && count($designados)) {
			$saida_quem.= '<table cellspacing=0 cellpadding=0 border=0 width="100%">';
			$saida_quem.= '<tr><td>'.link_usuario($designados[0]['usuario_id'], '','','esquerda').($designados[0]['contato_dept']? ' - '.link_secao($designados[0]['contato_dept']) : '');
			$qnt_designados=count($designados);
			if ($qnt_designados > 1) {		
					$lista='';
					for ($i = 1, $i_cmp = $qnt_designados; $i < $i_cmp; $i++) $lista.=link_usuario($designados[$i]['usuario_id'], '','','esquerda').($designados[$i]['contato_dept']? ' - '.link_secao($designados[$i]['contato_dept']) : '').'<br>';		
					$saida_quem.= dica('Outros designados', 'Clique para visualizar os demais designados.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'designados\');">(+'.($qnt_designados - 1).')</a>'.dicaF(). '<span style="display: none" id="designados"><br>'.$lista.'</span>';
					}
			$saida_quem.= '</td></tr></table>';
			} 
	if ($saida_quem) echo '<tr><td align="right" valign="top" nowrap="nowrap">'.dica('Designados', 'Quais '.strtolower($config['usuarios']).' estão envolvid'.$config['genero_usuario'].'s.').'Designados:'.dicaF().'</td><td class="realce">'.$saida_quem.'</td></tr>';
	}



echo '<tr><td align="right" nowrap="nowrap" valign="top">'.dica($titulo, 'Lista de '.strtolower($titulo).' pertencentes ao favorito.').$titulo.':'.dicaF().'</td><td class="realce">';

$qnt=0;
$sql->adTabela('favorito_lista');
$sql->adCampo('favorito_lista_campo');
$sql->adOnde('favorito_lista_favorito='.(int)$favorito_id);
$lista=$sql->carregarColuna();
$sql->limpar();


foreach($lista AS $valor) {

	if ($tarefa) echo ($qnt++ ? '<br>' : '').link_tarefa($valor);
	elseif ($projeto) echo ($qnt++ ? '<br>' : '').link_projeto($valor);
	elseif ($pratica) echo ($qnt++ ? '<br>' : '').link_pratica($valor);
	elseif ($acao) echo ($qnt++ ? '<br>' : '').link_acao($valor);
	elseif ($perspectiva) echo ($qnt++ ? '<br>' : '').link_perspectiva($valor);
	elseif ($tema) echo ($qnt++ ? '<br>' : '').link_tema((int)$valor);
	elseif ($objetivo) echo ($qnt++ ? '<br>' : '').link_objetivo($valor);
	elseif ($fator) echo ($qnt++ ? '<br>' : '').link_fator($valor);
	elseif ($estrategia) echo ($qnt++ ? '<br>' : '').link_estrategia($valor);
	elseif ($meta) echo ($qnt++ ? '<br>' : '').link_meta($valor);
	elseif ($canvas) echo ($qnt++ ? '<br>' : '').link_canvas($valor);
	elseif ($risco) echo ($qnt++ ? '<br>' : '').link_risco($valor);
	elseif ($risco_resposta) echo ($qnt++ ? '<br>' : '').link_risco_resposta($valor);
	elseif ($indicador) echo ($qnt++ ? '<br>' : '').link_indicador($valor);
	elseif ($calendario) echo ($qnt++ ? '<br>' : '').ink_calendario($valor);
	elseif ($monitoramento) echo ($qnt++ ? '<br>' : '').link_monitoramento($valor);
	elseif ($ata) echo ($qnt++ ? '<br>' : '').link_ata_pro($valor);
	elseif ($mswot) echo ($qnt++ ? '<br>' : '').link_mswot($valor);
	elseif ($swot) echo ($qnt++ ? '<br>' : '').link_swot($valor);
	elseif ($operativo) echo ($qnt++ ? '<br>' : '').link_operativo($valor);
	elseif ($instrumento) echo ($qnt++ ? '<br>' : '').link_instrumento($valor);
	elseif ($recurso) echo ($qnt++ ? '<br>' : '').link_recurso($valor);
	elseif ($problema) echo ($qnt++ ? '<br>' : '').link_problema_pro($valor);
	elseif ($demanda) echo ($qnt++ ? '<br>' : '').link_demanda($valor);
	elseif ($programa) echo ($qnt++ ? '<br>' : '').link_programa($valor);
	elseif ($licao) echo ($qnt++ ? '<br>' : '').link_licao($valor);
	elseif ($evento) echo ($qnt++ ? '<br>' : '').link_evento($valor);
	elseif ($link) echo ($qnt++ ? '<br>' : '').link_link($valor);
	elseif ($avaliacao) echo ($qnt++ ? '<br>' : '').link_avaliacao($valor);
	elseif ($tgn) echo ($qnt++ ? '<br>' : '').link_tgn($valor);
	elseif ($brainstorm) echo ($qnt++ ? '<br>' : '').link_brainstorm_pro($valor);
	elseif ($gut) echo ($qnt++ ? '<br>' : '').link_gut_pro($valor);
	elseif ($causa_efeito) echo ($qnt++ ? '<br>' : '').link_causa_efeito_pro($valor);
	elseif ($arquivo) echo ($qnt++ ? '<br>' : '').link_arquivo($valor);
	elseif ($forum) echo ($qnt++ ? '<br>' : '').link_forum($valor);
	elseif ($checklist) echo ($qnt++ ? '<br>' : '').link_checklist($valor);
	elseif ($agenda) echo ($qnt++ ? '<br>' : '').link_agenda($valor);
	elseif ($agrupamento) echo ($qnt++ ? '<br>' : '').link_agrupamento($valor);
	elseif ($patrocinador) echo ($qnt++ ? '<br>' : '').link_patrocinador($valor);
	elseif ($template) echo ($qnt++ ? '<br>' : '').link_template($valor);
	elseif ($painel) echo ($qnt++ ? '<br>' : '').link_painel($valor);
	elseif ($painel_odometro) echo ($qnt++ ? '<br>' : '').link_painel_odometro($valor);
	elseif ($painel_composicao) echo ($qnt++ ? '<br>' : '').link_painel_composicao($valor);
	elseif ($tr) echo ($qnt++ ? '<br>' : '').link_tr($valor);	
	elseif ($me) echo ($qnt++ ? '<br>' : '').link_me($valor);	



}

echo '</td></tr>';

echo '<tr><td align="right" nowrap="nowrap">'.dica('Ativo', 'Se o favorito se encontra ativo.').'Ativo:'.dicaF().'</td><td  class="realce" width="100%">'.($favorito['favorito_ativo'] ? 'Sim' : 'Não').'</td></tr>';

echo '</table>';

echo estiloFundoCaixa();	
	
echo '</form>';
?>

<script LANGUAGE="javascript">
function lista(favorito_id){
	document.getElementById('a').value='favoritos';
	document.env.submit();
	}
	
function inserir(){

	document.getElementById('a').value='favoritos_editar';
	document.getElementById('favorito_id').value=null;
	document.env.submit();
	}	

function editar(){
	document.getElementById('a').value='favoritos_editar';
	document.env.submit();
	}	


function excluir(){
	if (confirm( "Tem certeza que deseja excluir?" )){
		document.getElementById('del').value=1;
		document.getElementById('a').value='favoritos_fazer_sql';
		document.env.submit();
		}
	}	

function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}
</script>	