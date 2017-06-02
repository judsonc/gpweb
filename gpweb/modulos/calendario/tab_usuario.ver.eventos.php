<?php 
/* 
Copyright (c) 2007-2011 The web2Project Development Team <w2p-developers@web2project.net>
Copyright (c) 2003-2007 The dotProject Development Team <core-developers@dotproject.net>
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');

global $Aplic, $projeto_id, $negar, $podeAcessar, $podeEditar, $config, $data_inicio, $data_fim, $este_dia, $evento_filtro, $evento_filtro_lista, $usuario_id;
require_once $Aplic->getClasseModulo('calendario');


if ($Aplic->profissional){
  if ($Aplic->profissional) require_once BASE_DIR.'/modulos/projetos/template_pro.class.php';
	$ata_ativo=$Aplic->modulo_ativo('atas');
	if ($ata_ativo) require_once BASE_DIR.'/modulos/atas/funcoes.php';
	$swot_ativo=$Aplic->modulo_ativo('swot');
	if ($swot_ativo) {
		require_once BASE_DIR.'/modulos/swot/swot.class.php';
		require_once BASE_DIR.'/modulos/swot/mswot.class.php';
		}
	$operativo_ativo=$Aplic->modulo_ativo('operativo');
	if ($operativo_ativo) require_once BASE_DIR.'/modulos/operativo/funcoes.php';
	$problema_ativo=$Aplic->modulo_ativo('problema');
	if ($problema_ativo) require_once BASE_DIR.'/modulos/problema/funcoes.php';
	$agrupamento_ativo=$Aplic->modulo_ativo('agrupamento');
	if($agrupamento_ativo) require_once BASE_DIR.'/modulos/agrupamento/funcoes.php';
	$patrocinador_ativo=$Aplic->modulo_ativo('patrocinadores');
	if($patrocinador_ativo) require_once BASE_DIR.'/modulos/patrocinadores/patrocinadores.class.php';
	}



if(!$usuario_id) $usuario_id=getParam($_REQUEST, 'usuario_id', $Aplic->usuario_id);
$data_inicio =  new CData();
$data_fim =  new CData('9999-12-31 23:59:59');
if (isset($_REQUEST['usuario_id']))$usuario_id = getParam($_REQUEST, 'usuario_id', '');
$eventos = CEvento::getEventoParaPeriodo($data_inicio, $data_fim, ($evento_filtro ? $evento_filtro : 'todos'), $usuario_id);

$tipos = getSisValor('TipoEvento');
echo '<table cellspacing=0 cellpadding="2" border=0 width="100%" class="tbl1">';
echo '<tr><th>'.dica('Data - Hora', 'A data e hora do início e término do evento.').'Data'.dicaF().'</th>';
echo '<th>'.dica('Tipo', 'O tipo de evento.').'Tipo'.dicaF().'</th><th>'.dica('Evento', 'O nome do evento.').'Evento'.dicaF().'</th>';
if ($Aplic->profissional)echo '<th>'.dica('Relacionado', 'A quais partes do sistema o evento está relacionado.').'Relacionado'.dicaF().'</th>';
echo '</tr>';
$qnt=0;


if ($Aplic->profissional){
  if ($Aplic->profissional) require_once BASE_DIR.'/modulos/projetos/template_pro.class.php';
	$ata_ativo=$Aplic->modulo_ativo('atas');
	if ($ata_ativo) require_once BASE_DIR.'/modulos/atas/funcoes.php';
	$swot_ativo=$Aplic->modulo_ativo('swot');
	if ($swot_ativo) {
		require_once BASE_DIR.'/modulos/swot/swot.class.php';
		require_once BASE_DIR.'/modulos/swot/mswot.class.php';
		}
	$operativo_ativo=$Aplic->modulo_ativo('operativo');
	if ($operativo_ativo) require_once BASE_DIR.'/modulos/operativo/funcoes.php';
	$problema_ativo=$Aplic->modulo_ativo('problema');
	if ($problema_ativo) require_once BASE_DIR.'/modulos/problema/funcoes.php';
	$agrupamento_ativo=$Aplic->modulo_ativo('agrupamento');
	if($agrupamento_ativo) require_once BASE_DIR.'/modulos/agrupamento/funcoes.php';
	$patrocinador_ativo=$Aplic->modulo_ativo('patrocinadores');
	if($patrocinador_ativo) require_once BASE_DIR.'/modulos/patrocinadores/patrocinadores.class.php';
	}




foreach ($eventos as $linha) {
	$qnt++;
	echo '<tr>';

	echo '<td width="25%" nowrap="nowrap">'.retorna_data($linha['evento_inicio']).'&nbsp;-&nbsp;'.retorna_data($linha['evento_fim']).'</td>';
	echo '<td width="10%" nowrap="nowrap">'.imagem('icones/evento'.$linha['evento_tipo'].'.png', 'Tipo de Evento', 'Cada evento tem um gráfico diferente para facilitar a identificação visual.').'&nbsp;<b>'.$tipos[$linha['evento_tipo']].'</b></td>';
	echo '<td>'.link_evento($linha['evento_id']).'</td>';
	
	
	
	
	if ($Aplic->profissional){
		$sql = new BDConsulta;
		$sql->adTabela('evento_gestao');
		$sql->adCampo('evento_gestao.*');
		$sql->adOnde('evento_gestao_evento ='.(int)$linha['evento_id']);
		$sql->adOrdem('evento_gestao_ordem');
	  $lista = $sql->Lista();
	  $sql->limpar();
		echo '<td>';
		$qnt=0;
		foreach($lista as $gestao_data){
			if ($gestao_data['evento_gestao_tarefa']) echo ($qnt++ ? '<br>' : '').imagem('icones/tarefa_p.gif').link_tarefa($gestao_data['evento_gestao_tarefa']);
			elseif ($gestao_data['evento_gestao_projeto']) echo ($qnt++ ? '<br>' : '').imagem('icones/projeto_p.gif').link_projeto($gestao_data['evento_gestao_projeto']);
			elseif ($gestao_data['evento_gestao_pratica']) echo ($qnt++ ? '<br>' : '').imagem('icones/pratica_p.gif').link_pratica($gestao_data['evento_gestao_pratica']);
			elseif ($gestao_data['evento_gestao_acao']) echo ($qnt++ ? '<br>' : '').imagem('icones/plano_acao_p.gif').link_acao($gestao_data['evento_gestao_acao']);
			elseif ($gestao_data['evento_gestao_perspectiva']) echo ($qnt++ ? '<br>' : '').imagem('icones/perspectiva_p.png').link_perspectiva($gestao_data['evento_gestao_perspectiva']);
			elseif ($gestao_data['evento_gestao_tema']) echo ($qnt++ ? '<br>' : '').imagem('icones/tema_p.png').link_tema($gestao_data['evento_gestao_tema']);
			elseif ($gestao_data['evento_gestao_objetivo']) echo ($qnt++ ? '<br>' : '').imagem('icones/obj_estrategicos_p.gif').link_objetivo($gestao_data['evento_gestao_objetivo']);
			elseif ($gestao_data['evento_gestao_fator']) echo ($qnt++ ? '<br>' : '').imagem('icones/fator_p.gif').link_fator($gestao_data['evento_gestao_fator']);
			elseif ($gestao_data['evento_gestao_estrategia']) echo ($qnt++ ? '<br>' : '').imagem('icones/estrategia_p.gif').link_estrategia($gestao_data['evento_gestao_estrategia']);
			elseif ($gestao_data['evento_gestao_meta']) echo ($qnt++ ? '<br>' : '').imagem('icones/meta_p.gif').link_meta($gestao_data['evento_gestao_meta']);
			elseif ($gestao_data['evento_gestao_canvas']) echo ($qnt++ ? '<br>' : '').imagem('icones/canvas_p.png').link_canvas($gestao_data['evento_gestao_canvas']);
			elseif ($gestao_data['evento_gestao_risco']) echo ($qnt++ ? '<br>' : '').imagem('icones/risco_p.png').link_risco($gestao_data['evento_gestao_risco']);
			elseif ($gestao_data['evento_gestao_risco_resposta']) echo ($qnt++ ? '<br>' : '').imagem('icones/risco_resposta_p.png').link_risco_resposta($gestao_data['evento_gestao_risco_resposta']);
			elseif ($gestao_data['evento_gestao_indicador']) echo ($qnt++ ? '<br>' : '').imagem('icones/indicador_p.gif').link_indicador($gestao_data['evento_gestao_indicador']);
			elseif ($gestao_data['evento_gestao_calendario']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_calendario($gestao_data['evento_gestao_calendario']);
			elseif ($gestao_data['evento_gestao_monitoramento']) echo ($qnt++ ? '<br>' : '').imagem('icones/monitoramento_p.gif').link_monitoramento($gestao_data['evento_gestao_monitoramento']);
			elseif ($gestao_data['evento_gestao_ata']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/atas/imagens/ata_p.png').link_ata_pro($gestao_data['evento_gestao_ata']);
			elseif ($gestao_data['evento_gestao_mswot']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/swot/imagens/mswot_p.png').link_mswot($gestao_data['evento_gestao_mswot']);
			elseif ($gestao_data['evento_gestao_swot']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/swot/imagens/swot_p.png').link_swot($gestao_data['evento_gestao_swot']);
			elseif ($gestao_data['evento_gestao_operativo']) echo ($qnt++ ? '<br>' : '').imagem('icones/operativo_p.png').link_operativo($gestao_data['evento_gestao_operativo']);
			elseif ($gestao_data['evento_gestao_instrumento']) echo ($qnt++ ? '<br>' : '').imagem('icones/instrumento_p.png').link_instrumento($gestao_data['evento_gestao_instrumento']);
			elseif ($gestao_data['evento_gestao_recurso']) echo ($qnt++ ? '<br>' : '').imagem('icones/recursos_p.gif').link_recurso($gestao_data['evento_gestao_recurso']);
			elseif ($gestao_data['evento_gestao_problema']) echo ($qnt++ ? '<br>' : '').imagem('icones/problema_p.png').link_problema_pro($gestao_data['evento_gestao_problema']);
			elseif ($gestao_data['evento_gestao_demanda']) echo ($qnt++ ? '<br>' : '').imagem('icones/demanda_p.gif').link_demanda($gestao_data['evento_gestao_demanda']);
			elseif ($gestao_data['evento_gestao_programa']) echo ($qnt++ ? '<br>' : '').imagem('icones/programa_p.png').link_programa($gestao_data['evento_gestao_programa']);
			elseif ($gestao_data['evento_gestao_licao']) echo ($qnt++ ? '<br>' : '').imagem('icones/licoes_p.gif').link_licao($gestao_data['evento_gestao_licao']);
			elseif ($gestao_data['evento_gestao_link']) echo ($qnt++ ? '<br>' : '').imagem('icones/links_p.gif').link_link($gestao_data['evento_gestao_link']);
			elseif ($gestao_data['evento_gestao_avaliacao']) echo ($qnt++ ? '<br>' : '').imagem('icones/avaliacao_p.gif').link_avaliacao($gestao_data['evento_gestao_avaliacao']);
			elseif ($gestao_data['evento_gestao_tgn']) echo ($qnt++ ? '<br>' : '').imagem('icones/tgn_p.png').link_tgn($gestao_data['evento_gestao_tgn']);
			elseif ($gestao_data['evento_gestao_brainstorm']) echo ($qnt++ ? '<br>' : '').imagem('icones/brainstorm_p.gif').link_brainstorm_pro($gestao_data['evento_gestao_brainstorm']);
			elseif ($gestao_data['evento_gestao_gut']) echo ($qnt++ ? '<br>' : '').imagem('icones/gut_p.gif').link_gut_pro($gestao_data['evento_gestao_gut']);
			elseif ($gestao_data['evento_gestao_causa_efeito']) echo ($qnt++ ? '<br>' : '').imagem('icones/causaefeito_p.png').link_causa_efeito_pro($gestao_data['evento_gestao_causa_efeito']);
			elseif ($gestao_data['evento_gestao_arquivo']) echo ($qnt++ ? '<br>' : '').imagem('icones/arquivo_p.png').link_arquivo($gestao_data['evento_gestao_arquivo']);
			elseif ($gestao_data['evento_gestao_forum']) echo ($qnt++ ? '<br>' : '').imagem('icones/forum_p.gif').link_forum($gestao_data['evento_gestao_forum']);
			elseif ($gestao_data['evento_gestao_checklist']) echo ($qnt++ ? '<br>' : '').imagem('icones/todo_list_p.png').link_checklist($gestao_data['evento_gestao_checklist']);
			elseif ($gestao_data['evento_gestao_agenda']) echo ($qnt++ ? '<br>' : '').imagem('icones/calendario_p.png').link_agenda($gestao_data['evento_gestao_agenda']);
			elseif ($gestao_data['evento_gestao_agrupamento']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/agrupamento/imagens/agrupamento_p.png').link_agrupamento($gestao_data['evento_gestao_agrupamento']);
			elseif ($gestao_data['evento_gestao_patrocinador']) echo ($qnt++ ? '<br>' : '').imagem('../../../modulos/patrocinadores/imagens/patrocinador_p.gif').link_patrocinador($gestao_data['evento_gestao_patrocinador']);
			elseif ($gestao_data['evento_gestao_template']) echo ($qnt++ ? '<br>' : '').imagem('icones/template_p.gif').link_template($gestao_data['evento_gestao_template']);
			elseif ($gestao_data['evento_gestao_painel']) echo ($qnt++ ? '<br>' : '').imagem('icones/indicador_p.gif').link_painel($gestao_data['evento_gestao_painel']);
			elseif ($gestao_data['evento_gestao_painel_odometro']) echo ($qnt++ ? '<br>' : '').imagem('icones/odometro_p.png').link_painel_odometro($gestao_data['evento_gestao_painel_odometro']);
			elseif ($gestao_data['evento_gestao_painel_composicao']) echo ($qnt++ ? '<br>' : '').imagem('icones/painel_p.gif').link_painel_composicao($gestao_data['evento_gestao_painel_composicao']);
			elseif ($gestao_data['evento_gestao_tr']) echo ($qnt++ ? '<br>' : '').imagem('icones/tr_p.png').link_tr($gestao_data['evento_gestao_tr']);	
			elseif ($gestao_data['evento_gestao_me']) echo ($qnt++ ? '<br>' : '').imagem('icones/me_p.png').link_me($gestao_data['evento_gestao_me']);
			}
		echo '</td>';
		}
	echo '</tr>';
	}
if (!$qnt) echo '<tr><td colspan="3"><p>Nenhum evento encontrado.</p></td></tr>';	
echo '</table>';

?>