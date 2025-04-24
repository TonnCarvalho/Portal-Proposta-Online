<?php

use App\Helper\Contadores;
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link disabled text-muted" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

                <?php if ($_SESSION['nivel'] <= 10) : ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/inicio" class="nav-link disabled text-muted">Inicio</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/proposta-cadastro" class="nav-link disabled text-muted">Cadastra Proposta</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/consulta" class="nav-link disabled text-muted">Consulta</a>
                    </li>
                <?php endif ?>

                <?php if ($_SESSION['nivel'] > 10) : ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/inicio" class="nav-link disabled text-muted">Inicio</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/acompanhamento" class="nav-link disabled text-muted">Acompanhamento</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/assinados" class="nav-link disabled text-muted">Assinados</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/clicksign" class="nav-link disabled text-muted">Click Sign</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/estoque-consulta" class="nav-link disabled text-muted">Estoque</a>
                    </li>
                <?php endif ?>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown user-menu">

                            <a class="nav-link dropdown-toggle" href="#" id="perfil" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-user-tie"></i>
                                <span class="d-none d-md-inline"><?= $_SESSION['nome'] ?></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="perfil">
                                <a class="dropdown-item disabled" href="#">
                                    <i class="fa-solid fa-user mr-1"></i>
                                    Meu Perfil
                                </a>
                                <a class="dropdown-item disabled" href="#">
                                    <i class="fa-solid fa-circle-question mr-1"></i>
                                    Ajuda
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="/logout">
                                    <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i>
                                    Sair
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        <aside class="main-sidebar sidebar-light-primary elevation-1" style="overflow-x: hidden;">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
            <img src="assets/img/sua_logo.png" alt="Logo" class="w-100" style="height: 10rem;">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">

                        <!-- COLABORADOR -->
                        <?php if ($_SESSION['nivel'] > 10) : ?>
                            <li class="nav-item">
                                <a href="/inicio" class="nav-link disabled text-muted">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>
                                        Inicio
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/acompanhamento" class="nav-link disabled text-muted">
                                    <i class="nav-icon fas fa-clipboard-list"></i>
                                    <p>
                                        Acompanhamento
                                        <span class="badge badge-secondary right">
                                            <?= Contadores::propostaAndamentoContador() ?>
                                        </span>
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/assinados" class="nav-link disabled text-muted">
                                    <i class="nav-icon fas fa-file-circle-check"></i>
                                    <p>
                                        Assinados
                                        <span class="badge badge-secondary right">
                                            <?= Contadores::propostaAssinadoContador() ?>
                                        </span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/proposta-cadastro" class="nav-link disabled text-muted">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>
                                        Cadastra Proposta
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/clicksign" class="nav-link disabled text-muted">
                                    <i class="nav-icon fas fa-file-signature"></i>
                                    <p>
                                        Click Sign
                                        <span class="badge badge-secondary right">
                                            <?= Contadores::ClickSignContador() ?>
                                        </span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/consultas" class="nav-link disabled text-muted">
                                    <i class="nav-icon fa fa-magnifying-glass"></i>
                                    <p>
                                        Consulta
                                        <span class="badge badge-secondary right">
                                            <?= Contadores::ConsultaContador() ?>
                                        </span>
                                    </p>
                                </a>
                            </li>
                            <!-- ADM -->
                            <?php if ($_SESSION['nivel'] === 100): ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link disabled text-muted">
                                        <i class="nav-icon fas fa-boxes-packing"></i>
                                        <p>
                                            Estoque
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="/estoque-adicionar" class="nav-link disabled text-muted">
                                                <i class="fas fa-plus nav-icon"></i>
                                                <p>Adicionar</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/estoque-consulta" class="nav-link disabled text-muted">
                                                <i class="fas fa-boxes-packing nav-icon"></i>
                                                <p>Estoque</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif ?>
                            <!-- /ADM -->
                            <?php if ($_SESSION['nivel'] < 100): ?>
                                <li class="nav-item">
                                    <a href="/estoque-consulta" class="nav-link disabled text-muted">
                                        <i class="nav-icon fas fa-boxes-packing"></i>
                                        <p>
                                            Estoque
                                        </p>
                                    </a>
                                </li>
                            <?php endif ?>

                            <li class="nav-item">
                                <a href="/orgaos" class="nav-link disabled text-muted">
                                    <i class="nav-icon fas fa-o"></i>
                                    <p>
                                        Orgãos
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/praca" class="nav-link disabled text-muted">
                                    <i class="nav-icon fas fa-tree-city"></i>
                                    <p>
                                        Praças
                                    </p>
                                </a>
                            </li>

                            <?php if ($_SESSION['nivel'] >= 90): ?>
                                <li class="nav-item">
                                    <a href="/prestamista" class="nav-link disabled text-muted">
                                        <i class="nav-icon fas fa-shield-halved"></i>
                                        <p>
                                            Prestamista
                                        </p>
                                    </a>
                                </li>
                            <?php endif ?>

                            <li class="nav-item">
                                <a href="/usuario" class="nav-link disabled text-muted">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Usuário
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <!-- /COLABORADOR -->

                        <!-- CORRETOR -->
                        <?php if ($_SESSION['nivel'] <= 10) : ?>
                            <li class="nav-item">
                                <a href="/inicio" class="nav-link disabled text-muted">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>
                                        Inicio
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/proposta-cadastro" class="nav-link disabled text-muted">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>
                                        Cadastra Proposta
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/consultas" class="nav-link disabled text-muted">
                                    <i class="nav-icon fa fa-magnifying-glass"></i>
                                    <p>
                                        Consulta
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="content-header">
                    <h1></h1>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="card col-sm-12 col-md-6 card-primary card-outline">
                            <div class="mt-2">
                                <?php
                                if (isset($_SESSION['msg'])) {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                                ?>
                            </div>
                            <form action="/atualizar-usuario-login" method="POST" id="atualizarUsuarioLogin">
                                <div class="card-body">
                                    <h3 class="text-center">
                                        Olá <span class="text-primary"><?= $_SESSION['nome'] ?>,</span>
                                        <br> vamos atualizar seus dados.
                                    </h3>
                                    <div class="form-group">
                                        <label for="nome">Nome e sobrenome
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="nome" class="form-control" id="nome" placeholder="Seu nome e sobrenome" value="<?= $this->view->usuario['nome'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="cpf">
                                            CPF
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="cpf" class="form-control" id="cpf" placeholder="Seu CPF" value="<?= $this->view->usuario['cpf'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="celular">
                                            Celular
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="celular" class="form-control" id="celular" placeholder="Seu número de celular" value="<?= $this->view->usuario['celular'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">
                                            Email
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Seu email" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="estado">
                                            Estado
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="custom-select" id="estado" name="estado" placeholder="ESTADO"
                                            id="estado" required>
                                            <option selected disabled value="">SELECIONE</option>
                                            <option value="AC" <?= $this->view->usuario['estado'] == 'AC' ? 'selected' : '' ?>>
                                                ACRE
                                            </option>
                                            <option value="AL" <?= $this->view->usuario['estado'] == 'AL' ? 'selected' : '' ?>>
                                                ALAGOAS
                                            </option>
                                            <option value="AP" <?= $this->view->usuario['estado'] == 'AP' ? 'selected' : '' ?>>
                                                AMAPÁ
                                            </option>
                                            <option value="AM" <?= $this->view->usuario['estado'] == 'AM' ? 'selected' : '' ?>>
                                                AMAZONAS
                                            </option>
                                            <option value="BA" <?= $this->view->usuario['estado'] == 'BA' ? 'selected' : '' ?>>
                                                BAHIA
                                            </option>
                                            <option value="CE" <?= $this->view->usuario['estado'] == 'CE' ? 'selected' : '' ?>>
                                                CEARÁ
                                            </option>
                                            <option value="DF" <?= $this->view->usuario['estado'] == 'DF' ? 'selected' : '' ?>>
                                                DISTRITO FEDERAL
                                            </option>
                                            <option value="ES" <?= $this->view->usuario['estado'] == 'ES' ? 'selected' : '' ?>>
                                                ESPÍRITO SANTOS
                                            </option>
                                            <option value="GO" <?= $this->view->usuario['estado'] == 'GO' ? 'selected' : '' ?>>
                                                GOÍAS
                                            </option>
                                            <option value="MA" <?= $this->view->usuario['estado'] == 'MA' ? 'selected' : '' ?>>
                                                MARANHÃO
                                            </option>
                                            <option value="MT" <?= $this->view->usuario['estado'] == 'MT' ? 'selected' : '' ?>>
                                                MATO GROSSO
                                            </option>
                                            <option value="MS" <?= $this->view->usuario['estado'] == 'MS' ? 'selected' : '' ?>>
                                                MATO GROSSO DO SUL
                                            </option>
                                            <option value="MG" <?= $this->view->usuario['estado'] == 'MG' ? 'selected' : '' ?>>
                                                MINAS GEREAIS
                                            </option>
                                            <option value="PA" <?= $this->view->usuario['estado'] == 'PA' ? 'selected' : '' ?>>
                                                PARÁ
                                            </option>
                                            <option value="PB" <?= $this->view->usuario['estado'] == 'PB' ? 'selected' : '' ?>>
                                                PARAÍBA
                                            </option>
                                            <option value="PR" <?= $this->view->usuario['estado'] == 'PR' ? 'selected' : '' ?>>
                                                PARANÁ
                                            </option>
                                            <option value="PE" <?= $this->view->usuario['estado'] == 'PE' ? 'selected' : '' ?>>
                                                PERNAMBUCO
                                            </option>
                                            <option value="PI" <?= $this->view->usuario['estado'] == 'PI' ? 'selected' : '' ?>>
                                                PIAUÍ
                                            </option>
                                            <option value="RJ" <?= $this->view->usuario['estado'] == 'RJ' ? 'selected' : '' ?>>
                                                RIO DE JANEIRO
                                            </option>
                                            <option value="RN" <?= $this->view->usuario['estado'] == 'RN' ? 'selected' : '' ?>>
                                                RIO GRANDE DO NORTE
                                            </option>
                                            <option value="RS" <?= $this->view->usuario['estado'] == 'RS' ? 'selected' : '' ?>>
                                                RIO GRANDE DO SUL
                                            </option>
                                            <option value="RO" <?= $this->view->usuario['estado'] == 'RO' ? 'selected' : '' ?>>
                                                RONDÔNIA
                                            </option>
                                            <option value="RR" <?= $this->view->usuario['estado'] == 'RR' ? 'selected' : '' ?>>
                                                RORAIMA
                                            </option>
                                            <option value="SC" <?= $this->view->usuario['estado'] == 'SC' ? 'selected' : '' ?>>
                                                SANTA CATARINA
                                            </option>
                                            <option value="SP" <?= $this->view->usuario['estado'] == 'SP' ? 'selected' : '' ?>>
                                                SÃO PAULO
                                            </option>
                                            <option value="SE" <?= $this->view->usuario['estado'] == 'SE' ? 'selected' : '' ?>>
                                                SERGIPE
                                            </option>
                                            <option value="TO" <?= $this->view->usuario['estado'] == 'TO' ? 'selected' : '' ?>>
                                                TOCANTINS
                                            </option>
                                        </select>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="cidade">
                                            Cidade
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="cidade" class="form-control" id="cidade" placeholder="Onde mora" value="<?= $this->view->usuario['cidade'] ?>" required>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary px-5">
                                        Atualizar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="/plugins/jquery-mask/jquery.mask.min.js"></script>
    <script src="/plugins/jquery-validation/jquery.validate.js"></script>

    <script src="/js/usuario/login_atualizar_dados/mascara.js"></script>
    <script src="/js/usuario/login_atualizar_dados/validarForm.js"></script>
</body>