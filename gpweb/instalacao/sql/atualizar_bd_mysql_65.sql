UPDATE versao SET versao_codigo='7.7.9'; 
UPDATE versao SET versao_bd=65;

SET FOREIGN_KEY_CHECKS=0;

UPDATE tarefas SET tarefa_dinamica=0 WHERE tarefa_dinamica=31; 

ALTER TABLE agendas MODIFY agenda_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE arquivo_pastas MODIFY arquivo_pasta_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE arquivos MODIFY arquivo_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE baseline_projetos MODIFY projeto_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE baseline_tarefas MODIFY tarefa_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE brainstorm MODIFY brainstorm_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE causa_efeito MODIFY causa_efeito_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE checklist MODIFY checklist_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE cias MODIFY cia_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE depts MODIFY dept_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE estrategias MODIFY pg_estrategia_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE eventos MODIFY evento_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE fatores_criticos MODIFY pg_fator_critico_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE foruns MODIFY forum_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE gut MODIFY gut_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE instrumento MODIFY instrumento_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE links MODIFY link_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE metas MODIFY pg_meta_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE objetivos_estrategicos MODIFY pg_objetivo_estrategico_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE perspectivas MODIFY pg_perspectiva_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE plano_acao MODIFY plano_acao_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE praticas MODIFY pratica_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE projetos MODIFY projeto_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE recursos MODIFY recurso_nivel_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE tarefa_log MODIFY tarefa_log_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE tarefas MODIFY tarefa_acesso INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE tarefas MODIFY tarefa_percentagem FLOAT UNSIGNED DEFAULT '0';
ALTER TABLE baseline_tarefas MODIFY tarefa_percentagem FLOAT UNSIGNED DEFAULT '0';
ALTER TABLE projetos MODIFY projeto_status INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE baseline_projetos MODIFY projeto_status INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE baseline_tarefas MODIFY tarefa_status INTEGER(100) UNSIGNED DEFAULT '0';
ALTER TABLE tarefas MODIFY tarefa_status INTEGER(100) UNSIGNED DEFAULT '0';

UPDATE projetos SET projeto_status=0 WHERE projeto_status IS NULL;
UPDATE tarefas SET tarefa_status=0 WHERE tarefa_status IS NULL;
UPDATE baseline_projetos SET projeto_status=0 WHERE projeto_status IS NULL;
UPDATE baseline_tarefas SET tarefa_status=0 WHERE tarefa_status IS NULL;
UPDATE cias SET cia_acesso=0 WHERE cia_acesso IS NULL;
UPDATE depts SET dept_acesso=0 WHERE dept_acesso IS NULL;
UPDATE agendas SET agenda_acesso=0 WHERE agenda_acesso IS NULL;
UPDATE perspectivas SET pg_perspectiva_acesso=0 WHERE pg_perspectiva_acesso IS NULL;
UPDATE objetivos_estrategicos SET pg_objetivo_estrategico_acesso=0 WHERE pg_objetivo_estrategico_acesso IS NULL;
UPDATE fatores_criticos SET pg_fator_critico_acesso=0 WHERE pg_fator_critico_acesso IS NULL;
UPDATE estrategias SET pg_estrategia_acesso=0 WHERE pg_estrategia_acesso IS NULL;
UPDATE metas SET pg_meta_acesso=0 WHERE pg_meta_acesso IS NULL;
UPDATE checklist SET checklist_acesso=0 WHERE checklist_acesso IS NULL;
UPDATE praticas SET pratica_acesso=0 WHERE pratica_acesso IS NULL;
UPDATE plano_acao SET plano_acao_acesso=0 WHERE plano_acao_acesso IS NULL;
UPDATE arquivo_pastas SET arquivo_pasta_acesso=0 WHERE arquivo_pasta_acesso IS NULL;
UPDATE arquivos SET arquivo_acesso=0 WHERE arquivo_acesso IS NULL;
UPDATE projetos SET projeto_acesso=0 WHERE projeto_acesso IS NULL;
UPDATE tarefas SET tarefa_acesso=0 WHERE tarefa_acesso IS NULL;
UPDATE baseline_projetos SET projeto_acesso=0 WHERE projeto_acesso IS NULL;
UPDATE baseline_tarefas SET tarefa_acesso=0 WHERE tarefa_acesso IS NULL;
UPDATE brainstorm SET brainstorm_acesso=0 WHERE brainstorm_acesso IS NULL;
UPDATE causa_efeito SET causa_efeito_acesso=0 WHERE causa_efeito_acesso IS NULL;
UPDATE gut SET gut_acesso=0 WHERE gut_acesso IS NULL;
UPDATE eventos SET evento_acesso=0 WHERE evento_acesso IS NULL;
UPDATE foruns SET forum_acesso=0 WHERE forum_acesso IS NULL;
UPDATE instrumento SET instrumento_acesso=0 WHERE instrumento_acesso IS NULL;
UPDATE recursos SET recurso_nivel_acesso=0 WHERE recurso_nivel_acesso IS NULL;
UPDATE links SET link_acesso=0 WHERE link_acesso IS NULL;
UPDATE tarefa_log SET tarefa_log_acesso=0 WHERE tarefa_log_acesso IS NULL;


