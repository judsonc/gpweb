SET FOREIGN_KEY_CHECKS=0;
UPDATE versao SET versao_codigo='8.2.1'; 
UPDATE versao SET ultima_atualizacao_bd='2013-01-27'; 
UPDATE versao SET ultima_atualizacao_codigo='2013-01-27'; 
UPDATE versao SET versao_bd=144;

ALTER TABLE arquivos ADD COLUMN arquivo_calendario INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE arquivos ADD KEY arquivo_calendario (arquivo_calendario);
ALTER TABLE arquivos ADD CONSTRAINT arquivo_fk14 FOREIGN KEY (arquivo_calendario) REFERENCES calendario (calendario_id) ON DELETE CASCADE ON UPDATE CASCADE;





DROP TABLE IF EXISTS jornada;

CREATE TABLE jornada (
  jornada_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  jornada_nome VARCHAR(255) DEFAULT NULL,
  jornada_1_inicio TIME DEFAULT NULL,
  jornada_1_almoco_inicio TIME DEFAULT NULL,
  jornada_1_almoco_fim TIME DEFAULT NULL,
  jornada_1_fim TIME DEFAULT NULL,
  jornada_1_duracao DECIMAL(20,3) UNSIGNED DEFAULT 0,
  jornada_2_inicio TIME DEFAULT NULL,
  jornada_2_almoco_inicio TIME DEFAULT NULL,
  jornada_2_almoco_fim TIME DEFAULT NULL,
  jornada_2_fim TIME DEFAULT NULL,
  jornada_2_duracao DECIMAL(20,3) UNSIGNED DEFAULT 0,
  jornada_3_inicio TIME DEFAULT NULL,
  jornada_3_almoco_inicio TIME DEFAULT NULL,
  jornada_3_almoco_fim TIME DEFAULT NULL,
  jornada_3_fim TIME DEFAULT NULL,
  jornada_3_duracao DECIMAL(20,3) UNSIGNED DEFAULT 0,
  jornada_4_inicio TIME DEFAULT NULL,
  jornada_4_almoco_inicio TIME DEFAULT NULL,
  jornada_4_almoco_fim TIME DEFAULT NULL,
  jornada_4_fim TIME DEFAULT NULL,
  jornada_4_duracao DECIMAL(20,3) UNSIGNED DEFAULT 0,
  jornada_5_inicio TIME DEFAULT NULL,
  jornada_5_almoco_inicio TIME DEFAULT NULL,
  jornada_5_almoco_fim TIME DEFAULT NULL,
  jornada_5_fim TIME DEFAULT NULL,
  jornada_5_duracao DECIMAL(20,3) UNSIGNED DEFAULT 0,
  jornada_6_inicio TIME DEFAULT NULL,
  jornada_6_almoco_inicio TIME DEFAULT NULL,
  jornada_6_almoco_fim TIME DEFAULT NULL,
  jornada_6_fim TIME DEFAULT NULL,
  jornada_6_duracao DECIMAL(20,3) UNSIGNED DEFAULT 0,
  jornada_7_inicio TIME DEFAULT NULL,
  jornada_7_almoco_inicio TIME DEFAULT NULL,
  jornada_7_almoco_fim TIME DEFAULT NULL,
  jornada_7_fim TIME DEFAULT NULL,
  jornada_7_duracao DECIMAL(20,3) UNSIGNED DEFAULT 0,
  PRIMARY KEY (jornada_id)
)ENGINE=InnoDB;

DROP TABLE IF EXISTS jornada_excessao;

