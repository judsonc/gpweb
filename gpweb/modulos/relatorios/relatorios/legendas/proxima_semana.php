<?php
global $config, $traducao;

$traducao=array_merge($traducao, array(
'proxima_semana_titulo'=>ucfirst($config['tarefas']).' à concluir',
'proxima_semana_descricao'=>ucfirst($config['tarefas']).' a serem concluíd'.$config['genero_tarefa'].'s nos próximos sete dias',
'proxima_semana_dica'=>'Lista de  '.$config['tarefas'].' previst'.$config['genero_tarefa'].'s para serem concluíd'.$config['genero_tarefa'].'s nos próximos sete dias.'
));
?>