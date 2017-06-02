SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.61';
UPDATE versao SET ultima_atualizacao_bd='2016-10-13';
UPDATE versao SET ultima_atualizacao_codigo='2016-10-13';
UPDATE versao SET versao_bd=380;


ALTER TABLE arquivo_historico ADD COLUMN arquivo_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE arquivo_historico ADD KEY arquivo_moeda (arquivo_moeda);
ALTER TABLE arquivo_historico ADD CONSTRAINT arquivo_historico_moeda FOREIGN KEY (arquivo_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 
ALTER TABLE arquivo_historico ADD COLUMN arquivo_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE arquivo_historico ADD COLUMN arquivo_principal_indicador INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE arquivo_historico ADD KEY arquivo_principal_indicador (arquivo_principal_indicador);
ALTER TABLE arquivo_historico ADD CONSTRAINT arquivo_historico_principal_indicador FOREIGN KEY (arquivo_principal_indicador) REFERENCES pratica_indicador (pratica_indicador_id) ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE tarefa_log CHANGE tarefa_log_reg_mudanca_duracao tarefa_log_reg_mudanca_duracao DECIMAL(20,3) UNSIGNED DEFAULT NULL;
ALTER TABLE baseline_tarefa_log CHANGE tarefa_log_reg_mudanca_duracao tarefa_log_reg_mudanca_duracao DECIMAL(20,3) UNSIGNED DEFAULT NULL;