<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AcompanhamentoController extends Action
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

        $this->view->alerta = $_SESSION['msg'];

        $this->render('acompanhamento');
    }
    public function getProposta()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        $acompanhamentoModel = Container::getModel('Acompanhamento');

        //Parâmetros de filtros
        $pesquisa = isset($_GET['pesquisa']) ? (string)$_GET['pesquisa'] : '';
        $situacao = isset($_GET['situacao']) ? (string)$_GET['situacao'] : '';
        $clicksign = isset($_GET['clicksign']) ? (string)$_GET['clicksign'] : '';

        //Parâmetros de paginação
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $limit = 20;
        $offset = ($pagina - 1) * $limit;

        if ($pesquisa) {
            $acompanhamentoModel->__set('pesquisa', $pesquisa);
            $acompanhamento_lista = $acompanhamentoModel->getFiltroPesquisa($limit, $offset);
        }
        if ($situacao) {
            $acompanhamentoModel->__set('situacao', $situacao);
            $acompanhamento_lista = $acompanhamentoModel->getFiltroSituacao($limit, $offset);
        }
        if ($clicksign) {
            $acompanhamentoModel->__set('clicksign', $clicksign);
            $acompanhamento_lista = $acompanhamentoModel->getFiltroClickSign($limit, $offset);
        }

        if ($pesquisa === '' && $situacao === '' && $clicksign === '') {
            $acompanhamento_lista = $acompanhamentoModel->getPropostas($limit, $offset);
        }

        //Adiciona informações de paginação ao resultado
        $totalAcompanhamento = $acompanhamentoModel->contaPropostasCompanhamento();
        $totalPaginas = ceil($totalAcompanhamento / $limit);
        echo json_encode([
            'propostas' => $acompanhamento_lista,
            'pagina_atual' => $pagina,
            'total_paginas' => $totalPaginas
        ]);
    }
}
