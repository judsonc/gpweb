<?php
/*
Copyright [2008] -  Sérgio Fernandes Reinert de Lima
Este arquivo é parte do programa gpweb
O gpweb é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.
Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL 2.odt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*/


class CObjetivo extends CAplicObjeto {

	var $objetivo_id = null;
  var $objetivo_cia = null;
  var $objetivo_dept = null;
  var $objetivo_superior = null;
  var $objetivo_nome = null;
  var $objetivo_data = null;
  var $objetivo_usuario = null;
  var $objetivo_ordem = null;
  var $objetivo_acesso = null;
  var $objetivo_perspectiva = null;
  var $objetivo_tema = null;
  var $objetivo_indicador = null;
  var $objetivo_cor = null;
  var $objetivo_oque = null;
  var $objetivo_descricao = null;
  var $objetivo_onde = null;
  var $objetivo_quando = null;
  var $objetivo_como = null;
  var $objetivo_porque = null;
  var $objetivo_quanto = null;
  var $objetivo_quem = null;
  var $objetivo_controle = null;
  var $objetivo_melhorias = null;
  var $objetivo_metodo_aprendizado = null;
  var $objetivo_desde_quando = null;
  var $objetivo_composicao = null;
  var $objetivo_ativo = null;
  var $objetivo_tipo = null;
	var $objetivo_percentagem = null;
	var $objetivo_tipo_pontuacao = null;
	var $objetivo_ponto_alvo = null;
	var $objetivo_aprovado = null;
	var $objetivo_moeda = null;
	
	function __construct() {
		parent::__construct('objetivo', 'objetivo_id');
		}


