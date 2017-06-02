<?php
if (!($podeAcessar || $Aplic->usuario_super_admin)) $Aplic->redirecionar('m=publico&a=acesso_negado');

$sql = new BDConsulta;

$painel_filtro = $Aplic->getEstado('painel_filtro') !== null ? $Aplic->getEstado('painel_filtro') : 0;

if (isset($_REQUEST['filtro_prioridade_tema']))	$Aplic->setEstado('filtro_prioridade_tema', getParam($_REQUEST, 'filtro_prioridade_tema', null));
$filtro_prioridade_tema = $Aplic->getEstado('filtro_prioridade_tema') !== null ? $Aplic->getEstado('filtro_prioridade_tema') : null;

$houve_filtro=getParam($_REQUEST, 'houve_filtro', null);
$sql->adTabela('favorito_trava');
$sql->adCampo('favorito_trava_campo');
$sql->adOnde('favorito_trava_tema=1');
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

if (isset($_REQUEST['tab'])) $Aplic->setEstado('ListaTabTema', getParam($_REQUEST, 'tab', null));
$tab = ($Aplic->getEstado('ListaTabTema') !== null ? $Aplic->getEstado('ListaTabTema') : 0);

if (isset($_REQUEST['ver_subordinadas'])) $Aplic->setEstado('ver_subordinadas', getParam($_REQUEST, 'ver_subordinadas', null));
$ver_subordinadas = ($Aplic->getEstado('ver_subordinadas') !== null ? $Aplic->getEstado('ver_subordinadas') : (($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) ? $Aplic->usuario_prefs['ver_subordinadas'] : 0));

if (isset($_REQUEST['cia_id'])) $Aplic->setEstado('cia_id', getParam($_REQUEST, 'cia_id', null));
$cia_id = ($Aplic->getEstado('cia_id') !== null ? $Aplic->getEstado('cia_id') : $Aplic->usuario_cia);

if (isset($_REQUEST['dept_id'])) $Aplic->setEstado('dept_id', intval(getParam($_REQUEST, 'dept_id', 0)));
$dept_id = $Aplic->getEstado('dept_id') !== null ? $Aplic->getEstado('dept_id') : ($Aplic->usuario_pode_todos_depts ? null : $Aplic->usuario_dept);
if ($dept_id) $ver_subordinadas = null;

if (isset($_REQUEST['favorito_id'])) $Aplic->setEstado('tema_favorito', getParam($_REQUEST, 'favorito_id', null));
$favorito_id = $Aplic->getEstado('tema_favorito') !== null ? $Aplic->getEstado('tema_favorito') : 0;

if (isset($_REQUEST['pg_perspectiva_id'])) $Aplic->setEstado('pg_perspectiva_id', getParam($_REQUEST, 'pg_perspectiva_id', null));
$pg_perspectiva_id = $Aplic->getEstado('pg_perspectiva_id') !== null ? $Aplic->getEstado('pg_perspectiva_id') : 0;

if (isset($_REQUEST['tematextobusca'])) $Aplic->setEstado('tematextobusca', getParam($_REQUEST, 'tematextobusca', null));
$pesquisar_texto = ($Aplic->getEstado('tematextobusca') ? $Aplic->getEstado('tematextobusca') : '');

if (isset($_REQUEST['usuario_id'])) $Aplic->setEstado('usuario_id', getParam($_REQUEST, 'usuario_id', null));
$usuario_id = $Aplic->getEstado('usuario_id') !== null ? $Aplic->getEstado('usuario_id') : 0;

if (isset($_REQUEST['pg_id'])) $Aplic->setEstado('pg_id', getParam($_REQUEST, 'pg_id', null));
$pg_id = ($Aplic->getEstado('pg_id') !== null ? $Aplic->getEstado('pg_id') : null);




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


$sql->adTabela('plano_gestao');
$sql->adCampo('DISTINCT pg_id, pg_nome');
if ($ver_subordinadas) $sql->adOnde('pg_cia IN ('.$lista_cias.')');
else $sql->adOnde('pg_cia ='.(int)$cia_id);
if ($ver_dept_subordinados && $lista_depts) $sql->adOnde('pg_dept IN ('.$lista_depts.')');
elseif ($dept_id) $sql->adOnde('pg_dept='.(int)$dept_id);
else $sql->adOnde('pg_dept=0 OR pg_dept IS NULL');
$sql->adOrdem('pg_nome DESC');
$planos=array(0=>'')+$sql->listaVetorChave('pg_id','pg_nome');
$sql->limpar();



