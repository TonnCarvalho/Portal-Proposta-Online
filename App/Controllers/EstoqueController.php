<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class EstoqueController extends Action
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
        $this->render('estoque_consulta');
    }

    public function adicionarEstoque()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        $this->render('estoque_adicionar');
    }
    public function estoqueSucesso()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $this->render('estoque_sucesso');
    }

    public function buscarEstoqueAssociado()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $num_proposta = $_GET['num_proposta'];
        $estoque = Container::getModel('Estoque');
        $resultado = $estoque->buscarEstoqueAssociado($num_proposta);
        $resultado = json_encode($resultado);
        echo $resultado;
    }

    // Função para converter os dados ISO-8859-1 para UTF-8
    public function converter(&$dados_arquivo)
    {
        $dados_arquivo = mb_convert_encoding($dados_arquivo, "UTF-8", "ISO-8859-1");
    }

    //extrair estoque do tipo zip
    public function extractZip($zipFile, $destDir)
    {
        $zip = new ZipArchive;
        if ($zip->open($zipFile) === TRUE) {
            $zip->extractTo($destDir);
            $zip->close();
            return true;
        }
        return false;
    }

    //extrair estoque do tipo rar
    public function extractRar($rarFile, $destDir)
    {
        if (!extension_loaded('rar')) {
            die('A extensão RAR não está disponível.');
        }
        $rar = RarArchive::open($rarFile);
        if ($rar === false) {
            die('Erro ao abrir o arquivo RAR.');
        }
        $entries = $rar->getEntries();
        foreach ($entries as $entry) {
            $entry->extract($destDir);
        }
        $rar->close();
        return true;
    }

    public function enviarEstoque()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        $estoque = Container::getModel('Estoque');
        // Recebe o arquivo do input
        $arquivo = $_FILES['arquivo'];

        // Diretório temporário para processar arquivo CSV
        $dir_temp = sys_get_temp_dir();

        // Gera um nome aleatório para a pasta temporária
        $temp_folder = $dir_temp . '/' . uniqid('temp_', true);
        mkdir($temp_folder);

        // Verifica a extensão do arquivo
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

        // Extrai o arquivo compactado, se necessário

        if ($extensao === 'zip') {
            if (!$this->extractZip($arquivo['tmp_name'], $temp_folder)) {
                die('Erro ao descompactar o arquivo ZIP.');
            }
        } elseif ($extensao === 'rar') {
            if (!$this->extractRar($arquivo['tmp_name'], $temp_folder)) {
                die('Erro ao descompactar o arquivo RAR.');
            }
        }

        // Se o arquivo não foi extraído e é do tipo CSV, move para a pasta temporária
        if ($extensao === 'csv') {
            move_uploaded_file($arquivo['tmp_name'], $temp_folder . '/' . $arquivo['name']);
        }
        // Verifica se há arquivos CSV na pasta temporária
        $csv_files = glob($temp_folder . '/*.csv');
        if (count($csv_files) === 0) {
            die('Nenhum arquivo CSV encontrado.');
        }

        // Processa o primeiro arquivo CSV encontrado
        $csvFile = $csv_files[0];
        $dados_arquivo = fopen($csvFile, 'r');
        if (!$dados_arquivo) {
            die('Erro ao abrir o arquivo CSV.');
        }

        // Pula a primeira linha do CSV
        fgetcsv($dados_arquivo, 1000, ";");

        // Script para criar a tabela estoque_novo
        $estoque->dropAlterTabelaEstoque('DROP TABLE IF EXISTS `estoque_novo`');

        $estoque->criarTabelaEstoque();

        // Inicializa um array para armazenar os valores dos registros a serem inseridos
        $registros = array();
        $count = 0;

        // Loop para ler as linhas do CSV

        while (($data = fgetcsv($dados_arquivo, 1000, ";")) !== FALSE) {
            $count++;
            $this->converter($data);

            // As colunas no CSV estão indexadas numericamente, então pegamos o valor da coluna diretamente pelo índice
            $nome = $data[6];
            $cpf = $data[7];
            // $nome = mysqli_real_escape_string($conexao, $data[6]);
            // $cpf = mysqli_real_escape_string($conexao, $data[7]);

            // Ajuste para a data de aquisicao
            list($dia, $mes, $ano) = explode('/', $data[15]);
            $data_aquisicao = "$ano-$mes-$dia";

            $situacao = $data[21];
            // $situacao = mysqli_real_escape_string($conexao, $data[21]);

            // Tratamento dos valores monetários
            $valor_nominal = floatval(str_replace(',', '.', str_replace('.', '', $data[9])));
            $valor_presente = floatval(str_replace(',', '.', str_replace('.', '', $data[10])));
            $valor_aquisicao = floatval(str_replace(',', '.', str_replace('.', '', $data[11])));

            // numero da proposta
            $num_proposta =  $data[17];

            // Ajuste para a data de vencimento
            list($dia, $mes, $ano) = explode('/', $data[23]);
            $data_vencimento = "$ano-$mes-$dia";

            // Adiciona os valores da linha atual ao array de registros
            $registros[] = "('$nome', '$cpf', '$num_proposta', '$data_aquisicao', '$situacao', $valor_nominal, $valor_presente, $valor_aquisicao, '$data_vencimento')";

            // Se o número de registros no array for maior que 1000, insere-os no banco de dados
            if (count($registros) >= 1000) {
                $estoque->inserirRegistros($registros);
                // Limpa o array de registros
                $registros = array();
            }
        }

        // Insere os registros restantes no banco de dados
        if (!empty($registros)) {
            $estoque->inserirRegistros($registros);
        }

        if ($count) {
            $estoque->dropAlterTabelaEstoque('DROP TABLE IF EXISTS `estoque`');
            $estoque->dropAlterTabelaEstoque('ALTER TABLE `estoque_novo` RENAME TO `estoque`');
        }

        // Apaga a pasta temporária e todos os arquivos extraídos ou movidos
        array_map('unlink', glob("$temp_folder/*.*"));
        rmdir($temp_folder);

        header('Location: estoque-sucesso');
    }
}
