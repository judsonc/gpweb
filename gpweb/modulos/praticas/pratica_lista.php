<?php
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*/

if (!defined('BASE_DIR')) die('Voc� n�o deveria acessar este arquivo diretamente.');

$sql = new BDConsulta;

$painel_filtro = $Aplic->getEstado('painel_filtro') !== null ? $Aplic->getEstado('painel_filtro') : 0;

if (isset($_REQUEST['filtro_prioridade_pratica']))	$Aplic->setEstado('filtro_prioridade_pratica', getParam($_REQUEST, 'filtro_prioridade_pratica', null));
$filtro_prioridade_pratica = $Aplic->getEstado('filtro_prioridade_pratica') !== null ? $Aplic->getEstado('filtro_prioridade_pratica') : null;

$houve_filtro=getParam($_REQUEST, 'houve_filtro', null);
$sql->adTabela('favorito_trava');
$sql->adCampo('favorito_trava_campo');
$sql->adOnde('favorito_trava_pratica=1');
$sql->adOnde('favorito_trava_usuario='.(int)$Aplic->usuario_id);
$favorito_trava_campo=$sql->Resultado();
$sql->limpar();
if (!$houve_filtro && $favorito_trava_campo) {
	$vetor_filtro=explode('&', $favorito_trava_campo);
	foreach($vetor_filtro as $valor){
		$resultado=explode('=', $valor);
		if (isset($resultado[0]) && isset($resultado[1])) $_REQUEST[$resultado[0]]=$resultado[1];
		}
	}

if (isset($_REQUEST['tab'])) $Aplic->setEstado('ListaTabPratica', getParam($_REQUEST, 'tab', null));
$tab = ($Aplic->getEstado('ListaTabPratica') !== null ? $Aplic->getEstado('ListaTabPratica') : 0);

if (isset($_REQUEST['favorito_id'])) $Aplic->setEstado('pratica_favorito', getParam($_REQUEST, 'favorito_id', null));
$favorito_id = $Aplic->getEstado('pratica_favorito') !== null ? $Aplic->getEstado('pratica_favorito') : 0;

if (isset($_REQUEST['praticatextobusca'])) $Aplic->setEstado('praticatextobusca', getParam($_REQUEST, 'praticatextobusca', null));
$pesquisar_texto = ($Aplic->getEstado('praticatextobusca') ? $Aplic->getEstado('praticatextobusca') : '');

if (isset($_REQUEST['pratica_modelo_id'])) $Aplic->setEstado('pratica_modelo_id', getParam($_REQUEST, 'pratica_modelo_id', null));
$pratica_modelo_id = ($Aplic->getEstado('pratica_modelo_id') !== null ? $Aplic->getEstado('pratica_modelo_id') : null);

if (isset($_REQUEST['cia_id'])) $Aplic->setEstado('cia_id', getParam($_REQUEST, 'cia_id', null));
$cia_id = ($Aplic->getEstado('cia_id') !== null ? $Aplic->getEstado('cia_id') : $Aplic->usuario_cia);

if (isset($_REQUEST['dept_id'])) $Aplic->setEstado('dept_id', intval(getParam($_REQUEST, 'dept_id', 0)));
$dept_id = $Aplic->getEstado('dept_id') !== null ? $Aplic->getEstado('dept_id') : ($Aplic->usuario_pode_todos_depts ? null : $Aplic->usuario_dept);

if (isset($_REQUEST['usuario_id'])) $Aplic->setEstado('usuario_id', getParam($_REQUEST, 'usuario_id', null));
$usuario_id = $Aplic->getEstado('usuario_id') !== null ? $Aplic->getEstado('usuario_id') : null;

if (isset($_REQUEST['ver_subordinadas'])) $Aplic->setEstado('ver_subordinadas', getParam($_REQUEST, 'ver_subordinadas', null));
$ver_subordinadas = ($Aplic->getEstado('ver_subordinadas') !== null ? $Aplic->getEstado('ver_subordinadas') : (($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) ? $Aplic->usuario_prefs['ver_subordinadas'] : 0));
if ($dept_id) $ver_subordinadas = null;

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

$criterio=getParam($_REQUEST, 'criterio',0);
$item=getParam($_REQUEST, 'item',0);
$ordenar = getParam($_REQUEST, 'ordenar', 'pratica_nome');
$ordem = getParam($_REQUEST, 'ordem', '0');

$sql = new BDConsulta();


$sql->adTabela('pratica_modelo');
$sql->adCampo('pratica_modelo_id, pratica_modelo_nome');
$sql->adOrdem('pratica_modelo_ordem');
$modelos=array(''=>'')+$sql->ListaChave();
$sql->limpar();


$sql->adTabela('favorito');
$sql->adCampo('favorito_id, favorito_nome');
$sql->adOnde('favorito_geral!=1');
$sql->adOnde('favorito_ativo=1');
$sql->adOnde('favorito_pratica=1');
$sql->adOnde('favorito_usuario='.(int)$Aplic->usuario_id);
$vetor_favoritos=$sql->ListaChave();
$sql->limpar();

$sql->adTabela('favorito');
$sql->esqUnir('favorito_usuario', 'favorito_usuario', 'favorito_usuario_favorito= favorito.favorito_id');
if ($dept_id && !$lista_depts) {
	$sql->esqUnir('favorito_dept','favorito_dept', 'favorito_dept_favorito=favorito.favorito_id');
	$sql->adOnde('favorito_dept='.(int)$dept_id.' OR favorito_dept_dept='.(int)$dept_id.' OR favorito_usuario_usuario = '.(int)$Aplic->usuario_id.' OR favorito_usuario='.(int)$Aplic->usuario_id);
	}
elseif ($lista_depts) {
	$sql->esqUnir('favorito_dept','favorito_dept', 'favorito_dept_favorito=favorito.favorito_id');
	$sql->adOnde('favorito_dept IN ('.$lista_depts.') OR favorito_dept_dept IN ('.$lista_depts.') OR favorito_usuario_usuario = '.(int)$Aplic->usuario_id.' OR favorito_usuario='.(int)$Aplic->usuario_id);
	}	
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('favorito_cia', 'favorito_cia', 'favorito.favorito_id=favorito_cia_favorito');
	$sql->adOnde('favorito_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR favorito_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR favorito_usuario_usuario = '.(int)$Aplic->usuario_id.' OR favorito_usuario='.(int)$Aplic->usuario_id);
	}		
elseif ($cia_id && !$lista_cias) $sql->adOnde('favorito_cia='.(int)$cia_id.' OR favorito_usuario_usuario = '.(int)$Aplic->usuario_id.' OR favorito_usuario='.(int)$Aplic->usuario_id);
elseif ($lista_cias) $sql->adOnde('favorito_cia IN ('.$lista_cias.') OR favorito_usuario_usuario = '.(int)$Aplic->usuario_id.' OR favorito_usuario='.(int)$Aplic->usuario_id);
$sql->adOnde('favorito_acesso=1');
$sql->adOnde('favorito_geral=1');
$sql->adOnde('favorito_ativo=1');
$sql->adOnde('favorito_pratica=1');
$sql->adCampo('favorito_id, favorito_nome');
$vetor_favoritos1=$sql->ListaChave();
$sql->limpar();

