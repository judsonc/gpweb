SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.60';
UPDATE versao SET ultima_atualizacao_bd='2016-09-13';
UPDATE versao SET ultima_atualizacao_codigo='2016-09-13';
UPDATE versao SET versao_bd=376;

DROP TABLE IF EXISTS tr_assinatura;
DROP TABLE IF EXISTS tr_assinatura_historico;

CALL PROC_DROP_FOREIGN_KEY('assinatura','assinatura_atesta');
CALL PROC_DROP_FOREIGN_KEY('assinatura','assinatura_atesta_opcao');

CALL PROC_DROP_FOREIGN_KEY('assinatura_historico','assinatura_historico_atesta');
CALL PROC_DROP_FOREIGN_KEY('assinatura_historico','assinatura_historico_atesta_opcao');

CALL PROC_DROP_FOREIGN_KEY('ata_participante','ata_participante_atesta');
CALL PROC_DROP_FOREIGN_KEY('ata_participante','ata_participante_atesta_opcao');


CALL PROC_DROP_FOREIGN_KEY('tr_atesta_opcao','tr_atesta_opcao_atesta');
ALTER TABLE tr_atesta_opcao DROP KEY tr_atesta_opcao_atesta;


ALTER TABLE tr_atesta_opcao CHANGE tr_atesta_opcao_id assinatura_atesta_opcao_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE tr_atesta_opcao CHANGE tr_atesta_opcao_atesta assinatura_atesta_opcao_atesta INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE tr_atesta_opcao CHANGE tr_atesta_opcao_nome assinatura_atesta_opcao_nome VARCHAR(255) DEFAULT NULL;
ALTER TABLE tr_atesta_opcao CHANGE tr_atesta_opcao_aprova assinatura_atesta_opcao_aprova TINYINT(1) DEFAULT 1;
ALTER TABLE tr_atesta_opcao CHANGE tr_atesta_opcao_ordem assinatura_atesta_opcao_ordem INTEGER(100) UNSIGNED DEFAULT NULL;


ALTER TABLE tr_atesta CHANGE tr_atesta_id assinatura_atesta_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE tr_atesta CHANGE tr_atesta_nome assinatura_atesta_nome VARCHAR(255) DEFAULT NULL;
ALTER TABLE tr_atesta CHANGE tr_atesta_ordem assinatura_atesta_ordem INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE tr_atesta CHANGE tr_atesta_projeto assinatura_atesta_projeto TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_tarefa assinatura_atesta_tarefa TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_perspectiva assinatura_atesta_perspectiva TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_tema assinatura_atesta_tema TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_objetivo assinatura_atesta_objetivo TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_fator assinatura_atesta_fator TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_estrategia assinatura_atesta_estrategia TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_meta assinatura_atesta_meta TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_pratica assinatura_atesta_pratica TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_indicador assinatura_atesta_indicador TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_acao assinatura_atesta_acao TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_canvas assinatura_atesta_canvas TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_risco assinatura_atesta_risco TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_risco_resposta assinatura_atesta_risco_resposta TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_calendario assinatura_atesta_calendario TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_monitoramento assinatura_atesta_monitoramento TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_ata assinatura_atesta_ata TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_mswot assinatura_atesta_mswot TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_swot assinatura_atesta_swot TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_operativo assinatura_atesta_operativo TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_instrumento assinatura_atesta_instrumento TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_recurso assinatura_atesta_recurso TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_problema assinatura_atesta_problema TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_demanda assinatura_atesta_demanda TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_programa assinatura_atesta_programa TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_licao assinatura_atesta_licao TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_evento assinatura_atesta_evento TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_link assinatura_atesta_link TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_avaliacao assinatura_atesta_avaliacao TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_tgn assinatura_atesta_tgn TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_brainstorm assinatura_atesta_brainstorm TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_gut assinatura_atesta_gut TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_causa_efeito assinatura_atesta_causa_efeito TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_arquivo assinatura_atesta_arquivo TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_forum assinatura_atesta_forum TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_checklist assinatura_atesta_checklist TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_agenda assinatura_atesta_agenda TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_agrupamento assinatura_atesta_agrupamento TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_patrocinador assinatura_atesta_patrocinador TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_template assinatura_atesta_template TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_tr assinatura_atesta_tr TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_viabilidade assinatura_atesta_viabilidade TINYINT(1) DEFAULT 0;
ALTER TABLE tr_atesta CHANGE tr_atesta_abertura assinatura_atesta_abertura TINYINT(1) DEFAULT 0;

RENAME TABLE tr_atesta TO assinatura_atesta;

ALTER TABLE tr_atesta_opcao ADD KEY assinatura_atesta_opcao_atesta (assinatura_atesta_opcao_atesta);
ALTER TABLE tr_atesta_opcao ADD CONSTRAINT assinatura_atesta_opcao_atesta FOREIGN KEY (assinatura_atesta_opcao_atesta) REFERENCES assinatura_atesta (assinatura_atesta_id) ON DELETE SET NULL ON UPDATE CASCADE;
RENAME TABLE tr_atesta_opcao TO assinatura_atesta_opcao;


ALTER TABLE ata_participante ADD CONSTRAINT ata_participante_atesta FOREIGN KEY (ata_participante_atesta) REFERENCES assinatura_atesta (assinatura_atesta_id) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE ata_participante ADD CONSTRAINT ata_participante_atesta_opcao FOREIGN KEY (ata_participante_atesta_opcao) REFERENCES assinatura_atesta_opcao (assinatura_atesta_opcao_id) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE tarefa_custos DROP COLUMN tarefa_custos_tr_aprovado;
ALTER TABLE baseline_tarefa_custos DROP COLUMN tarefa_custos_tr_aprovado;

ALTER TABLE plano_acao_item_custos DROP COLUMN plano_acao_item_custos_tr_aprovado;