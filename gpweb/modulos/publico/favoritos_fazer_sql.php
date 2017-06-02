<?php  
/* Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

$salvar=getParam($_REQUEST, 'salvar', 0);
$del=getParam($_REQUEST, 'del', 0);
$favorito_id=getParam($_REQUEST, 'favorito_id', 0);
$favorito_nome=getParam($_REQUEST, 'favorito_nome', '');
$campos_escolhidos=getParam($_REQUEST, 'campos_escolhidos', array());



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
$agenda =getParam($_REQUEST, 'agenda ', 0);
$agrupamento=getParam($_REQUEST, 'agrupamento', 0);
$patrocinador=getParam($_REQUEST, 'patrocinador', 0);
$template=getParam($_REQUEST, 'template', 0);
$painel=getParam($_REQUEST, 'painel', 0);
$painel_odometro=getParam($_REQUEST, 'painel_odometro', 0);
$painel_composicao=getParam($_REQUEST, 'painel_composicao', 0);
$tr=getParam($_REQUEST, 'tr', 0);
$me=getParam($_REQUEST, 'me', 0);



$favorito_usuario=getParam($_REQUEST, 'favorito_usuario', '');
$favorito_cia=getParam($_REQUEST, 'favorito_cia', '');
$favorito_dept=getParam($_REQUEST, 'favorito_dept', '');
$favorito_acesso=getParam($_REQUEST, 'favorito_acesso', '');
$favorito_ativo=getParam($_REQUEST, 'favorito_ativo', '');
$favorito_geral=getParam($_REQUEST, 'favorito_geral', 0);



$sql = new BDConsulta;

if ($del && $favorito_id)	{
	$sql->setExcluir('favorito');
	$sql->adOnde('favorito_id='.(int)$favorito_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela favorito!'.$bd->stderr(true));
	$sql->limpar();
	}
elseif ($favorito_id && $salvar){
	$sql->adTabela('favorito');
	$sql->adAtualizar('favorito_nome', $favorito_nome);
	
	$sql->adAtualizar('favorito_usuario', $favorito_usuario);
	$sql->adAtualizar('favorito_nome', $favorito_nome);
	$sql->adAtualizar('favorito_cia', $favorito_cia);
	$sql->adAtualizar('favorito_dept', $favorito_dept);
	$sql->adAtualizar('favorito_acesso', $favorito_acesso);
	$sql->adAtualizar('favorito_ativo', $favorito_ativo);
	$sql->adAtualizar('favorito_geral', $favorito_geral);
	$sql->adOnde('favorito_id='.(int)$favorito_id);
	$sql->exec();
	$sql->limpar();
	
	}	
elseif (!$favorito_id && $salvar){

	$sql->adTabela('favorito');
	$sql->adInserir('favorito_usuario', $favorito_usuario);
	$sql->adInserir('favorito_nome', $favorito_nome);
	$sql->adInserir('favorito_cia', $favorito_cia);
	if ($favorito_dept) $sql->adInserir('favorito_dept', $favorito_dept);
	$sql->adInserir('favorito_acesso', $favorito_acesso);
	$sql->adInserir('favorito_ativo', $favorito_ativo);
	$sql->adInserir('favorito_geral', $favorito_geral);
	
	if ($projeto) $sql->adInserir('favorito_projeto', $projeto);
	if ($tarefa) $sql->adInserir('favorito_tarefa', $tarefa);
	if ($perspectiva) $sql->adInserir('favorito_perspectiva', $perspectiva);
	if ($tema) $sql->adInserir('favorito_tema', $tema);
	if ($objetivo) $sql->adInserir('favorito_objetivo', $objetivo);
	if ($fator) $sql->adInserir('favorito_fator', $fator);
	if ($estrategia) $sql->adInserir('favorito_estrategia', $estrategia);
	if ($meta) $sql->adInserir('favorito_meta', $meta);
	if ($pratica) $sql->adInserir('favorito_pratica', $pratica);
	if ($indicador) $sql->adInserir('favorito_indicador', $indicador);
	if ($acao) $sql->adInserir('favorito_acao', $acao);
	if ($canvas) $sql->adInserir('favorito_canvas', $canvas);
	if ($risco) $sql->adInserir('favorito_risco', $risco);
	if ($risco_resposta) $sql->adInserir('favorito_risco_resposta', $risco_resposta);
	if ($calendario) $sql->adInserir('favorito_calendario', $calendario);
	if ($monitoramento) $sql->adInserir('favorito_monitoramento', $monitoramento);
	if ($ata) $sql->adInserir('favorito_ata', $ata);
	if ($mswot) $sql->adInserir('favorito_mswot', $mswot);
	if ($swot) $sql->adInserir('favorito_swot', $swot);
	if ($operativo) $sql->adInserir('favorito_operativo', $operativo);
	if ($instrumento) $sql->adInserir('favorito_instrumento', $instrumento);
	if ($recurso) $sql->adInserir('favorito_recurso', $recurso);
	if ($problema) $sql->adInserir('favorito_problema', $problema);
	if ($demanda) $sql->adInserir('favorito_demanda', $demanda);
	if ($programa) $sql->adInserir('favorito_programa', $programa);
	if ($licao) $sql->adInserir('favorito_licao', $licao);
	if ($evento) $sql->adInserir('favorito_evento', $evento);
	if ($link) $sql->adInserir('favorito_link', $link);
	if ($avaliacao) $sql->adInserir('favorito_avaliacao', $avaliacao);
	if ($tgn) $sql->adInserir('favorito_tgn', $tgn);
	if ($brainstorm) $sql->adInserir('favorito_brainstorm', $brainstorm);
	if ($gut) $sql->adInserir('favorito_gut', $gut);
	if ($causa_efeito) $sql->adInserir('favorito_causa_efeito', $causa_efeito);
	if ($arquivo) $sql->adInserir('favorito_arquivo', $arquivo);
	if ($forum) $sql->adInserir('favorito_forum', $forum);
	if ($checklist) $sql->adInserir('favorito_checklist', $checklist);
	if ($agenda ) $sql->adInserir('favorito_agenda ', $agenda );
	if ($agrupamento) $sql->adInserir('favorito_agrupamento', $agrupamento);
	if ($patrocinador) $sql->adInserir('favorito_patrocinador', $patrocinador);
	if ($template) $sql->adInserir('favorito_template', $template);
	if ($painel) $sql->adInserir('favorito_painel', $painel);
	if ($painel_odometro) $sql->adInserir('favorito_painel_odometro', $painel_odometro);
	if ($painel_composicao) $sql->adInserir('favorito_painel_composicao', $painel_composicao);
	if ($tr) $sql->adInserir('favorito_tr', $tr);
	if ($me) $sql->adInserir('favorito_me', $me);
	$sql->exec();
	$favorito_id=$bd->Insert_ID('favorito','favorito_id');
	$sql->limpar();
	}	

if ($favorito_id){
	$sql->setExcluir('favorito_lista');
	$sql->adOnde('favorito_lista_favorito='.(int)$favorito_id);
	if (!$sql->exec()) die('Erro ao excluir de favorito_lista'.$bd->stderr(true));
	$sql->limpar();
	
	foreach((array)$campos_escolhidos AS $chave => $valor){ 	
		if ($valor){
			$sql->adTabela('favorito_lista');
			$sql->adInserir('favorito_lista_campo', $valor);
			$sql->adInserir('favorito_lista_favorito', $favorito_id);
			$sql->exec();
			$sql->limpar();
			}
		}
	
	$favorito_usuarios=getParam($_REQUEST, 'favorito_usuarios', null);
	$favorito_usuarios=explode(',', $favorito_usuarios);
	$sql->setExcluir('favorito_usuario');
	$sql->adOnde('favorito_usuario_favorito = '.(int)$favorito_id);
	$sql->exec();
	$sql->limpar();
	foreach($favorito_usuarios as $chave => $usuario_id){
		if($usuario_id){
			$sql->adTabela('favorito_usuario');
			$sql->adInserir('favorito_usuario_favorito', $favorito_id);
			$sql->adInserir('favorito_usuario_usuario', $usuario_id);
			$sql->exec();
			$sql->limpar();
			}
		}

	$favorito_depts=getParam($_REQUEST, 'favorito_depts', null);
	$favorito_depts=explode(',', $favorito_depts);
	$sql->setExcluir('favorito_dept');
	$sql->adOnde('favorito_dept_favorito = '.$favorito_id);
	$sql->exec();
	$sql->limpar();
	foreach($favorito_depts as $chave => $dept_id){
		if($dept_id){
			$sql->adTabela('favorito_dept');
			$sql->adInserir('favorito_dept_favorito', $favorito_id);
			$sql->adInserir('favorito_dept_dept', $dept_id);
			$sql->exec();
			$sql->limpar();
			}
		}

	$sql->setExcluir('favorito_cia');
	$sql->adOnde('favorito_cia_favorito='.(int)$favorito_id);
	$sql->exec();
	$sql->limpar();
	$cias=getParam($_REQUEST, 'favorito_cias', '');
	$cias=explode(',', $cias);
	if (count($cias)) {
		foreach ($cias as $cia_id) {
			if ($cia_id){
				$sql->adTabela('favorito_cia');
				$sql->adInserir('favorito_cia_favorito', $favorito_id);
				$sql->adInserir('favorito_cia_cia', $cia_id);
				$sql->exec();
				$sql->limpar();
				}
			}
		}
	}	
	
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


$Aplic->redirecionar($saida);

	

?>

<script LANGUAGE="javascript">

</script>	

