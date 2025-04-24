<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Estoque</h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary">
                        <i class="fa-solid fa-file-signature"></i>
                        Estoque
                    </h3>
                </div>
                <div class="card-body p-0" x-data="tabelaEstoqueAssociado()">
                    <div class="row justify-content-center">
                        <div class="my-3 col-sm-12 col-md-4">
                            <label for="search" class="form-label">
                                <strong>Pesquisa</strong>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Nº Proposta" x-model="num_proposta" @keydown.enter="carregarEstoque()">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default" @click="carregarEstoque()">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h4 class="px-3">Detalhes do Associado</h4>
                            <div class="row px-3">
                                <div class="col-md-6 col-lg-4">
                                    <div class="mb-3">
                                        <label for="nome" class="form-label">
                                            <strong>Associado</strong>
                                        </label>
                                        <input type="text" id="nome" class="form-control" x-model="nome" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="mb-3">
                                        <label for="cpf" class="form-label"><strong>CPF</strong></label>
                                        <input type="text" id="cpf_associado" class="form-control" x-model="cpf" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="mb-3">
                                        <label for="num_proposta" class="form-label"><strong>Numero da Proposta</strong></label>
                                        <input type="text" id="num_proposta_detalhe" class="form-control" x-model="removerSuffix(numPropostaAssociado)" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row px-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="valor_presente" class="form-label">
                                            <strong>Total valor presente</strong>
                                        </label>
                                        <input type="text" id="valor_presente" class="form-control" x-model="valor_presente" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="valor_refim" class="form-label">
                                            <strong>Valor para refinanciar</strong>
                                        </label>
                                        <input type="text" id="valor_refim" style="font-weight: 700;" class="form-control" x-model="valor_refinanciamento" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="media_valor_presente" class="form-label">
                                            <strong>Média do valor presente</strong>
                                        </label>
                                        <input type="text" id="media_valor_presente" class="form-control" x-model="valor_medio_presente" disabled>
                                    </div>
                                </div>

                                <div class="mb-3" data="{num_proposta: '' }">
                                    <form action="/gerar-arquivo-quitacao" method="post">
                                        <input type="hidden" class="form-control" x-model="num_proposta" name="num_proposta">
                                        <button type="submit" class="btn btn-flat btn-secondary px-5 ml-2" :disabled="num_proposta.length < 7">
                                            <i class="fa-regular fa-file-excel"></i>
                                            ARQUIVO QUITAÇÃO
                                        </button>
                                    </form>
                                </div>

                            </div>

                            <h4 class="mt-3 px-3">Histórico de Parcelas</h4>
                            <div class="table-responsive">
                                <form action="/ClickSign-gerar-excel" method="POST">
                                    <table class="table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="checkboxHead"
                                                            @change="toggleAllCheckboxes()" checked>
                                                        <label for="checkboxHead" class="custom-control-label"></label>
                                                    </div>
                                                </th>
                                                <th class="">PARCELA</th>
                                                <th class="col-2 text-center">VALOR NOMINAL</th>
                                                <th class="text-center">VALOR PRESENTE</th>
                                                <th class="text-center">DATA VENCIMENTO</th>
                                                <th class="text-center">Nº PROPOSTA</th>
                                                <th class="text-center">SITUAÇÃO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(estoqueItem, index) in estoque" :key="estoqueItem.id_estoque">
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input checkboxBody"
                                                                :value="estoqueItem.id_proposta" type="checkbox"
                                                                :id="'customCheckbox' + (index+1)"
                                                                @change="atualizarValores()" checked>
                                                            <label :for="'customCheckbox' + (index+1)" class="custom-control-label"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"
                                                        x-text="index +1"></td>
                                                    <td class="text-center"
                                                        x-text="formatarValor(estoqueItem.valor_nominal)"></td>
                                                    <td class="text-center"
                                                        x-text="formatarValor(estoqueItem.valor_presente)"></td>
                                                    <td class="text-center"
                                                        x-text="formatoData(estoqueItem.data_vencimento)"></td>
                                                    <td class="text-center"
                                                        x-text="removerSuffix(estoqueItem.num_proposta)"></td>
                                                    <td class="text-center"
                                                        x-text="estoqueItem.situacao"></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/js/estoque/estoque.js"></script>
<script src="/plugins/toastr/toastr.min.js"></script>