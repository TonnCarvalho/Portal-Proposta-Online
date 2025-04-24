<?php

namespace App\Controllers;

use App\Helper\Alertas;
use App\Controllers\PhpMailerController;
use MF\Controller\Action;
use MF\Model\Container;

class ConsultaController extends Action
{
    public function AutenticarUsuario()
	{
		$authController = new AuthController;
		return $authController->validarAutenticacao();
	}
    
    public function envioEmailConsultaRespondida($emailCorretor, $nomeCorretor, $codigoConsulta)
    {
        $email = new PhpMailerController;
        $para = $emailCorretor;
        $nomePara =  $nomeCorretor;
        $assunto = 'Consulta ' . $codigoConsulta . ' respondida';
        $nomeCorretor = $nomeCorretor;
        $uriProposta = $_SERVER['HTTP_REFERER'];

        $email->emailConsultaRespondida($para, $nomePara, $assunto, $nomeCorretor, $uriProposta, $codigoConsulta);
    }
    public function index()
    {
        $this->AutenticarUsuario();

        $consultaModel = Container::getModel('Consulta');

        if ($_SESSION['nivel'] <= 10) {
            $id_usuario = $_SESSION['id_usuario'];
            $consultaModel->__set('id_usuario', $id_usuario);
            $consultas = $consultaModel->getConsultaCorretor();
        }
        if ($_SESSION['nivel'] > 10) {
            $consultas = $consultaModel->getTodasConsultas();
        }

        $this->view->consulta = $consultas;
        $this->render('consultas');
    }

    public function consultaAdicionar()
    {
        $this->AutenticarUsuario();

        $pracaModel = Container::getModel('Praca');
        $todasPracas = $pracaModel->getTodasPracasAtivas();
        $this->view->pracas = $todasPracas;

        $usuarioModel = Container::getModel('Usuario');
        $emailUsuario = $usuarioModel->verificaDadosUsuario('email', 'id_usuario', $_SESSION['id_usuario']);
        $this->view->email = $emailUsuario;

        $this->render('consulta_adicionar');
    }

    //Envia dos dados da consulta para o banco de dados.
    public function postConsulta()
    {
        //TODO melhorar a validação dos inputs
        $this->AutenticarUsuario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $consultaModel = Container::getModel('Consulta');

            $email = $_POST['email'];
            $praca = $_POST['praca'];
            $nomes = $_POST['nome'];
            $cpfs = $_POST['cpf'];
            $matriculas = $_POST['matricula'];
            $data_nasc = $_POST['nascimento'];
            $data_criado = date('Y-m-d H:i:s');

            $nomes = array_map('trim', $nomes);
            $nomes = array_map('strtoupper', $nomes);

            $consultaModel->__set('data_criado', $data_criado);

            if (empty($praca)) {
                $_SESSION['msg'] = Alertas::alertaErro('Falha!', 'Informe a praça');

                header('Location: /consulta-adicionar');
                exit();
            }

            if (empty($nomes[0]) || empty($cpfs[0]) || empty($data_nasc[0])) {
                $_SESSION['msg'] = Alertas::alertaErro('Falha!', 'Preencha o formulário');

                header('Location: /consulta-adicionar');
                exit();
            }

            $id_usuario =  $_SESSION['id_usuario'];
            $consultaModel->__set('id_usuario', $id_usuario);
            $consultaModel->__set('email', $email);
            $consultaModel->__set('praca', $praca);


            foreach ($nomes as $index => $nome) {
                $cpf = isset($cpfs[$index]) ? $cpfs[$index] : '';
                $matricula = isset($matriculas[$index]) ? $matriculas[$index] : '';
                $data_nascimento = isset($data_nasc) ? $data_nasc[$index] : '';

                if (!empty($nome) && !empty($cpf) && !empty($data_nascimento)) {
                    $consultaModel->__set('nome' . ($index + 1), $nome);
                    $consultaModel->__set('cpf' . ($index + 1), $cpf);
                    $consultaModel->__set('matricula' . ($index + 1), $matricula);
                    $consultaModel->__set('data_nasc' . ($index + 1), $data_nascimento);
                }
            }
            $consultaModel->postConsulta();
            $_SESSION['msg'] = Alertas::alertaSucesso('Enviado!', 'Consulta enviada com sucesso');
        } else {
            $_SESSION['msg'] = Alertas::alertaErro('Falha!', 'Algo deu errado, por favor, procure um de nossos operadores');
        }
        header('Location: /consultas');
    }

    public function consultaVisualiza()
    {
        $this->AutenticarUsuario();
        $id_consulta = isset($_GET['codigo']) ? $_GET['codigo'] : '';
        $id_usuario = $_SESSION['id_usuario'] ;

        $consultaModel = Container::getModel('Consulta');
        $consultaModel->__set('id_consulta', $id_consulta);

        $consulta_visualiza = $consultaModel->showConsultaId();

        $verifica_status_consulta = $consultaModel->statusConsulta($id_consulta);

        if ($_SESSION['nivel'] > 10 && $verifica_status_consulta < 2) {
            $consultaModel->mudarStatusConsulta('status_consulta', 2, $id_consulta);
        }

        $id_usuario_consulta = $consulta_visualiza[0][1]; //pega o código do id_usuario pela consulta.
        $this->view->praca_consulta = $consulta_visualiza[0][3]; //pega a praça da consulta.

        if ($id_usuario == $id_usuario_consulta || $_SESSION['nivel'] > 10) {
            $this->view->consulta_visualiza = $consulta_visualiza;
            $this->view->id_consulta = $id_consulta;
        } else {
            header('Location: /consultas');
        }
        $this->render('consulta_visualiza');
    }

    public function postConsultaResponder()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $consultaModel = Container::getModel('Consulta');

            $resposta = $_POST['resposta'];
            $resposta_index = $_POST['index']; //usada para salvar na coluna númerada certa no banco de dados
            $id_consulta = $_POST['id_consulta'];
            $email_corretor = $_POST['email'];
            $data_resposta = date('Y-m-d H:i:s');

            $consultaModel->__set('id_consulta', $id_consulta);
            $consultaModel->__set('id_usuario', $_SESSION['id_usuario']);

            $consultaModel->__set('data_resposta', $data_resposta);

            for ($i = 0; $i < count($resposta); $i++) {
                if (!empty($resposta[$i])) {
                    $consultaModel->__set('resposta' . $resposta_index[$i], $resposta[$i]);
                }
            }

            $consultaModel->mudarStatusConsulta('status_consulta', 3, $id_consulta);
            $consultaModel->postRespostaConsulta();
            $_SESSION['msg'] = Alertas::alertaSucesso('Sucesso!', 'Consulta respondida com sucesso');

            //ENVIAR EMAIL
            $emailCorretor = $email_corretor;
            $nomeCorretor = $_SESSION['nome'];
            $codigoConsulta = $id_consulta;
            $this->envioEmailConsultaRespondida($emailCorretor, $nomeCorretor, $codigoConsulta);
        } else {
            $_SESSION['msg'] = Alertas::alertaErro('Falha!', 'Algo deu errado, por favor, procure um de nossos operadores');
        }

        header('Location: /consultas');
    }

    
}
