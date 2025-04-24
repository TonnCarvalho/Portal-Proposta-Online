<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AssinadosController extends Action
{
    public function AutenticarUsuario()
	{
		$authController = new AuthController;
		return $authController->validarAutenticacao();
	}
    
    public function index()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $this->render('assinados');
    }
    public function propostasAssinadas()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $assinadosModel = Container::getModel('Assinados');
        $propostasAssinadas = $assinadosModel->pegarPropostaAssinadasInicio();

        echo json_encode($propostasAssinadas);
    }

    public function propostaAprovadaDigitada()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $id_proposta = $_GET['id_proposta'];
        $id_usuario = $_SESSION['id_usuario'];

        $propostaModel = Container::getModel('Proposta');
        $propostaModel->mudarStatusProposta('status_proposta', 8, $id_proposta,);

        $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
        $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
        $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'ccb_enviada');

        echo json_encode(['digitada' => true]);
    }

    public function todasPropostasAprovadasDigitadas()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_usuario = $_SESSION['id_usuario'];

            // Lê os dados recebidos
            $inputData = json_decode(file_get_contents("php://input"), true);

            $idPropostas = $inputData['idProposta'];
            $propostaModel = Container::getModel('Proposta');
            $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');

            // Atualiza o status de cada proposta
            foreach ($idPropostas as $id_proposta) {
                $propostaModel->mudarStatusProposta('status_proposta', 8, $id_proposta);

                $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
                $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'ccb_enviada');
            }

            echo json_encode(['atualizado' => true]);
        }
    }
}
