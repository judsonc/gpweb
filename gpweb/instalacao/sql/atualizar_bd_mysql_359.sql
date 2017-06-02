SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.58';
UPDATE versao SET ultima_atualizacao_bd='2016-07-03';
UPDATE versao SET ultima_atualizacao_codigo='2016-07-03';
UPDATE versao SET versao_bd=359;

ALTER TABLE depts CHANGE dept_endereco1 dept_endereco1 VARCHAR(255) DEFAULT NULL;
ALTER TABLE depts CHANGE dept_endereco2 dept_endereco2 VARCHAR(255) DEFAULT NULL;
ALTER TABLE depts CHANGE dept_cidade dept_cidade VARCHAR(255) DEFAULT NULL;
ALTER TABLE depts CHANGE dept_url dept_url VARCHAR(255) DEFAULT NULL;

ALTER TABLE cias CHANGE cia_endereco1 cia_endereco1 VARCHAR(255) DEFAULT NULL;
ALTER TABLE cias CHANGE cia_endereco2 cia_endereco2 VARCHAR(255) DEFAULT NULL;