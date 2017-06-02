SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.59';
UPDATE versao SET ultima_atualizacao_bd='2016-08-01';
UPDATE versao SET ultima_atualizacao_codigo='2016-08-01';
UPDATE versao SET versao_bd=365;


ALTER TABLE favorito CHANGE favorito_descricao favorito_nome VARCHAR(255) DEFAULT NULL;
