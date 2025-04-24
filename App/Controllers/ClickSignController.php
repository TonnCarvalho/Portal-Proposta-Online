<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;
use App\Helper\Alertas;
use App\Helper\Contadores;
use App\Helper\ValorPorExtenso;

class ClickSignController extends Action
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

        $this->render('clicksign');
    }
    public function mostraPropostaClickSign()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $assinatura = Container::getModel('ClickSign');

        $assinatura_crud = $assinatura->clickSignInicio();
        echo json_encode($assinatura_crud);
    }
    public function filtraClickSignTotal()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $assinatura_crud = Contadores::ClickSignContador();
        echo json_encode($assinatura_crud);
    }

    //Envia para cessão de Click Sign
    public function enviarParaClickSign()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        $proposta = Container::getModel('Proposta');
        $id_proposta = $_GET['id_proposta'];
        $id_usuario = $_SESSION['id_usuario'];

        $proposta->mudarStatusProposta('status_assinatura', 1, $id_proposta,);
        $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
        $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
        $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'aguardando_click_sign');
        echo json_encode(['assinando' => true]);
    }

    public function remover()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $id_proposta = isset($_GET['id_proposta'])  ? $_GET['id_proposta'] : '';
        $id_usuario = $_SESSION['id_usuario'];

        $propostaModel = Container::getModel('Proposta');
        $propostaModel->mudarStatusProposta('status_assinatura', 0, $id_proposta);

        $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
        $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
        $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'removido_do_clicksign');

        echo json_encode(['remover' => true]);
    }

    public function adicionarRefin()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $dados = array_map('trim', $dados);

        $dados['saldo_devedor1'] = str_replace('.', '', $dados['saldo_devedor1']);
        $dados['saldo_devedor1'] = str_replace(',', '.', $dados['saldo_devedor1']);

        $dados['saldo_devedor2'] = str_replace('.', '', $dados['saldo_devedor2']);
        $dados['saldo_devedor2'] = str_replace(',', '.', $dados['saldo_devedor2']);

        $dados['saldo_devedor3'] = str_replace('.', '', $dados['saldo_devedor3']);
        $dados['saldo_devedor3'] = str_replace(',', '.', $dados['saldo_devedor3']);

        $dados['valor_parcela1'] = str_replace('.', '', $dados['valor_parcela1']);
        $dados['valor_parcela1'] = str_replace(',', '.', $dados['valor_parcela1']);

        $dados['valor_parcela2'] = str_replace('.', '', $dados['valor_parcela2']);
        $dados['valor_parcela2'] = str_replace(',', '.', $dados['valor_parcela2']);

        $dados['valor_parcela3'] = str_replace('.', '', $dados['valor_parcela3']);
        $dados['valor_parcela3'] = str_replace(',', '.', $dados['valor_parcela3']);

        try {
            $assinatura = Container::getModel('ClickSign');
            $assinatura->__set('id_proposta', $dados['id_proposta']);
            $assinatura->__set('id_associado', $dados['id_associado']);
            $assinatura->__set('num_proposta', $dados['num_proposta']);

            if (!empty($dados['num_contrato1']) && !empty($dados['saldo_devedor1']) && !empty($dados['valor_parcela1'])) {
                $assinatura->__set('num_contrato1', $dados['num_contrato1']);
                $assinatura->__set('saldo_devedor1', $dados['saldo_devedor1']);
                $assinatura->__set('valor_parcela1', $dados['valor_parcela1']);
            }
            if (!empty($dados['num_contrato2']) && !empty($dados['saldo_devedor2']) && !empty($dados['valor_parcela2'])) {
                $assinatura->__set('num_contrato2', $dados['num_contrato2']);
                $assinatura->__set('saldo_devedor2', $dados['saldo_devedor2']);
                $assinatura->__set('valor_parcela2', $dados['valor_parcela2']);
            }
            if (!empty($dados['num_contrato3']) && !empty($dados['saldo_devedor3']) && !empty($dados['valor_parcela3'])) {
                $assinatura->__set('num_contrato3', $dados['num_contrato3']);
                $assinatura->__set('saldo_devedor3', $dados['saldo_devedor3']);
                $assinatura->__set('valor_parcela3', $dados['valor_parcela3']);
            }
            $assinatura->adicionarRefin();

            $id_proposta = $dados['id_proposta'];
            $assinatura->mudarStatusRefinProposta($id_proposta);
            $_SESSION['msg'] = Alertas::alertaRefinSucesso('Adicionado', 'Refin adicionado com sucesso!');
        } catch (\Exception $e) {
            $_SESSION['msg'] = Alertas::alertaRefinError('Erro ao adicionar o refin');
        }

        header('Location: /clicksign');
    }

    public function editaRefin()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $dados = array_map('trim', $dados);

        $dados['saldo_devedor1'] = str_replace('R$', '', $dados['saldo_devedor1']);
        $dados['saldo_devedor2'] = str_replace('R$', '', $dados['saldo_devedor2']);
        $dados['saldo_devedor3'] = str_replace('R$', '', $dados['saldo_devedor3']);
        $dados['valor_parcela1'] = str_replace('R$', '', $dados['valor_parcela1']);
        $dados['valor_parcela2'] = str_replace('R$', '', $dados['valor_parcela2']);
        $dados['valor_parcela3'] = str_replace('R$', '', $dados['valor_parcela3']);

        $dados['saldo_devedor1'] = str_replace('.', '', $dados['saldo_devedor1']);
        $dados['saldo_devedor1'] = str_replace(',', '.', $dados['saldo_devedor1']);

        $dados['saldo_devedor2'] = str_replace('.', '', $dados['saldo_devedor2']);
        $dados['saldo_devedor2'] = str_replace(',', '.', $dados['saldo_devedor2']);

        $dados['saldo_devedor3'] = str_replace('.', '', $dados['saldo_devedor3']);
        $dados['saldo_devedor3'] = str_replace(',', '.', $dados['saldo_devedor3']);

        $dados['valor_parcela1'] = str_replace('.', '', $dados['valor_parcela1']);
        $dados['valor_parcela1'] = str_replace(',', '.', $dados['valor_parcela1']);

        $dados['valor_parcela2'] = str_replace('.', '', $dados['valor_parcela2']);
        $dados['valor_parcela2'] = str_replace(',', '.', $dados['valor_parcela2']);

        $dados['valor_parcela3'] = str_replace('.', '', $dados['valor_parcela3']);
        $dados['valor_parcela3'] = str_replace(',', '.', $dados['valor_parcela3']);
        try {
            $assinatura = Container::getModel('ClickSign');

            $assinatura->__set('id_refin', $dados['id_refin']);
            $assinatura->__set('id_associado', $dados['id_associado']);
            $assinatura->__set('num_proposta', $dados['num_proposta']);


            $assinatura->__set('num_contrato1', $dados['num_contrato1']);
            $assinatura->__set('saldo_devedor1', $dados['saldo_devedor1']);
            $assinatura->__set('valor_parcela1', $dados['valor_parcela1']);

            $assinatura->__set('num_contrato2', $dados['num_contrato2']);
            $assinatura->__set('saldo_devedor2', $dados['saldo_devedor2']);
            $assinatura->__set('valor_parcela2', $dados['valor_parcela2']);

            $assinatura->__set('num_contrato3', $dados['num_contrato3']);
            $assinatura->__set('saldo_devedor3', $dados['saldo_devedor3']);
            $assinatura->__set('valor_parcela3', $dados['valor_parcela3']);

            $assinatura->editaRefin();
            $_SESSION['msg'] = Alertas::alertaRefinSucesso('Editado', 'Refin editado com sucesso!');
        } catch (\Exception $e) {
            $_SESSION['msg'] = Alertas::alertaRefinError('Erro ao editar o refin');
        }

        header('Location: /clicksign');
    }
    public function apagaRefin()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $assinatura = Container::getModel('ClickSign');

        $id_proposta = isset($_GET['id_proposta'])  ? $_GET['id_proposta'] : '';
        $id_refin = isset($_GET['id_refin'])  ? $_GET['id_refin'] : '';

        $assinatura->removeRefinProposta($id_proposta);
        $assinatura->apagaRefin($id_refin);

        echo json_encode(['apagado' => true]);
    }
    public function gerarExcel()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $propostaModel = Container::getModel('Proposta');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            ini_set('default_charset', 'Windows-1252');
            if (!empty($_POST['id_proposta'])) {

                $id_proposta_checked = $_POST['id_proposta'];
                $cell = "";
                //Para cada id do checkbox, fazer a consulta na model
                foreach ($id_proposta_checked as $id_proposta) {
                    $assinatura = Container::getModel('ClickSign');
                    //faz a consulta pelo id
                    $dados_assinatura = $assinatura->dadosExcelClickSing($id_proposta);
                    //pegar os dados para por nas celulas da planilha
                    foreach ($dados_assinatura as $dados_excel) {
                        $proposta = $dados_excel['num_proposta'];
                        $cod_corretor = $dados_excel['cod_corretor'];
                        $estado_civil = $dados_excel['estado_civil'];
                        $valor_mensalidade = $dados_excel['valor_mensalidade']; // usada para a função valorPorExtenso funcionar.
                        $valor_mensalidade_extenso = ValorPorExtenso::valorPorExtenso($valor_mensalidade);
                        $valor_mensalidade = number_format($dados_excel['valor_mensalidade'], 2, ',', '.');
                        $valor_proposta = $dados_excel['valor_financiado']; // usada para a função valorPorExtenso funcionar.
                        $valor_proposta_extenso = ValorPorExtenso::valorPorExtenso($valor_proposta);
                        $valor_proposta = number_format($dados_excel['valor_financiado'], 2, ',', '.');
                        $valor_parcela = $dados_excel['valor_parcela']; // usada para a função valorPorExtenso funcionar.
                        $valor_parcela_extenso = ValorPorExtenso::valorPorExtenso($valor_parcela);
                        $valor_parcela = number_format($dados_excel['valor_parcela'], 2, ',', '.');
                        $prazo = $dados_excel['prazo'];
                        $mes_inicio = date('m', strtotime('+1 month'));
                        $ano_inicio = date('Y');
                        $suaempresa = 'Fulano de Tal';
                        $agencia = $dados_excel['agencia'];
                        $banco = $dados_excel['banco'];
                        $conta = $dados_excel['conta'];
                        $sexo = $dados_excel['sexo'] == "M" ? 'MASCULINO' : 'FEMININO';

                        $nome_pai = $dados_excel['nome_pai'] != '' ? $dados_excel['nome_pai'] : 'NULL';
                        $setor = $this->conversoUtf($dados_excel['setor']);
                        $nome = $this->conversoUtf($dados_excel['nome']);
                        $data_nasc = $dados_excel['data_nasc'];
                        $cpf = $dados_excel['cpf'];
                        $mat = $dados_excel['mat'];
                        $rg = $dados_excel['rg'];
                        $org_exp = $this->conversoUtf($dados_excel['orgao_exp']);
                        $email = $this->conversoUtf($dados_excel['email']);
                        $cel = $dados_excel['cel'];
                        $tel = $dados_excel['tel'] != '' ? $dados_excel['tel'] : 'NULL';
                        $tel_com = 'NULL';
                        $orgao = $this->conversoUtf($dados_excel['nome_orgao']);
                        $cargo = $this->conversoUtf($dados_excel['cargo']);
                        $nat = $dados_excel['nat'];
                        $nome_mae = $this->conversoUtf($dados_excel['nome_mae']);
                        $end = $this->conversoUtf($dados_excel['endereco']);
                        $bairro = $this->conversoUtf($dados_excel['bairro']);
                        $municipio = $this->conversoUtf($dados_excel['municipio']);
                        $uf = $this->conversoUtf($dados_excel['uf']);
                        $cep = $dados_excel['cep'];
                        $dep1_nome = 'NULL';
                        $dep1_nasc = 'NULL';
                        $dep1_parentesco = 'NULL';
                        $dep1_cpf = 'NULL';
                        $dep1_nome_mae = 'NULL';
                        $dep2_nome = 'NULL';
                        $dep2_nasc = 'NULL';
                        $dep2_parentesco = 'NULL';
                        $dep2_cpf = 'NULL';
                        $dep2_nome_mae = 'NULL';

                        $mes_extenso = array(
                            'Jan' => 'Janeiro',
                            'Feb' => 'Fevereiro',
                            'Mar' => 'Marco',
                            'Apr' => 'Abril',
                            'May' => 'Maio',
                            'Jun' => 'Junho',
                            'Jul' => 'Julho',
                            'Aug' => 'Agosto',
                            'Nov' => 'Novembro',
                            'Sep' => 'Setembro',
                            'Oct' => 'Outubro',
                            'Dec' => 'Dezembro'
                        );

                        $dia = date('d');
                        $m = date('M');
                        $mes = $mes_extenso[$m];
                        $ano = date('Y');

                        $dia_refin = date('d', strtotime($dados_excel['data_hora']));
                        $mes_refin = date('m', strtotime($dados_excel['data_hora']));
                        $ano_refin = date('Y', strtotime($dados_excel['data_hora']));

                        $contrat_ant = $dados_excel['num_contrato1'] != 0 ? $dados_excel['num_contrato1'] : 'NULL';
                        $saldo1 = $dados_excel['saldo_devedor1'] != 0 ? number_format($dados_excel['saldo_devedor1'], 2, ',', '.') : 'NULL';
                        $saldo1_exte = $dados_excel['saldo_devedor1'] != 0 ? ValorPorExtenso::valorPorExtenso($dados_excel['saldo_devedor1']) : 'NULL';

                        $parce1 = $dados_excel['valor_parcela1'] != 0 ?  number_format($dados_excel['valor_parcela1'], 2, ',', '.') : 'NULL';
                        $parce1_exte = $dados_excel['valor_parcela1'] != 0 ? ValorPorExtenso::valorPorExtenso($dados_excel['valor_parcela1']) : 'NULL';


                        $dia1 = $contrat_ant != 'NULL' ? $dia_refin : 'NULL';
                        $mes1 = $contrat_ant != 'NULL' ? $mes_refin : 'NULL';
                        $ano1 = $contrat_ant != 'NULL' ? $ano_refin : 'NULL';

                        $contrat_ant2 = $dados_excel['num_contrato2'] != 0 ? $dados_excel['num_contrato2'] : 'NULL';
                        $saldo2 = $dados_excel['saldo_devedor2'] != 0 ? number_format($dados_excel['saldo_devedor2'], 2, ',', '.') : 'NULL';
                        $saldo2_exte = $dados_excel['saldo_devedor2'] != 0 ?  ValorPorExtenso::valorPorExtenso($dados_excel['saldo_devedor2']) : 'NULL';

                        $parce2 = $dados_excel['valor_parcela2'] != 0 ? number_format($dados_excel['valor_parcela2'], 2, ',', '.') : 'NULL';
                        $parce2_exte = $dados_excel['valor_parcela2'] != 0 ?  ValorPorExtenso::valorPorExtenso($dados_excel['valor_parcela2']) : 'NULL';

                        $dia2 = $contrat_ant2 != 'NULL' ? $dia_refin : 'NULL';
                        $mes2 = $contrat_ant2 != 'NULL' ? $mes_refin : 'NULL';
                        $ano2 = $contrat_ant2 != 'NULL' ? $ano_refin : 'NULL';

                        $contrat_ant3 = $dados_excel['num_contrato3'] != 0 ? $dados_excel['num_contrato3'] : 'NULL';
                        $saldo3 = $dados_excel['saldo_devedor3'] != 0 ? number_format($dados_excel['saldo_devedor3'], 2, ',', '.') : 'NULL';
                        $saldo3_exte = $dados_excel['saldo_devedor3'] != 0 ?  ValorPorExtenso::valorPorExtenso($dados_excel['saldo_devedor3']) : 'NULL';

                        $parce3 = $dados_excel['valor_parcela3'] != 0 ? number_format($dados_excel['valor_parcela3'], 2, ',', '.') : 'NULL';
                        $parce3_exte = $dados_excel['valor_parcela3'] != 0 ?  ValorPorExtenso::valorPorExtenso($dados_excel['valor_parcela3']) : 'NULL';

                        $dia3 = $contrat_ant3 != 'NULL' ? $dia_refin : 'NULL';
                        $mes3 = $contrat_ant3 != 'NULL' ? $mes_refin : 'NULL';
                        $ano3 = $contrat_ant3 != 'NULL' ? $ano_refin : 'NULL';

                        $dia4 = $dia;
                        $mes4 = $mes;
                        $ano4 = $ano;

                        //celulas
                        $cell .= "$proposta;$cod_corretor;$estado_civil;$valor_mensalidade;$valor_mensalidade_extenso;$valor_proposta;$valor_proposta_extenso;$valor_parcela;$valor_parcela_extenso;$prazo;$mes_inicio;$ano_inicio;$suaempresa;$agencia;$banco;$conta;$sexo;$nome_pai;$setor;$nome;$data_nasc;$cpf;$mat;$rg;$org_exp;$email;$cel;$orgao;$cargo;$nat;$nome_mae;$end;$bairro;$municipio;$uf;$cep;$tel;$tel_com;$dep1_nome;$dep1_nasc;$dep1_parentesco;$dep1_cpf;$dep1_nome_mae;$dep2_nome;$dep2_nasc;$dep2_parentesco;$dep2_cpf;$dep2_nome_mae;$dia;$mes;$ano;$contrat_ant;$dia1;$mes1;$ano1;$saldo1;$saldo1_exte;$parce1;$parce1_exte;$contrat_ant2;$dia2;$mes2;$ano2;$saldo2;$saldo2_exte;$parce2;$parce2_exte;$contrat_ant3;$dia3;$mes3;$ano3;$saldo3;$saldo3_exte;$parce3;$parce3_exte;$dia4;$mes4;$ano4\n";
                    }
                }
            }
        }

        //header
        $header = "proposta;cod_corretor;estado_civil;valor_mens;valor_mens_extenso;valor_proposta;valor_proposta_extenso;valor_parcela;valor_parcela_extenso;prazo;mesini;anoini;sua_empresa;agencia;banco;conta;sexo;nome_pai;setor;nome;data_nasc;cpf;mat;rg;org_exp;email;cel;orgao;cargo;nat;nome_mae;end;bairro;municipio;uf;cep;tel;tel_com;dep1_nome;dep1_nasc;dep1_parentesco;dep1_cpf;dep1_nome_mae;dep2_nome;dep2_nasc;dep2_parentesco;dep2_cpf;dep2_nome_mae;dia;mes;ano;contrat_ant;dia1;mes1;ano1;saldo1;saldo1_exte;parce1;parce1_exte;contrat_ant2;dia2;mes2;ano2;saldo2;saldo2_exte;parce2;parce2_exte;contrat_ant3;dia3;mes3;ano3;saldo3;saldo3_exte;parce3;parce3_exte;dia4;mes4;ano4\n";

        $arquivo = $header . $cell;
        $arquivo_nome = "download_clicksign/click_sign_" . date('d') . date('m') . date('Y') . "_" . date('H') . date('i') . date('s') . ".csv";

        //GERAR A PLANILHA
        $arquivo_aberto = fopen($arquivo_nome, "w"); // abre o arquivo para leitura e escrita

        //TODO melhorar o tratamento de erro, se for false, mandar uma mensagem pela session e encaminhar para pagina de click sign
        if (!$arquivo_aberto) {
            echo 'não foi possivel abrir o arquivo';
        }
        fwrite($arquivo_aberto, $arquivo); //arquivo aberto e dados a ser gravado dentro do arquivo aberto.
        fclose($arquivo_aberto); // fecha o arquivo

        $id_usuario = $_SESSION['id_usuario'];
        $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
        foreach ($id_proposta_checked as $id_proposta) {

            $propostaModel->tipoAssinatura($id_proposta, 'click_sign');

            $propostaModel->mudarStatusProposta('status_proposta', 6, $id_proposta); //status proposta = aguardando assinatura
            $propostaModel->mudarStatusProposta('status_assinatura', 2, $id_proposta); //status click sign = gerado
            $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
            $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'aguardando_assinatura');
        }
        // Gerar download do arquivo
        if (file_exists($arquivo_nome)) {
            // Define os cabeçalhos HTTP
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($arquivo_nome) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($arquivo_nome));

            ob_clean();
            flush();
            readfile($arquivo_nome);
            exit;
        } else {
            die("Arquivo não encontrado.");
        }
    }

    public function conversoUtf($valor)
    {
        $texto = strtoupper($valor);
        $texto = mb_convert_encoding($valor, 'Windows-1252', 'UTF-8');
        return $texto;
    }
}
