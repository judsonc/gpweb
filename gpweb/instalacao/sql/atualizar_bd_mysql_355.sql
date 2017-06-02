SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.57';
UPDATE versao SET ultima_atualizacao_bd='2016-06-15';
UPDATE versao SET ultima_atualizacao_codigo='2016-06-15';
UPDATE versao SET versao_bd=355;


INSERT INTO config (config_nome, config_valor, config_grupo, config_tipo) VALUES 
	('siafi','SIAFI','legenda','text'),
	('genero_siafi','o','legenda','select');
	

INSERT INTO config_lista (config_nome, config_lista_nome) VALUES	
	('genero_siafi','a'),
	('genero_siafi','o');