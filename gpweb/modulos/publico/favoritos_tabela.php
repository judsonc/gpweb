<?php
global $linhas;


echo '<table width="100%" cellpadding=0 cellspacing=0 class="tbl1">';
echo '<tr>';
echo '<th nowrap="nowrap">&nbsp;</th>';
echo '<th nowrap="nowrap">'.dica('Nome', 'Nome para identificação do favorito.').'Nome'.dicaF().'</th>';
echo '</tr>';

foreach ($linhas as $linha) {
	echo '<tr>';
	echo '<td nowrap="nowrap" width="16">'.dica('Editar', 'Clique neste ícone '.imagem('icones/editar.gif').' para editar o favorito.').'<a href="javascript:void(0);" onclick="adicionar('.$linha['favorito_id'].');">'.imagem('icones/editar.gif').'</a>'.dicaF().'</td>';
	echo '<td nowrap="nowrap">'.dica($linha['favorito_nome'], 'Clique para visualizar os detalhes deste favorito.').'<a href="javascript:void(0);" onclick="visualizar('.$linha['favorito_id'].');">'.$linha['favorito_nome'].'</a>'.dicaF().'</td>';	
	echo '</tr>';
	}
if (!count($linhas)) echo '<tr><td colspan=20><p>Nenhum favorito encontrado.</p></td></tr>';
echo '</table>';
?>