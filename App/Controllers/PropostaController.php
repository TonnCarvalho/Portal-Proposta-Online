<?php

namespace App\Controllers;

use MF\Controller\Action;
use App\Controllers\AuthController;
use App\Helper\Alertas;
use MF\Model\Container;
use Exception;
use setasign\Fpdi\Fpdi;

class PropostaController extends Action
{
    public function AutenticarUsuario()
    {
        $authController = new AuthController;
        return $authController->validarAutenticacao();
    }


    public int $id_conferente;
    //TODO enviar email para o associado informando os beneficios    
    // public function emailPropostaCriada($nome_associado, $uri_proposta)
    // {
    //     //Pega os dados do corretor e da proposta para enviar informações ao email do corretor.

    //     $email = new phpMailerEnvio;
    //     $para = 'cleiton_601@hotmail.com';
    //     $nome_para =  '';
    //     $assunto = 'Nova Proposta';
    //     $nome_associado = $nome_associado;
    //     $uri_proposta = $uri_proposta;

    //     $email->emailPropostaCriada($para, $nome_para, $assunto, $nome_associado, $uri_proposta);
    // }
    /**
     * Mostra os dados dos associados na tela em /cadastro-proposta
     */
    public function propostaCadastro()
    {
        $this->AutenticarUsuario();

        $pracas = Container::getModel('Praca');
        $pracas_lista = $pracas->getTodasPracasAtivas();

        $associadoModel = Container::getModel('Associado');

        $cpfCadastro = $_POST['cpfCadastro'];
        $pracaCadastro = $_POST['pracaCadastro'];

        //Para pesquisa o associado, quando seleciona praça e cpf na primeira etapa do cadastro.
        if (isset($_POST['cadastro']) && $cpfCadastro != '' &&  $pracaCadastro != '') {

            $admin = $_SESSION['admin'];
            $cod_corretor = $_SESSION['cod_corretor'];

            $associado_lista = $associadoModel->getAssociadoCadastroProposta($cpfCadastro);

            //Se o retorno da consulta de cpf não for vazio, preenche os dados
            if (!empty($associado_lista)) {
                foreach ($associado_lista as $associado) {
                    if ($admin == 1 || $cod_corretor == $associado['cod_corretor']) {
                        $this->view->nome = $associado['nome'];
                        $this->view->rg = $associado['rg'];
                        $this->view->orgao_exp = $associado['orgao_exp'];
                        $this->view->email = $associado['email'];
                        $this->view->data_nasc = $associado['data_nasc'];
                        $this->view->nat = $associado['nat'];
                        $this->view->sexo = $associado['sexo'];
                        $this->view->cel = $associado['cel'];
                        $this->view->tel = $associado['tel'];
                        $this->view->nome_pai = $associado['nome_pai'];
                        $this->view->nome_mae = $associado['nome_mae'];
                        $this->view->estado_civil = $associado['estado_civil'];
                        $this->view->mat =  $associado['mat'];
                        $this->view->orgao_nome = $associado['orgao'];
                        $this->view->cod_orgao = $associado['cod_orgao'];
                        $this->view->setor = $associado['setor'];
                        $this->view->cargo = $associado['cargo'];
                        $this->view->ocupacao = $associado['ocupacao'];
                        $this->view->data_admissao = $associado['data_admissao'];
                        $this->view->banco = $associado['banco'];
                        $this->view->conta = $associado['conta'];
                        $this->view->agencia = $associado['agencia'];
                        $this->view->banco_pagamento = $associado['banco_pagamento'];
                        $this->view->conta_pagamento = $associado['conta_pagamento'];
                        $this->view->agencia_pagamento = $associado['agencia_pagamento'];
                        $this->view->tipo_bancario = $associado['tipo_bancario'];
                        $this->view->cep = $associado['cep'];
                        $this->view->uf = $associado['uf'];
                        $this->view->municipio = $associado['municipio'];
                        $this->view->bairro = $associado['bairro'];
                        $this->view->endereco = $associado['endereco'];
                    }
                }
            }

            //Pega a praça ao selecionar no cadastro, e mostra no formulario.
            $pracas->__set('cod_local', $pracaCadastro);
            $pracas_lista = $pracas->getPracaCadastroAssociado();
            $this->view->pracas = $pracas_lista;
        }

        //pega o cargo pelo cod_local do associado, e mostra no select orgao
        $orgao = Container::getModel('Orgao');
        $orgao->__set('cod_local', $pracaCadastro);
        $orgao_lista = $orgao->buscaCodigoOrgaoPeloCodlocal();
        $this->view->orgao = $orgao_lista;

        //lista as praças no cadastro, praça e cpf
        $this->view->pracas = $pracas_lista;
        $this->render('proposta_cadastro');
    }

    public function propostaCadastrar()
    {
        $this->AutenticarUsuario();

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); //Pega os dados dos inputs
        //Realiza o tratamento dos dados e envia para o banco de dados.
        $dados = array_map('trim', $dados); //Remove os espaços em brancos
        $dados = array_map('strtoupper', $dados); //Transforma todas as string em maiusculo
        $dados['email'] = strtolower($dados['email']); //Transforma somente o  email em minusculo

        //Tratamento nos valores para o formado do banco de dados
        $dados['financiado'] = str_replace('.', '', $dados['financiado']); //Substituir o ponto
        $dados['financiado'] = str_replace(',', '.', $dados['financiado']); //Substituir a virgula por pontos