$sql->adTabela('favorito');
$sql->esqUnir('favorito_usuario', 'favorito_usuario', 'favorito_usuario_favorito= favorito.favorito_id');
$sql->adOnde('favorito_usuario_usuario = '.(int)$Aplic->usuario_id.' OR favorito_usuario='.(int)$Aplic->usuario_id);
$sql->adOnde('favorito_acesso=2');
$sql->adOnde('favorito_geral=1');
$sql->adOnde('favorito_ativo=1');
$sql->adOnde('favorito_pratica=1');
$sql->adCampo('favorito_id, favorito_nome');
$vetor_favoritos2=$sql->ListaChave();
$sql->limpar();

$vetor_favoritos=$vetor_favoritos+$vetor_favoritos1+$vetor_favoritos2;

$favoritos='';
if (count($vetor_favoritos)) {
	$vetor_favoritos[0]='';
	if (!isset($vetor_favoritos[(int)$favorito_id])) $favorito_id=0;
	$favoritos='<tr><td align="right" nowrap="nowrap">'.dica('Favorito', 'Escolha um favorito.').'Favorito:'.dicaF().'</td><td width="100%" colspan="2">'.selecionaVetor($vetor_favoritos, 'favorito_id', 'class="texto" style="width:250px;" onchange="document.env.submit()"', $favorito_id).'</td></tr>';
	}
else $favorito_id=null;


$sql->adTabela('pratica_requisito');
$sql->esqUnir('praticas','praticas', 'praticas.pratica_id=pratica_requisito.pratica_id');
$sql->adCampo('DISTINCT ano');
if ($favorito_id){
	$sql->internoUnir('favorito_lista', 'favorito_lista', 'praticas.pratica_id=favorito_lista_campo');
	$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
	$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
	}
elseif ($Aplic->profissional && ($dept_id || $lista_depts)) {
	$sql->esqUnir('pratica_depts', 'pratica_depts', 'pratica_depts.pratica_id=praticas.pratica_id');
	$sql->adOnde('pratica_dept IN ('.($lista_depts ? $lista_depts  : $dept_id).') OR pratica_depts.dept_id IN ('.($lista_depts ? $lista_depts  : $dept_id).')');
	}
elseif (!$Aplic->profissional && ($dept_id || $lista_depts)) {
	$sql->adOnde('pratica_dept IN ('.($lista_depts ? $lista_depts  : $dept_id).')');
	}
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('pratica_cia', 'pratica_cia', 'praticas.pratica_id=pratica_cia_pratica');
	$sql->adOnde('pratica_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR pratica_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
	}
elseif ($cia_id && !$lista_cias) $sql->adOnde('pratica_cia='.(int)$cia_id);
elseif ($cia_id && $lista_cias) $sql->adOnde('pratica_cia IN ('.$lista_cias.')');
if ($usuario_id) {
	$sql->esqUnir('pratica_usuarios', 'pratica_usuarios', 'pratica_usuarios.pratica_id = praticas.pratica_id');
	$sql->adOnde('pratica_responsavel = '.(int)$usuario_id.' OR pratica_usuarios.usuario_id='.(int)$usuario_id);
	}
$sql->adOrdem('ano');
$anos=$sql->listaVetorChave('ano','ano');
$sql->limpar();

$ultimo_ano=$anos;
$ultimo_ano=array_pop($ultimo_ano);

if (isset($_REQUEST['IdxPraticaAno'])) $Aplic->setEstado('IdxPraticaAno', getParam($_REQUEST, 'IdxPraticaAno', null));
$ano = ($Aplic->getEstado('IdxPraticaAno') !== null && isset($anos[$Aplic->getEstado('IdxPraticaAno')])? $Aplic->getEstado('IdxPraticaAno') : $ultimo_ano);

if (!isset($anos[$ano])) $ano=null;