CREATE TABLE jornada_excessao (
  jornada_excessao_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  jornada_excessao_jornada INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_cia INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_dept INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_usuario INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_recurso INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_projeto INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_tarefa INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_acao INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_tema INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_objetivo INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_fator INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_estrategia INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_pratica INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_meta INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_indicador INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_excessao_inicio TIME DEFAULT NULL,
  jornada_excessao_almoco_inicio TIME DEFAULT NULL,
  jornada_excessao_almoco_fim TIME DEFAULT NULL,
  jornada_excessao_fim TIME DEFAULT NULL,
  jornada_excessao_data DATE DEFAULT NULL,
  jornada_excessao_duracao DECIMAL(20,3) UNSIGNED DEFAULT 0,
  jornada_excessao_trabalha TINYINT(1) DEFAULT '0',
  jornada_excessao_anual TINYINT(1) DEFAULT '0',
  PRIMARY KEY (jornada_excessao_id),
  KEY jornada_excessao_jornada (jornada_excessao_jornada),
  KEY jornada_excessao_cia (jornada_excessao_cia),
  KEY jornada_excessao_dept (jornada_excessao_dept),
  KEY jornada_excessao_usuario (jornada_excessao_usuario),
  KEY jornada_excessao_recurso (jornada_excessao_recurso),
  KEY jornada_excessao_projeto (jornada_excessao_projeto),
  KEY jornada_excessao_tarefa (jornada_excessao_tarefa),
  KEY jornada_excessao_acao (jornada_excessao_acao),
  KEY jornada_excessao_tema (jornada_excessao_tema),
  KEY jornada_excessao_objetivo (jornada_excessao_objetivo),
  KEY jornada_excessao_fator (jornada_excessao_fator),
  KEY jornada_excessao_estrategia (jornada_excessao_estrategia),
  KEY jornada_excessao_pratica (jornada_excessao_pratica),
  KEY jornada_excessao_meta (jornada_excessao_meta),
  KEY jornada_excessao_indicador (jornada_excessao_indicador),
	CONSTRAINT jornada_excessao_fk1 FOREIGN KEY (jornada_excessao_indicador) REFERENCES pratica_indicador (pratica_indicador_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk2 FOREIGN KEY (jornada_excessao_jornada) REFERENCES jornada (jornada_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk3 FOREIGN KEY (jornada_excessao_cia) REFERENCES cias (cia_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk4 FOREIGN KEY (jornada_excessao_dept) REFERENCES depts (dept_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk5 FOREIGN KEY (jornada_excessao_usuario) REFERENCES usuarios (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk6 FOREIGN KEY (jornada_excessao_recurso) REFERENCES recursos (recurso_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk7 FOREIGN KEY (jornada_excessao_projeto) REFERENCES projetos (projeto_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk8 FOREIGN KEY (jornada_excessao_tarefa) REFERENCES tarefas (tarefa_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk9 FOREIGN KEY (jornada_excessao_acao) REFERENCES plano_acao (plano_acao_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk10 FOREIGN KEY (jornada_excessao_tema) REFERENCES tema (tema_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk11 FOREIGN KEY (jornada_excessao_objetivo) REFERENCES objetivos_estrategicos (pg_objetivo_estrategico_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk12 FOREIGN KEY (jornada_excessao_fator) REFERENCES fatores_criticos (pg_fator_critico_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk13 FOREIGN KEY (jornada_excessao_estrategia) REFERENCES estrategias (pg_estrategia_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk14 FOREIGN KEY (jornada_excessao_pratica) REFERENCES praticas (pratica_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_excessao_fk15 FOREIGN KEY (jornada_excessao_meta) REFERENCES metas (pg_meta_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;


CREATE TABLE jornada_pertence (
  jornada_pertence_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  jornada_pertence_jornada INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_cia INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_dept INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_usuario INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_recurso INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_projeto INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_tarefa INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_acao INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_tema INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_objetivo INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_fator INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_estrategia INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_pratica INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_meta INTEGER(100) UNSIGNED DEFAULT NULL,
  jornada_pertence_indicador INTEGER(100) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (jornada_pertence_id),
  KEY jornada_pertence_jornada (jornada_pertence_jornada),
  KEY jornada_pertence_cia (jornada_pertence_cia),
  KEY jornada_pertence_dept (jornada_pertence_dept),
  KEY jornada_pertence_usuario (jornada_pertence_usuario),
  KEY jornada_pertence_recurso (jornada_pertence_recurso),
  KEY jornada_pertence_projeto (jornada_pertence_projeto),
  KEY jornada_pertence_tarefa (jornada_pertence_tarefa),
  KEY jornada_pertence_acao (jornada_pertence_acao),
  KEY jornada_pertence_tema (jornada_pertence_tema),
  KEY jornada_pertence_objetivo (jornada_pertence_objetivo),
  KEY jornada_pertence_fator (jornada_pertence_fator),
  KEY jornada_pertence_estrategia (jornada_pertence_estrategia),
  KEY jornada_pertence_pratica (jornada_pertence_pratica),
  KEY jornada_pertence_meta (jornada_pertence_meta),
  KEY jornada_pertence_indicador (jornada_pertence_indicador),
	CONSTRAINT jornada_pertence_fk1 FOREIGN KEY (jornada_pertence_indicador) REFERENCES pratica_indicador (pratica_indicador_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk2 FOREIGN KEY (jornada_pertence_jornada) REFERENCES jornada (jornada_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk3 FOREIGN KEY (jornada_pertence_cia) REFERENCES cias (cia_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk4 FOREIGN KEY (jornada_pertence_dept) REFERENCES depts (dept_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk5 FOREIGN KEY (jornada_pertence_usuario) REFERENCES usuarios (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk6 FOREIGN KEY (jornada_pertence_recurso) REFERENCES recursos (recurso_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk7 FOREIGN KEY (jornada_pertence_projeto) REFERENCES projetos (projeto_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk8 FOREIGN KEY (jornada_pertence_tarefa) REFERENCES tarefas (tarefa_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk9 FOREIGN KEY (jornada_pertence_acao) REFERENCES plano_acao (plano_acao_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk10 FOREIGN KEY (jornada_pertence_tema) REFERENCES tema (tema_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk11 FOREIGN KEY (jornada_pertence_objetivo) REFERENCES objetivos_estrategicos (pg_objetivo_estrategico_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk12 FOREIGN KEY (jornada_pertence_fator) REFERENCES fatores_criticos (pg_fator_critico_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk13 FOREIGN KEY (jornada_pertence_estrategia) REFERENCES estrategias (pg_estrategia_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk14 FOREIGN KEY (jornada_pertence_pratica) REFERENCES praticas (pratica_id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT jornada_pertence_fk15 FOREIGN KEY (jornada_pertence_meta) REFERENCES metas (pg_meta_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

INSERT INTO jornada (jornada_id, jornada_nome, jornada_1_inicio, jornada_1_almoco_inicio, jornada_1_almoco_fim, jornada_1_fim, jornada_1_duracao, jornada_2_inicio, jornada_2_almoco_inicio, jornada_2_almoco_fim, jornada_2_fim, jornada_2_duracao, jornada_3_inicio, jornada_3_almoco_inicio, jornada_3_almoco_fim, jornada_3_fim, jornada_3_duracao, jornada_4_inicio, jornada_4_almoco_inicio, jornada_4_almoco_fim, jornada_4_fim, jornada_4_duracao, jornada_5_inicio, jornada_5_almoco_inicio, jornada_5_almoco_fim, jornada_5_fim, jornada_5_duracao, jornada_6_inicio, jornada_6_almoco_inicio, jornada_6_almoco_fim, jornada_6_fim, jornada_6_duracao, jornada_7_inicio, jornada_7_almoco_inicio, jornada_7_almoco_fim, jornada_7_fim, jornada_7_duracao) VALUES 
  (1,'Feriados Nacionais','08:00:00','12:00:00','13:00:00','08:00:00',0.000,'08:00:00','12:00:00','13:00:00','17:00:00',8.000,'08:00:00','12:00:00','13:00:00','17:00:00',8.000,'08:00:00','12:00:00','13:00:00','17:00:00',8.000,'08:00:00','12:00:00','13:00:00','17:00:00',8.000,'08:00:00','12:00:00','13:00:00','17:00:00',8.000,'08:00:00','12:00:00','13:00:00','08:00:00',0.000);

INSERT INTO jornada_excessao (jornada_excessao_jornada, jornada_excessao_cia, jornada_excessao_dept, jornada_excessao_usuario, jornada_excessao_recurso, jornada_excessao_projeto, jornada_excessao_tarefa, jornada_excessao_acao, jornada_excessao_tema, jornada_excessao_objetivo, jornada_excessao_fator, jornada_excessao_estrategia, jornada_excessao_pratica, jornada_excessao_meta, jornada_excessao_indicador, jornada_excessao_inicio, jornada_excessao_almoco_inicio, jornada_excessao_almoco_fim, jornada_excessao_fim, jornada_excessao_data, jornada_excessao_trabalha, jornada_excessao_anual) VALUES 
  (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-01-01',0,1),
  (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-03-29',0,1),
  (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-04-21',0,1),
  (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-05-01',0,1),
  (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-09-07',0,1),
  (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-10-12',0,1),
  (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-11-02',0,1),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-11-15',0,1),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-12-25',0,1),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-02-12',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-05-30',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-03-04',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-06-19',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-02-17',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-06-04',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-02-09',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-05-26',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-02-28',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-06-15',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-02-13',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-05-31',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-05',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-06-20',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-02-25',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-11',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-02-16',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-06-03',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-03-01',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2022-06-16',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-02-21',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-06-08',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-02-13',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-05-30',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-03-04',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-06-19',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-17',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-04',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2027-02-09',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2027-05-27',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2028-02-29',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2028-06-15',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2029-02-13',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2029-05-31',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2030-03-05',0,0),
	(1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2030-06-20',0,0);




INSERT INTO config (config_nome, config_valor, config_grupo, config_tipo) VALUES 
	('calendario_padrao','1','calendario','combo_calendario');