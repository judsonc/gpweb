UPDATE config SET config_valor="organiza��o militar" WHERE config_nome="organizacao";
UPDATE config SET config_valor="organiza��es militares" WHERE config_nome="organizacoes";
UPDATE config SET config_valor="OM" WHERE config_nome="om";
UPDATE config SET config_valor="se��o" WHERE config_nome="departamento";
UPDATE config SET config_valor="se��es" WHERE config_nome="departamentos";
UPDATE config SET config_valor="se��o" WHERE config_nome="dept";
UPDATE config SET config_valor="organiza��o militar" WHERE config_nome="nome_om";
UPDATE config SET config_valor="2" WHERE config_nome="militar";


INSERT INTO cias (cia_id, cia_nome, cia_nome_completo, cia_superior, cia_tel1, cia_tel2, cia_fax, cia_endereco1, cia_endereco2, cia_cidade, cia_estado, cia_cep, cia_pais, cia_url, cia_responsavel, cia_descricao, cia_tipo, cia_email, cia_customizado, cia_contatos, cia_acesso, cia_cabacalho, cia_nup, cia_qnt_nup) VALUES 
  (1,'Cmt MB','Comandante da Marinha',0,'','','','','','','','','','',NULL,NULL,0,NULL,NULL,NULL,0,'<p style=\"text-align: center;\"><strong>MINIST�RIO DA DEFESA<br />Marinha do Brasil</strong></p>',NULL,0);
 
UPDATE arquivo_pasta SET arquivo_pasta_cia=1;
UPDATE arquivo SET arquivo_cia=1;
UPDATE baseline_tarefas SET tarefa_cia=1;
UPDATE brainstorm SET brainstorm_cia=1;
UPDATE calendario SET calendario_id=1;
UPDATE causa_efeito SET causa_efeito_cia=1;  
UPDATE checklist SET checklist_cia=1;
UPDATE contatos SET contato_cia=1; 
UPDATE depts SET dept_cia=1; 
UPDATE eventos SET evento_cia=1;
UPDATE expediente SET cia_id=1;
UPDATE favorito SET favorito_cia=1;
UPDATE foruns SET forum_cia=1; 
UPDATE gut SET gut_cia=1;
UPDATE links SET link_cia=1; 
UPDATE plano_gestao SET pg_cia=1; 
UPDATE pratica_indicador SET pratica_indicador_cia=1; 
UPDATE praticas SET pratica_cia=1; 
UPDATE projetos SET projeto_cia=1; 
UPDATE recursos SET recurso_cia=1; 
UPDATE tarefa_log SET tarefa_log_cia=1; 
UPDATE tarefas SET tarefa_cia=1;
UPDATE grupo SET grupo_cia=1;
UPDATE estrategias SET pg_estrategia_cia=1;
UPDATE objetivo SET objetivo_cia=1;
UPDATE perspectivas SET pg_perspectiva_cia=1;
UPDATE projeto_observado SET cia_de=1;
UPDATE fator SET fator_cia=1;
UPDATE metas SET pg_meta_cia=1;
UPDATE objetivo SET objetivo_cia=1;
UPDATE instrumento SET instrumento_cia=1;
UPDATE estrategias SET pg_estrategia_cia=1;