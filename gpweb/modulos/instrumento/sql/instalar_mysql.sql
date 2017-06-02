SET FOREIGN_KEY_CHECKS=0;

DELETE FROM preferencia_modulo WHERE preferencia_modulo_modulo='tr';
INSERT INTO preferencia_modulo (preferencia_modulo_modulo, preferencia_modulo_arquivo, preferencia_modulo_descricao) VALUES 
 ('tr','tr_lista','ucfirst($config[''trs''])');