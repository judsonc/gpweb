SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.57';
UPDATE versao SET ultima_atualizacao_bd='2016-06-17';
UPDATE versao SET ultima_atualizacao_codigo='2016-06-17';
UPDATE versao SET versao_bd=357;

ALTER TABLE usuarios ADD COLUMN usuario_frase varchar(255) DEFAULT NULL;
ALTER TABLE usuarios ADD COLUMN usuario_resposta varchar(255) DEFAULT NULL;