<?php

namespace App\Controllers;

use App\Helper\Alertas;
use MF\Controller\Action;
use MF\Model\Container;

class PracaController extends Action
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

        $this->render('praca');
    }

    public function pracas()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $praca = Container::getModel('Praca');

        $todas_pracas = $praca->todasPracas();

        $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

        if ($pesquisa) {
            $praca->__set('pesquisa', $pesquisa);
            $todas_pracas = $praca->pesquisaPraca();
        }

        echo json_encode($todas_pracas);
    }
    public function mudarSituacaoPraca()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $praca = Container::getModel('Praca');
            $input = json_decode(file_get_contents('php://input'), true);

            $cod_local = $input['cod_local'];
            $inativo = $input['checked'] == 'true' ? 0 : 1;

            $mudar_situacao = $praca->mudarSituacaoPraca($cod_local, $inativo);

            echo json_encode(['success' => $mudar_situacao]);
        }
    }
    public function adicionarPraca()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $dados = array_map('trim', $dados);
            $dados = array_map('strtoupper', $dados);
            $nome_praca = '';
            $praca = Container::getModel('Praca');

            $todas_pracas = $praca->todasPracas();

            $cod_locais = array_column($todas_pracas, 'cod_local');
            $ultimo_cod_local = end($cod_locais);

            if ($dados['selectEstado']) {
                $nome_praca = $dados['praca'] . ' - ' . $dados['selectEstado'];
                $praca->__set('cod_local', $ultimo_cod_local + 1);
                $praca->__set('nome_praca', $nome_praca);
                $praca->adicionarPraca();
            } else {
                $nome_praca = $dados['praca'];
                $praca->__set('cod_local', $ultimo_cod_local + 1);
                $praca->__set('nome_praca', $nome_praca);
                $praca->adicionarPraca();
            }
            $_SESSION['msg'] = Alertas::alertaPraca('success', 'Sucesso!', 'Praça criada com sucesso.');
        }

        header('Location: /praca');
    }
    public function editaPraca()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $dados = array_map('trim', $dados);
            $dados = array_map('strtoupper', $dados);

            print_r($dados);
            $praca = Container::getModel('Praca');
            $praca->__set('nome_praca', $dados['praca']);
            $praca->__set('cod_local', $dados['cod_local']);

            if ($praca->editaPraca()) {
                $_SESSION['msg'] = Alertas::alertaPraca('success', 'Sucesso!', 'Praça editada com sucesso.');
            }
        }
        header('Location: /praca');
    }
    public function deletaPraca()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        $praca = Container::getModel('Praca');

        $cod_local = $_GET['cod_local'];

        $praca->__set('cod_local', $cod_local);
        $praca->deletaPraca();

        echo json_encode(['deleta' => true]);
    }
}