        $dados['liberado'] = str_replace('.', '', $dados['liberado']); //Substituir o ponto
        $dados['liberado'] = str_replace(',', '.', $dados['liberado']); //Substituir a virgula por pontos

        $dados['parcela'] = str_replace('.', '', $dados['parcela']); //Substituir o ponto
        $dados['parcela'] = str_replace(',', '.', $dados['parcela']); //Substituir a virgula por pontos

        $dados['mensalidade'] = str_replace('.', '', $dados['mensalidade']); //Substituir o ponto
        $dados['mensalidade'] = str_replace(',', '.', $dados['mensalidade']); //Substituir a virgula por pontos

        $dados['iof'] = str_replace('.', '', $dados['iof']); //Substituir o ponto
        $dados['iof'] = str_replace(',', '.', $dados['iof']); //Substituir a virgula por pontos

        //tratamento dos caracteres que não sejam números.
        $dados['cel'] = preg_replace('/\D/', '', $dados['cel']);

        $dados['tel'] = preg_replace('/\D/', '', $dados['tel']);

        $dados['tipo_proposta'] = strtolower($dados['tipo_proposta']);


        $associadoModel = Container::getModel('Associado');
        $propostaModel = Container::getModel('Proposta');

        //Verificar se já existe.
        $cpf = $dados['cpf'];
        $cod_corretor = $dados['cod_corretor'];
        $cod_local = $dados['cod_local'];
        $associadoCorretor = $associadoModel->pegaCpfAssociadoCodCorretor($cpf, $cod_corretor, $cod_local);

        //Verifica se já existe a matricula
        $matricula = $dados['mat'];
        $verificaMatricula = $associadoModel->verificaMatricula($cpf, $cod_corretor, $cod_local, $matricula);

        $id_usuario = $_SESSION['id_usuario'];

        //Se não existir associado
        if (empty($associadoCorretor) || empty($verificaMatricula)) {
            //Cadastra associado e proposta
            try {
                $associadoModel->__set('id_usuario',  $id_usuario);
                $associadoModel->__set('cod_local', $dados['cod_local']);
                $associadoModel->__set('cod_corretor', $dados['cod_corretor']);
                $associadoModel->__set('nome', $dados['nome']);
                $associadoModel->__set('cpf', $dados['cpf']);
                $associadoModel->__set('rg', $dados['rg']);
                $associadoModel->__set('orgao_exp', $dados['orgao_exp']);
                $associadoModel->__set('data_nasc', $dados['data_nasc']);
                $associadoModel->__set('nat', $dados['nat']);
                $associadoModel->__set('sexo', $dados['sexo']);
                $associadoModel->__set('estado_civil', $dados['estado_civil']);
                $associadoModel->__set('tel', $dados['tel']);
                $associadoModel->__set('cel', $dados['cel']);
                $associadoModel->__set('email', $dados['email']);
                $associadoModel->__set('nome_pai', $dados['nome_pai']);
                $associadoModel->__set('nome_mae', $dados['nome_mae']);
                $associadoModel->__set('mat', $dados['mat']);
                $associadoModel->__set('cod_orgao', $dados['cod_orgao']);
                $associadoModel->__set('setor', $dados['setor']);
                $associadoModel->__set('cargo', $dados['cargo']);
                $associadoModel->__set('ocupacao', $dados['ocupacao']);
                $associadoModel->__set('data_admissao', $dados['data_admissao']);
                $associadoModel->__set('cep', $dados['cep']);
                $associadoModel->__set('uf', $dados['uf']);
                $associadoModel->__set('municipio', $dados['municipio']);
                $associadoModel->__set('bairro', $dados['bairro']);
                $associadoModel->__set('endereco', $dados['endereco']);
                $associadoModel->__set('banco', $dados['banco']);
                $associadoModel->__set('conta', $dados['conta']);
                $associadoModel->__set('agencia', $dados['agencia']);
                $associadoModel->__set('banco_pagamento', $dados['banco_pagamento']);
                $associadoModel->__set('conta_pagamento', $dados['conta_pagamento']);
                $associadoModel->__set('agencia_pagamento', $dados['agencia_pagamento']);
                $associadoModel->__set('tipo_bancario', $dados['tipo_bancario']);
                $associadoModel->cadastrarAssociado();

                //Cadastra Proposta
                $id_associado = $associadoModel->getlastInsertIdCliente();
                $propostaModel->__set('id_associado', $id_associado);
                $propostaModel->__set('id_usuario', $id_usuario);
                $propostaModel->__set('cod_local', $dados['cod_local']);
                $propostaModel->__set('cod_corretor', $dados['cod_corretor']);
                $propostaModel->__set('valor_financiado', $dados['financiado']);
                $propostaModel->__set('valor_liberado', $dados['liberado']);
                $propostaModel->__set('valor_parcela', $dados['parcela']);
                $propostaModel->__set('valor_mensalidade', $dados['mensalidade']);
                $propostaModel->__set('valor_mensalidade', $dados['mensalidade']);
                $propostaModel->__set('prazo', $dados['prazo']);
                $propostaModel->__set('taxa', $dados['taxa']);
                $propostaModel->__set('iof', $dados['iof']);
                $propostaModel->__set('tipo_proposta', $dados['tipo_proposta']);
                $propostaModel->cadastraProposta();

                //Salvar as imagens dos documentos do associado
                $id_proposta = $propostaModel->getlastInsertIdProposta();

                $_SESSION['msg'] = Alertas::alertaSucesso('Sucesso!', 'Proposta cadastrada com sucesso');

                $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
                $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, 'NULL', 'em andamento');
                header('Location: /inicio');
            } catch (\Exception $e) {
                $_SESSION['msg'] = Alertas::alertaErro('Erro!', 'Falha ao criar proposta');
            }

