<?php

include_once BASE_DIR.'/modulos/projetos/artefato.class.php';
include_once BASE_DIR.'/modulos/projetos/artefato_template.class.php';

$projeto_id = getParam($_REQUEST, 'projeto_id', 0);
$baseline_id = getParam($_REQUEST, 'baseline_id', 0);

if ($Aplic->profissional) {
	$barra=codigo_barra('projeto', $projeto_id, $baseline_id);
	if ($barra['cabecalho']) echo $barra['imagem'];
	}

$sql = new BDConsulta();
$sql->adTabela(($baseline_id ? 'baseline_' : '').'projetos','projetos');
$sql->adCampo('projetos.*');
$sql->adOnde('projeto_id = '.(int)$projeto_id);
if ($baseline_id) $sql->adOnde('baseline_id='.(int)$baseline_id);
$dados = $sql->Linha();
$sql->limpar();






$sql->adTabela('artefatos_tipo');
$sql->adCampo('artefato_tipo_campos, artefato_tipo_endereco, artefato_tipo_html');
$sql->adOnde('artefato_tipo_civil=\''.$config['anexo_civil'].'\'');
$sql->adOnde('artefato_tipo_arquivo=\'cabecalho_projeto_pro.html\'');
$linha = $sql->linha();
$sql->limpar();
$campos = unserialize($linha['artefato_tipo_campos']);

$modelo= new Modelo;
$modelo->set_modelo_tipo(1);
foreach((array)$campos['campo'] as $posicao => $campo) $modelo->set_campo($campo['tipo'], str_replace('\"','"',$campo['dados']), $posicao);
$tpl = new Template($linha['artefato_tipo_html'],false,false, false, true);
$modelo->set_modelo($tpl);
echo '<table align="left" cellspacing=0 cellpadding=0 width="100%"><tr><td>';
for ($i=1; $i <= $modelo->quantidade(); $i++){
	$campo='campo_'.$i;
	$tpl->$campo = $modelo->get_campo($i);
	} 
echo $tpl->exibir($modelo->edicao); 
echo '</td></tr>';

echo '</table>';


$obj = new CProjeto(($baseline_id ? true : false));
$obj->load($projeto_id, true, $baseline_id);

$lista_projeto=0;
if ($Aplic->profissional){
	$vetor=array($projeto_id => $projeto_id);
	portfolio_projetos($projeto_id, $vetor);
	$lista_projeto=implode(',',$vetor);
	}


$data_fim = intval($obj->projeto_data_fim) ? new CData($obj->projeto_data_fim) : null;

if ($obj->projeto_portfolio){
	$data_fim_atual=portfolio_tarefa_fim($projeto_id);
	$data_inicio_atual=portfolio_tarefa_inicio($projeto_id);

	$vetor=array();
	portfolio_tarefas($projeto_id, $vetor, $baseline_id);
	if(count($vetor)){
		$lista=implode(',',$vetor);
		$sql->adTabela(($baseline_id ? 'baseline_' : '').'tarefas','tarefas');
		$sql->adCampo('tarefa_id');
		$sql->adOnde('tarefa_id IN ('.$lista.')');
		$sql->adOnde('tarefa_projetoex_id IS NULL');
		if ($baseline_id) $sql->adOnde('baseline_id='.(int)$baseline_id);
		$sql->adOnde('tarefa_inicio=\''.$data_inicio_atual.'\'');
		$id_tarefa_inicio_atual = $sql->resultado();
		$sql->limpar();

		$sql->adTabela(($baseline_id ? 'baseline_' : '').'tarefas','tarefas');
		$sql->adCampo('tarefa_id');
		$sql->adOnde('tarefa_projetoex_id IS NULL');
		$sql->adOnde('tarefa_id IN ('.$lista.')');
		if ($baseline_id) $sql->adOnde('baseline_id='.(int)$baseline_id);
		$sql->adOnde('tarefa_fim=\''.$data_fim_atual.'\'');
		$id_tarefa_fim_atual = $sql->resultado();
		$sql->limpar();
		}
	}
