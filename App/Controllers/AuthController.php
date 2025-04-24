<?php

namespace App\Controllers;

use App\Helper\Alertas;
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action
{

    public function autenticar()
    {
        $usuarioModel =  Container::getModel('Usuario');
        $usuarioModel->__set('cod_corretor', $_POST['cod_corretor']);
        $usuarioModel->__set('senha', md5($_POST['senha']));

        $dados = $usuarioModel->autenticar();

        if ($dados->__get('id_usuario') != '' && $dados->__get('nome') != '') {
            session_start();
            $_SESSION['id_usuario'] = $dados->__get('id_usuario');
            $_SESSION['cod_corretor'] = $dados->__get('cod_corretor');
            $_SESSION['nome'] = $dados->__get('nome');
            $_SESSION['atualizado'] = $dados->__get('atualizado');
            $_SESSION['admin'] = $dados->__get('admin');
            $_SESSION['inativo'] = $dados->__get('inativo');
            $_SESSION['nivel'] = $dados->__get('nivel');

            $id_usuario = $_SESSION['id_usuario'];
            $this->ultimoLogin($id_usuario);
            header('Location: /inicio');
        } else {
            header('Location: /?login=error');
        }
    }

    public function index()
    {
        $this->view->login = isset($_GET['login']) ? isset($_GET['login']) : '';
        $this->render('login');
    }

    public function recuperarSenha()
    {
        $this->render('recuperar_senha');
    }
    public function enviarToken()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //verificar se email existe
            $email_recuperar = $_POST['email'];
            $usuarioModel = Container::getModel('Usuario');
            $email = $usuarioModel->verificaDadosUsuario('email', 'email', $email_recuperar);

            if (empty($email)) {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible'>
                  Email não encontrado!
                </div>";
                header('Location: /recuperar-senha');
            } else {

                $token = bin2hex(random_bytes(36));
                $usuarioModel->__set('email', $email);
                $usuarioModel->__set('token', $token);
                $usuarioModel->enviarRecuperarSenha();

                //Enviar email;
                $email = new PhpMailerController;
                $para = $email;
                $assunto = 'Mudar senha';
                $uri_proposta = 'www.seusite.com.br/recuperar-senha/nova-senha?token=' . $token . '&email=' . $email;
                //erro ao enviar email;
                $email->emailRecuperarSenha($para, $assunto, $uri_proposta);
                header('Location: /recuperar-senha');
            }
        }
    }
    public function mudarSenha()
    {
        //CRIAR TELA PARA MUDAR A SENHA
        //Excluir token
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
    }

    public function validarAutenticacao()
    {
        session_start();
        date_default_timezone_set('America/Bahia');
        if (
            !isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != '' &&
            !isset($_SESSION['nome']) || $_SESSION['nome'] != '' &&
            !isset($_SESSION['inativo']) || $_SESSION['inativo'] == 1
        ) {
            header('Location: /?login=error');
        }

        $dados_atualizado = $_SESSION['atualizado'];
        if ($dados_atualizado === 'nao') {
            $this->validaAtualizacaoDados();
        }
    }
    //Usados apenas na view /atualizar-usuario, para não causar error 302
    public function validarAutenticacaoAtualizaDados()
    {
        session_start();
        date_default_timezone_set('America/Bahia');
        if (
            !isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != '' &&
            !isset($_SESSION['nome']) || $_SESSION['nome'] != '' &&
            !isset($_SESSION['inativo']) || $_SESSION['inativo'] == 1
        ) {
            header('Location: /?login=error');
        }
    }

    public static function validacaoAutenticacaoFuncionario()
    {
        if ($_SESSION['nivel'] < 20) {
            header('Location: /inicio');
        }
    }

    public function ultimoLogin($id_usuario)
    {
        $id_usuario = $_SESSION['id_usuario'];

        $usuarioModel =  Container::getModel('Usuario');
        $usuarioModel->__set('id_usuario', $id_usuario);
        $usuarioModel->__set('ultimo_login', date('Y-m-d H:i:s')); // Data e hora atual
        $ultimo_login = $usuarioModel->ultimoLogin();
    }

    public function validaAtualizacaoDados()
    {
        header('Location: /atualizar-usuario');
    }
}
