SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.58';
UPDATE versao SET ultima_atualizacao_bd='2016-07-13';
UPDATE versao SET ultima_atualizacao_codigo='2016-07-13';
UPDATE versao SET versao_bd=362;

ALTER TABLE baseline_eventos ADD COLUMN evento_principal_indicador INTEGER(100) UNSIGNED DEFAULT NULL;