else {
	$sql->adTabela(($baseline_id ? 'baseline_' : '').'tarefas','tarefas');
	$sql->adCampo('MIN(tarefa_inicio)');
	$sql->adOnde('tarefa_projeto '.($lista_projeto ? 'IN('.$lista_projeto.')' : '='.(int)$projeto_id));
	$sql->adOnde('tarefa_projetoex_id IS NULL');
	if ($baseline_id) $sql->adOnde('baseline_id='.(int)$baseline_id);
	$sql->adOnde("tarefa_inicio IS NOT NULL AND tarefa_inicio != '000-00-00 00:00:00'");
	$data_inicio_atual = $sql->resultado();
	$sql->limpar();

	$sql->adTabela(($baseline_id ? 'baseline_' : '').'tarefas','tarefas');
	$sql->adCampo('tarefa_id');
	$sql->adOnde('tarefa_projeto '.($lista_projeto ? 'IN('.$lista_projeto.')' : '='.(int)$projeto_id));
	$sql->adOnde('tarefa_projetoex_id IS NULL');
	if ($baseline_id) $sql->adOnde('baseline_id='.(int)$baseline_id);
	$sql->adOnde('tarefa_inicio=\''.$data_inicio_atual.'\'');
	$id_tarefa_inicio_atual = $sql->resultado();
	$sql->limpar();


	$sql->adTabela(($baseline_id ? 'baseline_' : '').'tarefas','tarefas');
	$sql->adCampo('MAX(tarefa_fim)');
	$sql->adOnde('tarefa_projeto '.($lista_projeto ? 'IN('.$lista_projeto.')' : '='.(int)$projeto_id));
	$sql->adOnde('tarefa_projetoex_id IS NULL');
	if ($baseline_id) $sql->adOnde('baseline_id='.(int)$baseline_id);
	$sql->adOnde("tarefa_fim IS NOT NULL AND tarefa_fim != '000-00-00 00:00:00'");
	$data_fim_atual = $sql->resultado();
	$sql->limpar();

	$sql->adTabela(($baseline_id ? 'baseline_' : '').'tarefas','tarefas');
	$sql->adCampo('tarefa_id');
	$sql->adOnde('tarefa_projeto '.($lista_projeto ? 'IN('.$lista_projeto.')' : '='.(int)$projeto_id));
	$sql->adOnde('tarefa_projetoex_id IS NULL');
	if ($baseline_id) $sql->adOnde('baseline_id='.(int)$baseline_id);
	$sql->adOnde('tarefa_fim=\''.$data_fim_atual.'\'');
	$id_tarefa_fim_atual = $sql->resultado();
	$sql->limpar();
	}

$sql->adTabela('tarefas');
$sql->adCampo('COUNT(distinct tarefas.tarefa_id) AS total_tarefas');
$sql->adOnde('tarefa_projeto '.($lista_projeto ? 'IN('.$lista_projeto.')' : '='.(int)$projeto_id));
$sql->adOnde('tarefa_projetoex_id IS NULL');
$temTarefas = $sql->Resultado();
$sql->limpar();	
	
