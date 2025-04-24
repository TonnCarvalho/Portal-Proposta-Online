<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class CCBEnviadaController extends Action
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
        $this->render('ccb_enviada');
    }

    public function getCcbEnviadas()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $ccbEnviadaModel = Container::getModel('CcbEnviada');
        $getCcbEnviada = $ccbEnviadaModel->getPropostasCcbEnviada();

        echo json_encode($getCcbEnviada);
    }

    public function postPropostaCcbAssinada()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_proposta = isset($_GET['id_proposta']) ? $_GET['id_proposta'] : '';
            $id_usuario = $_SESSION['id_usuario'];

            $propostaModel = Container::getModel('Proposta');
            $propostaModel->mudarStatusProposta('status_proposta', 9, $id_proposta);

            $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
            $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
            $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'aguardando_pagamento');

            echo json_encode(['ccb_assinada' => true]);
        }
    }

    public function postTodasPropostaCcbAssinada()
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
                $propostaModel->mudarStatusProposta('status_proposta', 9, $id_proposta);

                $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
                $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'aguardando_pagamento');
            }

            echo json_encode(['ccb_assinadas' => true]);
        }
    }
}
