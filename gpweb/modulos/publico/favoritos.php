<?php  
/* Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/
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
$agenda=getParam($_REQUEST, 'agenda', 0);
$agrupamento=getParam($_REQUEST, 'agrupamento', 0);
$patrocinador=getParam($_REQUEST, 'patrocinador', 0);
$template=getParam($_REQUEST, 'template', 0);
$painel=getParam($_REQUEST, 'painel', 0);
$painel_odometro=getParam($_REQUEST, 'painel_odometro', 0);
$painel_composicao=getParam($_REQUEST, 'painel_composicao', 0);
$tr=getParam($_REQUEST, 'tr', 0);
$me=getParam($_REQUEST, 'me', 0);

$tipo=getParam($_REQUEST, 'tipo', '');


if (isset($_REQUEST['tab'])) $Aplic->setEstado('FavoritosListaTab', getParam($_REQUEST, 'tab', null));
$tab = ($Aplic->getEstado('FavoritosListaTab') !== null ? $Aplic->getEstado('FavoritosListaTab') : 0);

if (isset($_REQUEST['ver_subordinadas'])) $Aplic->setEstado('ver_subordinadas', getParam($_REQUEST, 'ver_subordinadas', null));
$ver_subordinadas = ($Aplic->getEstado('ver_subordinadas') !== null ? $Aplic->getEstado('ver_subordinadas') : (($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) ? $Aplic->usuario_prefs['ver_subordinadas'] : 0));

if (isset($_REQUEST['cia_id'])) $Aplic->setEstado('cia_id', getParam($_REQUEST, 'cia_id', null));
$cia_id = ($Aplic->getEstado('cia_id') !== null ? $Aplic->getEstado('cia_id') : $Aplic->usuario_cia);

if (isset($_REQUEST['dept_id'])) $Aplic->setEstado('dept_id', intval(getParam($_REQUEST, 'dept_id', 0)));
$dept_id = $Aplic->getEstado('dept_id') !== null ? $Aplic->getEstado('dept_id') : ($Aplic->usuario_pode_todos_depts ? null : $Aplic->usuario_dept);
if ($dept_id) $ver_subordinadas = null;

$painel_filtro = $Aplic->getEstado('painel_filtro') !== null ? $Aplic->getEstado('painel_filtro') : 0;

$lista_cias='';
if ($ver_subordinadas){
	$vetor_cias=array();
	lista_cias_subordinadas($cia_id, $vetor_cias);
	$vetor_cias[]=$cia_id;
	$lista_cias=implode(',',$vetor_cias);
	}

if (isset($_REQUEST['ver_dept_subordinados'])) $Aplic->setEstado('ver_dept_subordinados', getParam($_REQUEST, 'ver_dept_subordinados', null));
$ver_dept_subordinados = ($Aplic->getEstado('ver_dept_subordinados') !== null ? $Aplic->getEstado('ver_dept_subordinados') : (($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) ? $Aplic->usuario_prefs['ver_dept_subordinados'] : 0));
if ($ver_subordinadas) $ver_dept_subordinados=0;

$lista_depts='';
if ($ver_dept_subordinados){
	$vetor_depts=array();
	lista_depts_subordinados($dept_id, $vetor_depts);
	$vetor_depts[]=$dept_id;
	$lista_depts=implode(',',$vetor_depts);
	}


$sql = new BDConsulta;


$pagina = getParam($_REQUEST, 'pagina', 1);
$seta=array('0'=>'seta-cima.gif', '1'=>'seta-baixo.gif');

$xpg_tamanhoPagina = 30;
$xpg_min = $xpg_tamanhoPagina * ($pagina - 1); 

$ordenar = getParam($_REQUEST, 'ordenar', 'link_nome');
$ordem = getParam($_REQUEST, 'ordem', '0');
	
echo '<form method="POST" id="env" name="env">';
echo '<input type="hidden" id="a" name="a" value="favoritos">';
echo '<input type="hidden" id="m" name="m" value="publico">';	
echo '<input type="hidden" name="favorito_id" id="favorito_id" value="">';	

echo '<input type="hidden" name="ver_subordinadas" value="'.$ver_subordinadas.'" />';
echo '<input type="hidden" name="ver_dept_subordinados" value="'.$ver_dept_subordinados.'" />';

echo '<input type="hidden" name="projeto" id="projeto" value="'.$projeto.'">'; 
echo '<input type="hidden" name="tarefa" id="tarefa" value="'.$tarefa.'">'; 
echo '<input type="hidden" name="perspectiva" id="perspectiva" value="'.$perspectiva.'">'; 
echo '<input type="hidden" name="tema" id="tema" value="'.$tema.'">'; 
echo '<input type="hidden" name="objetivo" id="objetivo" value="'.$objetivo.'">'; 
echo '<input type="hidden" name="fator" id="fator" value="'.$fator.'">'; 
echo '<input type="hidden" name="estrategia" id="estrategia" value="'.$estrategia.'">'; 
echo '<input type="hidden" name="meta" id="meta" value="'.$meta.'">'; 
echo '<input type="hidden" name="pratica" id="pratica" value="'.$pratica.'">'; 
echo '<input type="hidden" name="indicador" id="indicador" value="'.$indicador.'">'; 
echo '<input type="hidden" name="acao" id="acao" value="'.$acao.'">'; 
echo '<input type="hidden" name="canvas" id="canvas" value="'.$canvas.'">'; 
echo '<input type="hidden" name="risco" id="risco" value="'.$risco.'">'; 
echo '<input type="hidden" name="risco_resposta" id="risco_resposta" value="'.$risco_resposta.'">'; 
echo '<input type="hidden" name="calendario" id="calendario" value="'.$calendario.'">'; 
echo '<input type="hidden" name="monitoramento" id="monitoramento" value="'.$monitoramento.'">'; 
echo '<input type="hidden" name="ata" id="ata" value="'.$ata.'">'; 
echo '<input type="hidden" name="mswot" id="mswot" value="'.$mswot.'">'; 
echo '<input type="hidden" name="swot" id="swot" value="'.$swot.'">'; 
echo '<input type="hidden" name="operativo" id="operativo" value="'.$operativo.'">'; 
echo '<input type="hidden" name="instrumento" id="instrumento" value="'.$instrumento.'">'; 
echo '<input type="hidden" name="recurso" id="recurso" value="'.$recurso.'">'; 
echo '<input type="hidden" name="problema" id="problema" value="'.$problema.'">'; 
echo '<input type="hidden" name="demanda" id="demanda" value="'.$demanda.'">'; 
echo '<input type="hidden" name="programa" id="programa" value="'.$programa.'">'; 
echo '<input type="hidden" name="licao" id="licao" value="'.$licao.'">'; 
echo '<input type="hidden" name="evento" id="evento" value="'.$evento.'">'; 
echo '<input type="hidden" name="link" id="link" value="'.$link.'">'; 
echo '<input type="hidden" name="avaliacao" id="avaliacao" value="'.$avaliacao.'">'; 
echo '<input type="hidden" name="tgn" id="tgn" value="'.$tgn.'">'; 
echo '<input type="hidden" name="brainstorm" id="brainstorm" value="'.$brainstorm.'">'; 
echo '<input type="hidden" name="gut" id="gut" value="'.$gut.'">'; 
echo '<input type="hidden" name="causa_efeito" id="causa_efeito" value="'.$causa_efeito.'">'; 
echo '<input type="hidden" name="arquivo" id="arquivo" value="'.$arquivo.'">'; 
echo '<input type="hidden" name="forum" id="forum" value="'.$forum.'">'; 
echo '<input type="hidden" name="checklist" id="checklist" value="'.$checklist.'">'; 
echo '<input type="hidden" name="agenda" id="agenda" value="'.$agenda.'">'; 
echo '<input type="hidden" name="agrupamento" id="agrupamento" value="'.$agrupamento.'">'; 
echo '<input type="hidden" name="patrocinador" id="patrocinador" value="'.$patrocinador.'">'; 
echo '<input type="hidden" name="template" id="template" value="'.$template.'">'; 
echo '<input type="hidden" name="painel" id="painel" value="'.$painel.'">'; 
echo '<input type="hidden" name="painel_odometro" id="painel_odometro" value="'.$painel_odometro.'">'; 
echo '<input type="hidden" name="painel_composicao" id="painel_composicao" value="'.$painel_composicao.'">'; 
echo '<input type="hidden" name="tr" id="tr" value="'.$tr.'">'; 
echo '<input type="hidden" name="me" id="me" value="'.$me.'">';



$sql->adTabela('favorito');
$sql->adCampo('favorito_id, favorito_nome');
$sql->adOnde('favorito_usuario='.$Aplic->usuario_id);
if ($projeto)$sql->adOnde('favorito_projeto=1');
if ($tarefa)$sql->adOnde('favorito_tarefa=1');
if ($perspectiva)$sql->adOnde('favorito_perspectiva=1');
if ($tema)$sql->adOnde('favorito_tema=1');
if ($objetivo)$sql->adOnde('favorito_objetivo=1');
if ($fator)$sql->adOnde('favorito_fator=1');
if ($estrategia)$sql->adOnde('favorito_estrategia=1');
if ($meta)$sql->adOnde('favorito_meta=1');
if ($pratica)$sql->adOnde('favorito_pratica=1');
if ($indicador)$sql->adOnde('favorito_indicador=1');
if ($acao)$sql->adOnde('favorito_acao=1');
if ($canvas)$sql->adOnde('favorito_canvas=1');
if ($risco)$sql->adOnde('favorito_risco=1');
if ($risco_resposta)$sql->adOnde('favorito_risco_resposta=1');
if ($calendario)$sql->adOnde('favorito_calendario=1');
if ($monitoramento)$sql->adOnde('favorito_monitoramento=1');
if ($ata)$sql->adOnde('favorito_ata=1');
if ($mswot)$sql->adOnde('favorito_mswot=1');
if ($swot)$sql->adOnde('favorito_swot=1');
if ($operativo)$sql->adOnde('favorito_operativo=1');
if ($instrumento)$sql->adOnde('favorito_instrumento=1');
if ($recurso)$sql->adOnde('favorito_recurso=1');
if ($problema)$sql->adOnde('favorito_problema=1');
if ($demanda)$sql->adOnde('favorito_demanda=1');
if ($programa)$sql->adOnde('favorito_programa=1');
if ($licao)$sql->adOnde('favorito_licao=1');
if ($evento)$sql->adOnde('favorito_evento=1');
if ($link)$sql->adOnde('favorito_link=1');
if ($avaliacao)$sql->adOnde('favorito_avaliacao=1');
if ($tgn)$sql->adOnde('favorito_tgn=1');
if ($brainstorm)$sql->adOnde('favorito_brainstorm=1');
if ($gut)$sql->adOnde('favorito_gut=1');
if ($causa_efeito)$sql->adOnde('favorito_causa_efeito=1');
if ($arquivo)$sql->adOnde('favorito_arquivo=1');
if ($forum)$sql->adOnde('favorito_forum=1');
if ($checklist)$sql->adOnde('favorito_checklist=1');
if ($agenda)$sql->adOnde('favorito_agenda=1');
if ($agrupamento)$sql->adOnde('favorito_agrupamento=1');
if ($patrocinador)$sql->adOnde('favorito_patrocinador=1');
if ($template)$sql->adOnde('favorito_template=1');
if ($painel)$sql->adOnde('favorito_painel=1');
if ($painel_odometro)$sql->adOnde('favorito_painel_odometro=1');
if ($painel_composicao)$sql->adOnde('favorito_painel_composicao=1');
if ($tr)$sql->adOnde('favorito_tr=1');
if ($me)$sql->adOnde('favorito_me=1');

if ($tab==0) $sql->adOnde('favorito_ativo=1');
elseif ($tab==1) $sql->adOnde('favorito_ativo=0');

$linhas = $sql->Lista();
$sql->limpar();


if($projeto){
	$tipo='projeto';
	$saida='m=projetos&a=index';
	$objeto='projeto='.$projeto;
	}
elseif($tarefa){
	$tipo='tarefa';
	$saida='m=tarefas&a=index';
	$objeto='tarefa='.$tarefa;
	}
elseif($perspectiva){
	$tipo='perspectiva';
	$saida='m=praticas&a=perspectiva_lista';
	$objeto='perspectiva='.$perspectiva;
	}
elseif($tema){
	$tipo='tema';
	$saida='m=praticas&a=tema_lista';
	$objeto='tema='.$tema;
	}
elseif($objetivo){
	$tipo='objetivo';
	$saida='m=praticas&a=obj_estrategico_lista';
	$objeto='objetivo='.$objetivo;
	}
elseif($fator){
	$tipo='fator';
	$saida='m=praticas&a=fator_lista';
	$objeto='fator='.$fator;
	}
elseif($estrategia){
	$tipo='estrategia';
	$saida='m=praticas&a=estrategia_lista';
	$objeto='estrategia='.$estrategia;
	}
elseif($meta){
	$tipo='meta';
	$saida='m=praticas&a=meta_lista';
	$objeto='meta='.$meta;
	}
elseif($pratica){
	$tipo='pratica';
	$saida='m=praticas&a=pratica_lista';
	$objeto='pratica='.$pratica;
	}
elseif($indicador){
	$tipo='indicador';
	$saida='m=praticas&a=indicador_lista';
	$objeto='indicador='.$indicador;
	}
elseif($acao){
	$tipo='acao';
	$saida='m=praticas&a=plano_acao_lista';
	$objeto='acao='.$acao;
	}
elseif($canvas){
	$tipo='canvas';
	$saida='m=praticas&a=canvas_pro_lista';
	$objeto='canvas='.$canvas;
	}
elseif($risco){
	$tipo='risco';
	$saida='m=praticas&a=risco_pro_lista';
	$objeto='risco='.$risco;
	}
elseif($risco_resposta){
	$tipo='risco_resposta';
	$saida='m=praticas&a=risco_resposta_pro_lista';
	$objeto='risco_resposta='.$risco_resposta;
	}
elseif($calendario){
	$tipo='calendario';
	$saida='m=praticas&a=XXX_lista';
	$objeto='calendario='.$calendario;
	}
elseif($monitoramento){
	$tipo='monitoramento';
	$saida='m=praticas&a=monitoramento_lista_pro';
	$objeto='monitoramento='.$monitoramento;
	}
elseif($ata){
	$tipo='ata';
	$saida='m=atas&a=ata_lista';
	$objeto='ata='.$ata;
	}
elseif($mswot){
	$tipo='mswot';
	$saida='m=swot&a=mswot_lista';
	$objeto='mswot='.$mswot;
	}
elseif($swot){
	$tipo='swot';
	$saida='m=swot&a=swot_lista';
	$objeto='swot='.$swot;
	}
elseif($operativo){
	$tipo='operativo';
	$saida='m=operativo&a=operativo_lista';
	$objeto='operativo='.$operativo;
	}
elseif($instrumento){
	$tipo='instrumento';
	$saida='m=instrumento&a=instrumento_lista';
	$objeto='instrumento='.$instrumento;
	}
elseif($recurso){
	$tipo='recurso';
	$saida='m=recursos&a=index';
	$objeto='recurso='.$recurso;
	}
elseif($problema){
	$tipo='problema';
	$saida='m=problema&a=problema_lista';
	$objeto='problema='.$problema;
	}
elseif($demanda){
	$tipo='demanda';
	$saida='m=projetos&a=demanda_lista';
	$objeto='demanda='.$demanda;
	}
elseif($programa){
	$tipo='programa';
	$saida='m=projetos&a=programa_pro_lista';
	$objeto='programa='.$programa;
	}
elseif($licao){
	$tipo='licao';
	$saida='m=projetos&a=licao_lista';
	$objeto='licao='.$licao;
	}
elseif($evento){
	$tipo='evento';
	$saida='m=calendario&a=evento_lista_pro';
	$objeto='evento='.$evento;
	}
elseif($link){
	$tipo='link';
	$saida='m=links&a=index';
	$objeto='link='.$link;
	}
elseif($avaliacao){
	$tipo='avaliacao';
	$saida='m=praticas&a=avaliacao_lista';
	$objeto='avaliacao='.$avaliacao;
	}
elseif($tgn){
	$tipo='tgn';
	$saida='m=praticas&a=tgn_pro_lista';
	$objeto='tgn='.$tgn;
	}
elseif($brainstorm){
	$tipo='brainstorm';
	$saida='m=praticas&a=brainstorm_pro_lista';
	$objeto='brainstorm='.$brainstorm;
	}
elseif($gut){
	$tipo='gut';
	$saida='m=praticas&a=gut_pro_lista';
	$objeto='gut='.$gut;
	}
elseif($causa_efeito){
	$tipo='causa_efeito';
	$saida='m=praticas&a=causa_efeito_pro_lista';
	$objeto='causa_efeito='.$causa_efeito;
	}
elseif($arquivo){
	$tipo='arquivo';
	$saida='m=arquivos&a=index';
	$objeto='arquivo='.$arquivo;
	}
elseif($forum){
	$tipo='forum';
	$saida='m=foruns&a=index';
	$objeto='forum='.$forum;
	}
elseif($checklist){
	$tipo='checklist';
	$saida='m=praticas&a=checklist_lista';
	$objeto='checklist='.$checklist;
	}
elseif($agenda){
	$tipo='agenda';
	$saida='m=email&a=ver_mes';
	$objeto='agenda='.$agenda;
	}
elseif($agrupamento){
	$tipo='agrupamento';
	$saida='m=agrupamento&a=agrupamento_lista';
	$objeto='agrupamento='.$agrupamento;
	}
elseif($patrocinador){
	$tipo='patrocinador';
	$saida='m=patrocinadores&a=index';
	$objeto='patrocinador='.$patrocinador;
	}
elseif($template){
	$tipo='template';
	$saida='m=projetos&a=template_pro_lista';
	$objeto='template='.$template;
	}
elseif($painel){
	$tipo='painel';
	$saida='m=praticas&a=painel_pro_lista';
	$objeto='painel='.$painel;
	}
elseif($painel_odometro){
	$tipo='painel_odometro';
	$saida='m=praticas&a=odometro_pro_lista';
	$objeto='painel_odometro='.$painel_odometro;
	}
elseif($painel_composicao){
	$tipo='painel_composicao';
	$saida='m=praticas&a=painel_composicao_pro_lista';
	$objeto='painel_composicao='.$painel_composicao;
	}
elseif($tr){
	$tipo='tr';
	$saida='m=tr&a=tr_lista';
	$objeto='tr='.$tr;
	}
elseif($me){
	$tipo='me';
	$saida='m=praticas&a=me_lista_pro';
	$objeto='me='.$me;
	}



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



$tipos=array(
'projeto' => ucfirst($config['projetos']), 
'tarefa' => ucfirst($config['tarefas']), 
'perspectiva' => ucfirst($config['perspectivas']), 
'tema' => ucfirst($config['temas']), 
'objetivo' => ucfirst($config['objetivos']), 
'fator' => ucfirst($config['fatores']), 
'estrategia' => ucfirst($config['iniciativas']), 
'meta' => ucfirst($config['metas']), 
'pratica' => ucfirst($config['praticas']), 
'indicador' => 'Indicadores', 
'acao' => ucfirst($config['acoes']), 
'canvas' => ucfirst($config['canvass']), 
'risco' => ucfirst($config['riscos']), 
'risco_resposta' => ucfirst($config['risco_respostas']), 
'calendario' => 'Agendas', 
'monitoramento' => 'Monitoramentos',  
'recurso' => ucfirst($config['recursos']), 
'demanda' => 'Demandas', 
'programa' => ucfirst($config['programas']), 
'licao' => ucfirst($config['licoes']), 
'evento' => 'Eventos', 
'link' => 'Links', 
'avaliacao' => 'Avaliações', 
'tgn' => ucfirst($config['tgns']), 
'brainstorm' => 'Brainstorms', 
'gut' => 'G.U.T.s', 
'causa_efeito' => 'Diagramas de Causa-Efeito', 
'arquivo' => 'Arquivos', 
'forum' => 'Fóruns', 
'checklist' => 'Checklists', 
'agenda' => 'Compromissos', 
'template' => 'Modelos', 
'painel' => 'Painéis de Indicador', 
'painel_odometro' => 'Odômetros', 
'painel_composicao' => 'Composições de Painéis'
);

if ($Aplic->modulo_ativo('atas')) $tipos['ata']='Atas de Reunião';
if ($Aplic->modulo_ativo('swot')) {
	$tipos['mswot']='Matrizes SWOT';
	$tipos['swot']='Campos SWOT';
	}
if ($Aplic->modulo_ativo('operativo')) $tipos['operativo']='Planos Operativos';
if ($Aplic->modulo_ativo('instrumento')) $tipos['instrumento']=ucfirst($config['instrumentos']);
if ($Aplic->modulo_ativo('problema')) $tipos['problema']=ucfirst($config['problemas']);
if ($Aplic->modulo_ativo('agrupamento')) $tipos['agrupamento']='Agrupamentos';
if ($Aplic->modulo_ativo('patrocinadores')) $tipos['patrocinador']='Patrocinadores';
if ($Aplic->modulo_ativo('tr')) $tipos['tr']=ucfirst($config['trs']);
if (isset($config['exibe_me']) && $config['exibe_me']) $tipos['me']=ucfirst($config['mes']);	

asort($tipos);




$Aplic->salvarPosicao();	
$botoesTitulo = new CBlocoTitulo('Lista de Favoritos de '.$titulo, 'favoritos.png', $m, $m.'.'.$a);
$botoesTitulo->adicionaBotao($saida, 'retornar','','Retornar','Voltar à tela anterior.');
$saida2='<div id="filtro_container" style="border: 1px solid #'.($estilo_interface=='metro' ? '006fc2' : 'a6a6a6').'; margin-bottom: 2px; -webkit-border-radius: 4px; border-radius:4px; -moz-border-radius: 4px;">';
$saida2.=dica('Filtros e Ações','Clique nesta barra para esconder/mostrar os filtros e as ações permitidas.').'<div id="filtro_titulo" style="background-color: #'.($estilo_interface=='metro' ? '006fc2' : 'a6a6a6').'; font-size: 8pt; font-weight: bold;" onclick="$jq(\'#filtro_content\').toggle(); xajax_painel_filtro(document.getElementById(\'filtro_content\').style.display);"><a class="aba" href="javascript:void(0);">'.imagem('icones/favorito_p.png').'&nbsp;Filtros e Ações</a></div>'.dicaF();
$saida2.='<div id="filtro_content" style="display:'.($painel_filtro ? '' : 'none').'">';
$saida2.='<table cellspacing=0 cellpadding=0>';
$vazio='<tr><td colspan=2>&nbsp;</td></tr>';

$procurar_om='<tr><td align=right>'.dica('Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'], 'Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].'.').ucfirst($config['organizacao']).':'.dicaF().'</td><td><div id="combo_cia">'.selecionar_om($cia_id, 'cia_id', 'class=texto size=1 style="width:250px;" onchange="javascript:mudar_om();"').'</div></td><td><a href="javascript:void(0);" onclick="document.env.submit();">'.imagem('icones/filtrar_p.png','Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'],'Clique neste ícone '.imagem('icones/filtrar_p.png').' para filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].' a esquerda.').'</a></td>'.(($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) && !$ver_subordinadas ? '<td><a href="javascript:void(0);" onclick="document.env.ver_subordinadas.value=1; document.env.dept_id.value=\'\';  document.env.ver_dept_subordinados.value=0; document.env.submit();">'.imagem('icones/organizacao_p.gif','Incluir Subordinad'.$config['genero_organizacao'].'s','Clique neste ícone '.imagem('icones/organizacao_p.gif').' para incluir '.$config['genero_organizacao'].'s '.$config['organizacoes'].' subordinad'.$config['genero_organizacao'].'s '.($config['genero_organizacao']=='a' ? 'à' : 'ao').' selecionad'.$config['genero_organizacao'].'.').'</a></td>' : '').(($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) && $ver_subordinadas ? '<td><a href="javascript:void(0);" onclick="document.env.ver_subordinadas.value=0; document.env.submit();">'.imagem('icones/nao_sub_om.gif','Não Incluir Subordinad'.$config['genero_organizacao'].'s','Clique neste ícone '.imagem('icones/nao_sub_om.gif').' para deixar de incluir '.$config['genero_organizacao'].'s '.$config['organizacoes'].' subordinad'.$config['genero_organizacao'].'s '.($config['genero_organizacao']=='a' ? 'à' : 'ao').' selecionad'.$config['genero_organizacao'].'.').'</a></td>' : '').($Aplic->profissional ? '<td><input type="hidden" name="dept_id" id="dept_id" value="'.$dept_id.'" />'.(!$dept_id ? '<a href="javascript:void(0);" onclick="escolher_dept();">'.imagem('icones/secoes_p.gif',ucfirst($config['departamento']),'Clique neste ícone '.imagem('icones/secoes_p.gif').' para filtrar pel'.$config['genero_dept'].' '.$config['departamento'].' envolvid'.$config['genero_dept'].' ou don'.$config['genero_dept'].'.').'</a>' : '').'</td>' : '').'</tr>'.
($dept_id ? '<tr><td align=right>'.dica(ucfirst($config['departamento']), 'Filtrar pel'.$config['genero_dept'].' '.strtolower($config['departamento']).' envolvid'.$config['genero_dept'].'.').ucfirst($config['departamento']).':</td><td><input type="text" style="width:250px;" class="texto" name="dept_nome" id="dept_nome" value="'.nome_dept($dept_id).'"></td>'.($dept_id ? '<td><a href="javascript:void(0);" onclick="escolher_dept();">'.imagem('icones/secoes_p.gif',ucfirst($config['departamento']),'Clique neste ícone '.imagem('icones/secoes_p.gif').' para filtrar pel'.$config['genero_dept'].' '.$config['departamento'].' envolvid'.$config['genero_dept'].' ou don'.$config['genero_dept'].'.').'</a></td>'.(($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) && !$ver_dept_subordinados ? '<td><a href="javascript:void(0);" onclick="document.env.ver_dept_subordinados.value=1; document.env.submit();">'.imagem('icones/organizacao_p.gif','Incluir Subordinad'.$config['genero_dept'].'s','Clique neste ícone '.imagem('icones/organizacao_p.gif').' para incluir '.$config['genero_dept'].'s '.$config['departamentos'].' subordinad'.$config['genero_dept'].'s '.($config['genero_dept']=='a' ? 'à' : 'ao').' selecionad'.$config['genero_dept'].'.').'</a></td>' : '').(($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) && $ver_dept_subordinados ? '<td><a href="javascript:void(0);" onclick="document.env.ver_dept_subordinados.value=0; document.env.submit();">'.imagem('icones/nao_sub_om.gif','Não Incluir Subordinad'.$config['genero_dept'].'s','Clique neste ícone '.imagem('icones/nao_sub_om.gif').' para deixar de incluir '.$config['genero_dept'].'s '.$config['departamentos'].' subordinad'.$config['genero_dept'].'s '.($config['genero_dept']=='a' ? 'à' : 'ao').' selecionad'.$config['genero_dept'].'.').'</a></td>' : '') : '').'</tr>' : '');

$popFiltro='<tr><td align="right" nowrap="nowrap">'.dica('Módulo','A qual módulo deseja ver os favoritos cadastrados.').'Módulo:'.dicaF().'</td><td align="left">'.selecionaVetor($tipos, 'tipo', 'style="width:250px;" class="texto" onchange="mudar_tipo(this.value)"', $tipo).'</td></tr>';

$novo_favorito='<tr><td nowrap="nowrap">'.dica('Novo Favorito', 'Criar um novo favorito.').'<a href="javascript: void(0)" onclick="adicionar(0);" ><img src="'.acharImagem('favorito_novo.png').'" border=0 width="16" heigth="16" /></a>'.dicaF().'</td></tr>';

$saida2.='<tr><td><table cellspacing=0 cellpadding=0>'.$procurar_om.$popFiltro.'</table></td><td><table cellspacing=0 cellpadding=0>'.$novo_favorito.'</table></td></tr></table>';
$saida2.= '</div></div>';
$botoesTitulo->adicionaCelula($saida2);



$botoesTitulo->mostrar();


if (!$dialogo){
	$caixaTab = new CTabBox('m='.$m.'&a='.$a.'&'.$objeto, '', $tab);
	$caixaTab->adicionar(BASE_DIR.'/modulos/publico/favoritos_tabela','Ativos',null,null,'Ativos','Visualizar os favoritos ativos.');
	$caixaTab->adicionar(BASE_DIR.'/modulos/publico/favoritos_tabela','Inativos',null,null,'Inativos','Visualizar os favoritos inativos.');
	$caixaTab->adicionar(BASE_DIR.'/modulos/publico/favoritos_tabela','Todos',null,null,'Todos','Visualizar todos os favoritos.');
	$caixaTab->mostrar('','','','',true);
	echo estiloFundoCaixa('','', $tab);
	}


echo '</form>';
?>

<script LANGUAGE="javascript">

function adicionar(favorito_id){
	document.getElementById('a').value='favoritos_editar';
	document.getElementById('favorito_id').value=favorito_id;
	document.env.submit();
	}

function visualizar(favorito_id){
	document.getElementById('a').value='favoritos_ver';
	document.getElementById('favorito_id').value=favorito_id;
	document.env.submit();
	}


function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}

function escolher_dept(){
	if (window.parent.gpwebApp) parent.gpwebApp.popUp('<?php echo ucfirst($config["departamento"])?>', 500, 500, 'm=publico&a=selecao_unico_dept&dialogo=1&chamar_volta=filtrar_dept&dept_id=<?php echo $dept_id ?>&cia_id='+document.getElementById('cia_id').value, window.filtrar_dept, window);
	else window.open('./index.php?m=publico&a=selecao_unico_dept&dialogo=1&chamar_volta=filtrar_dept&dept_id=<?php echo $dept_id ?>&cia_id='+document.getElementById('cia_id').value, 'Filtrar','height=500,width=500,resizable,scrollbars=yes, left=0, top=0');
	}

function filtrar_dept(cia_id, dept_id){
	document.getElementById('cia_id').value=cia_id;
	document.getElementById('dept_id').value=dept_id;
	env.submit();
	}

function mudar_om(){
	xajax_selecionar_om_ajax(document.getElementById('cia_id').value,'cia_id','combo_cia', 'class="texto" size=1 style="width:250px;" onchange="javascript:mudar_om();"');
	}
	
function mudar_tipo(tipo){
	limpar();
	document.getElementById(tipo).value=1;
	env.submit();
	}	

function limpar(){
	env.projeto.value=null;
	env.tarefa.value=null;
	env.perspectiva.value=null;
	env.tema.value=null;
	env.objetivo.value=null;
	env.fator.value=null;
	env.estrategia.value=null;
	env.meta.value=null;
	env.pratica.value=null;
	env.indicador.value=null;
	env.acao.value=null;
	env.canvas.value=null;
	env.risco.value=null;
	env.risco_resposta.value=null;
	env.calendario.value=null;
	env.monitoramento.value=null;
	env.ata.value=null;
	env.mswot.value=null;
	env.swot.value=null;
	env.operativo.value=null;
	env.instrumento.value=null;
	env.recurso.value=null;
	env.problema.value=null;
	env.demanda.value=null;
	env.programa.value=null;
	env.licao.value=null;
	env.evento.value=null;
	env.link.value=null;
	env.avaliacao.value=null;
	env.tgn.value=null;
	env.brainstorm.value=null;
	env.gut.value=null;
	env.causa_efeito.value=null;
	env.arquivo.value=null;
	env.forum.value=null;
	env.checklist.value=null;
	env.agenda.value=null;
	env.agrupamento.value=null;
	env.patrocinador.value=null;
	env.template.value=null;
	env.painel.value=null;
	env.painel_odometro.value=null;
	env.painel_composicao.value=null;
	env.tr.value=null;
	env.me.value=null;
	}
	

</script>