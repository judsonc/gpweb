SET FOREIGN_KEY_CHECKS=0;

UPDATE versao SET versao_codigo='8.4.60';
UPDATE versao SET ultima_atualizacao_bd='2016-09-11';
UPDATE versao SET ultima_atualizacao_codigo='2016-09-11';
UPDATE versao SET versao_bd=373;


ALTER TABLE anotacao_usuarios CHANGE anotacao_usuarios_id anotacao_usuario_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE anotacao_usuarios DROP FOREIGN KEY anotacao_usuarios_fk;
ALTER TABLE anotacao_usuarios DROP FOREIGN KEY anotacao_usuarios_fk1;
ALTER TABLE anotacao_usuarios DROP KEY anotacao_id;
ALTER TABLE anotacao_usuarios DROP KEY usuario_id;
ALTER TABLE anotacao_usuarios CHANGE anotacao_id anotacao_usuario_anotacao INTEGER(100) UNSIGNED NOT NULL;
ALTER TABLE anotacao_usuarios CHANGE usuario_id anotacao_usuario_usuario INTEGER(100) UNSIGNED NOT NULL;
RENAME TABLE anotacao_usuarios TO anotacao_usuario;
ALTER TABLE anotacao_usuario ADD KEY anotacao_usuario_anotacao (anotacao_usuario_anotacao);
ALTER TABLE anotacao_usuario ADD KEY anotacao_usuario_usuario (anotacao_usuario_usuario);
ALTER TABLE anotacao_usuario ADD CONSTRAINT anotacao_usuario_usuario FOREIGN KEY (anotacao_usuario_usuario) REFERENCES usuarios (usuario_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE anotacao_usuario ADD CONSTRAINT anotacao_usuario_anotacao FOREIGN KEY (anotacao_usuario_anotacao) REFERENCES anotacao (anotacao_id) ON DELETE CASCADE ON UPDATE CASCADE;

RENAME TABLE arquivos TO arquivo;