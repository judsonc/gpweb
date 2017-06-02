SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.61';
UPDATE versao SET ultima_atualizacao_bd='2016-09-26';
UPDATE versao SET ultima_atualizacao_codigo='2016-09-26';
UPDATE versao SET versao_bd=378;

ALTER TABLE praticas ADD COLUMN pratica_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE pratica_indicador ADD COLUMN pratica_indicador_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE checklist ADD COLUMN checklist_aprovado TINYINT(1) DEFAULT 0;


