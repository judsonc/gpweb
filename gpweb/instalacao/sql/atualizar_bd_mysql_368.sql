SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.60';
UPDATE versao SET ultima_atualizacao_bd='2016-08-14';
UPDATE versao SET ultima_atualizacao_codigo='2016-08-14';
UPDATE versao SET versao_bd=368;

DROP TABLE IF EXISTS moeda;

CREATE TABLE moeda (
  moeda_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  moeda_nome VARCHAR(255) DEFAULT NULL,
  moeda_simbolo VARCHAR(5) DEFAULT NULL,
  moeda_ativo VARCHAR(5) DEFAULT NULL,
  PRIMARY KEY (moeda_id)
 )ENGINE=InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;
 
 
DROP TABLE IF EXISTS moeda_cotacao;

CREATE TABLE moeda_cotacao (
  moeda_cotacao_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT,
 	moeda_cotacao_moeda INTEGER(100) UNSIGNED DEFAULT NULL,
 	moeda_cotacao_cotacao DECIMAL(6,5) UNSIGNED DEFAULT NULL,
  moeda_cotacao_data DATE DEFAULT NULL, 
  PRIMARY KEY (moeda_cotacao_id),
  KEY moeda_cotacao_moeda (moeda_cotacao_moeda),
  KEY moeda_cotacao_data (moeda_cotacao_data),
  CONSTRAINT moeda_cotacao_moeda FOREIGN KEY (moeda_cotacao_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE
 )ENGINE=InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci; 
 

ALTER TABLE plano_acao_item_custos ADD COLUMN plano_acao_item_custos_moeda INTEGER(100) UNSIGNED DEFAULT 1;  
ALTER TABLE plano_acao_item_custos ADD COLUMN plano_acao_item_custos_cotacao DECIMAL(6,5) UNSIGNED DEFAULT 1.00000; 
ALTER TABLE plano_acao_item_custos ADD COLUMN plano_acao_item_custos_data_moeda DATE DEFAULT NULL; 
ALTER TABLE plano_acao_item_custos ADD KEY plano_acao_item_custos_moeda (plano_acao_item_custos_moeda);
ALTER TABLE plano_acao_item_custos ADD CONSTRAINT plano_acao_item_custos_moeda FOREIGN KEY (plano_acao_item_custos_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE;  
 
ALTER TABLE plano_acao_item_gastos ADD COLUMN plano_acao_item_gastos_moeda INTEGER(100) UNSIGNED DEFAULT 1;  
ALTER TABLE plano_acao_item_gastos ADD COLUMN plano_acao_item_gastos_cotacao DECIMAL(6,5) UNSIGNED DEFAULT 1.00000; 
ALTER TABLE plano_acao_item_gastos ADD COLUMN plano_acao_item_gastos_data_moeda DATE DEFAULT NULL; 
ALTER TABLE plano_acao_item_gastos ADD KEY plano_acao_item_gastos_moeda (plano_acao_item_gastos_moeda);
ALTER TABLE plano_acao_item_gastos ADD CONSTRAINT plano_acao_item_gastos_moeda FOREIGN KEY (plano_acao_item_gastos_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE plano_acao ADD COLUMN plano_acao_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE plano_acao ADD KEY plano_acao_moeda (plano_acao_moeda);
ALTER TABLE plano_acao ADD CONSTRAINT plano_acao_moeda FOREIGN KEY (plano_acao_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE canvas ADD COLUMN canvas_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE canvas ADD KEY canvas_moeda (canvas_moeda);
ALTER TABLE canvas ADD CONSTRAINT canvas_moeda FOREIGN KEY (canvas_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE tr ADD COLUMN tr_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE tr ADD KEY tr_moeda (tr_moeda);
ALTER TABLE tr ADD CONSTRAINT tr_moeda FOREIGN KEY (tr_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE projetos ADD COLUMN projeto_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE projetos ADD KEY projeto_moeda (projeto_moeda);
ALTER TABLE projetos ADD CONSTRAINT projeto_moeda FOREIGN KEY (projeto_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE;
  
ALTER TABLE demandas ADD COLUMN demanda_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE demandas ADD KEY demanda_moeda (demanda_moeda);
ALTER TABLE demandas ADD CONSTRAINT demanda_moeda FOREIGN KEY (demanda_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE;  
  
ALTER TABLE baseline_projetos ADD COLUMN projeto_moeda INTEGER(100) UNSIGNED DEFAULT 1;  
    
ALTER TABLE tarefa_custos ADD COLUMN tarefa_custos_moeda INTEGER(100) UNSIGNED DEFAULT 1;  
ALTER TABLE tarefa_custos ADD COLUMN tarefa_custos_cotacao DECIMAL(6,5) UNSIGNED DEFAULT 1.00000; 
ALTER TABLE tarefa_custos ADD COLUMN tarefa_custos_data_moeda DATE DEFAULT NULL; 
ALTER TABLE tarefa_custos ADD KEY tarefa_custos_moeda (tarefa_custos_moeda);
ALTER TABLE tarefa_custos ADD CONSTRAINT tarefa_custos_moeda FOREIGN KEY (tarefa_custos_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE baseline_tarefa_custos ADD COLUMN tarefa_custos_moeda INTEGER(100) UNSIGNED DEFAULT 1;  
ALTER TABLE baseline_tarefa_custos ADD COLUMN tarefa_custos_cotacao DECIMAL(6,5) UNSIGNED DEFAULT 1.00000; 
ALTER TABLE baseline_tarefa_custos ADD COLUMN tarefa_custos_data_moeda DATE DEFAULT NULL; 

ALTER TABLE tarefa_gastos ADD COLUMN tarefa_gastos_moeda INTEGER(100) UNSIGNED DEFAULT 1;  
ALTER TABLE tarefa_gastos ADD COLUMN tarefa_gastos_cotacao DECIMAL(6,5) UNSIGNED DEFAULT 1.00000; 
ALTER TABLE tarefa_gastos ADD COLUMN tarefa_gastos_data_moeda DATE DEFAULT NULL; 
ALTER TABLE tarefa_gastos ADD KEY tarefa_gastos_moeda (tarefa_gastos_moeda);
ALTER TABLE tarefa_gastos ADD CONSTRAINT tarefa_gastos_moeda FOREIGN KEY (tarefa_gastos_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE baseline_tarefa_gastos ADD COLUMN tarefa_gastos_moeda INTEGER(100) UNSIGNED DEFAULT 1;  
ALTER TABLE baseline_tarefa_gastos ADD COLUMN tarefa_gastos_cotacao DECIMAL(6,5) UNSIGNED DEFAULT 1.00000; 
ALTER TABLE baseline_tarefa_gastos ADD COLUMN tarefa_gastos_data_moeda DATE DEFAULT NULL;  
 
ALTER TABLE custo ADD COLUMN custo_moeda INTEGER(100) UNSIGNED DEFAULT 1;  
ALTER TABLE custo ADD COLUMN custo_cotacao DECIMAL(6,5) UNSIGNED DEFAULT 1.00000; 
ALTER TABLE custo ADD COLUMN custo_data_moeda DATE DEFAULT NULL; 
ALTER TABLE custo ADD KEY custo_moeda (custo_moeda);
ALTER TABLE custo ADD CONSTRAINT custo_moeda FOREIGN KEY (custo_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 
 
 
INSERT INTO moeda (moeda_id, moeda_nome, moeda_simbolo, moeda_ativo) VALUES
	(1,'Real','R$',1),
	(2,'Dolar Americano','US$',1);

INSERT INTO moeda_cotacao (moeda_cotacao_moeda, moeda_cotacao_data, moeda_cotacao_cotacao) VALUES
	(2,'2014-01-02',2.3913),
	(2,'2014-01-03',2.3739),
	(2,'2014-01-06',2.3767),
	(2,'2014-01-07',2.3785),
	(2,'2014-01-08',2.3897),
	(2,'2014-01-09',2.3975),
	(2,'2014-01-10',2.365),
	(2,'2014-01-13',2.3509),
	(2,'2014-01-14',2.3561),
	(2,'2014-01-15',2.3574),
	(2,'2014-01-16',2.3657),
	(2,'2014-01-17',2.3462),
	(2,'2014-01-20',2.3383),
	(2,'2014-01-21',2.3615),
	(2,'2014-01-22',2.3725),
	(2,'2014-01-23',2.4026),
	(2,'2014-01-24',2.398),
	(2,'2014-01-27',2.426),
	(2,'2014-01-28',2.4265),
	(2,'2014-01-29',2.4338),
	(2,'2014-01-30',2.4147),
	(2,'2014-01-31',2.4124),
	(2,'2014-02-03',2.4371),
	(2,'2014-02-04',2.4152),
	(2,'2014-02-05',2.4),
	(2,'2014-02-06',2.3832),
	(2,'2014-02-07',2.3793),
	(2,'2014-02-10',2.406),
	(2,'2014-02-11',2.4025),
	(2,'2014-02-12',2.4225),
	(2,'2014-02-13',2.4065),
	(2,'2014-02-14',2.3865),
	(2,'2014-02-17',2.3887),
	(2,'2014-02-18',2.3975),
	(2,'2014-02-19',2.3904),
	(2,'2014-02-20',2.3727),
	(2,'2014-02-21',2.3534),
	(2,'2014-02-24',2.3475),
	(2,'2014-02-25',2.341),
	(2,'2014-02-26',2.3524),
	(2,'2014-02-27',2.3245),
	(2,'2014-02-28',2.345),
	(2,'2014-03-05',2.3197),
	(2,'2014-03-06',2.3212),
	(2,'2014-03-07',2.348),
	(2,'2014-03-10',2.3529),
	(2,'2014-03-11',2.3675),
	(2,'2014-03-12',2.3592),
	(2,'2014-03-13',2.3615),
	(2,'2014-03-14',2.3516),
	(2,'2014-03-17',2.3499),
	(2,'2014-03-18',2.342),
	(2,'2014-03-19',2.349),
	(2,'2014-03-20',2.3267),
	(2,'2014-03-21',2.3265),
	(2,'2014-03-24',2.3225),
	(2,'2014-03-25',2.3062),
	(2,'2014-03-26',2.3084),
	(2,'2014-03-27',2.268),
	(2,'2014-03-28',2.2594),
	(2,'2014-03-31',2.2694),
	(2,'2014-04-01',2.2635),
	(2,'2014-04-02',2.2703),
	(2,'2014-04-03',2.2825),
	(2,'2014-04-04',2.2437),
	(2,'2014-04-07',2.22),
	(2,'2014-04-08',2.203),
	(2,'2014-04-09',2.1975),
	(2,'2014-04-10',2.204),
	(2,'2014-04-11',2.2213),
	(2,'2014-04-14',2.2147),
	(2,'2014-04-15',2.2385),
	(2,'2014-04-16',2.2418),
	(2,'2014-04-17',2.2357),
	(2,'2014-04-22',2.2418),
	(2,'2014-04-23',2.2261),
	(2,'2014-04-24',2.2158),
	(2,'2014-04-25',2.2428),
	(2,'2014-04-28',2.2254),
	(2,'2014-04-29',2.2331),
	(2,'2014-04-30',2.23),
	(2,'2014-05-02',2.2193),
	(2,'2014-05-05',2.2468),
	(2,'2014-05-06',2.2291),
	(2,'2014-05-07',2.2181),
	(2,'2014-05-08',2.2144),
	(2,'2014-05-09',2.2154),
	(2,'2014-05-12',2.2156),
	(2,'2014-05-13',2.215),
	(2,'2014-05-14',2.2083),
	(2,'2014-05-15',2.2208),
	(2,'2014-05-16',2.2135),
	(2,'2014-05-19',2.2088),
	(2,'2014-05-20',2.217),
	(2,'2014-05-21',2.2105),
	(2,'2014-05-22',2.2157),
	(2,'2014-05-23',2.224),
	(2,'2014-05-26',2.224),
	(2,'2014-05-27',2.2407),
	(2,'2014-05-28',2.2355),
	(2,'2014-05-29',2.224),
	(2,'2014-05-30',2.2408),
	(2,'2014-06-02',2.2755),
	(2,'2014-06-03',2.2782),
	(2,'2014-06-04',2.2836),
	(2,'2014-06-05',2.2608),
	(2,'2014-06-06',2.2496),
	(2,'2014-06-09',2.231),
	(2,'2014-06-10',2.2281),
	(2,'2014-06-11',2.234),
	(2,'2014-06-12',2.233),
	(2,'2014-06-13',2.2301),
	(2,'2014-06-16',2.2377),
	(2,'2014-06-17',2.257),
	(2,'2014-06-18',2.23),
	(2,'2014-06-20',2.2313),
	(2,'2014-06-23',2.2178),
	(2,'2014-06-24',2.2267),
	(2,'2014-06-25',2.206),
	(2,'2014-06-26',2.1963),
	(2,'2014-06-27',2.1954),
	(2,'2014-06-30',2.21),
	(2,'2014-07-01',2.205),
	(2,'2014-07-02',2.2243),
	(2,'2014-07-03',2.2116),
	(2,'2014-07-04',2.2155),
	(2,'2014-07-07',2.224),
	(2,'2014-07-08',2.2146),
	(2,'2014-07-09',2.217),
	(2,'2014-07-10',2.2224),
	(2,'2014-07-11',2.2215),
	(2,'2014-07-14',2.2115),
	(2,'2014-07-15',2.2211),
	(2,'2014-07-16',2.2223),
	(2,'2014-07-17',2.2588),
	(2,'2014-07-18',2.2283),
	(2,'2014-07-21',2.2239),
	(2,'2014-07-22',2.2118),
	(2,'2014-07-23',2.2205),
	(2,'2014-07-24',2.2213),
	(2,'2014-07-25',2.2275),
	(2,'2014-07-28',2.2235),
	(2,'2014-07-29',2.2311),
	(2,'2014-07-30',2.2427),
	(2,'2014-07-31',2.2699),
	(2,'2014-08-01',2.2605),
	(2,'2014-08-04',2.2625),
	(2,'2014-08-05',2.2827),
	(2,'2014-08-06',2.2736),
	(2,'2014-08-07',2.2959),
	(2,'2014-08-08',2.2869),
	(2,'2014-08-11',2.2745),
	(2,'2014-08-12',2.2785),
	(2,'2014-08-13',2.2787),
	(2,'2014-08-14',2.2695),
	(2,'2014-08-15',2.264),
	(2,'2014-08-18',2.2586),
	(2,'2014-08-19',2.2502),
	(2,'2014-08-20',2.2631),
	(2,'2014-08-21',2.2683),
	(2,'2014-08-22',2.2804),
	(2,'2014-08-25',2.2905),
	(2,'2014-08-26',2.2642),
	(2,'2014-08-27',2.2456),
	(2,'2014-08-28',2.2393),
	(2,'2014-08-29',2.239),
	(2,'2014-09-01',2.2448),
	(2,'2014-09-02',2.2405),
	(2,'2014-09-03',2.2362),
	(2,'2014-09-04',2.2434),
	(2,'2014-09-05',2.2396),
	(2,'2014-09-08',2.2655),
	(2,'2014-09-09',2.2862),
	(2,'2014-09-10',2.2912),
	(2,'2014-09-11',2.2972),
	(2,'2014-09-12',2.3351),
	(2,'2014-09-15',2.3439),
	(2,'2014-09-16',2.3286),
	(2,'2014-09-17',2.3576),
	(2,'2014-09-18',2.365),
	(2,'2014-09-19',2.3727),
	(2,'2014-09-22',2.3944),
	(2,'2014-09-23',2.407),
	(2,'2014-09-24',2.3835),
	(2,'2014-09-25',2.4299),
	(2,'2014-09-26',2.416),
	(2,'2014-09-29',2.4557),
	(2,'2014-09-30',2.448),
	(2,'2014-10-01',2.4848),
	(2,'2014-10-02',2.4918),
	(2,'2014-10-03',2.4618),
	(2,'2014-10-06',2.4266),
	(2,'2014-10-07',2.4023),
	(2,'2014-10-08',2.386),
	(2,'2014-10-09',2.3979),
	(2,'2014-10-10',2.4236),
	(2,'2014-10-13',2.3927),
	(2,'2014-10-14',2.4005),
	(2,'2014-10-15',2.4575),
	(2,'2014-10-16',2.4645),
	(2,'2014-10-17',2.4325),
	(2,'2014-10-20',2.4637),
	(2,'2014-10-21',2.4766),
	(2,'2014-10-22',2.4802),
	(2,'2014-10-23',2.5137),
	(2,'2014-10-24',2.457),
	(2,'2014-10-27',2.5229),
	(2,'2014-10-28',2.474),
	(2,'2014-10-29',2.4684),
	(2,'2014-10-30',2.4079),
	(2,'2014-10-31',2.4787),
	(2,'2014-11-03',2.5005),
	(2,'2014-11-04',2.5054),
	(2,'2014-11-05',2.5149),
	(2,'2014-11-06',2.5607),
	(2,'2014-11-07',2.5634),
	(2,'2014-11-10',2.5493),
	(2,'2014-11-11',2.5577),
	(2,'2014-11-12',2.5641),
	(2,'2014-11-13',2.5948),
	(2,'2014-11-14',2.6007),
	(2,'2014-11-17',2.6013),
	(2,'2014-11-18',2.5903),
	(2,'2014-11-19',2.5757),
	(2,'2014-11-20',2.5743),
	(2,'2014-11-21',2.5216),
	(2,'2014-11-24',2.5488),
	(2,'2014-11-25',2.5367),
	(2,'2014-11-26',2.507),
	(2,'2014-11-27',2.5295),
	(2,'2014-11-28',2.5716),
	(2,'2014-12-01',2.5586),
	(2,'2014-12-02',2.5757),
	(2,'2014-12-03',2.5567),
	(2,'2014-12-04',2.5898),
	(2,'2014-12-05',2.5933),
	(2,'2014-12-08',2.6115),
	(2,'2014-12-09',2.5981),
	(2,'2014-12-10',2.6125),
	(2,'2014-12-11',2.6476),
	(2,'2014-12-12',2.6512),
	(2,'2014-12-15',2.6853),
	(2,'2014-12-16',2.7355),
	(2,'2014-12-17',2.7018),
	(2,'2014-12-18',2.655),
	(2,'2014-12-19',2.6574),
	(2,'2014-12-22',2.6608),
	(2,'2014-12-23',2.7045),
	(2,'2014-12-24',2.6965),
	(2,'2014-12-26',2.6741),
	(2,'2014-12-29',2.7071),
	(2,'2014-12-30',2.6587),
	(2,'2015-01-02',2.6925),
	(2,'2015-01-05',2.7087),
	(2,'2015-01-06',2.7019),
	(2,'2015-01-07',2.7035),
	(2,'2015-01-08',2.6724),
	(2,'2015-01-09',2.639),
	(2,'2015-01-12',2.6682),
	(2,'2015-01-13',2.6369),
	(2,'2015-01-14',2.6213),
	(2,'2015-01-15',2.6422),
	(2,'2015-01-16',2.6212),
	(2,'2015-01-19',2.656),
	(2,'2015-01-20',2.615),
	(2,'2015-01-21',2.6066),
	(2,'2015-01-22',2.5745),
	(2,'2015-01-23',2.5889),
	(2,'2015-01-26',2.5905),
	(2,'2015-01-27',2.5706),
	(2,'2015-01-28',2.5769),
	(2,'2015-01-29',2.6121),
	(2,'2015-01-30',2.6894),
	(2,'2015-02-02',2.7152),
	(2,'2015-02-03',2.694),
	(2,'2015-02-04',2.742),
	(2,'2015-02-05',2.7415),
	(2,'2015-02-06',2.7782),
	(2,'2015-02-09',2.7774),
	(2,'2015-02-10',2.8364),
	(2,'2015-02-11',2.8742),
	(2,'2015-02-12',2.8209),
	(2,'2015-02-13',2.8313),
	(2,'2015-02-18',2.8422),
	(2,'2015-02-19',2.8657),
	(2,'2015-02-20',2.8788),
	(2,'2015-02-23',2.8792),
	(2,'2015-02-24',2.8334),
	(2,'2015-02-25',2.8681),
	(2,'2015-02-26',2.8852),
	(2,'2015-02-27',2.856),
	(2,'2015-03-02',2.8951),
	(2,'2015-03-03',2.928),
	(2,'2015-03-04',2.9807),
	(2,'2015-03-05',3.0115),
	(2,'2015-03-06',3.0565),
	(2,'2015-03-09',3.1297),
	(2,'2015-03-10',3.104),
	(2,'2015-03-11',3.1278),
	(2,'2015-03-12',3.1615),
	(2,'2015-03-13',3.249),
	(2,'2015-03-16',3.2445),
	(2,'2015-03-17',3.231),
	(2,'2015-03-18',3.2141),
	(2,'2015-03-19',3.2965),
	(2,'2015-03-20',3.2302),
	(2,'2015-03-23',3.1453),
	(2,'2015-03-24',3.1275),
	(2,'2015-03-25',3.2034),
	(2,'2015-03-26',3.1909),
	(2,'2015-03-27',3.2405),
	(2,'2015-03-30',3.2317),
	(2,'2015-03-31',3.1909),
	(2,'2015-04-01',3.1725),
	(2,'2015-04-02',3.1292),
	(2,'2015-04-06',3.1223),
	(2,'2015-04-07',3.1341),
	(2,'2015-04-08',3.0563),
	(2,'2015-04-09',3.0706),
	(2,'2015-04-10',3.0711),
	(2,'2015-04-13',3.1245),
	(2,'2015-04-14',3.063),
	(2,'2015-04-15',3.0343),
	(2,'2015-04-16',3.0167),
	(2,'2015-04-17',3.0414),
	(2,'2015-04-20',3.0273),
	(2,'2015-04-22',3.0083),
	(2,'2015-04-23',2.9816),
	(2,'2015-04-24',2.955),
	(2,'2015-04-27',2.9217),
	(2,'2015-04-28',2.9422),
	(2,'2015-04-29',2.9574),
	(2,'2015-04-30',3.0131),
	(2,'2015-05-04',3.0807),
	(2,'2015-05-05',3.0687),
	(2,'2015-05-06',3.0466),
	(2,'2015-05-07',3.0275),
	(2,'2015-05-08',2.9835),
	(2,'2015-05-11',3.0525),
	(2,'2015-05-12',3.0195),
	(2,'2015-05-13',3.0385),
	(2,'2015-05-14',2.9927),
	(2,'2015-05-15',2.9981),
	(2,'2015-05-18',3.0184),
	(2,'2015-05-19',3.0412),
	(2,'2015-05-20',3.0035),
	(2,'2015-05-21',3.0426),
	(2,'2015-05-22',3.0951),
	(2,'2015-05-25',3.0979),
	(2,'2015-05-26',3.15),
	(2,'2015-05-27',3.1452),
	(2,'2015-05-28',3.1638),
	(2,'2015-05-29',3.1873),
	(2,'2015-06-01',3.1743),
	(2,'2015-06-02',3.1346),
	(2,'2015-06-03',3.1347),
	(2,'2015-06-05',3.1506),
	(2,'2015-06-08',3.1099),
	(2,'2015-06-09',3.101),
	(2,'2015-06-10',3.1147),
	(2,'2015-06-11',3.106),
	(2,'2015-06-12',3.1181),
	(2,'2015-06-15',3.1273),
	(2,'2015-06-16',3.0953),
	(2,'2015-06-17',3.0579),
	(2,'2015-06-18',3.0588),
	(2,'2015-06-19',3.1021),
	(2,'2015-06-22',3.0816),
	(2,'2015-06-23',3.0779),
	(2,'2015-06-24',3.1014),
	(2,'2015-06-25',3.1281),
	(2,'2015-06-26',3.1282),
	(2,'2015-06-29',3.1195),
	(2,'2015-06-30',3.1089),
	(2,'2015-07-01',3.145),
	(2,'2015-07-02',3.096),
	(2,'2015-07-03',3.1393),
	(2,'2015-07-06',3.1421),
	(2,'2015-07-07',3.1825),
	(2,'2015-07-08',3.2338),
	(2,'2015-07-10',3.1612),
	(2,'2015-07-13',3.1308),
	(2,'2015-07-14',3.1385),
	(2,'2015-07-15',3.136),
	(2,'2015-07-16',3.1582),
	(2,'2015-07-17',3.1939),
	(2,'2015-07-20',3.2006),
	(2,'2015-07-21',3.1732),
	(2,'2015-07-22',3.2257),
	(2,'2015-07-23',3.2958),
	(2,'2015-07-24',3.347),
	(2,'2015-07-27',3.364),
	(2,'2015-07-28',3.369),
	(2,'2015-07-29',3.3293),
	(2,'2015-07-30',3.371),
	(2,'2015-07-31',3.4247),
	(2,'2015-08-03',3.4545),
	(2,'2015-08-04',3.4642),
	(2,'2015-08-05',3.489),
	(2,'2015-08-06',3.5374),
	(2,'2015-08-07',3.5081),
	(2,'2015-08-10',3.4429),
	(2,'2015-08-11',3.4978),
	(2,'2015-08-12',3.4744),
	(2,'2015-08-13',3.5137),
	(2,'2015-08-14',3.4831),
	(2,'2015-08-17',3.4823),
	(2,'2015-08-18',3.466),
	(2,'2015-08-19',3.4877),
	(2,'2015-08-20',3.4596),
	(2,'2015-08-21',3.496),
	(2,'2015-08-24',3.5525),
	(2,'2015-08-25',3.6084),
	(2,'2015-08-26',3.6014),
	(2,'2015-08-27',3.5528),
	(2,'2015-08-28',3.5853),
	(2,'2015-08-31',3.6271),
	(2,'2015-09-01',3.688),
	(2,'2015-09-02',3.7598),
	(2,'2015-09-03',3.7598),
	(2,'2015-09-04',3.8605),
	(2,'2015-09-08',3.819),
	(2,'2015-09-09',3.7994),
	(2,'2015-09-10',3.8504),
	(2,'2015-09-11',3.8771),
	(2,'2015-09-14',3.8138),
	(2,'2015-09-15',3.8626),
	(2,'2015-09-16',3.8341),
	(2,'2015-09-17',3.8822),
	(2,'2015-09-18',3.9582),
	(2,'2015-09-21',3.9809),
	(2,'2015-09-22',4.0538),
	(2,'2015-09-23',4.1461),
	(2,'2015-09-24',3.9914),
	(2,'2015-09-25',3.9757),
	(2,'2015-09-28',4.1095),
	(2,'2015-09-29',4.0591),
	(2,'2015-09-30',3.9655),
	(2,'2015-10-01',4.0024),
	(2,'2015-10-02',3.9457),
	(2,'2015-10-05',3.9008),
	(2,'2015-10-06',3.8429),
	(2,'2015-10-07',3.8771),
	(2,'2015-10-08',3.7931),
	(2,'2015-10-09',3.7588),
	(2,'2015-10-13',3.8935),
	(2,'2015-10-14',3.8126),
	(2,'2015-10-15',3.8005),
	(2,'2015-10-16',3.8735),
	(2,'2015-10-19',3.8768),
	(2,'2015-10-20',3.9028),
	(2,'2015-10-21',3.943),
	(2,'2015-10-22',3.9075),
	(2,'2015-10-23',3.8906),
	(2,'2015-10-26',3.9167),
	(2,'2015-10-27',3.8969),
	(2,'2015-10-28',3.9201),
	(2,'2015-10-29',3.8541),
	(2,'2015-10-30',3.8628),
	(2,'2015-11-03',3.7705),
	(2,'2015-11-04',3.7967),
	(2,'2015-11-05',3.7765),
	(2,'2015-11-06',3.7625),
	(2,'2015-11-09',3.7997),
	(2,'2015-11-10',3.7915),
	(2,'2015-11-11',3.7695),
	(2,'2015-11-12',3.7672),
	(2,'2015-11-13',3.8331),
	(2,'2015-11-16',3.8185),
	(2,'2015-11-17',3.817),
	(2,'2015-11-18',3.79),
	(2,'2015-11-19',3.729),
	(2,'2015-11-20',3.697),
	(2,'2015-11-23',3.7353),
	(2,'2015-11-24',3.704),
	(2,'2015-11-25',3.7506),
	(2,'2015-11-26',3.7465),
	(2,'2015-11-27',3.8234),
	(2,'2015-11-30',3.8865),
	(2,'2015-12-01',3.8549),
	(2,'2015-12-02',3.8355),
	(2,'2015-12-03',3.7488),
	(2,'2015-12-04',3.739),
	(2,'2015-12-07',3.7589),
	(2,'2015-12-08',3.81),
	(2,'2015-12-09',3.737),
	(2,'2015-12-10',3.8005),
	(2,'2015-12-11',3.8738),
	(2,'2015-12-14',3.8862),
	(2,'2015-12-15',3.8765),
	(2,'2015-12-16',3.9247),
	(2,'2015-12-17',3.8893),
	(2,'2015-12-18',3.9468),
	(2,'2015-12-21',4.0228),
	(2,'2015-12-22',3.9885),
	(2,'2015-12-23',3.9523),
	(2,'2015-12-24',3.9428),
	(2,'2015-12-28',3.86),
	(2,'2015-12-29',3.8769),
	(2,'2015-12-30',3.948),
	(2,'2016-01-04',4.0339),
	(2,'2016-01-05',3.9933),
	(2,'2016-01-06',4.0214),
	(2,'2016-01-07',4.0525),
	(2,'2016-01-08',4.0403),
	(2,'2016-01-11',4.0517),
	(2,'2016-01-12',4.0452),
	(2,'2016-01-13',4.0109),
	(2,'2016-01-14',3.9983),
	(2,'2016-01-15',4.0458),
	(2,'2016-01-18',4.0342),
	(2,'2016-01-19',4.0549),
	(2,'2016-01-20',4.105),
	(2,'2016-01-21',4.1655),
	(2,'2016-01-22',4.1105),
	(2,'2016-01-25',4.102),
	(2,'2016-01-26',4.07),
	(2,'2016-01-27',4.0859),
	(2,'2016-01-28',4.08),
	(2,'2016-01-29',4.0243),
	(2,'2016-02-01',3.9591),
	(2,'2016-02-02',3.986),
	(2,'2016-02-03',3.9181),
	(2,'2016-02-04',3.8941),
	(2,'2016-02-05',3.91),
	(2,'2016-02-10',3.9355),
	(2,'2016-02-11',3.9837),
	(2,'2016-02-12',3.9895),
	(2,'2016-02-15',3.9963),
	(2,'2016-02-16',4.0705),
	(2,'2016-02-17',3.994),
	(2,'2016-02-18',4.049),
	(2,'2016-02-19',4.0227),
	(2,'2016-02-22',3.95),
	(2,'2016-02-23',3.9627),
	(2,'2016-02-24',3.9568),
	(2,'2016-02-25',3.95),
	(2,'2016-02-26',3.9976),
	(2,'2016-02-29',4.0035),
	(2,'2016-03-01',3.9411),
	(2,'2016-03-02',3.8877),
	(2,'2016-03-03',3.8022),
	(2,'2016-03-04',3.7607),
	(2,'2016-03-07',3.7937),
	(2,'2016-03-08',3.7389),
	(2,'2016-03-09',3.697),
	(2,'2016-03-10',3.6414),
	(2,'2016-03-11',3.591),
	(2,'2016-03-14',3.6524),
	(2,'2016-03-15',3.763),
	(2,'2016-03-16',3.7391),
	(2,'2016-03-17',3.6533),
	(2,'2016-03-18',3.5817),
	(2,'2016-03-21',3.6103),
	(2,'2016-03-22',3.6008),
	(2,'2016-03-23',3.6768),
	(2,'2016-03-24',3.6812),
	(2,'2016-03-28',3.6257),
	(2,'2016-03-29',3.6379),
	(2,'2016-03-30',3.6209),
	(2,'2016-03-31',3.5963),
	(2,'2016-04-01',3.5627),
	(2,'2016-04-04',3.6138),
	(2,'2016-04-05',3.681),
	(2,'2016-04-06',3.6453),
	(2,'2016-04-07',3.6937),
	(2,'2016-04-08',3.5965),
	(2,'2016-04-11',3.4946),
	(2,'2016-04-12',3.4948),
	(2,'2016-04-13',3.4795),
	(2,'2016-04-14',3.476),
	(2,'2016-04-15',3.524),
	(2,'2016-04-18',3.5972),
	(2,'2016-04-19',3.5283),
	(2,'2016-04-20',3.5325),
	(2,'2016-04-22',3.5703),
	(2,'2016-04-25',3.5485),
	(2,'2016-04-26',3.5191),
	(2,'2016-04-27',3.5243),
	(2,'2016-04-28',3.4976),
	(2,'2016-04-29',3.4401),
	(2,'2016-05-02',3.49),
	(2,'2016-05-03',3.5712),
	(2,'2016-05-04',3.54),
	(2,'2016-05-05',3.5398),
	(2,'2016-05-06',3.503),
	(2,'2016-05-09',3.5249),
	(2,'2016-05-10',3.4666),
	(2,'2016-05-11',3.4456),
	(2,'2016-05-12',3.4727),
	(2,'2016-05-13',3.5236),
	(2,'2016-05-16',3.5042),
	(2,'2016-05-17',3.4915),
	(2,'2016-05-18',3.5629),
	(2,'2016-05-19',3.5702),
	(2,'2016-05-20',3.5182),
	(2,'2016-05-23',3.5823),
	(2,'2016-05-24',3.5755),
	(2,'2016-05-25',3.5974),
	(2,'2016-05-27',3.611),
	(2,'2016-05-30',3.5779),
	(2,'2016-05-31',3.6123),
	(2,'2016-06-01',3.5879),
	(2,'2016-06-02',3.5875),
	(2,'2016-06-03',3.5249),
	(2,'2016-06-06',3.4905),
	(2,'2016-06-07',3.4486),
	(2,'2016-06-08',3.3697),
	(2,'2016-06-09',3.4035),
	(2,'2016-06-10',3.431),
	(2,'2016-06-13',3.4867),
	(2,'2016-06-14',3.48),
	(2,'2016-06-15',3.4665),
	(2,'2016-06-16',3.47),
	(2,'2016-06-17',3.4203),
	(2,'2016-06-20',3.3994),
	(2,'2016-06-21',3.4062),
	(2,'2016-06-22',3.3778),
	(2,'2016-06-23',3.3445),
	(2,'2016-06-24',3.3797),
	(2,'2016-06-27',3.3946),
	(2,'2016-06-28',3.306),
	(2,'2016-06-29',3.237),
	(2,'2016-06-30',3.2133),
	(2,'2016-07-01',3.2328),
	(2,'2016-07-04',3.2649),
	(2,'2016-07-05',3.301),
	(2,'2016-07-06',3.337),
	(2,'2016-07-07',3.3659),
	(2,'2016-07-08',3.2945),
	(2,'2016-07-11',3.31),
	(2,'2016-07-12',3.298),
	(2,'2016-07-13',3.2745),
	(2,'2016-07-14',3.2595),
	(2,'2016-07-15',3.2543),
	(2,'2016-07-18',3.2517),
	(2,'2016-07-19',3.2589),
	(2,'2016-07-20',3.2486),
	(2,'2016-07-21',3.2816),
	(2,'2016-07-22',3.2581),
	(2,'2016-07-25',3.294),
	(2,'2016-07-26',3.2703),
	(2,'2016-07-27',3.271),
	(2,'2016-07-28',3.2965),
	(2,'2016-07-29',3.2429),
	(2,'2016-08-01',3.272),
	(2,'2016-08-02',3.2661),
	(2,'2016-08-03',3.2408),
	(2,'2016-08-04',3.1945),
	(2,'2016-08-05',3.1691),
	(2,'2016-08-08',3.1677),
	(2,'2016-08-09',3.1411),
	(2,'2016-08-10',3.1322),
	(2,'2016-08-11',3.14),
	(2,'2016-08-12',3.185);