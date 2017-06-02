SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.60';
UPDATE versao SET ultima_atualizacao_bd='2016-08-29';
UPDATE versao SET ultima_atualizacao_codigo='2016-08-29';
UPDATE versao SET versao_bd=369;

ALTER TABLE agenda ADD COLUMN agenda_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE agenda ADD KEY agenda_moeda (agenda_moeda);
ALTER TABLE agenda ADD CONSTRAINT agenda_moeda FOREIGN KEY (agenda_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 




ALTER TABLE arquivos ADD COLUMN arquivo_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE arquivos ADD KEY arquivo_moeda (arquivo_moeda);
ALTER TABLE arquivos ADD CONSTRAINT arquivo_moeda FOREIGN KEY (arquivo_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE ata ADD COLUMN ata_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE ata ADD KEY ata_moeda (ata_moeda);
ALTER TABLE ata ADD CONSTRAINT ata_moeda FOREIGN KEY (ata_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE avaliacao ADD COLUMN avaliacao_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE avaliacao ADD KEY avaliacao_moeda (avaliacao_moeda);
ALTER TABLE avaliacao ADD CONSTRAINT avaliacao_moeda FOREIGN KEY (avaliacao_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE brainstorm ADD COLUMN brainstorm_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE brainstorm ADD KEY brainstorm_moeda (brainstorm_moeda);
ALTER TABLE brainstorm ADD CONSTRAINT brainstorm_moeda FOREIGN KEY (brainstorm_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE calendario ADD COLUMN calendario_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE calendario ADD KEY calendario_moeda (calendario_moeda);
ALTER TABLE calendario ADD CONSTRAINT calendario_moeda FOREIGN KEY (calendario_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE causa_efeito ADD COLUMN causa_efeito_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE causa_efeito ADD KEY causa_efeito_moeda (causa_efeito_moeda);
ALTER TABLE causa_efeito ADD CONSTRAINT causa_efeito_moeda FOREIGN KEY (causa_efeito_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE checklist ADD COLUMN checklist_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE checklist ADD KEY checklist_moeda (checklist_moeda);
ALTER TABLE checklist ADD CONSTRAINT checklist_moeda FOREIGN KEY (checklist_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE estrategias ADD COLUMN pg_estrategia_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE estrategias ADD KEY pg_estrategia_moeda (pg_estrategia_moeda);
ALTER TABLE estrategias ADD CONSTRAINT pg_estrategia_moeda FOREIGN KEY (pg_estrategia_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE eventos ADD COLUMN evento_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE eventos ADD KEY evento_moeda (evento_moeda);
ALTER TABLE eventos ADD CONSTRAINT evento_moeda FOREIGN KEY (evento_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE fatores_criticos ADD COLUMN pg_fator_critico_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE fatores_criticos ADD KEY pg_fator_critico_moeda (pg_fator_critico_moeda);
ALTER TABLE fatores_criticos ADD CONSTRAINT pg_fator_critico_moeda FOREIGN KEY (pg_fator_critico_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE foruns ADD COLUMN forum_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE foruns ADD KEY forum_moeda (forum_moeda);
ALTER TABLE foruns ADD CONSTRAINT forum_moeda FOREIGN KEY (forum_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE gut ADD COLUMN gut_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE gut ADD KEY gut_moeda (gut_moeda);
ALTER TABLE gut ADD CONSTRAINT gut_moeda FOREIGN KEY (gut_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE pratica_indicador ADD COLUMN pratica_indicador_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE pratica_indicador ADD KEY pratica_indicador_moeda (pratica_indicador_moeda);
ALTER TABLE pratica_indicador ADD CONSTRAINT pratica_indicador_moeda FOREIGN KEY (pratica_indicador_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE instrumento ADD COLUMN instrumento_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE instrumento ADD KEY instrumento_moeda (instrumento_moeda);
ALTER TABLE instrumento ADD CONSTRAINT instrumento_moeda FOREIGN KEY (instrumento_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE licao ADD COLUMN licao_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE licao ADD KEY licao_moeda (licao_moeda);
ALTER TABLE licao ADD CONSTRAINT licao_moeda FOREIGN KEY (licao_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE links ADD COLUMN link_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE links ADD KEY link_moeda (link_moeda);
ALTER TABLE links ADD CONSTRAINT link_moeda FOREIGN KEY (link_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE me ADD COLUMN me_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE me ADD KEY me_moeda (me_moeda);
ALTER TABLE me ADD CONSTRAINT me_moeda FOREIGN KEY (me_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE metas ADD COLUMN pg_meta_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE metas ADD KEY pg_meta_moeda (pg_meta_moeda);
ALTER TABLE metas ADD CONSTRAINT pg_meta_moeda FOREIGN KEY (pg_meta_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE;
 
ALTER TABLE mswot ADD COLUMN mswot_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE mswot ADD KEY mswot_moeda (mswot_moeda);
ALTER TABLE mswot ADD CONSTRAINT mswot_moeda FOREIGN KEY (mswot_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE objetivos_estrategicos ADD COLUMN pg_objetivo_estrategico_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE objetivos_estrategicos ADD KEY pg_objetivo_estrategico_moeda (pg_objetivo_estrategico_moeda);
ALTER TABLE objetivos_estrategicos ADD CONSTRAINT pg_objetivo_estrategico_moeda FOREIGN KEY (pg_objetivo_estrategico_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 
 

ALTER TABLE perspectivas ADD COLUMN pg_perspectiva_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE perspectivas ADD KEY pg_perspectiva_moeda (pg_perspectiva_moeda);
ALTER TABLE perspectivas ADD CONSTRAINT pg_perspectiva_moeda FOREIGN KEY (pg_perspectiva_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

ALTER TABLE praticas ADD COLUMN pratica_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE praticas ADD KEY pratica_moeda (pratica_moeda);
ALTER TABLE praticas ADD CONSTRAINT pratica_moeda FOREIGN KEY (pratica_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 
 

ALTER TABLE recursos ADD COLUMN recurso_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE recursos ADD KEY recurso_moeda (recurso_moeda);
ALTER TABLE recursos ADD CONSTRAINT recurso_moeda FOREIGN KEY (recurso_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 


ALTER TABLE tema ADD COLUMN tema_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE tema ADD KEY tema_moeda (tema_moeda);
ALTER TABLE tema ADD CONSTRAINT tema_moeda FOREIGN KEY (tema_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 
 
ALTER TABLE template ADD COLUMN template_moeda INTEGER(100) UNSIGNED DEFAULT 1; 
ALTER TABLE template ADD KEY template_moeda (template_moeda);
ALTER TABLE template ADD CONSTRAINT template_moeda FOREIGN KEY (template_moeda) REFERENCES moeda (moeda_id) ON DELETE SET NULL ON UPDATE CASCADE; 

