<?php

namespace App\Controllers;

use App\Helper\Alertas;
use MF\Controller\Action;
use MF\Model\Container;

class UsuarioController extends Action
{
    public function AutenticarUsuario()
    {
        $authController = new AuthController;
        return $authController->validarAutenticacao();
    }

    public function AutenticarUsuarioAtualizarDados()
    {
        $authController = new AuthController;
        return $authController->validarAutenticacaoAtualizaDados();
    }

    public function index()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $this->view->usuario = array(
            'nome' => '',
            'senha' => '',
            'confirmaSenha' => '',
            'cpf' => '',
            'telefone' => '',
            'celular' => '',
            'email' => '',
            'estado' => '',
            'cidade' => '',
            'nivel' => '',
        );

        $this->render('usuario');
    }

    public function loginAtualizarDados()
    {
        $this->AutenticarUsuarioAtualizarDados();

        $usuarioModel = Container::getModel('Usuario');

        $id_usuario = $_SESSION['id_usuario'];
        $dados_usuario = $usuarioModel->loginDadosUsuario($id_usuario);

        $this->view->usuario = array(
            'nome' => $dados_usuario['nome'],
            'cpf' => $dados_usuario['cpf'],
            'email' => $dados_usuario['email'],
            'celular' => $dados_usuario['cel'],
            'estado' => $dados_usuario['uf'],
            'cidade' => $dados_usuario['cidade']
        );

        $this->render('login_atualizar_dados');
    }

    public function postAtualizarUsuarioLogin()
    {
        $this->AutenticarUsuarioAtualizarDados();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                $dados = array_map('trim', $dados);
                $dados = array_map('strtoupper', $dados);
                $dados['email'] = strtolower($dados['email']);
                $dados['email'] = filter_var($dados['email'], FILTER_SANITIZE_EMAIL);
                $dados['email'] = filter_var($dados['email'], FILTER_VALIDATE_EMAIL);

                $dados['celular'] = str_replace('(', '', $dados['celular']);
                $dados['celular'] = str_replace(')', '', $dados['celular']);
                $dados['celular'] = str_replace(' ', '', $dados['celular']);
                $dados['celular'] = str_replace('-', '', $dados['celular']);

                $id_usuario = $_SESSION['id_usuario'];

                $usuarioModel = Container::getModel('Usuario');
                $usuarioModel->__set('nome', $dados['nome']);
                $usuarioModel->__set('cpf', $dados['cpf']);
                $usuarioModel->__set('cel', $dados['celular']);
                $usuarioModel->__set('email', $dados['email']);
                $usuarioModel->__set('uf', $dados['estado']);
                $usuarioModel->__set('cidade', $dados['cidade']);
                $usuarioModel->__set('atualizado', 'sim');
                $usuarioModel->__set('id_usuario', $id_usuario);
                $usuarioModel->loginAtualizarUsuario();

                $_SESSION['atualizado'] = 'sim'; //força para não causar loop infinito.

                $_SESSION['msg'] = Alertas::alertaSucesso('Sucesso!', 'Dados de usuário atualizado com sucesso!');
                header('Location: /inicio');
            } catch (\Exception $e) {
                $_SESSION['msg'] = Alertas::alertaErro('Falha!', 'Falha ao atualizar o usuário');
                header('Location: /atualizar-usuario');
            }
        }
    }

    public function listaUsuario()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $usuarioModel = Container::getModel('Usuario');
        $lista_usuario = $usuarioModel->listaUsuario();

        $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

        if ($pesquisa) {
            $usuarioModel->__set('pesquisa', $pesquisa);
            $lista_usuario = $usuarioModel->pesquisaUsuario();
        }

        echo json_encode($lista_usuario);
    }
    public function mudarSituacaoUsuario()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioModel = Container::getModel('Usuario');
            $input = json_decode(file_get_contents('php://input'), true);

            $id_usuario = $input['id_usuario'];
            $inativo = $input['checked'] == 'true' ? 0 : 1;

            $usuarioModel->__set('id_usuario', $id_usuario);
            $usuarioModel->__set('inativo', $inativo);
            $mudar_situacao = $usuarioModel->mudarSituacaoUsuario();

            echo json_encode(['success' => $mudar_situacao]);
        }
    }

    public function adicionarUsuario()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $dados = array_map('trim', $dados);
            $dados['nome'] = strtoupper($dados['nome']);
            $dados['senha'] = md5($dados['senha']);
            $dados['email'] = strtolower($dados['email']);
            $dados['estado'] = strtoupper($dados['estado']);
            $dados['cidade'] = strtoupper($dados['cidade']);

            $dados['celular'] = str_replace(' ', '', $dados['celular']);
            $dados['celular'] = str_replace('-', '', $dados['celular']);
            $dados['telefone'] = str_replace(' ', '', $dados['telefone']);

            $usuarioModel = Container::getModel('Usuario');

            $usuarioModel->__set('nome', $dados['nome']);
            $usuarioModel->__set('cod_corretor', $dados['codigo']);
            $usuarioModel->__set('senha', $dados['senha']);
            $usuarioModel->__set('cpf', $dados['cpf']);
            $usuarioModel->__set('tel', $dados['telefone']);
            $usuarioModel->__set('cel', $dados['celular']);
            $usuarioModel->__set('email', $dados['email']);
            $usuarioModel->__set('uf', $dados['estado']);
            $usuarioModel->__set('cidade', $dados['cidade']);
            $usuarioModel->__set('nivel', $dados['nivel']);

            $dadosVerificado = true;

            $cod_corretor =  $usuarioModel->verificaDadosUsuario('cod_corretor', 'cod_corretor', $dados['codigo']);

            $email =  $usuarioModel->verificaDadosUsuario('email', 'email', $dados['email']);

            $cpf =  $usuarioModel->verificaDadosUsuario('cpf', 'cpf', $dados['cpf']);

            $this->verificarCpfCorretor($dados, $cpf, $dadosVerificado);

            $this->verificarCodCorretorEmailCorretor($dados, $cod_corretor, $email, $dadosVerificado);

            $this->verificarCodCorretor($dados, $cod_corretor, $dadosVerificado);

            $this->verificarEmailCorretor($dados, $email, $dadosVerificado);


            if ($dadosVerificado) {
                $usuarioModel->adicionaUsuario();
                $_SESSION['msg'] = Alertas::alertaSucesso('Sucesso!', 'Usuário adicionado com sucesso.');
                header('Location: /usuario');
            }
        }
    }

    public function editaUsuario()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $dados = array_map('trim', $dados);
            $dados['nome'] = strtoupper($dados['nome']);
            $dados['email'] = strtolower($dados['email']);
            $dados['estado'] = strtoupper($dados['estado']);
            $dados['cidade'] = strtoupper($dados['cidade']);

            $dados['celular'] = str_replace(' ', '', $dados['celular']);
            $dados['celular'] = str_replace('-', '', $dados['celular']);
            $dados['telefone'] = str_replace(' ', '', $dados['telefone']);

            $usuarioModel = Container::getModel('Usuario');

            try {
                $usuarioModel->__set('id_usuario', $dados['id_usuario']);
                $usuarioModel->__set('nome', $dados['nome']);
                $usuarioModel->__set('cod_corretor', $dados['codigo']);
                $usuarioModel->__set('cpf', $dados['cpf']);
                $usuarioModel->__set('tel', $dados['telefone']);
                $usuarioModel->__set('cel', $dados['celular']);
                $usuarioModel->__set('email', $dados['email']);
                $usuarioModel->__set('uf', $dados['estado']);
                $usuarioModel->__set('cidade', $dados['cidade']);
                $usuarioModel->__set('nivel', $dados['nivel']);
                $usuarioModel->editaUsuario();
                $_SESSION['msg'] = Alertas::alertaSucesso('Sucesso!', 'Usuário editado com sucesso');
            } catch (\Exception $e) {
                $_SESSION['msg'] = Alertas::alertaErro('Falha!', 'Falha ao alterar o usuario');
            }
        }
        header('Location: /usuario');
    }
    public function alteraSenhaUsuario()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $dados = array_map('trim', $dados);
            $usuarioModel = Container::getModel('Usuario');
            $dados['senha'] = md5($dados['senha']);

            try {
                $usuarioModel->__set('id_usuario', $dados['id_usuario']);
                $usuarioModel->__set('senha', $dados['senha']);

                $usuarioModel->alteraSenhaUsuario();

                $_SESSION['msg'] = Alertas::alertaSucesso('Sucesso!', 'Senha alterada com sucesso');
            } catch (\Exception $e) {
                $_SESSION['msg'] = Alertas::alertaErro('Falha!', 'Falha ao alterar a senha do usuario');
            }
        }
        header('Location: /usuario');
    }
    public function verificarCpfCorretor($dados, $cpf, $dadosVerificado)
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($cpf == $dados['cpf']) {

            $dadosVerificado = false;

            $this->view->usuario = array(
                'nome' => $dados['nome'],
                'codigo' => $dados['codigo'],
                'senha' => $dados['confirmaSenha'],
                'confirmaSenha' => $dados['confirmaSenha'],
                'telefone' => $dados['telefone'],
                'celular' => $dados['celular'],
                'email' => $dados['email'],
                'estado' => $dados['estado'],
                'cidade' => $dados['cidade'],
                'nivel' => $dados['nivel'],
            );

            $_SESSION['msg'] = Alertas::alertaErro('Error!', 'CPF do corretor já existe');

            $this->render('usuario');
        }
    }
    public function verificarCodCorretor($dados, $cod_corretor, $dadosVerificado)
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        if ($cod_corretor == $dados['codigo']) {

            $dadosVerificado = false;

            $this->view->usuario = array(
                'nome' => $dados['nome'],
                'senha' => $dados['confirmaSenha'],
                'confirmaSenha' => $dados['confirmaSenha'],
                'cpf' => $dados['cpf'],
                'telefone' => $dados['telefone'],
                'celular' => $dados['celular'],
                'email' => $dados['email'],
                'estado' => $dados['estado'],
                'cidade' => $dados['cidade'],
                'nivel' => $dados['nivel'],
            );

            $_SESSION['msg'] = Alertas::alertaErro('Error!', 'Código do corretor já existe');

            $this->render('usuario');
        }
    }

    public function verificarEmailCorretor($dados, $email, $dadosVerificado)
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        if ($email == $dados['email']) {
            $dadosVerificado = false;

            $this->view->usuario = array(
                'nome' => $dados['nome'],
                'codigo' => $dados['codigo'],
                'senha' => $dados['confirmaSenha'],
                'confirmaSenha' => $dados['confirmaSenha'],
                'cpf' => $dados['cpf'],
                'telefone' => $dados['telefone'],
                'celular' => $dados['celular'],
                'estado' => $dados['estado'],
                'cidade' => $dados['cidade'],
                'nivel' => $dados['nivel'],
            );
            $_SESSION['msg'] = Alertas::alertaErro('Error!', 'Email do corretor já existe');
            $this->render('usuario');
        }
    }
    public function verificarCodCorretorEmailCorretor($dados, $cod_corretor, $email, $dadosVerificado)
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        if ($cod_corretor == $dados['codigo'] && $email == $dados['email']) {
            $dadosVerificado = false;

            $this->view->usuario = array(
                'nome' => $dados['nome'],
                'senha' => $dados['confirmaSenha'],
                'confirmaSenha' => $dados['confirmaSenha'],
                'cpf' => $dados['cpf'],
                'telefone' => $dados['telefone'],
                'celular' => $dados['celular'],
                'estado' => $dados['estado'],
                'cidade' => $dados['cidade'],
                'nivel' => $dados['nivel'],
            );

            $_SESSION['msg'] = Alertas::alertaErro('Error!', 'Código e email do corretor já existem');

            $this->render('usuario');
        }
    }
}
