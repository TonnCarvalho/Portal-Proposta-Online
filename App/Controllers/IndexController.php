<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;
use App\Helper\Alertas;
use Exception;

class IndexController extends Action
{

	public function inicio()
	{
		$this->AutenticarUsuario();

		$pracas = Container::getModel('Praca');
		$pracas_lista = $pracas->getTodasPracasAtivas();


		if (isset($_SESSION['msg'])) {
			$this->view->alerta = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}

		$nivel_usuario = $_SESSION['nivel'];

		$this->view->pracas = $pracas_lista;
		$this->view->nivel_usuario = $nivel_usuario;

		$this->render('inicio');
	}
	public function painel()
	{
		$this->AutenticarUsuario();
		AuthController::validacaoAutenticacaoFuncionario();
		$this->render('painel');
	}

	//Mostra a proposta no CRUD
	public function filtraPropostaInicio()
	{
		$this->AutenticarUsuario();
		$propostas = Container::getModel('Proposta');

		// Parâmetros de filtro
		$situacao = isset($_GET['situacao']) ? $_GET['situacao'] : '';
		$praca = isset($_GET['cod_local']) ? $_GET['cod_local'] : '';
		$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

		// Parâmetros de paginação
		$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
		$limite = 10;
		$offset = ($pagina - 1) * $limite;

		$id_usuario = $_SESSION['id_usuario'];
		$cod_corretor = $_SESSION['cod_corretor'];

		// Inicializa a lista de propostas
		$propostas_lista = [];

		// Mostra as propostas do corretor
		if ($_SESSION['nivel'] == 10) {
			if ($praca) {
				$propostas->__set('cod_corretor', $cod_corretor);
				$propostas->__set('cod_local', $praca);
				$propostas_lista = $propostas->propostaFiltroPracaCorretor($limite, $offset);
			}
			if ($situacao) {
				$propostas->__set('situacao', $situacao);
				$propostas->__set('cod_corretor', $cod_corretor);
				$propostas_lista = $propostas->propostaFiltroSituacaoCorretor($limite, $offset);
			}
			if ($pesquisa) {
				$praca = '';
				$situacao = '';
				$propostas->__set('pesquisa', $pesquisa);
				$propostas->__set('cod_corretor', $cod_corretor);
				$propostas_lista = $propostas->propostaPesquisaCorretor($limite, $offset);
			}
			if ($praca && $situacao) {
				$propostas->__set('situacao', $situacao);
				$propostas->__set('cod_corretor', $cod_corretor);
				$propostas->__set('cod_local', $praca);
				$propostas_lista = $propostas->propostaFiltroPracaSituacaoCorretor($limite, $offset);
			}

			if (!$praca && !$situacao && !$pesquisa) {
				$propostas->__set('id_usuario', $id_usuario);
				$propostas->__set('cod_corretor', $cod_corretor);
				$propostas_lista = $propostas->pegarPropostaInicioCorretor($limite, $offset);
			}
		}

		// Mostra as propostas para os colaboradores
		if ($_SESSION['nivel'] > 10) {
			if ($praca) {
				$propostas->__set('cod_local', $praca);
				$propostas_lista = $propostas->propostaFiltroPraca($limite, $offset);
			}
			if ($situacao) {
				$propostas->__set('situacao', $situacao);
				$propostas_lista = $propostas->propostaFiltroSituacao($limite, $offset);
			}
			if ($pesquisa) {
				$praca = '';
				$situacao = '';
				$propostas->__set('pesquisa', $pesquisa);
				$propostas_lista = $propostas->propostaPesquisa($limite, $offset);
			}
			if ($praca && $situacao) {
				$propostas->__set('situacao', $situacao);
				$propostas->__set('cod_local', $praca);
				$propostas_lista = $propostas->propostaFiltroPracaSituacao($limite, $offset);
			}

			if (!$praca && !$situacao && !$pesquisa) {
				$id_usuario = $_SESSION['id_usuario'];
				$cod_corretor = $_SESSION['cod_corretor'];
				$propostas->__set('id_usuario', $id_usuario);
				$propostas->__set('cod_corretor', $cod_corretor);
				$propostas_lista = $propostas->pegarPropostaInicio($limite, $offset);
			}
		}

		// Adiciona informações de paginação ao resultado
		$totalPropostas = $propostas->contarPropostas();
		$totalPaginas = ceil($totalPropostas / $limite);

		// Retorna o resultado como JSON
		echo json_encode([
			'propostas' => $propostas_lista,
			'pagina_atual' => $pagina,
			'total_paginas' => $totalPaginas
		]);
	}

	public function propostaMudarSituacao()
	{
		$this->AutenticarUsuario();
		AuthController::validacaoAutenticacaoFuncionario();

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

			$dados = array_map('trim', $dados);
			$id_proposta = $dados['id_proposta'];
			$status_proposta = $dados['status_proposta'];
			$status_assinatura = $dados['status_assinatura'];
			$status_recusado = $dados['status_recusado'];
			$status_refin = $dados['status_refin'];

			// Carrega o modelo de proposta
			$proposta = Container::getModel('Proposta');

			try {
				// Atualiza cada status conforme necessário
				$proposta->mudarStatusProposta('status_proposta', $status_proposta, $id_proposta);
				$proposta->mudarStatusProposta('status_assinatura', $status_assinatura, $id_proposta);
				$proposta->mudarStatusProposta('status_recusado', $status_recusado, $id_proposta);
				$proposta->mudarStatusProposta('status_refin', $status_refin, $id_proposta);

				$_SESSION['msg'] = Alertas::alertaPraca('success', 'Sucesso!', 'Proposta alterada com sucesso');
			} catch (Exception $e) {
				echo 'error';
			}
		}
		header('Location: /inicio');
	}

	public function AutenticarUsuario()
	{
		$authController = new AuthController;
		return $authController->validarAutenticacao();
	}
}
