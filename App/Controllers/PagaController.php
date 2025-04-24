<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class PagaController extends Action
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
        $this->render('paga');
    }

    public function getPropostas()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
        $data = isset($_GET['data']) ? $_GET['data'] : '';

        $pagarModel = Container::getModel('Pagar');
        
        if($pesquisa){
            $pagarModel->__set('nome', $pesquisa);
            $pagarModel->__set('cpf', $pesquisa);
            $pagarModel->__set('num_proposta', $pesquisa);
            $propostas = $pagarModel->getPesquisaPropostas();
        }

        if($data){
            $pagarModel->__set('data', $data);
            $propostas = $pagarModel->getDataPropostas();
        }

        if (empty($pesquisa) && empty($data)) {
            $propostas = $pagarModel->getPropostas();
        }
        echo json_encode($propostas);
    }

    public function postPagaProposta()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_proposta = isset($_GET['id_proposta']) ? $_GET['id_proposta'] : '';
            $id_usuario = $_SESSION['id_usuario'];

            $propostaModel = Container::getModel('Proposta');
            $propostaModel->mudarStatusProposta('status_proposta', 10, $id_proposta);

            $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
            $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
            $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'pago');

            echo json_encode(['pago' => true]);
        }
    }

    public function postPagaTodasPropostas()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_SESSION['id_usuario'];

            $inputData = json_decode(file_get_contents("php://input"), true);
            $idProposta = $inputData['idProposta'];

            $propostaModel = Container::getModel('Proposta');
            $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');

            foreach ($idProposta as $id_proposta) {
                $propostaModel->mudarStatusProposta('status_proposta', 10, $id_proposta);
                $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
                $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'pago');
            }

            echo json_encode(['pagas' => true]);
        }
    }
}
