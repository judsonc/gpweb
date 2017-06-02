SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.58';
UPDATE versao SET ultima_atualizacao_bd='2016-06-28';
UPDATE versao SET ultima_atualizacao_codigo='2016-06-28';
UPDATE versao SET versao_bd=358;

ALTER TABLE tarefa_custos ADD COLUMN tarefa_custos_ptres VARCHAR(100) DEFAULT NULL;
ALTER TABLE baseline_tarefa_custos ADD COLUMN tarefa_custos_ptres VARCHAR(100) DEFAULT NULL;

ALTER TABLE tarefa_gastos ADD COLUMN tarefa_gastos_ptres VARCHAR(100) DEFAULT NULL;
ALTER TABLE baseline_tarefa_gastos ADD COLUMN tarefa_gastos_ptres VARCHAR(100) DEFAULT NULL;