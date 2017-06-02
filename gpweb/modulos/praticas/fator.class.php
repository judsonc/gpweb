<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*/


class CFator extends CAplicObjeto {

	var $fator_id = null;
	var $fator_cia = null;
	var $fator_dept = null;
	var $fator_nome = null;
	var $fator_data = null;
	var $fator_usuario = null;
	var $fator_principal_indicador = null;
	var $fator_ordem = null;
	var $fator_objetivo = null;
	var $fator_acesso = null;
	var $fator_cor = null;
	var $fator_oque = null;
	var $fator_descricao = null;
	var $fator_onde = null;
	var $fator_quando = null;
	var $fator_como = null;
	var $fator_porque = null;
	var $fator_quanto = null;
	var $fator_quem = null;
	var $fator_controle = null;
	var $fator_melhorias = null;
	var $fator_metodo_aprendizado = null;
	var $fator_desde_quando = null;
	var $fator_ativo = null;
	var $fator_tipo = null;
	var $fator_tipo_pontuacao = null;
	var $fator_percentagem = null;
  var $fator_ponto_alvo = null;
	var $fator_aprovado = null;
	var $fator_moeda = null;

	function __construct() {
		parent::__construct('fator', 'fator_id');
		}


	function armazenar($atualizarNulos = false) {
		global $Aplic;
		$sql = new BDConsulta();
		if ($this->fator_id) {
			$ret = $sql->atualizarObjeto('fator', $this, 'fator_id', false);
			$sql->limpar();
			}
		else {
			$ret = $sql->inserirObjeto('fator', $this, 'fator_id');
			$sql->limpar();
			}

		require_once ($Aplic->getClasseSistema('CampoCustomizados'));
		$campos_customizados = new CampoCustomizados('fatores', $this->fator_id, 'editar');
		$campos_customizados->join($_REQUEST);
		$campos_customizados->armazenar($this->fator_id);


		$fator_usuarios=getParam($_REQUEST, 'fator_usuarios', null);
		$fator_usuarios=explode(',', $fator_usuarios);
		$sql->setExcluir('fator_usuario');
		$sql->adOnde('fator_usuario_fator ='.(int)$this->fator_id);
		$sql->exec();
		$sql->limpar();
		foreach($fator_usuarios as $chave => $usuario_id){
			if($usuario_id){
				$sql->adTabela('fator_usuario');
				$sql->adInserir('fator_usuario_fator', $this->fator_id);
				$sql->adInserir('fator_usuario_usuario', $usuario_id);
				$sql->exec();
				$sql->limpar();
				}
			}

		$depts_selecionados=getParam($_REQUEST, 'fator_depts', null);
		$depts_selecionados=explode(',', $depts_selecionados);
		$sql->setExcluir('fator_dept');
		$sql->adOnde('fator_dept_fator ='.(int)$this->fator_id);
		$sql->exec();
		$sql->limpar();
		foreach($depts_selecionados as $chave => $dept_id){
			if($dept_id){
				$sql->adTabela('fator_dept');
				$sql->adInserir('fator_dept_fator', $this->fator_id);
				$sql->adInserir('fator_dept_dept', $dept_id);
				$sql->exec();
				$sql->limpar();
				}
			}

		if ($Aplic->profissional){
			$sql->setExcluir('fator_cia');
			$sql->adOnde('fator_cia_fator='.(int)$this->fator_id);
			$sql->exec();
			$sql->limpar();
			$cias=getParam($_REQUEST, 'fator_cias', '');
			$cias=explode(',', $cias);
			if (count($cias)) {
				foreach ($cias as $cia_id) {
					if ($cia_id){
						$sql->adTabela('fator_cia');
						$sql->adInserir('fator_cia_fator', $this->fator_id);
						$sql->adInserir('fator_cia_cia', $cia_id);
						$sql->exec();
						$sql->limpar();
						}
					}
				}
			}


		$uuid=getParam($_REQUEST, 'uuid', null);
		if ($uuid){
			$sql->adTabela('fator_objetivo');
			$sql->adAtualizar('fator_objetivo_fator', (int)$this->fator_id);
			$sql->adAtualizar('fator_objetivo_uuid', null);
			$sql->adOnde('fator_objetivo_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();
			}
		if ($Aplic->profissional && $uuid){
			$sql->adTabela('fator_media');
			$sql->adAtualizar('fator_media_fator', (int)$this->fator_id);
			$sql->adAtualizar('fator_media_uuid', null);
			$sql->adOnde('fator_media_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();

			$sql->adTabela('plano_acao_observador');
			$sql->adAtualizar('plano_acao_observador_fator', (int)$this->fator_id);
			$sql->adAtualizar('plano_acao_observador_uuid', null);
			$sql->adOnde('plano_acao_observador_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();

			$sql->adTabela('projeto_observador');
			$sql->adAtualizar('projeto_observador_fator', (int)$this->fator_id);
			$sql->adAtualizar('projeto_observador_uuid', null);
			$sql->adOnde('projeto_observador_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();

			$sql->adTabela('estrategia_observador');
			$sql->adAtualizar('estrategia_observador_fator', (int)$this->fator_id);
			$sql->adAtualizar('estrategia_observador_uuid', null);
			$sql->adOnde('estrategia_observador_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();
			
			
			$sql->adTabela('assinatura');
			$sql->adAtualizar('assinatura_fator', (int)$this->fator_id);
			$sql->adAtualizar('assinatura_uuid', null);
			$sql->adOnde('assinatura_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();

			$sql->adTabela('priorizacao');
			$sql->adAtualizar('priorizacao_fator', (int)$this->fator_id);
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
			$sql->adOnde('assinatura_fator='.(int)$this->fator_id);
			$sql->adOnde('assinatura_atesta_opcao_aprova!=1 OR assinatura_atesta_opcao_aprova IS NULL');
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta_opcao > 0');
			$nao_aprovado1 = $sql->resultado();
			$sql->limpar();
			
			
			$sql->adTabela('assinatura');
			$sql->adCampo('count(assinatura_id)');
			$sql->adOnde('assinatura_fator='.(int)$this->fator_id);
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta IS NULL');
			$sql->adOnde('assinatura_data IS NULL OR (assinatura_data IS NOT NULL AND assinatura_aprovou=0)');
			$nao_aprovado2 = $sql->resultado();
			$sql->limpar();
			
			//assinatura que tem despacho mas nem assinou
			$sql->adTabela('assinatura');
			$sql->adCampo('count(assinatura_id)');
			$sql->adOnde('assinatura_fator='.(int)$this->fator_id);
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta IS NOT NULL');
			$sql->adOnde('assinatura_atesta_opcao IS NULL');
			$nao_aprovado3 = $sql->resultado();
			$sql->limpar();
			
			$nao_aprovado=($nao_aprovado1 || $nao_aprovado2 || $nao_aprovado3);
			
			$sql->adTabela('fator');
			$sql->adAtualizar('fator_aprovado', ($nao_aprovado ? 0 : 1));
			$sql->adOnde('fator_id='.(int)$this->fator_id);
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
		$valor=permiteAcessarFator($this->fator_acesso, $this->fator_id);
		return $valor;
		}

	function podeEditar() {
		$valor=permiteEditarFator($this->fator_acesso, $this->fator_id);
		return $valor;
		}


	function calculo_percentagem(){
		$tipo=$this->fator_tipo_pontuacao;

		$sql = new BDConsulta;
		$porcentagem=null;
		if (!$tipo) $porcentagem=$this->fator_percentagem;
		elseif($tipo=='media_ponderada'){
			$sql->adTabela('fator_media');
			$sql->esqUnir('estrategias', 'estrategias', 'pg_estrategia_id=fator_media_estrategia');
			$sql->esqUnir('projetos', 'projetos', 'projeto_id=fator_media_projeto');
			$sql->esqUnir('plano_acao', 'plano_acao', 'plano_acao_id=fator_media_acao');
			$sql->adCampo('
			pg_estrategia_percentagem,
			projeto_percentagem,
			plano_acao_percentagem,
			fator_media_estrategia,
			fator_media_projeto,
			fator_media_acao,
			fator_media_peso
			');

			$sql->adOnde('fator_media_fator ='.(int)$this->fator_id);
			$sql->adOnde('fator_media_tipo =\'media_ponderada\'');
			$lista = $sql->lista();
			$sql->limpar();
			$numerador=0;
			$denominador=0;

			foreach($lista as $linha){
				if ($linha['fator_media_estrategia']) $numerador+=($linha['pg_estrategia_percentagem']*$linha['fator_media_peso']);
				elseif ($linha['fator_media_projeto']) $numerador+=($linha['projeto_percentagem']*$linha['fator_media_peso']);
				elseif ($linha['fator_media_acao']) $numerador+=($linha['plano_acao_percentagem']*$linha['fator_media_peso']);
				$denominador+=$linha['fator_media_peso'];
				}
			$porcentagem=($denominador ? $numerador/$denominador : 0);
			}
		elseif($tipo=='pontos_completos'){


			$sql->adTabela('fator_media');
			$sql->esqUnir('estrategias', 'estrategias', 'pg_estrategia_id=fator_media_estrategia');
			$sql->adCampo('SUM(fator_media_ponto)');
			$sql->adOnde('fator_media_fator ='.(int)$this->fator_id);
			$sql->adOnde('fator_media_tipo =\'pontos_completos\'');
			$sql->adOnde('pg_estrategia_percentagem = 100');
			$sql->adOnde('fator_media_estrategia > 0');
			$pontos3 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('fator_media');
			$sql->esqUnir('projetos', 'projetos', 'projeto_id=fator_media_projeto');
			$sql->adCampo('SUM(fator_media_ponto)');
			$sql->adOnde('fator_media_fator ='.(int)$this->fator_id);
			$sql->adOnde('fator_media_tipo =\'pontos_completos\'');
			$sql->adOnde('projeto_percentagem = 100');
			$sql->adOnde('fator_media_projeto > 0');
			$pontos4 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('fator_media');
			$sql->esqUnir('plano_acao', 'plano_acao', 'plano_acao_id=fator_media_acao');
			$sql->adCampo('SUM(fator_media_ponto)');
			$sql->adOnde('fator_media_fator ='.(int)$this->fator_id);
			$sql->adOnde('fator_media_tipo =\'pontos_completos\'');
			$sql->adOnde('plano_acao_percentagem = 100');
			$sql->adOnde('fator_media_acao > 0');
			$pontos5 = $sql->Resultado();
			$sql->limpar();


			$porcentagem=($this->fator_ponto_alvo ? (($pontos3+$pontos4+$pontos5)/$this->fator_ponto_alvo)*100 : 0);
			}
		elseif($tipo=='pontos_parcial'){


			$sql->adTabela('fator_media');
			$sql->esqUnir('estrategias', 'estrategias', 'pg_estrategia_id=fator_media_estrategia');
			$sql->adCampo('SUM(fator_media_ponto)');
			$sql->adOnde('fator_media_fator ='.(int)$this->fator_id);
			$sql->adOnde('fator_media_tipo =\'pontos_completos\'');
			$sql->adOnde('fator_media_estrategia > 0');
			$pontos3 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('fator_media');
			$sql->esqUnir('projetos', 'projetos', 'projeto_id=fator_media_projeto');
			$sql->adCampo('SUM(fator_media_ponto)');
			$sql->adOnde('fator_media_fator ='.(int)$this->fator_id);
			$sql->adOnde('fator_media_tipo =\'pontos_completos\'');
			$sql->adOnde('fator_media_projeto > 0');
			$pontos4 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('fator_media');
			$sql->esqUnir('plano_acao', 'plano_acao', 'plano_acao_id=fator_media_acao');
			$sql->adCampo('SUM(fator_media_ponto)');
			$sql->adOnde('fator_media_fator ='.(int)$this->fator_id);
			$sql->adOnde('fator_media_tipo =\'pontos_completos\'');
			$sql->adOnde('fator_media_acao > 0');
			$pontos5 = $sql->Resultado();
			$sql->limpar();

			$porcentagem=($this->fator_ponto_alvo ? (($pontos3+$pontos4+$pontos5)/$this->fator_ponto_alvo)*100 : 0);
			}
		elseif($tipo=='indicador'){
			if ($this->fator_principal_indicador) {
				include_once BASE_DIR.'/modulos/praticas/indicador_simples.class.php';
				$obj_indicador = new Indicador($this->fator_principal_indicador);
				$porcentagem=$obj_indicador->Pontuacao();
				}
			else $porcentagem=0;
			}

		else $porcentagem=0; //caso nao previsto

		if ($porcentagem > 100) $porcentagem=100;
		if ($porcentagem!=$this->fator_percentagem){
			$sql->adTabela('fator');
			$sql->adAtualizar('fator_percentagem', $porcentagem);
			$sql->adOnde('fator_id ='.(int)$this->fator_id);
			$sql->exec();
			$sql->limpar();
			$this->disparo_observador('fisico');
			}
		return $porcentagem;
		}

	function disparo_observador($acao='fisico'){
		//Quem faz uso deste fator em cálculos de percentagem
		$sql = new BDConsulta;

		$sql->adTabela('fator_observador');
		$sql->adCampo('fator_observador.*');
		$sql->adOnde('fator_observador_fator ='.(int)$this->fator_id);
		if ($acao) $sql->adOnde('fator_observador_acao =\''.$acao.'\'');
		$lista = $sql->lista();
		$sql->limpar();
		$qnt_objetivo=0;
		$qnt_me=0;
		foreach($lista as $linha){
			if ($linha['fator_observador_objetivo']){
				if (!($qnt_objetivo++)) require_once BASE_DIR.'/modulos/praticas/obj_estrategico.class.php';
				$obj= new CObjetivo();
				$obj->load($linha['fator_observador_objetivo']);
				if (method_exists($obj, $linha['fator_observador_metodo'])){
					$obj->$linha['fator_observador_metodo']();
					}
				}
			elseif ($linha['fator_observador_me']){
				if (!($qnt_me++)) require_once BASE_DIR.'/modulos/praticas/me_pro.class.php';
				$obj= new CMe();
				$obj->load($linha['fator_observador_me']);
				if (method_exists($obj, $linha['fator_observador_metodo'])){
					$obj->$linha['fator_observador_metodo']();
					}
				}
			}

		}


	function notificar($post=array()){
		global $Aplic, $config, $localidade_tipo_caract;

		require_once ($Aplic->getClasseSistema('libmail'));

		$sql = new BDConsulta;

		$sql->adTabela('fator');
		$sql->adCampo('fator_nome');
		$sql->adOnde('fator_id ='.(int)$this->fator_id);
		$nome = $sql->Resultado();
		$sql->limpar();



		$usuarios =array();
		$usuarios1=array();
		$usuarios2=array();
		$usuarios3=array();
		$usuarios4=array();

		if ($post['fator_usuarios'] && isset($post['email_designados'])){
			$sql->adTabela('usuarios');
			$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('usuario_id IN ('.$post['fator_usuarios'].')');
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

		if (isset($post['email_responsavel'])){
			$sql->adTabela('usuarios');
			$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
			$sql->esqUnir('fator', 'fator', 'fator.fator_usuario = usuarios.usuario_id');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('fator_id='.(int)$this->fator_id);
			$usuarios3=$sql->Lista();
			$sql->limpar();
			}

		if (isset($post['email_extras']) && $post['email_extras']){
			$extras=explode(',',$post['email_extras']);
			foreach($extras as $chave => $valor) $usuarios4[]=array('usuario_id' => 0, 'nome_usuario' =>'', 'contato_email'=> $valor);
			}



		$usuarios = array_merge((array)$usuarios1, (array)$usuarios2);
		$usuarios = array_merge((array)$usuarios, (array)$usuarios3);
		$usuarios = array_merge((array)$usuarios, (array)$usuarios4);


		$usado_usuario=array();
		$usado_email=array();

		if (isset($post['del']) && $post['del'])$tipo='excluido';
		elseif (isset($post['fator_id']) && $post['fator_id']) $tipo='atualizado';
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

				if ($tipo == 'excluido') $titulo='Fator crítico de sucesso excluído';
				elseif ($tipo=='atualizado') $titulo='Fator crítico de sucesso atualizado';
				else $titulo='Fator crítico de sucesso inserido';

				$email->Assunto($titulo, $localidade_tipo_caract);

				if ($tipo=='atualizado') $corpo = 'Atualizado '.$config['genero_fator'].' '.$config['fator'].': '.$nome.'<br>';
				elseif ($tipo=='excluido') $corpo = 'Excluído '.$config['genero_fator'].' '.$config['fator'].': '.$nome.'<br>';
				else $corpo = 'Inserido '.$config['genero_fator'].' '.$config['fator'].': '.$nome.'<br>';

				if ($tipo=='excluido') $corpo .= '<br><br><b>Responsável pela exclusão d'.$config['genero_fator'].' '.$config['fator'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;
				elseif ($tipo=='atualizado') $corpo .= '<br><br><b>Responsável pela edição d'.$config['genero_fator'].' '.$config['fator'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;
				else $corpo .= '<br><br><b>Criador d'.$config['genero_fator'].' '.$config['fator'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;


				$corpo_interno=$corpo;
				$corpo_externo=$corpo;

				if ($tipo!='excluido') {
					$corpo_interno .= '<br><a href="javascript:void(0);" onclick="url_passar(0, \'m=praticas&a=fator_ver&fator_id='.(int)$this->fator_id.'\');"><b>Clique para acessar '.$config['genero_fator'].' '.$config['fator'].'</b></a>';

					if ($Aplic->profissional){
						require_once BASE_DIR.'/incluir/funcoes_principais_pro.php';
						$endereco=link_email_externo($usuario['usuario_id'], 'm=praticas&a=fator_ver&fator_id='.(int)$this->fator_id);
						$corpo_externo.='<br><a href="'.$endereco.'"><b>Clique para acessar '.$config['genero_fator'].' '.$config['fator'].'</b></a>';
						}
					}

				$email->Corpo($corpo_externo, (isset($GLOBALS['locale_char_set']) ? $GLOBALS['locale_char_set'] : $localidade_tipo_caract));
				if ($usuario['usuario_id']!=$Aplic->usuario_id && $usuario['usuario_id']) {
					if ($usuario['usuario_id']) msg_email_interno('', $titulo, $corpo_interno,'',$usuario['usuario_id']);
					if ($email->EmailValido($usuario['contato_email']) && $config['email_ativo'] && $config['email_externo_auto']) {
						$email->Para($usuario['contato_email'], true);
						$email->Enviar();
						}
					}
				}
			}
		}






	}

class CFatorLog extends CAplicObjeto {
	var $fator_log_id = null;
	var $fator_log_fator = null;
	var $fator_log_nome = null;
	var $fator_log_descricao = null;
	var $fator_log_criador = null;
	var $fator_log_horas = null;
	var $fator_log_data = null;
	var $fator_log_nd = null;
	var $fator_log_categoria_economica = null;
	var $fator_log_grupo_despesa = null;
	var $fator_log_modalidade_aplicacao = null;
	var $fator_log_problema = null;
	var $fator_log_referencia = null;
	var $fator_log_url_relacionada = null;
	var $fator_log_custo = null;
	var $fator_log_acesso = null;

	function __construct() {
		parent::__construct('fator_log', 'fator_log_id');
		$this->fator_log_problema = intval($this->fator_log_problema);
		}


	function arrumarTodos() {
		$descricaoComEspacos = $this->fator_log_descricao;
		parent::arrumarTodos();
		$this->fator_log_descricao = $descricaoComEspacos;
		}

	function check() {
		$this->fator_log_horas = (float)$this->fator_log_horas;
		return null;
		}


	function podeAcessar() {
		$valor=permiteAcessarFator($this->fator_log_acesso, $this->fator_log_fator);
		return $valor;
		}

	function podeEditar() {
		$valor=permiteEditarFator($this->fator_log_acesso, $this->fator_log_fator);
		return $valor;
		}




	function notificar($post=array()){
		global $Aplic, $config, $localidade_tipo_caract;

		require_once ($Aplic->getClasseSistema('libmail'));

		$sql = new BDConsulta;

		$sql->adTabela('fator');
		$sql->adCampo('fator_nome');
		$sql->adOnde('fator_id ='.(int)$post['fator_log_fator']);
		$nome = $sql->Resultado();
		$sql->limpar();

		$usuarios =array();
		$usuarios1=array();
		$usuarios2=array();
		$usuarios3=array();
		$usuarios4=array();

		if ($post['email_fator_lista'] && isset($post['email_designados'])){
			$sql->adTabela('usuarios');
			$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('contato_id IN ('.$post['email_fator_lista'].')');
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

		if (isset($post['email_responsavel'])){
			$sql->adTabela('usuarios');
			$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
			$sql->esqUnir('fator', 'fator', 'fator.fator_usuario = usuarios.usuario_id');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('fator_id='.(int)$post['fator_log_fator']);
			$usuarios3=$sql->Lista();
			$sql->limpar();
			}

		if (isset($post['email_extras']) && $post['email_extras']){
			$extras=explode(',',$post['email_extras']);
			foreach($extras as $chave => $valor) $usuarios4[]=array('usuario_id' => 0, 'nome_usuario' =>'', 'contato_email'=> $valor);
			}



		$usuarios = array_merge((array)$usuarios1, (array)$usuarios2);
		$usuarios = array_merge((array)$usuarios, (array)$usuarios3);
		$usuarios = array_merge((array)$usuarios, (array)$usuarios4);


		$usado_usuario=array();
		$usado_email=array();

		if (isset($post['del']) && $post['del'])$tipo='excluido';
		elseif (isset($post['fator_log_id']) && $post['fator_log_id']) $tipo='atualizado';
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

				if ($tipo == 'excluido') $titulo='Registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].' excluído';
				elseif ($tipo=='atualizado') $titulo='Registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].' atualizado';
				else $titulo='Registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].' inserido';

				$email->Assunto($titulo, $localidade_tipo_caract);

				if ($tipo=='atualizado') $corpo = 'Atualizado o registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].': '.$nome.'<br>';
				elseif ($tipo=='excluido') $corpo = 'Excluído o registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].': '.$nome.'<br>';
				else $corpo = 'Inserido o registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].': '.$nome.'<br>';

				if ($tipo=='excluido') $corpo .= '<br><br><b>Responsável pela exclusão do registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;
				elseif ($tipo=='atualizado') $corpo .= '<br><br><b>Responsável pela edição do registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;
				else $corpo .= '<br><br><b>Criador do registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;


				$corpo_interno=$corpo;
				$corpo_externo=$corpo;

				if ($tipo!='excluido') {
					$corpo_interno .= '<br><a href="javascript:void(0);" onclick="url_passar(0, \'m=praticas&a=fator_ver&tab=0&fator_id='.(int)$post['fator_log_fator'].'\');"><b>Clique para acessar o registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].'</b></a>';

					if ($Aplic->profissional){
						require_once BASE_DIR.'/incluir/funcoes_principais_pro.php';
						$endereco=link_email_externo($usuario['usuario_id'], 'm=praticas&a=fator_ver&tab=0&fator_id='.(int)$post['fator_log_fator']);
						$corpo_externo.='<br><a href="'.$endereco.'"><b>Clique para acessar o registro de ocorrência d'.$config['genero_fator'].' '.$config['fator'].'</b></a>';
						}
					}

				$email->Corpo($corpo_externo, (isset($GLOBALS['locale_char_set']) ? $GLOBALS['locale_char_set'] : $localidade_tipo_caract));
				if ($usuario['usuario_id']!=$Aplic->usuario_id && $usuario['usuario_id']) {
					if ($usuario['usuario_id']) msg_email_interno('', $titulo, $corpo_interno,'',$usuario['usuario_id']);
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