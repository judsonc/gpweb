SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.60';
UPDATE versao SET ultima_atualizacao_bd='2016-09-11';
UPDATE versao SET ultima_atualizacao_codigo='2016-09-11';
UPDATE versao SET versao_bd=372;

CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos_composicao', 'objetivos_estrategicos_composicao_fk1');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos_composicao', 'objetivos_estrategicos_composicao_fk');
CALL PROC_DROP_KEY('objetivos_estrategicos_composicao', 'objetivo_pai');
CALL PROC_DROP_KEY('objetivos_estrategicos_composicao', 'objetivo_filho');

CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos_depts', 'objetivos_estrategicos_depts_fk');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos_depts', 'objetivos_estrategicos_depts_fk1');
CALL PROC_DROP_KEY('objetivos_estrategicos_depts', 'pg_objetivo_estrategico_id');
CALL PROC_DROP_KEY('objetivos_estrategicos_depts', 'dept_id');

CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos_usuarios', 'objetivos_estrategicos_usuarios_fk');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos_usuarios', 'objetivos_estrategicos_usuarios_fk1');
CALL PROC_DROP_KEY('objetivos_estrategicos_usuarios', 'pg_objetivo_estrategico_id');
CALL PROC_DROP_KEY('objetivos_estrategicos_usuarios', 'usuario_id');

CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos_log', 'objetivos_estrategicos_log_fk');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos_log', 'objetivos_estrategicos_log_fk1');
CALL PROC_DROP_KEY('objetivos_estrategicos_log', 'pg_objetivo_estrategico_log_objetivo');
CALL PROC_DROP_KEY('objetivos_estrategicos_log', 'pg_objetivo_estrategico_log_criador');

CALL PROC_DROP_FOREIGN_KEY('plano_gestao_objetivos_estrategicos', 'plano_gestao_objetivos_estrategicos_fk');
CALL PROC_DROP_KEY('plano_gestao_objetivos_estrategicos', 'pg_objetivo_estrategico_id');
CALL PROC_DROP_KEY('plano_gestao_objetivos_estrategicos', 'pg_id');

CALL PROC_DROP_FOREIGN_KEY('fatores_criticos', 'fatores_criticos_fk2');

CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos', 'objetivos_estrategicos_fk');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos', 'objetivos_estrategicos_fk1');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos', 'objetivos_estrategicos_fk2');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos', 'objetivos_estrategicos_fk3');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos', 'objetivos_estrategicos_fk4');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos', 'objetivos_estrategicos_fk5');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos', 'objetivos_estrategicos_fk6');
CALL PROC_DROP_FOREIGN_KEY('objetivos_estrategicos', 'pg_objetivo_estrategico_moeda');
CALL PROC_DROP_KEY('objetivos_estrategicos', 'pg_objetivo_estrategico_cia');
CALL PROC_DROP_KEY('objetivos_estrategicos', 'pg_objetivo_estrategico_dept');
CALL PROC_DROP_KEY('objetivos_estrategicos', 'pg_objetivo_estrategico_superior');
CALL PROC_DROP_KEY('objetivos_estrategicos', 'pg_objetivo_estrategico_usuario');
CALL PROC_DROP_KEY('objetivos_estrategicos', 'pg_objetivo_estrategico_perspectiva');
CALL PROC_DROP_KEY('objetivos_estrategicos', 'pg_objetivo_estrategico_tema');
CALL PROC_DROP_KEY('objetivos_estrategicos', 'pg_objetivo_estrategico_indicador');
CALL PROC_DROP_KEY('objetivos_estrategicos', 'pg_objetivo_estrategico_moeda');

ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_id objetivo_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_cia objetivo_cia INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_dept objetivo_dept INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_perspectiva objetivo_perspectiva INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_tema objetivo_tema INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_usuario objetivo_usuario INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_superior objetivo_superior INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_indicador objetivo_indicador INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_nome objetivo_nome VARCHAR(250) DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_data objetivo_data DATETIME DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_ordem objetivo_ordem INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_acesso objetivo_acesso INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_cor objetivo_cor VARCHAR(6) DEFAULT 'FFFFFF';
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_oque objetivo_oque TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_descricao objetivo_descricao TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_onde objetivo_onde TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_quando objetivo_quando TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_como objetivo_como TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_porque objetivo_porque TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_quanto objetivo_quanto TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_quem objetivo_quem TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_controle objetivo_controle TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_melhorias objetivo_melhorias TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_metodo_aprendizado objetivo_metodo_aprendizado TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_desde_quando objetivo_desde_quando TEXT;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_composicao objetivo_composicao TINYINT(1) DEFAULT 0;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_ativo objetivo_ativo TINYINT(1) DEFAULT 1;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_tipo objetivo_tipo VARCHAR(50) DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_percentagem objetivo_percentagem DECIMAL(20,5) UNSIGNED DEFAULT 0;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_tipo_pontuacao objetivo_tipo_pontuacao VARCHAR(40) DEFAULT NULL;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_ponto_alvo objetivo_ponto_alvo DECIMAL(20,5) UNSIGNED DEFAULT 0;
ALTER TABLE objetivos_estrategicos CHANGE pg_objetivo_estrategico_moeda objetivo_moeda INTEGER(100) UNSIGNED DEFAULT 1;
RENAME TABLE objetivos_estrategicos TO objetivo;
ALTER TABLE objetivo ADD KEY objetivo_cia (objetivo_cia);
ALTER TABLE objetivo ADD KEY objetivo_dept (objetivo_dept);
ALTER TABLE objetivo ADD KEY objetivo_superior (objetivo_superior);
ALTER TABLE objetivo ADD KEY objetivo_usuario (objetivo_usuario);
ALTER TABLE objetivo ADD KEY objetivo_perspectiva (objetivo_perspectiva);
ALTER TABLE objetivo ADD KEY objetivo_tema (objetivo_tema);
ALTER TABLE objetivo ADD KEY objetivo_indicador (objetivo_indicador);
ALTER TABLE objetivo ADD KEY objetivo_moeda (objetivo_moeda);
ALTER TABLE objetivo ADD CONSTRAINT objetivo_cia FOREIGN KEY (objetivo_cia) REFERENCES cias (cia_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE objetivo ADD CONSTRAINT objetivo_superior FOREIGN KEY (objetivo_superior) REFERENCES objetivo (objetivo_id) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE objetivo ADD CONSTRAINT objetivo_usuario FOREIGN KEY (objetivo_usuario) REFERENCES usuarios (usuario_id) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE objetivo ADD CONSTRAINT objetivo_perspectiva FOREIGN KEY (objetivo_perspectiva) REFERENCES perspectivas (pg_perspectiva_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE objetivo ADD CONSTRAINT objetivo_tema FOREIGN KEY (objetivo_tema) REFERENCES tema (tema_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE objetivo ADD CONSTRAINT objetivo_indicador FOREIGN KEY (objetivo_indicador) REFERENCES pratica_indicador (pratica_indicador_id) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE objetivo ADD CONSTRAINT objetivo_dept FOREIGN KEY (objetivo_dept) REFERENCES depts (dept_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE objetivo ADD CONSTRAINT objetivo_moeda FOREIGN KEY (objetivo_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE objetivos_estrategicos_composicao CHANGE objetivo_pai objetivo_composicao_pai INTEGER(100) UNSIGNED NOT NULL;
ALTER TABLE objetivos_estrategicos_composicao CHANGE objetivo_filho objetivo_composicao_filho INTEGER(100) UNSIGNED NOT NULL;
RENAME TABLE objetivos_estrategicos_composicao TO objetivo_composicao;
ALTER TABLE objetivo_composicao ADD KEY objetivo_composicao_pai (objetivo_composicao_pai);
ALTER TABLE objetivo_composicao ADD KEY bjetivo_composicao_filho (objetivo_composicao_filho);
ALTER TABLE objetivo_composicao ADD CONSTRAINT objetivo_composicao_pai FOREIGN KEY (objetivo_composicao_pai) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE objetivo_composicao ADD CONSTRAINT objetivo_composicao_filho FOREIGN KEY (objetivo_composicao_filho) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE objetivos_estrategicos_depts CHANGE pg_objetivo_estrategico_id objetivo_dept_objetivo INTEGER(100) UNSIGNED NOT NULL;
ALTER TABLE objetivos_estrategicos_depts CHANGE dept_id objetivo_dept_dept INTEGER(100) UNSIGNED NOT NULL;
RENAME TABLE objetivos_estrategicos_depts TO objetivo_dept;
ALTER TABLE objetivo_dept ADD KEY objetivo_dept_objetivo (objetivo_dept_objetivo);
ALTER TABLE objetivo_dept ADD KEY objetivo_dept_dept (objetivo_dept_dept);
ALTER TABLE objetivo_dept ADD CONSTRAINT objetivo_dept_dept FOREIGN KEY (objetivo_dept_dept) REFERENCES depts (dept_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE objetivo_dept ADD CONSTRAINT objetivo_dept_objetivo FOREIGN KEY (objetivo_dept_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE objetivos_estrategicos_usuarios CHANGE pg_objetivo_estrategico_id objetivo_usuario_objetivo INTEGER(100) UNSIGNED NOT NULL;
ALTER TABLE objetivos_estrategicos_usuarios CHANGE usuario_id objetivo_usuario_usuario INTEGER(100) UNSIGNED NOT NULL;
RENAME TABLE objetivos_estrategicos_usuarios TO objetivo_usuario;
ALTER TABLE objetivo_usuario ADD KEY objetivo_usuario_objetivo (objetivo_usuario_objetivo);
ALTER TABLE objetivo_usuario ADD KEY objetivo_usuario_usuario (objetivo_usuario_usuario);
ALTER TABLE objetivo_usuario ADD CONSTRAINT objetivo_usuario_usuario FOREIGN KEY (objetivo_usuario_usuario) REFERENCES usuarios (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE objetivo_usuario ADD CONSTRAINT objetivo_usuario_objetivo FOREIGN KEY (objetivo_usuario_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_id objetivo_log_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_objetivo objetivo_log_objetivo INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_criador objetivo_log_criador INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_horas objetivo_log_horas DECIMAL(20,5) UNSIGNED DEFAULT 0;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_descricao objetivo_log_descricao TEXT;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_custo objetivo_log_custo DECIMAL(20,5) UNSIGNED DEFAULT 0;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_nd objetivo_log_nd VARCHAR(11) DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_categoria_economica objetivo_log_categoria_economica VARCHAR(1) DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_grupo_despesa objetivo_log_grupo_despesa VARCHAR(1) DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_modalidade_aplicacao objetivo_log_modalidade_aplicacao VARCHAR(2) DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_metodo objetivo_log_metodo INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_exercicio objetivo_log_exercicio INTEGER(4) UNSIGNED DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_problema objetivo_log_problema TINYINT(1) DEFAULT 0;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_referencia objetivo_log_referencia INTEGER(11) DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_nome objetivo_log_nome VARCHAR(200) DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_data objetivo_log_data DATETIME DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_url_relacionada objetivo_log_url_relacionada VARCHAR(250) DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log CHANGE pg_objetivo_estrategico_log_acesso objetivo_log_acesso INTEGER(100) DEFAULT 0;
RENAME TABLE objetivos_estrategicos_log TO objetivo_log;
ALTER TABLE objetivo_log ADD KEY objetivo_log_objetivo (objetivo_log_objetivo);
ALTER TABLE objetivo_log ADD KEY objetivo_log_criador (objetivo_log_criador);
ALTER TABLE objetivo_log ADD CONSTRAINT objetivo_log_objetivo FOREIGN KEY (objetivo_log_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE objetivo_log ADD CONSTRAINT objetivo_log_criador FOREIGN KEY (objetivo_log_criador) REFERENCES usuarios (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE plano_gestao_objetivos_estrategicos CHANGE pg_objetivo_estrategico_id plano_gestao_objetivo_objetivo INTEGER(100) UNSIGNED NOT NULL;
ALTER TABLE plano_gestao_objetivos_estrategicos CHANGE pg_id plano_gestao_objetivo_plano_gestao INTEGER(100) UNSIGNED NOT NULL;
ALTER TABLE plano_gestao_objetivos_estrategicos CHANGE pg_objetivo_estrategico_ordem plano_gestao_objetivo_ordem INTEGER(100) UNSIGNED DEFAULT NULL;
RENAME TABLE plano_gestao_objetivos_estrategicos TO  plano_gestao_objetivo;
ALTER TABLE plano_gestao_objetivo ADD KEY plano_gestao_objetivo_objetivo (plano_gestao_objetivo_objetivo);
ALTER TABLE plano_gestao_objetivo ADD CONSTRAINT plano_gestao_objetivo_objetivo FOREIGN KEY (plano_gestao_objetivo_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE plano_gestao_objetivo ADD KEY plano_gestao_objetivo_plano_gestao (plano_gestao_objetivo_plano_gestao);
ALTER TABLE plano_gestao_objetivo ADD CONSTRAINT plano_gestao_objetivo_plano_gestao FOREIGN KEY (plano_gestao_objetivo_plano_gestao) REFERENCES plano_gestao (pg_id) ON DELETE CASCADE ON UPDATE CASCADE;

UPDATE campo_formulario SET campo_formulario_campo='objetivo_descricao' WHERE campo_formulario_campo='pg_objetivo_estrategico_descricao';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_oque' WHERE campo_formulario_campo='pg_objetivo_estrategico_oque';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_onde' WHERE campo_formulario_campo='pg_objetivo_estrategico_onde';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_quando' WHERE campo_formulario_campo='pg_objetivo_estrategico_quando';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_como' WHERE campo_formulario_campo='pg_objetivo_estrategico_como';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_porque' WHERE campo_formulario_campo='pg_objetivo_estrategico_porque';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_quanto' WHERE campo_formulario_campo='pg_objetivo_estrategico_quanto';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_quem' WHERE campo_formulario_campo='pg_objetivo_estrategico_quem';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_controle' WHERE campo_formulario_campo='pg_objetivo_estrategico_controle';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_melhorias' WHERE campo_formulario_campo='pg_objetivo_estrategico_melhorias';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_metodo_aprendizado' WHERE campo_formulario_campo='pg_objetivo_estrategico_metodo_aprendizado';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_desde_quando' WHERE campo_formulario_campo='pg_objetivo_estrategico_desde_quando';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_superior' WHERE campo_formulario_campo='pg_objetivo_estrategico_superior';
UPDATE campo_formulario SET campo_formulario_campo='objetivo_composicao' WHERE campo_formulario_campo='pg_objetivo_estrategico_composicao';

CALL PROC_DROP_FOREIGN_KEY('fatores_criticos_depts', 'fatores_criticos_depts_fk');
CALL PROC_DROP_FOREIGN_KEY('fatores_criticos_depts', 'fatores_criticos_depts_fk1');
CALL PROC_DROP_KEY('fatores_criticos_depts', 'pg_fator_critico_id');
CALL PROC_DROP_KEY('fatores_criticos_depts', 'dept_id');

CALL PROC_DROP_FOREIGN_KEY('fatores_criticos_usuarios', 'fatores_criticos_usuarios_fk');
CALL PROC_DROP_FOREIGN_KEY('fatores_criticos_usuarios', 'fatores_criticos_usuarios_fk1');
CALL PROC_DROP_KEY('fatores_criticos_usuarios', 'pg_fator_critico_id');
CALL PROC_DROP_KEY('fatores_criticos_usuarios', 'usuario_id');

CALL PROC_DROP_FOREIGN_KEY('plano_gestao_fatores_criticos', 'plano_gestao_fatores_criticos_fk1');
CALL PROC_DROP_FOREIGN_KEY('plano_gestao_fatores_criticos', 'plano_gestao_fatores_criticos_fk');
CALL PROC_DROP_KEY('plano_gestao_fatores_criticos', 'pg_fator_critico_id');
CALL PROC_DROP_KEY('plano_gestao_fatores_criticos', 'pg_id');

CALL PROC_DROP_FOREIGN_KEY('fatores_criticos_log', 'fatores_criticos_log_fk');
CALL PROC_DROP_FOREIGN_KEY('fatores_criticos_log', 'fatores_criticos_log_fk1');
CALL PROC_DROP_KEY('fatores_criticos_log', 'pg_fator_critico_log_fator');
CALL PROC_DROP_KEY('fatores_criticos_log', 'pg_fator_critico_log_criador');

CALL PROC_DROP_FOREIGN_KEY('fatores_criticos', 'fatores_criticos_fk');
CALL PROC_DROP_FOREIGN_KEY('fatores_criticos', 'fatores_criticos_fk1');
CALL PROC_DROP_FOREIGN_KEY('fatores_criticos', 'fatores_criticos_fk3');
CALL PROC_DROP_FOREIGN_KEY('fatores_criticos', 'fatores_criticos_fk4');
CALL PROC_DROP_FOREIGN_KEY('fatores_criticos', 'fatores_criticos_fk5');
CALL PROC_DROP_FOREIGN_KEY('fatores_criticos', 'pg_fator_critico_moeda');
CALL PROC_DROP_KEY('fatores_criticos', 'pg_fator_critico_cia');
CALL PROC_DROP_KEY('fatores_criticos', 'pg_fator_critico_dept');
CALL PROC_DROP_KEY('fatores_criticos', 'pg_fator_critico_superior');
CALL PROC_DROP_KEY('fatores_criticos', 'pg_fator_critico_usuario');
CALL PROC_DROP_KEY('fatores_criticos', 'pg_fator_critico_objetivo');
CALL PROC_DROP_KEY('fatores_criticos', 'pg_fator_critico_principal_indicador');
CALL PROC_DROP_KEY('fatores_criticos', 'pg_fator_critico_moeda');
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_id fator_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_cia fator_cia INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_dept fator_dept INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_objetivo fator_objetivo INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_usuario fator_usuario INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_principal_indicador fator_principal_indicador INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_superior fator_superior INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_nome fator_nome VARCHAR(250) DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_data fator_data DATETIME DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_ordem fator_ordem INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_acesso fator_acesso INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_cor fator_cor VARCHAR(6) DEFAULT 'FFFFFF';
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_oque fator_oque TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_descricao fator_descricao TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_onde fator_onde TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_quando fator_quando TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_como fator_como TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_porque fator_porque TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_quanto fator_quanto TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_quem fator_quem TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_controle fator_controle TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_melhorias fator_melhorias TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_metodo_aprendizado fator_metodo_aprendizado TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_desde_quando fator_desde_quando TEXT;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_ativo fator_ativo TINYINT(1) DEFAULT 1;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_tipo fator_tipo VARCHAR(50) DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_percentagem fator_percentagem DECIMAL(20,5) UNSIGNED DEFAULT 0;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_tipo_pontuacao fator_tipo_pontuacao VARCHAR(40) DEFAULT NULL;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_ponto_alvo fator_ponto_alvo DECIMAL(20,5) UNSIGNED DEFAULT 0;
ALTER TABLE fatores_criticos CHANGE pg_fator_critico_moeda fator_moeda INTEGER(100) UNSIGNED DEFAULT 1;
RENAME TABLE fatores_criticos TO fator;
ALTER TABLE fator ADD KEY fator_cia (fator_cia);
ALTER TABLE fator ADD KEY fator_dept (fator_dept);
ALTER TABLE fator ADD KEY fator_superior (fator_superior);
ALTER TABLE fator ADD KEY fator_usuario (fator_usuario);
ALTER TABLE fator ADD KEY fator_objetivo (fator_objetivo);
ALTER TABLE fator ADD KEY fator_principal_indicador (fator_principal_indicador);
ALTER TABLE fator ADD KEY fator_moeda (fator_moeda);
ALTER TABLE fator ADD CONSTRAINT fator_cia FOREIGN KEY (fator_cia) REFERENCES cias (cia_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE fator ADD CONSTRAINT fator_dept FOREIGN KEY (fator_dept) REFERENCES depts (dept_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE fator ADD CONSTRAINT fator_superior FOREIGN KEY (fator_superior) REFERENCES fator (fator_id) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE fator ADD CONSTRAINT fator_usuario FOREIGN KEY (fator_usuario) REFERENCES usuarios (usuario_id) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE fator ADD CONSTRAINT fator_objetivo FOREIGN KEY (fator_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE fator ADD CONSTRAINT fator_principal_indicador FOREIGN KEY (fator_principal_indicador) REFERENCES pratica_indicador (pratica_indicador_id) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE fator ADD CONSTRAINT fator_moeda FOREIGN KEY (fator_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE fatores_criticos_depts CHANGE pg_fator_critico_id fator_dept_fator INTEGER(100) UNSIGNED NOT NULL;
ALTER TABLE fatores_criticos_depts CHANGE dept_id fator_dept_dept INTEGER(100) UNSIGNED NOT NULL;
RENAME TABLE fatores_criticos_depts TO fator_dept;
ALTER TABLE fator_dept ADD KEY fator_dept_fator (fator_dept_fator);
ALTER TABLE fator_dept ADD KEY fator_dept_dept (fator_dept_dept);
ALTER TABLE fator_dept ADD CONSTRAINT fator_dept_dept FOREIGN KEY (fator_dept_dept) REFERENCES depts (dept_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE fator_dept ADD CONSTRAINT fator_dept_fator FOREIGN KEY (fator_dept_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE fatores_criticos_usuarios CHANGE pg_fator_critico_id fator_usuario_fator INTEGER(100) UNSIGNED NOT NULL;
ALTER TABLE fatores_criticos_usuarios CHANGE usuario_id fator_usuario_usuario INTEGER(100) UNSIGNED NOT NULL;
RENAME TABLE fatores_criticos_usuarios TO fator_usuario;
ALTER TABLE fator_usuario ADD KEY fator_usuario_fator (fator_usuario_fator);
ALTER TABLE fator_usuario ADD KEY fator_usuario_usuario (fator_usuario_usuario);
ALTER TABLE fator_usuario ADD CONSTRAINT fator_usuario_usuario FOREIGN KEY (fator_usuario_usuario) REFERENCES usuarios (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE fator_usuario ADD CONSTRAINT fator_usuario_fator FOREIGN KEY (fator_usuario_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE plano_gestao_fatores_criticos CHANGE pg_fator_critico_id plano_gestao_fator_fator INTEGER(100) UNSIGNED NOT NULL;
ALTER TABLE plano_gestao_fatores_criticos CHANGE pg_id plano_gestao_fator_plano_gestao INTEGER(100) UNSIGNED NOT NULL;
ALTER TABLE plano_gestao_fatores_criticos CHANGE pg_fator_critico_ordem plano_gestao_fator_ordem INTEGER(100) UNSIGNED DEFAULT NULL;
RENAME TABLE plano_gestao_fatores_criticos TO  plano_gestao_fator;
ALTER TABLE plano_gestao_fator ADD KEY plano_gestao_fator_fator (plano_gestao_fator_fator);
ALTER TABLE plano_gestao_fator ADD CONSTRAINT plano_gestao_fator_fator FOREIGN KEY (plano_gestao_fator_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE plano_gestao_fator ADD KEY plano_gestao_fator_plano_gestao (plano_gestao_fator_plano_gestao);
ALTER TABLE plano_gestao_fator ADD CONSTRAINT plano_gestao_fator_plano_gestao FOREIGN KEY (plano_gestao_fator_plano_gestao) REFERENCES plano_gestao (pg_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_id fator_log_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_fator fator_log_fator INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_criador fator_log_criador INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_horas fator_log_horas DECIMAL(20,5) UNSIGNED DEFAULT 0;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_descricao fator_log_descricao TEXT;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_custo fator_log_custo DECIMAL(20,5) UNSIGNED DEFAULT 0;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_nd fator_log_nd VARCHAR(11) DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_categoria_economica fator_log_categoria_economica VARCHAR(1) DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_grupo_despesa fator_log_grupo_despesa VARCHAR(1) DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_modalidade_aplicacao fator_log_modalidade_aplicacao VARCHAR(2) DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_criticos_metodo fator_log_metodo INTEGER(100) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_criticos_exercicio fator_log_exercicio INTEGER(4) UNSIGNED DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_problema fator_log_problema TINYINT(1) DEFAULT 0;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_referencia fator_log_referencia INTEGER(11) DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_nome fator_log_nome VARCHAR(200) DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_data fator_log_data DATETIME DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_url_relacionada fator_log_url_relacionada VARCHAR(250) DEFAULT NULL;
ALTER TABLE fatores_criticos_log CHANGE pg_fator_critico_log_acesso fator_log_acesso INTEGER(100) DEFAULT 0;
RENAME TABLE fatores_criticos_log TO fator_log;
ALTER TABLE fator_log ADD KEY fator_log_fator (fator_log_fator);
ALTER TABLE fator_log ADD KEY fator_log_criador (fator_log_criador);
ALTER TABLE fator_log ADD CONSTRAINT fator_log_fator FOREIGN KEY (fator_log_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE fator_log ADD CONSTRAINT fator_log_criador FOREIGN KEY (fator_log_criador) REFERENCES usuarios (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE;

UPDATE campo_formulario SET campo_formulario_campo='fator_descricao' WHERE campo_formulario_campo='pg_fator_critico_descricao';
UPDATE campo_formulario SET campo_formulario_campo='fator_oque' WHERE campo_formulario_campo='pg_fator_critico_oque';
UPDATE campo_formulario SET campo_formulario_campo='fator_onde' WHERE campo_formulario_campo='pg_fator_critico_onde';
UPDATE campo_formulario SET campo_formulario_campo='fator_quando' WHERE campo_formulario_campo='pg_fator_critico_quando';
UPDATE campo_formulario SET campo_formulario_campo='fator_como' WHERE campo_formulario_campo='pg_fator_critico_como';
UPDATE campo_formulario SET campo_formulario_campo='fator_porque' WHERE campo_formulario_campo='pg_fator_critico_porque';
UPDATE campo_formulario SET campo_formulario_campo='fator_quanto' WHERE campo_formulario_campo='pg_fator_critico_quanto';
UPDATE campo_formulario SET campo_formulario_campo='fator_quem' WHERE campo_formulario_campo='pg_fator_critico_quem';
UPDATE campo_formulario SET campo_formulario_campo='fator_controle' WHERE campo_formulario_campo='pg_fator_critico_controle';
UPDATE campo_formulario SET campo_formulario_campo='fator_melhorias' WHERE campo_formulario_campo='pg_fator_critico_melhorias';
UPDATE campo_formulario SET campo_formulario_campo='fator_metodo_aprendizado' WHERE campo_formulario_campo='pg_fator_critico_metodo_aprendizado';
UPDATE campo_formulario SET campo_formulario_campo='fator_desde_quando' WHERE campo_formulario_campo='pg_fator_critico_desde_quando';
UPDATE campo_formulario SET campo_formulario_campo='fator_tipo' WHERE campo_formulario_campo='pg_fator_critico_tipo';