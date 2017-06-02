<?php
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


$direcao = getParam($_REQUEST, 'cmd', '');
$ordem = getParam($_REQUEST, 'ordem', '0');
$objetivo_id= getParam($_REQUEST, 'objetivo_id', '0');
$excluirobjetivo_estrategico=getParam($_REQUEST, 'excluirobjetivo_estrategico', '0');
$cancelar=getParam($_REQUEST, 'cancelar', '0');
$inserir=getParam($_REQUEST, 'inserir', '0');

echo '<input type="hidden" name="inserir" value="" />';
echo '<input type="hidden" name="cancelar" value="" />';
echo '<input type="hidden" name="cmd" value="" />';
echo '<input type="hidden" name="ordem" value="" />';
echo '<input type="hidden" name="pg_arquivos_id" value="" />';
echo '<input type="hidden" name="objetivo_id" value="" />';
echo '<input type="hidden" name="excluirobjetivo_estrategico" value="" />';


//salvar dados na tabela
if ($inserir){
 	
 	//checar se j� n�o existe
 	$sql->adTabela('plano_gestao_objetivo');
	$sql->adCampo('count(plano_gestao_objetivo_objetivo) AS soma');
	$sql->adOnde('plano_gestao_objetivo_plano_gestao ='.(int)$pg_id);	
 	$sql->adOnde('plano_gestao_objetivo_objetivo ='.(int)$objetivo_id);	
 	$existe=$sql->resultado();
 	$sql->limpar();
 	
 	if (!$existe){
	 	$sql->adTabela('plano_gestao_objetivo');
		$sql->adCampo('count(plano_gestao_objetivo_objetivo) AS soma');
		$sql->adOnde('plano_gestao_objetivo_plano_gestao ='.(int)$pg_id);	
	  $soma_total = 1+(int)$sql->Resultado();
	  $sql->limpar();
		$sql->adTabela('plano_gestao_objetivo');
		$sql->adInserir('plano_gestao_objetivo_plano_gestao', $pg_id);
		$sql->adInserir('plano_gestao_objetivo_objetivo', $objetivo_id);
		$sql->adInserir('plano_gestao_objetivo_ordem', $soma_total);
		$sql->exec();
		$objetivo_id=$bd->Insert_ID('plano_gestao_objetivo','plano_gestao_objetivo_objetivo');
		$sql->limpar();
		}
	else ver2('J� existe esta objetivo_estrategico estrat�gica!');
	}

if ($excluirobjetivo_estrategico){
	$sql->setExcluir('plano_gestao_objetivo');
	$sql->adOnde('plano_gestao_objetivo_objetivo='.(int)$objetivo_id);
	$sql->adOnde('plano_gestao_objetivo_plano_gestao='.(int)$pg_id);
	if (!$sql->exec()) die('N�o foi possivel alterar os valores da tabela objetivo!'.$bd->stderr(true));
	$sql->limpar();	
	}


//ordenar objetivo_estrategicoes
if($direcao&&$objetivo_id) {
		$novo_ui_ordem = $ordem;
		$sql->adTabela('plano_gestao_objetivo');
		$sql->adOnde('plano_gestao_objetivo_objetivo !='.(int)$objetivo_id);
		$sql->adOnde('plano_gestao_objetivo_plano_gestao ='.(int)$pg_id);
		$sql->adOrdem('plano_gestao_objetivo_ordem');
		$objetivo = $sql->Lista();
		$sql->limpar();
		
		if ($direcao == 'moverParaCima') {
			$outro_novo = $novo_ui_ordem;
			$novo_ui_ordem--;
			} 
		elseif ($direcao == 'moverParaBaixo') {
			$outro_novo = $novo_ui_ordem;
			$novo_ui_ordem++;
			} 
		elseif ($direcao == 'moverPrimeiro') {
			$outro_novo = $novo_ui_ordem;
			$novo_ui_ordem = 1;
			} 
		elseif ($direcao == 'moverUltimo') {
			$outro_novo = $novo_ui_ordem;
			$novo_ui_ordem = count($objetivo) + 1;
			}
		if ($novo_ui_ordem && ($novo_ui_ordem <= count($objetivo) + 1)) {
			$sql->adTabela('plano_gestao_objetivo');
			$sql->adAtualizar('plano_gestao_objetivo_ordem', $novo_ui_ordem);
			$sql->adOnde('plano_gestao_objetivo_objetivo ='.(int)$objetivo_id);
			$sql->adOnde('plano_gestao_objetivo_plano_gestao ='.(int)$pg_id);
			$sql->exec();
			$sql->limpar();
			$idx = 1;
			foreach ($objetivo as $acao) {
				if ((int)$idx != (int)$novo_ui_ordem) {
					$sql->adTabela('plano_gestao_objetivo');
					$sql->adAtualizar('plano_gestao_objetivo_ordem', $idx);
					$sql->adOnde('plano_gestao_objetivo_plano_gestao ='.(int)$pg_id);
					$sql->adOnde('plano_gestao_objetivo_objetivo ='.(int)$acao['plano_gestao_objetivo_objetivo']);
					$sql->exec();
					$sql->limpar();
					$idx++;
					} 
				else {
					$sql->adTabela('plano_gestao_objetivo');
					$sql->adAtualizar('plano_gestao_objetivo_ordem', $idx + 1);
					$sql->adOnde('plano_gestao_objetivo_plano_gestao ='.(int)$pg_id);
					$sql->adOnde('plano_gestao_objetivo_objetivo ='.(int)$acao['plano_gestao_objetivo_objetivo']);
					$sql->exec();
					$sql->limpar();
					$idx = $idx + 2;
					}
				}		
			}
		}

	


