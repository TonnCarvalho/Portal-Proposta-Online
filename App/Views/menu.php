<?php

use App\Helper\Contadores;
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <?php if ($_SESSION['nivel'] <= 10) : ?>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/inicio" class="nav-link">Inicio</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/proposta-cadastro" class="nav-link">Cadastra Proposta</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/consulta" class="nav-link">Consulta</a>
            </li>
        <?php endif ?>

        <?php if ($_SESSION['nivel'] > 10) : ?>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/inicio" class="nav-link">Inicio</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/acompanhamento" class="nav-link">Acompanhamento</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/assinados" class="nav-link">Assinados</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/clicksign" class="nav-link">Click Sign</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/estoque-consulta" class="nav-link">Estoque</a>
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
    <a href="inicio" class="brand-link">
        <img src="assets/img/sua_logo.png" alt="Logo" class="w-100" style="height:6rem">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">

                <!-- COLABORADOR -->
                <?php if ($_SESSION['nivel'] > 10) : ?>
                    <li class="nav-item">
                        <a href="/inicio" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Inicio
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/acompanhamento" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>
                                Acompanhamento
                                <span class="badge badge-dark right">
                                    <?= Contadores::propostaAndamentoContador() ?>
                                </span>
                            </p>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a href="/paga" class="nav-link">
                            <i class="nav-icon fa-brands fa-pix"></i>
                            <p>
                                A Pagar
                                <span class="badge badge-dark right">
                                    <?= Contadores::propostaPagaContador() ?>
                                </span>
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/assinados" class="nav-link">
                            <i class="nav-icon fas fa-file-circle-check"></i>
                            <p>
                                Assinados
                                <span class="badge badge-dark right">
                                    <?= Contadores::propostaAssinadoContador() ?>
                                </span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/proposta-cadastro" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                Cadastra Proposta
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/ccb-enviada" class="nav-link">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <p>
                                CCB Enviada
                                <span class="badge badge-dark right">
                                    <?= Contadores::propostaAguardandoCCBContador() ?>
                                </span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/clicksign" class="nav-link">
                            <i class="nav-icon fas fa-file-signature"></i>
                            <p>
                                Click Sign
                                <span class="badge badge-dark right">
                                    <?= Contadores::ClickSignContador() ?>
                                </span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/consultas" class="nav-link">
                            <i class="nav-icon fa fa-magnifying-glass"></i>
                            <p>
                                Consulta
                                <span class="badge badge-dark right">
                                    <?= Contadores::ConsultaContador() ?>
                                </span>
                            </p>
                        </a>
                    </li>
                    <!-- ADM -->
                    <?php if ($_SESSION['nivel'] === 100): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-boxes-packing"></i>
                                <p>
                                    Estoque
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/estoque-adicionar" class="nav-link">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Adicionar</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/estoque-consulta" class="nav-link">
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
                            <a href="/estoque-consulta" class="nav-link">
                                <i class="nav-icon fas fa-boxes-packing"></i>
                                <p>
                                    Estoque
                                </p>
                            </a>
                        </li>
                    <?php endif ?>

                    <li class="nav-item">
                        <a href="/orgaos" class="nav-link">
                            <i class="nav-icon fas fa-o"></i>
                            <p>
                                Orgãos
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/praca" class="nav-link">
                            <i class="nav-icon fas fa-tree-city"></i>
                            <p>
                                Praças
                            </p>
                        </a>
                    </li>

                    <?php if ($_SESSION['nivel'] >= 90): ?>
                        <li class="nav-item">
                            <a href="/prestamista" class="nav-link">
                                <i class="nav-icon fas fa-shield-halved"></i>
                                <p>
                                    Prestamista
                                </p>
                            </a>
                        </li>
                    <?php endif ?>

                    <li class="nav-item">
                        <a href="/usuario" class="nav-link">
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
                        <a href="/inicio" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Inicio
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/proposta-cadastro" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                Cadastra Proposta
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/consultas" class="nav-link">
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
<script src="/plugins/jquery/jquery.min.js"></script>
<script>
    /*** add active class and stay opened when selected ***/
    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $('ul.nav-sidebar a').filter(function() {
        if (this.href) {
            return this.href == url || url.href.indexOf(this.href) == 0;
        }
    }).addClass('active');

    // for the treeview
    $('ul.nav-treeview a').filter(function() {
        if (this.href) {
            return this.href == url || url.href.indexOf(this.href) == 0;
        }
    }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');

    // for sidebar menu entirely but not cover treeview
    $('ul.navbar-nav a').filter(function() {
        if (this.href) {
            return this.href == url || url.href.indexOf(this.href) == 0;
        }
    }).addClass('active');

    // for the treeview
    $('ul.nav-treeview a').filter(function() {
        if (this.href) {
            return this.href == url || url.href.indexOf(this.href) == 0;
        }
    }).parentsUntil(".navbar-nav > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
</script>