if ($temTarefas){
	$sql->adTabela('tarefa_log');
	$sql->adTabela('tarefas');
	$sql->adCampo('ROUND(SUM(tarefa_log_horas),2)');
	$sql->adOnde('tarefa_projetoex_id IS NULL');
	$sql->adOnde('tarefa_log_tarefa = tarefa_id AND tarefa_projeto '.($lista_projeto ? 'IN('.$lista_projeto.')' : '='.(int)$projeto_id));
	$horas_trabalhadas_registros = $sql->Resultado();
	$sql->limpar();
	$horas_trabalhadas_registros = rtrim($horas_trabalhadas_registros, '.');

	$sql->adTabela('tarefas');
	$sql->adCampo('SUM(tarefa_duracao)');
	$sql->adOnde('tarefa_projeto '.($lista_projeto ? 'IN('.$lista_projeto.')' : '='.(int)$projeto_id));
	$sql->adOnde('tarefa_dinamica != 1');
	$sql->adOnde('tarefa_projetoex_id IS NULL');
	$totalHoras = $sql->Resultado();
	$sql->limpar();

	$sql->limpar();
	$sql->adTabela('tarefa_designados');
	$sql->esqUnir('tarefas', 'tarefas', 'tarefas.tarefa_id = tarefa_designados.tarefa_id');
	$sql->adCampo('ROUND(SUM(tarefa_duracao*perc_designado/100),2)');
	$sql->adOnde('tarefa_projetoex_id IS NULL');
	$sql->adOnde('tarefa_projeto '.($lista_projeto ? 'IN('.$lista_projeto.')' : '='.(int)$projeto_id).' AND tarefa_dinamica != 1 AND tarefa_duracao!=0');
	$totalhoras_designados_tarefas = $sql->Resultado();
	$sql->limpar();
	}
else  $horas_trabalhadas_registros = $totalHoras = $totalhoras_designados_tarefas = 0.00;	
	
$tarefasCriticas = ($projeto_id > 0) ? $obj->getTarefasCriticas($projeto_id) : null;
$PrioridadeProjeto = getSisValor('PrioridadeProjeto');
$corPrioridadeProjeto = getSisValor('CorPrioridadeProjeto');	
$paises = getPais('Paises');

$sql->adTabela('municipios_coordenadas');
$sql->adCampo('count(municipio_id)');
$tem_coordenadas=$sql->resultado();
$sql->limpar();



$estilo1='style="font-family:Times New Roman, Times, serif; font-size:12pt; font-weight:bold"';
$estilo2='style="font-family:Times New Roman, Times, serif; font-size:12pt; text-align: justify;"';




echo '<table align="left" cellspacing=0 cellpadding=0 width=100%><tr><td>&nbsp;</td></tr>';

$nr=1;

if (isset($obj->projeto_codigo) && $obj->projeto_codigo) echo '<tr><td '.$estilo1.'>'.$nr++.'. CÓDIGO</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_codigo.'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_setor) && $obj->projeto_setor) echo '<tr><td '.$estilo1.'>'.$nr++.'. '.strtoupper($config['setor']).'</td></tr><tr><td '.$estilo2.'>'.$obj->getSetor().'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_segmento) && $obj->projeto_segmento) echo '<tr><td '.$estilo1.'>'.$nr++.'. '.strtoupper($config['segmento']).'</td></tr><tr><td '.$estilo2.'>'.$obj->getSegmento().'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_intervencao) && $obj->projeto_intervencao) echo '<tr><td '.$estilo1.'>'.$nr++.'. '.strtoupper($config['intervencao']).'</td></tr><tr><td '.$estilo2.'>'.$obj->getIntervencao().'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_tipo_intervencao) && $obj->projeto_tipo_intervencao) echo '<tr><td '.$estilo1.'>'.$nr++.'. '.strtoupper($config['tipo']).'</td></tr><tr><td '.$estilo2.'>'.$obj->getTipoIntervencao().'</td></tr><tr><td>&nbsp;</td></tr>';

if (isset($obj->projeto_descricao) && $obj->projeto_descricao) echo '<tr><td '.$estilo1.'>'.$nr++.'. O QUE</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_descricao.'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_objetivos) && $obj->projeto_objetivos) echo '<tr><td '.$estilo1.'>'.$nr++.'. POR QUE</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_objetivos.'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_como) && $obj->projeto_como) echo '<tr><td '.$estilo1.'>'.$nr++.'. COMO</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_como.'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_localizacao) && $obj->projeto_localizacao) echo '<tr><td '.$estilo1.'>'.$nr++.'. ONDE</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_localizacao.'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_beneficiario) && $obj->projeto_beneficiario) echo '<tr><td '.$estilo1.'>'.$nr++.'. BENEFICIÁRIO</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_beneficiario.'</td></tr><tr><td>&nbsp;</td></tr>';

