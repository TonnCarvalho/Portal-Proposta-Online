<?php include(__DIR__ . '/modal/criar_pendencia.php') ?>
<?php include(__DIR__ . '/modal/editar_pendencia.php') ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h3 class="text-uppercase">
                <?= $this->view->num_proposta ?> - <?= $this->view->nome ?>
            </h3>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php if ($this->view->recusado_motivo != '' && $this->view->status_recusado == 1): ?>

                        <div class="card card-danger">
                            <div class="card-header">
                                RECUSADO
                            </div>
                            <div class="card-body">
                                <?= $this->view->recusado_motivo ?>
                            </div>
                        </div>

                    <?php endif ?>

                    <?= $this->view->alerta ?>
                </div>

                <div class="ml-2 mb-2">
                    <?php if ($this->view->status_proposta <= 2 && $this->view->status_recusado != 1 && $_SESSION['nivel'] > 10): ?>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#criarPendenciaModal">
                            <i class="fa-solid fa-plus"></i>
                            CRIAR PENDENCIA
                        </button>

                    <?php endif ?>

                    <?php if ($this->view->status_proposta == 3 || $this->view->status_proposta == 4 && $_SESSION['nivel'] > 10): ?>
                        <div class="ml-2 mb-2">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editarPendenciaModal">
                                <i class="fa-solid fa-pen"></i>
                                EDITAR PENDENCIA
                            </button>
                        </div>
                    <?php endif ?>

                    <?php if ($_SESSION['nivel'] > 10 && $this->view->status_proposta < 5 && $this->status_recusado == 0 && $this->view->iof && $this->view->taxa): ?>
                        <button type="button"
                            name="conferido"
                            id="conferido"
                            class="btn btn-success px-5"
                            onclick="conferirProposta(<?= $this->view->id_proposta ?>)">
                            CONFERIR
                        </button>
                    <?php elseif ($this->view->status_proposta >= 5): ?>
                        <button type="button"
                            id="conferido"
                            class="btn btn-success px-5 disabled">
                            <i class="fa-solid fa-check"></i>
                            CONFERIDO
                        </button>
                    <?php endif ?>
                </div>
                <?php if ($this->view->status_proposta == 3 || $this->view->status_proposta == 4): ?>
                    <section class="col-12">
                        <div class="card card-danger">
                            <div class="card-header">
                                PENDENCIA
                            </div>
                            <div class="card-body">
                                <?= $this->view->pendencia_mensagem ?>
                            </div>
                        </div>
                    </section>
                <?php endif ?>



                <section class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            IMAGENS DOS DOCUMENTOS
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <?php if (!empty($this->view->frente)) : ?>
                                    <?php if ($this->view->frente_pdf == 'pdf'): ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->frente ?>" target="_blank">
                                                <img src="img/pdf.png" alt="<?= $this->view->frente ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p class="ml-2">Frente</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="/remove_documento?id_proposta=<?= $this->view->id_proposta ?>&arquivo=documento_frente" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->frente ?>" target="_blank">
                                                <img src="<?= $this->view->frente ?>" alt="<?= $this->view->frente ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p>Frente</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="<?= $this->view->frente ?>" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>

                                <?php if (!empty($this->view->verso)) : ?>
                                    <?php if ($this->view->verso_pdf == 'pdf'): ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->verso ?>" target="_blank">
                                                <img src="img/pdf.png" alt="<?= $this->view->verso ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p class="ml-2">Verso</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="#" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->verso ?>" target="_blank">
                                                <img src="<?= $this->view->verso ?>" alt="<?= $this->view->frente ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p>Verso</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="#" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>

                                <?php if (!empty($this->view->contra_cheque)) : ?>
                                    <?php if ($this->view->contra_cheque_pdf == 'pdf'): ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->contra_cheque ?>" target="_blank">
                                                <img src="img/pdf.png" alt="<?= $this->view->contra_cheque ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p class="ml-2">Contra Cheque</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="#" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->contra_cheque ?>" target="_blank">
                                                <img src="<?= $this->view->contra_cheque ?>" alt="<?= $this->view->contra_cheque ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p>Contra Cheque</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="#" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>

                                <?php if (!empty($this->view->comprovante_bancario)) : ?>
                                    <?php if ($this->view->comprovante_bancario_pdf == 'pdf'): ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->comprovante_bancario ?>" target="_blank">
                                                <img src="img/pdf.png" alt="<?= $this->view->comprovante_bancario ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p class="ml-2">Comprovante Bancario</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="#" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->comprovante_bancario ?>" target="_blank">
                                                <img src="<?= $this->view->comprovante_bancario ?>" alt="<?= $this->view->comprovante_bancario ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p>Comprovante Bancario</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="#" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>

                                <?php if (!empty($this->view->comprovante_residencia)) : ?>
                                    <?php if ($this->view->comprovante_residencia_pdf == 'pdf'): ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->comprovante_residencia ?>" target="_blank">
                                                <img src="img/pdf.png" alt="<?= $this->view->comprovante_residencia ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p class="ml-2">Comprovante Residencia</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="#" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->comprovante_residencia ?>" target="_blank">
                                                <img src="<?= $this->view->comprovante_residencia ?>" alt="<?= $this->view->comprovante_residencia ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p>Comprovante Residencia</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="#" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>

                                <?php if (!empty($this->view->outros)) : ?>
                                    <?php if ($this->view->outros_pdf == 'pdf'): ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->outros ?>" target="_blank">
                                                <img src="img/pdf.png" alt="<?= $this->view->outros ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p class="ml-2">Outros</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="#" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-12 col-md-2 text-center">
                                            <a href="<?= $this->view->outros ?>" target="_blank">
                                                <img src="<?= $this->view->outros ?>" alt="<?= $this->view->outros ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                            </a>
                                            <p>Outros</p>
                                            <?php if ($this->view->nivel_usuario == 100) : ?>
                                                <a href="#" class="text-danger">
                                                    Remover
                                                </a>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>

                                <?php if ($_SESSION['nivel'] > 10): ?>
                                    <?php if (!empty($this->view->consulta_receita_federal)) : ?>
                                        <?php if ($this->view->consulta_receita_federal_pdf == 'pdf'): ?>
                                            <div class="col-sm-12 col-md-2 text-center">
                                                <a href="<?= $this->view->consulta_receita_federal ?>" target="_blank">
                                                    <img src="img/pdf.png" alt="<?= $this->view->consulta_receita_federal ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                                </a>
                                                <p class="ml-2">Consulta Receita Federal</p>
                                                <?php if ($this->view->nivel_usuario == 100) : ?>
                                                    <a href="#" class="text-danger">
                                                        Remover
                                                    </a>
                                                <?php endif ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-sm-12 col-md-2 text-center">
                                                <a href="<?= $this->view->consulta_receita_federal ?>" target="_blank">
                                                    <img src="<?= $this->view->consulta_receita_federal ?>" alt="<?= $this->view->consulta_receita_federal ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                                </a>
                                                <p>Consulta Receita Federal</p>
                                                <?php if ($this->view->nivel_usuario == 100) : ?>
                                                    <a href="#" class="text-danger">
                                                        Remover
                                                    </a>
                                                <?php endif ?>
                                            </div>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <?php if (!empty($this->view->averbacao_beneficio)) : ?>
                                        <?php if ($this->view->averbacao_beneficio_pdf == 'pdf'): ?>
                                            <div class="col-sm-12 col-md-2 text-center">
                                                <a href="<?= $this->view->averbacao_beneficio ?>" target="_blank">
                                                    <img src="img/pdf.png" alt="<?= $this->view->averbacao_beneficio ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                                </a>
                                                <p class="ml-2">Averbacao Beneficio</p>
                                                <?php if ($this->view->nivel_usuario == 100) : ?>
                                                    <a href="#" class="text-danger">
                                                        Remover
                                                    </a>
                                                <?php endif ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-sm-12 col-md-2 text-center">
                                                <a href="<?= $this->view->averbacao_beneficio ?>" target="_blank">
                                                    <img src="<?= $this->view->averbacao_beneficio ?>" alt="<?= $this->view->averbacao_beneficio ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                                </a>
                                                <p>Averbacao Beneficio</p>
                                                <?php if ($this->view->nivel_usuario == 100) : ?>
                                                    <a href="#" class="text-danger">
                                                        Remover
                                                    </a>
                                                <?php endif ?>
                                            </div>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <?php if (!empty($this->view->averbacao_mensalidade)) : ?>
                                        <?php if ($this->view->averbacao_mensalidade_pdf == 'pdf'): ?>
                                            <div class="col-sm-12 col-md-2 text-center">
                                                <a href="<?= $this->view->averbacao_mensalidade ?>" target="_blank">
                                                    <img src="img/pdf.png" alt="<?= $this->view->averbacao_mensalidade ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                                </a>
                                                <p class="ml-2">Averbacao Mensalidade</p>
                                                <?php if ($this->view->nivel_usuario == 100) : ?>
                                                    <a href="#" class="text-danger">
                                                        Remover
                                                    </a>
                                                <?php endif ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-sm-12 col-md-2 text-center">
                                                <a href="<?= $this->view->averbacao_mensalidade ?>" target="_blank">
                                                    <img src="<?= $this->view->averbacao_mensalidade ?>" alt="<?= $this->view->averbacao_mensalidade ?>" style="height: 100px; width: 100px; object-fit:contain;">
                                                </a>
                                                <p>Averbacao Mensalidade</p>
                                                <?php if ($this->view->nivel_usuario == 100) : ?>
                                                    <a href="#" class="text-danger">
                                                        Remover
                                                    </a>
                                                <?php endif ?>
                                            </div>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>

                            <?php if ($_SESSION['nivel'] > 10): ?>
                                <div class="mt-3">
                                    <button class="btn btn-flat btn-secondary px-5"
                                        onclick="juntarEmPDF(<?= $this->view->id_proposta ?>,<?= $this->view->num_proposta ?>)">
                                        <i class="fa-regular fa-file-pdf"></i>
                                        GERAR IMAGENS EM PDF
                                    </button>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </section>
            </div>
            <form action="/proposta-atualizar?proposta=<?= $this->view->id_proposta ?>" method="POST" id="propostaEdita" enctype="multipart/form-data" onsubmit="return validarPrazo()">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                DOCUMENTOS
                            </div>
                            <div class="card-body row">
                                <?php //TODO colocar e melhorar o bloqueios dos inputs de imagens.
                                ?>
                                <div class="form-group col-12 col-md-6">
                                    <label for="frente">
                                        FRENTE DO DOCUMENTO
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="frente" name="frente" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                        <label class="custom-file-label" for="frente">

                                        </label>
                                    </div>
                                </div>
                                <div class="form-group  col-12 col-md-6">
                                    <label for="nome">
                                        VERSO DO DOCUMENTO
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="verso" name="verso" accept=".jpg, .jpeg, .png, .gif, .pdf">
                                        <label class="custom-file-label" for="verso"></label>
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
                        <div class="card card-primary">
                            <div class="card-header">
                                DADOS DO ASSOCIADO
                            </div>

                            <div class="card-body form-group row">

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="nome">
                                        NOME COMPLETO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="nome" name="nome" placeholder="Nome completo" value="<?= $this->view->nome ?>" <?= $this->view->disabled ?> required>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="cpf">
                                        CPF
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase ignore" id="cpf" name="cpf" placeholder="CPF" value="<?= $this->view->cpf ?>" readonly <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="rg">
                                        RG
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="rg" name="rg" value="<?= $this->view->rg ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="orgao_exp">
                                        ÓRGÃO EXPEDIDOR
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="orgao_exp" name="orgao_exp" value="<?= $this->view->orgao_exp ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="email">
                                        EMAIL
                                        <span class="text-danger"> *</span>
                                        <small>do associado</small>
                                    </label>
                                    <input type="email" class="form-control text-uppercase" id="email" name="email" value="<?= $this->view->email ?>" <?= $this->view->disabled ?>>
                                    <small id="emailHelp" class="form-text text-danger">
                                        Envio de assinatura por e-mail
                                    </small>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="data_nasc">
                                        DATA DE NASCIMENTO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="date" class="form-control text-uppercase" id="data_nasc" name="data_nasc" value="<?= $this->view->data_nasc ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="nat">
                                        NATURALIDADE
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="nat" name="nat" value="<?= $this->view->nat ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="sexo">
                                        SEXO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <select class="custom-select" id="sexo" name="sexo" <?= $this->view->disabled ?>>
                                        <option
                                            <?= $this->view->sexo == 'M' ? 'selected' : '' ?>
                                            value="M">MASCULINO</option>
                                        <option
                                            <?= $this->view->sexo == 'F' ? 'selected' : '' ?>
                                            value="F">FEMININO</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="cel">
                                        CELULAR (WhatsApp)
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="cel" name="cel" value="<?= $this->view->cel ?>" <?= $this->view->disabled ?>>
                                    <small id="celHelp" class="form-text text-danger">
                                        Envio de assinatura por WhatsApp
                                    </small>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="tel">
                                        TELEFONE FIXO
                                    </label>
                                    <input type="text" class="form-control text-uppercase ignore" id="tel" name="tel" value="<?= $this->view->tel ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="nome_pai">
                                        NOME DO PAI
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="nome_pai" name="nome_pai" value="<?= $this->view->nome_pai ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="nome_mae">
                                        NOME DA MÃE
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="nome_mae" name="nome_mae" value="<?= $this->view->nome_mae ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="estado_civil">
                                        ESTADO CIVIL
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <select class="custom-select" id="estado_civil" name="estado_civil" <?= $this->view->disabled ?>>
                                        <option selected disabled>ESTADO CIVIL</option>
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
                                    <input type="text" class="form-control text-uppercase" id="mat" name="mat" value="<?= $this->view->mat ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="cod_orgao">
                                        ÓRGÃO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <select class="custom-select" id="cod_orgao" name="cod_orgao" <?= $this->view->disabled ?>>
                                        <option value="<?= $this->view->cod_orgao ?>">
                                            <?= $this->view->orgao_nome ?>
                                        </option>
                                        <?php foreach ($this->view->orgao as $orgao) : ?>
                                            <option value="<?= $orgao['cod_orgao'] ?>"><?= $orgao['nome'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="setor">
                                        SETOR
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="setor" name="setor" value="<?= $this->view->setor ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="cargo">
                                        CARGO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="cargo" name="cargo" value="<?= $this->view->cargo ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="ocupacao">
                                        OCUPAÇÃO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <select class="custom-select" id="ocupacao" name="ocupacao" <?= $this->view->disabled ?>>
                                        <option
                                            <?= $this->view->ocupacao == 'ATIVO' ?  'selected' : '' ?>
                                            value="ativo">ATIVO(A)</option>
                                        <option
                                            <?= $this->view->ocupacao == 'APOSENTADO' ? 'selected' : '' ?>
                                            value="aposentado">APOSENTADO(A)</option>
                                        <option
                                            <?= $this->view->ocupacao == 'PENSIONISTA' ? 'selected' : '' ?>
                                            value="pensionista">PENSIONISTA</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="data_admissao">
                                        DATA ADMISSÃO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="date" class="form-control text-uppercase" id="data_admissao" name="data_admissao" value="<?= $this->view->data_admissao ?>" <?= $this->view->disabled ?>>
                                </div>

                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                ENDEREÇO
                            </div>
                            <div class="card-body form-group row">
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="cep">
                                        CEP
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="cep" name="cep" value="<?= $this->view->cep ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="uf">
                                        ESTADO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="uf" name="uf" value="<?= $this->view->uf ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="municipio">
                                        CIDADE OU MUNÍCIPIO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="municipio" name="municipio" value="<?= $this->view->municipio ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="bairro">
                                        BAIRRO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="bairro" name="bairro" value="<?= $this->view->bairro ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="endereco">
                                        ENDEREÇO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="endereco" name="endereco" value="<?= $this->view->endereco ?>" <?= $this->view->disabled ?>>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- / ESQUERDA -->
                    <!-- DIREITA -->
                    <div class="col-md-6">
                        <div class="card card-primary" style="margin-bottom: 30px;">
                            <div class="card-header ">
                                DADOS FINANCEIRO
                            </div>

                            <div class="card-body row">

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="cod_corretor">
                                        CÓDIGO DO CORRETOR
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="cod_corretor" name="cod_corretor" placeholder="Código" value="<?= $this->view->cod_corretor ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="praca">
                                        PRAÇA
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase ignore" id="praca" name="praca" placeholder="Praça" value="<?= $this->view->nome_praca ?>" <?= $this->view->disabled ?> readonly>
                                    <input type="hidden" class="form-control text-uppercase ignore" id="cod_local" name="cod_local" value="<?= $this->view->cod_local ?>" readonly>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="proposta">
                                        Nº PROPOSTA
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase ignore" id="proposta" name="num_proposta" placeholder="Nº Proposta" value="<?= $this->view->num_proposta ?>" readonly>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="data">
                                        DATA DA PROPOSTA
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase ignore" id="data" name="data_proposta" value="<?= $this->view->data_proposta ?>" disabled <?= $this->view->disabled ?>>
                                </div>


                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="financiado">
                                        VALOR FINANCIADO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                        </div>
                                        <input type="text" class="form-control text-uppercase" id="financiado" name="financiado" value="<?= $this->view->valor_financiado ?>" <?= $this->view->disabled ?>>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="liberado">
                                        VALOR LIBERADO
                                    </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                        </div>
                                        <input type="text" class="form-control text-uppercase ignore" id="liberado" name="liberado" value="<?= $this->view->valor_liberado ?>" <?= $this->view->disabled ?>>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="parcela">
                                        VALOR DA PARCELA
                                    </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                        </div>
                                        <input type="text" class="form-control text-uppercase ignore" id="parcela" name="parcela" value="<?= $this->view->valor_parcela ?>" <?= $this->view->disabled ?>>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="mensalidade">
                                        VALOR DA MENSALIDADE
                                    </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                        </div>
                                        <input type="text" class="form-control text-uppercase ignore" id="mensalidade" name="mensalidade" value="<?= $this->view->valor_mensalidade ?>" <?= $this->view->disabled ?>>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="prazo">
                                        PRAZO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control text-uppercase" id="prazo" name="prazo" value="<?= $this->view->prazo ?>" <?= $this->view->disabled ?>>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="prazo">Meses</span>
                                        </div>
                                    </div>
                                    <small class="text-danger d-none" id="msgPrazo">
                                        A soma do prazo com a idade não pode ser maior do que 70 anos</small>
                                </div>

                                <?php if ($_SESSION['nivel'] > 10): ?>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="tipo_proposta">
                                            TIPO DA PROPOSTA
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <select class="custom-select" id="tipo_proposta" name="tipo_proposta" <?= $this->view->disabled ?>>
                                            <option value="novo_com_margem"
                                                <?= $this->view->tipo_proposta === 'novo_com_margem' ?  'selected' : '' ?>>
                                                NOVO COM MARGEM
                                            </option>
                                            <option value="refin_com_margem"
                                                <?= $this->view->tipo_proposta === 'refin_com_margem' ?  'selected' : '' ?>>
                                                REFIN COM MARGEM
                                            </option>
                                            <option value="novo_mensalidade"
                                                <?= $this->view->tipo_proposta === 'novo_mensalidade' ?  'selected' : '' ?>>
                                                NOVO MENSALIDADE
                                            </option>
                                            <option value="refin_mensalidade"
                                                <?= $this->view->tipo_proposta === 'refin_mensalidade' ?  'selected' : '' ?>>
                                                REFIN MENSALIDADE
                                            </option>
                                            <option value="2_linha"
                                                <?= $this->view->tipo_proposta === '2_linha' ?  'selected' : '' ?>>
                                                2º LINHA
                                            </option>
                                            <option value="refin_2_linha"
                                                <?= $this->view->tipo_proposta === 'refin_2_linha' ?  'selected' : '' ?>>
                                                REFIN 2º LINHA
                                            </option>
                                            <option value="reenquadramento"
                                                <?= $this->view->tipo_proposta === 'reenquadramento' ?  'selected' : '' ?>>
                                                REENQUADRAMENTO
                                            </option>
                                            <option value="refinanciamento"
                                                <?= $this->view->tipo_proposta === 'refinanciamento' ?  'selected' : '' ?>>
                                                REFINANCIAMENTO
                                            </option>
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
                                            <input type="text" class="form-control text-uppercase" id="iof" name="iof" value="<?= $this->view->iof ?>" <?= $this->view->disabled ?>>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="iof">
                                            TAXA
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control text-uppercase" id="taxa" name="taxa" value="<?= $this->view->taxa ?>" <?= $this->view->disabled ?>>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">%</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                DADOS BANCÁRIOS DO CONTRA-CHEQUE
                            </div>

                            <div class="card-body form-group row" style="margin-bottom: 108px;">

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="banco">
                                        BANCO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" list="bancos" class="form-control text-uppercase" id="banco" name="banco" value="<?= $this->view->banco ?>" <?= $this->view->disabled ?>>
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
                                    <input type="text" class="form-control text-uppercase" id="agencia" name="agencia" value="<?= $this->view->agencia ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="conta">
                                        CONTA
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="conta" name="conta" value="<?= $this->view->conta ?>" <?= $this->view->disabled ?>>
                                </div>

                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                DADOS BANCÁRIOS PARA RECEBIMENTO
                            </div>

                            <div class="card-body form-group row" style="margin-bottom: 102px;">
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="banco_pagamento">
                                        BANCO
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" list="bancos" class="form-control text-uppercase" id="banco_pagamento" name="banco_pagamento" value="<?= $this->view->banco_pagamento ?>" <?= $this->view->disabled ?>>
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
                                    <input type="text" class="form-control text-uppercase" id="agencia_pagamento" name="agencia_pagamento" value="<?= $this->view->agencia_pagamento ?>" <?= $this->view->disabled ?>>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="conta_pagamento">
                                        CONTA
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" class="form-control text-uppercase" id="conta_pagamento" name="conta_pagamento" value="<?= $this->view->conta_pagamento ?>" <?= $this->view->disabled ?>>
                                </div>


                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="tipo_bancario">
                                        TIPO DA CONTA
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <select class="custom-select" id="tipo_bancario" name="tipo_bancario" <?= $this->view->disabled ?>>
                                        <?php if ($this->view->tipo_bancario == 'C') : ?>
                                            <option value="P">POUPANÇA</option>
                                            <option selected value="C">CORRENTE</option>
                                        <?php else : ?>
                                            <option selected value="P">POUPANÇA</option>
                                            <option value="C">CORRENTE</option>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /DIREITA -->

                    <div class="col-12">
                        <?php //TODO melhorar essa div footer
                        ?>
                        <div class="card-footer">
                            <?php if ($_SESSION['nivel'] <= 10): ?>
                                <button type="submit" name="cadastra" class="btn btn-primary float-left mr-3 px-5" <?= $this->view->disabled ?>>
                                    ATUALIZAR
                                </button>
                            <?php else: ?>
                                <button type="submit" name="cadastra" class="btn btn-primary float-left mr-3 px-5">
                                    ATUALIZAR
                                </button>
                            <?php endif ?>



                            <a href="/inicio" class="btn btn-outline-primary float-left mr-3  px-4">
                                VOLTA
                            </a>
                            <?php if ($_SESSION['nivel'] > 10 && $this->view->status_proposta < 5 && $this->view->status_recusado == 0 && $this->view->iof && $this->view->taxa): ?>
                                <button type="button"
                                    name="conferido"
                                    id="conferido"
                                    class="btn btn-success mb-2 px-5"
                                    onclick="conferirProposta(<?= $this->view->id_proposta ?>)">
                                    CONFERIR
                                </button>
                            <?php elseif ($this->view->status_proposta >= 5): ?>
                                <button type="button"
                                    id="conferido"
                                    class="btn btn-success ml-2 mb-2 px-5 disabled">
                                    <i class="fa-solid fa-check"></i>
                                    CONFERIDO
                                </button>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/jquery-mask/jquery.mask.min.js"></script>
<script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="/api/viaCep.js"></script>
<script src="/plugins/jquery-validation/jquery.validate.js"></script>
<script src="/js/proposta/edita_proposta/validarForm.js"></script>
<script src="/js/proposta/edita_proposta/mascaraInput.js"></script>
<script src="/js/proposta/edita_proposta/editaProposta.js"></script>
<script src="/js/proposta/edita_proposta/validarPrazo.js"></script>