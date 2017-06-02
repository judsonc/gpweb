<?php
global $config;

if(file_exists(BASE_DIR.'/modulos/projetos/tarefa_cache.class_pro.php')){
	$sql = new BDConsulta;
	$sql->adTabela('menu_item');	
	$sql->adCampo('count(menu_item_id)');
	$sql->adOnde('menu_item_chave=\'swot\'');
	$tem_swot = $sql->resultado();
	$sql->limpar();

	if ($tem_swot){	
		$sql->setExcluir('menu_item');
		$sql->adOnde('menu_item_modulo = "swot"');
		$sql->exec();
		$sql->limpar();
		

		mysql_query("
		INSERT INTO menu_item (menu_item_chave, menu_item_chave_pai, menu_item_titulo, menu_item_modulo, menu_item_parametros, menu_item_menu_id, menu_item_tipo, menu_item_acao, menu_item_tip, menu_item_smodulo, menu_item_permissao, menu_item_icone, menu_item_icone_classe, menu_item_script, menu_item_index, menu_item_permissao_extra) VALUES 
			('swot','menu','''Matriz SWOT''','swot','',1,'item',0,'''Menu de matrizes SWOT.''','0',4,'server/modulos/swot/imagens/mswot_p.png','','',15,''),
			('mswot_lista','swot','''Lista de matrizes SWOT''','swot','''m=swot&a=mswot_lista''',1,'item',1,'''Lista de matrizes SWOT.''','0',4,'server/modulos/swot/imagens/mswot_p.png','','',1,''),
			('swot_lista','swot','''Lista de campos de matriz SWOT''','swot','''m=swot&a=swot_lista''',1,'item',1,'''Lista de campos de matriz SWOT.''','0',4,'server/modulos/swot/imagens/swot_p.png','','',2,'');");
		}


	
	$sql->adTabela('arquivo_gestao');	
	$sql->adCampo('DISTINCT arquivo_gestao_arquivo');
	$sql->adOnde('arquivo_gestao_arquivo > 0');
	$arquivo_gestao = $sql->carregarColuna();
	$sql->limpar();
	
	$sql->adTabela('arquivo');	
	$sql->adCampo('arquivos.*');
	if (count($arquivo_gestao)) $sql->adOnde('arquivo_id NOT IN ('.implode(',',$arquivo_gestao).')');
	$lista = $sql->lista();
	$sql->limpar();	
			
	foreach($lista AS $linha) {
		if (isset($linha['arquivo_tarefa']) && $linha['arquivo_tarefa'] && $linha['arquivo_projeto']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_tarefa', $linha['arquivo_tarefa']);
			$sql->adInserir('arquivo_gestao_projeto', $linha['arquivo_projeto']);
			$sql->exec();
			$sql->limpar();
			}
			
		elseif (isset($linha['arquivo_projeto']) && $linha['arquivo_projeto']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_projeto', $linha['arquivo_projeto']);
			$sql->exec();
			$sql->limpar();
			}	
			
		elseif (isset($linha['arquivo_pratica']) && $linha['arquivo_pratica']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_pratica', $linha['arquivo_pratica']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_acao']) && $linha['arquivo_acao']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_acao', $linha['arquivo_acao']);
			$sql->exec();
			$sql->limpar();
			}		
			
		elseif (isset($linha['arquivo_indicador']) && $linha['arquivo_indicador']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_indicador', $linha['arquivo_indicador']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_objetivo']) && $linha['arquivo_objetivo']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_objetivo', $linha['arquivo_objetivo']);
			$sql->exec();
			$sql->limpar();
			}		
				
		elseif (isset($linha['arquivo_perspectiva']) && $linha['arquivo_perspectiva']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_perspectiva', $linha['arquivo_perspectiva']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_tema']) && $linha['arquivo_tema']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_tema', $linha['arquivo_tema']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_fator']) && $linha['arquivo_fator']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_fator', $linha['arquivo_fator']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_estrategia']) && $linha['arquivo_estrategia']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_estrategia', $linha['arquivo_estrategia']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_meta']) && $linha['arquivo_meta']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_meta', $linha['arquivo_meta']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_arquivo_demanda']) && $linha['arquivo_arquivo_demanda']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_arquivo_demanda', $linha['arquivo_arquivo_demanda']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_instrumento']) && $linha['arquivo_instrumento']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_instrumento', $linha['arquivo_instrumento']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_calendario']) && $linha['arquivo_calendario']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_calendario', $linha['arquivo_calendario']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_ata']) && $linha['arquivo_ata']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_ata', $linha['arquivo_ata']);
			$sql->exec();
			$sql->limpar();
			}	
		
		elseif (isset($linha['arquivo_canvas']) && $linha['arquivo_canvas']) {
			$sql->adTabela('arquivo_gestao');
			$sql->adInserir('arquivo_gestao_arquivo', $linha['arquivo_id']);
			$sql->adInserir('arquivo_gestao_canvas', $linha['arquivo_canvas']);
			$sql->exec();
			$sql->limpar();
			}	
		
		
		}

	}
?>