if ($obj->projeto_data_inicio && $obj->projeto_data_fim) echo '<tr><td '.$estilo1.'>'.$nr++.'. INÍCIO E TÉRMINO PREVISTO</td></tr><tr><td '.$estilo2.'>'.$nr++.'. '.retorna_data($obj->projeto_data_inicio, false).' | '.retorna_data($obj->projeto_data_fim, false).'</td></tr><tr><td>&nbsp;</td></tr>';

$data_final=($projeto_id > 0 ? ($data_fim_atual ? '<span '.($data_fim_atual > $obj->projeto_data_fim ? 'style="color:red; font-weight:bold"' : '').'>'.retorna_data($data_fim_atual, false).'</span>'.($id_tarefa_fim_atual ? ' - '.link_tarefa($id_tarefa_fim_atual) : '') : '') : null);
$data_inicial=($projeto_id > 0 ? ($data_inicio_atual ? '<span '.($data_inicio_atual > $obj->projeto_data_inicio ? 'style="color:red; font-weight:bold"' : '').'>'.retorna_data($data_inicio_atual, false).'</span>'.($id_tarefa_inicio_atual ? ' - '.link_tarefa($id_tarefa_inicio_atual) : '') : '') : null);

if ($data_inicial) echo '<tr><td '.$estilo1.'>'.$nr++.'. INÍCIO E TÉRMINO ATUALIZADO</td></tr><tr><td '.$estilo2.'>'.$data_inicial.' | '.$data_final.'</td></tr><tr><td>&nbsp;</td></tr>';

if (isset($obj->projeto_responsavel) && $obj->projeto_responsavel) echo '<tr><td '.$estilo1.'>'.$nr++.'. '.strtoupper($config['gerente']).'</td></tr><tr><td '.$estilo2.'>'.nome_usuario($obj->projeto_responsavel, true).'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_supervisor) && $obj->projeto_supervisor) echo '<tr><td '.$estilo1.'>'.$nr++.'. '.strtoupper($config['supervisor']).'</td></tr><tr><td '.$estilo2.'>'.nome_usuario($obj->projeto_supervisor, true).'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_autoridade) && $obj->projeto_autoridade) echo '<tr><td '.$estilo1.'>'.$nr++.'. '.strtoupper($config['autoridade']).'</td></tr><tr><td '.$estilo2.'>'.nome_usuario($obj->projeto_autoridade, true).'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_cliente) && $obj->projeto_cliente) echo '<tr><td '.$estilo1.'>'.$nr++.'. '.strtoupper($config['cliente']).'</td></tr><tr><td '.$estilo2.'>'.nome_usuario($obj->projeto_cliente, true).'</td></tr><tr><td>&nbsp;</td></tr>';





$empregosObra=$obj->getEmpregosObra($baseline_id);
$empregosDiretos=$obj->getEmpregosDiretos($baseline_id);
$empregosIndiretos=$obj->getEmpregosIndiretos($baseline_id);

if ($empregosObra) echo '<tr><td '.$estilo1.'>'.$nr++.'. EMPREGOS (EXECUÇÃO)</td></tr><tr><td '.$estilo2.'>'.$empregosObra.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($empregosDiretos) echo '<tr><td '.$estilo1.'>'.$nr++.'. EMPREGOS DIRETOS</td></tr><tr><td '.$estilo2.'>'.$empregosDiretos.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($empregosIndiretos) echo '<tr><td '.$estilo1.'>'.$nr++.'. EMPREGOS INDIRETOS</td></tr><tr><td '.$estilo2.'>'.$empregosIndiretos.'</td></tr><tr><td>&nbsp;</td></tr>';
$projTipo = getSisValor('TipoProjeto');
if (isset($projTipo[$obj->projeto_tipo])) echo '<tr><td '.$estilo1.'>'.$nr++.'. CATEGORIA</td></tr><tr><td '.$estilo2.'>'.$projTipo[$obj->projeto_tipo].'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_url) && $obj->projeto_url) echo '<tr><td '.$estilo1.'>'.$nr++.'. URL</td></tr><tr><td '.$estilo2.'><a href="'.$obj->projeto_url.'" target="_new">'.$obj->projeto_url.'</a></td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_url_externa) && $obj->projeto_url_externa) echo '<tr><td '.$estilo1.'>'.$nr++.'. PÁGINA WEB</td></tr><tr><td '.$estilo2.'><a href="http://'.$obj->projeto_url_externa.'" target="_new">'.$obj->projeto_url_externa.'</a></td></tr><tr><td>&nbsp;</td></tr>';



