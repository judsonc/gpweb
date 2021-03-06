<?php
/*
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/


include_once $Aplic->getClasseBiblioteca('xajax/xajax_core/xajax.inc');
$xajax = new xajax();
$xajax->configure('defaultMode', 'synchronous');
//$xajax->setFlag('debug',true);
//$xajax->setFlag('outputEntities',true);

if ($Aplic->profissional) include_once (BASE_DIR.'/modulos/projetos/licao_editar_ajax_pro.php');

function exibir_cias($cias){
	global $config;
	$cias_selecionadas=explode(',', $cias);
	$saida_cias='';
	if (count($cias_selecionadas)) {
			$saida_cias.= '<table cellpadding=0 cellspacing=0>';
			$saida_cias.= '<tr><td class="texto" style="width:400px;">'.link_cia($cias_selecionadas[0]);
			$qnt_lista_cias=count($cias_selecionadas);
			if ($qnt_lista_cias > 1) {		
					$lista='';
					for ($i = 1, $i_cmp = $qnt_lista_cias; $i < $i_cmp; $i++) $lista.=link_cia($cias_selecionadas[$i]).'<br>';		
					$saida_cias.= dica('Outr'.$config['genero_organizacao'].'s '.ucfirst($config['organizacoes']), 'Clique para visualizar '.$config['genero_organizacao'].'s demais '.strtolower($config['organizacoes']).'.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_cias\');">(+'.($qnt_lista_cias - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_cias"><br>'.$lista.'</span>';
					}
			$saida_cias.= '</td></tr></table>';
			} 
	else 	$saida_cias.= '<table cellpadding=0 cellspacing=0 class="texto" width=100%><tr><td>&nbsp;</td></tr></table>';	
	$objResposta = new xajaxResponse();
	$objResposta->assign('combo_cias',"innerHTML", utf8_encode($saida_cias));
	return $objResposta;				
	}
$xajax->registerFunction("exibir_cias");	


function atualizar_arquivo($licao_id=0){
    $sql = new BDConsulta;
    //arquivo anexo
    $sql->adTabela('licao_arquivo');
    $sql->adCampo('licao_arquivo_id, licao_arquivo_usuario, licao_arquivo_data, licao_arquivo_ordem, licao_arquivo_nome, licao_arquivo_endereco');
    $sql->adOnde('licao_arquivo_licao='.(int)$licao_id);
    $sql->adOrdem('licao_arquivo_ordem ASC');
    $arquivos=$sql->Lista();
    $sql->limpar();
    $saida='<table cellspacing=0 cellpadding=0>';
    foreach ($arquivos as $arquivo) {
        $saida.= '<tr>';
        $saida.= '<td nowrap="nowrap" width="40" align="center">';
        $saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_arquivo('.$arquivo['licao_arquivo_ordem'].', '.$arquivo['licao_arquivo_id'].', \'moverPrimeiro\');"><img src="'.acharImagem('icones/2setacima.gif').'" border=0/></a>';
        $saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_arquivo('.$arquivo['licao_arquivo_ordem'].', '.$arquivo['licao_arquivo_id'].', \'moverParaCima\');"><img src="'.acharImagem('icones/1setacima.gif').'" border=0/></a>';
        $saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_arquivo('.$arquivo['licao_arquivo_ordem'].', '.$arquivo['licao_arquivo_id'].', \'moverParaBaixo\');"><img src="'.acharImagem('icones/1setabaixo.gif').'" border=0/></a>';
        $saida.= '<a href="javascript:void(0);" onclick="javascript:mudar_posicao_arquivo('.$arquivo['licao_arquivo_ordem'].', '.$arquivo['licao_arquivo_id'].', \'moverUltimo\');"><img src="'.acharImagem('icones/2setabaixo.gif').'" border=0/></a>';
        $saida.= '</td>';
        $saida.= '<td><a href="javascript:void(0);" onclick="javascript:url_passar(0, \'m=projetos&a=licao_pro_download&sem_cabecalho=1&licao_arquivo_id='.$arquivo['licao_arquivo_id'].'\');">'.$arquivo['licao_arquivo_nome'].'</a></td>';
        $saida.= '<td><a href="javascript: void(0);" onclick="if (confirm(\'Tem certeza que deseja excluir?\')) {excluir_arquivo('.$arquivo['licao_arquivo_id'].');}">'.imagem('icones/remover.png').'</a></td>';
        $saida.= '</tr>';
        }
    $saida.='</table>';
    return $saida;
    }

function mudar_posicao_arquivo($ordem, $licao_arquivo_id, $direcao, $licao_id=0){
    //ordenar membro da equipe
    $sql = new BDConsulta;
    if($direcao && $licao_arquivo_id) {
        $novo_ui_ordem = $ordem;
        $sql->adTabela('licao_arquivo');
        $sql->adOnde('licao_arquivo_id != '.(int)$licao_arquivo_id);
        $sql->adOnde('licao_arquivo_licao = '.(int)$licao_id);
        $sql->adOrdem('licao_arquivo_ordem');
        $membros = $sql->Lista();
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
            $novo_ui_ordem = count($membros) + 1;
            }
        if ($novo_ui_ordem && ($novo_ui_ordem <= count($membros) + 1)) {
            $sql->adTabela('licao_arquivo');
            $sql->adAtualizar('licao_arquivo_ordem', $novo_ui_ordem);
            $sql->adOnde('licao_arquivo_id = '.(int)$licao_arquivo_id);
            $sql->exec();
            $sql->limpar();
            $idx = 1;
            foreach ($membros as $acao) {
                if ((int)$idx != (int)$novo_ui_ordem) {
                    $sql->adTabela('licao_arquivo');
                    $sql->adAtualizar('licao_arquivo_ordem', $idx);
                    $sql->adOnde('licao_arquivo_id = '.(int)$acao['licao_arquivo_id']);
                    $sql->exec();
                    $sql->limpar();
                    $idx++;
                    } 
                else {
                    $sql->adTabela('licao_arquivo');
                    $sql->adAtualizar('licao_arquivo_ordem', $idx + 1);
                    $sql->adOnde('licao_arquivo_id = '.(int)$acao['licao_arquivo_id']);
                    $sql->exec();
                    $sql->limpar();
                    $idx = $idx + 2;
                    }
                }        
            }
        }
    
    $saida=atualizar_arquivo($licao_id);
    $objResposta = new xajaxResponse();
    $objResposta->assign("combo_arquivos","innerHTML", utf8_encode($saida));
    return $objResposta;
    }
$xajax->registerFunction("mudar_posicao_arquivo");

function excluir_arquivo($licao_arquivo_id=0, $licao_id=0){    
    global $config;
    
    $sql = new BDConsulta;
    
    
    $sql->adTabela('licao_arquivo');
    $sql->adCampo('licao_arquivo_endereco');
    $sql->adOnde('licao_arquivo_id='.(int)$licao_arquivo_id);
    $arquivos=$sql->Lista();
    $sql->limpar();
    
    $base_dir=($config['dir_arquivo'] ? $config['dir_arquivo'] : BASE_DIR);
    
    foreach($arquivos as $chave => $arquivo){
        @unlink($base_dir.'/arquivos/licao/'.$arquivo['licao_arquivo_endereco']);
        }
    
    
    
    $sql->setExcluir('licao_arquivo');
    $sql->adOnde('licao_arquivo_id='.(int)$licao_arquivo_id);
    $sql->exec();
    
    $saida=atualizar_arquivo($licao_id);
    $objResposta = new xajaxResponse();
    $objResposta->assign("combo_arquivos","innerHTML", utf8_encode($saida));
    return $objResposta;
    }    
$xajax->registerFunction("excluir_arquivo");











function exibir_usuarios($usuarios){
	global $config;
	$usuarios_selecionados=explode(',', $usuarios);
	$saida_usuarios='';
	if (count($usuarios_selecionados)) {
			$saida_usuarios.= '<table cellpadding=0 cellspacing=0>';
			$saida_usuarios.= '<tr><td class="texto" style="width:400px;">'.link_usuario($usuarios_selecionados[0],'','','esquerda');
			$qnt_lista_usuarios=count($usuarios_selecionados);
			if ($qnt_lista_usuarios > 1) {		
					$lista='';
					for ($i = 1, $i_cmp = $qnt_lista_usuarios; $i < $i_cmp; $i++) $lista.=link_usuario($usuarios_selecionados[$i],'','','esquerda').'<br>';		
					$saida_usuarios.= dica('Outr'.$config['genero_usuario'].'s '.ucfirst($config['usuarios']), 'Clique para visualizar '.$config['genero_usuario'].'s demais '.strtolower($config['usuarios']).'.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_usuarios\');">(+'.($qnt_lista_usuarios - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_usuarios"><br>'.$lista.'</span>';
					}
			$saida_usuarios.= '</td></tr></table>';
			} 
	else $saida_usuarios.= '<table cellpadding=0 cellspacing=0 class="texto" width=100%><tr><td>&nbsp;</td></tr></table>';	
	$objResposta = new xajaxResponse();
	$objResposta->assign('combo_usuarios',"innerHTML", utf8_encode($saida_usuarios));
	return $objResposta;				
	}
$xajax->registerFunction("exibir_usuarios");

function exibir_depts($depts){
	global $config;
	$depts_selecionados=explode(',', $depts);
	$saida_depts='';
	if (count($depts_selecionados)) {
			$saida_depts.= '<table cellpadding=0 cellspacing=0>';
			$saida_depts.= '<tr><td class="texto" style="width:400px;">'.link_secao($depts_selecionados[0]);
			$qnt_lista_depts=count($depts_selecionados);
			if ($qnt_lista_depts > 1) {		
					$lista='';
					for ($i = 1, $i_cmp = $qnt_lista_depts; $i < $i_cmp; $i++) $lista.=link_secao($depts_selecionados[$i]).'<br>';		
					$saida_depts.= dica('Outr'.$config['genero_dept'].'s '.ucfirst($config['departamentos']), 'Clique para visualizar '.$config['genero_dept'].'s demais '.strtolower($config['departamentos']).'.').' <a href="javascript: void(0);" onclick="expandir_colapsar(\'lista_depts\');">(+'.($qnt_lista_depts - 1).')</a>'.dicaF(). '<span style="display: none" id="lista_depts"><br>'.$lista.'</span>';
					}
			$saida_depts.= '</td></tr></table>';
			} 
	
	$objResposta = new xajaxResponse();
	$objResposta->assign('combo_depts',"innerHTML", utf8_encode($saida_depts));
	return $objResposta;				
	}
$xajax->registerFunction("exibir_depts");


function selecionar_om_ajax($cia_id=1, $campo, $posicao, $script,  $vazio='', $acesso=0, $externo=0 ){
	$saida=selecionar_om_para_ajax($cia_id, $campo, $script,  $vazio, $acesso, $externo);
	$objResposta = new xajaxResponse();
	$objResposta->assign($posicao,"innerHTML", $saida);
	return $objResposta;
	}
	
$xajax->registerFunction("selecionar_om_ajax");	
$xajax->processRequest();

?>