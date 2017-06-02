<?php
global $config, $bd;

if(file_exists(BASE_DIR.'/modulos/projetos/tarefa_cache.class_pro.php')){
	$sql = new BDConsulta;
	
	$sql->adTabela('plano_acao_item_custos');	
	$sql->adCampo('plano_acao_item_custos_id, plano_acao_item_custos_tr, plano_acao_item_custos_quantidade');
	$sql->adOnde('plano_acao_item_custos_tr > 0');
	$lista = $sql->lista();
	$sql->limpar();
	$ordem=array();
	foreach($lista AS $linha) {
		
		if (isset($ordem[$linha['plano_acao_item_custos_tr']]))	$ordem[$linha['plano_acao_item_custos_tr']]++;
		else $ordem[$linha['plano_acao_item_custos_tr']]=1;
		
		$sql->adTabela('tr_custo');
		$sql->adInserir('tr_custo_tr', $linha['plano_acao_item_custos_tr']);
		$sql->adInserir('tr_custo_acao', $linha['plano_acao_item_custos_id']);
		$sql->adInserir('tr_custo_quantidade', $linha['plano_acao_item_custos_quantidade']);
		$sql->adInserir('tr_custo_ordem', $ordem[$linha['plano_acao_item_custos_tr']]);
		$sql->exec();
		$sql->limpar();
		}
		
	//item de tarefa	
	$sql->adTabela('tarefa_custos');	
	$sql->adCampo('tarefa_custos_id, tarefa_custos_tr, tarefa_custos_quantidade');
	$sql->adOnde('tarefa_custos_tr > 0');
	$sql->adOnde('tarefa_custos_tarefa > 0');
	$lista = $sql->lista();
	$sql->limpar();
	$ordem=array();
	foreach($lista AS $linha) {
		if (isset($ordem[$linha['tarefa_custos_tr']])) $ordem[$linha['tarefa_custos_tr']]++;
		else $ordem[$linha['tarefa_custos_tr']]=1;
		$sql->adTabela('tr_custo');
		$sql->adInserir('tr_custo_tr', $linha['tarefa_custos_tr']);
		$sql->adInserir('tr_custo_tarefa', $linha['tarefa_custos_id']);
		$sql->adInserir('tr_custo_quantidade', $linha['tarefa_custos_quantidade']);
		$sql->adInserir('tr_custo_ordem', $ordem[$linha['tarefa_custos_tr']]);
		$sql->exec();
		$sql->limpar();
		}	
		
		
	//item avulso
	$sql->adTabela('tarefa_custos');	
	$sql->adCampo('tarefa_custos.*');
	$sql->adOnde('tarefa_custos_tr > 0');
	$sql->adOnde('tarefa_custos_tarefa IS NULL');
	$lista = $sql->lista();
	$sql->limpar();
	$ordem=array();
	foreach($lista AS $linha) {
		if (isset($ordem[$linha['tarefa_custos_tr']])) $ordem[$linha['tarefa_custos_tr']]++;
		else $ordem[$linha['tarefa_custos_tr']]=1;
		
		$sql->adTabela('tr_avulso_custo');

		$sql->adInserir('tr_avulso_custo_tr', $linha['tarefa_custos_tr']);
	  if ($linha['tarefa_custos_usuario']) $sql->adInserir('tr_avulso_custo_usuario', $linha['tarefa_custos_usuario']);
	  if ($linha['tarefa_custos_nome']) $sql->adInserir('tr_avulso_custo_nome', $linha['tarefa_custos_nome']);
	  if ($linha['tarefa_custos_codigo']) $sql->adInserir('tr_avulso_custo_codigo', $linha['tarefa_custos_codigo']);
	  if ($linha['tarefa_custos_fonte']) $sql->adInserir('tr_avulso_custo_fonte', $linha['tarefa_custos_fonte']);
	  if ($linha['tarefa_custos_regiao']) $sql->adInserir('tr_avulso_custo_regiao', $linha['tarefa_custos_regiao']);
	  if ($linha['tarefa_custos_tipo']) $sql->adInserir('tr_avulso_custo_tipo', $linha['tarefa_custos_tipo']);
	  if ($linha['tarefa_custos_data']) $sql->adInserir('tr_avulso_custo_data', $linha['tarefa_custos_data']);
	  $sql->adInserir('tr_avulso_custo_quantidade', $linha['tarefa_custos_quantidade']);
	  $sql->adInserir('tr_avulso_custo_custo', $linha['tarefa_custos_custo']);
	  if ($linha['tarefa_custos_bdi']) $sql->adInserir('tr_avulso_custo_bdi', $linha['tarefa_custos_bdi']);
		if ($linha['tarefa_custos_moeda']) $sql->adInserir('tr_avulso_custo_moeda', $linha['tarefa_custos_moeda']);
		if ($linha['tarefa_custos_cotacao']) $sql->adInserir('tr_avulso_custo_cotacao', $linha['tarefa_custos_cotacao']);
		if ($linha['tarefa_custos_data_moeda']) $sql->adInserir('tr_avulso_custo_data_moeda', $linha['tarefa_custos_data_moeda']);
	  if ($linha['tarefa_custos_percentagem']) $sql->adInserir('tr_avulso_custo_percentagem', $linha['tarefa_custos_percentagem']);
	  if ($linha['tarefa_custos_descricao']) $sql->adInserir('tr_avulso_custo_descricao', $linha['tarefa_custos_descricao']);
	 	if ($linha['tarefa_custos_ordem']) $sql->adInserir('tr_avulso_custo_ordem', $linha['tarefa_custos_ordem']);
	  if ($linha['tarefa_custos_nd']) $sql->adInserir('tr_avulso_custo_nd', $linha['tarefa_custos_nd']);
	  if ($linha['tarefa_custos_categoria_economica']) $sql->adInserir('tr_avulso_custo_categoria_economica', $linha['tarefa_custos_categoria_economica']);
	  if ($linha['tarefa_custos_grupo_despesa']) $sql->adInserir('tr_avulso_custo_grupo_despesa', $linha['tarefa_custos_grupo_despesa']);
	  if ($linha['tarefa_custos_modalidade_aplicacao']) $sql->adInserir('tr_avulso_custo_modalidade_aplicacao', $linha['tarefa_custos_modalidade_aplicacao']);
	  if ($linha['tarefa_custos_metodo']) $sql->adInserir('tr_avulso_custo_metodo', $linha['tarefa_custos_metodo']);
		if ($linha['tarefa_custos_exercicio']) $sql->adInserir('tr_avulso_custo_exercicio', $linha['tarefa_custos_exercicio']);
		if ($linha['tarefa_custos_data_limite']) $sql->adInserir('tr_avulso_custo_data_limite', $linha['tarefa_custos_data_limite']);
		if ($linha['tarefa_custos_pi']) $sql->adInserir('tr_avulso_custo_pi', $linha['tarefa_custos_pi']);
		$sql->exec();
		$tr_avulso_custo_id=$bd->Insert_ID('tr_avulso_custo','tr_avulso_custo_id');
		$sql->limpar();
	
		$sql->adTabela('tr_custo');
		$sql->adInserir('tr_custo_tr', $linha['tarefa_custos_tr']);
		$sql->adInserir('tr_custo_avulso', $tr_avulso_custo_id);
		$sql->adInserir('tr_custo_quantidade', $linha['tarefa_custos_quantidade']);
		$sql->adInserir('tr_custo_ordem', $ordem[$linha['tarefa_custos_tr']]);
		$sql->exec();
		$sql->limpar();
		
		$sql->setExcluir('tarefa_custos');
		$sql->adOnde('tarefa_custos_id = '.(int)$linha['tarefa_custos_id']);
		$sql->exec();
		$sql->limpar();
		}		
		
		
	$sql->adTabela('demanda_custo');	
	$sql->adCampo('demanda_custo_id, demanda_custo_tr, demanda_custo_quantidade');
	$sql->adOnde('demanda_custo_tr > 0');
	$lista = $sql->lista();
	$sql->limpar();
	$ordem=array();
	foreach($lista AS $linha) {
		if (isset($ordem[$linha['demanda_custo_tr']])) $ordem[$linha['demanda_custo_tr']]++;
		else $ordem[$linha['demanda_custo_tr']]=1;
		$sql->adTabela('tr_custo');
		$sql->adInserir('tr_custo_tr', $linha['demanda_custo_tr']);
		$sql->adInserir('tr_custo_demanda', $linha['demanda_custo_id']);
		$sql->adInserir('tr_custo_quantidade', $linha['demanda_custo_quantidade']);
		$sql->adInserir('tr_custo_ordem', $ordem[$linha['demanda_custo_tr']]);
		$sql->exec();
		$sql->limpar();
		}		
		
		
	}
?>