ALTER TABLE contatos MODIFY contato_ultima_atualizacao DATETIME DEFAULT NULL;
ALTER TABLE contatos MODIFY contato_pedido_atualizacao DATETIME DEFAULT NULL;
ALTER TABLE agendas MODIFY agenda_inicio DATETIME DEFAULT NULL;
ALTER TABLE agendas MODIFY agenda_fim DATETIME DEFAULT NULL;
ALTER TABLE agendas MODIFY agenda_criacao DATETIME DEFAULT NULL;
ALTER TABLE agendas MODIFY agenda_modificacao DATETIME DEFAULT NULL;
ALTER TABLE agenda_arquivos MODIFY agenda_arquivo_data DATETIME DEFAULT NULL;
ALTER TABLE agenda_usuarios MODIFY data DATETIME DEFAULT NULL;
ALTER TABLE alteracoes MODIFY data DATETIME DEFAULT NULL;
ALTER TABLE chaves_publicas MODIFY chave_publica_data DATETIME DEFAULT NULL;
ALTER TABLE msg MODIFY data_envio DATETIME DEFAULT NULL;
ALTER TABLE anexos MODIFY data_envio DATETIME DEFAULT NULL;
ALTER TABLE anexo_leitura MODIFY datahora_leitura DATETIME DEFAULT NULL;
ALTER TABLE anotacao MODIFY datahora DATETIME DEFAULT NULL;
ALTER TABLE objetivos_estrategicos MODIFY pg_objetivo_estrategico_data DATETIME DEFAULT NULL;
ALTER TABLE fatores_criticos MODIFY pg_fator_critico_data DATETIME DEFAULT NULL;
ALTER TABLE estrategias MODIFY pg_estrategia_data DATETIME DEFAULT NULL;
ALTER TABLE metas MODIFY pg_meta_data DATETIME DEFAULT NULL;
ALTER TABLE projetos MODIFY projeto_data_inicio DATETIME DEFAULT NULL;
ALTER TABLE projetos MODIFY projeto_data_fim DATETIME DEFAULT NULL;
ALTER TABLE projetos MODIFY projeto_fim_atualizado DATETIME DEFAULT NULL;
ALTER TABLE projetos MODIFY projeto_data_chave DATETIME DEFAULT NULL;
ALTER TABLE projetos MODIFY projeto_criado DATETIME DEFAULT NULL;
ALTER TABLE projetos MODIFY projeto_atualizado DATETIME DEFAULT NULL;
ALTER TABLE projetos MODIFY projeto_data_fim_ajustada DATETIME DEFAULT NULL;
ALTER TABLE baseline_projetos MODIFY projeto_data_inicio DATETIME DEFAULT NULL;
ALTER TABLE baseline_projetos MODIFY projeto_data_fim DATETIME DEFAULT NULL;
ALTER TABLE baseline_projetos MODIFY projeto_fim_atualizado DATETIME DEFAULT NULL;
ALTER TABLE baseline_projetos MODIFY projeto_data_chave DATETIME DEFAULT NULL;
ALTER TABLE baseline_projetos MODIFY projeto_criado DATETIME DEFAULT NULL;
ALTER TABLE baseline_projetos MODIFY projeto_atualizado DATETIME DEFAULT NULL;
ALTER TABLE baseline_projetos MODIFY projeto_data_fim_ajustada DATETIME DEFAULT NULL;
ALTER TABLE baseline_tarefas MODIFY tarefa_inicio DATETIME DEFAULT NULL;
ALTER TABLE baseline_tarefas MODIFY tarefa_fim DATETIME DEFAULT NULL;
ALTER TABLE baseline_tarefas MODIFY tarefa_data_criada DATETIME DEFAULT NULL;
ALTER TABLE baseline_tarefas MODIFY tarefa_data_atualizada DATETIME DEFAULT NULL;
ALTER TABLE tarefas MODIFY tarefa_inicio DATETIME DEFAULT NULL;
ALTER TABLE tarefas MODIFY tarefa_fim DATETIME DEFAULT NULL;
ALTER TABLE tarefas MODIFY tarefa_data_criada DATETIME DEFAULT NULL;
ALTER TABLE tarefas MODIFY tarefa_data_atualizada DATETIME DEFAULT NULL;
ALTER TABLE arquivos MODIFY arquivo_data DATETIME DEFAULT NULL;
ALTER TABLE evento_arquivos MODIFY evento_arquivo_data DATETIME DEFAULT NULL;
ALTER TABLE evento_usuarios MODIFY data DATETIME DEFAULT NULL;
ALTER TABLE fatores_criticos_log MODIFY pg_fator_critico_log_data DATETIME DEFAULT NULL;
ALTER TABLE foruns MODIFY forum_data_criacao DATETIME DEFAULT NULL;
ALTER TABLE foruns MODIFY forum_ultima_data DATETIME DEFAULT NULL;
ALTER TABLE forum_mensagens MODIFY mensagem_data DATETIME DEFAULT NULL;
ALTER TABLE gut MODIFY gut_datahora DATETIME DEFAULT NULL;
ALTER TABLE historico MODIFY historico_data DATETIME DEFAULT NULL;
ALTER TABLE links MODIFY link_data DATETIME DEFAULT NULL;
ALTER TABLE metas_log MODIFY pg_meta_log_data DATETIME DEFAULT NULL;
ALTER TABLE modelos_dados MODIFY modelo_dados_data DATETIME DEFAULT NULL;
ALTER TABLE modelos MODIFY modelo_data DATETIME DEFAULT NULL;
ALTER TABLE modelos MODIFY modelo_data_protocolo DATETIME DEFAULT NULL;
ALTER TABLE modelos MODIFY modelo_data_assinado DATETIME DEFAULT NULL;
ALTER TABLE modelos MODIFY modelo_data_aprovado DATETIME DEFAULT NULL;
ALTER TABLE modelo_anotacao MODIFY datahora DATETIME DEFAULT NULL;
ALTER TABLE modelo_usuario MODIFY datahora DATETIME DEFAULT NULL;
ALTER TABLE modelo_usuario MODIFY datahora_leitura DATETIME DEFAULT NULL;
ALTER TABLE modelo_usuario MODIFY data_retorno DATETIME DEFAULT NULL;
ALTER TABLE modelo_usuario MODIFY data_limite DATETIME DEFAULT NULL;
ALTER TABLE modelo_leitura MODIFY datahora_leitura DATETIME DEFAULT NULL;
ALTER TABLE modelo_usuario_ext MODIFY datahora DATETIME DEFAULT NULL;
ALTER TABLE modelos_anexos MODIFY data_envio DATETIME DEFAULT NULL;
ALTER TABLE msg_usuario MODIFY datahora DATETIME DEFAULT NULL;
ALTER TABLE msg_usuario MODIFY datahora_leitura DATETIME DEFAULT NULL;
ALTER TABLE msg_usuario MODIFY data_retorno DATETIME DEFAULT NULL;
ALTER TABLE msg_usuario MODIFY data_limite DATETIME DEFAULT NULL;
ALTER TABLE msg_usuario_ext MODIFY datahora DATETIME DEFAULT NULL;
ALTER TABLE objetivos_estrategicos_log MODIFY pg_objetivo_estrategico_log_data DATETIME DEFAULT NULL;
ALTER TABLE parafazer_usuarios MODIFY data DATETIME DEFAULT NULL;
ALTER TABLE plano_acao_item_custos MODIFY plano_acao_item_custos_data DATETIME DEFAULT NULL;
ALTER TABLE plano_acao_item_gastos MODIFY plano_acao_item_gastos_data DATETIME DEFAULT NULL;
ALTER TABLE plano_acao_item_h_custos MODIFY h_custos_data1 DATETIME DEFAULT NULL;
ALTER TABLE plano_acao_item_h_custos MODIFY h_custos_data2 DATETIME DEFAULT NULL;
ALTER TABLE plano_acao_item_h_gastos MODIFY h_gastos_data1 DATETIME DEFAULT NULL;
ALTER TABLE plano_acao_item_h_gastos MODIFY h_gastos_data2 DATETIME DEFAULT NULL;
ALTER TABLE plano_acao_log MODIFY plano_acao_log_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao MODIFY pg_ultima_alteracao DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_ameacas MODIFY pg_ameaca_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_arquivos MODIFY pg_arquivo_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_diretrizes MODIFY pg_diretriz_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_diretrizes_superiores MODIFY pg_diretriz_superior_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_fornecedores MODIFY pg_fornecedor_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_oportunidade MODIFY pg_oportunidade_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_oportunidade_melhorias MODIFY pg_oportunidade_melhoria_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_pessoal MODIFY pg_pessoal_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_pontosfortes MODIFY pg_ponto_forte_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_premiacoes MODIFY pg_premiacao_data DATETIME DEFAULT NULL;
ALTER TABLE plano_gestao_principios MODIFY pg_principio_data DATETIME DEFAULT NULL;
ALTER TABLE pratica_indicador_log MODIFY pratica_indicador_log_data DATETIME DEFAULT NULL;
ALTER TABLE pratica_log MODIFY pratica_log_data DATETIME DEFAULT NULL;
ALTER TABLE projeto_anexo_a_equipe MODIFY data DATETIME DEFAULT NULL;
ALTER TABLE projeto_anexo_arquivos MODIFY pa_arquivo_data DATETIME DEFAULT NULL;
ALTER TABLE projeto_anexo_b_atribuicao MODIFY data DATETIME DEFAULT NULL;
ALTER TABLE projeto_anexo_h MODIFY data_inseriu DATETIME DEFAULT NULL;
ALTER TABLE projeto_anexo_i MODIFY data_inseriu DATETIME DEFAULT NULL;
ALTER TABLE projeto_anexo_j_atividade MODIFY data_inseriu DATETIME DEFAULT NULL;
ALTER TABLE projeto_anexo_j MODIFY data_inseriu DATETIME DEFAULT NULL;
ALTER TABLE projeto_observado MODIFY data_envio DATETIME DEFAULT NULL;
ALTER TABLE projeto_observado MODIFY data_aprovacao DATETIME DEFAULT NULL;
ALTER TABLE recurso_tarefas MODIFY recurso_inicio DATETIME DEFAULT NULL;
ALTER TABLE recurso_tarefas MODIFY recurso_fim DATETIME DEFAULT NULL;
ALTER TABLE referencia MODIFY referencia_data DATETIME DEFAULT NULL;
ALTER TABLE sessoes MODIFY sessao_criada DATETIME DEFAULT NULL;
ALTER TABLE tarefa_custos MODIFY tarefa_custos_data DATETIME DEFAULT NULL;
ALTER TABLE tarefa_gastos MODIFY tarefa_gastos_data DATETIME DEFAULT NULL;
ALTER TABLE tarefa_h_custos MODIFY h_custos_data1 DATETIME DEFAULT NULL;
ALTER TABLE tarefa_h_custos MODIFY h_custos_data2 DATETIME DEFAULT NULL;
ALTER TABLE tarefa_h_gastos MODIFY h_gastos_data1 DATETIME DEFAULT NULL;
ALTER TABLE tarefa_h_gastos MODIFY h_gastos_data2 DATETIME DEFAULT NULL;
ALTER TABLE tarefa_log MODIFY tarefa_log_data DATETIME DEFAULT NULL;
ALTER TABLE tarefa_log MODIFY tarefa_log_reg_mudanca_data DATETIME DEFAULT NULL;
ALTER TABLE usuario_reg_acesso MODIFY entrou DATETIME DEFAULT NULL;
ALTER TABLE usuario_reg_acesso MODIFY saiu DATETIME DEFAULT NULL;
ALTER TABLE usuario_reg_acesso MODIFY ultima_atividade DATETIME DEFAULT NULL;

