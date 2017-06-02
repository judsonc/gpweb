<?php 
/* Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

if (!defined('BASE_DIR')) die('Voc� n�o deveria acessar este arquivo diretamente.');
global $Aplic, $usuario_id, $tab, $projStatus, $config;


if ($Aplic->profissional){
	require_once BASE_DIR.'/modulos/projetos/funcoes_pro.php';
	}

if(!$usuario_id) $usuario_id=getParam($_REQUEST, 'usuario_id', $Aplic->usuario_id);

$ordenar = getParam($_REQUEST, 'ordenar_projeto', 'projeto_nome');

$ordem = getParam($_REQUEST, 'ordem', '0');
if ($ordem) $ordenar .= ' DESC'; else $ordenar .= ' ASC';
$horas_trabalhadas = ($config['horas_trab_diario'] ? $config['horas_trab_diario'] : 8);
$df = '%d/%m/%Y';
$sql = new BDConsulta;

$sql->adTabela('projetos', 'pr');
$sql->adCampo('concatenar_tres(contatos.contato_posto, \' \', contatos.contato_nomeguerra) AS nome_responsavel');
$sql->adCampo('pr.projeto_id, pr.projeto_nome, pr.projeto_descricao,
             pr.projeto_data_inicio, pr.projeto_data_fim, pr.projeto_status,
             pr.projeto_meta_custo, pr.projeto_prioridade, pr.projeto_cor,
             pr.projeto_responsavel');
$sql->adCampo('contatos.contato_posto, contatos.contato_nomeguerra, contatos.contato_id');
$sql->adCampo('projeto_percentagem, max(tarefas.tarefa_fim) AS projeto_fim_atualizado');
$sql->adCampo('SUM(tarefas.tarefa_id) AS tarefa_log_problema');
$sql->adCampo('COUNT(DISTINCT tarefas.tarefa_id) AS total_tarefas');
$sql->adCampo('COUNT(DISTINCT tarefas.tarefa_id) AS minhas_tarefas ');

$sql->esqUnir('tarefas', '', 'tarefas.tarefa_projeto = pr.projeto_id');
$sql->esqUnir('usuarios', '', 'usuarios.usuario_id = pr.projeto_responsavel');
$sql->esqUnir('contatos', '', 'contatos.contato_id = usuarios.usuario_contato');
$sql->adOnde('pr.projeto_responsavel = '.(int)$usuario_id);
$sql->adGrupo('pr.projeto_id');
$sql->adOrdem($ordenar);
$linhas = $sql->Lista();
$sql->limpar();

echo '<table cellpadding="2" cellspacing=0 border=0 width="100%" class="tbl1">';
$tipos_status = getSisValor('StatusProjeto');
if (!count($linhas)) echo '<tr><td><p>'.($config['genero_projeto']=='o'? 'Nenhum': 'Nenhuma').' '.$config['projeto'].($config['genero_projeto']=='o'? ' encontrado' : ' encontrada').'.</p></td></tr>'.$Aplic->getMsg();
else {
	echo '<tr>';
	echo '<th width=16><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&usuario_id='.$usuario_id.(isset($tab)? '&tab='.$tab : '').'&ordenar_projeto=projeto_cor&ordem='.($ordem ? '0' : '1').'\');">'.dica('Cor', 'Clique para ordenar '.$config['genero_projeto'].'s '.$config['projetos'].' por cor.<br>Para facilitar a visualiza��o d'.$config['genero_projeto'].'s '.$config['projetos'].' � conveniente escolher cores distintas para cada um.').'Cor'.dicaF().'</a></th>';
	echo	'<th><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&usuario_id='.$usuario_id.(isset($tab)? '&tab='.$tab : '').'&ordenar_projeto=projeto_nome&ordem='.($ordem ? '0' : '1').'\');">'. dica('Nome d'.$config['genero_projeto'].' '.ucfirst($config['projeto']), 'Clique para ordenar '.$config['genero_projeto'].'s '.$config['projetos'].' pelo nome d'.$config['genero_projeto'].'s mesm'.$config['genero_projeto'].'s.') .'Nome'.dicaF().'</a></th>';
	echo	'<th><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&usuario_id='.$usuario_id.(isset($tab)? '&tab='.$tab : '').'&ordenar_projeto=projeto_percentagem&ordem='.($ordem ? '0' : '1').'\');">'. dica('F�sico Executado', 'Clique para ordenar '.$config['genero_projeto'].'s '.$config['projetos'].' pelo f�sico executado.').'%'.dicaF().'</a></th>';
	echo '<th><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&usuario_id='.$usuario_id.(isset($tab)? '&tab='.$tab : '').'&ordenar_projeto=projeto_prioridade&ordem='.($ordem ? '0' : '1').'\');">'. dica('Prioridade', 'Clique para ordenar '.$config['genero_projeto'].'s '.$config['projetos'].' pelo n�vel de prioridade<br><br>H� cinco n�veis de prioridades:</p><ul><li>'.imagem('icones/prioridade+2.gif').' - a mais alta preced�ncia.</li><li>'.imagem('icones/prioridade+1.gif').' - alta preced�ncia.</li><li>'.imagem('icones/prioridade0.gif').' - '.$config['projetos'].' rotineir'.$config['genero_projeto'].'s, normalmente os que n�o tem sucessoras.</li><li>'.imagem('icones/prioridade-1.gif').' - '.$config['projetos'].' rotineir'.$config['genero_projeto'].'s que n�o tenham um impacto significativo nos planos e metas.</li><li>'.imagem('icones/prioridade-2.gif').' - '.$config['projetos'].' que n�o tenham impacto nos planos e metas.</li></ul>').'P'.dicaF().'</a></th>';
	echo '<th>'.dica(ucfirst($config['departamento']), strtoupper($config['genero_dept']).' '.$config['departamento'].' respons�vel pel'.$config['genero_projeto'].' '.$config['projeto'].'.').$config['dept'].dicaF().'</th>';
	echo '<th><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&usuario_id='.$usuario_id.(isset($tab)? '&tab='.$tab : '').'&ordenar_projeto=projeto_data_inicio&ordem='.($ordem ? '0' : '1').'\');">'.dica('Data de In�cio', 'Clique para ordenar '.$config['genero_projeto'].'s '.$config['projetos'].' pela data de in�cio d'.$config['genero_projeto'].'s mesm'.$config['genero_projeto'].'s.').'In�cio'.dicaF().'</a></th>';
	echo '<th><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&usuario_id='.$usuario_id.(isset($tab)? '&tab='.$tab : '').'&ordenar_projeto=projeto_data_fim&ordem='.($ordem ? '0' : '1').'\');">'. dica('T�rmino', 'Clique para ordenar '.$config['genero_projeto'].'s '.$config['projetos'].' pela data de t�rmino.').'T�rmino'.dicaF().'</a></th>';
	echo '<th><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&usuario_id='.$usuario_id.(isset($tab)? '&tab='.$tab : '').'&ordenar_projeto=projeto_fim_atualizado&ordem='.($ordem ? '0' : '1').'\');">'. dica('Prov�vel T�rmino', 'Clique para ordenar '.$config['genero_projeto'].'s '.$config['projetos'].' pela data de t�rmino calculada com base n'.$config['genero_tarefa'].'s '.$config['tarefas'].'.').'Prov�vel'.dicaF().'</a></th>';
	if ($Aplic->profissional) echo '<th>'. dica('Registros de Problemas', 'Registros de problemas '.$config['genero_projeto'].'s '.$config['projetos'].'.').'RP'.dicaF().'</a></th>';
	echo '<th><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&usuario_id='.$usuario_id.(isset($tab)? '&tab='.$tab : '').'&ordenar_projeto=total_tarefas&ordem='.($ordem ? '0' : '1').'\');">'.dica(ucfirst($config['tarefas']), 'Clique para ordenar '.$config['genero_projeto'].'s '.$config['projetos'].' pela quantidade de  '.$config['tarefas'].'.').'T'.dicaF().'</a><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&usuario_id='.$usuario_id.(isset($tab)? '&tab='.$tab : '').'&ordenar=minhas_tarefas&ordem='.($ordem ? '0' : '1').'\');">'.dica('Minhas '.ucfirst($config['tarefa']), 'Clique para ordenar '.$config['genero_projeto'].'s '.$config['projetos'].' pela quantidade de  '.$config['tarefas'].' designadas para mim.').' M'.dicaF().'</a></th>';
	echo '<th><a class="hdr" href="javascript:void(0);" onclick="url_passar(0, \'m='.$m.'&a='.$a.'&usuario_id='.$usuario_id.(isset($tab)? '&tab='.$tab : '').'&ordenar_projeto=projeto_status&ordem='.($ordem ? '0' : '1').'\');">'.dica('Status d'.$config['genero_projeto'].' '.ucfirst($config['projeto']), 'Clique para ordenar '.$config['genero_projeto'].'s '.$config['projetos'].' pelo status d'.$config['genero_projeto'].'s mesm'.$config['genero_projeto'].'s.<br><br>O Status d'.$config['genero_projeto'].' '.$config['projeto'].', que pode ser: <ul><li>N�o definido - caso em que ainda n�o h� muitos dados concretos sobre o mesmo, ou que ainda n�o tem um respons�vel efetivo.</li><li>Proposto - quando j� tem um respons�vel efetivo definido, porem n�o iniciou ainda os trabalhos.</li><li>Em Planejamento - quando n�o foi iniciado nenhum'.($config['genero_tarefa']=='a' ?  'a' : '').' '.$config['tarefa'].', porem a equipe designada j� est�o realizando trabalhos preprat�rios</li><li>Em andamento - quando est� em execu��o, com ao menos algum'.($config['genero_tarefa']=='a' ?  'a' : '').' '.$config['tarefa'].' com mais de 0% realizado e que n�o esteja em <b>espera</b>.</li><li>Em Espera - quando '.$config['genero_projeto'].' '.$config['projeto'].' iniciou, mas por algum motivo incontra-se interrompido. A interrup��o pode ser permanente ou provis�ria.</li><li>Completado - quando todas '.$config['genero_tarefa'].'s '.$config['tarefas'].' '.($config['genero_projeto']=='o' ? 'deste' : 'desta').' '.$config['projeto'].' atingiram 100% executadas.</li><li>Modelo - quando '.$config['genero_projeto'].' '.$config['projeto'].' e su'.$config['genero_tarefa'].'s '.$config['tarefas'].' sirvam apenas de refer�ncia, para outr'.$config['genero_projeto'].'s '.$config['projetos'].', n�o sendo um '.$config['projeto'].' real.</li></ul>.').'Status'.dicaF().'</a></th>';
	foreach ($linhas as $linha) {
		$data_inicio = new CData($linha['projeto_data_inicio']);
		
		
		$vetor_projetos=array($linha['projeto_id'] => $linha['projeto_id']);
		if ($Aplic->profissional){
			portfolio_projetos($linha['projeto_id'], $vetor_projetos);
			}
		$vetor_projetos=implode(',',$vetor_projetos);
		
		
		echo '<tr>';
		echo '<td width="15"  style="background-color:#'.$linha['projeto_cor'].'"><font color="'.melhorCor($linha['projeto_cor']).'">&nbsp;&nbsp;</font></td>';
		echo '<td width="150">';
		$sql->adTabela('projetos');
		$sql->adCampo('COUNT(projeto_id)');
		$sql->adOnde('projeto_superior_original = '.(int)$linha['projeto_id']);
		$quantidade_projetos = $sql->Resultado();
		$sql->limpar();
		
		if (isset($nivel) && $nivel) echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', ($nivel - 1)) .'<img src="'.acharImagem('subnivel.gif').'" width="16" height="12" border=0>&nbsp;'.link_projeto($linha["projeto_id"]);
		elseif ($quantidade_projetos > 1 && (!isset($nivel)|| (isset($nivel) && !$nivel))) echo dica(ucfirst($config['projeto']).' superior de um multi-'.$config['projeto'], ($config['genero_projeto']=='o'? 'Este' : 'Esta').' '.$config['projeto'].' � '.$config['genero_projeto'].' principal de uma estrutura multi-'.$config['projeto'].'<br />clique para mostrar/esconder seus sub-projetos.').'<a href="javascript: void(0);" onclick="expandir_colapsar(\'multiprojeto_tr_'.$linha["projeto_id"].'_\', \'tblProjetos\')"><img id="multiprojeto_tr_'.$linha["projeto_id"].'__expandir" src="'.acharImagem('icones/expandir.gif').'" width="12" height="12" border=0><img id="multiprojeto_tr_'.$linha["projeto_id"].'__colapsar" src="'.acharImagem('icones/colapsar.gif').'" width="12" height="12" border=0 style="display:none"></a>&nbsp;'.link_projeto($linha["projeto_id"], 'cor').dicaF();
		else echo link_projeto($linha["projeto_id"]);
		echo '</td>';
		echo '<td width="45" align="right">'.sprintf('%.1f%%', $linha['projeto_percentagem']).'</td>';
		echo '<td align="center">'.prioridade($linha['projeto_prioridade']).'</td>';
		$sql->adTabela('depts', 'a');
		$sql->adTabela('projeto_depts', 'b');
		$sql->adCampo('a.dept_id, a.dept_nome, a.dept_tel, a.dept_fax, a.dept_endereco1, a.dept_endereco2, a.dept_cidade, a.dept_estado, a.dept_pais, a.dept_email, a.dept_descricao');
		$sql->adOnde('a.dept_id = b.departamento_id and b.projeto_id = '.(int)$linha['projeto_id']);
		$depts = $sql->ListaChave('dept_id');
		$sql->limpar();
		echo '<td nowrap="nowrap" align="center">';
		if (!count($depts)) $s.= '&nbsp;';
		foreach ($depts as $dept_id => $dept_info) {
			echo link_secao($dept_info['dept_id']);
			}
		$data_inicio = intval($linha['projeto_data_inicio']) ? new CData($linha['projeto_data_inicio']) : null;
		$data_fim = intval($linha['projeto_data_fim']) ? new CData($linha['projeto_data_fim']) : null;
		$data_fim_atual = intval($linha['projeto_fim_atualizado']) ? new CData($linha['projeto_fim_atualizado']) : null;
		$estilo = (($data_fim_atual > $data_fim) && !empty($data_fim)) ? 'style="color:red; font-weight:bold"' : '';	
		
		echo '</td>';
		echo '<td nowrap="nowrap" align="center">'.($data_inicio ? $data_inicio->format($df) : '&nbsp;').'</td>';
		echo '<td nowrap="nowrap" align="center">'.($data_fim ? $data_fim->format($df) : '&nbsp;').'</td>';
		echo '<td nowrap="nowrap" align="center">'.($data_fim_atual ? dica('Data Calculada', 'Clique para visualizar quais '.$config['tarefas'].' est�o alterando a data final.').'<a href="javascript:void(0);" onclick="url_passar(0, \'m=tarefas&a=ver&tarefa_id='.(isset($linha['critica_tarefa']) ? $linha['critica_tarefa'] :'').'\');"><span '.$estilo.'>'.$data_fim_atual->format($df).'</span></a>'.dicaF() : '&nbsp;').'</td>';
		if ($Aplic->profissional){
			$sql->adTabela('tarefa_log');
			$sql->esqUnir('tarefas','tarefas','tarefa_log.tarefa_log_tarefa=tarefas.tarefa_id');
			$sql->adCampo('COUNT(distinct tarefa_log_id)');
			$sql->adOnde('tarefa_projeto IN ('.$vetor_projetos.')');
			$sql->adOnde('tarefa_projetoex_id IS NULL');
			$sql->adOnde('tarefa_log_problema=1');
			$tarefa_log_problema=$sql->Resultado();
			$sql->limpar();
			
			echo '<td align="center">'.($tarefa_log_problema ? '<a href="javascript:void(0);" onclick="url_passar(0, \'m=projetos&a=ver&tab=2&projeto_id='.$linha['projeto_id'].'\');">'.imagem('icones/aviso.gif', 'Problema', 'Foi registrado ao menos um problema em uma d'.$config['genero_tarefa'].'s '.$config['tarefas'].'. Clique para ver os registros.').'</a>' : '&nbsp;').'</td>';
			}
		echo '<td align="center" nowrap="nowrap">'.$linha['total_tarefas'].($linha['minhas_tarefas'] ? ' ('.$linha['minhas_tarefas'].')' : '').'</td>';
		echo '<td align="center" nowrap="nowrap">'.($linha['projeto_status'] ? $tipos_status[$linha['projeto_status']] : 'N�o definido').'</td>';
		echo '</tr>';
		}
	}
	
echo '</table>';
?>