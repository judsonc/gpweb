<?php
global $config, $traducao;

$traducao=array_merge($traducao, array(
'proxima_semana_titulo'=>ucfirst($config['tarefas']).' � concluir',
'proxima_semana_descricao'=>ucfirst($config['tarefas']).' a serem conclu�d'.$config['genero_tarefa'].'s nos pr�ximos sete dias',
'proxima_semana_dica'=>'Lista de  '.$config['tarefas'].' previst'.$config['genero_tarefa'].'s para serem conclu�d'.$config['genero_tarefa'].'s nos pr�ximos sete dias.'
));
?>