if ($totalhoras_designados_tarefas) echo '<tr><td '.$estilo1.'>'.$nr++.'. HORAS DE TRABALHO</td></tr><tr><td '.$estilo2.'>'.number_format($totalhoras_designados_tarefas, 2, ',', '.').'&nbsp;'.($totalhoras_designados_tarefas > 0 ? '('.(int)($totalhoras_designados_tarefas/($config['horas_trab_diario'] ? $config['horas_trab_diario'] : 8)).' dias)' : '').'</td></tr><tr><td>&nbsp;</td></tr>';
if ($horas_trabalhadas_registros) echo '<tr><td '.$estilo1.'>'.$nr++.'. HORAS DOS REGISTROS</td></tr><tr><td '.$estilo2.'>'.number_format($horas_trabalhadas_registros, 2, ',', '.').'&nbsp;'.($horas_trabalhadas_registros > 0 ? '('.(int)($horas_trabalhadas_registros/($config['horas_trab_diario'] ? $config['horas_trab_diario'] : 8)).' dias)' : '').'</td></tr><tr><td>&nbsp;</td></tr>';
echo '<tr><td '.$estilo1.'>'.$nr++.'. PRAZO DE EXECUÇÃO D'.strtoupper($obj->projeto_portfolio ? $config['genero_portfolio'].' '.$config['portfolio'] : $config['genero_projeto'].' '.$config['projeto']).'</td></tr><tr><td '.$estilo2.'>'.number_format((float)$totalHoras, 2, ',', '.').'&nbsp;'.($totalHoras > 0 ? '('.(int)($totalHoras/($config['horas_trab_diario'] ? $config['horas_trab_diario'] : 8)).' dias)' : '').'</td></tr><tr><td>&nbsp;</td></tr>';
if ($totalhoras_designados_tarefas && $totalHoras) echo '<tr><td '.$estilo1.'>'.$nr++.'. HOMEM/HORA</td></tr><tr><td '.$estilo2.'>'.number_format(($totalhoras_designados_tarefas/$totalHoras), 2, ',', '.').'&nbsp;h/hr</td></tr><tr><td>&nbsp;</td></tr>';

$sql->adTabela('projetos');
$sql->esqUnir('estado', 'estado', 'projeto_estado=estado_sigla');
$sql->esqUnir('municipios', 'municipios', 'projeto_cidade=municipio_id');
$sql->adCampo('estado_nome, municipio_nome');
$sql->adOnde('projeto_id='.(int)$projeto_id);
$endereco=$sql->Linha();
$sql->limpar();


if (isset($obj->projeto_endereco1) && $obj->projeto_endereco1) echo '<tr valign="top"><td '.$estilo1.'>'.$nr++.'. ENDEREÇO</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_endereco1.(($obj->projeto_endereco2) ? '<br />'.$obj->projeto_endereco2 : '') .($obj->projeto_cidade || $obj->projeto_estado || $obj->projeto_pais ? '<br>' : '').$endereco['municipio_nome'].($obj->projeto_estado ? ' - ' : '').$obj->projeto_estado.($obj->projeto_pais ? ' - '.$paises[$obj->projeto_pais] : '').(($obj->projeto_cep) ? '<br />'.$obj->projeto_cep : '').'</td></tr><tr><td>&nbsp;</td></tr>';
elseif ($endereco['municipio_nome']) echo '<tr valign="top"><td '.$estilo1.'>'.$nr++.'. ENDEREÇO</td></tr><tr><td '.$estilo2.'>'.$endereco['municipio_nome'].($obj->projeto_estado ? ' - ' : '').$endereco['estado_nome'].($obj->projeto_pais ? ' - '.$paises[$obj->projeto_pais] : '').'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_latitude) && isset($obj->projeto_longitude) && $obj->projeto_latitude && $obj->projeto_longitude) echo '<tr><td '.$estilo1.'>'.$nr++.'. COORDENADAS</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_latitude.'º '.$obj->projeto_longitude.'º</td></tr><tr><td>&nbsp;</td></tr>';

