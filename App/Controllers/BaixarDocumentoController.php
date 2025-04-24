<?php

namespace App\Controllers;


use MF\Controller\Action;
use MF\Model\Container;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Helper\ValorPorExtenso;
use DateTime;

class BaixarDocumentoController extends Action
{
    public function AutenticarUsuario()
	{
		$authController = new AuthController;
		return $authController->validarAutenticacao();
	}
    
    public function dadosAssociadoDocumento($id_proposta)
    {
        $this->AutenticarUsuario();

        $propostaModel = Container::getModel('Proposta');
        $propostaModel->__set('id_proposta', $id_proposta);
        $dados_proposta = $propostaModel->pegarDadosProposta();

        if ($dados_proposta[0]['sexo'] === 'M') {
            $sexo = 'MASCULINO';
        } else {
            $sexo = 'FEMININO';
        }

        $valor_financiado = str_replace('.', ',', $dados_proposta[0]['valor_financiado']);
        $valor_liberado = str_replace('.', ',', $dados_proposta[0]['valor_liberado']);
        $valor_parcela = str_replace('.', ',', $dados_proposta[0]['valor_parcela']);
        $valor_mensalidade = str_replace('.', ',', $dados_proposta[0]['valor_mensalidade']);

        $dados_proposta_documento = array();
        foreach ($dados_proposta as $dados) {
            $date = DateTime::createFromFormat('d/m/Y', $dados['data_proposta']);

            $dados_proposta_documento = [
                '${num_proposta}' => $dados['num_proposta'],
                '${cod_corretor}' => $dados['cod_corretor'],
                '${nome_praca}' => $dados['nome_praca'],
                '${nome}' => $this->conversoUtf($dados['nome']),
                '${data_nascimento}' => (new DateTime($dados['data_nasc']))->format('d/m/Y'),
                '${cpf}' => $dados['cpf'],
                '${rg}' => $dados['rg'],
                '${matricula}' => $dados['mat'],
                '${estado_civil}' => $dados['estado_civil'],
                '${sexo}' => $sexo,
                '${orgao_exp}' => $dados['orgao_exp'],
                '${nome_mae}' => $dados['nome_mae'],
                '${nome_pai}' => $dados['nome_pai'],
                '${nat}' => $dados['nat'],
                '${tel}' => $dados['tel'],
                '${cel}' => $dados['cel'],
                '${email}' => $dados['email'],
                '${logradouro}' => $dados['endereco'],
                '${bairro}' => $dados['bairro'],
                '${localidade}' => $dados['municipio'],
                '${uf}' => $dados['uf'],
                '${cep}' => $dados['cep'],
                '${setor}' => $dados['setor'],
                '${orgao}' => $dados['nome_orgao'],
                '${cargo}' => $dados['cargo'],
                '${data_admissao}' => (new DateTime($dados['data_admissao']))->format('d/m/Y'),
                '${valor_financiado}' => $valor_financiado,
                '${valor_financiado_extenso}' => ValorPorExtenso::valorPorExtenso($dados['valor_financiado']),
                '${valor_liberado}' => $valor_liberado,
                '${valor_parcela}' => $valor_parcela,
                '${valor_parcela_extenso}' => ValorPorExtenso::valorPorExtenso($dados['valor_parcela']),
                '${valor_mensalidade}' => $valor_mensalidade,
                '${valor_mensalidade_extenso}' => ValorPorExtenso::valorPorExtenso($dados['valor_mensalidade']),
                '${prazo}' => $dados['prazo'],
                '${banco}' => $dados['banco'],
                '${agencia}' => $dados['agencia'],
                '${conta}' => $dados['conta'],
                '${dep1_nome}' => 'NULL',
                '${dep1_nasc}' => 'NULL',
                '${dep1_cpf}' => 'NULL',
                '${dep1_parentesco}' => 'NULL',
                '${dep1_nome_mae}' => 'NULL',
                '${dep2_nome}' => 'NULL',
                '${dep2_nasc}' => 'NULL',
                '${dep2_cpf}' => 'NULL',
                '${dep2_parentesco}' => 'NULL',
                '${dep2_nome_mae}' => 'NULL',
                '${dia}' => $date->format('d'),
                '${mes}' => $this->meses($date->format('m')),
                '${ano}' => $date->format('Y'),
                'mesini' => $date->format('m'),
                'anoini' => $date->format('Y'),
                '${assinatura_presidente}' => 'Fulado de tal',
                '${assinatura_associado}' => $dados['nome'],
            ];
        }
        return $dados_proposta_documento;
    }

    public function gerarDocumento()
    {
        $this->AutenticarUsuario();

        $id_proposta = isset($_POST['id_proposta']) ? $_POST['id_proposta'] : '';

        $propostaModel = Container::getModel('Proposta');
        $propostaModel->tipoAssinatura($id_proposta, 'FÍSICA');

        $propostaModel->mudarStatusProposta('status_proposta', 6, $id_proposta); //status proposta = aguardando assinatura
        $propostaModel->mudarStatusProposta('status_assinatura', 2, $id_proposta); //status assinatura = gerado

        $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
        $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
        $id_usuario = $_SESSION['id_usuario'];
        $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'aguardando assinatura');
        
        $dados_associado = $this->dadosAssociadoDocumento($id_proposta);

        $arquivo = 'arquivo_contrato_associado/CONTRATO_ASSOCIADO.docx';

        $templateProcessor = new TemplateProcessor($arquivo);

        $num_proposta = $dados_associado['${num_proposta}'];
        $nome_associado = $dados_associado['${nome}'];

        foreach ($dados_associado as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $salvar = "download_contrato_associado/$num_proposta-$nome_associado.docx";
        $templateProcessor->saveAs($salvar);

        // Verifica se o arquivo existe
        if (file_exists($salvar)) {
            // Define os cabeçalhos HTTP
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($salvar) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($salvar));

            ob_clean();
            flush();
            readfile($salvar);
            exit;
        } else {
            die("Arquivo não encontrado.");
        }
    }

    public function meses($mes)
    {
        $meses = [
            '01' => 'janeiro',
            '02' => 'fevereiro',
            '03' => 'março',
            '04' => 'abril',
            '05' => 'maio',
            '06' => 'junho',
            '07' => 'julho',
            '08' => 'agosto',
            '09' => 'setembro',
            '10' => 'outubro',
            '11' => 'novembro',
            '12' => 'dezembro',
        ];
        return $meses[$mes];
    }
    public function conversoUtf($valor)
    {
        $texto = strtoupper($valor);
        $texto = mb_convert_encoding($valor, 'Windows-1252', 'UTF-8');
        return $texto;
    }
}
