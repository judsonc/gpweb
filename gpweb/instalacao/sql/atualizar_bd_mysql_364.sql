SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.59';
UPDATE versao SET ultima_atualizacao_bd='2016-07-28';
UPDATE versao SET ultima_atualizacao_codigo='2016-07-28';
UPDATE versao SET versao_bd=364;

ALTER TABLE favoritos_lista DROP FOREIGN KEY favoritos_lista_fk;
ALTER TABLE favoritos_lista DROP KEY favorito_id;
ALTER TABLE favoritos_lista DROP KEY campo_id;

ALTER TABLE favoritos_lista CHANGE favorito_id favorito_lista_favorito INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE favoritos_lista CHANGE campo_id favorito_lista_campo INTEGER(100) UNSIGNED DEFAULT NULL;

RENAME TABLE favoritos_lista TO favorito_lista;

ALTER TABLE favoritos CHANGE projeto favorito_projeto TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE pratica favorito_pratica TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE indicador favorito_indicador TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE objetivo favorito_objetivo TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE fator favorito_fator TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE estrategia favorito_estrategia TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE checklist favorito_checklist TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE plano_acao favorito_acao TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE meta favorito_meta TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE brainstorm favorito_brainstorm TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE causa_efeito favorito_causa_efeito TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE gut favorito_gut TINYINT(1) DEFAULT 0;
ALTER TABLE favoritos CHANGE me favorito_me TINYINT(1) DEFAULT 0;

ALTER TABLE favoritos CHANGE descricao favorito_descricao VARCHAR(255) DEFAULT NULL;
ALTER TABLE favoritos CHANGE protegido favorito_protegido TINYINT(1) DEFAULT 0;

ALTER TABLE favoritos DROP FOREIGN KEY favoritos_fk;
ALTER TABLE favoritos DROP FOREIGN KEY favoritos_fk1;
ALTER TABLE favoritos DROP KEY unidade_id;
ALTER TABLE favoritos DROP KEY criador_id;
ALTER TABLE favoritos CHANGE unidade_id favorito_cia INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE favoritos CHANGE criador_id favorito_usuario INTEGER(100) UNSIGNED DEFAULT NULL;

RENAME TABLE favoritos TO favorito;

ALTER TABLE favorito ADD KEY favorito_cia (favorito_cia);
ALTER TABLE favorito ADD KEY favorito_usuario (favorito_usuario);
ALTER TABLE favorito ADD CONSTRAINT favorito_cia FOREIGN KEY (favorito_cia) REFERENCES cias (cia_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE favorito ADD CONSTRAINT favorito_usuario FOREIGN KEY (favorito_usuario) REFERENCES usuarios (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE favorito ADD COLUMN favorito_tarefa TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_perspectiva TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_tema TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_canvas TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_risco TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_risco_resposta TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_calendario TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_monitoramento TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_ata TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_mswot TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_swot TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_operativo TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_instrumento TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_recurso TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_problema TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_demanda TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_programa TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_licao TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_evento TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_link TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_avaliacao TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_tgn TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_arquivo TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_forum TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_agenda  TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_agrupamento TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_patrocinador TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_template TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_painel TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_painel_odometro TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_painel_composicao TINYINT(1) DEFAULT 0;
ALTER TABLE favorito ADD COLUMN favorito_tr TINYINT(1) DEFAULT 0;

ALTER TABLE favorito_lista ADD KEY favorito_lista_favorito (favorito_lista_favorito);
ALTER TABLE favorito_lista ADD KEY favorito_lista_campo (favorito_lista_campo);
ALTER TABLE favorito_lista ADD CONSTRAINT favorito_lista_favorito FOREIGN KEY (favorito_lista_favorito) REFERENCES favorito (favorito_id) ON DELETE CASCADE ON UPDATE CASCADE;