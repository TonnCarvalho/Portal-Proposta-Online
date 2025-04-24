<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Cadastra Proposta</h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <?php if (!isset($_POST['cadastro'])) : ?>
                <div class="card card-primary">

                    <form action="/proposta-cadastro" method="post" id="pracaCPFCadastro" name="busca_cpf" onsubmit="return validaCPF()">
                        <div class="card-body row justify-content-center">
                            <div class="form-group col-sm-12 col-md-6">

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">PRAÇA</span>
                                    </div>
                                    <select name="pracaCadastro" id="pracaCadastro" class="form-control text-uppercase select2CpfCadastro">
                                        <option value=""></option>
                                        <?php foreach ($this->view->pracas as $praca) : ?>
                                            <option value="<?= $praca['cod_local'] ?>">
                                                <?= $praca['nome'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">CPF</span>
                                    </div>
                                    <input type="text" id="cpfCadastro" class="form-control text-uppercase" name="cpfCadastro" placeholder="000.000.000-00">
                                </div>

                                <div class="alert alert-danger text-center d-none" id="msgErroCPF" role="alert">
                                    CPF invalido!
                                </div>

                                <div class="">
                                    <button type="submit" class="btn btn-primary btn-block mb-3" name="cadastro">
                                        AVANÇAR
                                    </button>

                                    <a href="/inicio">
                                        <button type="button" class="btn btn-outline-secondary btn-block">
                                            VOLTA
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            <?php else : ?>
                <form action="/proposta-cadastrar" method="post" class="row" id="propostaCadastro" enctype="multipart/form-data" onsubmit="return validarPrazo()">

                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                DOCUMENTOS
                            </div>

                            <div class="card-body row">

                                <div class="form-group col-12 col-md-6">
                                    <label for="frente">
                                        FRENTE DO DOCUMENTO
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="frente" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                        <label class="custom-file-label" for="frente"></label>
                                    </div>
                                </div>

                                <div class="form-group  col-12 col-md-6">
                                    <label for="nome">
                                        VERSO DO DOCUMENTO
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="verso" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                        <label class="custom-file-label" for="customFile"></label>
                                    </div>
                                </div>

                                <div class="form-group  col-12 col-md-6">
                                    <label for="nome">
                                        CONTRA-CHEQUE
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="contra_cheque" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                        <label class="custom-file-label" for="customFile"></label>
                                    </div>
                                </div>

                                <div class="form-group  col-12 col-md-6">
                                    <label for="nome">
                                        COMPROVANTE BANCARIO
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="comprovante_bancario" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                        <label class="custom-file-label" for="customFile"></label>
                                    </div>
                                </div>

                                <div class="form-group  col-12 col-md-6">
                                    <label for="nome">
                                        COMPROVANTE DE RESIDÊNCIA
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="comprovante_residencia" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                        <label class="custom-file-label" for="customFile"></label>
                                    </div>
                                </div>

                                <div class="form-group  col-12 col-md-6">
                                    <label for="nome">
                                        OUTROS DOCUMENTOS
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="outros" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                        <label class="custom-file-label" for="customFile"></label>
                                    </div>
                                </div>

                                <?php if ($_SESSION['nivel'] > 10): ?>

                                    <div class="form-group  col-12 col-md-6">
                                        <label for="nome">
                                            CONSULTA RECEITA FEDERAL
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="consulta_receita_federal" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                            <label class="custom-file-label" for="customFile"></label>
                                        </div>
                                    </div>

                                    <div class="form-group  col-12 col-md-6">
                                        <label for="nome">
                                            AVERBAÇÃO DE BENEFÍCIO
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="averbacao_beneficio" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                            <label class="custom-file-label" for="customFile"></label>
                                        </div>
                                    </div>

                                    <div class="form-group  col-12 col-md-6">
                                        <label for="nome">
                                            AVERBAÇÃO DE MENSALIDADE
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="averbacao_mensalidade" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                            <label class="custom-file-label" for="customFile"></label>
                                        </div>
                                    </div>
                                <?php endif ?>

                            </div>
                        </div>
                    </div>

                    <!-- ESQUERDA -->
                    <div class="col-md-6">
                        <div class="">
                            <div class="card card-primary">
                                <div class="card-header">
                                    DADOS DO ASSOCIADO
                                </div>

                                <div class="card-body row">

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="nome">
                                            NOME COMPLETO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="nome" name="nome" placeholder="Nome completo" value="<?= $this->view->nome ?>" required>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="cpf">
                                            CPF
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase ignore" id="cpf" name="cpf" placeholder="CPF" value="<?= $_POST['cpfCadastro'] ?>" readonly>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="rg">
                                            RG
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="rg" name="rg" value="<?= $this->view->rg ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="orgao_exp">
                                            ÓRGÃO EXPEDIDOR
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="orgao_exp" name="orgao_exp" value="<?= $this->view->orgao_exp ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="email">
                                            EMAIL
                                            <span class="text-danger"> *</span>
                                            <small>do associado</small>
                                        </label>
                                        <input type="email" class="form-control text-uppercase" id="email" name="email" value="<?= $this->view->email ?>">
                                        <small id="emailHelp" class="form-text text-danger">
                                            Envio de assinatura por e-mail
                                        </small>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="data_nasc">
                                            DATA DE NASCIMENTO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="date" class="form-control text-uppercase" id="data_nasc" name="data_nasc" value="<?= $this->view->data_nasc ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="nat">
                                            NATURALIDADE
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="nat" name="nat" value="<?= $this->view->nat ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="sexo">
                                            SEXO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <select class="custom-select" id="sexo" name="sexo">
                                            <?php if ($this->view->sexo == '') : ?>
                                                <option value="" selected disabled>SELECIONE</option>
                                                <option value="M">MASCULINO</option>
                                                <option value="F">FEMININO</option>
                                            <?php elseif ($this->view->sexo == 'M') : ?>
                                                <option value="M" selected>MASCULINO</option>
                                                <option value="F">FEMININO</option>
                                            <?php else : ?>
                                                <option value="F" selected>FEMININO</option>
                                                <option value="M">MASCULINO</option>
                                            <?php endif ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="cel">
                                            CELULAR (WhatsApp)
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="cel" name="cel" value="<?= $this->view->cel ?>">
                                        <small id="celHelp" class="form-text text-danger">
                                            Envio de assinatura por WhatsApp
                                        </small>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="tel">
                                            TELEFONE FIXO
                                        </label>
                                        <input type="text" class="form-control text-uppercase ignore" id="tel" name="tel" value="<?= $this->view->tel ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="nome_pai">
                                            NOME DO PAI
                                        </label>
                                        <input type="text" class="form-control text-uppercase ignore" id="nome_pai" name="nome_pai" value="<?= $this->view->nome_pai ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="nome_mae">
                                            NOME DA MÃE
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="nome_mae" name="nome_mae" value="<?= $this->view->nome_mae ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="estado_civil">
                                            ESTADO CIVIL
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <select class="custom-select" id="estado_civil" name="estado_civil">
                                            <option value="" disabled selected>SELECIONE</option>
                                            <option value="solteiro" <?= $this->view->estado_civil == 'SOLTEIRO' ? 'selected' : '' ?>>
                                                SOLTEIRO (A)
                                            </option>
                                            <option value="casado" <?= $this->view->estado_civil == 'CASADO' ? 'selected' : '' ?>>
                                                CASADO (A)
                                            </option>
                                            <option value="divorciado" <?= $this->view->estado_civil == 'DIVORCIADO' ? 'selected' : '' ?>>
                                                DIVORCIADO (A)
                                            </option>
                                            <option value="viuvo" <?= $this->view->estado_civil == 'VIUVO' ? 'selected' : '' ?>>
                                                VIÚVO (A)
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="mat">
                                            MATRÍCULA
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="mat" name="mat" value="<?= $this->view->mat ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="orgao">
                                            ÓRGÃO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <select class="custom-select" id="cod_orgao" name="cod_orgao">

                                            <?php if (empty($this->view->orgao_nome)): ?>
                                                <option value="" selected disabled>SELECIONE O ÓRGÃO</option>
                                            <?php else : ?>
                                                <option value="<?= $this->view->cod_orgao ?>">
                                                    <?= $this->view->orgao_nome ?>
                                                </option>
                                            <?php endif ?>

                                            <?php foreach ($this->view->orgao as $orgao) : ?>
                                                <option value="<?= $orgao['cod_orgao'] ?>">
                                                    <?= $orgao['nome'] ?>
                                                </option>
                                            <?php endforeach ?>

                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="setor">
                                            SETOR
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="setor" name="setor" value="<?= $this->view->setor ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="cargo">
                                            CARGO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="cargo" name="cargo" value="<?= $this->view->cargo ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="ocupacao">
                                            OCUPAÇÃO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <select class="custom-select" id="ocupacao" name="ocupacao">
                                            <option value="" selected disabled>SELECIONE</option>
                                            <option value="ativo"
                                                <?= $this->view->ocupacao == 'ATIVO' ?  'selected' : '' ?>>
                                                ATIVO(A)
                                            </option>
                                            <option value="aposentado"
                                                <?= $this->view->ocupacao == 'APOSENTADO' ? 'selected' : '' ?>>
                                                APOSENTADO(A)
                                            </option>
                                            <option value="pensionista"
                                                <?= $this->view->ocupacao == 'PENSIONISTA' ? 'selected' : '' ?>>
                                                PENSIONISTA
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="data_admissao">
                                            DATA ADMISSÃO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="date" class="form-control text-uppercase" id="data_admissao" name="data_admissao" value="<?= $this->view->data_admissao ?>">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="card card-primary">
                                <div class="card-header">
                                    ENDEREÇO
                                </div>
                                <div class="card-body row">
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="cep">
                                            CEP
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="cep" name="cep" value="<?= $this->view->cep ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="uf">
                                            ESTADO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="uf" name="uf" value="<?= $this->view->uf ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="municipio">
                                            CIDADE OU MUNÍCIPIO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="municipio" name="municipio" value="<?= $this->view->municipio ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="bairro">
                                            BAIRRO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="bairro" name="bairro" value="<?= $this->view->bairro ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="endereco">
                                            ENDEREÇO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="endereco" name="endereco" value="<?= $this->view->endereco ?>">
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- / ESQUERDA -->
                    <!-- DIREITA -->
                    <div class="col-md-6">
                        <div class="">
                            <div class="card card-primary" style="margin-bottom: 32px;">
                                <div class="card-header ">
                                    DADOS FINANCEIRO
                                </div>

                                <div class="card-body row">

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="codCorretor">
                                            CÓDIGO DO CORRETOR
                                            <span class="text-danger"> *</span>
                                        </label>

                                        <?php if ($_SESSION['nivel'] <= 10) : ?>
                                            <input type="text" class="form-control text-uppercase" id="codCorretor" name="cod_corretor" placeholder="Código" value="<?= $_SESSION['cod_corretor'] ?>" readonly>
                                        <?php else : ?>
                                            <input type="text" class="form-control text-uppercase" id="codCorretor" name="cod_corretor" placeholder="Código" value="">
                                        <?php endif ?>

                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="praca">
                                            PRAÇA
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <?php foreach ($this->view->pracas as $praca) : ?>
                                            <input type="text" class="form-control text-uppercase ignore" id="praca" name="praca" value="<?= $praca['nome'] ?>" readonly>
                                            <input type="hidden" class="form-control text-uppercase ignore" id="cod_local" name="cod_local" value="<?= $praca['cod_local'] ?>" readonly>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="financiado">
                                            VALOR FINANCIADO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">R$</span>
                                            </div>
                                            <input type="text" class="form-control text-uppercase" id="financiado" name="financiado" value="" placeholder="0,00">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="liberado">
                                            VALOR LIBERADO
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text ignore" id="basic-addon1">R$</span>
                                            </div>
                                            <input type="text" class="form-control text-uppercase" id="liberado" name="liberado" value="" placeholder="0,00">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="parcela">
                                            VALOR DA PARCELA
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text ignore" id="basic-addon1">R$</span>
                                            </div>
                                            <input type="text" class="form-control text-uppercase" id="parcela" name="parcela" value="" placeholder="0,00">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="mensalidade">
                                            VALOR DA MENSALIDADE
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">R$</span>
                                            </div>
                                            <input type="text" class="form-control text-uppercase ignore" id="mensalidade" name="mensalidade" value="" placeholder="0,00">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="prazo">
                                            PRAZO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control text-uppercase" id="prazo" name="prazo" value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="prazo">Meses</span>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($_SESSION['nivel'] > 10): ?>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label for="tipo_proposta">
                                                TIPO DA PROPOSTA
                                            </label>
                                            <select class="custom-select" id="tipo_proposta" name="tipo_proposta">
                                                <option value="" selected disabled>SELECIONE</option>
                                                <option value="novo_com_margem">NOVO COM MARGEM</option>
                                                <option value="refin_com_margem">REFIN COM MARGEM</option>
                                                <option value="novo_mensalidade">NOVO MENSALIDADE</option>
                                                <option value="refin_mensalidade">REFIN MENSALIDADE</option>
                                                <option value="2_linha">2º LINHA</option>
                                                <option value="refin_2_linha">REFIN 2º LINHA</option>
                                                <option value="reenquadramento">REENQUADRAMENTO</option>
                                                <option value="refinanciamento">REFINANCIAMENTO</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label for="iof">
                                                IOF
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                </div>
                                                <input type="text" class="form-control text-uppercase ignore" id="iof" name="iof" value="<?= $this->view->iof ?>" <?= $this->view->disabled ?>>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label for="iof">
                                                TAXA
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control text-uppercase" id="taxa" name="taxa" value="" <?= $this->view->disabled ?>>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="card card-primary">
                                <div class="card-header">
                                    DADOS BANCÁRIOS DO CONTRA-CHEQUE
                                </div>

                                <div class="card-body row" style="margin-bottom: 240px;">

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="banco">
                                            BANCO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" list="bancos" class="form-control text-uppercase" id="banco" name="banco" value="<?= $this->view->banco ?>">
                                        <datalist id="bancos">
                                            <option value="001">Banco do Brasil</option>
                                            <option value="003">Santander</option>
                                            <option value="104">Caixa Econômica Federal</option>
                                            <option value="237">Banco Bradesco</option>
                                            <option value="341">Itaú Unibanco</option>
                                        </datalist>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="agencia">
                                            AGÊNCIA
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="agencia" name="agencia" value="<?= $this->view->agencia ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="conta">
                                            CONTA
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="conta" name="conta" value="<?= $this->view->conta ?>">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="card card-primary">
                                <div class="card-header">
                                    DADOS BANCÁRIOS PARA RECEBIMENTO
                                </div>

                                <div class="card-body row" style="margin-bottom: 102px;">
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="banco_pagamento">
                                            BANCO
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" list="bancos" class="form-control text-uppercase" id="banco_pagamento" name="banco_pagamento" value="<?= $this->view->banco_pagamento ?>">
                                        <datalist id="bancos">
                                            <option value="001">Banco do Brasil</option>
                                            <option value="003">Santander</option>
                                            <option value="104">Caixa Econômica Federal</option>
                                            <option value="237">Banco Bradesco</option>
                                            <option value="341">Itaú Unibanco</option>
                                        </datalist>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="agencia_pagamento">
                                            AGÊNCIA
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="agencia_pagamento" name="agencia_pagamento" value="<?= $this->view->agencia_pagamento ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="conta_pagamento">
                                            CONTA
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control text-uppercase" id="conta_pagamento" name="conta_pagamento" value="<?= $this->view->conta_pagamento ?>">
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="tipo_bancario">
                                            TIPO DA CONTA
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <select class="custom-select" id="tipo_bancario" name="tipo_bancario">
                                            <option value="" disabled selected>SELECIONE</option>
                                            <option value="C">CORRENTE</option>
                                            <option value="P">POUPANÇA</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /DIREITA -->
                    <div class="col-12">
                        <div class="card-footer clearfix">
                            <button type="submit" name="cadastra" class="btn btn-primary float-left mr-3 px-5">
                                CRIAR PROPOSTA
                            </button>

                            <a href="/inicio" class="btn btn-outline-primary float-left">
                                VOLTA
                            </a>

                        </div>
                    </div>
                </form>

            <?php endif ?>
        </div>
    </div>

</div>
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/jquery-mask/jquery.mask.min.js"></script>
<script src="/plugins/price-format/jquery.priceformat.min.js"></script>
<script src="/plugins/jquery-validation/jquery.validate.js"></script>
<script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="/api/viaCep.js"></script>
<script src="/js/proposta/cadastro_proposta/validaCPF.js"></script>
<script src="/js/proposta/cadastro_proposta/validarForm.js"></script>
<script src="/js/proposta/cadastro_proposta/mascaraInput.js"></script>
<script src="/js/proposta/cadastro_proposta/validarPrazo.js"></script>