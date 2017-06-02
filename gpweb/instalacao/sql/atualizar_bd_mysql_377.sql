SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.61';
UPDATE versao SET ultima_atualizacao_bd='2016-09-22';
UPDATE versao SET ultima_atualizacao_codigo='2016-09-22';
UPDATE versao SET versao_bd=377;

ALTER TABLE perspectivas ADD COLUMN pg_perspectiva_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE tema ADD COLUMN tema_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE objetivo ADD COLUMN objetivo_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE me ADD COLUMN me_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE fator ADD COLUMN fator_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE estrategias ADD COLUMN pg_estrategia_aprovado TINYINT(1) DEFAULT 0;
ALTER TABLE metas ADD COLUMN pg_meta_aprovado TINYINT(1) DEFAULT 0;


ALTER TABLE assinatura_atesta ADD COLUMN assinatura_atesta_me TINYINT(1) DEFAULT 0;


UPDATE campo_formulario SET campo_formulario_descricao='Início previsto' WHERE campo_formulario_tipo='projetos' AND campo_formulario_campo='inicio';
UPDATE campo_formulario SET campo_formulario_descricao='Término previsto' WHERE campo_formulario_tipo='projetos' AND campo_formulario_campo='termino';
UPDATE campo_formulario SET campo_formulario_descricao='Início' WHERE campo_formulario_tipo='projetos' AND campo_formulario_campo='provavel_inicio';
UPDATE campo_formulario SET campo_formulario_descricao='Término' WHERE campo_formulario_tipo='projetos' AND campo_formulario_campo='provavel_termino';