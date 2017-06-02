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





$sql->adTabela('favorito_lista');
$sql->esqUnir('favorito','favorito','favorito.favorito_id=favorito_lista_favorito');

if ($projeto){
	$sql->esqUnir('projetos', 'projetos', 'projetos.projeto_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = projetos.projeto_cia');
 	$sql->adCampo('projetos.projeto_id AS campo, projeto_nome AS nome, cia_nome');
 	} 	
elseif ($tarefa){
	$sql->esqUnir('tarefas', 'tarefas', 'tarefas.tarefa_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = tarefas.tarefa_cia');
 	$sql->adCampo('tarefas.tarefa_id AS campo, tarefa_nome AS nome, cia_nome');
 	} 
 	
elseif ($perspectiva){
	$sql->esqUnir('perspectivas', 'perspectivas', 'perspectivas.pg_perspectiva_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = perspectivas.pg_perspectiva_cia');
 	$sql->adCampo('perspectivas.pg_perspectiva_id AS campo, pg_perspectiva_nome AS nome, cia_nome');
 	} 	
elseif ($tema){
	$sql->esqUnir('tema', 'tema', 'tema.tema_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = tema_cia');
 	$sql->adCampo('tema.tema_id AS campo, tema_nome AS nome, cia_nome');
 	} 	
elseif ($objetivo){
	$sql->esqUnir('objetivo', 'objetivo', 'objetivo.objetivo_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = objetivo_cia');
 	$sql->adCampo('objetivo.objetivo_id AS campo, objetivo_nome AS nome, cia_nome');
 	}  	
elseif ($fator){
	$sql->esqUnir('fator', 'fator', 'fator.fator_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = fator_cia');
 	$sql->adCampo('fator.fator_id AS campo, fator_nome AS nome, cia_nome');
 	} 	
elseif ($estrategia){
	$sql->esqUnir('estrategias', 'estrategias', 'estrategias.pg_estrategia_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = pg_estrategia_cia');
 	$sql->adCampo('estrategias.pg_estrategia_id AS campo, pg_estrategia_nome AS nome, cia_nome');
 	}  	
elseif ($meta){
	$sql->esqUnir('metas', 'metas', 'metas.pg_meta_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = pg_meta_cia');
 	$sql->adCampo('metas.pg_meta_id AS campo, pg_meta_nome AS nome, cia_nome');
 	} 	
elseif ($pratica){
	$sql->esqUnir('praticas', 'praticas', 'praticas.pratica_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = praticas.pratica_cia');
 	$sql->adCampo('praticas.pratica_id AS campo, pratica_nome AS nome, cia_nome');
 	}	
elseif ($indicador){
	$sql->esqUnir('pratica_indicador', 'pratica_indicador', 'pratica_indicador.pratica_indicador_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = pratica_indicador.pratica_indicador_cia');
 	$sql->adCampo('pratica_indicador.pratica_indicador_id AS campo, pratica_indicador_nome AS nome, cia_nome');
 	} 	

elseif ($acao){
	$sql->esqUnir('plano_acao', 'plano_acao', 'plano_acao.plano_acao_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = plano_acao_cia');
 	$sql->adCampo('plano_acao.plano_acao_id AS campo, plano_acao_nome AS nome, cia_nome');
 	} 	
elseif ($canvas){
	$sql->esqUnir('canvas', 'canvas', 'canvas.canvas_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = canvas.canvas_cia');
 	$sql->adCampo('canvas.canvas_id AS campo, canvas_nome AS nome, cia_nome');
 	} 	 	
elseif ($risco){
	$sql->esqUnir('risco', 'risco', 'risco.risco_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = risco_cia');
 	$sql->adCampo('risco_id AS campo, risco_nome AS nome, cia_nome');
 	} 	 	
elseif ($risco_resposta){
	$sql->esqUnir('risco_resposta', 'risco_resposta', 'risco_resposta_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = risco_resposta_cia');
 	$sql->adCampo('risco_resposta_id AS campo, risco_resposta_nome AS nome, cia_nome');
 	} 	 	
elseif ($calendario){
	$sql->esqUnir('calendario', 'calendario', 'calendario_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = calendario_cia');
 	$sql->adCampo('calendario_id AS campo, calendario_nome AS nome, cia_nome');
 	} 	 	
elseif ($monitoramento){
	$sql->esqUnir('monitoramento', 'monitoramento', 'monitoramento.monitoramento_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = monitoramento_cia');
 	$sql->adCampo('monitoramento.monitoramento_id AS campo, monitoramento_nome AS nome, cia_nome');
 	}  		
elseif ($ata){
	$sql->esqUnir('ata', 'ata', 'ata_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = ata_cia');
 	$sql->adCampo('ata_id AS campo, ata_titulo AS nome, cia_nome');
 	} 	 		
elseif ($mswot){
	$sql->esqUnir('mswot', 'mswot', 'mswot_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = mswot_cia');
 	$sql->adCampo('mswot_id AS campo, mswot_nome AS nome, cia_nome');
 	} 
elseif ($swot){
	$sql->esqUnir('swot', 'swot', 'swot_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = swot_cia');
 	$sql->adCampo('swot_id AS campo, swot_nome AS nome, cia_nome');
 	} 	 		
elseif ($operativo){
	$sql->esqUnir('operativo', 'operativo', 'operativo_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = operativo_cia');
 	$sql->adCampo('operativo_id AS campo, operativo_nome AS nome, cia_nome');
 	}  	 	
elseif ($instrumento){
	$sql->esqUnir('instrumento', 'instrumento', 'instrumento_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = instrumento_cia');
 	$sql->adCampo('instrumento_id AS campo, instrumento_nome AS nome, cia_nome');
 	} 	 		
elseif ($recurso){
	$sql->esqUnir('recursos', 'recursos', 'recurso_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = recurso_cia');
 	$sql->adCampo('recurso_id AS campo, recurso_nome AS nome, cia_nome');
 	}  	
elseif ($problema){
	$sql->esqUnir('problema', 'problema', 'problema_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = problema_cia');
 	$sql->adCampo('problema_id AS campo, problema_nome AS nome, cia_nome');
 	} 	 		
elseif ($demanda){
	$sql->esqUnir('demandas', 'demandas', 'demanda_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = demanda_cia');
 	$sql->adCampo('demanda_id AS campo, demanda_nome AS nome, cia_nome');
 	} 
elseif ($programa){
	$sql->esqUnir('programa', 'programa', 'programa_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = programa_cia');
 	$sql->adCampo('programa_id AS campo, programa_nome AS nome, cia_nome');
 	} 	 		
elseif ($licao){
	$sql->esqUnir('licao', 'licao', 'licao_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = licao_cia');
 	$sql->adCampo('licao_id AS campo, licao_nome AS nome, cia_nome');
 	}  	 	
elseif ($evento){
	$sql->esqUnir('eventos', 'eventos', 'evento_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = evento_cia');
 	$sql->adCampo('evento_id AS campo, evento_titulo AS nome, cia_nome');
 	} 	 		
elseif ($link){
	$sql->esqUnir('links', 'links', 'link_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = link_cia');
 	$sql->adCampo('link_id AS campo, link_nome AS nome, cia_nome');
 	} 
