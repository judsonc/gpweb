SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.60';
UPDATE versao SET ultima_atualizacao_bd='2016-09-13';
UPDATE versao SET ultima_atualizacao_codigo='2016-09-13';
UPDATE versao SET versao_bd=375;

ALTER TABLE tr ADD COLUMN tr_informacao_automatica TINYINT(1) DEFAULT 1;
ALTER TABLE tr ADD COLUMN tr_planilha_automatica TINYINT(1) DEFAULT 1;