if (!$dialogo && $Aplic->profissional){
	$Aplic->salvarPosicao();
	echo '<form name="env" id="env" method="post">';
	echo '<input type="hidden" name="m" value="'.$m.'" />';
	echo '<input type="hidden" name="a" value="'.$a.'" />';
	echo '<input type="hidden" name="u" value="" />';
	echo '<input type="hidden" name="dept_id" value="" />';
	echo '<input type="hidden" name="cia_dept" value="" />';
	echo '<input type="hidden" name="ver_subordinadas" value="'.$ver_subordinadas.'" />';
	echo '<input type="hidden" name="ver_dept_subordinados" value="'.$ver_dept_subordinados.'" />';
	echo '<input type="hidden" name="filtro_prioridade_pratica" id="filtro_prioridade_pratica" value="'.$filtro_prioridade_pratica.'" />';
	echo '<input type="hidden" name="houve_filtro" id="houve_filtro" value="1" />';
	
	$botoesTitulo = new CBlocoTitulo('Lista de '.ucfirst($config['praticas']), 'pratica.gif', $m, $m.'.'.$a);

	$saida='<div id="filtro_container" style="border: 1px solid #'.($estilo_interface=='metro' ? '006fc2' : 'a6a6a6').'; margin-bottom: 2px; -webkit-border-radius: 4px; border-radius:4px; -moz-border-radius: 4px;">';
  $saida.=dica('Filtros e A��es','Clique nesta barra para esconder/mostrar os filtros e as a��es permitidas.').'<div id="filtro_titulo" style="background-color: #'.($estilo_interface=='metro' ? '006fc2' : 'a6a6a6').'; font-size: 8pt; font-weight: bold;" onclick="$jq(\'#filtro_content\').toggle(); xajax_painel_filtro(document.getElementById(\'filtro_content\').style.display);"><a class="aba" href="javascript:void(0);">'.imagem('icones/pratica_p.gif').'&nbsp;Filtros e A��es</a></div>'.dicaF();
  $saida.='<div id="filtro_content" style="display:'.($painel_filtro ? '' : 'none').'">';
  $saida.='<table cellspacing=0 cellpadding=0>';
	$vazio='<tr><td colspan=2>&nbsp;</td></tr>';

	$filtro_pontuacao='<tr><td nowrap="nowrap" align="right">'.dica('Sele��o de Pauta de Pontua��o', 'Utilize esta op��o para filtrar '.$config['genero_marcador'].'s '.$config['marcadores'].' pela pauta de pontua��o de sua prefer�ncia.').'Pauta:'.dicaF().'</td><td nowrap="nowrap" align="left">'.selecionaVetor($modelos, 'pratica_modelo_id', 'onchange="document.env.submit()" class="texto" style="width:250px;"', $pratica_modelo_id).'</td></tr>';
	$procuraBuffer = '<tr><td nowrap="nowrap" align="right">'.dica('Pesquisa', 'Pesquisar pelo nome e campos de descri��o').'Pesquisar:'.dicaF().'</td><td><input type="text" class="texto" style="width:250px;" name="praticatextobusca" onChange="document.env.submit();" value="'.$pesquisar_texto.'"/></td><td><a href="javascript:void(0);" onclick="url_passar(0, \'m=praticas&a=pratica_lista&praticatextobusca=\');">'.imagem('icones/limpar_p.gif','Limpar Pesquisa', 'Clique neste �cone '.imagem('icones/limpar_p.gif').' para limpar a caixa texto de pesquisa.').'</a></td></tr>';
	$procurar_ano='<tr><td align=right>'.dica('Sele��o do Ano', 'Utilize esta op��o para filtrar '.$config['genero_pratica'].' '.$config['pratica'].' pelo ano em que '.$config['genero_pratica'].' mesm'.$config['genero_pratica'].' foi realizad'.$config['genero_pratica'].'.').'Ano:'.dicaF().'</td><td>'.selecionaVetor($anos, 'IdxPraticaAno', 'onchange="mudar_ano()" class="texto"', $ano).'</td></tr>';


	$procurar_om='<tr><td align=right>'.dica('Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'], 'Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].'.').ucfirst($config['organizacao']).':'.dicaF().'</td><td><div id="combo_cia">'.selecionar_om($cia_id, 'cia_id', 'class=texto size=1 style="width:250px;" onchange="javascript:mudar_om();"').'</div></td><td><a href="javascript:void(0);" onclick="document.env.submit();">'.imagem('icones/filtrar_p.png','Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'],'Clique neste �cone '.imagem('icones/filtrar_p.png').' para filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].' a esquerda.').'</a></td>'.(($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) && !$ver_subordinadas ? '<td><a href="javascript:void(0);" onclick="document.env.ver_subordinadas.value=1; document.env.dept_id.value=\'\';  document.env.ver_dept_subordinados.value=0; document.env.submit();">'.imagem('icones/organizacao_p.gif','Incluir Subordinad'.$config['genero_organizacao'].'s','Clique neste �cone '.imagem('icones/organizacao_p.gif').' para incluir '.$config['genero_organizacao'].'s '.$config['organizacoes'].' subordinad'.$config['genero_organizacao'].'s '.($config['genero_organizacao']=='a' ? '�' : 'ao').' selecionad'.$config['genero_organizacao'].'.').'</a></td>' : '').(($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) && $ver_subordinadas ? '<td><a href="javascript:void(0);" onclick="document.env.ver_subordinadas.value=0; document.env.submit();">'.imagem('icones/nao_sub_om.gif','N�o Incluir Subordinad'.$config['genero_organizacao'].'s','Clique neste �cone '.imagem('icones/nao_sub_om.gif').' para deixar de incluir '.$config['genero_organizacao'].'s '.$config['organizacoes'].' subordinad'.$config['genero_organizacao'].'s '.($config['genero_organizacao']=='a' ? '�' : 'ao').' selecionad'.$config['genero_organizacao'].'.').'</a></td>' : '').($Aplic->profissional ? '<td><input type="hidden" name="dept_id" id="dept_id" value="'.$dept_id.'" />'.(!$dept_id ? '<a href="javascript:void(0);" onclick="escolher_dept();">'.imagem('icones/secoes_p.gif',ucfirst($config['departamento']),'Clique neste �cone '.imagem('icones/secoes_p.gif').' para filtrar pel'.$config['genero_dept'].' '.$config['departamento'].' envolvid'.$config['genero_dept'].' ou don'.$config['genero_dept'].'.').'</a>' : '').'</td>' : '<input type="hidden" name="dept_id" id="dept_id" value="'.$dept_id.'" />').'</tr>'.
	($dept_id ? '<tr><td align=right>'.dica(ucfirst($config['departamento']), 'Filtrar pel'.$config['genero_dept'].' '.strtolower($config['departamento']).' envolvid'.$config['genero_dept'].'.').ucfirst($config['departamento']).':</td><td><input type="text" style="width:250px;" class="texto" name="dept_nome" id="dept_nome" value="'.nome_dept($dept_id).'"></td>'.($dept_id ? '<td><a href="javascript:void(0);" onclick="escolher_dept();">'.imagem('icones/secoes_p.gif',ucfirst($config['departamento']),'Clique neste �cone '.imagem('icones/secoes_p.gif').' para filtrar pel'.$config['genero_dept'].' '.$config['departamento'].' envolvid'.$config['genero_dept'].' ou don'.$config['genero_dept'].'.').'</a></td>'.(($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) && !$ver_dept_subordinados ? '<td><a href="javascript:void(0);" onclick="document.env.ver_dept_subordinados.value=1; document.env.submit();">'.imagem('icones/organizacao_p.gif','Incluir Subordinad'.$config['genero_dept'].'s','Clique neste �cone '.imagem('icones/organizacao_p.gif').' para incluir '.$config['genero_dept'].'s '.$config['departamentos'].' subordinad'.$config['genero_dept'].'s '.($config['genero_dept']=='a' ? '�' : 'ao').' selecionad'.$config['genero_dept'].'.').'</a></td>' : '').(($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) && $ver_dept_subordinados ? '<td><a href="javascript:void(0);" onclick="document.env.ver_dept_subordinados.value=0; document.env.submit();">'.imagem('icones/nao_sub_om.gif','N�o Incluir Subordinad'.$config['genero_dept'].'s','Clique neste �cone '.imagem('icones/nao_sub_om.gif').' para deixar de incluir '.$config['genero_dept'].'s '.$config['departamentos'].' subordinad'.$config['genero_dept'].'s '.($config['genero_dept']=='a' ? '�' : 'ao').' selecionad'.$config['genero_dept'].'.').'</a></td>' : '') : '').'</tr>' : '');
	$procurar_usuario='<tr><td align=right>'.dica(ucfirst($config['usuario']), 'Filtrar pel'.$config['genero_usuario'].' '.$config['usuario'].' escolhido na caixa de sele��o � direita.').ucfirst($config['usuario']).':'.dicaF().'</td><td><input type="hidden" id="usuario_id" name="usuario_id" value="'.$usuario_id.'" /><input type="text" id="nome_responsavel" name="nome_responsavel" value="'.nome_usuario($usuario_id).'" style="width:250px;" class="texto" READONLY /></td><td><a href="javascript: void(0);" onclick="popResponsavel();">'.imagem('icones/usuarios.gif','Selecionar '.ucfirst($config['usuario']),'Clique neste �cone '.imagem('icones/usuarios.gif').' para selecionar '.($config['genero_usuario']=='o' ? 'um' : 'uma').' '.$config['usuario'].'.').'</a></td></tr>';


	$nova_pratica=($Aplic->checarModulo('praticas', 'adicionar', null, 'pratica') ? '<tr><td align="right">'.dica('Nov'.$config['genero_pratica'].' '.ucfirst($config['pratica']), 'Criar '.($config['genero_pratica']=='a' ? 'uma nova ': 'um novo ').$config['pratica'].'.').'<a href="javascript: void(0)" onclick="javascript:env.a.value=\'pratica_editar\'; env.submit();" ><img src="'.acharImagem('pratica_novo.png').'" border=0 width="16" heigth="16" /></a>'.dicaF().'</td></tr>' : '');
	$botao_favorito='<tr><td nowrap="nowrap" align="right">'.dica('Favorit'.$config['genero_pratica'].'s', 'Criar ou editar um grupo de '.$config['praticas'].' favorit'.$config['genero_pratica'].'s, para uma r�pida filtragem.').'<a href="javascript: void(0)" onclick="url_passar(0, \'m=publico&a=favoritos&pratica=1\');"><img src="'.acharImagem('favorito_p.png').'" border=0 width="16" heigth="16" /></a>'.dicaF().'</td></tr>';
	$imprimir='<tr><td nowrap="nowrap" align="right">'.dica('Imprir '.ucfirst($config['praticas']), 'Imprimir a lista de '.$config['praticas'].'.').'<a href="javascript: void(0);" onclick ="imprimir_praticas('.$tab.')">'.imagem('imprimir_p.png').'</a>'. dicaF().'</td></tr>';
	$botao_trava='<tr id="combo_travado" '.($favorito_trava_campo ? '' : 'style="display:none"').'><td nowrap="nowrap"><a href="javascript: void(0)" onclick="travar(0);">'.imagem('cadeado_fechado.png', 'Destravar Filtros', 'Clique neste �cone '.imagem('cadeado_fechado.png').' para destravar os filtros.').'</a>'.dicaF().'</td></tr><tr id="combo_destravado" '.(!$favorito_trava_campo ? '' : 'style="display: none"').'><td nowrap="nowrap"><a href="javascript: void(0)" onclick="travar(1);">'.imagem('cadeado_aberto.png', 'Travar Filtros', 'Clique neste �cone '.imagem('cadeado_aberto.png').' para travar os filtros.').'</a>'.dicaF().'</td></tr>';
	
	if($filtro_prioridade_pratica) $botao_prioridade=($Aplic->profissional ? '<tr><td><a href="javascript: void(0)" onclick="priorizacao(0);">'.imagem('icones/priorizacao_nao_p.png', 'Cancelar a Prioriza��o' , 'Clique neste �cone '.imagem('icones/priorizacao_nao_p.png').' para cancelar a prioriza��o.').'</a>'.dicaF().'</td></tr>' : '');
	else $botao_prioridade=($Aplic->profissional ? '<tr><td><a href="javascript: void(0)" onclick="priorizacao(1);">'.imagem('icones/priorizacao_p.png', 'Prioriza��o' , 'Clique neste �cone '.imagem('icones/priorizacao_p.png').' para priorizar.').'</a>'.dicaF().'</td></tr>' : '');

	$saida.='<tr><td><table cellspacing=0 cellpadding=0>'.$procurar_om.$filtro_pontuacao.$procurar_usuario.$procuraBuffer.$procurar_ano.$favoritos.'</table></td><td><table cellspacing=0 cellpadding=0>'.$nova_pratica.$imprimir.$botao_prioridade.$botao_favorito.$botao_trava.'</table></td></tr></table>';
	$saida.= '</div></div>';
	$botoesTitulo->adicionaCelula($saida);
	$botoesTitulo->mostrar();
	echo '</form>';
	}