echo '<table width="100%" >';  
echo '<tr><td colspan=2 align="left"><h1>Lista de '.ucfirst($config['objetivos']).'</h1></td></tr>'; 
//objetivo

if ($editarPG){
	echo '<tr><td colspan=2 align="left"><table cellpadding=0 cellspacing="2"><tr><td><b>'.ucfirst($config['objetivo']).'</b></td><td></td></tr>';

	echo '<tr><td><input type="text" name="objetivo_nome" id="objetivo_nome" style="width:400px;" class="texto" value=""></td>';
	echo '<td><a href="javascript: void(0);" onclick="popObjetivo();">'.imagem('icones/obj_estrategicos_p.gif','Selecionar '.ucfirst($config['objetivo']).'','Clique neste �cone '.imagem('icones/obj_estrategicos_p.gif').' para selecionar '.($config['genero_objetivo']=='o' ? 'um' : 'uma').' '.$config['objetivo'].'.').'</a></td>';
	
	echo '</tr></table></td></tr>';
	}


$sql->adTabela('plano_gestao_objetivo');
$sql->esqUnir('objetivo', 'objetivo', 'plano_gestao_objetivo_objetivo=objetivo.objetivo_id');
$sql->adCampo('objetivo_nome, objetivo_cor, plano_gestao_objetivo_ordem, objetivo.objetivo_id');
$sql->adOnde('plano_gestao_objetivo_plano_gestao='.(int)$pg_id);
$sql->adOrdem('plano_gestao_objetivo_ordem ASC');
$objetivo=$sql->Lista();

