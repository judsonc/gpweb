<?php 
/* Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

if (!defined('BASE_DIR')) die('Voc� n�o deveria acessar este arquivo diretamente.');


class objetivos extends pesquisa {
	var $tabela = 'objetivo';
	var $tabela_apelido = 'objetivo';
	var $tabela_modulo = 'praticas';
	var $tabela_chave = 'objetivo.objetivo_id';
	var $tabela_link = 'index.php?m=praticas&a=obj_estrategico_ver&objetivo_id=';
	var $tabela_titulo ='objetivos';
	var $tabela_ordem_por = 'objetivo_nome';
	var $buscar_campos = array('objetivo_nome', 'objetivo_oque','objetivo_descricao','objetivo_onde','objetivo_quando','objetivo_como','objetivo_porque','objetivo_quanto','objetivo_quem','objetivo_controle','objetivo_melhorias','objetivo_metodo_aprendizado','objetivo_desde_quando');
	var $mostrar_campos = array('objetivo_nome', 'objetivo_oque','objetivo_descricao','objetivo_onde','objetivo_quando','objetivo_como','objetivo_porque','objetivo_quanto','objetivo_quem','objetivo_controle','objetivo_melhorias','objetivo_metodo_aprendizado','objetivo_desde_quando');
	var $funcao='objetivo';
	}
?>