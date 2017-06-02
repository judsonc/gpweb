SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.56';
UPDATE versao SET ultima_atualizacao_bd='2016-06-07';
UPDATE versao SET ultima_atualizacao_codigo='2016-06-07';
UPDATE versao SET versao_bd=354;


ALTER TABLE plano_acao ADD COLUMN plano_acao_duracao DECIMAL(20,3) UNSIGNED DEFAULT NULL;