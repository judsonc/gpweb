<?php
global $config, $traducao;

$traducao=array_merge($traducao, array(
'geral_titulo'=>'Total de horas',
'geral_descricao'=>'Permite uma vis�o geral sobre as horas trabalhadas n'.$config['genero_projeto'].'s '.$config['projetos'],
'geral_dica'=>'Este relat�rio mostra o n�mero total de horas gasto n'.$config['genero_tarefa'].'s '.$config['tarefas'].' d'.$config['genero_projeto'].'s '.$config['projetos']
));
?>