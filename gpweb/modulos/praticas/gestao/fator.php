<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

$direcao = getParam($_REQUEST, 'cmd', '');
$ordem = getParam($_REQUEST, 'ordem', '0');
$fator_id= getParam($_REQUEST, 'fator_id', '0');
$excluirfator_critico=getParam($_REQUEST, 'excluirfator_critico', '0');
$cancelar=getParam($_REQUEST, 'cancelar', '0');
$inserir=getParam($_REQUEST, 'inserir', '0');

echo '<input type="hidden" name="inserir" value="" />';
echo '<input type="hidden" name="cancelar" value="" />';
echo '<input type="hidden" name="cmd" value="" />';
echo '<input type="hidden" name="ordem" value="" />';
echo '<input type="hidden" name="pg_arquivos_id" value="" />';
echo '<input type="hidden" name="fator_id" value="" />';
echo '<input type="hidden" name="excluirfator_critico" value="" />';


//salvar dados na tabela
if ($inserir){
 	
 	//checar se já não existe
 	$sql->adTabela('plano_gestao_fator');
	$sql->adCampo('count(plano_gestao_fator_fator) AS soma');
	$sql->adOnde('plano_gestao_fator_plano_gestao ='.(int)$pg_id);	
 	$sql->adOnde('plano_gestao_fator_fator ='.(int)$fator_id);	
 	$existe=$sql->resultado();
 	$sql->limpar();
 	
 	if (!$existe){
	 	$sql->adTabela('plano_gestao_fator');
		$sql->adCampo('count(plano_gestao_fator_fator) AS soma');
		$sql->adOnde('plano_gestao_fator_plano_gestao ='.(int)$pg_id);	
	  $soma_total = 1+(int)$sql->Resultado();
	  $sql->limpar();
		$sql->adTabela('plano_gestao_fator');
		$sql->adInserir('plano_gestao_fator_plano_gestao', $pg_id);
		$sql->adInserir('plano_gestao_fator_fator', $fator_id);
		$sql->adInserir('plano_gestao_fator_ordem', $soma_total);
		$sql->exec();
		$sql->limpar();
		}
	else ver2('Já existe este fator crítico!');
	}

if ($excluirfator_critico){
	$sql->setExcluir('plano_gestao_fator');
	$sql->adOnde('plano_gestao_fator_fator='.(int)$fator_id);
	$sql->adOnde('plano_gestao_fator_plano_gestao='.(int)$pg_id);
	if (!$sql->exec()) die('Não foi possivel alterar os valores da tabela fator!'.$bd->stderr(true));
	$sql->limpar();	
	}


//ordenar fator_criticoes
if($direcao&&$fator_id) {
		$novo_ui_ordem = $ordem;
		$sql->adTabela('plano_gestao_fator');
		$sql->adOnde('plano_gestao_fator_fator !='.(int)$fator_id);
		$sql->adOnde('plano_gestao_fator_plano_gestao ='.(int)$pg_id);
		$sql->adOrdem('plano_gestao_fator_ordem');
		$fator = $sql->Lista();
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
			$novo_ui_ordem = count($fator) + 1;
			}
		if ($novo_ui_ordem && ($novo_ui_ordem <= count($fator) + 1)) {
			$sql->adTabela('plano_gestao_fator');
			$sql->adAtualizar('plano_gestao_fator_ordem', $novo_ui_ordem);
			$sql->adOnde('plano_gestao_fator_fator ='.(int)$fator_id);
			$sql->adOnde('plano_gestao_fator_plano_gestao ='.(int)$pg_id);
			$sql->exec();
			$sql->limpar();
			$idx = 1;
			foreach ($fator as $acao) {
				if ((int)$idx != (int)$novo_ui_ordem) {
					$sql->adTabela('plano_gestao_fator');
					$sql->adAtualizar('plano_gestao_fator_ordem', $idx);
					$sql->adOnde('plano_gestao_fator_plano_gestao ='.(int)$pg_id);
					$sql->adOnde('plano_gestao_fator_fator ='.(int)$acao['plano_gestao_fator_fator']);
					$sql->exec();
					$sql->limpar();
					$idx++;
					} 
				else {
					$sql->adTabela('plano_gestao_fator');
					$sql->adAtualizar('plano_gestao_fator_ordem', $idx + 1);
					$sql->adOnde('plano_gestao_fator_plano_gestao ='.(int)$pg_id);
					$sql->adOnde('plano_gestao_fator_fator ='.(int)$acao['plano_gestao_fator_fator']);
					$sql->exec();
					$sql->limpar();
					$idx = $idx + 2;
					}
				}		
			}
		}

	


echo '<table width="100%" >';  
echo '<tr><td colspan=2 align="left"><h1>Lista de Fatores Críticos</h1></td></tr>'; 
//fator

if ($editarPG){
	echo '<tr><td colspan=2 align="left"><table cellpadding=0 cellspacing="2"><tr><td><b>Fator Crítico</b></td><td></td></tr>';

	echo '<tr><td><input type="text" name="fator_nome" id="fator_nome" style="width:400px;" class="texto" value=""></td>';
	echo '<td><a href="javascript: void(0);" onclick="popFator();">'.imagem('icones/fator_p.gif','Selecionar '.ucfirst($config['fator']),'Clique neste ícone '.imagem('icones/fator_p.gif').' para selecionar '.($config['genero_fator']=='o' ? 'um' : 'uma').' '.$config['fator'].'.').'</a></td>';
	
	echo '</tr></table></td></tr>';
	}


