<?php 
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb profissional - registrado no INPI sob o n�mero RS 11802-5 e protegido pelo direito de autor. 
� expressamente proibido utilizar este script em parte ou no todo sem o expresso consentimento do autor.
*/

if (!$Aplic->checarModulo('sistema', 'acesso')) $Aplic->redirecionar('m=publico&a=acesso_negado');

$botoesTitulo = new CBlocoTitulo('Configura��o', 'instrumento.png', $m, $m.'.'.$a);
$botoesTitulo->adicionaBotao('m=sistema&a=vermods', 'voltar','','Voltar','Voltar � tela de administra��o de m�dulos.');
$botoesTitulo->mostrar();

$sql = new BDConsulta();


echo '<form name="env" method="post">';
echo '<input type="hidden" name="m" value="'.$m.'" />';
echo '<input type="hidden" name="a" value="'.$a.'" />';
echo '<input type="hidden" name="gravar" value="1" />';

echo estiloTopoCaixa();
echo '<table width="100%" align="center" class="std" cellspacing=0 cellpadding=0>';
echo '<tr><td>N�o h� configura��es para este m�dulo</td></tr>';
echo '</table>';
echo estiloFundoCaixa();
echo '</form>';
?>