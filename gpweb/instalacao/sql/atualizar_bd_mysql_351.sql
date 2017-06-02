SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.56';
UPDATE versao SET ultima_atualizacao_bd='2016-06-06';
UPDATE versao SET ultima_atualizacao_codigo='2016-06-06';
UPDATE versao SET versao_bd=351;

INSERT INTO config (config_nome, config_valor, config_grupo, config_tipo) VALUES 
	('papel_parede','','admin_sistema','text'),
	('papel_parede_login','','admin_sistema','text');


DROP TABLE IF EXISTS mswot;

CREATE TABLE mswot (
  mswot_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  mswot_cia INTEGER(100) UNSIGNED DEFAULT NULL,
  mswot_dept INTEGER(100) UNSIGNED DEFAULT NULL,
  mswot_responsavel INTEGER(100) UNSIGNED DEFAULT NULL,
  mswot_principal_indicador INTEGER(100) UNSIGNED DEFAULT NULL,
  mswot_nome VARCHAR(255),
  mswot_inicio DATE DEFAULT NULL,
  mswot_fim DATE DEFAULT NULL,
  mswot_percentagem DECIMAL(20,3) UNSIGNED DEFAULT 0,
  mswot_oque TEXT,
  mswot_descricao TEXT,
  mswot_onde TEXT,
  mswot_quando TEXT,
  mswot_como TEXT,
  mswot_porque TEXT,
  mswot_quanto TEXT,
  mswot_quem TEXT,
  mswot_controle TEXT,
  mswot_melhorias TEXT,
  mswot_metodo_aprendizado TEXT,
  mswot_desde_quando TEXT,
  mswot_cor VARCHAR(6) DEFAULT 'FFFFFF',
  mswot_ativo TINYINT(1) DEFAULT 1,
  mswot_acesso INTEGER(100) UNSIGNED DEFAULT 0,
  PRIMARY KEY (mswot_id),
  KEY mswot_cia (mswot_cia),
  KEY mswot_dept (mswot_dept),
  KEY mswot_responsavel (mswot_responsavel),
 	KEY mswot_principal_indicador (mswot_principal_indicador),
  CONSTRAINT mswot_cia FOREIGN KEY (mswot_cia) REFERENCES cias (cia_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT mswot_dept FOREIGN KEY (mswot_dept) REFERENCES depts (dept_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT mswot_responsavel FOREIGN KEY (mswot_responsavel) REFERENCES usuarios (usuario_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT mswot_principal_indicador FOREIGN KEY (mswot_principal_indicador) REFERENCES pratica_indicador (pratica_indicador_id) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;


ALTER TABLE tr_atesta ADD COLUMN tr_atesta_mswot TINYINT(1) DEFAULT 0;