            //Se já existir o associado com o corretor
        } elseif (!empty($associadoCorretor) || !empty($verificaMatricula)) {

            $associadoModel->__set('cpf', $dados['cpf']);
            $associadoModel->__set('cod_corretor', $dados['cod_corretor']);
            $associadoModel->__set('cod_local', $dados['cod_local']);
            $associadoModel->__set('mat', $dados['mat']);
            $id_associado = $associadoModel->getIdAssociadoCorretor();

            try {
                //Atualiza associado
                $associadoModel->__set('id_associado',  $id_associado);
                $associadoModel->__set('id_usuario',  $id_usuario);
                $associadoModel->__set('cod_local', $dados['cod_local']);
                $associadoModel->__set('nome', $dados['nome']);
                $associadoModel->__set('rg', $dados['rg']);
                $associadoModel->__set('orgao_exp', $dados['orgao_exp']);
                $associadoModel->__set('data_nasc', $dados['data_nasc']);
                $associadoModel->__set('nat', $dados['nat']);
                $associadoModel->__set('sexo', $dados['sexo']);
                $associadoModel->__set('estado_civil', $dados['estado_civil']);
                $associadoModel->__set('tel', $dados['tel']);
                $associadoModel->__set('cel', $dados['cel']);
                $associadoModel->__set('email', $dados['email']);
                $associadoModel->__set('nome_pai', $dados['nome_pai']);
                $associadoModel->__set('nome_mae', $dados['nome_mae']);
                $associadoModel->__set('mat', $dados['mat']);
                $associadoModel->__set('cod_orgao', $dados['cod_orgao']);
                $associadoModel->__set('setor', $dados['setor']);
                $associadoModel->__set('cargo', $dados['cargo']);
                $associadoModel->__set('ocupacao', $dados['ocupacao']);
                $associadoModel->__set('data_admissao', $dados['data_admissao']);
                $associadoModel->__set('cep', $dados['cep']);
                $associadoModel->__set('uf', $dados['uf']);
                $associadoModel->__set('municipio', $dados['municipio']);
                $associadoModel->__set('bairro', $dados['bairro']);
                $associadoModel->__set('endereco', $dados['endereco']);
                $associadoModel->__set('banco', $dados['banco']);
                $associadoModel->__set('conta', $dados['conta']);
                $associadoModel->__set('agencia', $dados['agencia']);
                $associadoModel->__set('banco_pagamento', $dados['banco_pagamento']);
                $associadoModel->__set('conta_pagamento', $dados['conta_pagamento']);
                $associadoModel->__set('agencia_pagamento', $dados['agencia_pagamento']);
                $associadoModel->__set('tipo_bancario', $dados['tipo_bancario']);
                $associadoModel->atualizarAssociadoProposta();

                $propostaModel->__set('id_associado', $id_associado);
                $propostaModel->__set('cod_corretor', $dados['cod_corretor']);
                $propostaModel->__set('id_usuario', $id_usuario);
                $propostaModel->__set('cod_local', $dados['cod_local']);
                $propostaModel->__set('valor_financiado', $dados['financiado']);
                $propostaModel->__set('valor_liberado', $dados['liberado']);
                $propostaModel->__set('valor_parcela', $dados['parcela']);
                $propostaModel->__set('valor_mensalidade', $dados['mensalidade']);
                $propostaModel->__set('prazo', $dados['prazo']);
                $propostaModel->__set('iof', $dados['iof']);
                $propostaModel->__set('taxa', $dados['taxa']);
                $propostaModel->__set('tipo_proposta', $dados['tipo_proposta']);
                $propostaModel->cadastraProposta();

                $id_proposta = $propostaModel->getlastInsertIdProposta();

                $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
                $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, 'NULL', 'em andamento');


                $_SESSION['msg'] = Alertas::alertaSucesso('Sucesso!', 'Proposta cadastrada com sucesso');
            } catch (\Exception $e) {
                $_SESSION['msg'] = Alertas::alertaErro('Erro!', $e);
            }
        }

        //Arquivos de imagens
        $camposArquivos = [
            'frente',
            'verso',
            'contra_cheque',
            'comprovante_bancario',
            'comprovante_residencia',
            'outros',
            'consulta_receita_federal',
            'averbacao_beneficio',
            'averbacao_mensalidade',

        ];
        $campoPreenchido = false;
        foreach ($camposArquivos as $arquivo) {
            if (!empty($_FILES[$arquivo]['name'] && $_FILES[$arquivo]['size'] > 0 && $_FILES[$arquivo]['error'] == UPLOAD_ERR_OK)) {
                $campoPreenchido = true;
            }
        }
        if ($campoPreenchido) {
            $this->enviarDocumentos($id_proposta, $id_associado);
        }

        header('Location: /inicio');
    }

    //Chamada para mostra os dados da proposta em /proposta-edita?proposta=id
    public function propostaEdita()
    {
        $this->AutenticarUsuario();

        if ($_SERVER['QUERY_STRING'] == '') {
            header('Location: inicio');
        }

        $dados_proposta = Container::getModel('Proposta');
        $orgao = Container::getModel('Orgao');

        $id_proposta = isset($_GET['proposta']) ? $_GET['proposta'] : '';

        $cod_corretor_proposta = $dados_proposta->verificaCodCorretor($id_proposta);

        if ($_SESSION['cod_corretor'] != $cod_corretor_proposta && $_SESSION['nivel'] <= 10) {
            header('Location: /inicio');
        }

        if ($id_proposta != '') {

            $this->analiseProposta($id_proposta);

            $associado = $dados_proposta->__set('id_proposta', $id_proposta);
            $associado = $dados_proposta->pegarDadosProposta();

            $orgao_lista = $orgao->__set('id_proposta', $id_proposta);
            $orgao_lista = $orgao->buscaCodigoOrgaoPeloCodlocalEdite();

            $_SESSION['id_proposta'] = $id_proposta;

            //Pega as imagens do diretorio do associado.
            $documento_frente = "documentos_associado/$id_proposta/documento_frente.";
            $documento_verso = "documentos_associado/$id_proposta/documento_verso.";
            $contra_cheque = "documentos_associado/$id_proposta/contra_cheque.";
            $comprovante_bancario = "documentos_associado/$id_proposta/comprovante_bancario.";
            $comprovante_residencia = "documentos_associado/$id_proposta/comprovante_residencia.";
            $outros = "documentos_associado/$id_proposta/outros.";
            $consulta_receita_federal = "documentos_associado/$id_proposta/consulta_receita_federal.";
            $averbacao_beneficio = "documentos_associado/$id_proposta/averbacao_beneficio.";
            $averbacao_mensalidade = "documentos_associado/$id_proposta/averbacao_mensalidade.";

            // Extensões suportadas
            $formato_suportado = array('jpg', 'jpeg', 'png', 'gif', 'pdf');

            // Verifica o formato de cada arquivo
            foreach ($formato_suportado as $formato_arquivo) {
                //Se o caminho e o formato existe, atribui o caminho e o formato a uma variavel.

                if (is_file($documento_frente . $formato_arquivo)) {
                    $this->view->frente_pdf = $formato_arquivo;
                    $this->view->frente = $documento_frente . $formato_arquivo;
                }
                if (is_file($documento_verso . $formato_arquivo)) {
                    $this->view->verso_pdf = $formato_arquivo;
                    $this->view->verso = $documento_verso . $formato_arquivo;
                }
                if (is_file($contra_cheque . $formato_arquivo)) {
                    $this->view->contra_cheque_pdf =  $formato_arquivo;
                    $this->view->contra_cheque = $contra_cheque . $formato_arquivo;
                }
                if (is_file($comprovante_bancario . $formato_arquivo)) {
                    $this->view->comprovante_bancario_pdf =  $formato_arquivo;
                    $this->view->comprovante_bancario = $comprovante_bancario . $formato_arquivo;
                }
                if (is_file($comprovante_residencia . $formato_arquivo)) {
                    $this->view->comprovante_residencia_pdf =  $formato_arquivo;
                    $this->view->comprovante_residencia = $comprovante_residencia . $formato_arquivo;
                }
                if (is_file($outros . $formato_arquivo)) {
                    $this->view->outros_pdf = $formato_arquivo;
                    $this->view->outros = $outros . $formato_arquivo;
                }
                if (is_file($consulta_receita_federal . $formato_arquivo)) {
                    $this->view->consulta_receita_federal_pdf = $formato_arquivo;
                    $this->view->consulta_receita_federal = $consulta_receita_federal . $formato_arquivo;
                }
                if (is_file($averbacao_beneficio . $formato_arquivo)) {
                    $this->view->averbacao_beneficio_pdf = $formato_arquivo;
                    $this->view->averbacao_beneficio = $averbacao_beneficio . $formato_arquivo;
                }
                if (is_file($averbacao_mensalidade . $formato_arquivo)) {
                    $this->view->averbacao_mensalidade_pdf =  $formato_arquivo;
                    $this->view->averbacao_mensalidade = $averbacao_mensalidade . $formato_arquivo;
                }
            }

            foreach ($associado as $associado) {
                $this->view->cod_corretor = $associado['cod_corretor'];

                $this->view->id_proposta = $associado['id_proposta'];

                $this->view->nome = $associado['nome'];
                $this->view->cpf = $associado['cpf'];
                $this->view->rg = $associado['rg'];
                $this->view->data_nasc = $associado['data_nasc'];
                $this->view->orgao_exp = $associado['orgao_exp'];
                $this->view->email = $associado['email'];
                $this->view->nat = $associado['nat'];
                $this->view->cel = $associado['cel'];
                $this->view->sexo = $associado['sexo'];
                $this->view->cod_local = $associado['cod_local'];

                $this->view->data_proposta = $associado['data_proposta'];
                $this->view->nome_praca = $associado['nome_praca'];

                $this->view->num_proposta = $associado['num_proposta'];
                $this->view->tipo_proposta = $associado['tipo_proposta'];

                $this->view->valor_financiado = $associado['valor_financiado'];
                $this->view->valor_liberado = $associado['valor_liberado'];
                $this->view->valor_parcela = $associado['valor_parcela'];
                $this->view->valor_mensalidade = $associado['valor_mensalidade'];
                $this->view->prazo = $associado['prazo'];
                $this->view->iof = $associado['iof'];
                $this->view->taxa = $associado['taxa'];
                $this->view->tipo_bancario = $associado['tipo_bancario'];

                $this->view->tel = $associado['tel'];
                $this->view->nome_pai = $associado['nome_pai'];
                $this->view->nome_mae = $associado['nome_mae'];
                $this->view->estado_civil = $associado['estado_civil'];
                $this->view->mat =  $associado['mat'];
                $this->view->orgao_nome = $associado['nome_orgao'];
                $this->view->cod_orgao = $associado['cod_orgao'];
                $this->view->setor = $associado['setor'];
                $this->view->cargo = $associado['cargo'];
                $this->view->ocupacao = $associado['ocupacao'];
                $this->view->data_admissao = $associado['data_admissao'];

                $this->view->banco = $associado['banco'];
                $this->view->conta = $associado['conta'];
                $this->view->agencia = $associado['agencia'];
                $this->view->banco_pagamento = $associado['banco_pagamento'];
                $this->view->conta_pagamento = $associado['conta_pagamento'];
                $this->view->agencia_pagamento = $associado['agencia_pagamento'];

                $this->view->cep = $associado['cep'];
                $this->view->uf = $associado['uf'];
                $this->view->municipio = $associado['municipio'];
                $this->view->bairro = $associado['bairro'];
                $this->view->endereco = $associado['endereco'];

                $this->view->pendencia_mensagem = $associado['mensagem'];
                $this->view->pendencia_status = $associado['pendencia_status'];

                $this->view->status_proposta = $associado['status_proposta'];

                $this->view->status_recusado = $associado['status_recusado'];

                $this->view->recusado_motivo = $associado['recusado_motivo'];


                //Desabilita o input
                if (
                    $associado['status_recusado'] == 1
                    || $associado['status_proposta'] == 5
                    && $_SESSION['nivel'] == 10
                ) {
                    $this->view->disabled = 'disabled';
                } else {
                    $this->view->disabled = '';
                };
            }

            $nivel_usuario = $_SESSION['nivel'];
            $this->view->nivel_usuario = $nivel_usuario;

            $this->view->orgao = $orgao_lista;


            if (isset($_SESSION['msg'])) {
                $this->view->alerta = $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        }

        $this->render('proposta_edita');
    }

    //Utilizado para atualizar as propostas.
    public function propostaAtualizar()
    {
        $this->AutenticarUsuario();

        //Realiza o tratamento dos dados e envia para o banco de dados.
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); //Pega os dados dos inputs
        $dados = array_map('trim', $dados); //Remove os espaços em brancos
        $dados = array_map('strtoupper', $dados); //Transforma todas as string em maiusculo
        $dados['email'] = strtolower($dados['email']); //Transforma somente o  email em minusculo

        //Tratamento nos valores para o formado do banco de dados
        $dados['financiado'] = str_replace('.', '', $dados['financiado']); //Substituir o ponto
        $dados['financiado'] = str_replace(',', '.', $dados['financiado']); //Substituir a virgula por pontos

        $dados['liberado'] = str_replace('.', '', $dados['liberado']); //Substituir o ponto
        $dados['liberado'] = str_replace(',', '.', $dados['liberado']); //Substituir a virgula por pontos

        $dados['parcela'] = str_replace('.', '', $dados['parcela']); //Substituir o ponto
        $dados['parcela'] = str_replace(',', '.', $dados['parcela']); //Substituir a virgula por pontos

        $dados['mensalidade'] = str_replace('.', '', $dados['mensalidade']); //Substituir o ponto
        $dados['mensalidade'] = str_replace(',', '.', $dados['mensalidade']); //Substituir a virgula por pontos

        $dados['iof'] = str_replace('.', '', $dados['iof']); //Substituir o ponto
        $dados['iof'] = str_replace(',', '.', $dados['iof']); //Substituir a virgula por pontos

        //tratamento dos caracteres que não sejam números.
        $dados['cel'] = preg_replace('/\D/', '', $dados['cel']);

        $dados['tel'] = preg_replace('/\D/', '', $dados['tel']);

        $dados['tipo_proposta'] = strtolower($dados['tipo_proposta']);

        $id_usuario = $_SESSION['id_usuario'];

        $propostaModel = Container::getModel('Proposta');
        $associadoModel = Container::getModel('Associado');

        //pega o id do Associado ao atualizar
        $id_proposta = isset($_GET['proposta']) ? $_GET['proposta'] : '';
        $associadoModel->__set('id_proposta', $id_proposta);
        $id_associado = $associadoModel->getIdAtualizarAssociado();

        if (isset($dados['cadastra'])) {
            try {
                // Atualiza associado
                $associadoModel->__set('id_associado',  $id_associado);
                $associadoModel->__set('id_usuario',  $id_usuario);
                $associadoModel->__set('cod_local', $dados['cod_local']);
                $associadoModel->__set('nome', $dados['nome']);
                $associadoModel->__set('rg', $dados['rg']);
                $associadoModel->__set('orgao_exp', $dados['orgao_exp']);
                $associadoModel->__set('data_nasc', $dados['data_nasc']);
                $associadoModel->__set('nat', $dados['nat']);
                $associadoModel->__set('sexo', $dados['sexo']);
                $associadoModel->__set('estado_civil', $dados['estado_civil']);
                $associadoModel->__set('tel', $dados['tel']);
                $associadoModel->__set('cel', $dados['cel']);
                $associadoModel->__set('email', $dados['email']);
                $associadoModel->__set('nome_pai', $dados['nome_pai']);
                $associadoModel->__set('nome_mae', $dados['nome_mae']);
                $associadoModel->__set('mat', $dados['mat']);
                $associadoModel->__set('cod_orgao', $dados['cod_orgao']);
                $associadoModel->__set('setor', $dados['setor']);
                $associadoModel->__set('cargo', $dados['cargo']);
                $associadoModel->__set('ocupacao', $dados['ocupacao']);
                $associadoModel->__set('data_admissao', $dados['data_admissao']);
                $associadoModel->__set('cep', $dados['cep']);
                $associadoModel->__set('uf', $dados['uf']);
                $associadoModel->__set('municipio', $dados['municipio']);
                $associadoModel->__set('bairro', $dados['bairro']);
                $associadoModel->__set('endereco', $dados['endereco']);
                $associadoModel->__set('banco', $dados['banco']);
                $associadoModel->__set('conta', $dados['conta']);
                $associadoModel->__set('agencia', $dados['agencia']);
                $associadoModel->__set('banco_pagamento', $dados['banco_pagamento']);
                $associadoModel->__set('conta_pagamento', $dados['conta_pagamento']);
                $associadoModel->__set('agencia_pagamento', $dados['agencia_pagamento']);
                $associadoModel->__set('tipo_bancario', $dados['tipo_bancario']);
                $associadoModel->atualizarAssociadoProposta();

                $propostaModel->__set('id_usuario', $id_usuario);
                // $propostaModel->__set('cod_local', $cod_local); TEM QUE ATUALIZAR ASSOCIADO E PROPOSTA
                $propostaModel->__set('cod_corretor', $dados['cod_corretor']);
                $propostaModel->__set('valor_financiado', $dados['financiado']);
                $propostaModel->__set('valor_liberado', $dados['liberado']);
                $propostaModel->__set('valor_parcela', $dados['parcela']);
                $propostaModel->__set('valor_mensalidade', $dados['mensalidade']);
                $propostaModel->__set('tipo_proposta', $dados['tipo_proposta']);
                $propostaModel->__set('iof', $dados['iof']);
                $propostaModel->__set('taxa', $dados['taxa']);
                $propostaModel->__set('prazo', $dados['prazo']);
                $propostaModel->__set('id_proposta', $id_proposta);
                $propostaModel->atualizaProposta();

                //Arquivos de imagens
                $camposArquivos = [
                    'frente',
                    'verso',
                    'contra_cheque',
                    'comprovante_bancario',
                    'comprovante_residencia',
                    'outros',
                    'consulta_receita_federal',
                    'averbacao_beneficio',
                    'averbacao_mensalidade',

                ];
                $campoPreenchido = false;
                foreach ($camposArquivos as $arquivo) {
                    if (!empty($_FILES[$arquivo]['name'] && $_FILES[$arquivo]['size'] > 0 && $_FILES[$arquivo]['error'] == UPLOAD_ERR_OK)) {
                        $campoPreenchido = true;
                    }
                }
                if ($campoPreenchido) {
                    $this->enviarDocumentos($id_proposta, $id_associado);
                }

                $_SESSION['msg'] = Alertas::alertaSucesso('Sucesso!', "Proposta atualizada com sucesso");
            } catch (\Exception $e) {
                $_SESSION['msg'] = Alertas::alertaErro('Erro!', 'Não foi possivel atualizar a proposta');
            }
        };

        //Verifica se o corretor atualizou uma proposta pendente.
        $status_proposta = $propostaModel->statusProposta($id_proposta);
        if ($status_proposta == 3 && $_SESSION['nivel'] == 10) {

            $propostaModel->mudarStatusProposta('status_proposta', 4, $id_proposta,);

            $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
            $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
            $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'pendencia_resolvida');
        }

        $propostaUrl = $_SERVER['HTTP_REFERER'];
        header("Location: $propostaUrl");
    }
    //Função para enviar as imagens
    public function enviarDocumentos($id_proposta)
    {
        $this->AutenticarUsuario();

        $extensoesPermitidas = array('jpg', 'jpeg', 'png', 'gif', 'pdf');

        //Se o arquivo existe && não ouver erro && o tamanho > 0, chama a função enviarDocumento
        if (isset($_FILES['frente']) && $_FILES['frente']['error'] == 0 && $_FILES['frente']['size'] > 0) {
            $this->salvarDocumento($_FILES['frente'], 'documento_frente', $id_proposta, $extensoesPermitidas);
        }

        if (isset($_FILES['verso']) && $_FILES['verso']['error'] == 0 && $_FILES['verso']['size'] > 0) {
            $this->salvarDocumento($_FILES['verso'], 'documento_verso', $id_proposta, $extensoesPermitidas);
        }

        if (isset($_FILES['contra_cheque']) && $_FILES['contra_cheque']['error'] == UPLOAD_ERR_OK && $_FILES['contra_cheque']['size'] > 0) {
            $this->salvarDocumento($_FILES['contra_cheque'], 'contra_cheque', $id_proposta, $extensoesPermitidas);
        }

        if (isset($_FILES['comprovante_bancario']) && $_FILES['comprovante_bancario']['error'] == UPLOAD_ERR_OK && $_FILES['comprovante_bancario']['size'] > 0) {
            $this->salvarDocumento($_FILES['comprovante_bancario'], 'comprovante_bancario', $id_proposta, $extensoesPermitidas);
        }

        if (isset($_FILES['comprovante_residencia']) && $_FILES['comprovante_residencia']['error'] == UPLOAD_ERR_OK && $_FILES['comprovante_residencia']['size'] > 0) {
            $this->salvarDocumento($_FILES['comprovante_residencia'], 'comprovante_residencia', $id_proposta, $extensoesPermitidas);
        }

        if (isset($_FILES['outros']) && $_FILES['outros']['error'] == UPLOAD_ERR_OK && $_FILES['outros']['size'] > 0) {
            $this->salvarDocumento($_FILES['outros'], 'outros', $id_proposta, $extensoesPermitidas);
        }

        if (isset($_FILES['consulta_receita_federal']) && $_FILES['consulta_receita_federal']['error'] == UPLOAD_ERR_OK && $_FILES['consulta_receita_federal']['size'] > 0) {
            $this->salvarDocumento($_FILES['consulta_receita_federal'], 'consulta_receita_federal', $id_proposta, $extensoesPermitidas);
        }

        if (isset($_FILES['averbacao_beneficio']) && $_FILES['averbacao_beneficio']['error'] == UPLOAD_ERR_OK && $_FILES['averbacao_beneficio']['size'] > 0) {
            $this->salvarDocumento($_FILES['averbacao_beneficio'], 'averbacao_beneficio', $id_proposta, $extensoesPermitidas);
        }

        if (isset($_FILES['averbacao_mensalidade']) && $_FILES['averbacao_mensalidade']['error'] == UPLOAD_ERR_OK && $_FILES['averbacao_mensalidade']['size'] > 0) {
            $this->salvarDocumento($_FILES['averbacao_mensalidade'], 'averbacao_mensalidade', $id_proposta, $extensoesPermitidas);
        }
    }

    //Função para salvar as imagens em uma pasta, e substituir a imagem caso ela já exista.
    public function salvarDocumento($arquivo, $novoNome, $id_proposta, $extensoesPermitidas)
    {
        $this->AutenticarUsuario();

        // Obtém a extensão do arquivo enviado e converte para minúsculas
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        // Define o diretório de destino com base no identificador da proposta
        $diretorio = 'documentos_associado/' . $id_proposta . '/';

        //cria o diretório se ele não existir
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        // Verifica se a extensão do arquivo está na lista de extensões permitidas
        if (in_array($extensao, $extensoesPermitidas)) {
            $novo_nome = $novoNome . '.' . $extensao;
            $arquivo_alvo = $diretorio . $novo_nome;

            // Exclui arquivos existentes com o mesmo nome base, mas extensões diferentes
            foreach ($extensoesPermitidas as $extensaoPermitida) {
                $arquivo_existente = $diretorio . $novoNome . '.' . $extensaoPermitida;

                if (file_exists($arquivo_existente)) {
                    unlink($arquivo_existente);
                }
            }
            // Move o arquivo enviado para o diretório de destino, substituindo qualquer arquivo existente com o mesmo nome
            move_uploaded_file($arquivo['tmp_name'], $arquivo_alvo);
        }
    }

    //TODO falta criar e colocar para funcionar
    public function removerDocumento(int $id_proposta, string $nome_documento) //TODO A FAZER.
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $documento = $nome_documento;
        $arquivo = 'documentos_associado/' . $id_proposta . '/' . $documento;

        if (file_exists($arquivo)) {
            unlink($arquivo);
        }

        echo 'Ola mundo';
    }

    public function juntarImagensPDF()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        try {
            // Parâmetros da requisição
            $id_proposta = $_GET['id_proposta'] ?? null;
            $num_proposta = $_GET['num_proposta'] ?? null;

            if (!$id_proposta || !$num_proposta) {
                throw new Exception("Parâmetros inválidos: id_proposta ou num_proposta ausentes.");
            }

            $diretorio = 'documentos_associado/' . $id_proposta;

            if (!is_dir($diretorio)) {
                throw new Exception("Diretório não encontrado: $diretorio");
            }

            // Inicializa o FPDI
            $pdf = new Fpdi();

            // Obtém todos os arquivos (PDF e imagens) no diretório
            $files = array_merge(
                glob("$diretorio/*.pdf"),
                glob("$diretorio/*.jpg"),
                glob("$diretorio/*.jpeg"),
                glob("$diretorio/*.png")
            );

            if (empty($files)) {
                throw new Exception("Nenhum arquivo PDF ou imagem encontrado no diretório: $diretorio");
            }

            // Itera pelos arquivos e adiciona ao PDF
            foreach ($files as $filePath) {
                $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                    // Trata arquivos de imagem
                    if ($imageInfo = getimagesize($filePath)) {
                        list($width, $height) = $imageInfo;

                        // Orientação da página (Paisagem ou Retrato)
                        $orientation = ($width > $height) ? 'L' : 'P';
                        $pdf->AddPage($orientation);

                        // Define as dimensões ajustadas
                        $maxWidth = $orientation === 'L' ? 270 : 190;
                        $pdf->Image($filePath, 10, 10, $maxWidth);
                    } else {
                        echo "Imagem inválida ou corrompida ignorada: $filePath\n";
                    }
                } elseif ($fileExtension === 'pdf') {
                    // Trata arquivos PDF
                    try {
                        $pageCount = $pdf->setSourceFile($filePath);
                        for ($i = 1; $i <= $pageCount; $i++) {
                            $templateId = $pdf->importPage($i);
                            $pdf->AddPage();
                            $pdf->useTemplate($templateId);
                        }
                    } catch (Exception $e) {
                        echo "Erro ao processar PDF: $filePath - " . $e->getMessage() . "\n";
                    }
                } else {
                    // Ignora formatos desconhecidos
                    echo "Arquivo com extensão não suportada ignorado: $filePath\n";
                }
            }

            // Gera o PDF final para download
            $arquivoFinal = "$num_proposta.pdf";
            $pdf->Output('D', $arquivoFinal);
        } catch (Exception $e) {
            // Log de erro
            // echo "Erro: " . $e->getMessage();
        }

        // Redireciona para a página de origem
        $pagina_referencia = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: $pagina_referencia");
        exit;
    }

    public function statusProposta(int $id_proposta)
    {
        $this->AutenticarUsuario();
        $propostaModel = Container::getModel('Proposta');
        $status_proposta = $propostaModel->statusProposta($id_proposta);
        return $status_proposta;
    }

    //Ao clicar para ver a proposta, muda o status para analisando.
    public function analiseProposta($id_proposta)
    {
        $this->AutenticarUsuario();
        $propostaModel = Container::getModel('Proposta');
        $id_usuario = $_SESSION['id_usuario'];

        $verifica_status = $this->statusProposta($id_proposta);

        //Verifica se o status da proposta é 1
        //Se for altera o status para 2 (analisando);
        if ($_SESSION['nivel'] > 10) {
            if (
                isset($verifica_status)
                && $verifica_status == 1
            ) {
                //Adicionar status conferencia
                $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
                $this->id_conferente = $id_usuario;
                $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $this->id_conferente, 'em analise');

                $propostaModel->mudarStatusProposta('status_proposta', 2, $id_proposta,);
            }
        }
    }

    public function conferirProposta()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();

        $id_proposta = $_GET['id_proposta'];
        $id_usuario = $_SESSION['id_usuario'];

        $propostaModel = Container::getModel('Proposta');
        $propostaModel->mudarStatusProposta('status_proposta', 5, $id_proposta,); //status proposta = conferido
        $propostaModel->mudarStatusProposta('status_assinatura', 1, $id_proposta,); //enviado para /clicksign

        $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
        $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
        $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'conferido');

        //deleta a pendencia
        $pendenciaModel = Container::getModel('Pendencia');
        $pendenciaModel->pendenciaDeleta($id_proposta);

        $_SESSION['msg'] = Alertas::alertaSucesso('Conferido!', 'Proposta conferida com sucesso');
        $volta = $_SERVER['HTTP_REFERER'];
        header("Location: $volta");
    }

    public function propostaAssinada()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        $id_proposta = $_GET['id_proposta'];
        $id_usuario = $_SESSION['id_usuario'];

        $propostaModel = Container::getModel('Proposta');
        $propostaModel->mudarStatusProposta('status_proposta', 7, $id_proposta,); //status proposta = assinada

        $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
        $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
        $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'assinado');

        echo json_encode(['propostaAssinada' => true]);
    }

    public function recusarProposta()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        $propostaModel = Container::getModel('Proposta');

        $id_usuario = $_SESSION['id_usuario'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id_proposta = $_POST['id_proposta'];
            $recusado_motivo = trim($_POST['motivo']);

            if ($recusado_motivo != '' && $id_proposta != '') {
                $propostaModel->__set('id_proposta', $id_proposta);
                $propostaModel->__set('recusado_motivo', $recusado_motivo);

                $propostaModel->recusarProposta();

                $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');

                $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
                $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'recusado');

                $_SESSION['msg'] = Alertas::alertaSucesso('Sucesso!', 'Proposta recusada com sucesso');
                header('Location: /acompanhamento');
            } else {
                $_SESSION['msg'] = Alertas::alertaErro('Erro!', 'Informe o motivo para recusar a proposta');
                header('Location: /acompanhamento');
            }
        }
    }

    public function reativarProposta()
    {
        $this->AutenticarUsuario();
        AuthController::validacaoAutenticacaoFuncionario();
        $proposta = Container::getModel('Proposta');

        $id_proposta = $_GET['id_proposta'];
        $id_usuario = $_SESSION['id_usuario'];

        $propostaConferenciaModel = Container::getModel('PropostaStatusConferencia');
        $id_conferente = $propostaConferenciaModel->idConferente($id_proposta);
        $propostaConferenciaModel->statusConferenciaAdicionar($id_proposta, $id_usuario, $id_conferente, 'reativado');

        $proposta->mudarStatusProposta('status_recusado', 0, $id_proposta,);

        echo json_encode(['reativado' => true]);
    }
}