elseif ($avaliacao){
	$sql->esqUnir('avaliacao', 'avaliacao', 'avaliacao_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = avaliacao_cia');
 	$sql->adCampo('avaliacao_id AS campo, avaliacao_nome AS nome, cia_nome');
 	} 	 		
elseif ($tgn){
	$sql->esqUnir('tgn', 'tgn', 'tgn_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = tgn_cia');
 	$sql->adCampo('tgn_id AS campo, tgn_nome AS nome, cia_nome');
 	} 
elseif ($brainstorm){
	$sql->esqUnir('brainstorm', 'brainstorm', 'brainstorm.brainstorm_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = brainstorm_cia');
 	$sql->adCampo('brainstorm.brainstorm_id AS campo, brainstorm_nome AS nome, cia_nome');
 	} 	 	
elseif ($gut){
	$sql->esqUnir('gut', 'gut', 'gut_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = gut_cia');
 	$sql->adCampo('gut_id AS campo, gut_nome AS nome, cia_nome');
 	} 	 		
elseif ($causa_efeito){
	$sql->esqUnir('causa_efeito', 'causa_efeito', 'causa_efeito_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = causa_efeito_cia');
 	$sql->adCampo('causa_efeito_id AS campo, causa_efeito_nome AS nome, cia_nome');
 	}  	 	
elseif ($arquivo){
	$sql->esqUnir('arquivo', 'arquivo', 'arquivo_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = arquivo_cia');
 	$sql->adCampo('arquivo_id AS campo, arquivo_nome AS nome, cia_nome');
 	} 	 		
elseif ($forum){
	$sql->esqUnir('foruns', 'foruns', 'forum_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = forum_cia');
 	$sql->adCampo('forum_id AS campo, forum_nome AS nome, cia_nome');
 	} 
elseif ($checklist){
	$sql->esqUnir('checklist', 'checklist', 'checklist.checklist_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = checklist_cia');
 	$sql->adCampo('checklist.checklist_id AS campo, checklist_nome AS nome, cia_nome');
 	} 	
elseif ($agenda){
	$sql->esqUnir('agenda', 'agenda', 'agenda_id = favorito_lista_campo');
	$sql->esqUnir('usuarios', 'us', 'us.usuario_id = agenda_dono');
	$sql->esqUnir('contatos', 'co', 'us.usuario_contato = co.contato_id');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = contato_cia');
 	$sql->adCampo('agenda_id AS campo, agenda_nome AS nome, cia_nome');
 	} 	 		
elseif ($agrupamento){
	$sql->esqUnir('agrupamento', 'agrupamento', 'agrupamento_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = agrupamento_cia');
 	$sql->adCampo('agrupamento_id AS campo, agrupamento_nome AS nome, cia_nome');
 	} 
elseif ($patrocinador){
	$sql->esqUnir('patrocinadores', 'patrocinadores', 'patrocinador_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = patrocinador_cia');
 	$sql->adCampo('patrocinador_id AS campo, patrocinador_nome AS nome, cia_nome');
 	} 	 		
elseif ($template){
	$sql->esqUnir('template', 'template', 'template_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = template_cia');
 	$sql->adCampo('template_id AS campo, template_nome AS nome, cia_nome');
 	}  	 	
elseif ($painel){
	$sql->esqUnir('painel', 'painel', 'painel_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = painel_cia');
 	$sql->adCampo('painel_id AS campo, painel_nome AS nome, cia_nome');
 	} 	 		
elseif ($painel_odometro){
	$sql->esqUnir('painel_odometro', 'painel_odometro', 'painel_odometro_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = painel_odometro_cia');
 	$sql->adCampo('painel_odometro_id AS campo, painel_odometro_nome AS nome, cia_nome');
 	}  	 	 	
elseif ($painel_composicao){
	$sql->esqUnir('painel_composicao', 'painel_composicao', 'painel_composicao_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = painel_composicao_cia');
 	$sql->adCampo('painel_composicao_id AS campo, painel_composicao_nome AS nome, cia_nome');
 	}
elseif ($tr){
	$sql->esqUnir('tr', 'tr', 'tr_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = tr_cia');
 	$sql->adCampo('tr_id AS campo, tr_nome AS nome, cia_nome');
 	}
elseif ($me){
	$sql->esqUnir('me', 'me', 'me.me_id = favorito_lista_campo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = me_cia');
 	$sql->adCampo('me.me_id AS campo, me_nome AS nome, cia_nome');
 	}  	
$sql->adOnde('favorito.favorito_id='.(int)$favorito_id);
$sql->adOrdem('favorito_nome ASC');
$lista=$sql->Lista();
$sql->limpar();


$campos_escolhidos=array();
foreach($lista AS $linha) $campos_escolhidos[$linha['campo']]=$linha['nome'].($Aplic->getPref('om_usuario') && $linha['cia_nome'] ? ' - '.$linha['cia_nome']: '');