$sql->adTabela(($baseline_id ? 'baseline_' : '').'municipio_lista','municipio_lista');
$sql->esqUnir('municipios', 'municipios', 'municipios.municipio_id=municipio_lista_municipio');
$sql->adCampo('DISTINCT municipios.municipio_id, municipio_nome, estado_sigla');
$sql->adOnde('municipio_lista_projeto '.($lista_projeto ? 'IN('.$lista_projeto.')' : '='.(int)$projeto_id));
if ($baseline_id) $sql->adOnde('baseline_id='.(int)$baseline_id);
$sql->adOrdem('estado_sigla, municipio_nome');
$lista_municipios = $sql->Lista();
$sql->limpar();

$plural_municipio=(count($lista_municipios)>1 ? 's' : '');


$saida_municipios='';
if (isset($lista_municipios) && count($lista_municipios)){
		$plural=(count($lista_municipios)>1 ? 's' : '');
		$saida_municipios.= '<table cellspacing=0 cellpadding=0 width="100%">';
		$saida_municipios.= '<tr><td '.$estilo2.'>'.$lista_municipios[0]['municipio_nome'].'-'.$lista_municipios[0]['estado_sigla'];
		$qnt_lista_municipios=count($lista_municipios);
		if ($qnt_lista_municipios > 1){
				$lista='';
				for ($i = 1, $i_cmp = $qnt_lista_municipios; $i < $i_cmp; $i++) $lista.=$lista_municipios[$i]['municipio_nome'].'-'.$lista_municipios[$i]['estado_sigla'].'<br>';
				$saida_municipios.= '<br>'.$lista;
				}
		$saida_municipios.= '</td></tr></table>';
		}
if ($saida_municipios) echo '<tr><td '.$estilo1.'>'.$nr++.'. MUNICÍPIO'.$plural.'</td></tr><tr><td '.$estilo2.'>'.$saida_municipios.'</td></tr><tr><td>&nbsp;</td></tr>';


if ($obj->projeto_justificativa) echo '<tr><td '.$estilo1.'>'.$nr++.'. JUSTIFICATIVA</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_justificativa.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($obj->projeto_objetivo) echo '<tr><td '.$estilo1.'>'.''.$nr++.'. OBJETIVO</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_objetivo.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($obj->projeto_objetivo_especifico) echo '<tr><td '.$estilo1.'>'.$nr++.'. OBJETIVOS ESPECÍFICOS</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_objetivo_especifico.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($obj->projeto_escopo) echo '<tr><td '.$estilo1.'>'.$nr++.'. ESCOPO</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_escopo.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($obj->projeto_nao_escopo) echo '<tr><td '.$estilo1.'>'.$nr++.'. NÃO ESCOPO</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_nao_escopo.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($obj->projeto_premissas) echo '<tr><td '.$estilo1.'>'.$nr++.'. PREMISSAS</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_premissas.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($obj->projeto_restricoes) echo '<tr><td '.$estilo1.'>'.$nr++.'. RESTRIÇÕES</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_restricoes.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($obj->projeto_orcamento) echo '<tr><td '.$estilo1.'>'.$nr++.'. CUSTOS E FONTES</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_orcamento.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($obj->projeto_beneficio) echo '<tr><td '.$estilo1.'>'.$nr++.'. BENEFÍCIOS</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_beneficio.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($obj->projeto_produto) echo '<tr><td '.$estilo1.'>'.$nr++.'. PRODUTOS</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_produto.'</td></tr><tr><td>&nbsp;</td></tr>';
if ($obj->projeto_requisito) echo '<tr><td '.$estilo1.'>'.$nr++.'. REQUISITOS</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_requisito.'</td></tr><tr><td>&nbsp;</td></tr>';