$sql->adTabela('favorito');
$sql->adCampo('favorito_id, favorito_nome');
$sql->adOnde('favorito_geral!=1');
$sql->adOnde('favorito_ativo=1');
$sql->adOnde('favorito_tema=1');
$sql->adOnde('favorito_usuario='.$Aplic->usuario_id);
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
$sql->adOnde('favorito_tema=1');
$sql->adCampo('favorito_id, favorito_nome');
$vetor_favoritos1=$sql->ListaChave();
$sql->limpar();

$sql->adTabela('favorito');
$sql->esqUnir('favorito_usuario', 'favorito_usuario', 'favorito_usuario_favorito= favorito.favorito_id');
$sql->adOnde('favorito_usuario_usuario = '.(int)$Aplic->usuario_id.' OR favorito_usuario='.(int)$Aplic->usuario_id);
$sql->adOnde('favorito_acesso=2');
$sql->adOnde('favorito_geral=1');
$sql->adOnde('favorito_ativo=1');
$sql->adOnde('favorito_tema=1');
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

$perspectivas=array();
$sql->adTabela('perspectivas');
if ($ver_subordinadas) $sql->adOnde('pg_perspectiva_cia IN ('.$lista_cias.')');
else $sql->adOnde('pg_perspectiva_cia ='.(int)$cia_id);
if ($pg_id){
	$sql->esqUnir('plano_gestao_perspectivas', 'plano_gestao_perspectivas', 'plano_gestao_perspectivas.pg_perspectiva_id=perspectivas.pg_perspectiva_id');
	$sql->adOnde('plano_gestao_perspectivas.pg_id='.(int)$pg_id);
	}
$sql->adOnde('pg_perspectiva_ativo = 1');
$sql->adCampo('pg_perspectiva_id, pg_perspectiva_nome');
$sql->adOrdem('pg_perspectiva_ordem');
$perspectivas_ativas = $sql->Lista();
$sql->limpar();
foreach($perspectivas_ativas as $ativas) {
	$perspectivas[$ativas['pg_perspectiva_id']]=$ativas['pg_perspectiva_nome'];
	$cor[$ativas['pg_perspectiva_id']]='color:#000;';
	}

$sql->adTabela('perspectivas');
if ($ver_subordinadas) $sql->adOnde('pg_perspectiva_cia IN ('.$lista_cias.')');
else $sql->adOnde('pg_perspectiva_cia ='.(int)$cia_id);
if ($pg_id){
	$sql->esqUnir('plano_gestao_perspectivas', 'plano_gestao_perspectivas', 'plano_gestao_perspectivas.pg_perspectiva_id=perspectivas.pg_perspectiva_id');
	$sql->adOnde('plano_gestao_perspectivas.pg_id='.(int)$pg_id);
	}
$sql->adOnde('pg_perspectiva_ativo = 0');
$sql->adCampo('pg_perspectiva_id, pg_perspectiva_nome');
$sql->adOrdem('pg_perspectiva_ordem');
$perspectivas_inativas = $sql->Lista();
$sql->limpar();
foreach($perspectivas_inativas as $inativas) {
	$perspectivas[$inativas['pg_perspectiva_id']]='<span style="color:#333;">'.$inativas['pg_perspectiva_nome'].'</span>';
	$cor[$inativas['pg_perspectiva_id']]='color:#F00;';
	}
$perspectivas[0]='';
$cor[0]='color:#000;';