$sql->adTabela('plano_gestao_fator');
$sql->esqUnir('fator', 'fator', 'plano_gestao_fator_fator=fator.fator_id');
$sql->adCampo('fator_nome, fator_cor, plano_gestao_fator_ordem, fator.fator_id');
$sql->adOnde('plano_gestao_fator_plano_gestao='.(int)$pg_id);
$sql->adOrdem('plano_gestao_fator_ordem ASC');
$fator=$sql->Lista();

if ($fator && count($fator)) echo '<tr><td colspan=2><table class="tbl1" cellspacing=0 cellpadding=0 border=0 width="810"><tr>'.($editarPG ? '<th></th>' : '').'<th>&nbsp;'.(count($fator) >1 ? 'Fatores Críticos':'Fator Crítico').'&nbsp;</th>'.($editarPG ? '<th width="16"></th>' : '').'</tr>';
foreach ($fator as $fator_critico) {
	echo '<tr>';
	if ($editarPG) {
			echo '<td nowrap="nowrap" width="40" align="center">';
			echo dica('Mover para Primeira Posição', 'Clique neste ícone '.imagem('icones/2setacima.gif').' para mover para a primeira posição').'<a href="javascript:void(0);" onclick="javascript:env.ordem.value='.(int)$fator_critico['plano_gestao_fator_ordem'].'; env.fator_id.value='.(int)$fator_critico['fator_id'].'; env.cmd.value=\'moverPrimeiro\' ;env.submit();"><img src="'.acharImagem('icones/2setacima.gif').'" border=0/></a>'.dicaF();
			echo dica('Mover para Cima', 'Clique neste ícone '.imagem('icones/1setacima.gif').' para mover acima').'<a href="javascript:void(0);" onclick="javascript:env.ordem.value='.(int)$fator_critico['plano_gestao_fator_ordem'].'; env.fator_id.value='.(int)$fator_critico['fator_id'].'; env.cmd.value=\'moverParaCima\' ;env.submit();"><img src="'.acharImagem('icones/1setacima.gif').'" border=0/></a>'.dicaF();
			echo dica('Mover para Baixo', 'Clique neste ícone '.imagem('icones/1setabaixo.gif').' para mover abaixo').'<a href="javascript:void(0);" onclick="javascript:env.ordem.value='.(int)$fator_critico['plano_gestao_fator_ordem'].'; env.fator_id.value='.(int)$fator_critico['fator_id'].'; env.cmd.value=\'moverParaBaixo\' ;env.submit();"><img src="'.acharImagem('icones/1setabaixo.gif').'" border=0/></a>'.dicaF();
			echo dica('Mover para a Ultima Posição', 'Clique neste ícone '.imagem('icones/2setabaixo.gif').' para mover para a última posição').'<a href="javascript:void(0);" onclick="javascript:env.ordem.value='.(int)$fator_critico['plano_gestao_fator_ordem'].'; env.fator_id.value='.(int)$fator_critico['fator_id'].'; env.cmd.value=\'moverUltimo\' ;env.submit();"><img src="'.acharImagem('icones/2setabaixo.gif').'" border=0/></a>'.dicaF();
			echo '</td>';
			}
	echo '<td style="background-color: #'.$fator_critico['fator_cor'].'">'.$fator_critico['fator_nome'].'</td>';
	if ($editarPG) echo '<td><a href="javascript: void(0);" onclick="if (confirm(\'Tem certeza que deseja excluir esta fator_critico estratégica?\')) {env.excluirfator_critico.value=1; env.fator_id.value='.(int)$fator_critico['fator_id'].'; env.submit();}">'.imagem('icones/remover.png', 'Excluir Fator Crítico', 'Clique neste ícone '.imagem('icones/remover.png').' para excluir a fator_critico estratégica.').'</a></td>';

	echo '</tr>';
	}
if ($fator && count($fator)) echo '</table></td></tr>';




echo '<tr><td colspan=2 align="center"><table width="100%"><tr><td>'.botao('anterior', 'Anterior', 'Ir para a tela anterior.','','carregar(\'fator_geral\');').'</td><td width="40%">&nbsp;</td><td>&nbsp;</td><td width="40%">&nbsp;</td><td>'.botao('próximo', 'Próximo', 'Ir para a próxima tela.','','carregar(\'estrategias_geral\');').'</td></tr></table></td></tr>';

echo '</table>';
echo '</td></tr></table>';



?>

<script type="text/javascript">
function popFator() {
	if (window.parent.gpwebApp) parent.gpwebApp.popUp('<?php echo ucfirst($config["fator"])?>', 500, 500, 'm=publico&a=selecionar&dialogo=1&chamar_volta=setFator&tabela=fator&cia_id='+document.getElementById('cia_id').value, window.setFator, window);
	else window.open('./index.php?m=publico&a=selecionar&dialogo=1&chamar_volta=setFator&tabela=fator&cia_id='+document.getElementById('cia_id').value, '<?php echo ucfirst($config["fator"])?>','left=0,top=0,height=600,width=600,scrollbars=yes, resizable=yes');
	}		
	
function setFator(chave, valor){
	document.env.fator_id.value = chave;
	document.env.fator_nome.value = valor;
	document.env.inserir.value =1;
	env.submit();
	}	
	
	
function setCor(cor) {
	var f = document.env;
	if (cor) f.fator_cor.value = cor;
	document.getElementById('teste').style.background = '#' + f.fator_cor.value;
	}
</script>