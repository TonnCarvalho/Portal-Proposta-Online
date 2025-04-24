<?php

namespace App\Controllers;

use App\Helper\Alertas;
use MF\Controller\Action;
use MF\Model\Container;
use PDOException;

class PrestamistaController extends Action
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

        if (isset($_pegaCpfAssociadoCodCorretor)) {
            $this->view->alerta = $_pegaCpfAssociadoCodCorretor;
            unset($_pegaCpfAssociadoCodCorretor);
        }

        $this->view->prestamista_download = 'arquivo_prestamista/Prestamista.csv';
        $this->view->prestamista_nao_encontrado_download = 'arquivo_prestamista/Prestamista_nao_encontrados.csv';
        $this->render('prestamista');
    }

    // Função para converter os dados ISO-8859-1 para UTF-8
    public function converter(&$dados_arquivo)
    {
        $dados_arquivo = mb_convert_encoding($dados_arquivo, "UTF-8", "ISO-8859-1");
    }

    public function enviarPrestamista()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        set_time_limit(300);
        try {
            if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
                // Caminho temporário do arquivo
                $arquivo_csv = $_FILES['arquivo']['tmp_name'];

                // Abre o arquivo CSV para leitura
                if (($handle = fopen($arquivo_csv, 'r')) !== false) {
                    $cabeçalho = fgetcsv($handle, 1000, ','); // Ignora o cabeçalho

                    // Arrays para armazenar resultados
                    $encontrados = [];
                    $nao_encontrados = [];
                    $prestamistaModel = Container::getModel('Prestamista');
                    // Lê cada linha do CSV
                    while (($linha = fgetcsv($handle, 1000, ',')) !== false) {
                        $nome = $linha[0];
                        $cpf = $linha[1];
                        $data_nascimento_planilha = $linha[2]; // Data de nascimento da planilha

                        $resultado_bd = $prestamistaModel->buscarAssociadosPrestaMista($cpf);
                        $cpf_encontrado = false;
                        if ($resultado_bd) {
                            foreach ($resultado_bd as $resultado) {
                                if ($resultado['cpf'] == $cpf) {
                                    $cpf_encontrado = true;
                                    // Adicionar a data de nascimento da planilha aos dados encontrados no banco
                                    $encontrados[] = [
                                        'nome' => $resultado['nome'],
                                        'cpf' => $resultado['cpf'],
                                        'data_nascimento' => $data_nascimento_planilha, // Data da planilha
                                        'total_presente' => $resultado['total_presente']
                                    ];
                                }
                            }
                        }
                        // Se o CPF não foi encontrado, adiciona ao array de não encontrados
                        if (!$cpf_encontrado) {
                            $nao_encontrados[] = [
                                'nome' => $nome,
                                'cpf' => $cpf,
                                'data_nascimento' => $data_nascimento_planilha
                            ];
                        }
                    }


                    // Fecha o arquivo
                    fclose($handle);

                    // Gera a primeira planilha (dados encontrados)
                    $arquivo_encontrados = 'arquivo_prestamista/Prestamista.csv';
                    $handle_encontrados = fopen($arquivo_encontrados, 'w');
                    fputcsv($handle_encontrados, ['NOME', 'CPF', 'DT NASC', 'SOMA VP']); // Cabeçalho

                    foreach ($encontrados as $encontrado) {
                        fputcsv($handle_encontrados, $encontrado);
                    }
                    fclose($handle_encontrados);

                    // Gera a segunda planilha (CPFs não encontrados)
                    $arquivo_nao_encontrados = 'arquivo_prestamista/Prestamista_nao_encontrados.csv';
                    $handle_nao_encontrados = fopen($arquivo_nao_encontrados, 'w');
                    fputcsv($handle_nao_encontrados, ['Nome', 'CPF', 'Data de Nascimento']); // Cabeçalho

                    foreach ($nao_encontrados as $nao_encontrado) {
                        fputcsv($handle_nao_encontrados, $nao_encontrado);
                    }
                    fclose($handle_nao_encontrados);

                    // Mensagem de sucesso
                    $_SESSION['msg'] = Alertas::alertaSucesso('Sucesso!', 'Arquivos gerados com sucesso');
                } else {
                    echo 'Erro ao abrir o arquivo.';
                }
            } else {
                echo 'Erro no upload do arquivo.';
            }
        } catch (PDOException $e) {
            echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
        }
        header('Location: /prestamista');
    }
}