if (!$dialogo && $Aplic->profissional){
	$Aplic->salvarPosicao();
	echo '<form name="env" id="env" method="post">';
	echo '<input type="hidden" name="m" value="'.$m.'" />';
	echo '<input type="hidden" name="a" value="'.$a.'" />';
	echo '<input type="hidden" name="u" value="" />';
	echo '<input type="hidden" name="ver_subordinadas" value="'.$ver_subordinadas.'" />';
	echo '<input type="hidden" name="ver_dept_subordinados" value="'.$ver_dept_subordinados.'" />';
	echo '<input type="hidden" name="filtro_prioridade_tema" id="filtro_prioridade_tema" value="'.$filtro_prioridade_tema.'" />';
	echo '<input type="hidden" name="houve_filtro" id="houve_filtro" value="1" />';
	
	
	$botoesTitulo = new CBlocoTitulo('Lista de '.ucfirst($config['temas']), 'tema.png', $m, $m.'.'.$a);

	$saida='<div id="filtro_container" style="border: 1px solid #'.($estilo_interface=='metro' ? '006fc2' : 'a6a6a6').'; margin-bottom: 2px; -webkit-border-radius: 4px; border-radius:4px; -moz-border-radius: 4px;">';
  $saida.=dica('Filtros e A��es','Clique nesta barra para esconder/mostrar os filtros e as a��es permitidas.').'<div id="filtro_titulo" style="background-color: #'.($estilo_interface=='metro' ? '006fc2' : 'a6a6a6').'; font-size: 8pt; font-weight: bold;" onclick="$jq(\'#filtro_content\').toggle(); xajax_painel_filtro(document.getElementById(\'filtro_content\').style.display);"><a class="aba" href="javascript:void(0);">'.imagem('icones/tema_p.png').'&nbsp;Filtros e A��es</a></div>'.dicaF();
  $saida.='<div id="filtro_content" style="display:'.($painel_filtro ? '' : 'none').'">';
  $saida.='<table cellspacing=0 cellpadding=0>';
	$vazio='<tr><td colspan=2>&nbsp;</td></tr>';

	$filtra_perspectiva='<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['perspectiva']), 'Filtrar '.$config['temas'].' pel'.$config['genero_perspectiva'].' '.$config['perspectiva'].' dos mesmos.').ucfirst($config['perspectiva']).':'.dicaF().'</td><td>'.	selecionaVetor($perspectivas, 'pg_perspectiva_id', 'class="texto" style="width:250px;" onchange="env.submit();"', $pg_perspectiva_id,'','',$cor).'</td></tr>';
	$procurar_om='<tr><td align=right>'.dica('Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'], 'Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].'.').ucfirst($config['organizacao']).':'.dicaF().'</td><td><div id="combo_cia">'.selecionar_om($cia_id, 'cia_id', 'class=texto size=1 style="width:250px;" onchange="javascript:mudar_om();"').'</div></td><td><a href="javascript:void(0);" onclick="document.env.submit();">'.imagem('icones/filtrar_p.png','Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'],'Clique neste �cone '.imagem('icones/filtrar_p.png').' para filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].' a esquerda.').'</a></td>'.(($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) && !$ver_subordinadas ? '<td><a href="javascript:void(0);" onclick="document.env.ver_subordinadas.value=1; document.env.dept_id.value=\'\';  document.env.ver_dept_subordinados.value=0; document.env.submit();">'.imagem('icones/organizacao_p.gif','Incluir Subordinad'.$config['genero_organizacao'].'s','Clique neste �cone '.imagem('icones/organizacao_p.gif').' para incluir '.$config['genero_organizacao'].'s '.$config['organizacoes'].' subordinad'.$config['genero_organizacao'].'s '.($config['genero_organizacao']=='a' ? '�' : 'ao').' selecionad'.$config['genero_organizacao'].'.').'</a></td>' : '').(($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) && $ver_subordinadas ? '<td><a href="javascript:void(0);" onclick="document.env.ver_subordinadas.value=0; document.env.submit();">'.imagem('icones/nao_sub_om.gif','N�o Incluir Subordinad'.$config['genero_organizacao'].'s','Clique neste �cone '.imagem('icones/nao_sub_om.gif').' para deixar de incluir '.$config['genero_organizacao'].'s '.$config['organizacoes'].' subordinad'.$config['genero_organizacao'].'s '.($config['genero_organizacao']=='a' ? '�' : 'ao').' selecionad'.$config['genero_organizacao'].'.').'</a></td>' : '').($Aplic->profissional ? '<td><input type="hidden" name="dept_id" id="dept_id" value="'.$dept_id.'" />'.(!$dept_id ? '<a href="javascript:void(0);" onclick="escolher_dept();">'.imagem('icones/secoes_p.gif',ucfirst($config['departamento']),'Clique neste �cone '.imagem('icones/secoes_p.gif').' para filtrar pel'.$config['genero_dept'].' '.$config['departamento'].' envolvid'.$config['genero_dept'].' ou don'.$config['genero_dept'].'.').'</a>' : '').'</td>' : '<input type="hidden" name="dept_id" id="dept_id" value="'.$dept_id.'" />').'</tr>'.
	($dept_id ? '<tr><td align=right>'.dica(ucfirst($config['departamento']), 'Filtrar pel'.$config['genero_dept'].' '.strtolower($config['departamento']).' envolvid'.$config['genero_dept'].'.').ucfirst($config['departamento']).':</td><td><input type="text" style="width:250px;" class="texto" name="dept_nome" id="dept_nome" value="'.nome_dept($dept_id).'"></td>'.($dept_id ? '<td><a href="javascript:void(0);" onclick="escolher_dept();">'.imagem('icones/secoes_p.gif',ucfirst($config['departamento']),'Clique neste �cone '.imagem('icones/secoes_p.gif').' para filtrar pel'.$config['genero_dept'].' '.$config['departamento'].' envolvid'.$config['genero_dept'].' ou don'.$config['genero_dept'].'.').'</a></td>'.(($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) && !$ver_dept_subordinados ? '<td><a href="javascript:void(0);" onclick="document.env.ver_dept_subordinados.value=1; document.env.submit();">'.imagem('icones/organizacao_p.gif','Incluir Subordinad'.$config['genero_dept'].'s','Clique neste �cone '.imagem('icones/organizacao_p.gif').' para incluir '.$config['genero_dept'].'s '.$config['departamentos'].' subordinad'.$config['genero_dept'].'s '.($config['genero_dept']=='a' ? '�' : 'ao').' selecionad'.$config['genero_dept'].'.').'</a></td>' : '').(($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) && $ver_dept_subordinados ? '<td><a href="javascript:void(0);" onclick="document.env.ver_dept_subordinados.value=0; document.env.submit();">'.imagem('icones/nao_sub_om.gif','N�o Incluir Subordinad'.$config['genero_dept'].'s','Clique neste �cone '.imagem('icones/nao_sub_om.gif').' para deixar de incluir '.$config['genero_dept'].'s '.$config['departamentos'].' subordinad'.$config['genero_dept'].'s '.($config['genero_dept']=='a' ? '�' : 'ao').' selecionad'.$config['genero_dept'].'.').'</a></td>' : '') : '').'</tr>' : '');
	$procuraBuffer = '<tr><td align=right nowrap="nowrap">'.dica('Pesquisar', 'Pesquisar pelo nome e campos de descri��o').'Pesquisar:'.dicaF().'</td><td><input type="text" class="texto" style="width:250px;" name="tematextobusca" onChange="document.env.submit();" value="'.$pesquisar_texto.'"/></td><td><a href="javascript:void(0);" onclick="url_passar(0, \'m=praticas&a=tema_lista&tab='.$tab.'&tematextobusca=\');">'.imagem('icones/limpar_p.gif','Limpar Pesquisa', 'Clique neste �cone '.imagem('icones/limpar_p.gif').' para limpar a caixa texto de pesquisa.').'</a></td></tr>';
	$selecionar_planejamento='<tr><td align="right" nowrap="nowrap">'.dica('Planejamentos Estrat�gico', 'Utilize esta op��o para filtrar pelo planejamentos estrat�gico que est� vinculad'.$config['genero_fator'].'.').'Planejamentos Estrat�gico:</td><td>'.dicaF().selecionaVetor($planos, 'pg_id', 'onchange="env.submit();" style="width:250px;" class="texto"', $pg_id).'</td></tr>';
	$procurar_usuario='<tr><td align=right nowrap="nowrap">'.dica(ucfirst($config['usuario']), 'Filtrar pel'.$config['genero_usuario'].' '.$config['usuario'].' escolhido na caixa de sele��o � direita.').ucfirst($config['usuario']).':'.dicaF().'</td><td><input type="hidden" id="usuario_id" name="usuario_id" value="'.$usuario_id.'" /><input type="text" id="nome_responsavel" name="nome_responsavel" value="'.nome_usuario($usuario_id).'" style="width:250px;" class="texto" READONLY /></td><td><a href="javascript: void(0);" onclick="popResponsavel();">'.imagem('icones/usuarios.gif','Selecionar '.ucfirst($config['usuario']),'Clique neste �cone '.imagem('icones/usuarios.gif').' para selecionar '.($config['genero_usuario']=='o' ? 'um' : 'uma').' '.$config['usuario'].'.').'</a></td></tr>';
	$novo_tema=($podeAdicionar ? '<tr><td nowrap="nowrap" align=right>'.dica('Nov'.$config['genero_tema'].' '.ucfirst($config['tema']).'', 'Criar um nov'.$config['genero_tema'].' '.$config['tema'].'.').'<a href="javascript: void(0)" onclick="javascript:env.a.value=\'tema_editar\'; env.submit();" ><img src="'.acharImagem('tema_novo.png').'" border=0 width="16" heigth="16" /></a>'.dicaF().'</td></tr>' : '');
	$imprimir='<tr><td nowrap="nowrap" align="right">'.dica('Imprimir '.ucfirst($config['temas']), 'Clique neste �cone '.imagem('imprimir_p.png').' para imprimir a lista de '.$config['temas'].'.').'<a href="javascript: void(0);" onclick ="url_passar(1, \'m='.$m.'&a='.$a.'&dialogo=1&tab='.$tab.'\');">'.imagem('imprimir_p.png').'</a>'.dicaF().'</td></tr>';

	$botao_favorito='<tr><td nowrap="nowrap">'.dica('Favoritos', 'Criar ou editar um grupo de planos de a��o favoritos, para uma r�pida filtragem.').'<a href="javascript: void(0)" onclick="url_passar(0, \'m=publico&a=favoritos&tema=1\');"><img src="'.acharImagem('favorito_p.png').'" border=0 width="16" heigth="16" /></a>'.dicaF().'</td></tr>';	
	$botao_trava='<tr id="combo_travado" '.($favorito_trava_campo ? '' : 'style="display:none"').'><td nowrap="nowrap"><a href="javascript: void(0)" onclick="travar(0);">'.imagem('cadeado_fechado.png', 'Destravar Filtros', 'Clique neste �cone '.imagem('cadeado_fechado.png').' para destravar os filtros.').'</a>'.dicaF().'</td></tr><tr id="combo_destravado" '.(!$favorito_trava_campo ? '' : 'style="display: none"').'><td nowrap="nowrap"><a href="javascript: void(0)" onclick="travar(1);">'.imagem('cadeado_aberto.png', 'Travar Filtros', 'Clique neste �cone '.imagem('cadeado_aberto.png').' para travar os filtros.').'</a>'.dicaF().'</td></tr>';
		
	if($filtro_prioridade_tema) $botao_prioridade=($Aplic->profissional ? '<tr><td><a href="javascript: void(0)" onclick="priorizacao(0);">'.imagem('icones/priorizacao_nao_p.png', 'Cancelar a Prioriza��o' , 'Clique neste �cone '.imagem('icones/priorizacao_nao_p.png').' para cancelar a prioriza��o.').'</a>'.dicaF().'</td></tr>' : '');
	else $botao_prioridade=($Aplic->profissional ? '<tr><td><a href="javascript: void(0)" onclick="priorizacao(1);">'.imagem('icones/priorizacao_p.png', 'Prioriza��o' , 'Clique neste �cone '.imagem('icones/priorizacao_p.png').' para priorizar.').'</a>'.dicaF().'</td></tr>' : '');
	
		
	$saida.='<tr><td><table cellspacing=0 cellpadding=0>'.$procurar_om.$procurar_usuario.$selecionar_planejamento.$procuraBuffer.$filtra_perspectiva.$favoritos.'</table></td><td><table cellspacing=0 cellpadding=0>'.$novo_tema.$imprimir.$botao_prioridade.$botao_favorito.$botao_trava.'</table></td></tr></table>';
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
	echo '<input type="hidden" name="ver_subordinadas" value="'.$ver_subordinadas.'" />';
	echo '<input type="hidden" name="ver_dept_subordinados" value="'.$ver_dept_subordinados.'" />';
	$botoesTitulo = new CBlocoTitulo('Lista de '.ucfirst($config['temas']), 'tema.png', $m, $m.'.'.$a);
	$filtra_perspectiva='<tr><td align="right" nowrap="nowrap">'.dica(ucfirst($config['perspectiva']), 'Filtrar '.$config['temas'].' pel'.$config['genero_perspectiva'].' '.$config['perspectiva'].' dos mesmos.').ucfirst($config['perspectiva']).':'.dicaF().'</td><td>'.	selecionaVetor($perspectivas, 'pg_perspectiva_id', 'class="texto" style="width:250px;" onchange="env.submit();"', $pg_perspectiva_id,'','',$cor).'</td></tr>';
	$procurar_om='<tr><td align=right>'.dica('Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'], 'Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].'.').ucfirst($config['organizacao']).':'.dicaF().'</td><td><div id="combo_cia">'.selecionar_om($cia_id, 'cia_id', 'class=texto size=1 style="width:250px;" onchange="javascript:mudar_om();"').'</div></td><td><a href="javascript:void(0);" onclick="document.env.submit();">'.imagem('icones/filtrar_p.png','Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'],'Clique neste �cone '.imagem('icones/filtrar_p.png').' para filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].' a esquerda.').'</a></td>'.(($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) && !$ver_subordinadas ? '<td><a href="javascript:void(0);" onclick="document.env.ver_subordinadas.value=1; document.env.dept_id.value=\'\';  document.env.ver_dept_subordinados.value=0; document.env.submit();">'.imagem('icones/organizacao_p.gif','Incluir Subordinad'.$config['genero_organizacao'].'s','Clique neste �cone '.imagem('icones/organizacao_p.gif').' para incluir '.$config['genero_organizacao'].'s '.$config['organizacoes'].' subordinad'.$config['genero_organizacao'].'s '.($config['genero_organizacao']=='a' ? '�' : 'ao').' selecionad'.$config['genero_organizacao'].'.').'</a></td>' : '').(($Aplic->usuario_pode_outra_cia || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todas_cias) && $ver_subordinadas ? '<td><a href="javascript:void(0);" onclick="document.env.ver_subordinadas.value=0; document.env.submit();">'.imagem('icones/nao_sub_om.gif','N�o Incluir Subordinad'.$config['genero_organizacao'].'s','Clique neste �cone '.imagem('icones/nao_sub_om.gif').' para deixar de incluir '.$config['genero_organizacao'].'s '.$config['organizacoes'].' subordinad'.$config['genero_organizacao'].'s '.($config['genero_organizacao']=='a' ? '�' : 'ao').' selecionad'.$config['genero_organizacao'].'.').'</a></td>' : '').($Aplic->profissional ? '<td><input type="hidden" name="dept_id" id="dept_id" value="'.$dept_id.'" />'.(!$dept_id ? '<a href="javascript:void(0);" onclick="escolher_dept();">'.imagem('icones/secoes_p.gif',ucfirst($config['departamento']),'Clique neste �cone '.imagem('icones/secoes_p.gif').' para filtrar pel'.$config['genero_dept'].' '.$config['departamento'].' envolvid'.$config['genero_dept'].' ou don'.$config['genero_dept'].'.').'</a>' : '').'</td>' : '<input type="hidden" name="dept_id" id="dept_id" value="'.$dept_id.'" />').'</tr>'.
	($dept_id ? '<tr><td align=right>'.dica(ucfirst($config['departamento']), 'Filtrar pel'.$config['genero_dept'].' '.strtolower($config['departamento']).' envolvid'.$config['genero_dept'].'.').ucfirst($config['departamento']).':</td><td><input type="text" style="width:250px;" class="texto" name="dept_nome" id="dept_nome" value="'.nome_dept($dept_id).'"></td>'.($dept_id ? '<td><a href="javascript:void(0);" onclick="escolher_dept();">'.imagem('icones/secoes_p.gif',ucfirst($config['departamento']),'Clique neste �cone '.imagem('icones/secoes_p.gif').' para filtrar pel'.$config['genero_dept'].' '.$config['departamento'].' envolvid'.$config['genero_dept'].' ou don'.$config['genero_dept'].'.').'</a></td>'.(($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) && !$ver_dept_subordinados ? '<td><a href="javascript:void(0);" onclick="document.env.ver_dept_subordinados.value=1; document.env.submit();">'.imagem('icones/organizacao_p.gif','Incluir Subordinad'.$config['genero_dept'].'s','Clique neste �cone '.imagem('icones/organizacao_p.gif').' para incluir '.$config['genero_dept'].'s '.$config['departamentos'].' subordinad'.$config['genero_dept'].'s '.($config['genero_dept']=='a' ? '�' : 'ao').' selecionad'.$config['genero_dept'].'.').'</a></td>' : '').(($Aplic->usuario_pode_dept_subordinado || $Aplic->usuario_super_admin || $Aplic->usuario_pode_todos_depts) && $ver_dept_subordinados ? '<td><a href="javascript:void(0);" onclick="document.env.ver_dept_subordinados.value=0; document.env.submit();">'.imagem('icones/nao_sub_om.gif','N�o Incluir Subordinad'.$config['genero_dept'].'s','Clique neste �cone '.imagem('icones/nao_sub_om.gif').' para deixar de incluir '.$config['genero_dept'].'s '.$config['departamentos'].' subordinad'.$config['genero_dept'].'s '.($config['genero_dept']=='a' ? '�' : 'ao').' selecionad'.$config['genero_dept'].'.').'</a></td>' : '') : '').'</tr>' : '');
	$procuraBuffer = '<tr><td align=right nowrap="nowrap">'.dica('Pesquisar', 'Pesquisar pelo nome e campos de descri��o').'Pesquisar:'.dicaF().'</td><td><input type="text" class="texto" style="width:250px;" name="tematextobusca" onChange="document.env.submit();" value="'.$pesquisar_texto.'"/></td><td><a href="javascript:void(0);" onclick="url_passar(0, \'m=praticas&a=tema_lista&tab='.$tab.'&tematextobusca=\');">'.imagem('icones/limpar_p.gif','Limpar Pesquisa', 'Clique neste �cone '.imagem('icones/limpar_p.gif').' para limpar a caixa texto de pesquisa.').'</a></td></tr>';
	$selecionar_planejamento='<tr><td align="right" nowrap="nowrap">'.dica('Planejamentos Estrat�gico', 'Utilize esta op��o para filtrar pelo planejamentos estrat�gico que est� vinculad'.$config['genero_fator'].'.').'Planejamentos Estrat�gico:</td><td>'.dicaF().selecionaVetor($planos, 'pg_id', 'onchange="env.submit();" style="width:250px;" class="texto"', $pg_id).'</td></tr>';
	$procurar_usuario='<tr><td align=right nowrap="nowrap">'.dica(ucfirst($config['usuario']), 'Filtrar pel'.$config['genero_usuario'].' '.$config['usuario'].' escolhido na caixa de sele��o � direita.').ucfirst($config['usuario']).':'.dicaF().'</td><td><input type="hidden" id="usuario_id" name="usuario_id" value="'.$usuario_id.'" /><input type="text" id="nome_responsavel" name="nome_responsavel" value="'.nome_usuario($usuario_id).'" style="width:250px;" class="texto" READONLY /></td><td><a href="javascript: void(0);" onclick="popResponsavel();">'.imagem('icones/usuarios.gif','Selecionar '.ucfirst($config['usuario']),'Clique neste �cone '.imagem('icones/usuarios.gif').' para selecionar '.($config['genero_usuario']=='o' ? 'um' : 'uma').' '.$config['usuario'].'.').'</a></td></tr>';
	$botoesTitulo->adicionaCelula('<table cellspacing=0 cellpadding=0>'.$procurar_om.$procurar_usuario.$selecionar_planejamento.$procuraBuffer.$filtra_perspectiva.'</table>');
	if ($podeAdicionar) $botoesTitulo->adicionaCelula('<table><tr><td nowrap="nowrap">'.dica('Nov'.$config['genero_tema'].' '.ucfirst($config['tema']).'', 'Criar um nov'.$config['genero_tema'].' '.$config['tema'].'.').'<a class="botao" href="javascript: void(0)" onclick="javascript:env.a.value=\'tema_editar\'; env.submit();" ><span>nov'.$config['genero_tema'].'</span></a>'.dicaF().'</td></tr><tr><td nowrap="nowrap"></td></tr></table>');
	$botoesTitulo->adicionaCelula('<td nowrap="nowrap" align="right">'.dica('Imprimir '.ucfirst($config['temas']), 'Clique neste �cone '.imagem('imprimir_p.png').' para imprimir a lista de '.$config['temas'].'.').'<a href="javascript: void(0);" onclick ="url_passar(1, \'m='.$m.'&a='.$a.'&dialogo=1&tab='.$tab.'\');">'.imagem('imprimir_p.png').'</a>'.dicaF());
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
	echo 	'<font size="4"><center>Lista de '.ucfirst($config['temas']).'</center></font>';
	}


