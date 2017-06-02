SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.58';
UPDATE versao SET ultima_atualizacao_bd='2016-07-03';
UPDATE versao SET ultima_atualizacao_codigo='2016-07-03';
UPDATE versao SET versao_bd=360;

ALTER TABLE tr ADD COLUMN tr_acao_orcamentaria VARCHAR(255) DEFAULT NULL;
ALTER TABLE tr ADD COLUMN tr_protocolo VARCHAR(255) DEFAULT NULL;