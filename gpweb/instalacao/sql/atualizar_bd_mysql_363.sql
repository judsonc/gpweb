SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.59';
UPDATE versao SET ultima_atualizacao_bd='2016-07-20';
UPDATE versao SET ultima_atualizacao_codigo='2016-07-20';
UPDATE versao SET versao_bd=363;

ALTER TABLE tr_config DROP COLUMN tr_config_trava_aprovacao;
ALTER TABLE demanda_config DROP COLUMN demanda_config_trava_aprovacao ;
ALTER TABLE ata_config DROP COLUMN ata_config_trava_aprovacao ;
ALTER TABLE demanda_config DROP COLUMN demanda_config_trava_edicao;