elseif (!$dialogo && !$Aplic->profissional){
	$Aplic->salvarPosicao();
	echo '<form name="env" id="env" method="post">';
	echo '<input type="hidden" name="m" value="'.$m.'" />';
	echo '<input type="hidden" name="a" value="'.$a.'" />';
	echo '<input type="hidden" name="u" value="" />';
	echo '<input type="hidden" name="dept_id" value="" />';
	echo '<input type="hidden" name="cia_dept" value="" />';
	echo '<input type="hidden" name="ver_subordinadas" value="'.$ver_subordinadas.'" />';
	echo '<input type="hidden" name="ver_dept_subordinados" value="'.$ver_dept_subordinados.'" />';
	$procuraBuffer = dica('Pesquisa', 'Pesquisar pelo nome e campos de descri��o').'Pesquisar:'.dicaF().'</td><td><input type="text" class="texto" style="width:145px;" name="praticatextobusca" onChange="document.env.submit();" value="'.$pesquisar_texto.'"/></td><td><a href="javascript:void(0);" onclick="url_passar(0, \'m=praticas&a=pratica_lista&praticatextobusca=\');">'.imagem('icones/limpar_p.gif','Limpar Pesquisa', 'Clique neste �cone '.imagem('icones/limpar_p.gif').' para limpar a caixa texto de pesquisa.').'</a>';
	$botoesTitulo = new CBlocoTitulo(ucfirst($config['praticas']), 'pratica.gif', $m, $m.'.'.$a);
	$procurar_ano='<tr><td align=right>'.dica('Sele��o do Ano', 'Utilize esta op��o para filtrar '.$config['genero_plano_gestao'].' '.$config['plano_gestao'].' pelo ano em que o mesmo foi realizado.').'Ano:'.dicaF().'</td><td>'.selecionaVetor($anos, 'IdxPraticaAno', 'onchange="mudar_ano()" class="texto"', $ano).'</td></tr>';
	$botoesTitulo->adicionaCelula('<table cellspacing=0 cellpadding=0><tr><td nowrap="nowrap" align="right">'.dica('Sele��o de Pauta de Pontua��o', 'Utilize esta op��o para filtrar '.$config['genero_marcador'].'s '.$config['marcadores'].' pela pauta de pontua��o de sua prefer�ncia.').'Pauta:'.dicaF().'</td><td nowrap="nowrap" align="left">'.selecionaVetor($modelos, 'pratica_modelo_id', 'onchange="document.env.submit()" class="texto"', $pratica_modelo_id).'</td></tr><tr><td>'.$procuraBuffer.'</td></tr>'.$procurar_ano.'</table>', '', '', '');
	$procurar_om='<tr><td align=right>'.dica('Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'], 'Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].'.').ucfirst($config['organizacao']).':'.dicaF().'</td><td><div id="combo_cia">'.selecionar_om($cia_id, 'cia_id', 'class=texto size=1 style="width:250px;" onchange="javascript:mudar_om();"').'</div></td><td><a href="javascript:void(0);" onclick="document.env.submit();">'.imagem('icones/filtrar_p.png','Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'],'Clique neste �cone '.imagem('icones/filtrar_p.png').' para filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].' a esquerda.').'</a></td>'.(($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) && !$ver_subordinadas ? '<td><a href="javascript:void(0);" onclick="document.env.ver_subordinadas.value=1; document.env.dept_id.value=\'\';  document.env.ver_dept_subordinados.value=0; document.env.submit();">'.imagem('icones/organizacao_p.gif','Incluir Subordinad'.$config['genero_organizacao'].'s','Clique neste �cone '.imagem('icones/organizacao_p.gif').' para incluir '.$config['genero_organizacao'].'s '.$config['organizacoes'].' subordinad'.$config['genero_organizacao'].'s '.($config['genero_organizacao']=='a' ? '�' : 'ao').' selecionad'.$config['genero_organizacao'].'.').'</a></td>' : '').(($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) && $ver_subordinadas ? '<td><a href="javascript:void(0);" onclick="document.env.ver_subordinadas.value=0; document.env.submit();">'.imagem('icones/nao_sub_om.gif','N�o Incluir Subordinad'.$config['genero_organizacao'].'s','Clique neste �cone '.imagem('icones/nao_sub_om.gif').' para deixar de incluir '.$config['genero_organizacao'].'s '.$config['organizacoes'].' subordinad'.$config['genero_organizacao'].'s '.($config['genero_organizacao']=='a' ? '�' : 'ao').' selecionad'.$config['genero_organizacao'].'.').'</a></td>' : '').($Aplic->profissional ? '<td><input type="hidden" name="dept_id" id="dept_id" value="'.$dept_id.'" />'.(!$dept_id ? '<a href="javascript:void(0);" onclick="escolher_dept();">'.imagem('icones/secoes_p.gif',ucfirst($config['departamento']),'Clique neste �cone '.imagem('icones/secoes_p.gif').' para filtrar pel'.$config['genero_dept'].' '.$config['departamento'].' envolvid'.$config['genero_dept'].' ou don'.$config['genero_dept'].'.').'</a>' : '').'</td>' : '<input type="hidden" name="dept_id" id="dept_id" value="'.$dept_id.'" />').'</tr>'.
	($dept_id ? '<tr><td align=right>'.dica(ucfirst($config['departamento']), 'Filtrar pel'.$config['genero_dept'].' '.strtolower($config['departamento']).' envolvid'.$config['genero_dept'].'.').ucfirst($config['departamento']).':</td><td><input type="text" style="width:250px;" class="texto" name="dept_nome" id="dept_nome" value="'.nome_dept($dept_id).'"></td>'.($dept_id ? '<td><a href="javascript:void(0);" onclick="escolher_dept();">'.imagem('icones/secoes_p.gif',ucfirst($config['departamento']),'Clique neste �cone '.imagem('icones/secoes_p.gif').' para filtrar pel'.$config['genero_dept'].' '.$config['departamento'].' envolvid'.$config['genero_dept'].' ou don'.$config['genero_dept'].'.').'</a></td>'.(($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) && !$ver_dept_subordinados ? '<td><a href="javascript:void(0);" onclick="document.env.ver_dept_subordinados.value=1; document.env.submit();">'.imagem('icones/organizacao_p.gif','Incluir Subordinad'.$config['genero_dept'].'s','Clique neste �cone '.imagem('icones/organizacao_p.gif').' para incluir '.$config['genero_dept'].'s '.$config['departamentos'].' subordinad'.$config['genero_dept'].'s '.($config['genero_dept']=='a' ? '�' : 'ao').' selecionad'.$config['genero_dept'].'.').'</a></td>' : '').(($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) && $ver_dept_subordinados ? '<td><a href="javascript:void(0);" onclick="document.env.ver_dept_subordinados.value=0; document.env.submit();">'.imagem('icones/nao_sub_om.gif','N�o Incluir Subordinad'.$config['genero_dept'].'s','Clique neste �cone '.imagem('icones/nao_sub_om.gif').' para deixar de incluir '.$config['genero_dept'].'s '.$config['departamentos'].' subordinad'.$config['genero_dept'].'s '.($config['genero_dept']=='a' ? '�' : 'ao').' selecionad'.$config['genero_dept'].'.').'</a></td>' : '') : '').'</tr>' : '');
	$procurar_usuario='<tr><td align=right>'.dica('Respons�vel', 'Filtrar pel'.$config['genero_usuario'].' '.$config['usuario'].' escolhido na caixa de sele��o � direita.').'Resp:'.dicaF().'</td><td><input type="hidden" id="usuario_id" name="usuario_id" value="'.$usuario_id.'" /><input type="text" id="nome_responsavel" name="nome_responsavel" value="'.nome_usuario($usuario_id).'" style="width:250px;" class="texto" READONLY /></td><td></td><td><a href="javascript: void(0);" onclick="popResponsavel();">'.imagem('icones/usuarios.gif','Selecionar '.ucfirst($config['usuario']),'Clique neste �cone '.imagem('icones/usuarios.gif').' para selecionar '.($config['genero_usuario']=='o' ? 'um' : 'uma').' '.$config['usuario'].'.').'</a></td></tr>';
	$botoesTitulo->adicionaCelula('<table cellspacing=0 cellpadding=0>'.$procurar_om.$procurar_usuario.'</table>');
	if ($Aplic->checarModulo('praticas', 'adicionar', null, 'pratica')) $botoesTitulo->adicionaCelula(dica('Nov'.$config['genero_pratica'].' '.ucfirst($config['pratica']), 'Criar '.($config['genero_pratica']=='a' ? 'uma nova ': 'um novo ').$config['pratica'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:env.a.value=\'pratica_editar\'; env.submit();" ><span>nov'.$config['genero_pratica'].'</span></a>'.dicaF());
	//$botoesTitulo->adicionaCelula('<table cellspacing=0 cellpadding=0><tr><td nowrap="nowrap">'.dica('Favorit'.$config['praticas'].'s', 'Criar ou editar um grupo de '.$config['praticas'].' favorit'.$config['genero_pratica'].'s, para uma r�pida filtragem.').'<a class="botao" href="javascript: void(0)" onclick="url_passar(0, \'m=publico&a=favoritos&pratica=1\');"><span>favorit'.$config['genero_pratica'].'s</span></a>'.dicaF().'</td></tr></table>');
	$botoesTitulo->adicionaCelula(dica('Imprir '.ucfirst($config['praticas']), 'Clique neste �cone '.imagem('imprimir_p.png').' para imprimir a lista de '.$config['praticas'].'.').'<a href="javascript: void(0);" onclick ="imprimir_praticas('.$tab.')">'.imagem('imprimir_p.png').'</a>'. dicaF());
	$botoesTitulo->mostrar();
	echo '</form>';
	}
elseif ($Aplic->profissional){
	include_once BASE_DIR.'/modulos/projetos/artefato.class.php';
	include_once BASE_DIR.'/modulos/projetos/artefato_template.class.php';
	$dados=array();
	$dados['projeto_cia'] = $cia_id;
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
	echo '<font size="4"><center>Lista de '.ucfirst($config['praticas']).'</center></font>';
	}
$sql->adTabela('pratica_criterio');
$sql->adCampo('pratica_criterio_id, pratica_criterio_nome');
$sql->adOnde('pratica_criterio_modelo='.(int)$pratica_modelo_id);
$sql->adOnde('pratica_criterio_resultado=0');
if ($criterio) $sql->adOnde('pratica_criterio_id='.(int)$criterio);
$praticas_criterios=$sql->Lista();
$sql->limpar();

$titulo=array();
$nomes_criterios=array();
foreach ((array)$praticas_criterios as $chave => $criterio) {
	$total[$chave] = 0;
	$sql->adTabela('pratica_nos_marcadores');
	$sql->esqUnir('pratica_marcador', 'pratica_marcador', 'pratica_marcador.pratica_marcador_id=pratica_nos_marcadores.marcador');
	$sql->esqUnir('pratica_item', 'pratica_item', 'pratica_item.pratica_item_id =pratica_marcador.pratica_marcador_item');
	$sql->esqUnir('pratica_criterio', 'pratica_criterio', 'pratica_criterio.pratica_criterio_id=pratica_item.pratica_item_criterio');
	$sql->esqUnir('praticas', 'praticas', 'praticas.pratica_id =pratica_nos_marcadores.pratica');
	$sql->esqUnir('pratica_requisito', 'pratica_requisito', 'pratica_requisito.pratica_id=praticas.pratica_id');
	
	if ($filtro_prioridade_pratica){
		$sql->esqUnir('priorizacao', 'priorizacao', 'praticas.pratica_id=priorizacao_pratica');
		$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_pratica.')');
		}
	
	if ($favorito_id){
		$sql->internoUnir('favorito_lista', 'favorito_lista', 'praticas.pratica_id=favorito_lista_campo');
		$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
		$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
		}
	elseif ($Aplic->profissional && ($dept_id || $lista_depts)) {
		$sql->esqUnir('pratica_depts', 'pratica_depts', 'pratica_depts.pratica_id=praticas.pratica_id');
		$sql->adOnde('pratica_dept IN ('.($lista_depts ? $lista_depts  : $dept_id).') OR pratica_depts.dept_id IN ('.($lista_depts ? $lista_depts  : $dept_id).')');
		}
	elseif (!$Aplic->profissional && ($dept_id || $lista_depts)) {
		$sql->adOnde('pratica_dept IN ('.($lista_depts ? $lista_depts  : $dept_id).')');
		}
	elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
		$sql->esqUnir('pratica_cia', 'pratica_cia', 'praticas.pratica_id=pratica_cia_pratica');
		$sql->adOnde('pratica_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR pratica_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
		}
	elseif ($cia_id && !$lista_cias) $sql->adOnde('pratica_cia='.(int)$cia_id);
	elseif ($cia_id && $lista_cias) $sql->adOnde('pratica_cia IN ('.$lista_cias.')');

	if ($ano) $sql->adOnde('pratica_nos_marcadores.ano='.(int)$ano);
	if ($ano) $sql->adOnde('pratica_requisito.ano='.(int)$ano);
	if ($item)$sql->adOnde('pratica_item.pratica_item_id='.(int)$item);

	if ($pesquisar_texto)$sql->adOnde('pratica_nome LIKE \'%'.$pesquisar_texto.'%\' OR pratica_descricao LIKE \'%'.$pesquisar_texto.'%\'');

	if ($usuario_id) {
		$sql->esqUnir('pratica_usuarios', 'pratica_usuarios', 'pratica_usuarios.pratica_id = praticas.pratica_id');
		$sql->adOnde('pratica_responsavel = '.(int)$usuario_id.' OR pratica_usuarios.usuario_id='.(int)$usuario_id);
		}

	$sql->adCampo('count(DISTINCT praticas.pratica_id)');
	$sql->adOnde('pratica_criterio_id='.(int)$criterio['pratica_criterio_id']);
	$sql->adOnde('pratica_ativa=1');
	$soma=$sql->Resultado();
	$sql->limpar();
	$nomes_criterios[] = array( 0 => (strlen($criterio['pratica_criterio_nome'])> 17 ? substr($criterio['pratica_criterio_nome'], 0, 16).'.' : $criterio['pratica_criterio_nome']).($soma ? ' '.$soma : '') , 1=> $criterio['pratica_criterio_nome'].($soma ? ' '.$soma : ''));
	}







