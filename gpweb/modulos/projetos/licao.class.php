<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*/


class CLicao extends CAplicObjeto {

	public $licao_id = null;
  public $licao_cia = null;
  public $licao_dept = null;
  public $licao_responsavel = null;
  public $licao_projeto = null;
  public $licao_nome = null;
  public $licao_ocorrencia = null;
  public $licao_tipo = null;
  public $licao_categoria = null;
  public $licao_consequencia = null;
  public $licao_acao_tomada = null;
  public $licao_aprendizado = null;
  public $licao_data = null;
  public $licao_data_final = null;
  public $licao_status = null;
  public $licao_acesso = null;
  public $licao_cor = null;
  public $licao_ativa = null;
  public $licao_aprovado = null;
	public $licao_moeda = null;

	function __construct() {
		parent::__construct('licao', 'licao_id');
		}

	function excluir($oid = NULL) {
		global $Aplic;
		if ($Aplic->getEstado('licao_id', null)==$this->licao_id) $Aplic->setEstado('licao_id', null);
		parent::excluir();
		return null;
		}

	function armazenar($atualizarNulos = false) {
		global $Aplic;
		$sql = new BDConsulta();
		if ($this->licao_id) {
			$ret = $sql->atualizarObjeto('licao', $this, 'licao_id', false);
			$sql->limpar();
			}
		else {
			$ret = $sql->inserirObjeto('licao', $this, 'licao_id');
			$sql->limpar();
			}

		require_once ($Aplic->getClasseSistema('CampoCustomizados'));
		$campos_customizados = new CampoCustomizados('licao_aprendida', $this->licao_id, 'editar');
		$campos_customizados->join($_REQUEST);
		$campos_customizados->armazenar($this->licao_id);


		$licao_usuarios=getParam($_REQUEST, 'licao_usuarios', null);
		$licao_usuarios=explode(',', $licao_usuarios);
		$sql->setExcluir('licao_usuarios');
		$sql->adOnde('licao_id = '.$this->licao_id);
		$sql->exec();
		$sql->limpar();
		foreach($licao_usuarios as $chave => $usuario_id){
			if($usuario_id){
				$sql->adTabela('licao_usuarios');
				$sql->adInserir('licao_id', $this->licao_id);
				$sql->adInserir('usuario_id', $usuario_id);
				$sql->exec();
				$sql->limpar();
				}
			}

		$licao_depts=getParam($_REQUEST, 'licao_depts', null);
		$licao_depts=explode(',', $licao_depts);
		$sql->setExcluir('licao_dept');
		$sql->adOnde('licao_dept_licao = '.$this->licao_id);
		$sql->exec();
		$sql->limpar();
		foreach($licao_depts as $chave => $dept_id){
			if($dept_id){
				$sql->adTabela('licao_dept');
				$sql->adInserir('licao_dept_licao', $this->licao_id);
				$sql->adInserir('licao_dept_dept', $dept_id);
				$sql->exec();
				$sql->limpar();
				}
			}

		if ($Aplic->profissional){
			$sql->setExcluir('licao_cia');
			$sql->adOnde('licao_cia_licao='.(int)$this->licao_id);
			$sql->exec();
			$sql->limpar();
			$cias=getParam($_REQUEST, 'licao_cias', '');
			$cias=explode(',', $cias);
			if (count($cias)) {
				foreach ($cias as $cia_id) {
					if ($cia_id){
						$sql->adTabela('licao_cia');
						$sql->adInserir('licao_cia_licao', $this->licao_id);
						$sql->adInserir('licao_cia_cia', $cia_id);
						$sql->exec();
						$sql->limpar();
						}
					}
				}
			}
			
			
		$uuid=getParam($_REQUEST, 'uuid', null);
		if ($uuid){	
			$sql->adTabela('assinatura');
			$sql->adAtualizar('assinatura_licao', (int)$this->licao_id);
			$sql->adAtualizar('assinatura_uuid', null);
			$sql->adOnde('assinatura_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();

			$sql->adTabela('priorizacao');
			$sql->adAtualizar('priorizacao_licao', (int)$this->licao_id);
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
			$sql->adOnde('assinatura_licao='.(int)$this->licao_id);
			$sql->adOnde('assinatura_atesta_opcao_aprova!=1 OR assinatura_atesta_opcao_aprova IS NULL');
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta_opcao > 0');
			$nao_aprovado1 = $sql->resultado();
			$sql->limpar();
			
			
			$sql->adTabela('assinatura');
			$sql->adCampo('count(assinatura_id)');
			$sql->adOnde('assinatura_licao='.(int)$this->licao_id);
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta IS NULL');
			$sql->adOnde('assinatura_data IS NULL OR (assinatura_data IS NOT NULL AND assinatura_aprovou=0)');
			$nao_aprovado2 = $sql->resultado();
			$sql->limpar();
			
			//assinatura que tem despacho mas nem assinou
			$sql->adTabela('assinatura');
			$sql->adCampo('count(assinatura_id)');
			$sql->adOnde('assinatura_licao='.(int)$this->licao_id);
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta IS NOT NULL');
			$sql->adOnde('assinatura_atesta_opcao IS NULL');
			$nao_aprovado3 = $sql->resultado();
			$sql->limpar();
			
			$nao_aprovado=($nao_aprovado1 || $nao_aprovado2 || $nao_aprovado3);
			
			$sql->adTabela('licao');
			$sql->adAtualizar('licao_aprovado', ($nao_aprovado ? 0 : 1));
			$sql->adOnde('licao_id='.(int)$this->licao_id);
			$sql->exec();
			$sql->limpar();
			}	

		if (!$ret) return get_class($this).'::armazenar falhou '.db_error();
		else return null;
		}


	function check() {
		return null;
		}


	function podeAcessar() {
		$valor=permiteAcessarLicao($this->licao_acesso, $this->licao_id);
		return $valor;
		}

	function podeEditar() {
		$valor=permiteEditarLicao($this->licao_acesso, $this->licao_id);
		return $valor;
		}




	function notificar($post=array()){
		global $Aplic, $config, $localidade_tipo_caract;
		require_once ($Aplic->getClasseSistema('libmail'));
		$sql = new BDConsulta;

		$sql->adTabela('licao');
		$sql->adCampo('licao_nome');
		$sql->adOnde('licao_id ='.$this->licao_id);
		$licao_nome = $sql->Resultado();
		$sql->limpar();



		$usuarios =array();
		$usuarios1=array();
		$usuarios2=array();
		$usuarios3=array();
		$usuarios4=array();

		if ($post['licao_usuarios'] && $post['email_designados']){
			$sql->adTabela('usuarios');
			$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('usuario_id IN ('.$post['licao_usuarios'].')');
			$usuarios1 = $sql->Lista();
			$sql->limpar();
			}
		if ($post['email_outro']){
			$sql->adTabela('usuarios');
			$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('contato_id IN ('.$post['email_outro'].')');
			$usuarios2=$sql->Lista();
			$sql->limpar();
			}

		if ($post['email_responsavel']){
			$sql->adTabela('usuarios');
			$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
			$sql->esqUnir('licao', 'licao', 'licao.licao_responsavel = usuarios.usuario_id');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('licao_id='.$this->licao_id);
			$usuarios3=$sql->Lista();
			$sql->limpar();
			}

		if ($post['email_extras']){
			$post['email_extras']=str_replace(';', ',', $post['email_extras']);
			$extras=explode(',',$post['email_extras']);
			foreach($extras as $chave => $valor) $usuarios4[]=array('usuario_id' => 0, 'nome_usuario' =>'', 'contato_email'=> $valor);
			}



		$usuarios = array_merge((array)$usuarios1, (array)$usuarios2);
		$usuarios = array_merge((array)$usuarios, (array)$usuarios3);
		$usuarios = array_merge((array)$usuarios, (array)$usuarios4);


		$usado_usuario=array();
		$usado_email=array();

		if (isset($post['del']) && $post['del'])$tipo='excluido';
		elseif (isset($post['licao_id']) && $post['licao_id']) $tipo='atualizado';
		else $tipo='incluido';

		foreach($usuarios as $usuario){
			if (!isset($usado[$usuario['usuario_id']]) && !isset($usado[$usuario['contato_email']])){

				$usado[$usuario['usuario_id']]=1;
				$usado[$usuario['contato_email']]=1;
				$email = new Mail;
				$email->De($config['email'], $Aplic->usuario_nome);

                if ($Aplic->usuario_email && $email->EmailValido($Aplic->usuario_email)){
                    $email->ResponderPara($Aplic->usuario_email);
                    }
                else if($Aplic->usuario_email2 && $email->EmailValido($Aplic->usuario_email2)){
                    $email->ResponderPara($Aplic->usuario_email2);
                    }

				if ($tipo == 'excluido') {
					$email->Assunto('Excluída Lição Aprendida', $localidade_tipo_caract);
					$titulo='Excluída lição aprendida';
					}
				elseif ($tipo=='atualizado') {
					$email->Assunto('Atualizada Lição Aprendida', $localidade_tipo_caract);
					$titulo='Atualizada lição aprendida';
					}
				else {
					$email->Assunto('Inserida Lição Aprendida', $localidade_tipo_caract);
					$titulo='Inserida lição aprendida';
					}
				if ($tipo=='atualizado') $corpo = 'Atualizada lição aprendida: '.$licao_nome.'<br>';
				elseif ($tipo=='excluido') $corpo = 'Excluída lição aprendida: '.$licao_nome.'<br>';
				else $corpo = 'Inserida licao: '.$licao_nome.'<br>';

				if ($tipo!='excluido') $corpo .= '<br><a href="javascript:void(0);" onclick="url_passar(0, \'m=projetos&a=licao_ver&licao_id='.$this->licao_id.'\');"><b>Clique para acessar a lição aprendida</b></a>';

				if ($tipo=='excluido') $corpo .= '<br><br><b>Responsável pela exclusão da lição aprendida:</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;
				elseif ($tipo=='atualizado') $corpo .= '<br><br><b>Responsável pela edição da lição aprendida:</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;
				else $corpo .= '<br><br><b>Criador da lição aprendida:</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;

				$email->Corpo($corpo, isset($GLOBALS['locale_char_set']) ? $GLOBALS['locale_char_set'] : '');
				if ($usuario['usuario_id']!=$Aplic->usuario_id && $usuario['usuario_id']) {
					if ($usuario['usuario_id']) msg_email_interno('', $titulo, $corpo,'',$usuario['usuario_id']);
					if ($email->EmailValido($usuario['contato_email']) && $config['email_ativo'] && $config['email_externo_auto']) {
						$email->Para($usuario['contato_email'], true);
						$email->Enviar();
						}
					}
				}
			}
		}

	}

?>