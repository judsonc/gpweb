SET FOREIGN_KEY_CHECKS=0;
UPDATE versao SET versao_codigo='8.0.38'; 
UPDATE versao SET ultima_atualizacao_bd='2012-10-14'; 
UPDATE versao SET ultima_atualizacao_codigo='2012-10-14'; 
UPDATE versao SET versao_bd=124; 

INSERT INTO config (config_nome, config_valor, config_grupo, config_tipo) VALUES 
	('login','login','legenda','text');

ALTER TABLE contatos CHANGE contato_nomeguerra contato_nomeguerra VARCHAR(100) DEFAULT NULL;

ALTER TABLE cias ADD COLUMN cia_cnpj VARCHAR(18) DEFAULT NULL;
ALTER TABLE cias ADD COLUMN cia_inscricao_estadual VARCHAR(25) DEFAULT NULL;

CREATE TABLE categoria (
  categoria_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  categoria_nome VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (categoria_id)
)ENGINE=InnoDB;

INSERT INTO categoria (categoria_id, categoria_nome) VALUES
	(1,'Com�rcio'),
	(2,'Organiza��es Industriais'),
	(3,'Organiza��es prestadoras de servi�o'),
	(4,'Organiza��es sociais sem fins lucrativos'),
	(5,'�rg�os da administra��o p�blica Estadual'),
	(6,'�rg�o da administra��o p�blica Federal'),
	(7,'�rg�os da administra��o p�blica Municipal');