$sql->adTabela('praticas');
$sql->esqUnir('pratica_requisito', 'pratica_requisito', 'pratica_requisito.pratica_id=praticas.pratica_id');
$sql->esqUnir('pratica_nos_marcadores', 'pratica_nos_marcadores', 'pratica_nos_marcadores.pratica=praticas.pratica_id');
$sql->esqUnir('pratica_marcador', 'pratica_marcador', 'pratica_marcador.pratica_marcador_id=pratica_nos_marcadores.marcador');
$sql->esqUnir('pratica_item', 'pratica_item', 'pratica_item.pratica_item_id=pratica_marcador.pratica_marcador_item');
$sql->esqUnir('pratica_criterio', 'pratica_criterio', 'pratica_criterio.pratica_criterio_id=pratica_item.pratica_item_criterio');

if ($filtro_prioridade_pratica){
	$sql->esqUnir('priorizacao', 'priorizacao', 'praticas.pratica_id=priorizacao_pratica');
	if ($config['metodo_priorizacao']) $sql->adCampo('(SELECT round(exp(sum(log(coalesce(priorizacao_valor,1))))) FROM priorizacao WHERE priorizacao_pratica = praticas.pratica_id AND priorizacao_modelo IN ('.$filtro_prioridade_pratica.')) AS priorizacao');
	else $sql->adCampo('(SELECT SUM(priorizacao_valor) FROM priorizacao WHERE priorizacao_pratica = praticas.pratica_id AND priorizacao_modelo IN ('.$filtro_prioridade_pratica.')) AS priorizacao');
	$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_pratica.')');
	}

