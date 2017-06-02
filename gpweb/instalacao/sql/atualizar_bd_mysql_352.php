<?php
global $config;

if(file_exists(BASE_DIR.'/modulos/projetos/tarefa_cache.class_pro.php')){
	$sql = new BDConsulta;
	$sql->adTabela('risco_resposta_risco');	
	$sql->adCampo('risco_resposta_risco.*');
	$lista = $sql->lista();
	$sql->limpar();
	foreach($lista AS $linha) {
		$sql->adTabela('risco_resposta_gestao');	
		$sql->adCampo('risco_resposta_gestao_risco');
		$sql->adOnde('risco_resposta_gestao_risco='.(int)$linha['risco_id']);
		$sql->adOnde('risco_resposta_gestao_risco_resposta='.(int)$linha['risco_resposta_id']);
		$existe = $sql->resultado();
		$sql->limpar();
		
		if (!$existe){	
			$sql->adTabela('risco_resposta_gestao');
			$sql->adInserir('risco_resposta_gestao_risco_resposta', $linha['risco_resposta_id']);
			$sql->adInserir('risco_resposta_gestao_risco', $linha['risco_id']);
			$sql->exec();
			$sql->limpar();
			}
		}
	}
?>