CREATE TABLE segmento (
  segmento_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  segmento_categoria INTEGER(100) UNSIGNED DEFAULT NULL,
  segmento_nome VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (segmento_id),
  KEY segmento_categoria (segmento_categoria),
  CONSTRAINT segmento_fk FOREIGN KEY (segmento_categoria) REFERENCES categoria (categoria_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

INSERT INTO segmento (segmento_categoria, segmento_nome) VALUES
	(1,'Com�rcio Varejista de g�neros aliment�cios'),
	(1,'Com�rcio Varejista'),
	(1,'Distribuidores, Revendedores, Com�rcio Atacadista'),
	(2,'Aeron�utica/Aeroespacial'),
	(2,'Alimentos e Bebidas'),
	(2,'B�lica'),
	(2,'Constru��o Civil'),
	(2,'Constru��o Naval'),
	(2,'El�trica'),
	(2,'Eletr�nica'),
	(2,'Gr�fica'),
	(2,'Inform�tica'),
	(2,'M�quinas e Equipamentos'),
	(2,'Material de Constru��o'),
	(2,'Material de Embalagem'),
	(2,'Medicamentos, Higiene, Prod. M�dicos e Odontol�gicos'),
	(2,'Metal�rgica'),
	(2,'Minera��o'),
	(2,'Mobili�rio e Decora��o'),
	(2,'Nuclear'),
	(2,'Outras ind�strias, ou combina��es acima'),
	(2,'Papel e Celulose'),
	(2,'Produtos �tico, Instrumentos'),
	(2,'Produtos e Artefatos de Madeira e Couro'),
	(2,'Produtos e Equipamentos de Cultura, Esporte e Lazer'),
	(2,'Qu�mica, Petroqu�mica, Alcoolqu�mica, Borracha e Pl�stico'),
	(2,'T�xtil'),
	(2,'T�xtil'),
	(2,'Ve�culos, Equipamentos de Transporte e Manuseio'),
	(3,'Administradoras'),
	(3,'Agropecu�rios'),
	(3,'Alimentos e Bebidas'),
	(3,'Arquitetura'),
	(3,'Assessoramento'),
	(3,'Bancos e Institui��es Financeiras'),
	(3,'Com�rcio Exterior'),
	(3,'Comunica��es (R�dio, Jornal, TV, Telecomunica��es)'),
	(3,'Conserva��o e Limpeza'),
	(3,'Constru��o e Montagens'),
	(3,'Consultoria e Engenharia'),
	(3,'Consultoria em Administra��o'),
	(3,'Contabilidade'),
	(3,'Cultura, Esporte e Lazer'),
	(3,'Dentista'),
	(3,'Educa��o'),
	(3,'Eventos'),
	(3,'Farm�cia'),
	(3,'Funda��es, Associa��es, Federa��es, Sindicatos, etc'),
	(3,'Gr�ficas'),
	(3,'Hospitais'),
	(3,'Hot�is e Restaurantes'),
	(3,'Imobili�rias'),
	(3,'Inform�tica'),
	(3,'Jur�dico'),
	(3,'Laborat�rios'),
	(3,'Manuten��o'),
	(3,'Outros ou combina��o dos acima'),
	(3,'P�blicos (g�s, luz, telefone, �gua e esgoto etc.)'),
	(3,'Profissionais'),
	(3,'Publicidade'),
	(3,'Qualidade (Consultoria, Inspe��o, etc.)'),
	(3,'Sa�de'),
	(3,'Seguran�a'),
	(3,'Seguros'),
	(3,'Servi�o Social'),
	(3,'Telefonia'),
	(3,'Transporte, Armazenagem'),
	(3,'Turismo'),
	(3,'Ve�culos'),
	(4,'Assist�ncia Social'),
	(4,'Educa��o'),
	(4,'Meio Ambiente'),
	(4,'Outros'),
	(4,'Sa�de'),
	(5,'Abastecimento'),
	(5,'Administra��o'),
	(5,'Agropecu�ria e Pesca'),
	(5,'Auditoria'),
	(5,'Com�rcio Exterior'),
	(5,'Comunica��es'),
	(5,'Cultura'),
	(5,'Defesa Nacional'),
	(5,'Direito P�blico'),
	(5,'Esporte e Lazer'),
	(5,'Finan�as'),
	(5,'Ind�stria e Com�rcio'),
	(5,'Meio-ambiente'),
	(5,'Minas e Energia'),
	(5,'Ocupa��o Territorial e Reforma Agr�ria'),
	(5,'Pesquisa Cient�fica e Tecnol�gica'),
	(5,'Planejamento e Or�amento'),
	(5,'Previd�ncia e Assist�ncia Social'),
	(5,'Rela��es Exteriores'),
	(5,'Sa�de'),
	(5,'Seguran�a'),
	(5,'Servi�os Tecnol�gicos'),
	(5,'Trabalho'),
	(5,'Transporte'),
	(5,'Turismo'),
	(6,'Abastecimento'),
	(6,'Administra��o'),
	(6,'Agropecu�ria e Pesca'),
	(6,'Auditoria'),
	(6,'Com�rcio Exterior'),
	(6,'Comunica��es'),
	(6,'Cultura'),
	(6,'Defesa Nacional'),
	(6,'Direito P�blico'),
	(6,'Esporte e Lazer'),
	(6,'Finan�as'),
	(6,'Ind�stria e Com�rcio'),
	(6,'Meio-ambiente'),
	(6,'Minas e Energia'),
	(6,'Ocupa��o Territorial e Reforma Agr�ria'),
	(6,'Outros, ou combina��o dos acima'),
	(6,'Pesquisa Cientifica e Tecnol�gica'),
	(6,'Planejamento e Or�amento'),
	(6,'Previd�ncia e Assist�ncia Social'),
	(6,'Rela��es Exteriores'),
	(6,'Sa�de'),
	(6,'Seguran�a'),
	(6,'Servi�os Tecnol�gicos'),
	(6,'Trabalho'),
	(6,'Transporte'),
	(6,'Turismo'),
	(7,'Abastecimento'),
	(7,'Administra��o'),
	(7,'Agropecu�ria e Pesca'),
	(7,'Auditoria'),
	(7,'Com�rcio Exterior'),
	(7,'Comunica��es'),
	(7,'Cultura'),
	(7,'Defesa Nacional '),
	(7,'Direito P�blico'),
	(7,'Escola'),
	(7,'Esporte e Lazer'),
	(7,'Finan�as'),
	(7,'Ind�stria e Com�rcio'),
	(7,'Meio-ambiente'),
	(7,'Minas e Energia'),
	(7,'Ocupa��o Territorial e Reforma Agr�ria'),
	(7,'Outros, ou combina��o dos acima'),
	(7,'Pesquisa Cientifica e Tecnol�gica'),
	(7,'Planejamento e Or�amento'),
	(7,'Prefeitura'),
	(7,'Previd�ncia e Assist�ncia Social'),
	(7,'Rela��es Exteriores'),
	(7,'Sa�de'),
	(7,'Seguran�a'),
	(7,'Servi�os Tecnol�gicos'),
	(7,'Trabalho'),
	(7,'Transporte'),
	(7,'Turismo');



CREATE TABLE cia_segmento (
  cia_segmento_cia INTEGER(100) UNSIGNED DEFAULT NULL,
  cia_segmento_segmento INTEGER(100) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (cia_segmento_cia, cia_segmento_segmento),
  KEY cia_segmento_cia (cia_segmento_cia),
  KEY cia_segmento_segmento (cia_segmento_segmento),
  CONSTRAINT cia_segmentos_fk FOREIGN KEY (cia_segmento_cia) REFERENCES cias (cia_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT cia_segmentos_fk1 FOREIGN KEY (cia_segmento_segmento) REFERENCES segmento (segmento_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;


