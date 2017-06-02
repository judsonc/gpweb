SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.60';
UPDATE versao SET ultima_atualizacao_bd='2016-08-08';
UPDATE versao SET ultima_atualizacao_codigo='2016-08-08';
UPDATE versao SET versao_bd=366;

ALTER TABLE favorito CHANGE favorito_cia favorito_cia INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE favorito ADD COLUMN favorito_dept INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE favorito ADD COLUMN favorito_acesso INTEGER(100) UNSIGNED DEFAULT 1;
ALTER TABLE favorito ADD COLUMN favorito_ativo TINYINT(1) DEFAULT 1;
ALTER TABLE favorito ADD COLUMN favorito_geral TINYINT(1) DEFAULT 0;

ALTER TABLE favorito ADD KEY favorito_dept (favorito_dept);
ALTER TABLE favorito ADD CONSTRAINT favorito_dept FOREIGN KEY (favorito_dept) REFERENCES depts (dept_id) ON DELETE CASCADE ON UPDATE CASCADE;


DROP TABLE IF EXISTS favorito_dept;

CREATE TABLE favorito_dept (
  favorito_dept_favorito INTEGER(100) UNSIGNED NOT NULL,
  favorito_dept_dept INTEGER(100) UNSIGNED NOT NULL,
  PRIMARY KEY (favorito_dept_favorito, favorito_dept_dept),
  KEY favorito_dept_favorito (favorito_dept_favorito),
  KEY favorito_dept_dept (favorito_dept_dept),
  CONSTRAINT favorito_dept_dept FOREIGN KEY (favorito_dept_dept) REFERENCES depts (dept_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT favorito_dept_favorito FOREIGN KEY (favorito_dept_favorito) REFERENCES favorito (favorito_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;


DROP TABLE IF EXISTS favorito_cia;

CREATE TABLE favorito_cia (
  favorito_cia_favorito INTEGER(100) UNSIGNED NOT NULL,
  favorito_cia_cia INTEGER(100) UNSIGNED NOT NULL,
  PRIMARY KEY (favorito_cia_favorito, favorito_cia_cia),
  KEY favorito_cia_favorito (favorito_cia_favorito),
  KEY favorito_cia_cia (favorito_cia_cia),
  CONSTRAINT favorito_cia_cia FOREIGN KEY (favorito_cia_cia) REFERENCES cias (cia_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT favorito_cia_favorito FOREIGN KEY (favorito_cia_favorito) REFERENCES favorito (favorito_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;


DROP TABLE IF EXISTS favorito_usuario;

CREATE TABLE favorito_usuario (
  favorito_usuario_favorito INTEGER(100) UNSIGNED NOT NULL,
  favorito_usuario_usuario INTEGER(100) UNSIGNED NOT NULL,
  KEY favorito_usuario_favorito (favorito_usuario_favorito),
  KEY favorito_usuario_usuario (favorito_usuario_usuario),
  CONSTRAINT favorito_usuario_favorito FOREIGN KEY (favorito_usuario_favorito) REFERENCES favorito (favorito_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT favorito_usuario_usuario FOREIGN KEY (favorito_usuario_usuario) REFERENCES usuarios (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;

DROP TABLE IF EXISTS favorito_trava;

CREATE TABLE favorito_trava (
  favorito_trava_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  favorito_trava_usuario INTEGER(100) UNSIGNED DEFAULT NULL,
  favorito_trava_projeto TINYINT(1) DEFAULT 0,
	favorito_trava_tarefa TINYINT(1) DEFAULT 0,
	favorito_trava_perspectiva TINYINT(1) DEFAULT 0,
	favorito_trava_tema TINYINT(1) DEFAULT 0,
	favorito_trava_objetivo TINYINT(1) DEFAULT 0,
	favorito_trava_fator TINYINT(1) DEFAULT 0,
	favorito_trava_estrategia TINYINT(1) DEFAULT 0,
	favorito_trava_meta TINYINT(1) DEFAULT 0,
	favorito_trava_pratica TINYINT(1) DEFAULT 0,
	favorito_trava_indicador TINYINT(1) DEFAULT 0,
	favorito_trava_acao TINYINT(1) DEFAULT 0,
	favorito_trava_canvas TINYINT(1) DEFAULT 0,
	favorito_trava_risco TINYINT(1) DEFAULT 0,
	favorito_trava_risco_resposta TINYINT(1) DEFAULT 0,
	favorito_trava_calendario TINYINT(1) DEFAULT 0,
	favorito_trava_monitoramento TINYINT(1) DEFAULT 0,
	favorito_trava_ata TINYINT(1) DEFAULT 0,
	favorito_trava_mswot TINYINT(1) DEFAULT 0,
	favorito_trava_swot TINYINT(1) DEFAULT 0,
	favorito_trava_operativo TINYINT(1) DEFAULT 0,
	favorito_trava_instrumento TINYINT(1) DEFAULT 0,
	favorito_trava_recurso TINYINT(1) DEFAULT 0,
	favorito_trava_problema TINYINT(1) DEFAULT 0,
	favorito_trava_demanda TINYINT(1) DEFAULT 0,
	favorito_trava_programa TINYINT(1) DEFAULT 0,
	favorito_trava_licao TINYINT(1) DEFAULT 0,
	favorito_trava_evento TINYINT(1) DEFAULT 0,
	favorito_trava_link TINYINT(1) DEFAULT 0,
	favorito_trava_avaliacao TINYINT(1) DEFAULT 0,
	favorito_trava_tgn TINYINT(1) DEFAULT 0,
	favorito_trava_brainstorm TINYINT(1) DEFAULT 0,
	favorito_trava_gut TINYINT(1) DEFAULT 0,
	favorito_trava_causa_efeito TINYINT(1) DEFAULT 0,
	favorito_trava_arquivo TINYINT(1) DEFAULT 0,
	favorito_trava_forum TINYINT(1) DEFAULT 0,
	favorito_trava_checklist TINYINT(1) DEFAULT 0,
	favorito_trava_agenda  TINYINT(1) DEFAULT 0,
	favorito_trava_agrupamento TINYINT(1) DEFAULT 0,
	favorito_trava_patrocinador TINYINT(1) DEFAULT 0,
	favorito_trava_template TINYINT(1) DEFAULT 0,
	favorito_trava_painel TINYINT(1) DEFAULT 0,
	favorito_trava_painel_odometro TINYINT(1) DEFAULT 0,
	favorito_trava_painel_composicao TINYINT(1) DEFAULT 0,
	favorito_trava_tr TINYINT(1) DEFAULT 0,
	favorito_trava_me TINYINT(1) DEFAULT 0,
	favorito_trava_campo TEXT,
  PRIMARY KEY (favorito_trava_id),
  KEY favorito_trava_usuario (favorito_trava_usuario),
  CONSTRAINT favorito_trava_usuario FOREIGN KEY (favorito_trava_usuario) REFERENCES usuarios (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;