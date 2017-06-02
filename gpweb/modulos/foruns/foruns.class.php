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

global $config;
require_once ($Aplic->getClasseSistema('libmail'));
require_once ($Aplic->getClasseBiblioteca('PEAR/BBCodeParser'));
$bbparser = new HTML_BBCodeParser();
$filtros = array('');
if (isset($a) && $a == 'ver') array_push($filtros, 'Meus Acompanhados', 'Últimos 30 Dias');
else array_push($filtros, 'Meus Fóruns', 'Meus Acompanhados', 'Minh'.$config['genero_organizacao'].' '.$config['organizacao']);

class CForum extends CAplicObjeto {
	public $forum_id = null;
	public $forum_cia = null;
	public $forum_dept = null;
	public $forum_projeto = null;
	public $forum_tarefa = null;
	public $forum_pratica = null;
	public $forum_acao = null;
	public $forum_indicador = null;
	public $forum_tema = null;
	public $forum_objetivo = null;
	public $forum_estrategia = null;
	public $forum_meta = null;
	public $forum_fator = null;
	public $forum_perspectiva = null;
	public $forum_canvas = null;
	public $forum_status = null;
	public $forum_dono = null;
	public $forum_nome = null;
	public $forum_data_criacao = null;
	public $forum_ultima_data = null;
	public $forum_ultimo_id = null;
	public $forum_contagem_msg = null;
	public $forum_descricao = null;
	public $forum_moderador = null;
	public $forum_acesso = null;
	public $forum_cor = null;
	public $forum_ativo = null;
	public $forum_principal_indicador = null;
	public $forum_moeda = null;
	public $forum_aprovado = null;	
	
	function __construct() {
		parent::__construct('foruns', 'forum_id');
		}

	function join($hash) {
		if (!is_array($hash))	return "CForum::unir falhou";
		else {
			$q = new BDConsulta;
			$q->unirLinhaAoObjeto($hash, $this);
			$q->limpar();
			return null;
			}
		}

	function check() {

		return null;
		}