if ($projeto){
	$sql->adTabela('projetos');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = projetos.projeto_cia');
 	$sql->adCampo('projetos.projeto_id AS campo, projeto_nome AS nome, cia_nome');
 	$sql->adOnde('projeto_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('projeto_ativo=1');
 	} 
elseif ($tarefa){
	$sql->adTabela('tarefas');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = tarefas.tarefa_cia');
 	$sql->adCampo('tarefas.tarefa_id AS campo, tarefa_nome AS nome, cia_nome');
 	$sql->adOnde('tarefa_cia='.(int)$Aplic->usuario_cia);
 	}
elseif ($perspectiva){
	$sql->adTabela('perspectivas');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = perspectivas.pg_perspectiva_cia');
 	$sql->adCampo('perspectivas.pg_perspectiva_id AS campo, pg_perspectiva_nome AS nome, cia_nome');
 	$sql->adOnde('pg_perspectiva_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('pg_perspectiva_ativo=1');
 	}
elseif ($tema){
	$sql->adTabela('tema');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = tema_cia');
 	$sql->adCampo('tema.tema_id AS campo, tema_nome AS nome, cia_nome');
 	$sql->adOnde('tema_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('tema_ativo=1');
 	} 	
elseif ($objetivo){
	$sql->adTabela('objetivo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = objetivo_cia');
 	$sql->adCampo('objetivo.objetivo_id AS campo, objetivo_nome AS nome, cia_nome');
 	$sql->adOnde('objetivo_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('objetivo_ativo=1');
 	}  	
elseif ($fator){
	$sql->adTabela('fator');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = fator_cia');
 	$sql->adCampo('fator_id AS campo, fator_nome AS nome, cia_nome');
 	$sql->adOnde('fator_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('fator_ativo=1');
 	} 	
elseif ($estrategia){
	$sql->adTabela('estrategias');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = pg_estrategia_cia');
 	$sql->adCampo('estrategias.pg_estrategia_id AS campo, pg_estrategia_nome AS nome, cia_nome');
 	$sql->adOnde('pg_estrategia_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('pg_estrategia_ativo=1');
 	}  	
elseif ($meta){
	$sql->adTabela('metas');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = pg_meta_cia');
 	$sql->adCampo('metas.pg_meta_id AS campo, pg_meta_nome AS nome, cia_nome');
 	$sql->adOnde('pg_meta_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('pg_meta_ativo=1');
 	} 	
elseif ($pratica){
	$sql->adTabela('praticas');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = praticas.pratica_cia');
 	$sql->adCampo('praticas.pratica_id AS campo, pratica_nome AS nome, cia_nome');
 	$sql->adOnde('pratica_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('pratica_ativa=1');
 	}	
elseif ($indicador){
	$sql->adTabela('pratica_indicador');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = pratica_indicador.pratica_indicador_cia');
 	$sql->adCampo('pratica_indicador.pratica_indicador_id AS campo, pratica_indicador_nome AS nome, cia_nome');
 	$sql->adOnde('pratica_indicador_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('pratica_indicador_ativo=1');
 	} 	
elseif ($acao){
	$sql->adTabela('plano_acao');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = plano_acao_cia');
 	$sql->adCampo('plano_acao_id AS campo, plano_acao_nome AS nome, cia_nome');
 	$sql->adOnde('plano_acao_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('plano_acao_ativo=1');
 	}
elseif ($canvas){
	$sql->adTabela('canvas');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = canvas.canvas_cia');
 	$sql->adCampo('canvas.canvas_id AS campo, canvas_nome AS nome, cia_nome');
 	$sql->adOnde('canvas_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('canvas_ativo=1');
 	}
elseif ($risco){
	$sql->adTabela('risco');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = risco_cia');
 	$sql->adCampo('risco_id AS campo, risco_nome AS nome, cia_nome');
 	$sql->adOnde('risco_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('risco_ativo=1');
 	} 	
elseif ($risco_resposta){
	$sql->adTabela('risco_resposta');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = risco_resposta_cia');
 	$sql->adCampo('risco_resposta_id AS campo, risco_resposta_nome AS nome, cia_nome');
 	$sql->adOnde('risco_resposta_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('risco_resposta_ativo=1');
 	} 	
elseif ($calendario){
	$sql->adTabela('calendario');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = calendario_cia');
 	$sql->adCampo('calendario_id AS campo, calendario_nome AS nome, cia_nome');
 	$sql->adOnde('calendario_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('calendario_ativo=1');
 	} 	 	
elseif ($monitoramento){
	$sql->adTabela('monitoramento');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = monitoramento_cia');
 	$sql->adCampo('monitoramento.monitoramento_id AS campo, monitoramento_nome AS nome, cia_nome');
 	$sql->adOnde('monitoramento_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('monitoramento_ativo=1');
 	}  		
elseif ($ata){
	$sql->adTabela('ata');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = ata_cia');
 	$sql->adCampo('ata_id AS campo, ata_titulo AS nome, cia_nome');
 	$sql->adOnde('ata_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('ata_ativo=1');
 	}	 		
elseif ($mswot){
	$sql->adTabela('mswot');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = mswot_cia');
 	$sql->adCampo('mswot_id AS campo, mswot_nome AS nome, cia_nome');
 	$sql->adOnde('mswot_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('mswot_ativo=1');
 	} 
elseif ($swot){
	$sql->adTabela('swot');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = swot_cia');
 	$sql->adCampo('swot_id AS campo, swot_nome AS nome, cia_nome');
 	$sql->adOnde('swot_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('swot_ativo=1');
 	}	 		
elseif ($operativo){
	$sql->adTabela('operativo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = operativo_cia');
 	$sql->adCampo('operativo_id AS campo, operativo_nome AS nome, cia_nome');
 	$sql->adOnde('operativo_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('operativo_ativo=1');
 	} 	 	
elseif ($instrumento){
	$sql->adTabela('instrumento');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = instrumento_cia');
 	$sql->adCampo('instrumento_id AS campo, instrumento_nome AS nome, cia_nome');
 	$sql->adOnde('instrumento_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('instrumento_ativo=1');
 	}	 		
elseif ($recurso){
	$sql->adTabela('recursos');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = recurso_cia');
 	$sql->adCampo('recurso_id AS campo, recurso_nome AS nome, cia_nome');
 	$sql->adOnde('recurso_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('recurso_ativo=1');
 	}	
elseif ($problema){
	$sql->adTabela('problema');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = problema_cia');
 	$sql->adCampo('problema_id AS campo, problema_nome AS nome, cia_nome');
 	$sql->adOnde('problema_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('problema_ativo=1');
 	}	 		
elseif ($demanda){
	$sql->adTabela('demandas');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = demanda_cia');
 	$sql->adCampo('demanda_id AS campo, demanda_nome AS nome, cia_nome');
 	$sql->adOnde('demanda_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('demanda_ativa=1');
 	} 
elseif ($programa){
	$sql->adTabela('programa');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = programa_cia');
 	$sql->adCampo('programa_id AS campo, programa_nome AS nome, cia_nome');
 	$sql->adOnde('programa_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('programa_ativo=1');
 	}	 		
elseif ($licao){
	$sql->adTabela('licao');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = licao_cia');
 	$sql->adCampo('licao_id AS campo, licao_nome AS nome, cia_nome');
 	$sql->adOnde('licao_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('licao_ativa=1');
 	} 	 	
elseif ($evento){
	$sql->adTabela('eventos');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = evento_cia');
 	$sql->adCampo('evento_id AS campo, evento_titulo AS nome, cia_nome');
 	$sql->adOnde('evento_cia='.(int)$Aplic->usuario_cia);
 	} 	 		
elseif ($link){
	$sql->adTabela('links');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = link_cia');
 	$sql->adCampo('link_id AS campo, link_nome AS nome, cia_nome');
 	$sql->adOnde('link_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('link_ativo=1');
 	}
elseif ($avaliacao){
	$sql->adTabela('avaliacao');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = avaliacao_cia');
 	$sql->adCampo('avaliacao_id AS campo, avaliacao_nome AS nome, cia_nome');
 	$sql->adOnde('avaliacao_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('avaliacao_ativa=1');
 	}	 		
elseif ($tgn){
	$sql->adTabela('tgn');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = tgn_cia');
 	$sql->adCampo('tgn_id AS campo, tgn_nome AS nome, cia_nome');
 	$sql->adOnde('tgn_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('tgn_ativo=1');
 	} 
elseif ($brainstorm){
	$sql->adTabela('brainstorm');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = brainstorm_cia');
 	$sql->adCampo('brainstorm_id AS campo,brainstorm_nome AS nome, cia_nome');
 	$sql->adOnde('brainstorm_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('brainstorm_ativo=1');
 	} 	 	
elseif ($gut){
	$sql->adTabela('gut');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = gut_cia');
 	$sql->adCampo('gut_id AS campo, gut_nome AS nome, cia_nome');
 	$sql->adOnde('gut_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('gut_ativo=1');
 	} 	 		
elseif ($causa_efeito){
	$sql->adTabela('causa_efeito');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = causa_efeito_cia');
 	$sql->adCampo('causa_efeito_id AS campo, causa_efeito_nome AS nome, cia_nome');
 	$sql->adOnde('causa_efeito_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('causa_efeito_ativo=1');
 	}  	 	
elseif ($arquivo){
	$sql->adTabela('arquivo');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = arquivo_cia');
 	$sql->adCampo('arquivo_id AS campo, arquivo_nome AS nome, cia_nome');
 	$sql->adOnde('arquivo_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('arquivo_ativo=1');
 	} 	 		
elseif ($forum){
	$sql->adTabela('foruns');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = forum_cia');
 	$sql->adCampo('forum_id AS campo, forum_nome AS nome, cia_nome');
 	$sql->adOnde('forum_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('forum_ativo=1');
 	} 
elseif ($checklist){
	$sql->adTabela('checklist');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = checklist_cia');
 	$sql->adCampo('checklist.checklist_id AS campo, checklist_nome AS nome, cia_nome');
 	$sql->adOnde('checklist_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('checklist_ativo=1');
 	} 	
elseif ($agenda){
	$sql->adTabela('agenda');
	$sql->esqUnir('usuarios', 'us', 'us.usuario_id = agenda_dono');
	$sql->esqUnir('contatos', 'co', 'us.usuario_contato = co.contato_id');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = contato_cia');
 	$sql->adCampo('agenda_id AS campo, agenda_nome AS nome, cia_nome');
 	$sql->adOnde('contato_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('agenda_ativo=1');
 	} 	 		
elseif ($agrupamento){
	$sql->adTabela('agrupamento');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = agrupamento_cia');
 	$sql->adCampo('agrupamento_id AS campo, agrupamento_nome AS nome, cia_nome');
 	$sql->adOnde('agrupamento_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('agrupamento_ativo=1');
 	} 
elseif ($patrocinador){
	$sql->adTabela('patrocinadores');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = patrocinador_cia');
 	$sql->adCampo('patrocinador_id AS campo, patrocinador_nome AS nome, cia_nome');
 	$sql->adOnde('patrocinador_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('patrocinador_ativo=1');
 	} 	 		
elseif ($template){
	$sql->adTabela('template');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = template_cia');
 	$sql->adCampo('template_id AS campo, template_nome AS nome, cia_nome');
 	$sql->adOnde('template_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('template_ativo=1');
 	}  	 	
elseif ($painel){
	$sql->adTabela('painel');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = painel_cia');
 	$sql->adCampo('painel_id AS campo, painel_nome AS nome, cia_nome');
 	$sql->adOnde('painel_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('painel_ativo=1');
 	}	 		
elseif ($painel_odometro){
	$sql->adTabela('painel_odometro');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = painel_odometro_cia');
 	$sql->adCampo('painel_odometro_id AS campo, painel_odometro_nome AS nome, cia_nome');
 	$sql->adOnde('painel_odometro_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('painel_odometro_ativo=1');
 	}  	 	 	
elseif ($painel_composicao){
	$sql->adTabela('painel_composicao');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = painel_composicao_cia');
 	$sql->adCampo('painel_composicao_id AS campo, painel_composicao_nome AS nome, cia_nome');
 	$sql->adOnde('painel_composicao_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('painel_composicao_ativo=1');
 	}
elseif ($tr){
	$sql->adTabela('tr');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = tr_cia');
 	$sql->adCampo('tr_id AS campo, tr_nome AS nome, cia_nome');
 	$sql->adOnde('tr_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('tr_ativo=1');
 	}
elseif ($me){
	$sql->adTabela('me');
	$sql->esqUnir('cias', 'cias', 'cias.cia_id = me_cia');
 	$sql->adCampo('me_id AS campo, me_nome AS nome, cia_nome');
 	$sql->adOnde('me_cia='.(int)$Aplic->usuario_cia);
 	$sql->adOnde('me_ativo=1');
 	} 	
 	
$sql->adOrdem('nome ASC');
$lista=$sql->Lista();
$sql->limpar();

$campos_dispiniveis=array();
foreach($lista AS $linha) $campos_dispiniveis[$linha['campo']]=$linha['nome'].($Aplic->getPref('om_usuario') && $linha['cia_nome'] ? ' - '.$linha['cia_nome']: '');

$sql->adTabela('favorito');
$sql->adCampo('favorito_nome, favorito_cia, favorito_usuario, favorito_dept, favorito_acesso, favorito_ativo, favorito_geral');
$sql->adOnde('favorito_id='.(int)$favorito_id);
$favorito=$sql->linha();
$sql->limpar();

$usuarios_selecionados=array();
$cias_selecionadas = array();
$depts_selecionados=array();
if ($favorito_id) {
	$sql->adTabela('favorito_usuario');
	$sql->adCampo('favorito_usuario_usuario');
	$sql->adOnde('favorito_usuario_favorito = '.(int)$favorito_id);
	$usuarios_selecionados = $sql->carregarColuna();
	$sql->limpar();
	
	
	$sql->adTabela('favorito_dept');
	$sql->adCampo('favorito_dept_dept');
	$sql->adOnde('favorito_dept_favorito ='.(int)$favorito_id);
	$depts_selecionados = $sql->carregarColuna();
	$sql->limpar();


	$sql->adTabela('favorito_cia');
	$sql->adCampo('favorito_cia_cia');
	$sql->adOnde('favorito_cia_favorito = '.(int)$favorito_id);
	$cias_selecionadas = $sql->carregarColuna();
	$sql->limpar();
	
	
	
	}





echo '<form method="POST" id="env" name="env">';
echo '<input type=hidden id="a" name="a" value="favoritos">';
echo '<input type=hidden id="m" name="m" value="publico">';	
echo '<input type="hidden" name="fazerSQL" value="favoritos_fazer_sql" />';
echo '<input type=hidden name="favorito_id" id="favorito_id" value="'.$favorito_id.'">';	
echo '<input type="hidden" name="salvar" id="salvar" value="" />';
echo '<input type="hidden" name="del" id="del" value="" />';

echo '<input name="favorito_depts" id="favorito_depts" type="hidden" value="'.implode(',', $depts_selecionados).'" />';
echo '<input name="favorito_cias" id="favorito_cias" type="hidden" value="'.implode(',', $cias_selecionadas).'" />';
echo '<input name="favorito_usuarios" id="favorito_usuarios" type="hidden" value="'.implode(',', $usuarios_selecionados).'" />';

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


$botoesTitulo = new CBlocoTitulo(($favorito_id ? 'Editar' : 'Adicionar').' Favorito de '.$titulo, 'favoritos.png', $m, $m.'.'.$a);
$botoesTitulo->mostrar();


echo estiloTopoCaixa(); 
echo '<table width="100%" class="std" align="center" cellspacing=0 cellpadding=0>';
echo '<tr><td align="right" width=100>'.dica('Nome', 'Nome para identificação do favorito.').'Nome:'.dicaF().'</td><td><input type=text class="texto" name="favorito_nome" id="favorito_nome" value="'.$favorito['favorito_nome'].'" style="width:286px"></td></tr>';



if ($Aplic->usuario_super_admin){
	
	$visivel=(!$favorito_id	|| $favorito['favorito_geral']);

	echo '<tr><td align="right">'.dica('Tipo', 'Tipo de favorito, que pode ser geral quando se está criando para ser utilizado por vários '.$config['usuarios'].' ou particular, quando somente é de interesse do administrador geral.').'Tipo:'.dicaF().'</td><td><input class="texto" type="radio" name="favorito_geral" onChange="mudar_adm(1)" value="1"'.($visivel ? ' checked="checked"' : '').'>Geral<input class="texto" type="radio" name="favorito_geral" onChange="mudar_adm(0)" value="0" '.(!$visivel ? ' checked="checked"' : '').'>Particular</td></tr>';

	echo '<tr style="display: '.($visivel ? '' : 'none').'" id="combo_ver_cia"><td align=right nowrap="nowrap">'.dica(ucfirst($config['organizacao']).' Responsável', 'Selecione '.$config['genero_organizacao'].' '.$config['organizacao'].' responsável pelo favorito.').ucfirst($config['organizacao']).' responsável:'.dicaF().'</td><td><div id="combo_cia">'.selecionar_om(($favorito['favorito_cia'] ? $favorito['favorito_cia'] : $Aplic->usuario_cia), 'favorito_cia', 'class=texto size=1 style="width:286px;" onchange="javascript:mudar_om();"').'</div></td></tr>';
	
	$saida_cias='';
	if (count($cias_selecionadas)) {
			$saida_cias.= '<table cellpadding=0 cellspacing=0 class="texto" width=100%>';
			$saida_cias.= '<tr><td>'.link_cia($cias_selecionadas[0]);
			$qnt_lista_cias=count($cias_selecionadas);
			if ($qnt_lista_cias > 1) {
					$lista='';
					for ($i = 1, $i_cmp = $qnt_lista_cias; $i < $i_cmp; $i++) $lista.=link_cia($cias_selecionadas[$i]).'<br>';
					$saida_cias.= dica('Outr'.$config['genero_organizacao'].'s '.ucfirst($config['organizacoes']), 'Clique para visualizar '.$config['genero_organizacao'].'s demais '.strtolower($config['organizacoes']).'.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_cias\');">(+'.($qnt_lista_cias - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_cias"><br>'.$lista.'</span>';
					}
			$saida_cias.= '</td></tr></table>';
			}
	else $saida_cias.= '<table cellpadding=0 cellspacing=0 class="texto" width=100%><tr><td>&nbsp;</td></tr></table>';
	echo '<tr style="display: '.($visivel ? '' : 'none').'" id="combo_lista_cias"><td align="right" nowrap="nowrap">'.dica(ucfirst($config['organizacoes']).' Envolvid'.$config['genero_organizacao'].'s', 'Quais '.strtolower($config['organizacoes']).' estão envolvid'.$config['genero_organizacao'].'s.').ucfirst($config['organizacoes']).' envolvid'.$config['genero_organizacao'].'s:'.dicaF().'</td><td><table cellpadding=0 cellspacing=0><tr><td style="width:286px;"><div id="combo_cias">'.$saida_cias.'</div></td><td>'.botao_icone('organizacao_p.gif','Selecionar', 'selecionar '.$config['organizacoes'],'popCias()').'</td></tr></table></td></tr>';
	
	echo '<tr style="display: '.($visivel ? '' : 'none').'" id="combo_dept"><td align="right" nowrap="nowrap">'.dica(ucfirst($config['departamento']).' Responsável', 'Escolha pressionando o ícone à direita qual '.$config['genero_dept'].' '.$config['dept'].' responsável por esta ata.').ucfirst($config['departamento']).' responsável:'.dicaF().'</td><td><input type="hidden" name="favorito_dept" id="favorito_dept" value="'.($favorito_id ? $favorito['favorito_dept'] : ($Aplic->getEstado('dept_id') !== null ? ($Aplic->getEstado('dept_id') ? $Aplic->getEstado('dept_id') : null) : $Aplic->usuario_dept)).'" /><input type="text" class="texto" name="dept_nome" id="dept_nome" value="'.nome_dept(($favorito_id ? $favorito['favorito_dept'] : ($Aplic->getEstado('dept_id') !== null ? ($Aplic->getEstado('dept_id') ? $Aplic->getEstado('dept_id') : null) : $Aplic->usuario_dept))).'" style="width:284px;" READONLY />'.botao_icone('secoes_p.gif','Selecionar', 'selecionar '.$config['departamento'],'popDept()').'</td></tr>';
	$saida_depts='';
	if (count($depts_selecionados)) {
			$saida_depts.= '<table cellpadding=0 cellspacing=0 class="texto" width=100%>';
			$saida_depts.= '<tr><td>'.link_secao($depts_selecionados[0]);
			$qnt_lista_depts=count($depts_selecionados);
			if ($qnt_lista_depts > 1) {
					$lista='';
					for ($i = 1, $i_cmp = $qnt_lista_depts; $i < $i_cmp; $i++) $lista.=link_secao($depts_selecionados[$i]).'<br>';
					$saida_depts.= dica('Outr'.$config['genero_dept'].'s '.ucfirst($config['departamentos']), 'Clique para visualizar '.$config['genero_dept'].'s demais '.strtolower($config['departamentos']).'.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_depts\');">(+'.($qnt_lista_depts - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_depts"><br>'.$lista.'</span>';
					}
			$saida_depts.= '</td></tr></table>';
			}
	else $saida_depts.= '<table cellpadding=0 cellspacing=0 class="texto" width=100%><tr><td>&nbsp;</td></tr></table>';
	echo '<tr style="display: '.($visivel ? '' : 'none').'" id="combo_lista_depts"><td align="right" nowrap="nowrap">'.dica(ucfirst($config['departamentos']).' Envolvid'.$config['genero_dept'].'s', 'Quais '.strtolower($config['departamentos']).' estão envolvid'.$config['genero_dept'].'s.').ucfirst($config['departamentos']).' envolvid'.$config['genero_dept'].'s:'.dicaF().'</td><td><table cellpadding=0 cellspacing=0><tr><td style="width:286px;"><div id="combo_depts">'.$saida_depts.'</div></td><td>'.botao_icone('secoes_p.gif','Selecionar', 'selecionar '.$config['departamentos'],'popDepts()').'</td></tr></table></td></tr>';
	
	echo '<tr style="display: '.($visivel ? '' : 'none').'" id="combo_usuario"><td align="right" nowrap="nowrap">'.dica('Responsável', 'Todo favorito deve ter um responsável.').'Responsável:'.dicaF().'</td><td colspan="2"><input type="hidden" id="favorito_usuario" name="favorito_usuario" value="'.($favorito['favorito_usuario'] ? $favorito['favorito_usuario'] : $Aplic->usuario_id).'" /><input type="text" id="nome_responsavel" name="nome_responsavel" value="'.nome_om(($favorito['favorito_usuario'] ? $favorito['favorito_usuario'] : $Aplic->usuario_id),$Aplic->getPref('om_usuario')).'" style="width:284px;" class="texto" READONLY /><a href="javascript: void(0);" onclick="popResponsavel();">'.imagem('icones/usuarios.gif','Selecionar '.ucfirst($config['usuario']),'Clique neste ícone '.imagem('icones/usuarios.gif').' para selecionar '.($config['genero_usuario']=='o' ? 'um' : 'uma').' '.$config['usuario'].'.').'</a></td></tr>';
	
	$saida_usuarios='';
	if (count($usuarios_selecionados)) {
			$saida_usuarios.= '<table cellpadding=0 cellspacing=0 class="texto" width=100%>';
			$saida_usuarios.= '<tr><td>'.link_usuario($usuarios_selecionados[0],'','','esquerda');
			$qnt_lista_usuarios=count($usuarios_selecionados);
			if ($qnt_lista_usuarios > 1) {
					$lista='';
					for ($i = 1, $i_cmp = $qnt_lista_usuarios; $i < $i_cmp; $i++) $lista.=link_usuario($usuarios_selecionados[$i],'','','esquerda').'<br>';
					$saida_usuarios.= dica('Outr'.$config['genero_usuario'].'s '.ucfirst($config['usuarios']), 'Clique para visualizar '.$config['genero_usuario'].'s demais '.strtolower($config['usuarios']).'.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_usuarios\');">(+'.($qnt_lista_usuarios - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_usuarios"><br>'.$lista.'</span>';
					}
			$saida_usuarios.= '</td></tr></table>';
			}
	else $saida_usuarios.= '<table cellpadding=0 cellspacing=0 class="texto" width=100%><tr><td>&nbsp;</td></tr></table>';
	echo '<tr style="display: '.($visivel ? '' : 'none').'" id="combo_designados"><td align="right" nowrap="nowrap">'.dica('Designados', 'Quais '.strtolower($config['usuarios']).' estão envolvid'.$config['genero_usuario'].'s.').'Designados:'.dicaF().'</td><td><table cellpadding=0 cellspacing=0><tr><td style="width:286px;"><div id="combo_usuarios">'.$saida_usuarios.'</div></td><td>'.botao_icone('usuarios.gif','Selecionar', 'selecionar '.$config['usuarios'].'.','popUsuarios()').'</td></tr></table></td></tr>';
	$favorito_acesso=array(1=>'Protegido', 2=>'Participantes');
	echo '<tr style="display: '.($visivel ? '' : 'none').'" id="combo_acesso"><td align="right" nowrap="nowrap">'.dica('Nível de Acesso', 'O favorito ata de reunião pode ter dois níveis de acesso:<ul><li><b>Protegido</b> - Todos podem ver o favorito.</li><li><b>Participante</b> - Somente o responsável e os designados para o favorito podem ver </li></ul>').'Nível de acesso:'.dicaF().'</td><td>'.selecionaVetor($favorito_acesso, 'favorito_acesso', 'class="texto" style="width:286px;"', ($favorito_id ? $favorito['favorito_acesso'] : 1)).'</td></tr>';
	echo '<tr style="display: '.($visivel ? '' : 'none').'" id="combo_ativo"><td align="right">'.dica('Ativo', 'Caso o favorito ainda esteja ativo deverá estar marcado este campo.').'Ativo:'.dicaF().'</td><td><input type="checkbox" value="1" name="favorito_ativo" '.($favorito['favorito_ativo'] || !$favorito_id ? 'checked="checked"' : '').' /></td></tr>';
	}
else {
	echo '<input type=hidden name="favorito_cia" id="favorito_cia" value="'.($favorito['favorito_cia'] ? $favorito['favorito_cia'] : $Aplic->usuario_cia).'">';
	echo '<input type=hidden name="favorito_usuario" id="favorito_usuario" value="'.($favorito['favorito_usuario'] ? $favorito['favorito_usuario'] : $Aplic->usuario_id).'">';
	echo '<input type=hidden name="favorito_dept" id="favorito_dept" value="">';
	echo '<input type=hidden name="favorito_acesso" id="favorito_acesso" value="0">';
	echo '<input type=hidden name="favorito_ativo" id="favorito_ativo" value="1">';
	echo '<input type=hidden name="favorito_geral" id="favorito_geral" value="0">';
	}

echo '<tr><td colspan=20>&nbsp;<td></tr>';
echo '<tr><td align=right>'.dica(ucfirst($config['organizacao']), 'Filtrar pel'.$config['genero_organizacao'].' '.$config['organizacao'].' selecionad'.$config['genero_organizacao'].'.').ucfirst($config['organizacao']).':'.dicaF().'</td><td><table cellspacing=0 cellpadding=0><tr><td><div id="combo_cia_disponiveis">'.selecionar_om($Aplic->usuario_cia, 'cia_disponiveis', 'class=texto size=1 style="width:288px;" onchange="mudar_om_disponiveis();"','',1).'</div></td><td><a href="javascript:void(0);" onclick="'.($objetivo || $estrategia ? 'atualizar_anos();' : '') .'mudar_disponiveis()">'.imagem('icones/atualizar.png','Atualizar Disponíveis','Clique neste ícone '.imagem('icones/atualizar.png').' para atualizar a lista de disponíveis.').'</a></td></tr></table></td></tr>';
echo '<tr><td colspan=20><table width="100%" cellspacing=0 cellpadding=0>';
echo '<tr><td valign="top" width="50%">'.dica('Disponíveis', 'Disponíveis para fazerem parte do favorito.').'Disponíveis'.dicaF().'</td><td width="50%">'.dica('Pertencentes', 'Lista dos pertencentes ao favorito').'Pertencentes'.dicaF().'</td></tr>';
echo '<tr><td><div id="combo_disponiveis">'.selecionaVetor($campos_dispiniveis, 'lista_disponiveis[]', 'style="width:100%;" size="10" class="texto" multiple="multiple" ondblclick="mover(document.env.lista_disponiveis, document.env.campos_escolhidos);"','','','lista_disponiveis').'</div></td><td>'.selecionaVetor($campos_escolhidos, 'campos_escolhidos[]', 'style="width:100%;" size="10" class="texto" multiple="multiple" ondblclick="mover2(document.env.campos_escolhidos,document.env.lista_disponiveis);"','','','campos_escolhidos').'</td></tr>';
echo '<tr><td align="left">'.botao('&nbsp;&gt;&nbsp;', 'Adicionar', 'Utilize este botão para adicionar um disdponível à lista dos pertencentes.</p>Caso deseje inserir múltiplos disponíveis de uma única vez, mantenha o botão <i>CTRL</i> pressionado enquanto clica com o botão esquerdo do mouse nos disponíveis da lista acima.','','mover(document.env.lista_disponiveis, document.env.campos_escolhidos);','','',0).'</td><td align="right">'.botao('&nbsp;&lt;&nbsp;', 'Retirar', 'Utilize este botão para retirar um dos pertencentes da lista dos pertencentes. </p>Caso deseje retirar múltiplos pertencentes de uma única vez, mantenha o botão <i>CTRL</i> pressionado enquanto clica com o botão esquerdo do mouse nos pertencentes da lista acima.','','mover2(document.env.campos_escolhidos,document.env.lista_disponiveis);','','',0).'</td></tr>';

echo '<tr><td align="left">'.botao('salvar', 'Salvar', 'Salvar os dados.','','enviarDados()','','',0).'</td><td align="right">'.botao('cancelar', 'Cancelar', 'Cancelar a edição de favorito.','','url_passar(0, \''.$Aplic->getPosicao().'\')','','',0).'</td></tr>';
echo '</table></td></tr>';


	
echo '</table>';

echo estiloFundoCaixa();	
	
echo '</form>';
?>

<script LANGUAGE="javascript">

function mudar_adm(tipo){
	if (tipo){
		document.getElementById('combo_ver_cia').style.display='';
		document.getElementById('combo_lista_cias').style.display='';
		document.getElementById('combo_dept').style.display='';
		document.getElementById('combo_lista_depts').style.display='';
		document.getElementById('combo_ativo').style.display='';
		document.getElementById('combo_usuario').style.display='';
		document.getElementById('combo_designados').style.display='';
		document.getElementById('combo_acesso').style.display='';
		}
	else {
		document.getElementById('combo_ver_cia').style.display='none';
		document.getElementById('combo_lista_cias').style.display='none';
		document.getElementById('combo_dept').style.display='none';
		document.getElementById('combo_lista_depts').style.display='none';
		document.getElementById('combo_ativo').style.display='none';
		document.getElementById('combo_usuario').style.display='none';
		document.getElementById('combo_designados').style.display='none';
		document.getElementById('combo_acesso').style.display='none';
		}	
		
	}

function popResponsavel() {
	if (window.parent.gpwebApp) parent.gpwebApp.popUp('Responsável', 500, 500, 'm=publico&a=selecao_unico_usuario&dialogo=1&chamar_volta=setResponsavel&usuario_id='+document.getElementById('favorito_usuario').value, window.setResponsavel, window);
	else window.open('./index.php?m=publico&a=selecao_unico_usuario&dialogo=1&chamar_volta=setResponsavel&usuario_id='+document.getElementById('favorito_usuario').value, 'Responsável','height=500,width=500,resizable,scrollbars=yes, left=0, top=0');
	}

function setResponsavel(usuario_id, posto, nome, funcao, campo, nome_cia){
	document.getElementById('favorito_usuario').value=usuario_id;
	document.getElementById('nome_responsavel').value=posto+' '+nome+(funcao ? ' - '+funcao : '')+(nome_cia && <?php echo $Aplic->getPref('om_usuario') ?>? ' - '+nome_cia : '');
	}


function mudar_om(){
	xajax_selecionar_om_ajax(document.getElementById('favorito_cia').value,'favorito_cia','combo_cia', 'class="texto" size=1 style="width:284px;" onchange="javascript:mudar_om();"');
	}


function popUsuarios() {
	if (window.parent.gpwebApp) parent.gpwebApp.popUp('<?php echo ucfirst($config["usuarios"])?>', 500, 500, 'm=publico&a=selecao_usuario&dialogo=1&chamar_volta=setUsuarios&cia_id='+document.getElementById('favorito_cia').value+'&usuarios_id_selecionados='+document.getElementById('favorito_usuarios').value, window.setUsuarios, window);
	else window.open('./index.php?m=publico&a=selecao_usuario&dialogo=1&chamar_volta=setUsuarios&cia_id='+document.getElementById('favorito_cia').value+'&usuarios_id_selecionados='+usuarios_id_selecionados, 'usuarios','height=500,width=500,resizable,scrollbars=yes');
	}

function setUsuarios(usuario_id_string){
	if(!usuario_id_string) usuario_id_string = '';
	document.env.favorito_usuarios.value = usuario_id_string;
	usuarios_id_selecionados = usuario_id_string;
	xajax_exibir_usuarios(usuarios_id_selecionados, 'combo_usuarios');
	__buildTooltip();
	}

function popCias() {
	if (window.parent.gpwebApp) parent.gpwebApp.popUp("<?php echo ucfirst($config['organizacoes']) ?>", 500, 500, 'm=publico&a=selecao_organizacoes&dialogo=1&chamar_volta=setCias&cia_id='+document.getElementById('favorito_cia').value+'&cias_id_selecionadas='+document.getElementById('favorito_cias').value, window.setCias, window);
	}

function setCias(organizacao_id_string){
	if(!organizacao_id_string) organizacao_id_string = '';
	document.env.favorito_cias.value = organizacao_id_string;
	document.getElementById('favorito_cias').value = organizacao_id_string;
	xajax_exibir_cias(document.getElementById('favorito_cias').value);
	__buildTooltip();
	}

function popDepts() {
	if (window.parent.gpwebApp) parent.gpwebApp.popUp('<?php echo ucfirst($config["departamentos"])?>', 500, 500, 'm=publico&a=selecao_dept&dialogo=1&chamar_volta=setDepts&cia_id='+document.getElementById('favorito_cia').value+'&depts_id_selecionados='+document.getElementById('favorito_depts').value, window.setDepts, window);
	else window.open('./index.php?m=publico&a=selecao_dept&dialogo=1&chamar_volta=setDepts&cia_id='+document.getElementById('favorito_cia').value+'&depts_id_selecionados='+depts_id_selecionados, 'depts','height=500,width=500,resizable,scrollbars=yes');
	}

function setDepts(departamento_id_string){
	if(!departamento_id_string) departamento_id_string = '';
	document.env.favorito_depts.value = departamento_id_string;
	depts_id_selecionados = departamento_id_string;
	xajax_exibir_depts(depts_id_selecionados);
	__buildTooltip();
	}

function popDept(){
	if (window.parent.gpwebApp) parent.gpwebApp.popUp('<?php echo ucfirst($config["departamento"])?>', 500, 500, 'm=publico&a=selecao_unico_dept&dialogo=1&chamar_volta=setDept&dept_id='+document.getElementById('favorito_dept').value+'&cia_id='+document.getElementById('favorito_cia').value, window.setDept, window);
	else window.open('./index.php?m=publico&a=selecao_unico_dept&dialogo=1&chamar_volta=setDept&dept_id='+document.getElementById('favorito_dept').value+'&cia_id='+document.getElementById('favorito_cia').value, 'Filtrar','height=500,width=500,resizable,scrollbars=yes, left=0, top=0');
	}

function setDept(cia_id, dept_id, dept_nome){
	document.getElementById('favorito_cia').value=cia_id;
	document.getElementById('favorito_dept').value=dept_id;
	document.getElementById('dept_nome').value=(dept_nome ? dept_nome : '');
	}


function cancelar(campo){
	document.getElementById(campo).value='';
	env.submit();
	}

function voltar(){
	<?php 
	if ($projeto) echo 'url_passar(0, "m=projetos&a=index");';
	elseif ($tarefa) echo 'url_passar(0, "m=tarefas&a=index");';
	elseif ($perspectiva) echo 'url_passar(0, "m=praticas&a=perspectiva_lista");';
	elseif ($tema) echo 'url_passar(0, "m=praticas&a=tema_lista");';
	elseif ($objetivo) echo 'url_passar(0, "m=praticas&a=obj_estrategico_lista");';
	elseif ($fator) echo 'url_passar(0, "m=praticas&a=fator_lista");';
	elseif ($estrategia) echo 'url_passar(0, "m=praticas&a=estrategia_lista");';
	elseif ($meta) echo 'url_passar(0, "m=praticas&a=meta_lista");';
	elseif ($pratica) echo 'url_passar(0, "m=praticas&a=pratica_lista");';
	elseif ($indicador) echo 'url_passar(0, "m=praticas&a=indicador_lista");';
	elseif ($acao) echo 'url_passar(0, "m=praticas&a=plano_acao_lista");';
	elseif ($canvas) echo 'url_passar(0, "m=praticas&a=canvas_pro_lista");';
	elseif ($risco) echo 'url_passar(0, "m=praticas&a=risco_pro_lista");';
	elseif ($risco_resposta) echo 'url_passar(0, "m=praticas&a=risco_resposta_pro_lista");';
	elseif ($calendario) echo 'url_passar(0, "m=praticas&a=XXX_lista");';
	elseif ($monitoramento) echo 'url_passar(0, "m=praticas&a=monitoramento_lista_pro");';
	elseif ($ata) echo 'url_passar(0, "m=atas&a=ata_lista");';
	elseif ($mswot) echo 'url_passar(0, "m=swot&a=mswot_lista");';
	elseif ($swot) echo 'url_passar(0, "m=swot&a=swot_lista");';
	elseif ($operativo) echo 'url_passar(0, "m=operativo&a=operativo_lista");';
	elseif ($instrumento) echo 'url_passar(0, "m=instrumento&a=instrumento_lista");';
	elseif ($recurso) echo 'url_passar(0, "m=recursos&a=index");';
	elseif ($problema) echo 'url_passar(0, "m=problema&a=problema_lista");';
	elseif ($demanda) echo 'url_passar(0, "m=projetos&a=demanda_lista");';
	elseif ($programa) echo 'url_passar(0, "m=projetos&a=programa_pro_lista");';
	elseif ($licao) echo 'url_passar(0, "m=projetos&a=licao_lista");';
	elseif ($evento) echo 'url_passar(0, "m=calendario&a=evento_lista_pro");';
	elseif ($link) echo 'url_passar(0, "m=links&a=index");';
	elseif ($avaliacao) echo 'url_passar(0, "m=praticas&a=avaliacao_lista");';
	elseif ($tgn) echo 'url_passar(0, "m=praticas&a=tgn_pro_lista");';
	elseif ($brainstorm) echo 'url_passar(0, "m=praticas&a=brainstorm_pro_lista");';
	elseif ($gut) echo 'url_passar(0, "m=praticas&a=gut_pro_lista");';
	elseif ($causa_efeito) echo 'url_passar(0, "m=praticas&a=causa_efeito_pro_lista");';
	elseif ($arquivo) echo 'url_passar(0, "m=arquivos&a=index");';
	elseif ($forum) echo 'url_passar(0, "m=foruns&a=index");';
	elseif ($checklist) echo 'url_passar(0, "m=praticas&a=checklist_lista");';
	elseif ($agenda) echo 'url_passar(0, "m=email&a=ver_mes");';
	elseif ($agrupamento) echo 'url_passar(0, "m=agrupamento&a=agrupamento_lista");';
	elseif ($patrocinador) echo 'url_passar(0, "m=patrocinadores&a=index");';
	elseif ($template) echo 'url_passar(0, "m=projetos&a=template_pro_lista");';
	elseif ($painel) echo 'url_passar(0, "m=praticas&a=painel_pro_lista");';
	elseif ($painel_odometro) echo 'url_passar(0, "m=praticas&a=odometro_pro_lista");';
	elseif ($painel_composicao) echo 'url_passar(0, "m=praticas&a=painel_composicao_pro_lista");';
	elseif ($tr) echo 'url_passar(0, "m=tr&a=tr_lista");';
	elseif ($me) echo 'url_passar(0, "m=praticas&a=me_lista_pro");';
	?>
	}


function mover(ListaDE,ListaPARA) {

//checar se já existe
	for(var i=0; i<ListaDE.options.length; i++) {
		if (ListaDE.options[i].selected && ListaDE.options[i].value != "0") {
			var no = new Option();
			no.value = ListaDE.options[i].value;
			no.text = ListaDE.options[i].text;
			var existe=0;
			for(var j=0; j <ListaPARA.options.length; j++) { 
				if (ListaPARA.options[j].value==no.value) {
					existe=1;
					break;
					}
				}
			if (!existe) {
				ListaPARA.options[ListaPARA.options.length] = no;		
				}
			}
		}
	}

function mover2(ListaPARA,ListaDE) {
	for(var i=0; i < ListaPARA.options.length; i++) {
		if (ListaPARA.options[i].selected && ListaPARA.options[i].value != "0") {
			ListaPARA.options[i].value = ""
			ListaPARA.options[i].text = ""	
			}
		}
	LimpaVazios(ListaPARA, ListaPARA.options.length);
	}

// Limpa Vazios
function LimpaVazios(box, box_len){
	for(var i=0; i<box_len; i++){
		if(box.options[i].value == ""){
			var ln = i;
			box.options[i] = null;
			break;
			}
		}
	if(ln < box_len){
		box_len -= 1;
		LimpaVazios(box, box_len);
		}
	}

// Seleciona todos os campos da lista
function selecionar() {
	for (var i=0; i < document.getElementById('campos_escolhidos').length ; i++) document.getElementById('campos_escolhidos').options[i].selected = true;
	}

function enviarDados(){
	var f = document.env;
	if (f.favorito_nome.value.length < 2) {
		alert('Escreva um nome válido');
		f.favorito_nome.focus();
		}
	else {
		selecionar();
		document.getElementById('salvar').value=1;
		f.submit();
		}
	}
	
function mudar_om_disponiveis(){	
	xajax_selecionar_om_ajax(document.getElementById('cia_disponiveis').value,'cia_disponiveis','combo_cia_disponiveis', 'class="texto" size=1 style="width:300px;" onchange="mudar_om_disponiveis();"','',1); 	
	}
	

function mudar_disponiveis(){	
	xajax_mudar_disponiveis(
	document.getElementById('cia_disponiveis').value, 
	'lista_disponiveis', 
	'combo_disponiveis', 
	'class="texto" size="11" style="width:100%;" multiple="multiple" ondblclick="mover(document.env.lista_disponiveis, document.env.campos_escolhidos);"', 
	document.getElementById('projeto').value,
	document.getElementById('tarefa').value,
	document.getElementById('perspectiva').value,
	document.getElementById('tema').value,
	document.getElementById('objetivo').value,
	document.getElementById('fator').value,
	document.getElementById('estrategia').value,
	document.getElementById('meta').value,
	document.getElementById('pratica').value,
	document.getElementById('indicador').value,
	document.getElementById('acao').value,
	document.getElementById('canvas').value,
	document.getElementById('risco').value,
	document.getElementById('risco_resposta').value,
	document.getElementById('calendario').value,
	document.getElementById('monitoramento').value,
	document.getElementById('ata').value,
	document.getElementById('mswot').value,
	document.getElementById('swot').value,
	document.getElementById('operativo').value,
	document.getElementById('instrumento').value,
	document.getElementById('recurso').value,
	document.getElementById('problema').value,
	document.getElementById('demanda').value,
	document.getElementById('programa').value,
	document.getElementById('licao').value,
	document.getElementById('evento').value,
	document.getElementById('link').value,
	document.getElementById('avaliacao').value,
	document.getElementById('tgn').value,
	document.getElementById('brainstorm').value,
	document.getElementById('gut').value,
	document.getElementById('causa_efeito').value,
	document.getElementById('arquivo').value,
	document.getElementById('forum').value,
	document.getElementById('checklist').value,
	document.getElementById('agenda').value,
	document.getElementById('agrupamento').value,
	document.getElementById('patrocinador').value,
	document.getElementById('template').value,
	document.getElementById('painel').value,
	document.getElementById('painel_odometro').value,
	document.getElementById('painel_composicao').value,
	document.getElementById('tr').value,
	document.getElementById('me').value
	); 	
	}	
			
function expandir_colapsar(campo){
	if (!document.getElementById(campo).style.display) document.getElementById(campo).style.display='none';
	else document.getElementById(campo).style.display='';
	}
</script>	

