<?php
include_once(__DIR__ . '/modal/adicionar_orgaos.php');
include_once(__DIR__ . '/modal/edita_orgaos.php');
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Órgão</h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary">
                        <i class="fa-solid fa-o"></i>
                        Órgão
                    </h3>
                </div>
                <div class="card-body p-0" x-data="alpineOrgaos()">
                    <div class="row px-3 mt-2">
                        <div class="col-lg-2 col-md-12 mb-2">
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-plus"></i>
                                ÓRGÃO
                            </button>
                        </div>

                        <div class="col-lg-10 col-md-12">
                            <div class="form-group">

                                <select class="custom-select" id="praca" x-model="cod_local" @change="selectOrgaos">
                                    <option selected>
                                        SELECIONE A PRAÇA
                                    </option>
                                    <?php foreach ($this->view->pracas as $praca): ?>
                                        <option value="<?= $praca['cod_local'] ?>">
                                            <?= $praca['nome'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>

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
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">
                                                CÓDIGO
                                            </th>
                                            <th colspan="2" class="text-center">
                                                ORGÃO
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
                                        <template x-for="(orgao, index) in orgaosLista" :key="orgao.id_orgao">
                                            <tr>
                                                <td x-text="orgao.cod_orgao"
                                                    class="text-center"
                                                    colspan="1">
                                                </td>
                                                <td x-html="orgao.nome"
                                                    class="text-center text-uppercase"
                                                    colspan="2">
                                                </td>
                                                <template x-if="orgao.inativo == 0">
                                                    <td class="text-center">
                                                        <span class="badge badge-pill badge-success">ativo</span>
                                                    </td>
                                                </template>
                                                <template x-if="orgao.inativo == 1">
                                                    <td class="text-center">
                                                        <span class="badge badge-pill badge-danger">inativo</span>
                                                    </td>
                                                </template>

                                                <td class="text-center d-flex justify-content-center">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" :id="'customSwitch' + index"
                                                                :checked="orgao.inativo == 0" @change="mudarSituacaoOrgao(orgao.id_orgao, $event)">
                                                            <label class="custom-control-label" :for="'customSwitch' + index">
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="dropdown ml-3">
                                                        <button class="btn btn-sm" type="button" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <button class="dropdown-item" data-toggle="modal" data-target="#editaOrgao" :data-orgao-nome="orgao.nome" :data-id-orgao="orgao.id_orgao"
                                                                :data-cod-orgao="orgao.cod_orgao">
                                                                <i class="fa-solid fa-pen text-primary mr-1"></i>
                                                                Editar
                                                            </button>
                                                            <?php if ($_SESSION['nivel'] === 100): ?>
                                                                <button class="dropdown-item" @click="deletaOrgao(orgao.id_orgao)">
                                                                    <i class="fa-solid fa-trash text-danger mr-1"></i>
                                                                    Deleta
                                                                </button>
                                                            <?php endif ?>
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
<script src="/js/orgaos/alpineOrgaos.js"></script>
<script src="/js/orgaos/orgaos.js"></script>