$sql->adTabela(($baseline_id ? 'baseline_' : '').'projeto_gestao', 'projeto_gestao');
$sql->adCampo('projeto_gestao.*');
$sql->adOnde('projeto_gestao_projeto ='.(int)$projeto_id);
if ($baseline_id) $sql->adOnde('baseline_id='.(int)$baseline_id);
$sql->adOrdem('projeto_gestao_ordem');
$lista_gestao = $sql->Lista();
$sql->limpar();
$saida='';
if (count($lista_gestao)){
	$saida.='<table cellspacing=0 cellpadding=0>';
	foreach($lista_gestao as $gestao_data){
		
		if (isset($gestao_data['projeto_gestao_tema']) && $gestao_data['projeto_gestao_tema']) $saida.= '<td align=left '.$estilo2.'>'.imagem('icones/tema_p.png').nome_tema($gestao_data['projeto_gestao_tema']).'</td>';
		if (isset($gestao_data['projeto_gestao_indicador']) && $gestao_data['projeto_gestao_indicador']) $saida.= '<td align=left '.$estilo2.'>'.imagem('icones/indicador_p.gif').nome_indicador($gestao_data['projeto_gestao_indicador']).'</td>';
		if (isset($gestao_data['projeto_gestao_meta']) && $gestao_data['projeto_gestao_meta']) $saida.= '<td align=left '.$estilo2.'>'.imagem('icones/meta_p.gif').nome_meta($gestao_data['projeto_gestao_meta']).'</td>';
		if (isset($gestao_data['projeto_gestao_acao']) && $gestao_data['projeto_gestao_acao']) $saida.= '<td align=left '.$estilo2.'>'.imagem('icones/plano_acao_p.gif').nome_acao($gestao_data['projeto_gestao_acao']).'</td>';
		if (isset($gestao_data['projeto_gestao_fator']) && $gestao_data['projeto_gestao_fator']) $saida.= '<td align=left '.$estilo2.'>'.imagem('icones/fator_p.gif').nome_fator($gestao_data['projeto_gestao_fator']).'</td>';
		if (isset($gestao_data['projeto_gestao_objetivo']) && $gestao_data['projeto_gestao_objetivo']) $saida.= '<td align=left '.$estilo2.'>'.imagem('icones/obj_estrategicos_p.gif').nome_objetivo($gestao_data['projeto_gestao_objetivo']).'</td>';
		if (isset($gestao_data['projeto_gestao_pratica']) && $gestao_data['projeto_gestao_pratica']) $saida.= '<td align=left '.$estilo2.'>'.imagem('icones/pratica_p.gif').nome_pratica($gestao_data['projeto_gestao_pratica']).'</td>';
		if (isset($gestao_data['projeto_gestao_estrategia']) && $gestao_data['projeto_gestao_estrategia']) $saida.= '<td align=left '.$estilo2.'>'.imagem('icones/estrategia_p.gif').nome_estrategia($gestao_data['projeto_gestao_estrategia']).'</td>';
		$saida.= '</tr>';
		}
	$saida.= '</table>';
	}
if ($saida) echo '<tr><td '.$estilo1.'>'.$nr++.'. ALINHAMENTO ESTRATÉGICO</td></tr><tr><td '.$estilo2.'>'.$saida.'</td></tr><tr><td>&nbsp;</td></tr>';