if ($favorito_id){
	$sql->internoUnir('favorito_lista', 'favorito_lista', 'praticas.pratica_id=favorito_lista_campo');
	$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
	$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
	}
elseif ($Aplic->profissional && ($dept_id || $lista_depts)) {
	$sql->esqUnir('pratica_depts', 'pratica_depts', 'pratica_depts.pratica_id=praticas.pratica_id');
	$sql->adOnde('pratica_dept IN ('.($lista_depts ? $lista_depts  : $dept_id).') OR pratica_depts.dept_id IN ('.($lista_depts ? $lista_depts  : $dept_id).')');
	}
elseif (!$Aplic->profissional && ($dept_id || $lista_depts)) {
	$sql->adOnde('pratica_dept IN ('.($lista_depts ? $lista_depts  : $dept_id).')');
	}
elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
	$sql->esqUnir('pratica_cia', 'pratica_cia', 'praticas.pratica_id=pratica_cia_pratica');
	$sql->adOnde('pratica_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR pratica_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
	}
elseif ($cia_id && !$lista_cias) $sql->adOnde('pratica_cia='.(int)$cia_id);
elseif ($cia_id && $lista_cias) $sql->adOnde('pratica_cia IN ('.$lista_cias.')');

if ($item)$sql->adOnde('pratica_item.pratica_item_id='.(int)$item);
if ($pratica_modelo_id && $tab > 1) $sql->adOnde('pc.pratica_criterio_modelo='.(int)$pratica_modelo_id);
if ($pesquisar_texto)$sql->adOnde('pratica_nome LIKE \'%'.$pesquisar_texto.'%\' OR pratica_descricao LIKE \'%'.$pesquisar_texto.'%\'');
if ($usuario_id) {
	$sql->esqUnir('pratica_usuarios', 'pratica_usuarios', 'pratica_usuarios.pratica_id = praticas.pratica_id');
	$sql->adOnde('pratica_responsavel = '.(int)$usuario_id.' OR pratica_usuarios.usuario_id='.(int)$usuario_id);
	}
