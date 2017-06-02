SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.60';
UPDATE versao SET ultima_atualizacao_bd='2016-09-11';
UPDATE versao SET ultima_atualizacao_codigo='2016-09-11';
UPDATE versao SET versao_bd=374;





ALTER TABLE custo ADD CONSTRAINT custo_objetivo FOREIGN KEY (custo_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE custo ADD CONSTRAINT custo_fator FOREIGN KEY (custo_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE jornada_excessao ADD CONSTRAINT jornada_excessao_objetivo FOREIGN KEY (jornada_excessao_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE jornada_excessao ADD CONSTRAINT jornada_excessao_fator FOREIGN KEY (jornada_excessao_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE jornada_pertence ADD CONSTRAINT jornada_pertence_objetivo FOREIGN KEY (jornada_pertence_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE jornada_pertence ADD CONSTRAINT jornada_pertence_fator FOREIGN KEY (jornada_pertence_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE ata ADD CONSTRAINT ata_objetivo FOREIGN KEY (ata_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE ata ADD CONSTRAINT ata_fator FOREIGN KEY (ata_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE msg ADD CONSTRAINT msg_objetivo FOREIGN KEY (msg_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE msg ADD CONSTRAINT msg_fator FOREIGN KEY (msg_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE metas ADD CONSTRAINT metas_objetivo FOREIGN KEY (pg_meta_objetivo_estrategico) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE metas ADD CONSTRAINT metas_fator FOREIGN KEY (pg_meta_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE pratica_indicador ADD CONSTRAINT pratica_indicador_objetivo_estrategico FOREIGN KEY (pratica_indicador_objetivo_estrategico) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pratica_indicador ADD CONSTRAINT pratica_indicador_fator FOREIGN KEY (pratica_indicador_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE plano_acao ADD CONSTRAINT plano_acao_objetivo FOREIGN KEY (plano_acao_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE plano_acao ADD CONSTRAINT plano_acao_fator FOREIGN KEY (plano_acao_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE arquivo_pasta ADD CONSTRAINT arquivo_pasta_objetivo FOREIGN KEY (arquivo_pasta_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE arquivo_pasta ADD CONSTRAINT arquivo_pasta_fator FOREIGN KEY (arquivo_pasta_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE arquivo ADD CONSTRAINT arquivo_objetivo FOREIGN KEY (arquivo_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE arquivo ADD CONSTRAINT arquivo_fator FOREIGN KEY (arquivo_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE arquivo_historico ADD CONSTRAINT arquivo_historico_objetivo FOREIGN KEY (arquivo_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE arquivo_historico ADD CONSTRAINT arquivo_historico_fator FOREIGN KEY (arquivo_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE brainstorm_objetivos ADD CONSTRAINT brainstorm_objetivos_objetivo FOREIGN KEY (pg_objetivo_estrategico_id) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE brainstorm_fatores ADD CONSTRAINT brainstorm_fatores_fator FOREIGN KEY (pg_fator_critico_id) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE causa_efeito_objetivos ADD CONSTRAINT causa_efeito_objetivos_objetivo FOREIGN KEY (pg_objetivo_estrategico_id) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE causa_efeito_fatores ADD CONSTRAINT causa_efeito_fatores_fator FOREIGN KEY (pg_fator_critico_id) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE eventos ADD CONSTRAINT evento_objetivo FOREIGN KEY (evento_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE eventos ADD CONSTRAINT evento_fator FOREIGN KEY (evento_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE foruns ADD CONSTRAINT foruns_objetivo FOREIGN KEY (forum_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE foruns ADD CONSTRAINT foruns_fator FOREIGN KEY (forum_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE gut_objetivos ADD CONSTRAINT gut_objetivos_objetivo FOREIGN KEY (pg_objetivo_estrategico_id) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE links ADD CONSTRAINT link_objetivo FOREIGN KEY (link_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE links ADD CONSTRAINT link_fator FOREIGN KEY (link_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE municipio_lista ADD CONSTRAINT municipio_lista_objetivo FOREIGN KEY (municipio_lista_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE municipio_lista ADD CONSTRAINT municipio_lista_fator FOREIGN KEY (municipio_lista_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE projeto_area ADD CONSTRAINT projeto_area_objetivo FOREIGN KEY (projeto_area_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE projeto_area ADD CONSTRAINT projeto_area_fator FOREIGN KEY (projeto_area_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE objetivo_cia ADD CONSTRAINT objetivo_cia_objetivo FOREIGN KEY (objetivo_cia_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE objetivo_perspectiva ADD CONSTRAINT objetivo_perspectiva_objetivo FOREIGN KEY (objetivo_perspectiva_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE fator_objetivo ADD CONSTRAINT fator_objetivo_objetivo FOREIGN KEY (fator_objetivo_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE me_objetivo ADD CONSTRAINT me_objetivo_objetivo FOREIGN KEY (me_objetivo_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE estrategia_fator ADD CONSTRAINT estrategia_fator_fator FOREIGN KEY (estrategia_fator_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE estrategia_fator ADD CONSTRAINT estrategia_fator_objetivo FOREIGN KEY (estrategia_fator_objetivo) REFERENCES objetivo (objetivo_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE estrategias ADD CONSTRAINT estrategias_fator FOREIGN KEY (pg_estrategia_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE fator_objetivo ADD CONSTRAINT fator_objetivo_fator FOREIGN KEY (fator_objetivo_fator) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;
					
ALTER TABLE gut_fatores ADD CONSTRAINT gut_fatores_fator FOREIGN KEY (pg_fator_critico_id) REFERENCES fator (fator_id) ON DELETE CASCADE ON UPDATE CASCADE;