SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.60';
UPDATE versao SET ultima_atualizacao_bd='2016-09-11';
UPDATE versao SET ultima_atualizacao_codigo='2016-09-11';
UPDATE versao SET versao_bd=371;

CALL PROC_DROP_FOREIGN_KEY('operativo','operativo_fk4');


CALL PROC_DROP_FOREIGN_KEY('baseline_municipio_lista','baseline_municipio_lista_fk7');
CALL PROC_DROP_FOREIGN_KEY('baseline_municipio_lista','baseline_municipio_lista_fk8');

CALL PROC_DROP_FOREIGN_KEY('ata','ata_fk7');
CALL PROC_DROP_FOREIGN_KEY('ata','ata_fk8');

CALL PROC_DROP_FOREIGN_KEY('foruns','forum_fk8');
CALL PROC_DROP_FOREIGN_KEY('foruns','forum_fk9');

CALL PROC_DROP_FOREIGN_KEY('links','link_fk8');
CALL PROC_DROP_FOREIGN_KEY('links','link_fk9');

CALL PROC_DROP_FOREIGN_KEY('msg','msg_fk10');
CALL PROC_DROP_FOREIGN_KEY('msg','msg_fk11');

CALL PROC_DROP_FOREIGN_KEY('pratica_indicador','pratica_indicador_fk3');
CALL PROC_DROP_FOREIGN_KEY('pratica_indicador','pratica_indicador_fk4');

CALL PROC_DROP_FOREIGN_KEY('custo', 'custo_objetivo');
CALL PROC_DROP_FOREIGN_KEY('custo', 'custo_fator');

CALL PROC_DROP_FOREIGN_KEY('jornada_excessao', 'jornada_excessao_fk11');
CALL PROC_DROP_FOREIGN_KEY('jornada_excessao', 'jornada_excessao_fk12');

CALL PROC_DROP_FOREIGN_KEY('jornada_pertence', 'jornada_pertence_fk11');
CALL PROC_DROP_FOREIGN_KEY('jornada_pertence', 'jornada_pertence_fk12');

CALL PROC_DROP_FOREIGN_KEY('ata', 'ata_objetivo');
CALL PROC_DROP_FOREIGN_KEY('ata', 'ata_fator');

CALL PROC_DROP_FOREIGN_KEY('msg', 'msg_objetivo');
CALL PROC_DROP_FOREIGN_KEY('msg', 'msg_fator');

CALL PROC_DROP_FOREIGN_KEY('metas', 'metas_fk3');
CALL PROC_DROP_FOREIGN_KEY('metas', 'metas_fk4');

CALL PROC_DROP_FOREIGN_KEY('pratica_indicador', 'pratica_indicador_objetivo_estrategico');
CALL PROC_DROP_FOREIGN_KEY('pratica_indicador', 'pratica_indicador_fator');

CALL PROC_DROP_FOREIGN_KEY('plano_acao', 'plano_acao_objetivo');
CALL PROC_DROP_FOREIGN_KEY('plano_acao', 'plano_acao_fator');

CALL PROC_DROP_FOREIGN_KEY('arquivo_pasta', 'arquivo_pasta_objetivo');
CALL PROC_DROP_FOREIGN_KEY('arquivo_pasta', 'arquivo_pasta_fator');

CALL PROC_DROP_FOREIGN_KEY('arquivo_pasta', 'arquivo_pastas_fk8');
CALL PROC_DROP_FOREIGN_KEY('arquivo_pasta', 'arquivo_pastas_fk9');

CALL PROC_DROP_FOREIGN_KEY('arquivos', 'arquivo_objetivo');
CALL PROC_DROP_FOREIGN_KEY('arquivos', 'arquivo_fator');

CALL PROC_DROP_FOREIGN_KEY('arquivos', 'arquivo_fk8');
CALL PROC_DROP_FOREIGN_KEY('arquivos', 'arquivo_fk9');


CALL PROC_DROP_FOREIGN_KEY('arquivo_historico', 'arquivo_historico_objetivo');
CALL PROC_DROP_FOREIGN_KEY('arquivo_historico', 'arquivo_historico_fator');

CALL PROC_DROP_FOREIGN_KEY('brainstorm_objetivos', 'brainstorm_objetivos_fk1');

CALL PROC_DROP_FOREIGN_KEY('brainstorm_fatores', 'brainstorm_fatores_fk1');

CALL PROC_DROP_FOREIGN_KEY('causa_efeito_objetivos', 'causa_efeito_objetivos_fk1');
CALL PROC_DROP_FOREIGN_KEY('causa_efeito_fatores', 'causa_efeito_fatores_fk1');

CALL PROC_DROP_FOREIGN_KEY('eventos', 'evento_objetivo');
CALL PROC_DROP_FOREIGN_KEY('eventos', 'evento_fator');

CALL PROC_DROP_FOREIGN_KEY('eventos', 'evento_fk8');
CALL PROC_DROP_FOREIGN_KEY('eventos', 'evento_fk9');

CALL PROC_DROP_FOREIGN_KEY('foruns', 'foruns_objetivo');
CALL PROC_DROP_FOREIGN_KEY('foruns', 'foruns_fator');

CALL PROC_DROP_FOREIGN_KEY('gut_objetivos', 'gut_objetivos_fk1');

CALL PROC_DROP_FOREIGN_KEY('links', 'link_objetivo');
CALL PROC_DROP_FOREIGN_KEY('links', 'link_fator');

CALL PROC_DROP_FOREIGN_KEY('municipio_lista', 'municipio_lista_fk7');
CALL PROC_DROP_FOREIGN_KEY('municipio_lista', 'municipio_lista_fk8');

CALL PROC_DROP_FOREIGN_KEY('plano_gestao_objetivos_estrategicos', 'plano_gestao_objetivos_estrategicos_fk1');

CALL PROC_DROP_FOREIGN_KEY('projeto_area', 'projeto_area_fk4');
CALL PROC_DROP_FOREIGN_KEY('projeto_area', 'projeto_area_fk5');

CALL PROC_DROP_FOREIGN_KEY('objetivo_cia', 'objetivo_cia_objetivo');

CALL PROC_DROP_FOREIGN_KEY('objetivo_perspectiva', 'objetivo_perspectiva_objetivo');

CALL PROC_DROP_FOREIGN_KEY('fator_objetivo', 'fator_objetivo_objetivo');

CALL PROC_DROP_FOREIGN_KEY('me_objetivo', 'me_objetivo_objetivo');

CALL PROC_DROP_FOREIGN_KEY('estrategia_fator', 'estrategia_fator_fator');
CALL PROC_DROP_FOREIGN_KEY('estrategia_fator', 'estrategia_fator_objetivo');

CALL PROC_DROP_FOREIGN_KEY('estrategias', 'estrategias_fk2');

CALL PROC_DROP_FOREIGN_KEY('fator_objetivo', 'fator_objetivo_fator');

CALL PROC_DROP_FOREIGN_KEY('gut_fatores', 'gut_fatores_fk1');

CALL PROC_DROP_FOREIGN_KEY('plano_acao', 'plano_acao_fator');