SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.49';
UPDATE versao SET ultima_atualizacao_bd='2016-03-13';
UPDATE versao SET ultima_atualizacao_codigo='2016-03-13';
UPDATE versao SET versao_bd=329;

ALTER TABLE demanda_config ADD COLUMN demanda_config_trava_edicao TINYINT DEFAULT 0;

ALTER TABLE demanda_config ADD COLUMN demanda_config_diretriz_iniciacao VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_diretriz_iniciacao TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_estudo_viabilidade VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_estudo_viabilidade TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_diretriz_implantacao VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_diretriz_implantacao TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_declara��o_escopo VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_declara��o_escopo TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_estrutura_analitica VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_estrutura_analitica TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_dicionario_eap VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_dicionario_eap TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_cronograma_fisico VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_cronograma_fisico TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_plano_projeto VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_plano_projeto TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_cronograma VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_cronograma TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_planejamento_custo VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_planejamento_custo TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_gerenciamento_humanos VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_gerenciamento_humanos TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_gerenciamento_comunicacoes VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_gerenciamento_comunicacoes TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_gerenciamento_partes VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_gerenciamento_partes TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_gerenciamento_riscos VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_gerenciamento_riscos TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_gerenciamento_qualidade VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_gerenciamento_qualidade TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_gerenciamento_mudanca VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_gerenciamento_mudanca TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_controle_mudanca VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_controle_mudanca TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_aceite_produtos VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_aceite_produtos TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_relatorio_situacao VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_relatorio_situacao TINYINT DEFAULT 1;
ALTER TABLE demanda_config ADD COLUMN demanda_config_termo_encerramento VARCHAR(100)DEFAULT NULL;
ALTER TABLE demanda_config ADD COLUMN demanda_config_ativo_termo_encerramento TINYINT DEFAULT 1;

UPDATE demanda_config SET demanda_config_diretriz_iniciacao='Diretriz de Inicia��o';
UPDATE demanda_config SET demanda_config_estudo_viabilidade='Estudo de Viabilidade';
UPDATE demanda_config SET demanda_config_diretriz_implantacao='Diretriz de Implanta��o';
UPDATE demanda_config SET demanda_config_declara��o_escopo='Declara��o de Escopo';
UPDATE demanda_config SET demanda_config_estrutura_analitica='Estrutura Anal�tica';
UPDATE demanda_config SET demanda_config_dicionario_eap='Dicion�rio da EAP';
UPDATE demanda_config SET demanda_config_cronograma_fisico='Cronograma F�sico-Financeiro Inicial';
UPDATE demanda_config SET demanda_config_plano_projeto='Plano do Projeto';
UPDATE demanda_config SET demanda_config_cronograma='Cronograma';
UPDATE demanda_config SET demanda_config_planejamento_custo='Planejamento de Custo e do Or�amento';
UPDATE demanda_config SET demanda_config_gerenciamento_humanos='Gerenciamento de Recursos Humanos';
UPDATE demanda_config SET demanda_config_gerenciamento_comunicacoes='Gerenciamento das Comunica��es';
UPDATE demanda_config SET demanda_config_gerenciamento_partes='Gerenciamento das Partes Interessadas';
UPDATE demanda_config SET demanda_config_gerenciamento_riscos='Gerenciamento de Riscos';
UPDATE demanda_config SET demanda_config_gerenciamento_qualidade='Gerenciamento da Qualidade';
UPDATE demanda_config SET demanda_config_gerenciamento_mudanca='Gerenciamento de Mudan�a';
UPDATE demanda_config SET demanda_config_controle_mudanca='Controle de Mudan�a';
UPDATE demanda_config SET demanda_config_aceite_produtos='Aceite de Produtos/Servi�os';
UPDATE demanda_config SET demanda_config_relatorio_situacao='Relat�rio de Situa��o';
UPDATE demanda_config SET demanda_config_termo_encerramento='Termo de Encerramento';