if ($objetivo && count($objetivo)) echo '<tr><td colspan=2><table class="tbl1" cellspacing=0 cellpadding=0 border=0 width="810"><tr>'.($editarPG ? '<th></th>' : '').'<th>&nbsp;'.(count($objetivo) >1 ? ucfirst($config['objetivos']):ucfirst($config['objetivo'])).'&nbsp;</th>'.($editarPG ? '<th width="16"></th>' : '').'</tr>';
foreach ($objetivo as $objetivo_estrategico) {
	echo '<tr>';
	if ($editarPG) {
			echo '<td nowrap="nowrap" width="40" align="center">';
			echo dica('Mover para Primeira Posi��o', 'Clique neste �cone '.imagem('icones/2setacima.gif').' para mover para a primeira posi��o').'<a href="javascript:void(0);" onclick="javascript:env.ordem.value='.(int)$objetivo_estrategico['plano_gestao_objetivo_ordem'].'; env.objetivo_id.value='.(int)$objetivo_estrategico['objetivo_id'].'; env.cmd.value=\'moverPrimeiro\' ;env.submit();"><img src="'.acharImagem('icones/2setacima.gif').'" border=0/></a>'.dicaF();
			echo dica('Mover para Cima', 'Clique neste �cone '.imagem('icones/1setacima.gif').' para mover acima').'<a href="javascript:void(0);" onclick="javascript:env.ordem.value='.(int)$objetivo_estrategico['plano_gestao_objetivo_ordem'].'; env.objetivo_id.value='.(int)$objetivo_estrategico['objetivo_id'].'; env.cmd.value=\'moverParaCima\' ;env.submit();"><img src="'.acharImagem('icones/1setacima.gif').'" border=0/></a>'.dicaF();
			echo dica('Mover para Baixo', 'Clique neste �cone '.imagem('icones/1setabaixo.gif').' para mover abaixo').'<a href="javascript:void(0);" onclick="javascript:env.ordem.value='.(int)$objetivo_estrategico['plano_gestao_objetivo_ordem'].'; env.objetivo_id.value='.(int)$objetivo_estrategico['objetivo_id'].'; env.cmd.value=\'moverParaBaixo\' ;env.submit();"><img src="'.acharImagem('icones/1setabaixo.gif').'" border=0/></a>'.dicaF();
			echo dica('Mover para a Ultima Posi��o', 'Clique neste �cone '.imagem('icones/2setabaixo.gif').' para mover para a �ltima posi��o').'<a href="javascript:void(0);" onclick="javascript:env.ordem.value='.(int)$objetivo_estrategico['plano_gestao_objetivo_ordem'].'; env.objetivo_id.value='.(int)$objetivo_estrategico['objetivo_id'].'; env.cmd.value=\'moverUltimo\' ;env.submit();"><img src="'.acharImagem('icones/2setabaixo.gif').'" border=0/></a>'.dicaF();
			echo '</td>';
			}
	echo '<td style="background-color: #'.$objetivo_estrategico['objetivo_cor'].'">'.$objetivo_estrategico['objetivo_nome'].'</td>';
	if ($editarPG) echo '<td><a href="javascript: void(0);" onclick="if (confirm(\'Tem certeza que deseja excluir esta objetivo_estrategico estrat�gica?\')) {env.excluirobjetivo_estrategico.value=1; env.objetivo_id.value='.(int)$objetivo_estrategico['objetivo_id'].'; env.submit();}">'.imagem('icones/remover.png', 'Excluir '.ucfirst($config['objetivo']).'', 'Clique neste �cone '.imagem('icones/remover.png').' para excluir a objetivo_estrategico estrat�gica.').'</a></td>';

	echo '</tr>';
	}
if ($objetivo && count($objetivo)) echo '</table></td></tr>';




echo '<tr><td colspan=2 align="center"><table width="100%"><tr><td>'.botao('anterior', 'Anterior', 'Ir para a tela anterior.','','carregar(\'objetivo_geral\');').'</td><td width="40%">&nbsp;</td><td>&nbsp;</td><td width="40%">&nbsp;</td><td>'.botao('pr�ximo', 'Pr�ximo', 'Ir para a pr�xima tela.','','carregar(\''.($Aplic->profissional && $config['exibe_me']  && $Aplic->checarModulo('praticas', 'acesso', null, 'me') ? 'mes_pro' : (!$Aplic->profissional || ($Aplic->profissional && $Aplic->profissional && $config['exibe_fator'] && $Aplic->checarModulo('praticas', 'acesso', null, 'fator')) ? 'fator_geral' : 'estrategias_geral')).'\');').'</td></tr></table></td></tr>';

echo '</table>';
echo '</td></tr></table>';



?>

<script type="text/javascript">
	
function popObjetivo() {
	if (window.parent.gpwebApp) parent.gpwebApp.popUp('<?php echo ucfirst($config["objetivo"])?>', 500, 500, 'm=publico&a=selecionar&dialogo=1&chamar_volta=setObjetivo&tabela=objetivo&cia_id='+document.getElementById('cia_id').value, window.setObjetivo, window);
	else window.open('./index.php?m=publico&a=selecionar&dialogo=1&chamar_volta=setObjetivo&tabela=objetivo&cia_id='+document.getElementById('cia_id').value, 'Objetivo','left=0,top=0,height=600,width=600,scrollbars=yes, resizable=yes');
	}		
	
function setObjetivo(chave, valor){
	document.env.objetivo_id.value = chave;
	document.env.objetivo_nome.value = valor;
	document.env.inserir.value =1;
	env.submit();
	}	
	
	
function setCor(cor) {
	var f = document.env;
	if (cor) f.objetivo_cor.value = cor;
	document.getElementById('teste').style.background = '#' + f.objetivo_cor.value;
	}
</script>