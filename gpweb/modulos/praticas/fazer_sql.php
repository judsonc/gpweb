<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


global $config;
$base_dir=($config['dir_arquivo'] ? $config['dir_arquivo'] : BASE_DIR);

$excluir=getParam($_REQUEST, 'excluir', 0);
$pratica_id=getParam($_REQUEST, 'pratica_id', null);
$pratica_indicador_id=getParam($_REQUEST, 'pratica_indicador_id', null);
$checklist_id=getParam($_REQUEST, 'checklist_id', null);
$modulo=getParam($_REQUEST, 'modulo', 0);
$sql = new BDConsulta;
$plano_acao_id=getParam($_REQUEST, 'plano_acao_id', null);
$pg_estrategia_id=getParam($_REQUEST, 'pg_estrategia_id', null);
$objetivo_id=getParam($_REQUEST, 'objetivo_id', null);
$pg_perspectiva_id=getParam($_REQUEST, 'pg_perspectiva_id', null);
$pg_meta_id=getParam($_REQUEST, 'pg_meta_id', null);
$fator_id=getParam($_REQUEST, 'fator_id', null);
$avaliacao_id=getParam($_REQUEST, 'avaliacao_id', null);
$tema_id=getParam($_REQUEST, 'tema_id', null);


if ($modulo=='objetivo' && $excluir && $objetivo_id){
	
	//verifica se não tem fator critico vinculado
	$sql->adTabela('fator');
	$sql->adCampo('count(fator_objetivo)');
	$sql->adOnde('fator_objetivo='.(int)$objetivo_id);
	$qnt=$sql->Resultado();
	$sql->limpar();
	if ($qnt > 0){
		$Aplic->setMsg('Não é possível excluir! Há '.$config['fator'].' vinculad'.$config['genero_fator'].'.', UI_MSG_ERRO);
		$Aplic->redirecionar('m=praticas&a=obj_estrategico_ver&objetivo_id='.(int)$objetivo_id);
		exit();
		}
	
	$sql->setExcluir('objetivo');
	$sql->adOnde('objetivo_id='.(int)$objetivo_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela pratica_objetivo!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('plano_gestao_objetivo');
	$sql->adOnde('plano_gestao_objetivo_objetivo='.(int)$objetivo_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela plano_gestao_objetivo!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('objetivo_usuario');
	$sql->adOnde('objetivo_usuario_objetivo='.(int)$objetivo_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela objetivo_usuario!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('objetivo_dept');
	$sql->adOnde('objetivo_dept_objetivo='.(int)$objetivo_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela objetivo_dept!'.$bd->stderr(true));
	$sql->limpar();
	
	
	$sql->setExcluir('objetivo_log');
	$sql->adOnde('objetivo_log_objetivo='.(int)$objetivo_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela objetivo_log!'.$bd->stderr(true));
	$sql->limpar();
	
	
	$sql->setExcluir('objetivo_composicao');
	$sql->adOnde('objetivo_composicao_pai = '.(int)$objetivo_id.' OR objetivo_composicao_filho ='.(int)$objetivo_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela objetivo_composicao!'.$bd->stderr(true));
	$sql->limpar();

	$sql->adTabela('eventos');
	$sql->adCampo('evento_id');
	$sql->adOnde('evento_objetivo='.(int)$objetivo_id);
	$eventos=$sql->Lista();
	$sql->limpar();
	foreach($eventos as $chave => $evento){
		$sql->setExcluir('evento_usuarios');
		$sql->adOnde('evento_id='.(int)$evento['evento_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_usuarios!'.$bd->stderr(true));
		$sql->limpar();
		$sql->setExcluir('evento_recorrencia');
		$sql->adOnde('recorrencia_id_origem='.(int)$evento['evento_id']);
		$sql->adOnde('recorrencia_tipo=\'evento\'');
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_recorrencia!'.$bd->stderr(true));
		$sql->limpar();
		$sql->setExcluir('evento_contatos');
		$sql->adOnde('evento_id='.(int)$evento['evento_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_contatos!'.$bd->stderr(true));
		$sql->limpar();
		}
	$sql->setExcluir('eventos');
	$sql->adOnde('evento_objetivo='.(int)$objetivo_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela eventos!'.$bd->stderr(true));
	$sql->limpar();

	$sql->adTabela('arquivo');
	$sql->adCampo('arquivo_id, arquivo_nome_real');
	$sql->adOnde('arquivo_objetivo='.(int)$objetivo_id);
	$arquivos=$sql->Lista();
	$sql->limpar();
	foreach($arquivos as $chave => $arquivo){
		@unlink($base_dir.'/arquivos/estrategias/'.(int)$objetivo_id.'/'.$arquivo['arquivo_nome_real']);
		}

	$sql->setExcluir('arquivo');
	$sql->adOnde('arquivo_objetivo='.(int)$objetivo_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela arquivo!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('links');
	$sql->adOnde('link_objetivo='.(int)$objetivo_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela links!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->adTabela('foruns');
	$sql->adCampo('forum_id');
	$sql->adOnde('forum_objetivo='.(int)$objetivo_id);
	$foruns=$sql->Lista();
	$sql->limpar();
	foreach($foruns as $chave => $forum){
		$sql->setExcluir('forum_visitas');
		$sql->adOnde('visita_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_visitas!'.$bd->stderr(true));
		$sql->limpar();
		
		$sql->setExcluir('forum_acompanhar');
		$sql->adOnde('acompanhar_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_acompanhar!'.$bd->stderr(true));
		$sql->limpar();
		
		$sql->setExcluir('forum_mensagens');
		$sql->adOnde('mensagem_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_acompanhar!'.$bd->stderr(true));
		$sql->limpar();
		}
	$sql->setExcluir('foruns');
	$sql->adOnde('forum_objetivo='.(int)$objetivo_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela foruns!'.$bd->stderr(true));
	$sql->limpar();

	$Aplic->setMsg('Objeto Estratégico excluído', UI_MSG_ALERTA);
	$Aplic->redirecionar('m=praticas&a=obj_estrategico_lista');
	}

//excluir estrategia
if ($modulo=='estrategia' && $excluir && $pg_estrategia_id){
	
	//verifica se não tem tema vinculado
	$sql->adTabela('metas');
	$sql->adCampo('count(pg_meta_estrategia)');
	$sql->adOnde('pg_meta_estrategia='.(int)$pg_estrategia_id);
	$qnt=$sql->Resultado();
	$sql->limpar();
	if ($qnt > 0){
		$Aplic->setMsg('Não é possível excluir! Há meta vinculada.', UI_MSG_ERRO);
		$Aplic->redirecionar('m=praticas&a=meta_ver&pg_estrategia_id='.(int)$pg_estrategia_id);
		exit();
		}
	
	$sql->setExcluir('estrategias');
	$sql->adOnde('pg_estrategia_id='.(int)$pg_estrategia_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela pratica_estrategia!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('plano_gestao_estrategias');
	$sql->adOnde('pg_estrategia_id='.(int)$pg_estrategia_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela plano_gestao_estrategias!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('estrategias_usuarios');
	$sql->adOnde('pg_estrategia_id='.(int)$pg_estrategia_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela estrategias_usuarios!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('estrategias_depts');
	$sql->adOnde('pg_estrategia_id='.(int)$pg_estrategia_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela estrategias_depts!'.$bd->stderr(true));
	$sql->limpar();
	
	
	$sql->setExcluir('estrategias_log');
	$sql->adOnde('pg_estrategia_log_estrategia='.(int)$pg_estrategia_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela estrategias_log!'.$bd->stderr(true));
	$sql->limpar();
	
	
	$sql->setExcluir('estrategias_composicao');
	$sql->adOnde('estrategia_pai ='.(int)$pg_estrategia_id.' OR estrategia_filho ='.(int)$pg_estrategia_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela estrategias_composicao!'.$bd->stderr(true));
	$sql->limpar();


	$sql->adTabela('eventos');
	$sql->adCampo('evento_id');
	$sql->adOnde('evento_estrategia='.(int)$pg_estrategia_id);
	$eventos=$sql->Lista();
	$sql->limpar();
	foreach($eventos as $chave => $evento){
		$sql->setExcluir('evento_usuarios');
		$sql->adOnde('evento_id='.(int)$evento['evento_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_usuarios!'.$bd->stderr(true));
		$sql->limpar();
		$sql->setExcluir('evento_recorrencia');
		$sql->adOnde('recorrencia_id_origem='.(int)$evento['evento_id']);
		$sql->adOnde('recorrencia_tipo=\'evento\'');
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_recorrencia!'.$bd->stderr(true));
		$sql->limpar();
		$sql->setExcluir('evento_contatos');
		$sql->adOnde('evento_id='.(int)$evento['evento_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_contatos!'.$bd->stderr(true));
		$sql->limpar();
		}
	$sql->setExcluir('eventos');
	$sql->adOnde('evento_estrategia='.(int)$pg_estrategia_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela eventos!'.$bd->stderr(true));
	$sql->limpar();

	$sql->adTabela('arquivo');
	$sql->adCampo('arquivo_id, arquivo_nome_real');
	$sql->adOnde('arquivo_estrategia='.(int)$pg_estrategia_id);
	$arquivos=$sql->Lista();
	$sql->limpar();
	foreach($arquivos as $chave => $arquivo){
		@unlink($base_dir.'/arquivos/estrategias/'.(int)$pg_estrategia_id.'/'.$arquivo['arquivo_nome_real']);
		}

	$sql->setExcluir('arquivo');
	$sql->adOnde('arquivo_estrategia='.(int)$pg_estrategia_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela arquivo!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('links');
	$sql->adOnde('link_estrategia='.(int)$pg_estrategia_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela links!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->adTabela('foruns');
	$sql->adCampo('forum_id');
	$sql->adOnde('forum_estrategia='.(int)$pg_estrategia_id);
	$foruns=$sql->Lista();
	$sql->limpar();
	foreach($foruns as $chave => $forum){
		$sql->setExcluir('forum_visitas');
		$sql->adOnde('visita_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_visitas!'.$bd->stderr(true));
		$sql->limpar();
		
		$sql->setExcluir('forum_acompanhar');
		$sql->adOnde('acompanhar_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_acompanhar!'.$bd->stderr(true));
		$sql->limpar();
		
		$sql->setExcluir('forum_mensagens');
		$sql->adOnde('mensagem_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_acompanhar!'.$bd->stderr(true));
		$sql->limpar();
		}
	$sql->setExcluir('foruns');
	$sql->adOnde('forum_estrategia='.(int)$pg_estrategia_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela foruns!'.$bd->stderr(true));
	$sql->limpar();

	
	$Aplic->setMsg('Iniciativa excluída', UI_MSG_ALERTA);
	$Aplic->redirecionar('m=praticas&a=estrategia_lista');
	}

//excluir avaliacao
if ($modulo=='avaliacao' && $excluir && $avaliacao_id){
	
	$sql->setExcluir('avaliacao');
	$sql->adOnde('avaliacao_id='.(int)$avaliacao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela avaliacao!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('avaliacao_indicador_lista');
	$sql->adOnde('avaliacao_indicador_lista_avaliacao='.(int)$avaliacao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela avaliacao_indicador_lista!'.$bd->stderr(true));
	$sql->limpar();
	
	
	$sql->setExcluir('avaliacao_usuarios');
	$sql->adOnde('avaliacao_id='.(int)$avaliacao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela avaliacao_usuarios!'.$bd->stderr(true));
	$sql->limpar();
	
	$Aplic->setMsg('Avaliação excluída', UI_MSG_ALERTA);
	$Aplic->redirecionar('m=praticas&a=avaliacao_lista');
	}

//excluir meta
if ($modulo=='meta' && $excluir && $pg_meta_id){
			
	$sql->setExcluir('metas');
	$sql->adOnde('pg_meta_id='.(int)$pg_meta_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela metas!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('plano_gestao_metas');
	$sql->adOnde('pg_meta_id='.(int)$pg_meta_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela plano_gestao_metas!'.$bd->stderr(true));
	$sql->limpar();
	
	
	$sql->setExcluir('metas_usuarios');
	$sql->adOnde('pg_meta_id='.(int)$pg_meta_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela metas_usuarios!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('metas_depts');
	$sql->adOnde('pg_meta_id='.(int)$pg_meta_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela metas_depts!'.$bd->stderr(true));
	$sql->limpar();

	$sql->setExcluir('metas_log');
	$sql->adOnde('pg_meta_log_meta='.(int)$pg_meta_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela metas_log!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->adTabela('eventos');
	$sql->adCampo('evento_id');
	$sql->adOnde('evento_meta='.(int)$pg_meta_id);
	$eventos=$sql->Lista();
	$sql->limpar();
	foreach($eventos as $chave => $evento){
		$sql->setExcluir('evento_usuarios');
		$sql->adOnde('evento_id='.(int)$evento['evento_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_usuarios!'.$bd->stderr(true));
		$sql->limpar();
		$sql->setExcluir('evento_recorrencia');
		$sql->adOnde('recorrencia_id_origem='.(int)$evento['evento_id']);
		$sql->adOnde('recorrencia_tipo=\'evento\'');
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_recorrencia!'.$bd->stderr(true));
		$sql->limpar();
		$sql->setExcluir('evento_contatos');
		$sql->adOnde('evento_id='.(int)$evento['evento_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_contatos!'.$bd->stderr(true));
		$sql->limpar();
		}
	$sql->setExcluir('eventos');
	$sql->adOnde('evento_meta='.(int)$pg_meta_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela eventos!'.$bd->stderr(true));
	$sql->limpar();

	$sql->adTabela('arquivo');
	$sql->adCampo('arquivo_id, arquivo_nome_real');
	$sql->adOnde('arquivo_meta='.(int)$pg_meta_id);
	$arquivos=$sql->Lista();
	$sql->limpar();
	foreach($arquivos as $chave => $arquivo){
		@unlink($base_dir.'/arquivos/metas/'.(int)$pg_meta_id.'/'.$arquivo['arquivo_nome_real']);
		}

	$sql->setExcluir('arquivo');
	$sql->adOnde('arquivo_meta='.(int)$pg_meta_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela arquivo!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('links');
	$sql->adOnde('link_meta='.(int)$pg_meta_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela links!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->adTabela('foruns');
	$sql->adCampo('forum_id');
	$sql->adOnde('forum_meta='.(int)$pg_meta_id);
	$foruns=$sql->Lista();
	$sql->limpar();
	foreach($foruns as $chave => $forum){
		$sql->setExcluir('forum_visitas');
		$sql->adOnde('visita_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_visitas!'.$bd->stderr(true));
		$sql->limpar();
		
		$sql->setExcluir('forum_acompanhar');
		$sql->adOnde('acompanhar_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_acompanhar!'.$bd->stderr(true));
		$sql->limpar();
		
		$sql->setExcluir('forum_mensagens');
		$sql->adOnde('mensagem_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_acompanhar!'.$bd->stderr(true));
		$sql->limpar();
		}
	$sql->setExcluir('foruns');
	$sql->adOnde('forum_meta='.(int)$pg_meta_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela foruns!'.$bd->stderr(true));
	$sql->limpar();

	
	$Aplic->setMsg('Meta excluída', UI_MSG_ALERTA);
	$Aplic->redirecionar('m=praticas&a=meta_lista');
	}


//excluir fator crítico
if ($modulo=='fator' && $excluir && $fator_id){
	
	//verifica se não uma iniciativa vinculada
	$sql->adTabela('estrategias');
	$sql->adCampo('count(pg_estrategia_fator)');
	$sql->adOnde('pg_estrategia_fator='.(int)$fator_id);
	$qnt=$sql->Resultado();
	$sql->limpar();
	if ($qnt > 0){
		$Aplic->setMsg('Não é possível excluir! Há '.$config['iniciativa'].' vinculad'.$config['genero_iniciativa'].'.', UI_MSG_ERRO);
		$Aplic->redirecionar('m=praticas&a=fator_ver&fator_id='.(int)$fator_id);
		exit();
		}
	
	$Aplic->setMsg('Fator crítico de sucesso excluído', UI_MSG_ALERTA);
	$Aplic->redirecionar('m=praticas&a=fator_lista');
	}
















//excluir perspectiva
if ($modulo=='tema' && $excluir && $tema_id){
	
	//verifica se não tem tema vinculado
	$sql->adTabela('objetivo');
	$sql->adCampo('count(objetivo_tema)');
	$sql->adOnde('objetivo_tema='.(int)$tema_id);
	$qnt=$sql->Resultado();
	$sql->limpar();
	if ($qnt > 0){
		$Aplic->setMsg('Não é possível excluir! Há '.$config['genero_objetivo'].' vinculado.', UI_MSG_ERRO);
		$Aplic->redirecionar('m=praticas&a=tema_ver&tema_id='.(int)$tema_id);
		exit();
		}
		
	$Aplic->setMsg(ucfirst($config['tema']).' excluíd'.$config['genero_tema'], UI_MSG_ALERTA);
	$Aplic->redirecionar('m=praticas&a=tema_lista');
	}




	
//excluir perspectiva
if ($modulo=='perspectiva' && $excluir && $pg_perspectiva_id){
	
	//verifica se não tem tema vinculado
	$sql->adTabela('tema');
	$sql->adCampo('count(tema_perspectiva)');
	$sql->adOnde('tema_perspectiva='.(int)$pg_perspectiva_id);
	$qnt=$sql->Resultado();
	$sql->limpar();
	if ($qnt > 0){
		$Aplic->setMsg('Não é possível excluir! Há '.$config['tema'].' vinculad'.$config['genero_tema'].'.', UI_MSG_ERRO);
		$Aplic->redirecionar('m=praticas&a=tema_ver&pg_perspectiva_id='.(int)$pg_perspectiva_id);
		exit();
		}
	
	//verifica se não tem objetivo vinculado
	$sql->adTabela('objetivo');
	$sql->adCampo('count(objetivo_perspectiva)');
	$sql->adOnde('objetivo_perspectiva='.(int)$pg_perspectiva_id);
	$qnt=$sql->Resultado();
	$sql->limpar();
	if ($qnt > 0){
		$Aplic->setMsg('Não é possível excluir! Há '.$config['genero_objetivo'].' vinculado.', UI_MSG_ERRO);
		$Aplic->redirecionar('m=praticas&a=tema_ver&pg_perspectiva_id='.(int)$pg_perspectiva_id);
		exit();
		}
	
	$Aplic->setMsg(ucfirst($config['perspectiva']).' excluíd'.$config['genero_perspectiva'], UI_MSG_ALERTA);
	$Aplic->redirecionar('m=praticas&a=perspectiva_lista');
	}
		
	
//excluir checklist
if ($modulo=='checklist' && $excluir && $checklist_id){
	
	$sql->setExcluir('checklist_dados');
	$sql->adOnde('checklist_dados_checklist_id='.(int)$checklist_id);
	if (!$sql->exec()) die('Não foi possivel excluir os valores da tabela checklist_dados!'.$bd->stderr(true));
	$sql->limpar();

	$sql->setExcluir('checklist_depts');
	$sql->adOnde('checklist_id='.(int)$checklist_id);
	if (!$sql->exec()) die('Não foi possivel excluir os valores da tabela checklist_depts!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('checklist_usuarios');
	$sql->adOnde('checklist_id='.(int)$checklist_id);
	if (!$sql->exec()) die('Não foi possivel excluir os valores da tabela checklist_usuarios!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('checklist_lista');
	$sql->adOnde('checklist_lista_checklist_id='.(int)$checklist_id);
	if (!$sql->exec()) die('Não foi possivel excluir os valores da tabela checklist_lista!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('checklist');
	$sql->adOnde('checklist_id='.(int)$checklist_id);
	if (!$sql->exec()) die('Não foi possivel excluir os valores da tabela checklist_lista!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->adTabela('pratica_indicador');
	$sql->adAtualizar('pratica_indicador_checklist', 0);
	$sql->adOnde('pratica_indicador_checklist='.(int)$checklist_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela pratica_indicador!'.$bd->stderr(true));
	$sql->limpar();
	
	$Aplic->setMsg('Checklist excluído', UI_MSG_ALERTA);
	$Aplic->redirecionar('m=praticas&a=checklist_lista');
	}


//excluir acao
if ($modulo=='plano_acao' && $excluir && $plano_acao_id){
	$sql->setExcluir('plano_acao');
	$sql->adOnde('plano_acao_id='.(int)$plano_acao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela plano_acao!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('plano_acao_log');
	$sql->adOnde('plano_acao_log_plano_acao='.(int)$plano_acao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela plano_acao_log!'.$bd->stderr(true));
	$sql->limpar();	
	
	
	$sql->setExcluir('plano_acao_depts');
	$sql->adOnde('plano_acao_id='.(int)$plano_acao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela plano_acao_depts!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('plano_acao_usuarios');
	$sql->adOnde('plano_acao_id='.(int)$plano_acao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela plano_acao_usuarios!'.$bd->stderr(true));
	$sql->limpar();
		
	$sql->adTabela('eventos');
	$sql->adCampo('evento_id');
	$sql->adOnde('evento_acao='.(int)$plano_acao_id);
	$eventos=$sql->Lista();
	$sql->limpar();
	foreach($eventos as $chave => $evento){
		$sql->setExcluir('evento_usuarios');
		$sql->adOnde('evento_id='.(int)$evento['evento_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_usuarios!'.$bd->stderr(true));
		$sql->limpar();
		$sql->setExcluir('evento_recorrencia');
		$sql->adOnde('recorrencia_id_origem='.(int)$evento['evento_id']);
		$sql->adOnde('recorrencia_tipo=\'evento\'');
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_recorrencia!'.$bd->stderr(true));
		$sql->limpar();
		$sql->setExcluir('evento_contatos');
		$sql->adOnde('evento_id='.(int)$evento['evento_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_contatos!'.$bd->stderr(true));
		$sql->limpar();
		}
	$sql->setExcluir('eventos');
	$sql->adOnde('evento_acao='.(int)$plano_acao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela eventos!'.$bd->stderr(true));
	$sql->limpar();

	$sql->adTabela('arquivo');
	$sql->adCampo('arquivo_id, arquivo_nome_real');
	$sql->adOnde('arquivo_acao='.(int)$plano_acao_id);
	$arquivos=$sql->Lista();
	$sql->limpar();
	foreach($arquivos as $chave => $arquivo){
		@unlink($base_dir.'/arquivos/praticas/'.(int)$pratica_id.'/'.$arquivo['arquivo_nome_real']);
		}

	$sql->setExcluir('arquivo');
	$sql->adOnde('arquivo_acao='.(int)$plano_acao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela arquivo!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('links');
	$sql->adOnde('link_acao='.(int)$plano_acao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela links!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->adTabela('foruns');
	$sql->adCampo('forum_id');
	$sql->adOnde('forum_acao='.(int)$plano_acao_id);
	$foruns=$sql->Lista();
	$sql->limpar();
	foreach($foruns as $chave => $forum){
		$sql->setExcluir('forum_visitas');
		$sql->adOnde('visita_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_visitas!'.$bd->stderr(true));
		$sql->limpar();
		
		$sql->setExcluir('forum_acompanhar');
		$sql->adOnde('acompanhar_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_acompanhar!'.$bd->stderr(true));
		$sql->limpar();
		
		$sql->setExcluir('forum_mensagens');
		$sql->adOnde('mensagem_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_mensagens!'.$bd->stderr(true));
		$sql->limpar();
		}
	$sql->setExcluir('foruns');
	$sql->adOnde('forum_acao='.(int)$plano_acao_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela foruns!'.$bd->stderr(true));
	$sql->limpar();
	
	$Aplic->setMsg('Plano de ação excluido', UI_MSG_ALERTA);
	$Aplic->redirecionar('m=praticas&a=plano_acao_lista');
	}





//excluir indicador
if ($modulo=='indicador' && $excluir && $pratica_indicador_id){
	$vetor=array();
	lista_indicadores_subordinados($pratica_indicador_id, $vetor);
	$vetor[]=$pratica_indicador_id;
	foreach($vetor as $indicador)	excluir_indicador($indicador);
	$Aplic->setMsg('Indicador excluído', UI_MSG_ALERTA);
	$Aplic->redirecionar('m=praticas&a=indicador_lista');
	}
	
	
	
function excluir_indicador($pratica_indicador_id){
	global $_REQUEST, $sql;
	
	$obj = new CIndicador();
	$obj->notificar('excluido', $pratica_indicador_id, $_REQUEST);	
	
	$sql->setExcluir('pratica_indicador');
	$sql->adOnde('pratica_indicador_id='.(int)$pratica_indicador_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela pratica_indicador!'.$bd->stderr(true));
	$sql->limpar();
	
	
	$sql->setExcluir('pratica_indicador_valor');
	$sql->adOnde('pratica_indicador_valor_indicador='.(int)$pratica_indicador_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela pratica_indicador_valor!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('pratica_indicador_usuarios');
	$sql->adOnde('pratica_indicador_id='.(int)$pratica_indicador_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela pratica_indicador_usuarios!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('pratica_indicador_depts');
	$sql->adOnde('pratica_indicador_id='.(int)$pratica_indicador_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela pratica_indicador_depts!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('pratica_indicador_nos_marcadores');
	$sql->adOnde('pratica_indicador_id='.(int)$pratica_indicador_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela pratica_indicador_nos_marcadores!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('pratica_indicador_composicao');
	$sql->adOnde('pratica_indicador_composicao_pai = '.(int)$pratica_indicador_id.' OR pratica_indicador_composicao_filho ='.(int)$pratica_indicador_id);
	$sql->exec();
	$sql->limpar();

	$sql->adTabela('eventos');
	$sql->adCampo('evento_id');
	$sql->adOnde('evento_indicador='.(int)$pratica_indicador_id);
	$eventos=$sql->Lista();
	$sql->limpar();
	foreach($eventos as $chave => $evento){
		$sql->setExcluir('evento_usuarios');
		$sql->adOnde('evento_id='.(int)$evento['evento_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_usuarios!'.$bd->stderr(true));
		$sql->limpar();
		$sql->setExcluir('evento_recorrencia');
		$sql->adOnde('recorrencia_id_origem='.(int)$evento['evento_id']);
		$sql->adOnde('recorrencia_tipo=\'evento\'');
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_recorrencia!'.$bd->stderr(true));
		$sql->limpar();
		$sql->setExcluir('evento_contatos');
		$sql->adOnde('evento_id='.(int)$evento['evento_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_contatos!'.$bd->stderr(true));
		$sql->limpar();
		}
	$sql->setExcluir('eventos');
	$sql->adOnde('evento_indicador='.(int)$pratica_indicador_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela eventos!'.$bd->stderr(true));
	$sql->limpar();

	$sql->adTabela('arquivo');
	$sql->adCampo('arquivo_id, arquivo_nome_real');
	$sql->adOnde('arquivo_indicador='.(int)$pratica_indicador_id);
	$arquivos=$sql->Lista();
	$sql->limpar();
	foreach($arquivos as $chave => $arquivo){
		@unlink($base_dir.'/arquivos/indicadores/'.(int)$pratica_indicador_id.'/'.$arquivo['arquivo_nome_real']);
		}

	$sql->setExcluir('arquivo');
	$sql->adOnde('arquivo_indicador='.(int)$pratica_indicador_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_usuarios!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->setExcluir('links');
	$sql->adOnde('link_indicador='.(int)$pratica_indicador_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela evento_usuarios!'.$bd->stderr(true));
	$sql->limpar();
	
	$sql->adTabela('foruns');
	$sql->adCampo('forum_id');
	$sql->adOnde('forum_indicador='.(int)$pratica_indicador_id);
	$foruns=$sql->Lista();
	$sql->limpar();
	foreach($foruns as $chave => $forum){
		$sql->setExcluir('forum_visitas');
		$sql->adOnde('visita_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_visitas!'.$bd->stderr(true));
		$sql->limpar();
		
		$sql->setExcluir('forum_acompanhar');
		$sql->adOnde('acompanhar_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_acompanhar!'.$bd->stderr(true));
		$sql->limpar();
		
		$sql->setExcluir('forum_mensagens');
		$sql->adOnde('mensagem_forum='.(int)$forum['forum_id']);
		if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela forum_acompanhar!'.$bd->stderr(true));
		$sql->limpar();
		}
	$sql->setExcluir('foruns');
	$sql->adOnde('forum_indicador='.(int)$pratica_indicador_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela foruns!'.$bd->stderr(true));
	$sql->limpar();
	}	

function lista_indicadores_subordinados($pratica_indicador_id, &$vetor=array()){
	$q = new BDConsulta;
	$q->adTabela('pratica_indicador');
	$q->adCampo('pratica_indicador_id');
	$q->adOnde('pratica_indicador_superior = '.(int)$pratica_indicador_id);	
	$q->adOnde('pratica_indicador_id != '.(int)$pratica_indicador_id);	
	$lista=$q->carregarColuna();
	$q->limpar();
	foreach($lista as $indicador){
		$vetor[]=$indicador;
		 lista_indicadores_subordinados($indicador, $vetor);
		}
	}


	
?>