<?php
include_once(__DIR__ . '/modal/adicionar_usuario.php');
include_once(__DIR__ . '/modal/edita_usuario.php');
include_once(__DIR__ . '/modal/altera_senha.php');
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="content-header">
            <h1>Usuário</h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary">
                        <i class="fa-solid fa-user"></i>
                        Usuário
                    </h3>
                </div>
                <div class="card-body p-0" x-data="alpineUsuario()">
                    <div class="row px-3 mt-2">
                        <div class="col-lg-2 col-md-12 mb-2">
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-plus"></i>
                                USUÁRIO
                            </button>
                        </div>
                        <div class="col-lg-10 col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control text-uppercase" id="pesquisa" placeholder="CÓDIGO OU NOME"
                                    x-model="pesquisaUsaurio" @keyup="listaUsuario">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php
                            if (isset($_SESSION['msg'])) {
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                            ?>
                            <div class="table-responsive" x-init="listaUsuario()">
                                <table class="table table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th colspan="1" class="text-center">
                                                CÓDIGO
                                            </th>
                                            <th colspan="2" class="text-center">
                                                NOME
                                            </th>
                                            <th class="text-center">
                                                NIVEL
                                            </th>
                                            <th class="text-center">
                                                SITUAÇÃO
                                            </th>
                                            <th class="text-center">
                                                OPÇÕES
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(usuario, index) in usuarioLista" :key="usuario.id_usuario">
                                            <tr class="my-2">
                                                <td x-text="usuario.cod_corretor"
                                                    class="text-center align-middle"
                                                    colspan="1">
                                                </td>
                                                <td x-html="usuario.nome"
                                                    class="text-center align-middle"
                                                    colspan="2">
                                                </td>

                                                <template x-if="usuario.nivel === 100">
                                                    <td class="text-center align-middle">
                                                        MASTER
                                                    </td>
                                                </template>

                                                <template x-if="usuario.nivel === 90">
                                                    <td class="text-center align-middle">
                                                        ADMINISTRADOR
                                                    </td>
                                                </template>

                                                <template x-if="usuario.nivel === 45">
                                                    <td class="text-center align-middle">
                                                        ADM DIGITAÇÃO
                                                    </td>
                                                </template>

                                                <template x-if="usuario.nivel === 40">
                                                    <td class="text-center align-middle">
                                                        DIGITAÇÃO
                                                    </td>
                                                </template>

                                                <template x-if="usuario.nivel === 35">
                                                    <td class="text-center align-middle">
                                                        ADM OPERAÇÃO
                                                    </td>
                                                </template>

                                                <template x-if="usuario.nivel === 30">
                                                    <td class="text-center align-middle">
                                                        OPERAÇÃO
                                                    </td>
                                                </template>

                                                <template x-if="usuario.nivel === 25">
                                                    <td class="text-center align-middle">
                                                        ADM ATENDIMENTO
                                                    </td>
                                                </template>

                                                <template x-if="usuario.nivel === 20">
                                                    <td class="text-center align-middle">
                                                        ATENDIMENTO
                                                    </td>
                                                </template>

                                                <template x-if="usuario.nivel === 10">
                                                    <td class="text-center align-middle">
                                                        CORRETOR
                                                    </td>
                                                </template>

                                                <template x-if="usuario.inativo == 0">
                                                    <td class="text-center align-middle">
                                                        <span class="badge badge-pill badge-success">ativo</span>
                                                    </td>
                                                </template>
                                                <template x-if="usuario.inativo == 1">
                                                    <td class="text-center align-middle">
                                                        <span class="badge badge-pill badge-danger">inativo</span>
                                                    </td>
                                                </template>

                                                <td class="align-middle">
                                                    <div class="d-flex justify-content-center align-items-center"
                                                        x-data="{ idUsuario: <?= $_SESSION['id_usuario'] ?>, nivelAtual: <?= $_SESSION['nivel'] ?> }">

                                                        <div class="align-middle">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" :id="'customSwitch' + index"
                                                                    :checked="usuario.inativo == 0"
                                                                    @change="mudarSituacaoUsuario(usuario.id_usuario, $event)"
                                                                    :disabled="(nivelAtual < 100 && usuario.nivel == 100 || usuario.id_usuario == idUsuario)
                                                                 || (usuario.id_usuario == 151)
                                                                 || (nivelAtual < 90 && usuario.nivel >= 90)
                                                                ">
                                                                <label class="custom-control-label" :for="'customSwitch' + index">
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="dropdown ml-3">
                                                            <button class="btn btn-sm" type="button" data-toggle="dropdown" aria-expanded="false"
                                                                :disabled="(nivelAtual < 100 && usuario.nivel == 100)
                                                                 || (usuario.id_usuario == 151)
                                                                 || (nivelAtual < 90 && usuario.nivel >= 90)
                                                                ">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <?php if ($_SESSION['nivel'] == 20 || $_SESSION['nivel'] == 25 || $_SESSION['nivel'] >= 90): ?>
                                                                    <button class="dropdown-item" data-toggle="modal" data-target="#editaUsuario" :data-id="usuario.id_usuario" :data-usuario="usuario.nome" :data-cod-corretor="usuario.cod_corretor"
                                                                        :data-cpf="usuario.cpf" :data-tel="usuario.tel" :data-cel="usuario.cel" :data-email="usuario.email" :data-uf="usuario.uf" :data-cidade="usuario.cidade"
                                                                        :data-nivel="usuario.nivel">
                                                                        <i class="fa-solid fa-pen text-primary mr-1"></i>
                                                                        Editar
                                                                    </button>
                                                                    <button class="dropdown-item" data-toggle="modal" data-target="#alteraSenha" :data-id="usuario.id_usuario" :data-usuario="usuario.nome" :data-cod-corretor="usuario.cod_corretor">
                                                                        <i class="fa-solid fa-key text-warning mr-1"></i>
                                                                        Altera Senha
                                                                    </button>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>

                                </table>

                                <!--
                            //TODO Paginação, colocar para funcionar 
                             <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/toastr/toastr.min.js"></script>
<script src="/plugins/jquery-validation/jquery.validate.js"></script>

<script src="/js/usuario/alpineUsuario.js"></script>
<script src="/js/usuario/MascaraUsuario.js"></script>

<script src="/js/usuario/validaCPF.js"></script>
<script src="/js/usuario/validarFormCadastro.js"></script>

<script src="/js/usuario/edita_usuario/editaDadosUsuario.js"></script>
<script src="/js/usuario/edita_usuario/editaValidarForm.js"></script>

<script src="/js/usuario/altera_senha/alteraSenhaDadosUsuario.js"></script>