$sql->esqUnir('pratica_item', 'pi', 'pi.pratica_item_id=pratica_marcador_item');
$sql->esqUnir('pratica_criterio', 'pc', 'pc.pratica_criterio_id=pi.pratica_item_criterio');
$sql->adCampo('praticas.pratica_id, pratica_acesso, pratica_nome, pratica_descricao, pratica_cor, pratica_responsavel');
$sql->adCampo('pratica_controlada, pratica_proativa, pratica_abrange_pertinentes, pratica_continuada, pratica_refinada, pratica_coerente, pratica_interrelacionada, pratica_cooperacao, pratica_cooperacao_partes, pratica_arte, pratica_inovacao, pratica_melhoria_aprendizado, pratica_agil, pratica_gerencial, pratica_refinada_implantacao, pratica_incoerente, pratica_aprovado');
if ($tab > 1 && isset($praticas_criterios[$tab-2]['pratica_criterio_id'])) {
	$sql->adOnde('pc.pratica_criterio_id='.(int)$praticas_criterios[$tab-2]['pratica_criterio_id']);
	if ($ano) $sql->adOnde('pratica_nos_marcadores.ano='.(int)$ano);
	}
if ($ano) $sql->adOnde('pratica_requisito.ano='.(int)$ano);
if ($tab !=1) $sql->adOnde('pratica_ativa=1');
else $sql->adOnde('pratica_ativa=0');
if ($Aplic->profissional) $sql->adCampo('(SELECT count(assinatura_id) FROM assinatura WHERE assinatura_aprova=1 AND assinatura_pratica=praticas.pratica_id) AS tem_aprovacao');
$sql->adOrdem($ordenar.($ordem ? ' DESC' : ' ASC'));
$sql->adGrupo('praticas.pratica_id');
$praticas=$sql->Lista();
$sql->limpar();









if($Aplic->profissional){
    $Aplic->carregarComboMultiSelecaoJS();
	}



if (!$dialogo){
	$caixaTab = new CTabBox('m=praticas&a=pratica_lista', BASE_DIR.'/modulos/praticas/', $tab);

	$sql->adTabela('praticas');
	$sql->esqUnir('pratica_requisito', 'pratica_requisito', 'pratica_requisito.pratica_id=praticas.pratica_id');
	
	if ($filtro_prioridade_pratica){
		$sql->esqUnir('priorizacao', 'priorizacao', 'praticas.pratica_id=priorizacao_pratica');
		$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_pratica.')');
		}
	
	if ($favorito_id){
		$sql->internoUnir('favorito_lista', 'favorito_lista', 'praticas.pratica_id=favorito_lista_campo');
		$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
		$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
		}
	elseif ($Aplic->profissional && ($dept_id || $lista_depts)) {
		$sql->esqUnir('pratica_depts', 'pratica_depts', 'pratica_depts.pratica_id=praticas.pratica_id');
		$sql->adOnde('pratica_dept IN ('.($lista_depts ? $lista_depts  : $dept_id).') OR pratica_depts.dept_id IN ('.($lista_depts ? $lista_depts  : $dept_id).')');
		}
	elseif (!$Aplic->profissional && ($dept_id || $lista_depts)) {
		$sql->adOnde('pratica_dept IN ('.($lista_depts ? $lista_depts  : $dept_id).')');
		}
	elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
		$sql->esqUnir('pratica_cia', 'pratica_cia', 'praticas.pratica_id=pratica_cia_pratica');
		$sql->adOnde('pratica_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR pratica_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
		}
	elseif ($cia_id && !$lista_cias) $sql->adOnde('pratica_cia='.(int)$cia_id);
	elseif ($cia_id && $lista_cias) $sql->adOnde('pratica_cia IN ('.$lista_cias.')');

	if ($pesquisar_texto)$sql->adOnde('pratica_nome LIKE \'%'.$pesquisar_texto.'%\' OR pratica_descricao LIKE \'%'.$pesquisar_texto.'%\'');
	if ($usuario_id) {
		$sql->esqUnir('pratica_usuarios', 'pratica_usuarios', 'pratica_usuarios.pratica_id = praticas.pratica_id');
		$sql->adOnde('pratica_responsavel = '.(int)$usuario_id.' OR pratica_usuarios.usuario_id='.(int)$usuario_id);
		}
	if ($ano) $sql->adOnde('pratica_requisito.ano='.(int)$ano);
	$sql->adCampo('count(DISTINCT praticas.pratica_id)');
	$sql->adOnde('pratica_ativa=0');
	$soma=$sql->Resultado();
	$sql->limpar();
	array_unshift($nomes_criterios, array(0 => 'Inativ'.$config['genero_pratica'].'s'.($soma ? ' '.$soma : '') , 1=> 'Inativ'.$config['genero_pratica'].'s'.($soma ? ' '.$soma : '')));



	$sql->adTabela('praticas');
	$sql->esqUnir('pratica_requisito', 'pratica_requisito', 'pratica_requisito.pratica_id=praticas.pratica_id');
	
	if ($filtro_prioridade_pratica){
		$sql->esqUnir('priorizacao', 'priorizacao', 'praticas.pratica_id=priorizacao_pratica');
		$sql->adOnde('priorizacao_modelo IN ('.$filtro_prioridade_pratica.')');
		}
	
	if ($favorito_id){
		$sql->internoUnir('favorito_lista', 'favorito_lista', 'praticas.pratica_id=favorito_lista_campo');
		$sql->internoUnir('favorito', 'favorito', 'favorito.favorito_id=favorito_lista_favorito');
		$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
		}
	elseif ($Aplic->profissional && ($dept_id || $lista_depts)) {
		$sql->esqUnir('pratica_depts', 'pratica_depts', 'pratica_depts.pratica_id=praticas.pratica_id');
		$sql->adOnde('pratica_dept IN ('.($lista_depts ? $lista_depts  : $dept_id).') OR pratica_depts.dept_id IN ('.($lista_depts ? $lista_depts  : $dept_id).')');
		}
	elseif (!$Aplic->profissional && ($dept_id || $lista_depts)) {
		$sql->adOnde('pratica_dept IN ('.($lista_depts ? $lista_depts  : $dept_id).')');
		}
	elseif ($Aplic->profissional && ($cia_id || $lista_cias)) {
		$sql->esqUnir('pratica_cia', 'pratica_cia', 'praticas.pratica_id=pratica_cia_pratica');
		$sql->adOnde('pratica_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).') OR pratica_cia_cia IN ('.($lista_cias ? $lista_cias  : $cia_id).')');
		}
	elseif ($cia_id && !$lista_cias) $sql->adOnde('pratica_cia='.(int)$cia_id);
	elseif ($cia_id && $lista_cias) $sql->adOnde('pratica_cia IN ('.$lista_cias.')');

	if ($pesquisar_texto)$sql->adOnde('pratica_nome LIKE \'%'.$pesquisar_texto.'%\' OR pratica_descricao LIKE \'%'.$pesquisar_texto.'%\'');
	if ($usuario_id) {
		$sql->esqUnir('pratica_usuarios', 'pratica_usuarios', 'pratica_usuarios.pratica_id = praticas.pratica_id');
		$sql->adOnde('pratica_responsavel = '.(int)$usuario_id.' OR pratica_usuarios.usuario_id='.(int)$usuario_id);
		}
	if ($ano) $sql->adOnde('pratica_requisito.ano='.(int)$ano);
	$sql->adCampo('count(DISTINCT praticas.pratica_id)');
	$sql->adOnde('pratica_ativa=1');
	$soma=$sql->Resultado();
	$sql->limpar();
	array_unshift($nomes_criterios, array(0 => 'Ativ'.$config['genero_pratica'].'s'.($soma ? ' '.$soma : '') , 1=> 'Ativ'.$config['genero_pratica'].'s'.($soma ? ' '.$soma : '')));
	foreach ($nomes_criterios as $nome_criterio) $caixaTab->adicionar('praticas_ver_idx', $nome_criterio[0], true,null,$nome_criterio[1],'Clique nesta aba para visualizar este grupo de '.$config['praticas'].'.');
	$ver_min = true;
	$caixaTab->mostrar('','','','',true);
	echo estiloFundoCaixa('','', $tab);
	}
