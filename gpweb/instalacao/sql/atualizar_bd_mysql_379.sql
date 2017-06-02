SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.61';
UPDATE versao SET ultima_atualizacao_bd='2016-10-05';
UPDATE versao SET ultima_atualizacao_codigo='2016-10-05';
UPDATE versao SET versao_bd=379;

ALTER TABLE brainstorm ADD COLUMN brainstorm_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE causa_efeito ADD COLUMN causa_efeito_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE gut ADD COLUMN gut_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE canvas ADD COLUMN canvas_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE avaliacao ADD COLUMN avaliacao_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE eventos ADD COLUMN evento_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE baseline_eventos ADD COLUMN evento_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE foruns ADD COLUMN forum_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE licao ADD COLUMN licao_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE links ADD COLUMN link_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE mswot ADD COLUMN mswot_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE recursos ADD COLUMN recurso_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE template ADD COLUMN template_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE arquivo ADD COLUMN arquivo_aprovado TINYINT(1) DEFAULT 0;



ALTER TABLE assinatura_atesta ADD COLUMN assinatura_atesta_painel TINYINT(1) DEFAULT 0;
ALTER TABLE assinatura_atesta ADD COLUMN assinatura_atesta_painel_composicao TINYINT(1) DEFAULT 0;
ALTER TABLE assinatura_atesta ADD COLUMN assinatura_atesta_painel_odometro TINYINT(1) DEFAULT 0;

DROP TABLE IF EXISTS baseline_evento_usuarios;

CREATE TABLE baseline_evento_usuarios (
  baseline_id INTEGER(100) UNSIGNED NOT NULL,
  usuario_id INTEGER(100) UNSIGNED NOT NULL,
  evento_id INTEGER(100) UNSIGNED NOT NULL,
  aceito TINYINT(1) DEFAULT 0,
  data DATETIME DEFAULT NULL,
  duracao DECIMAL(20,5) UNSIGNED DEFAULT 0,
  percentual INTEGER(3) UNSIGNED DEFAULT 100,
  PRIMARY KEY (baseline_id, usuario_id, evento_id),
  CONSTRAINT baseline_evento_usuarios FOREIGN KEY (baseline_id) REFERENCES baseline (baseline_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;
