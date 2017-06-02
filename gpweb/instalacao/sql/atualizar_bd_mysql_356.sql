SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.57';
UPDATE versao SET ultima_atualizacao_bd='2016-06-17';
UPDATE versao SET ultima_atualizacao_codigo='2016-06-17';
UPDATE versao SET versao_bd=356;

INSERT INTO artefato_campo (artefato_campo_arquivo, artefato_campo_campo, artefato_campo_descricao) VALUES
	('ata_reuniao_pro.html','ata_titulo','título da ata');