	function armazenar($atualizarNulos = false) {
		global $Aplic;
		$sql = new BDConsulta();
		if ($this->objetivo_id) {
			$ret = $sql->atualizarObjeto('objetivo', $this, 'objetivo_id', false);
			$sql->limpar();
			}
		else {
			$ret = $sql->inserirObjeto('objetivo', $this, 'objetivo_id');
			$sql->limpar();
			}

		require_once ($Aplic->getClasseSistema('CampoCustomizados'));

		$campos_customizados = new CampoCustomizados('objetivos', $this->objetivo_id, 'editar');
		$campos_customizados->join($_REQUEST);
		$campos_customizados->armazenar($this->objetivo_id);

		$objetivo_usuarios=getParam($_REQUEST, 'objetivo_usuarios', null);
		$objetivo_usuarios=explode(',', $objetivo_usuarios);
		$sql->setExcluir('objetivo_usuario');
		$sql->adOnde('objetivo_usuario_objetivo = '.$this->objetivo_id);
		$sql->exec();
		$sql->limpar();
		foreach($objetivo_usuarios as $chave => $usuario_id){
			if($usuario_id){
				$sql->adTabela('objetivo_usuario');
				$sql->adInserir('objetivo_usuario_objetivo', $this->objetivo_id);
				$sql->adInserir('objetivo_usuario_usuario', $usuario_id);
				$sql->exec();
				$sql->limpar();
				}
			}

		$depts_selecionados=getParam($_REQUEST, 'objetivo_depts', null);
		$depts_selecionados=explode(',', $depts_selecionados);
		$sql->setExcluir('objetivo_dept');
		$sql->adOnde('objetivo_dept_objetivo = '.$this->objetivo_id);
		$sql->exec();
		$sql->limpar();
		foreach($depts_selecionados as $chave => $dept_id){
			if($dept_id){
				$sql->adTabela('objetivo_dept');
				$sql->adInserir('objetivo_dept_objetivo', $this->objetivo_id);
				$sql->adInserir('objetivo_dept_dept', $dept_id);
				$sql->exec();
				$sql->limpar();
				}
			}

		$sql->setExcluir('objetivo_composicao');
		$sql->adOnde('objetivo_composicao_pai = '.$this->objetivo_id);
		$sql->exec();
		$sql->limpar();
		if (getParam($_REQUEST, 'objetivo_composicao', 0)){
			$lista_composicao = getParam($_REQUEST, 'lista_composicao', '');
			$vetor=explode(',',$lista_composicao);
			foreach($vetor as $chave => $campo){
				$sql->adTabela('objetivo_composicao');
				$sql->adInserir('objetivo_composicao_pai', $this->objetivo_id);
				$sql->adInserir('objetivo_composicao_filho', $campo);
				$sql->exec();
				$sql->limpar();
				}
			}

		if ($Aplic->profissional){
			$sql->setExcluir('objetivo_cia');
			$sql->adOnde('objetivo_cia_objetivo='.(int)$this->objetivo_id);
			$sql->exec();
			$sql->limpar();
			$cias=getParam($_REQUEST, 'objetivo_cias', '');
			$cias=explode(',', $cias);
			if (count($cias)) {
				foreach ($cias as $cia_id) {
					if ($cia_id){
						$sql->adTabela('objetivo_cia');
						$sql->adInserir('objetivo_cia_objetivo', $this->objetivo_id);
						$sql->adInserir('objetivo_cia_cia', $cia_id);
						$sql->exec();
						$sql->limpar();
						}
					}
				}
			}
		$uuid=getParam($_REQUEST, 'uuid', null);
		if ($uuid){
			$sql->adTabela('objetivo_perspectiva');
			$sql->adAtualizar('objetivo_perspectiva_objetivo', (int)$this->objetivo_id);
			$sql->adAtualizar('objetivo_perspectiva_uuid', null);
			$sql->adOnde('objetivo_perspectiva_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();
			}
		if ($Aplic->profissional && $uuid){
			$sql->adTabela('objetivo_media');
			$sql->adAtualizar('objetivo_media_objetivo', (int)$this->objetivo_id);
			$sql->adAtualizar('objetivo_media_uuid', null);
			$sql->adOnde('objetivo_media_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();

			$sql->adTabela('plano_acao_observador');
			$sql->adAtualizar('plano_acao_observador_objetivo', (int)$this->objetivo_id);
			$sql->adAtualizar('plano_acao_observador_uuid', null);
			$sql->adOnde('plano_acao_observador_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();

			$sql->adTabela('projeto_observador');
			$sql->adAtualizar('projeto_observador_objetivo', (int)$this->objetivo_id);
			$sql->adAtualizar('projeto_observador_uuid', null);
			$sql->adOnde('projeto_observador_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();

			$sql->adTabela('fator_observador');
			$sql->adAtualizar('fator_observador_objetivo', (int)$this->objetivo_id);
			$sql->adAtualizar('fator_observador_uuid', null);
			$sql->adOnde('fator_observador_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();
			
			
			
			
			$sql->adTabela('assinatura');
			$sql->adAtualizar('assinatura_objetivo', (int)$this->objetivo_id);
			$sql->adAtualizar('assinatura_uuid', null);
			$sql->adOnde('assinatura_uuid=\''.$uuid.'\'');
			$sql->exec();
			$sql->limpar();

			$sql->adTabela('priorizacao');
			$sql->adAtualizar('priorizacao_objetivo', (int)$this->objetivo_id);
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
			$sql->adOnde('assinatura_objetivo='.(int)$this->objetivo_id);
			$sql->adOnde('assinatura_atesta_opcao_aprova!=1 OR assinatura_atesta_opcao_aprova IS NULL');
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta_opcao > 0');
			$nao_aprovado1 = $sql->resultado();
			$sql->limpar();
			
			
			$sql->adTabela('assinatura');
			$sql->adCampo('count(assinatura_id)');
			$sql->adOnde('assinatura_objetivo='.(int)$this->objetivo_id);
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta IS NULL');
			$sql->adOnde('assinatura_data IS NULL OR (assinatura_data IS NOT NULL AND assinatura_aprovou=0)');
			$nao_aprovado2 = $sql->resultado();
			$sql->limpar();
			
			//assinatura que tem despacho mas nem assinou
			$sql->adTabela('assinatura');
			$sql->adCampo('count(assinatura_id)');
			$sql->adOnde('assinatura_objetivo='.(int)$this->objetivo_id);
			$sql->adOnde('assinatura_aprova=1');
			$sql->adOnde('assinatura_atesta IS NOT NULL');
			$sql->adOnde('assinatura_atesta_opcao IS NULL');
			$nao_aprovado3 = $sql->resultado();
			$sql->limpar();
			
			$nao_aprovado=($nao_aprovado1 || $nao_aprovado2 || $nao_aprovado3);
			
			$sql->adTabela('objetivo');
			$sql->adAtualizar('objetivo_aprovado', ($nao_aprovado ? 0 : 1));
			$sql->adOnde('objetivo_id='.(int)$this->objetivo_id);
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
		$valor=permiteAcessarObjetivo($this->objetivo_acesso, $this->objetivo_id);
		return $valor;
		}

	function podeEditar() {
		$valor=permiteEditarObjetivo($this->objetivo_acesso, $this->objetivo_id);
		return $valor;
		}

	function calculo_percentagem(){
		$tipo=$this->objetivo_tipo_pontuacao;

		$sql = new BDConsulta;
		$porcentagem=null;
		if (!$tipo) $porcentagem=$this->objetivo_percentagem;
		elseif($tipo=='media_ponderada'){
			$sql->adTabela('objetivo_media');
			$sql->esqUnir('me', 'me', 'me_id=objetivo_media_me');
			$sql->esqUnir('fator', 'fator', 'fator_id=objetivo_media_fator');
			$sql->esqUnir('estrategias', 'estrategias', 'pg_estrategia_id=objetivo_media_estrategia');
			$sql->esqUnir('projetos', 'projetos', 'projeto_id=objetivo_media_projeto');
			$sql->esqUnir('plano_acao', 'plano_acao', 'plano_acao_id=objetivo_media_acao');
			$sql->adCampo('
			fator_percentagem,
			me_percentagem,
			pg_estrategia_percentagem,
			projeto_percentagem,
			plano_acao_percentagem,
			objetivo_media_fator,
			objetivo_media_me,
			objetivo_media_estrategia,
			objetivo_media_projeto,
			objetivo_media_acao,
			objetivo_media_peso
			');

			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'media_ponderada\'');
			$lista = $sql->lista();
			$sql->limpar();
			$numerador=0;
			$denominador=0;

			foreach($lista as $linha){
				if ($linha['objetivo_media_fator']) $numerador+=($linha['fator_percentagem']*$linha['objetivo_media_peso']);
				elseif ($linha['objetivo_media_me']) $numerador+=($linha['me_percentagem']*$linha['objetivo_media_peso']);
				elseif ($linha['objetivo_media_estrategia']) $numerador+=($linha['pg_estrategia_percentagem']*$linha['objetivo_media_peso']);
				elseif ($linha['objetivo_media_projeto']) $numerador+=($linha['projeto_percentagem']*$linha['objetivo_media_peso']);
				elseif ($linha['objetivo_media_acao']) $numerador+=($linha['plano_acao_percentagem']*$linha['objetivo_media_peso']);
				$denominador+=$linha['objetivo_media_peso'];
				}
			$porcentagem=($denominador ? $numerador/$denominador : 0);
			}
		elseif($tipo=='pontos_completos'){
			$sql->adTabela('objetivo_media');
			$sql->esqUnir('fator', 'fator', 'fator_id=objetivo_media_fator');
			$sql->adCampo('SUM(objetivo_media_ponto)');
			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'pontos_completos\'');
			$sql->adOnde('fator_percentagem = 100');
			$sql->adOnde('objetivo_media_fator > 0');
			$pontos1 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('objetivo_media');
			$sql->esqUnir('me', 'me', 'me_id=objetivo_media_me');
			$sql->adCampo('SUM(objetivo_media_ponto)');
			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'pontos_completos\'');
			$sql->adOnde('me_percentagem = 100');
			$sql->adOnde('objetivo_media_me > 0');
			$pontos2 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('objetivo_media');
			$sql->esqUnir('estrategias', 'estrategias', 'pg_estrategia_id=objetivo_media_estrategia');
			$sql->adCampo('SUM(objetivo_media_ponto)');
			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'pontos_completos\'');
			$sql->adOnde('pg_estrategia_percentagem = 100');
			$sql->adOnde('objetivo_media_estrategia > 0');
			$pontos3 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('objetivo_media');
			$sql->esqUnir('projetos', 'projetos', 'projeto_id=objetivo_media_projeto');
			$sql->adCampo('SUM(objetivo_media_ponto)');
			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'pontos_completos\'');
			$sql->adOnde('projeto_percentagem = 100');
			$sql->adOnde('objetivo_media_projeto > 0');
			$pontos4 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('objetivo_media');
			$sql->esqUnir('plano_acao', 'plano_acao', 'plano_acao_id=objetivo_media_acao');
			$sql->adCampo('SUM(objetivo_media_ponto)');
			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'pontos_completos\'');
			$sql->adOnde('plano_acao_percentagem = 100');
			$sql->adOnde('objetivo_media_acao > 0');
			$pontos5 = $sql->Resultado();
			$sql->limpar();


			$porcentagem=($this->objetivo_ponto_alvo ? (($pontos1+$pontos2+$pontos3+$pontos4+$pontos5)/$this->objetivo_ponto_alvo)*100 : 0);
			}
		elseif($tipo=='pontos_parcial'){
			$sql->adTabela('objetivo_media');
			$sql->esqUnir('fator', 'fator', 'fator_id=objetivo_media_fator');
			$sql->adCampo('SUM(objetivo_media_ponto)');
			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'pontos_completos\'');
			$sql->adOnde('objetivo_media_fator > 0');
			$pontos1 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('objetivo_media');
			$sql->esqUnir('me', 'me', 'me_id=objetivo_media_me');
			$sql->adCampo('SUM(objetivo_media_ponto)');
			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'pontos_completos\'');
			$sql->adOnde('objetivo_media_me > 0');
			$pontos2 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('objetivo_media');
			$sql->esqUnir('estrategias', 'estrategias', 'pg_estrategia_id=objetivo_media_estrategia');
			$sql->adCampo('SUM(objetivo_media_ponto)');
			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'pontos_completos\'');
			$sql->adOnde('objetivo_media_estrategia > 0');
			$pontos3 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('objetivo_media');
			$sql->esqUnir('projetos', 'projetos', 'projeto_id=objetivo_media_projeto');
			$sql->adCampo('SUM(objetivo_media_ponto)');
			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'pontos_completos\'');
			$sql->adOnde('objetivo_media_projeto > 0');
			$pontos4 = $sql->Resultado();
			$sql->limpar();

			$sql->adTabela('objetivo_media');
			$sql->esqUnir('plano_acao', 'plano_acao', 'plano_acao_id=objetivo_media_acao');
			$sql->adCampo('SUM(objetivo_media_ponto)');
			$sql->adOnde('objetivo_media_objetivo ='.(int)$this->objetivo_id);
			$sql->adOnde('objetivo_media_tipo =\'pontos_completos\'');
			$sql->adOnde('objetivo_media_acao > 0');
			$pontos5 = $sql->Resultado();
			$sql->limpar();

			$porcentagem=($this->objetivo_ponto_alvo ? (($pontos1+$pontos2+$pontos3+$pontos4+$pontos5)/$this->objetivo_ponto_alvo)*100 : 0);
			}
		elseif($tipo=='indicador'){
			if ($this->objetivo_principal_indicador) {
				include_once BASE_DIR.'/modulos/praticas/indicador_simples.class.php';
				$obj_indicador = new Indicador($this->objetivo_principal_indicador);
				$porcentagem=$obj_indicador->Pontuacao();
				}
			else $porcentagem=0;
			}

		else $porcentagem=0; //caso nao previsto

		if ($porcentagem > 100) $porcentagem=100;
		if ($porcentagem!=$this->objetivo_percentagem){
			$sql->adTabela('objetivo');
			$sql->adAtualizar('objetivo_percentagem', $porcentagem);
			$sql->adOnde('objetivo_id ='.(int)$this->objetivo_id);
			$sql->exec();
			$sql->limpar();
			$this->disparo_observador('fisico');
			}
		return $porcentagem;
		}

	function disparo_observador($acao='fisico'){
		//Quem faz uso deste objetivo em cálculos de percentagem
		$sql = new BDConsulta;

		$sql->adTabela('objetivo_observador');
		$sql->adCampo('objetivo_observador.*');
		$sql->adOnde('objetivo_observador_objetivo ='.(int)$this->objetivo_id);
		if ($acao) $sql->adOnde('objetivo_observador_acao =\''.$acao.'\'');
		$lista = $sql->lista();
		$sql->limpar();
		$qnt_perspectiva=0;
		$qnt_tema=0;
		foreach($lista as $linha){
			if ($linha['objetivo_observador_perspectiva']){
				if (!($qnt_perspectiva++)) require_once BASE_DIR.'/modulos/praticas/perspectiva.class.php';
				$obj= new CPerspectiva();
				$obj->load($linha['objetivo_observador_perspectiva']);
				if (method_exists($obj, $linha['objetivo_observador_metodo'])){
					$obj->$linha['objetivo_observador_metodo']();
					}
				}
			elseif ($linha['objetivo_observador_tema']){
				if (!($qnt_tema++)) require_once BASE_DIR.'/modulos/praticas/tema.class.php';
				$obj= new CTema();
				$obj->load($linha['objetivo_observador_tema']);
				if (method_exists($obj, $linha['objetivo_observador_metodo'])){
					$obj->$linha['objetivo_observador_metodo']();
					}
				}
			}

		}


	function notificar($post=array()){
		global $Aplic, $config, $localidade_tipo_caract;

		require_once ($Aplic->getClasseSistema('libmail'));

		$sql = new BDConsulta;

		$sql->adTabela('objetivo');
		$sql->adCampo('objetivo_nome');
		$sql->adOnde('objetivo_id ='.$this->objetivo_id);
		$nome = $sql->Resultado();
		$sql->limpar();



		$usuarios =array();
		$usuarios1=array();
		$usuarios2=array();
		$usuarios3=array();
		$usuarios4=array();

		if ($post['objetivo_usuarios'] && isset($post['email_designados'])){
			$sql->adTabela('usuarios');
			$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('usuario_id IN ('.$post['objetivo_usuarios'].')');
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
			$sql->esqUnir('objetivo', 'objetivo', 'objetivo.objetivo_usuario = usuarios.usuario_id');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('objetivo_id='.$this->objetivo_id);
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
		elseif (isset($post['objetivo_id']) && $post['objetivo_id']) $tipo='atualizado';
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

				if ($tipo == 'excluido') $titulo=ucfirst($config['objetivo']).' excluíd'.$config['genero_objetivo'];
				elseif ($tipo=='atualizado') $titulo=ucfirst($config['objetivo']).' atualizad'.$config['genero_objetivo'];
				else $titulo=ucfirst($config['objetivo']).' inserid'.$config['genero_objetivo'];

				$email->Assunto($titulo, $localidade_tipo_caract);

				if ($tipo=='atualizado') $corpo = 'Atualizad'.$config['genero_objetivo'].' '.$config['genero_objetivo'].' '.$config['objetivo'].': '.$nome.'<br>';
				elseif ($tipo=='excluido') $corpo = 'Excluíd'.$config['genero_objetivo'].' '.$config['genero_objetivo'].' '.$config['objetivo'].': '.$nome.'<br>';
				else $corpo = 'Inserid'.$config['genero_objetivo'].' '.$config['genero_objetivo'].' '.$config['objetivo'].': '.$nome.'<br>';

				if ($tipo=='excluido') $corpo .= '<br><br><b>Responsável pela exclusão d'.$config['genero_objetivo'].' '.$config['objetivo'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;
				elseif ($tipo=='atualizado') $corpo .= '<br><br><b>Responsável pela edição d'.$config['genero_objetivo'].' '.$config['objetivo'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;
				else $corpo .= '<br><br><b>Criador d'.$config['genero_objetivo'].' '.$config['objetivo'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;


				$corpo_interno=$corpo;
				$corpo_externo=$corpo;

				if ($tipo!='excluido') {
					$corpo_interno .= '<br><a href="javascript:void(0);" onclick="url_passar(0, \'m=praticas&a=obj_estrategico_ver&objetivo_id='.$this->objetivo_id.'\');"><b>Clique para acessar '.$config['genero_objetivo'].' '.$config['objetivo'].'</b></a>';

					if ($Aplic->profissional){
						require_once BASE_DIR.'/incluir/funcoes_principais_pro.php';
						$endereco=link_email_externo($usuario['usuario_id'], 'm=praticas&a=obj_estrategico_ver&objetivo_id='.$this->objetivo_id);
						$corpo_externo.='<br><a href="'.$endereco.'"><b>Clique para acessar '.$config['genero_objetivo'].' '.$config['objetivo'].'</b></a>';
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

class CObjetivoLog extends CAplicObjeto {
	var $objetivo_log_id = null;
	var $objetivo_log_objetivo = null;
	var $objetivo_log_nome = null;
	var $objetivo_log_descricao = null;
	var $objetivo_log_criador = null;
	var $objetivo_log_horas = null;
	var $objetivo_log_data = null;
	var $objetivo_log_nd = null;
	var $objetivo_log_categoria_economica = null;
	var $objetivo_log_grupo_despesa = null;
	var $objetivo_log_modalidade_aplicacao = null;
	var $objetivo_log_problema = null;
	var $objetivo_log_referencia = null;
	var $objetivo_log_url_relacionada = null;
	var $objetivo_log_custo = null;
	var $objetivo_log_acesso = null;

	function __construct() {
		parent::__construct('objetivo_log', 'objetivo_log_id');
		$this->objetivo_log_problema = intval($this->objetivo_log_problema);
		}


	function arrumarTodos() {
		$descricaoComEspacos = $this->objetivo_log_descricao;
		parent::arrumarTodos();
		$this->objetivo_log_descricao = $descricaoComEspacos;
		}

	function check() {
		$this->objetivo_log_horas = (float)$this->objetivo_log_horas;
		return null;
		}


	function podeAcessar() {
		$valor=permiteAcessarObjetivo($this->objetivo_log_acesso, $this->objetivo_log_objetivo);
		return $valor;
		}

	function podeEditar() {
		$valor=permiteEditarObjetivo($this->objetivo_log_acesso, $this->objetivo_log_objetivo);
		return $valor;
		}




	function notificar($post=array()){
		global $Aplic, $config, $localidade_tipo_caract;

		require_once ($Aplic->getClasseSistema('libmail'));

		$sql = new BDConsulta;

		$sql->adTabela('objetivo');
		$sql->adCampo('objetivo_nome');
		$sql->adOnde('objetivo_id ='.$post['objetivo_log_objetivo']);
		$nome = $sql->Resultado();
		$sql->limpar();


		$usuarios =array();
		$usuarios1=array();
		$usuarios2=array();
		$usuarios3=array();
		$usuarios4=array();

		if ($post['email_objetivo_lista'] && isset($post['email_designados'])){
			$sql->adTabela('usuarios');
			$sql->esqUnir('contatos', 'contatos', 'contato_id = usuario_contato');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('contato_id IN ('.$post['email_objetivo_lista'].')');
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
			$sql->esqUnir('objetivo', 'objetivo', 'objetivo.objetivo_usuario = usuarios.usuario_id');
			$sql->adCampo('DISTINCT usuarios.usuario_id, '.($config['militar'] < 10 ? 'concatenar_tres(contato_posto, \' \', contato_nomeguerra)' : 'contato_nomeguerra').' AS nome_usuario, contato_email');
			$sql->adOnde('objetivo_id='.$post['objetivo_log_objetivo']);
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
		elseif (isset($post['objetivo_log_id']) && $post['objetivo_log_id']) $tipo='atualizado';
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

				if ($tipo == 'excluido') $titulo='Registro de ocorrência de '.$config['genero_objetivo'].' excluído';
				elseif ($tipo=='atualizado') $titulo='Registro de ocorrência de '.$config['genero_objetivo'].' atualizado';
				else $titulo='Registro de ocorrência de '.$config['genero_objetivo'].' inserido';

				$email->Assunto($titulo, $localidade_tipo_caract);

				if ($tipo=='atualizado') $corpo = 'Atualizado o registro de ocorrência d'.$config['genero_objetivo'].' '.$config['objetivo'].': '.$nome.'<br>';
				elseif ($tipo=='excluido') $corpo = 'Excluído o registro de ocorrência d'.$config['genero_objetivo'].' '.$config['objetivo'].': '.$nome.'<br>';
				else $corpo = 'Inserido o registro de ocorrência d'.$config['genero_objetivo'].' '.$config['objetivo'].': '.$nome.'<br>';

				if ($tipo=='excluido') $corpo .= '<br><br><b>Responsável pela exclusão do registro de ocorrência d'.$config['genero_objetivo'].' '.$config['objetivo'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;
				elseif ($tipo=='atualizado') $corpo .= '<br><br><b>Responsável pela edição do registro de ocorrência d'.$config['genero_objetivo'].' '.$config['objetivo'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;
				else $corpo .= '<br><br><b>Criador do registro de ocorrência d'.$config['genero_objetivo'].' '.$config['objetivo'].':</b> '.$Aplic->usuario_posto.' '.$Aplic->usuario_nomeguerra;


				$corpo_interno=$corpo;
				$corpo_externo=$corpo;

				if ($tipo!='excluido') {
					$corpo_interno .= '<br><a href="javascript:void(0);" onclick="url_passar(0, \'m=praticas&a=obj_estrategico_ver&objetivo_id='.$post['objetivo_log_objetivo'].'\');"><b>Clique para acessar o registro de ocorrência d'.$config['genero_objetivo'].' '.$config['objetivo'].'</b></a>';

					if ($Aplic->profissional){
						require_once BASE_DIR.'/incluir/funcoes_principais_pro.php';
						$endereco=link_email_externo($usuario['usuario_id'], 'm=praticas&a=obj_estrategico_ver&objetivo_id='.$post['objetivo_log_objetivo']);
						$corpo_externo.='<br><a href="'.$endereco.'"><b>Clique para acessar o registro de ocorrência d'.$config['genero_objetivo'].' '.$config['objetivo'].'</b></a>';
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