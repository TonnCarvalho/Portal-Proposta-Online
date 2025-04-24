<?php
include(__DIR__ . '/modal/recusar.php');
include(__DIR__ . '/modal/baixar_proposta.php');
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Acompanhamento</h1>
        </div>
    </div>
    <div class="content" x-data='alpineAcompanhamento(<?= $_SESSION['id_usuario'] ?>)'
        x-init='propostasAcompanhamento()'>
        <div class="container-fluid">
            <?php include(__DIR__ . '/componente/filtros.php') ?>
            <div>
                <?php
                if (isset($this->view->alerta)) {
                    echo $this->view->alerta;
                    unset($_SESSION['msg']);
                }
                ?>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary">
                        <i class="far fa-file-alt"></i>
                        Todas Propostas
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" style="white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center align-middle">Conferente</th>
                                    <th scope="col" class="text-center align-middle">Proposta</th>
                                    <th scope="col" class="text-center align-middle">Associado</th>
                                    <th scope="col" class="text-center align-middle">Status</th>
                                    <th scope="col" class="text-center align-middle">Click Sing</th>
                                    <th scope="col" class="text-center align-middle">CPF</th>
                                    <th scope="col" class="text-center align-middle">Praça</th>
                                    <th scope="col" class="text-center align-middle">Corretor</th>
                                    <th scope="col" class="text-center align-middle">Tipo <br> Contrato</th>
                                    <th scope="col" class="text-center align-middle">Taxa</th>
                                    <th scope="col" class="text-center align-middle">Data <br> proposta</th>
                                    <th scope="col" class="text-center align-middle">Valor <br> Mensalidade</th>
                                    <th scope="col" class="text-center align-middle">Valor <br> Financiado</th>
                                    <th scope="col" class="text-center align-middle">Valor <br> Liberado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for='proposta in propostas' :key='proposta.id_conferencia'>
                                    <tr>
                                        <td class="text-center text-uppercase align-middle">
                                            <template x-if="proposta.nivel > 10 && idUsuario == proposta.id_conferente">
                                                <span class="badge badge-primary"
                                                    x-html="`<i class='fa-solid fa-user'></i> ${removerSobreNome(proposta.nome_conferente)}`">
                                                </span>
                                            </template>

                                            <template x-if="proposta.nivel > 10 && idUsuario != proposta.id_conferente">
                                                <span class="badge badge-secondary"
                                                    x-html="`<i class='fa-solid fa-user'></i> ${removerSobreNome(proposta.nome_conferente)}`">
                                                </span>
                                            </template>
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle" x-text='proposta.num_proposta'>
                                        </td>

                                        <td
                                            class="text-center text-uppercase align-middle">
                                            <a :href="`/proposta-edita?proposta=${proposta.id_proposta}`" x-text='proposta.nome'></a>
                                        </td>

                                        <td class="text-center align-middle">
                                            <div class="btn-group">
                                                <button type="button" class="btn dropdown-toggle dropdown-icon p-0" data-toggle="dropdown" aria-expanded="false" x-html="proposta.status">
                                                </button>
                                                <div class="dropdown-menu disabled" role="menu">

                                                    <template x-if="
                                                    proposta.status_proposta_p === 5
                                                    && proposta.status_recusado === 0">
                                                        <a class="dropdown-item btn" data-toggle="modal" data-target="#baixarProposta"
                                                            :data-num-proposta="proposta.num_proposta"
                                                            :data-associado="proposta.nome" :data-id-proposta="proposta.id_proposta">
                                                            <i class="fas fa-file-arrow-down text-primary mr-1"></i>
                                                            Baixar
                                                        </a>
                                                    </template>
                                                    <template x-if="
                                                    proposta.status_proposta_p === 5
                                                    && proposta.status_recusado === 0
                                                    && proposta.status_assinatura === 0">
                                                        <button class="dropdown-item" @click="enviarParaClickSign(proposta.id_proposta)">
                                                            <i class="fas fa-file-signature text-orange"></i>
                                                            Click Sign
                                                        </button>
                                                    </template>

                                                    <template x-if="
                                                        proposta.status_proposta_p === 6
                                                        && proposta.status_recusado === 0">
                                                        <button class="dropdown-item" @click="propostaAssinada(proposta.id_proposta)">
                                                            <i class='fas fa-file-circle-check text-success mr-1'></i>
                                                            Assinado
                                                        </button>
                                                    </template>

                                                    <template x-if="
                                                    proposta.status_proposta_p < 9
                                                    proposta.status_recusado == 0">
                                                        <a class="dropdown-item btn" data-toggle="modal" data-target="#recusar" :data-num-proposta="proposta.num_proposta"
                                                            :data-associado="proposta.nome" :data-id-proposta="proposta.id_proposta">
                                                            <i class="fas fa-trash text-danger mr-1"></i>
                                                            Recusar
                                                        </a>
                                                    </template>

                                                    <template x-if="
                                                    proposta.status_recusado == 1">
                                                        <a class="dropdown-item btn"
                                                            x-on:click="reativarProposta(proposta.id_proposta)">
                                                            <i class="fas fa-trash-restore text-success mr-1"></i>
                                                            Reativar
                                                        </a>
                                                    </template>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle"
                                            x-html="statusClickSign(proposta.status_proposta_p, proposta.status_assinatura)">
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle"
                                            x-text='proposta.cpf'>
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle"
                                            x-html='proposta.praca_nome'>
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle"
                                            x-text='proposta.cod_corretor'>
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle"
                                            x-html='tipoPropostaReplace(proposta.tipo_proposta)'>
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle"
                                            x-text='proposta.taxa'>
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle"
                                            x-text='proposta.data_proposta'>
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle"
                                            x-html="'R$: '+ valorFormato(proposta.valor_mensalidade)">
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle"
                                            x-html="'R$: '+ valorFormato(proposta.valor_financiado)">
                                        </td>
                                        <td
                                            class="text-center text-uppercase align-middle"
                                            x-html="'R$: '+ valorFormato(proposta.valor_liberado)">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <!-- Link para a página anterior -->
                                <li class="page-item" :class="{ disabled: pagina <= 1 }">
                                    <a class="page-link" href="" @click.prevent="paginaAnterior()" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <!-- Link de página atual -->
                                <template x-for="page in paginasVisiveis()" :key="page">
                                    <li class="page-item" :class="{ active: page === pagina }">
                                        <a class="page-link" href="" @click.prevent="mudarPagina(page)" x-text="page"></a>
                                    </li>
                                </template>

                                <!-- Link para a próxima página -->
                                <li class="page-item" :class="{ disabled: pagina >= total_paginas }">
                                    <a class="page-link" href="" @click.prevent="proximaPagina()" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/toastr/toastr.min.js"></script>
<script src="js/acompanhamento/alpineAcompanhamento.js?v=<?=filemtime('js/acompanhamento/alpineAcompanhamento.js')?>"></script>
<script src="js/acompanhamento/modalBaixarProposta.js"></script>
<script src="js/acompanhamento/modalRecusar.js"></script>