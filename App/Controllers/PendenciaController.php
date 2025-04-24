<?php

namespace App\Controllers;

use App\Helper\Alertas;
use MF\Controller\Action;
use MF\Model\Container;
use App\Controllers\PhpMailerController;
use Exception;

class PendenciaController extends Action
{
    public function AutenticarUsuario()
	{
		$authController = new AuthController;
		return $authController->validarAutenticacao();
	}
    
    public function emailInfoPendencia($id_proposta, $nome_associado)
    {

        //Pega os dados do corretor e da proposta para enviar informações ao email do corretor.
        $dadosEmail = Container::getModel('DadosEmail');
        $resultadoDadosEmail = $dadosEmail->pegarDadosPendencia($id_proposta);

        if (!$resultadoDadosEmail || empty($resultadoDadosEmail['email'])) {
            throw new Exception('Erro: Nenhum dado de e-mail encontrado.');
        }

        $para = $resultadoDadosEmail['email'];
        $nomePara =  $resultadoDadosEmail['nome'];
        $assunto = 'Proposta com pendencia';
        $nomeCorretor = $resultadoDadosEmail['nome'];
        $nomeAssociado = $nome_associado;
        $num_proposta = $resultadoDadosEmail['num_proposta'];
        $uriProposta = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'wwww.proposta.tondev.com.br';

        $email = new PhpMailerController;
        $email->emailPendenciaCriada($para, $nomePara, $assunto, $nomeCorretor, $nomeAssociado, $num_proposta, $uriProposta);
    }
    public function pendenciaCriar()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {

                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                $id_usuario = $_SESSION['id_usuario'];

                $dados_pendencia = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                $dados_pendencia['mensagem'] = trim($dados_pendencia['mensagem']);
                $dados_pendencia['mensagem'] = nl2br($dados_pendencia['mensagem']);
                $id_proposta =  $dados_pendencia['id_proposta'];
                $nome_associado = $dados_pendencia['nome_associado'];

                $pendenciaModel = Container::getModel('Pendencia');
                $pendenciaModel->__set('mensagem', $dados_pendencia['mensagem']);
                $pendenciaModel->pendenciaCriar($id_proposta, $id_usuario);

                $propostaModel = Container::getModel('Proposta');
                $propostaModel->mudarStatusProposta('status_proposta', '3', $id_proposta);

                $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
                $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
                $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'pendencia');
                

                $this->emailInfoPendencia($id_proposta, $nome_associado);

                $_SESSION['msg'] = Alertas::alertaPendencia('Sucesso!', 'A pendencia foi criada e informada ao corretor');

                $pagina_anterior = $_SERVER['HTTP_REFERER'];
                header("Location: $pagina_anterior");
            } catch (\Exception $e) {
                echo 'error';
            }
        } else {
            header('Location: /inicio');
        }
    }

    public function pendenciaEditar()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        $pendenciaModel = Container::getModel('Pendencia');

        $dados_pendencia = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $dados_pendencia['mensagem'] = trim($dados_pendencia['mensagem']);
        $dados_pendencia['mensagem'] = nl2br($dados_pendencia['mensagem']);

        $id_proposta =  $dados_pendencia['id_proposta'];
        $id_usuario = $dados_pendencia['id_usuario'];
        $nome_associado = $dados_pendencia['nome_associado'];
        $pendenciaModel->__set('mensagem', $dados_pendencia['mensagem']);

        $pendenciaModel->pendenciaEditar($id_proposta, $id_usuario);
        //TODO ATIVAR E CONFIGURAR PARA PRODUÇÃO
        $this->emailInfoPendencia($id_proposta, $nome_associado);

        $_SESSION['msg'] = Alertas::alertaPendencia('Sucesso!', 'A pendencia foi editada e informada ao corretor');

        $pagina_anterior = $_SERVER['HTTP_REFERER'];
        header("Location: $pagina_anterior");
    }
}