else include_once (BASE_DIR.'/modulos/praticas/praticas_ver_idx.php');


?>
<script type="text/javascript">
	
function travar(tipo){
	xajax_travar(tipo);
	if (tipo){
		document.getElementById('combo_travado').style.display="";
		document.getElementById('combo_destravado').style.display="none";
		}
	else {
		document.getElementById('combo_travado').style.display="none";
		document.getElementById('combo_destravado').style.display="";
		}
	}	
	

function mudar_ano(){
	env.submit();
	}

function priorizacao() {
	parent.gpwebApp.popUp("Prioriza��o", 400, 300, 'm=publico&a=filtro_priorizacao_pro&dialogo=1&acao=1&filtro_prioridade='+env.filtro_prioridade_pratica.value, window.setFiltroPriorizacao, window);
	}

function setFiltroPriorizacao(filtro_prioridade_pratica){
	env.filtro_prioridade_pratica.value=filtro_prioridade_pratica;
	env.submit();
	}

function escolher_dept(){
	if (window.parent.gpwebApp) parent.gpwebApp.popUp("<?php echo ucfirst($config['departamento']) ?>", 500, 500, 'm=publico&a=selecao_unico_dept&dialogo=1&chamar_volta=filtrar_dept&dept_id=<?php echo $dept_id ?>&cia_id='+document.getElementById('cia_id').value, window.filtrar_dept, window);
	else window.open('./index.php?m=publico&a=selecao_unico_dept&dialogo=1&chamar_volta=filtrar_dept&dept_id=<?php echo $dept_id ?>&cia_id='+document.getElementById('cia_id').value, 'Filtrar','height=500,width=500,resizable,scrollbars=yes, left=0, top=0');
	}

function filtrar_dept(cia_id, dept_id){
	document.getElementById('cia_id').value=cia_id;
	document.getElementById('dept_id').value=dept_id;
	env.submit();
	}

function imprimir_praticas(tab){
	url_passar(1, 'm=praticas&a=pratica_lista&dialogo=1');

	}

function mudar_om(){
	var cia_id=document.getElementById('cia_id').value;
	xajax_selecionar_om_ajax(cia_id,'cia_id','combo_cia', 'class="texto" size=1 style="width:250px;" onchange="javascript:mudar_om();"');
	}


function popResponsavel(campo) {
	if (window.parent.gpwebApp) parent.gpwebApp.popUp('Respons�vel', 500, 500, 'm=publico&a=selecao_unico_usuario&dialogo=1&chamar_volta=setResponsavel&cia_id='+document.getElementById('cia_id').value+'&usuario_id='+document.getElementById('usuario_id').value, window.setResponsavel, window);
	else window.open('./index.php?m=publico&a=selecao_unico_usuario&dialogo=1&chamar_volta=setResponsavel&cia_id='+document.getElementById('cia_id').value+'&usuario_id='+document.getElementById('usuario_id').value, 'Respons�vel','height=500,width=500,resizable,scrollbars=yes, left=0, top=0');
	}

function setResponsavel(usuario_id, posto, nome, funcao, campo, nome_cia){
	document.getElementById('usuario_id').value=usuario_id;
	document.getElementById('nome_responsavel').value=posto+' '+nome+(funcao ? ' - '+funcao : '')+(nome_cia && <?php echo $Aplic->getPref('om_usuario') ?>? ' - '+nome_cia : '');
	env.submit();
	}




function iluminar_tds(linha,alto,id){
	if(document.getElementsByTagName){
		var tcs=linha.getElementsByTagName('td');
		var nome_celula='';
		if(!id)check=false;
		else{
			var f=eval('document.frm');
			var check=eval('f.selecao_projeto_'+id+'.checked')
			}
		for(var j=0,j_cmp=tcs.length;j<j_cmp;j+=1){
			nome_celula=eval('tcs['+j+'].id');
			if(!(nome_celula.indexOf('ignore_td_')>=0)){
				if(alto==3) tcs[j].style.background='#FFFFCC';
				else if(alto==2||check)
				tcs[j].style.background='#FFCCCC';
				else if(alto==1) tcs[j].style.background='#FFFFCC';
				else tcs[j].style.background='#FFFFFF';
				}
			}
		}
	}

var estah_marcado;

function selecionar_projeto(id){
	var f=eval('document.frm');
	var boxObj=eval('f.elements["selecao_projeto_'+id+'"]');
	if(boxObj.checked){
		var linha=document.getElementById('projeto_'+id);
		boxObj.checked=false;
		iluminar_tds(linha,2,id);
		}
	else if(!boxObj.checked){
		var linha=document.getElementById('projeto_'+id);
		boxObj.checked=true;
		iluminar_tds(linha,3,id);
		}
	}

function selecionar_multiprojeto(id1, id2){
	var f=eval('document.frm');
	var boxObj=eval('f.elements["selecao_projeto_'+id2+'"]');
	if(boxObj.checked){
		var linha=document.getElementById('multiprojeto_tr_'+id1+'_'+id2+'_');
		boxObj.checked=false;
		iluminar_tds(linha,2,id2);
		}
	else if(!boxObj.checked){
		var linha=document.getElementById('multiprojeto_tr_'+id1+'_'+id2+'_');
		boxObj.checked=true;
		iluminar_tds(linha,3,id2);
		}
	}
var nomeTab="<?php echo $caixaTab->tabs[$tab][1] ?>";

</script>