if (isset($obj->projeto_fonte) && $obj->projeto_fonte) echo '<tr><td '.$estilo1.'>'.$nr++.'. '.strtoupper($config['projeto_fonte']).'</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_fonte.'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_regiao) && $obj->projeto_regiao) echo '<tr><td '.$estilo1.'>'.$nr++.'. '.strtoupper($config['projeto_regiao']).'</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_regiao.'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($obj->projeto_observacao) && $obj->projeto_observacao) echo '<tr><td '.$estilo1.'>'.$nr++.'. OBSERVAÇÕES</td></tr><tr><td '.$estilo2.'>'.$obj->projeto_observacao.'</td></tr><tr><td>&nbsp;</td></tr>';
echo '<tr><td '.$estilo1.'>'.$nr++.'. PRIORIDADE</td></tr><tr><td '.$estilo2.'>'.prioridade($obj->projeto_prioridade, true, true).'</td></tr><tr><td>&nbsp;</td></tr>';
if (isset($projStatus[$obj->projeto_status])) echo '<tr><td '.$estilo1.'>'.$nr++.'. STATUS</td></tr><tr><td '.$estilo2.'>'.$projStatus[$obj->projeto_status].'</td></tr><tr><td>&nbsp;</td></tr>';





if ($Aplic->profissional){

	$sql->adTabela('demandas');
	$sql->adOnde('demanda_projeto = '.(int)$projeto_id);
	$sql->adCampo('demanda_id');
	$sql->adOrdem('demanda_superior, demanda_nome');
	$demandas=$sql->carregarColuna();
	$sql->limpar();
	$saida_demanda=array();
	foreach($demandas as $demanda) $saida_demanda[]=link_demanda($demanda);
	if (count($saida_demanda)) echo '<tr><td '.$estilo1.'>'.$nr++.'. DEMANDA</td></tr><tr><td '.$estilo2.'>'.implode('<br>', $saida_demanda).'</td></tr><tr><td>&nbsp;</td></tr>';



	$sql->adTabela('pi');
	$sql->adOnde('pi_projeto = '.(int)$projeto_id);
	$sql->adCampo('pi_pi');
	$sql->adOrdem('pi_ordem');
	$pi=$sql->carregarColuna();
	$sql->limpar();
	if (count($pi)) echo '<tr><td '.$estilo1.'>'.$nr++.'. PI</td></tr><tr><td '.$estilo2.'>'.implode('<br>', $pi).'</td></tr><tr><td>&nbsp;</td></tr>';

	$sql->adTabela('ptres');
	$sql->adOnde('ptres_projeto = '.(int)$projeto_id);
	$sql->adCampo('ptres_ptres');
	$sql->adOrdem('ptres_ordem');
	$ptres=$sql->carregarColuna();
	$sql->limpar();
	if (count($ptres)) echo '<tr><td '.$estilo1.'>'.$nr++.'. PTRES</td></tr><tr><td '.$estilo2.'>'.implode('<br>', $ptres).'</td></tr><tr><td>&nbsp;</td></tr>';
	}










$saida=lista_eap($projeto_id);
echo '<tr><td '.$estilo1.'>'.$nr++.'. RESUMO D'.strtoupper($config['genero_tarefa'].'s '.$config['tarefas']).'</td></tr><tr><td '.$estilo2.'>'.$saida.'</td></tr><tr><td>&nbsp;</td></tr>';

$saida=lista_gantt($projeto_id);
echo '<tr><td '.$estilo1.'>'.$nr++.'. ESTRUTURA ANALÍTICA D'.strtoupper($config['genero_projeto'].' '.$config['projeto']).'</td></tr><tr><td '.$estilo2.'>'.$saida.'</td></tr><tr><td>&nbsp;</td></tr>';

echo '<tr><td '.$estilo1.'>'.$nr++.'. CUSTOS REALIZADOS</td></tr><tr><td>&nbsp;</td></tr>';

$saida=lista_gastos($projeto_id);
echo '<tr><td '.$estilo2.'>'.$saida.'</td></tr><tr><td>&nbsp;</td></tr>';


if ($Aplic->profissional && $barra['rodape']) echo '<tr><td colspan=2 align=center>'.$barra['imagem'].'</td></tr>';
echo '</table>';

if ($dialogo && !$Aplic->pdf_print) echo '<script>self.print();</script>';


















?>