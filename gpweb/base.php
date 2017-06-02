<?php
/*
Copyright (c) 2007-2011 The web2Project Development Team <w2p-developers@web2project.net>
Copyright (c) 2003-2007 The dotProject Development Team <core-developers@dotproject.net>
Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*/

/********************************************************************************************

gpweb\base.php

Configura as constantes	BASE_DIR e BASE_URL

********************************************************************************************/

if (!ini_get('safe_mode')) @set_time_limit(0);

//ini_set('default_charset', 'ISO-8859-1');

//Comente as duas linhas de baixo caso n�o queira que o PHP exiba notifica��es e mensagens de erro
ini_set('display_errors', 1);
error_reporting(E_ALL);
//error_reporting(0);
//error_reporting(E_ALL & ~ E_NOTICE);

//cria as constantes BASE_DIR e BASE_URL
$baseDir = dirname(__file__);
$baseUrl = get_base_url();

define('BASE_DIR', $baseDir);

date_default_timezone_set('America/Sao_Paulo');

function safe_get_env($nome) {
	if (isset($_SERVER[$nome])) return $_SERVER[$nome];
	elseif (strpos(php_sapi_name(), 'apache') === false) getenv($nome);
	else return '';
	}

function get_host() {
    if ($host = safe_get_env('HTTP_X_FORWARDED_HOST')){
        $elements = explode(',', $host);
        $host = trim(end($elements));
        }
    else{
        if (!($host = safe_get_env('HTTP_HOST'))){
            if (!($host = safe_get_env('SERVER_NAME'))){
                $host = safe_get_env('SERVER_ADDR');
                $host = !empty($host) ? $host : '';
                }
            }
        }

    // Remove port number from host
    //$host = preg_replace('/:\d+$/', '', $host);

    return trim($host);
    }

function get_protocol() {
    if(isset($_REQUEST['protocolo'])){
        return $_REQUEST['protocolo'] . '//';
    }

    if(isset($_SESSION['gpweb_protocolo'])){
        return $_SESSION['gpweb_protocolo'] . '//';
    }

    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        return 'https://';
        }
    else if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
        return 'https://';
        }
    else if(isset($_SERVER['HTTP_X_FORWARDED_SSL']) && !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && ( $_SERVER['HTTP_X_FORWARDED_SSL'] == 1 || $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on' ) ){
        return 'https://';
        }

    return 'http://';
    }

function get_base_url(){
    $baseUrl = get_protocol();
    $baseUrl .= get_host();
    $caminhoInfo = safe_get_env('PATH_INFO');
    if ($caminhoInfo) $baseUrl .= str_replace('\\', '/', dirname($caminhoInfo));
    else $baseUrl .= str_replace('\\', '/', dirname(safe_get_env('SCRIPT_NAME')));
    $baseUrl = preg_replace('#/$#D', '', $baseUrl);
    $baseUrl = str_replace('/codigo', '', $baseUrl);

    return $baseUrl;
    }
?>