UPDATE contatos SET contato_ultima_atualizacao = null WHERE contato_ultima_atualizacao = '0000-00-00 00:00:00';
UPDATE contatos SET contato_pedido_atualizacao = null WHERE contato_pedido_atualizacao = '0000-00-00 00:00:00';
UPDATE agendas SET agenda_inicio = null WHERE agenda_inicio = '0000-00-00 00:00:00';
UPDATE agendas SET agenda_fim = null WHERE agenda_fim = '0000-00-00 00:00:00';
UPDATE agendas SET agenda_criacao = null WHERE agenda_criacao = '0000-00-00 00:00:00';
UPDATE agendas SET agenda_modificacao = null WHERE agenda_modificacao = '0000-00-00 00:00:00';
UPDATE agenda_arquivos SET agenda_arquivo_data = null WHERE agenda_arquivo_data = '0000-00-00 00:00:00';
UPDATE agenda_usuarios SET data = null WHERE data = '0000-00-00 00:00:00';
UPDATE alteracoes SET data = null WHERE data = '0000-00-00 00:00:00';
UPDATE chaves_publicas SET chave_publica_data = null WHERE chave_publica_data = '0000-00-00 00:00:00';
UPDATE msg SET data_envio = null WHERE data_envio = '0000-00-00 00:00:00';
UPDATE anexos SET data_envio = null WHERE data_envio = '0000-00-00 00:00:00';
UPDATE anexo_leitura SET datahora_leitura = null WHERE datahora_leitura = '0000-00-00 00:00:00';
UPDATE anotacao SET datahora = null WHERE datahora = '0000-00-00 00:00:00';
UPDATE objetivos_estrategicos SET pg_objetivo_estrategico_data = null WHERE pg_objetivo_estrategico_data = '0000-00-00 00:00:00';
UPDATE fatores_criticos SET pg_fator_critico_data = null WHERE pg_fator_critico_data = '0000-00-00 00:00:00';
UPDATE estrategias SET pg_estrategia_data = null WHERE pg_estrategia_data = '0000-00-00 00:00:00';
UPDATE metas SET pg_meta_data = null WHERE pg_meta_data = '0000-00-00 00:00:00';
UPDATE projetos SET projeto_data_inicio = null WHERE projeto_data_inicio = '0000-00-00 00:00:00';
UPDATE projetos SET projeto_data_fim = null WHERE projeto_data_fim = '0000-00-00 00:00:00';
UPDATE projetos SET projeto_fim_atualizado = null WHERE projeto_fim_atualizado = '0000-00-00 00:00:00';
UPDATE projetos SET projeto_data_chave = null WHERE projeto_data_chave = '0000-00-00 00:00:00';
UPDATE projetos SET projeto_criado = null WHERE projeto_criado = '0000-00-00 00:00:00';
UPDATE projetos SET projeto_atualizado = null WHERE projeto_atualizado = '0000-00-00 00:00:00';
UPDATE projetos SET projeto_data_fim_ajustada = null WHERE projeto_data_fim_ajustada = '0000-00-00 00:00:00';
UPDATE baseline_projetos SET projeto_data_inicio = null WHERE projeto_data_inicio = '0000-00-00 00:00:00';
UPDATE baseline_projetos SET projeto_data_fim = null WHERE projeto_data_fim = '0000-00-00 00:00:00';
UPDATE baseline_projetos SET projeto_fim_atualizado = null WHERE projeto_fim_atualizado = '0000-00-00 00:00:00';
UPDATE baseline_projetos SET projeto_data_chave = null WHERE projeto_data_chave = '0000-00-00 00:00:00';
UPDATE baseline_projetos SET projeto_criado = null WHERE projeto_criado = '0000-00-00 00:00:00';
UPDATE baseline_projetos SET projeto_atualizado = null WHERE projeto_atualizado = '0000-00-00 00:00:00';
UPDATE baseline_projetos SET projeto_data_fim_ajustada = null WHERE projeto_data_fim_ajustada = '0000-00-00 00:00:00';
UPDATE baseline_tarefas SET tarefa_inicio = null WHERE tarefa_inicio = '0000-00-00 00:00:00';
UPDATE baseline_tarefas SET tarefa_fim = null WHERE tarefa_fim = '0000-00-00 00:00:00';
UPDATE baseline_tarefas SET tarefa_data_criada = null WHERE tarefa_data_criada = '0000-00-00 00:00:00';
UPDATE baseline_tarefas SET tarefa_data_atualizada = null WHERE tarefa_data_atualizada = '0000-00-00 00:00:00';
UPDATE tarefas SET tarefa_inicio = null WHERE tarefa_inicio = '0000-00-00 00:00:00';
UPDATE tarefas SET tarefa_fim = null WHERE tarefa_fim = '0000-00-00 00:00:00';
UPDATE tarefas SET tarefa_data_criada = null WHERE tarefa_data_criada = '0000-00-00 00:00:00';
UPDATE tarefas SET tarefa_data_atualizada = null WHERE tarefa_data_atualizada = '0000-00-00 00:00:00';
UPDATE arquivos SET arquivo_data = null WHERE arquivo_data = '0000-00-00 00:00:00';
UPDATE evento_arquivos SET evento_arquivo_data = null WHERE evento_arquivo_data = '0000-00-00 00:00:00';
UPDATE evento_usuarios SET data = null WHERE data = '0000-00-00 00:00:00';
UPDATE fatores_criticos_log SET pg_fator_critico_log_data = null WHERE pg_fator_critico_log_data = '0000-00-00 00:00:00';
UPDATE foruns SET forum_data_criacao = null WHERE forum_data_criacao = '0000-00-00 00:00:00';
UPDATE foruns SET forum_ultima_data = null WHERE forum_ultima_data = '0000-00-00 00:00:00';
UPDATE forum_mensagens SET mensagem_data = null WHERE mensagem_data = '0000-00-00 00:00:00';
UPDATE gut SET gut_datahora = null WHERE gut_datahora = '0000-00-00 00:00:00';
UPDATE historico SET historico_data = null WHERE historico_data = '0000-00-00 00:00:00';
UPDATE links SET link_data = null WHERE link_data = '0000-00-00 00:00:00';
UPDATE metas_log SET pg_meta_log_data = null WHERE pg_meta_log_data = '0000-00-00 00:00:00';
UPDATE modelos_dados SET modelo_dados_data = null WHERE modelo_dados_data = '0000-00-00 00:00:00';
UPDATE modelos SET modelo_data = null WHERE modelo_data = '0000-00-00 00:00:00';
UPDATE modelos SET modelo_data_protocolo = null WHERE modelo_data_protocolo = '0000-00-00 00:00:00';
UPDATE modelos SET modelo_data_assinado = null WHERE modelo_data_assinado = '0000-00-00 00:00:00';
UPDATE modelos SET modelo_data_aprovado = null WHERE modelo_data_aprovado = '0000-00-00 00:00:00';
UPDATE modelo_anotacao SET datahora = null WHERE datahora = '0000-00-00 00:00:00';
UPDATE modelo_usuario SET datahora = null WHERE datahora = '0000-00-00 00:00:00';
UPDATE modelo_usuario SET datahora_leitura = null WHERE datahora_leitura = '0000-00-00 00:00:00';
UPDATE modelo_usuario SET data_retorno = null WHERE data_retorno = '0000-00-00 00:00:00';
UPDATE modelo_usuario SET data_limite = null WHERE data_limite = '0000-00-00 00:00:00';
UPDATE modelo_leitura SET datahora_leitura = null WHERE datahora_leitura = '0000-00-00 00:00:00';
UPDATE modelo_usuario_ext SET datahora = null WHERE datahora = '0000-00-00 00:00:00';
UPDATE modelos_anexos SET data_envio = null WHERE data_envio = '0000-00-00 00:00:00';
UPDATE msg_usuario SET datahora = null WHERE datahora = '0000-00-00 00:00:00';
UPDATE msg_usuario SET datahora_leitura = null WHERE datahora_leitura = '0000-00-00 00:00:00';
UPDATE msg_usuario SET data_retorno = null WHERE data_retorno = '0000-00-00 00:00:00';
UPDATE msg_usuario SET data_limite = null WHERE data_limite = '0000-00-00 00:00:00';
UPDATE msg_usuario_ext SET datahora = null WHERE datahora = '0000-00-00 00:00:00';
UPDATE objetivos_estrategicos_log SET pg_objetivo_estrategico_log_data = null WHERE pg_objetivo_estrategico_log_data = '0000-00-00 00:00:00';
UPDATE parafazer_usuarios SET data = null WHERE data = '0000-00-00 00:00:00';
UPDATE plano_acao_item_custos SET plano_acao_item_custos_data = null WHERE plano_acao_item_custos_data = '0000-00-00 00:00:00';
UPDATE plano_acao_item_gastos SET plano_acao_item_gastos_data = null WHERE plano_acao_item_gastos_data = '0000-00-00 00:00:00';
UPDATE plano_acao_item_h_custos SET h_custos_data1 = null WHERE h_custos_data1 = '0000-00-00 00:00:00';
UPDATE plano_acao_item_h_custos SET h_custos_data2 = null WHERE h_custos_data2 = '0000-00-00 00:00:00';
UPDATE plano_acao_item_h_gastos SET h_gastos_data1 = null WHERE h_gastos_data1 = '0000-00-00 00:00:00';
UPDATE plano_acao_item_h_gastos SET h_gastos_data2 = null WHERE h_gastos_data2 = '0000-00-00 00:00:00';
UPDATE plano_acao_log SET plano_acao_log_data = null WHERE plano_acao_log_data = '0000-00-00 00:00:00';
UPDATE plano_gestao SET pg_ultima_alteracao = null WHERE pg_ultima_alteracao = '0000-00-00 00:00:00';
UPDATE plano_gestao_ameacas SET pg_ameaca_data = null WHERE pg_ameaca_data = '0000-00-00 00:00:00';
UPDATE plano_gestao_arquivos SET pg_arquivo_data = null WHERE pg_arquivo_data = '0000-00-00 00:00:00';
UPDATE plano_gestao_diretrizes SET pg_diretriz_data = null WHERE pg_diretriz_data = '0000-00-00 00:00:00';
UPDATE plano_gestao_diretrizes_superiores SET pg_diretriz_superior_data = null WHERE pg_diretriz_superior_data = '0000-00-00 00:00:00';
UPDATE plano_gestao_fornecedores SET pg_fornecedor_data = null WHERE pg_fornecedor_data = '0000-00-00 00:00:00';
UPDATE plano_gestao_oportunidade SET pg_oportunidade_data = null WHERE pg_oportunidade_data = '0000-00-00 00:00:00';
UPDATE plano_gestao_oportunidade_melhorias SET pg_oportunidade_melhoria_data = null WHERE pg_oportunidade_melhoria_data = '0000-00-00 00:00:00';
UPDATE plano_gestao_pessoal SET pg_pessoal_data = null WHERE pg_pessoal_data = '0000-00-00 00:00:00';
UPDATE plano_gestao_pontosfortes SET pg_ponto_forte_data = null WHERE pg_ponto_forte_data = '0000-00-00 00:00:00';
UPDATE plano_gestao_premiacoes SET pg_premiacao_data = null WHERE pg_premiacao_data = '0000-00-00 00:00:00';
UPDATE plano_gestao_principios SET pg_principio_data = null WHERE pg_principio_data = '0000-00-00 00:00:00';
UPDATE pratica_indicador_log SET pratica_indicador_log_data = null WHERE pratica_indicador_log_data = '0000-00-00 00:00:00';
UPDATE pratica_log SET pratica_log_data = null WHERE pratica_log_data = '0000-00-00 00:00:00';
UPDATE projeto_anexo_a_equipe SET data = null WHERE data = '0000-00-00 00:00:00';
UPDATE projeto_anexo_arquivos SET pa_arquivo_data = null WHERE pa_arquivo_data = '0000-00-00 00:00:00';
UPDATE projeto_anexo_b_atribuicao SET data = null WHERE data = '0000-00-00 00:00:00';
UPDATE projeto_anexo_h SET data_inseriu = null WHERE data_inseriu = '0000-00-00 00:00:00';
UPDATE projeto_anexo_i SET data_inseriu = null WHERE data_inseriu = '0000-00-00 00:00:00';
UPDATE projeto_anexo_j_atividade SET data_inseriu = null WHERE data_inseriu = '0000-00-00 00:00:00';
UPDATE projeto_anexo_j SET data_inseriu = null WHERE data_inseriu = '0000-00-00 00:00:00';
UPDATE projeto_observado SET data_envio = null WHERE data_envio = '0000-00-00 00:00:00';
UPDATE projeto_observado SET data_aprovacao = null WHERE data_aprovacao = '0000-00-00 00:00:00';
UPDATE recurso_tarefas SET recurso_inicio = null WHERE recurso_inicio = '0000-00-00 00:00:00';
UPDATE recurso_tarefas SET recurso_fim = null WHERE recurso_fim = '0000-00-00 00:00:00';
UPDATE referencia SET referencia_data = null WHERE referencia_data = '0000-00-00 00:00:00';
UPDATE sessoes SET sessao_criada = null WHERE sessao_criada = '0000-00-00 00:00:00';
UPDATE tarefa_custos SET tarefa_custos_data = null WHERE tarefa_custos_data = '0000-00-00 00:00:00';
UPDATE tarefa_gastos SET tarefa_gastos_data = null WHERE tarefa_gastos_data = '0000-00-00 00:00:00';
UPDATE tarefa_h_custos SET h_custos_data1 = null WHERE h_custos_data1 = '0000-00-00 00:00:00';
UPDATE tarefa_h_custos SET h_custos_data2 = null WHERE h_custos_data2 = '0000-00-00 00:00:00';
UPDATE tarefa_h_gastos SET h_gastos_data1 = null WHERE h_gastos_data1 = '0000-00-00 00:00:00';
UPDATE tarefa_h_gastos SET h_gastos_data2 = null WHERE h_gastos_data2 = '0000-00-00 00:00:00';
UPDATE tarefa_log SET tarefa_log_data = null WHERE tarefa_log_data = '0000-00-00 00:00:00';
UPDATE tarefa_log SET tarefa_log_reg_mudanca_data = null WHERE tarefa_log_reg_mudanca_data = '0000-00-00 00:00:00';
UPDATE usuario_reg_acesso SET entrou = null WHERE entrou = '0000-00-00 00:00:00';
UPDATE usuario_reg_acesso SET saiu = null WHERE saiu = '0000-00-00 00:00:00';
UPDATE usuario_reg_acesso SET ultima_atividade = null WHERE ultima_atividade = '0000-00-00 00:00:00';