<?php
include_once('modal/refin_adicionar.php');
include_once('modal/refin_editar.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Click Sign</h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary">
                        <i class="fa-solid fa-file-signature"></i>
                        Click Sign
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="col-12">
                        <div class="row" x-data="alpineClickSign()" x-init="propostaClickSign()">
                            <div class="col-12 my-2">
                                <?php
                                if (isset($_SESSION['msg'])) {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                                ?>
                            </div>
                            <div class="table-responsive">
                                <form action="/clicksign-gerar-excel" method="POST">
                                    <table class="table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input checkboxHeader" type="checkbox" id="checkboxHeader" @change="mudarEstadoCheckBoxBody()" checked>
                                                        <label for="checkboxHeader" class="custom-control-label"></label>
                                                    </div>
                                                </th>
                                                <th class="">PROPOSTA</th>
                                                <th class="col-2 text-center">ASSOCIADO</th>
                                                <th class="text-center">PRAÇA</th>
                                                <th class="text-center">FINANCIADO</th>
                                                <th class="text-center">LIBERADO</th>
                                                <th class="text-center">PARCELA</th>
                                                <th class="text-center">MENSALIDADE</th>
                                                <th class="text-center">PRAZO</th>
                                                <?php if ($_SESSION['nivel'] > 10): ?>
                                                    <th class="text-center">OPÇÕES</th>
                                                <?php endif ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="proposta, index in propostas" :key="proposta.id_proposta">
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input checkboxBody"
                                                                type="checkbox"
                                                                :id="'customCheckbox' + (index+1)"
                                                                :value="proposta.id_proposta"
                                                                name="id_proposta[]"
                                                                @change="mudarEstadoCheckBoxHeader()"
                                                                checked>
                                                            <label :for="'customCheckbox' + (index+1)" class="custom-control-label"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div x-text="proposta.num_proposta"></div>
                                                        <template x-if="
                                                        proposta.tipo_proposta == 'refin_com_margem' && proposta.status_refin == 0 ||
                                                        proposta.tipo_proposta == 'refin_mensalidade' && proposta.status_refin == 0 ||
                                                        proposta.tipo_proposta == 'refin_2_linha' && proposta.status_refin == 0 ||
                                                        proposta.tipo_proposta == 'reenquadramento' && proposta.status_refin == 0 ||
                                                        proposta.tipo_proposta == 'refinanciamento' && proposta.status_refin == 0 ">
                                                            <small class="badge badge-secondary">refin</small>
                                                        </template>

                                                        <template x-if="proposta.status_refin == 1">
                                                            <span class="badge bg-success">refin</span>
                                                        </template>

                                                    <td class="text-center text-uppercase">
                                                        <a :href="'proposta-edita?proposta=' + proposta.id_proposta"
                                                            x-text="proposta.nome">
                                                        </a>
                                                    </td>

                                                    <td class="text-center text-uppercase">
                                                        <div x-html="proposta.nome_praca"></div>
                                                    </td>

                                                    <td class="text-center">
                                                        <div x-text="valorFormato(proposta.valor_financiado)"></div>
                                                    </td>

                                                    <td class="text-center">
                                                        <div x-text="valorFormato(proposta.valor_liberado)"></div>
                                                    </td>

                                                    <td class="text-center">
                                                        <div x-text="valorFormato(proposta.valor_parcela)"></div>
                                                    </td>

                                                    <td class="text-center">
                                                        <div x-text="valorFormato(proposta.valor_mensalidade)"></div>
                                                    </td>

                                                    <td class="text-center">
                                                        <div x-text="proposta.prazo + 'x'"></div>
                                                    </td>

                                                    <?php if ($_SESSION['nivel'] > 10): ?>
                                                        <td class="text-center align-middle">
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm" type="button" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <template x-if="
                                                                    proposta.tipo_proposta == 'refin_com_margem' && proposta.status_refin == 0 ||
                                                                    proposta.tipo_proposta == 'refin_mensalidade' && proposta.status_refin == 0 ||
                                                                    proposta.tipo_proposta == 'refin_2_linha' && proposta.status_refin == 0 ||
                                                                    proposta.tipo_proposta == 'reenquadramento' && proposta.status_refin == 0 ||
                                                                    proposta.tipo_proposta == 'refinanciamento' && proposta.status_refin == 0">
                                                                        <a class="dropdown-item btn" data-toggle="modal" data-target="#refinModal"
                                                                            :data-id-proposta="proposta.id_proposta"
                                                                            :data-proposta="proposta.num_proposta"
                                                                            :data-associado="proposta.id_associado"
                                                                            :data-nome="proposta.nome">
                                                                            <i class="fa-solid fa-plus text-success mr-1"></i>
                                                                            Adicionar Refin
                                                                        </a>
                                                                    </template>
                                                                    <template x-if="proposta.status_refin == 1">
                                                                        <a class="dropdown-item btn" data-toggle="modal" data-target="#editarRefinModal"
                                                                            :data-id-proposta="proposta.id_proposta"
                                                                            :data-id-refin="proposta.id_refin"
                                                                            :data-proposta="proposta.num_proposta"
                                                                            :data-associado="proposta.id_associado"
                                                                            :data-nome="proposta.nome"
                                                                            :data-num-contrato1="proposta.num_contrato1"
                                                                            :data-num-contrato2="proposta.num_contrato2"
                                                                            :data-num-contrato3="proposta.num_contrato3"
                                                                            :data-saldo-devedor1="proposta.saldo_devedor1"
                                                                            :data-saldo-devedor2="proposta.saldo_devedor2"
                                                                            :data-saldo-devedor3="proposta.saldo_devedor3"
                                                                            :data-valor-parcela1="proposta.valor_parcela1"
                                                                            :data-valor-parcela2="proposta.valor_parcela2"
                                                                            :data-valor-parcela3="proposta.valor_parcela3">
                                                                            <i class="fa-solid fa-pen text-info mr-1"></i>
                                                                            Editar Refin
                                                                        </a>
                                                                    </template>

                                                                    <template x-if="proposta.status_refin == 1">
                                                                        <a class="dropdown-item btn"
                                                                            @click="apagaRefin(proposta.id_proposta,proposta.id_refin)">
                                                                            <i class="fa-solid fa-trash text-danger mr-1"></i>
                                                                            Apaga Refin
                                                                        </a>
                                                                    </template>
                                                                    <a class="dropdown-item btn"
                                                                        @click="remover(proposta.id_proposta)">
                                                                        <i class="fa-solid fa-arrows-rotate text-danger mr-1"></i>
                                                                        Remover
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                </tr>
                                            <?php endif ?>
                                            </template>
                                        </tbody>

                                    </table>
                                    <button
                                        type="submit"
                                        class="btn btn-flat btn-secondary px-5 m-3"
                                        :disabled="totalProposta === 0">
                                        <i class="fa-regular fa-file-excel"></i>
                                        GERAR EXCEL
                                    </button>
                                </form>

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
<script src="/plugins/jquery-mask/jquery.mask.min.js"></script>
<script src="/js/click_sign/alpineClickSign.js"></script>
<script src="/js/click_sign/clicksign.js"></script>
<script src="/plugins/toastr/toastr.min.js"></script>