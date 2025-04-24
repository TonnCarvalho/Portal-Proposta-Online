<?php

namespace App\Controllers;

use App\Helper\Alertas;
use MF\Controller\Action;
use MF\Model\Container;

class OrgaosController extends Action
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
        $pracas = Container::getModel('Praca');
        $pracas_select = $pracas->getTodasPracasAtivas();

        $this->view->pracas = $pracas_select;
        $this->render('orgaos');
    }

    public function filtroOrgaos()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $orgaos = Container::getModel('Orgao');

        $cod_local = isset($_GET['cod_local']) ? $_GET['cod_local'] : '';

        if ($cod_local) {
            $orgaos->__set('cod_local', $cod_local);
            $filtra_orgao = $orgaos->orgaos();
        }

        echo json_encode($filtra_orgao);
    }

    //TODO: adicionar vereificação de codigo de orgao e nome de orgao antes de adicionar.
    public function adicionarOrgao()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $dados = array_map('trim', $dados);
            $dados = array_map('strtoupper', $dados);

            $orgao = Container::getModel('Orgao');

            if ($dados['possui_codigo'] === 'S') {
                $orgao->__set('cod_local', $dados['cod_local']);
                $orgao->__set('cod_orgao', $dados['codigo']);
                $orgao->__set('nome', $dados['orgao_nome']);
                $orgao->adicionarOrgao();

                $_SESSION['msg'] = Alertas::alertaPraca('success', 'Sucesso!', 'Orgão criada com sucesso.');
            } else {
                $orgao->__set('cod_local', $dados['cod_local']);
                $orgao->buscaUltimoCodOrgParaIncrementar();

                $resultado_ultimo_cod_local = $orgao->buscaUltimoCodOrgParaIncrementar();

                $cod_orgaos = array_column($resultado_ultimo_cod_local, 'cod_orgao');

                $maior_cod_orgao = $cod_orgaos[0] + 1;

                $orgao->__set('cod_local', $dados['cod_local']);
                $orgao->__set('nome', $dados['orgao_nome']);
                $orgao->__set('cod_orgao', $maior_cod_orgao);
                $orgao->adicionarOrgao();

                $_SESSION['msg'] = Alertas::alertaPraca('success', 'Sucesso!', 'Orgão criada com sucesso.');
            }
            //TODO adicionar envio de email para informa que novo orgão foi incluido.
        }

        header('Location: /orgaos');
    }
    public function editaOrgao()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $dados = array_map('trim', $dados);
            $dados = array_map('strtoupper', $dados);

            $orgao = Container::getModel('Orgao');
            $orgao->__set('nome', $dados['nome_orgao']);
            $orgao->__set('id_orgao', $dados['id_orgao']);

            if ($orgao->editaOrgao()) {
                $_SESSION['msg'] = Alertas::alertaPraca('success', 'Sucesso!', 'Órgão editada com sucesso.');
            }
        }
        header('Location: /orgaos');
    }
    public function deletaOrgao()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $orgao = Container::getModel('Orgao');

        $id_orgao = $_GET['id_orgao'];

        $orgao->__set('id_orgao', $id_orgao);
        $orgao->deletaOrgao();

        echo json_encode(['deleta' => true]);
    }

    public function mudarSituacaoOrgao()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orgao = Container::getModel('Orgao');
            $input = json_decode(file_get_contents('php://input'), true);

            $id_orgao = $input['id_orgao'];
            $inativo = $input['checked'] == 'true' ? 0 : 1;

            $orgao->__set('id_orgao', $id_orgao);
            $orgao->__set('inativo', $inativo);
            $mudar_situacao = $orgao->mudarSituacaoOrgao();

            echo json_encode(['success' => $mudar_situacao]);
        }
    }
}