$caixaTab = new CTabBox('m='.$m.'&a='.$a, '', $tab);
if (!$dialogo){
	$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/tema_ver_idx', 'Ativ'.$config['genero_tema'].'s',null,null,'Ativ'.$config['genero_tema'].'s','Visualizar '.$config['genero_tema'].'s '.$config['temas'].' ativ'.$config['genero_tema'].'s.');
	$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/tema_ver_idx', 'Inativ'.$config['genero_tema'].'s',null,null,'Inativ'.$config['genero_tema'].'s','Visualizar '.$config['genero_tema'].'s '.$config['temas'].' inativ'.$config['genero_tema'].'s.');
	$caixaTab->adicionar(BASE_DIR.'/modulos/praticas/tema_ver_idx', 'Tod'.$config['genero_tema'].'s',null,null,'Tod'.$config['genero_tema'].'s','Visualizar tod'.$config['genero_tema'].'s '.$config['genero_tema'].'s '.$config['temas'].'.');
	$caixaTab->mostrar('','','','',true);
	echo estiloFundoCaixa('','', $tab);
	}
else {
	include_once(BASE_DIR.'/modulos/praticas/tema_ver_idx.php');
	echo '<script type="text/javascript">self.print();</script>';
	}

if($Aplic->profissional){
    $Aplic->carregarComboMultiSelecaoJS();
	}
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