	function armazenar($atualizarNulos = false) {
		global $Aplic;
		$msg = $this->check();
		if ($msg) return 'CForum::checagem para armazenar falhou '.$msg;
		$sql = new BDConsulta();
		if ($this->forum_id) {
			$ret = $sql->atualizarObjeto('foruns', $this, 'forum_id', false);
			$sql->limpar();
			}
		else {
			$ret = $sql->inserirObjeto('foruns', $this, 'forum_id');
			$sql->limpar();
			}

		$forum_usuarios=getParam($_REQUEST, 'forum_usuarios', null);
		$forum_usuarios=explode(',', $forum_usuarios);
		$sql->setExcluir('forum_usuario');
		$sql->adOnde('forum_usuario_forum = '.$this->forum_id);
		$sql->exec();
		$sql->limpar();
		foreach($forum_usuarios as $chave => $usuario_id){
			if($usuario_id){
				$sql->adTabela('forum_usuario');
				$sql->adInserir('forum_usuario_forum', $this->forum_id);
				$sql->adInserir('forum_usuario_usuario', $usuario_id);
				$sql->exec();
				$sql->limpar();
				}
			}

		$depts_selecionados=getParam($_REQUEST, 'forum_depts', null);
		$depts_selecionados=explode(',', $depts_selecionados);
		$sql->setExcluir('forum_dept');
		$sql->adOnde('forum_dept_forum = '.$this->forum_id);
		$sql->exec();
		$sql->limpar();
		foreach($depts_selecionados as $chave => $dept_id){
			if($dept_id){
				$sql->adTabela('forum_dept');
				$sql->adInserir('forum_dept_forum', $this->forum_id);
				$sql->adInserir('forum_dept_dept', $dept_id);
				$sql->exec();
				$sql->limpar();
				}
			}

		if ($Aplic->profissional){
			$sql->setExcluir('forum_cia');
			$sql->adOnde('forum_cia_forum='.(int)$this->forum_id);
			$sql->exec();
			$sql->limpar();
			$cias=getParam($_REQUEST, 'forum_cias', '');
			$cias=explode(',', $cias);
			if (count($cias)) {
				foreach ($cias as $cia_id) {
					if ($cia_id){
						$sql->adTabela('forum_cia');
						$sql->adInserir('forum_cia_forum', $this->forum_id);
						$sql->adInserir('forum_cia_cia', $cia_id);
						$sql->exec();
						$sql->limpar();
						}
					}
				}
			}

		$uuid=getParam($_REQUEST, 'uuid', null);
		if ($Aplic->profissional && $uuid){
			$sql->adTabela('forum_gestao');
			$sql->adAtualizar('forum_gestao_forum', (int)$this->forum_id);
			$sql->adAtualizar('forum_gestao_uuid', null);
			$sql->adOnde('forum_gestao_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();



			$sql->adTabela('assinatura');
			$sql->adAtualizar('assinatura_forum', (int)$this->forum_id);
			$sql->adAtualizar('assinatura_uuid', null);
			$sql->adOnde('assinatura_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();

			$sql->adTabela('priorizacao');
			$sql->adAtualizar('priorizacao_forum', (int)$this->forum_id);
			$sql->adAtualizar('priorizacao_uuid', null);
			$sql->adOnde('priorizacao_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();		
			}

		//verificar aprovacao
		if ($Aplic->profissional) {
			$sql->adTabela('assinatura');
			$sql->esqUnir('assinatura_atesta_opcao', 'assinatura_atesta_opcao', 'assinatura_atesta_opcao_id=assinatura_atesta_opcao');
			$sql->adCampo('count(assinatura_id)');
			$sql->adOnde('assinatura_forum='.(int)$this->forum_id);
			$sql->adOnde('assinatura_atesta_opcao_aprova!=1 OR assinatura_atesta_opcao_aprova IS NULL');
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta_opcao > 0');
			$nao_aprovado1 = $sql->resultado();
			$sql->limpar();
			
			
			$sql->adTabela('assinatura');
			$sql->adCampo('count(assinatura_id)');
			$sql->adOnde('assinatura_forum='.(int)$this->forum_id);
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta IS NULL');
			$sql->adOnde('assinatura_data IS NULL OR (assinatura_data IS NOT NULL AND assinatura_aprovou=0)');
			$nao_aprovado2 = $sql->resultado();
			$sql->limpar();
			
			//assinatura que tem despacho mas nem assinou
			$sql->adTabela('assinatura');
			$sql->adCampo('count(assinatura_id)');
			$sql->adOnde('assinatura_forum='.(int)$this->forum_id);
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta IS NOT NULL');
			$sql->adOnde('assinatura_atesta_opcao IS NULL');
			$nao_aprovado3 = $sql->resultado();
			$sql->limpar();
			
			$nao_aprovado=($nao_aprovado1 || $nao_aprovado2 || $nao_aprovado3);
			
			$sql->adTabela('foruns');
			$sql->adAtualizar('forum_aprovado', ($nao_aprovado ? 0 : 1));
			$sql->adOnde('forum_id='.(int)$this->forum_id);
			$sql->exec();
			$sql->limpar();
			}

		require_once ($Aplic->getClasseSistema('CampoCustomizados'));
		$campos_customizados = new CampoCustomizados('foruns', $this->forum_id, 'editar');
		$campos_customizados->join($_REQUEST);
		$campos_customizados->armazenar($this->forum_id);
		if (!$ret) return get_class($this).'::armazenar falhou '.db_error();
		else return null;
		}



	function excluir($oid = NULL) {
		global $Aplic;
		if ($Aplic->getEstado('forum_id', null)==$this->forum_id) $Aplic->setEstado('forum_id', null);
		parent::excluir();
		return null;
		}

	function podeAcessar() {
		return true;
		}

	function podeEditar() {
		return true;
		}

	}

class CForumMensagem {
	public $mensagem_id = null;
	public $mensagem_forum = null;
	public $mensagem_superior = null;
	public $mensagem_autor = null;
	public $mensagem_editor = null;
	public $mensagem_titulo = null;
	public $mensagem_data = null;
	public $mensagem_texto = null;
	public $mensagem_publicada = null;

	function __construct() {
		// construtor vazio
		}

	function join($hash) {
		if (!is_array($hash)) return 'CForumMensagem::unir falhou';
		else {
			$q = new BDConsulta;
			$q->unirLinhaAoObjeto($hash, $this);
			$q->limpar();
			return null;
			}
		}

	function check() {
		if ($this->mensagem_id === null) return 'Id da mensagem está nulo';
		return null;
		}

	function armazenar($atualizarNulos = true) {
		$msg = $this->check();
		if ($msg) return 'CForumMensagem::checagem para armazenar falhou '.$msg;
		$q = new BDConsulta;
		if ($this->mensagem_id) {
			$q->setExcluir('forum_visitas');
			$q->adOnde('visita_mensagem = '.(int)$this->mensagem_id);
			$q->exec();
			$q->limpar();
			$ret = $q->atualizarObjeto('forum_mensagens', $this, 'mensagem_id', false);
			$q->limpar();
			}
		else {
			$data = new CData();
			$this->mensagem_data = $data->format(FMT_TIMESTAMP_MYSQL);
			$novo_id = $q->inserirObjeto('forum_mensagens', $this, 'mensagem_id');
			echo db_error();
			$q->limpar();
			$q->adTabela('forum_mensagens');
			$q->adCampo('count(mensagem_id) as qnt, MAX(mensagem_data) as data');
			$q->adOnde('mensagem_forum = '.(int)$this->mensagem_forum);
			$resposta = $q->linha();
			$q->limpar();


			$q->adTabela('foruns');
			$q->adAtualizar('forum_contagem_msg', $resposta['qnt']);
			$q->adAtualizar('forum_ultima_data', $resposta['data']);
			$q->adAtualizar('forum_ultimo_id', $this->mensagem_id);
			$q->adOnde('forum_id = '.$this->mensagem_forum);
			$q->exec();
			$q->limpar();

			return $this->enviarEmailAcompanhamento(false);
			}

		if (!$ret) return 'CForumMensagem::armazenar falhou '.db_error();
		else return null;
	}

	function excluir($oid = NULL) {
		$q = new BDConsulta;
		$q->setExcluir('forum_visitas');
		$q->adOnde('visita_mensagem = '.(int)$this->mensagem_id);
		$q->exec();
		$q->limpar();
		$q->adTabela('forum_mensagens');
		$q->adCampo('mensagem_forum');
		$q->adOnde('mensagem_id = '.(int)$this->mensagem_id);
		$forumId = $q->Resultado();
		$q->limpar();
		$q->setExcluir('forum_mensagens');
		$q->adOnde('mensagem_id = '.(int)$this->mensagem_id);
		if (!$q->exec()) $resultado = db_error();
		else $resultado = null;
		$q->limpar();
		$q->adTabela('forum_mensagens');
		$q->adCampo('COUNT(mensagem_id)');
		$q->adOnde('mensagem_forum = '.(int)$forumId);
		$quantMensagens = $q->Resultado();
		$q->limpar();
		$q->adTabela('foruns');
		$q->adAtualizar('forum_contagem_msg', $quantMensagens);
		$q->adOnde('forum_id = '.(int)$forumId);
		$q->exec();
		$q->limpar();
		return $resultado;
		}

	function enviarEmailAcompanhamento($depurar = false) {
		global $Aplic, $depurar, $config;
		$prefixo_assunto = 'Assunto do forum';
		$corpo_msg = 'Atividade detectada em um fórum que você acompanha';
		$q = new BDConsulta;
		$q->adTabela('usuarios', 'u');
		$q->esqUnir('contatos', 'con', 'contato_id = usuario_contato');
		$q->adCampo('contato_email, contato_posto, contato_nomeguerra');
		$q->adOnde('usuario_id = '.(int)$this->mensagem_autor);
		$res = $q->exec();
		if ($linha = $q->carregarLinha()) $mensagem_de = ($config['militar'] < 10 ? $linha['contato_posto'].' '.$linha['contato_nomeguerra'] : $linha['contato_nomeguerra']).'<'.$linha['contato_email'].'>';
		else $mensagem_de = ucfirst($config['usuario']).' desconhecido';
		$q->limpar();
		$q->adTabela('foruns');
		$q->adCampo('forum_nome');
		$q->adOnde('forum_id = \''.$this->mensagem_forum.'\'');
		$res = $q->exec();
		if ($linha = $q->carregarLinha()) $forum_nome = $linha['forum_nome'];
		else $forum_nome = 'Desconhecido';
		$q->limpar();
		$q->adTabela('forum_acompanhar');
		$q->adCampo('*');
		$q->adOnde('acompanhar_usuario = 0 OR acompanhar_usuario IS NULL');
		$q->adOnde('acompanhar_forum = 0 OR acompanhar_forum IS NULL');
		$q->adOnde('acompanhar_topico = 0 OR acompanhar_topico IS NULL');
		$resTodos = $q->exec();
		$contarTodos = db_num_rows($resTodos);
		$q->limpar();
		$q->adTabela('usuarios');
		$q->adCampo('DISTINCT contato_email, usuario_id, contato_posto, contato_nomeguerra, usuarios.usuario_id');
		//$q->esqUnir('contatos', 'con', 'contato_id = usuario_contato');
    //EUZ
		$q->esqUnir('contatos', '', 'contatos.contato_id = usuarios.usuario_contato');
		$q->esqUnir('forum_acompanhar', '', 'forum_acompanhar.acompanhar_usuario = usuarios.usuario_id');
		//EUD

		if ($contarTodos < 1) {
			//$q->adTabela('forum_acompanhar');
			$q->adOnde('usuario_id = acompanhar_usuario AND (acompanhar_forum = '.(int)$this->mensagem_forum.' OR acompanhar_topico = '.(int)$this->mensagem_superior.')');
			}
		if (!($res = $q->exec(ADODB_FETCH_ASSOC))) {
			$q->limpar();
			return;
			}
		if (db_num_rows($res) < 1) return;
		$email = new Mail;
		$email->De($config['email'], $Aplic->usuario_nome);

        if ($Aplic->usuario_email && $email->EmailValido($Aplic->usuario_email)){
            $email->ResponderPara($Aplic->usuario_email);
            }
        else if($Aplic->usuario_email2 && $email->EmailValido($Aplic->usuario_email2)){
            $email->ResponderPara($Aplic->usuario_email2);
            }

		$email->Assunto($prefixo_assunto.' '.$this->mensagem_titulo, isset($GLOBALS['locale_char_set']) ? $GLOBALS['locale_char_set'] : '');
		$titulo=$prefixo_assunto.' '.$this->mensagem_titulo;
		$corpo = $corpo_msg;
		$corpo .= "\n\n<b>Forum:</b> ".$forum_nome;
		$corpo .= "\n<b>Assunto:</b> ".$this->mensagem_titulo;
		$corpo .= "\n<b>Mensagem de:</b> ".$mensagem_de;
		$corpo .= "\n\n".'<a href="javascript:void(0);" onclick="url_passar(0, \'m=foruns&a=ver&forum_id='.$this->mensagem_forum.'\');">Clique aqui para acessar</a>';
		$corpo .= "\n\n".$this->mensagem_texto;
		$email->Corpo($corpo, isset($GLOBALS['locale_char_set']) ? $GLOBALS['locale_char_set'] : '');
		while ($linha = $q->carregarLinha()) {
			msg_email_interno ('', $titulo, $corpo,'',$linha['usuario_id']);
			if ($email->EmailValido($linha['contato_email']) && $config['email_ativo'] && $config['email_externo_auto']) {
				$email->Para($linha['contato_email'], true);
				$email->Enviar();
				}
			}
		$q->limpar();
		}

	}
?>