<?php 
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb profissional - registrado no INPI sob o número RS 11802-5 e protegido pelo direito de autor. 
É expressamente proibido utilizar este script em parte ou no todo sem o expresso consentimento do autor.
*/

if (!defined('BASE_DIR')) die('Você não deveria acessar este arquivo diretamente.');

require_once BASE_DIR.'/codigo/instalacao.inc.php';



$mod_bd=1;
$configuracao = array();
$configuracao['mod_versao'] = 1;
$configuracao['mod_ui_ativo'] = 1;
$configuracao['mod_ativo'] = 1;
$configuracao['mod_nome'] = ucfirst($config['instrumentos']);
$configuracao['mod_diretorio'] = 'instrumento';
$configuracao['mod_classe_configurar'] = 'CSetupinstrumento';
$configuracao['mod_tipo'] = 'usuario';
$configuracao['mod_ui_nome'] = ucfirst($config['instrumentos']);
$configuracao['mod_ui_icone'] = 'instrumento_p.png';
$configuracao['mod_descricao'] = 'Módulo para controlar '.$config['instrumentos'].'.';
$configuracao['mod_classe_principal'] = 'CInstrumento';
$configuracao['mod_texto_botao'] = 'Exibir a lista de '.$config['instrumentos'].'';
$configuracao['permissoes_item_tabela'] = 'instrumento';
$configuracao['permissoes_item_campo'] = 'instrumento_id';
$configuracao['permissoes_item_legenda'] = 'instrumento_nome';
  
  
class CSetupinstrumento {
	public function instalar() {
		global $configuracao, $Aplic, $config;
		instalacao_carregarSQL(BASE_DIR.'/modulos/instrumento/sql/menu_pro.sql');
		instalacao_carregarSQL(BASE_DIR.'/modulos/instrumento/sql/instalar_'.$config['tipoBd'].'.sql');
    return true;
		}

	public function remover() {
		global $configuracao, $Aplic, $config;
		instalacao_carregarSQL(BASE_DIR.'/modulos/instrumento/sql/desinstalar_'.$config['tipoBd'].'.sql');
		include_once BASE_DIR.'/incluir/funcoes_principais_pro.php';
		desinstalar_menu_pro($configuracao['mod_diretorio']);
		return true;
		}

	public function atualizar($versao_antiga) {

		global $Aplic, $config, $mod_bd;
		while ($versao_antiga< $mod_bd){
			++$versao_antiga;
			instalacao_carregarSQL(BASE_DIR.'/modulos/instrumento/sql/atualizar_bd_'.$config['tipoBd'].'_'.$versao_antiga.'.sql');
			executar_php(BASE_DIR.'/modulos/instrumento/sql/atualizar_bd_'.$config['tipoBd'].'_'.$versao_antiga.'.php');
			}
		return true;
		}
		
	public function configurar() {
		global $Aplic;
		$Aplic->redirecionar('m=instrumento&a=configurar');
		return true;
		}	
		
}