function priorizacao() {
	parent.gpwebApp.popUp("Prioriza��o", 400, 300, 'm=publico&a=filtro_priorizacao_pro&dialogo=1&acao=1&filtro_prioridade='+env.filtro_prioridade_tema.value, window.setFiltroPriorizacao, window);
	}

function setFiltroPriorizacao(filtro_prioridade_tema){
	env.filtro_prioridade_tema.value=filtro_prioridade_tema;
	env.submit();
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

function favoritos(){
	url_passar(0, 'm=publico&a=favoritos&objetivo=1&cia_id='+document.getElementById('cia_id').value+'&pg_ano='+document.getElementById('pg_ano').value);
	}


function mudar_om(){
	xajax_selecionar_om_ajax(document.getElementById('cia_id').value,'cia_id','combo_cia', 'class="texto" size=1 style="width:250px;" onchange="javascript:mudar_om();"');
	}

function popResponsavel(campo) {
	if (window.parent.gpwebApp) parent.gpwebApp.popUp('Respons�vel', 500, 500, 'm=publico&a=selecao_unico_usuario&dialogo=1&chamar_volta=setResponsavel&cia_id='+document.getElementById('cia_id').value+'&usuario_id='+document.getElementById('usuario_id').value, window.setResponsavel, window);
	else window.open('./index.php?m=publico&a=selecao_unico_usuario&dialogo=1&chamar_volta=setResponsavel&cia_id='+document.getElementById('cia_id').value+'&usuario_id='+document.getElementById('usuario_id').value, 'Respons�vel','height=500,width=500,resizable,scrollbars=yes, left=0, top=0');
	}

function setResponsavel(usuario_id, posto, nome, funcao, campo, nome_cia){
	document.getElementById('usuario_id').value=(usuario_id ? usuario_id : 0);
	document.getElementById('nome_responsavel').value=posto+' '+nome+(funcao ? ' - '+funcao : '')+(nome_cia && <?php echo $Aplic->getPref('om_usuario') ?>? ' - '+nome_cia : '');
	env.submit();
	}
</script>