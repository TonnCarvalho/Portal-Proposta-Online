<div class="content-wrapper" x-cloak x-data='alpinePaga()' x-init='carregarProposta()'>
    <div class="content-header">
        <div class="container-fluid">
            <h1>A Pagar</h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <?php include('componente/filtro.php')?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary">
                        <i class="far fa-file-alt"></i>
                        Aguardando pagamento
                    </h3>
                </div>
                <div class="card-body p-0">

                    <div class="row">
                        <div class="col-12">
                            <?php
                            if (isset($this->view->alerta)) {
                                echo $this->view->alerta;
                            }
                            ?>
                            <div class="table-responsive">
                                <form @submit.prevent='propostasPagas()'>
                                    <table class="table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th width="50">
                                                    <div class="custom-control custom-checkbox">
                                                        <input
                                                            class="custom-control-input checkboxHeader"
                                                            type="checkbox" id="checkBoxHeader"
                                                            @change='mudarEstadoCheckBoxBody()'>
                                                        <label for="checkBoxHeader" class="custom-control-label"></label>
                                                    </div>
                                                </th>
                                                <th class="text-start">Proposta</th>
                                                <th class="text-start">Data</th>
                                                <th class="text-center">Associado</th>
                                                <th class="text-center">Praça</th>
                                                <th class="text-center">Financiado</th>
                                                <th class="text-center">Liberado</th>
                                                <th class="text-center">Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for='proposta, index in propostas' :key='proposta.id_proposta'>
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input checkboxBody"
                                                                type="checkbox"
                                                                :id="'customCheckbox' + (index + 1)"
                                                                :value='proposta.id_proposta'
                                                                x-model='idPropostas'
                                                                @change="mudarEstadoCheckBoxHeader()">
                                                            <label :for="'customCheckbox' + (index + 1)" class="custom-control-label"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-start" x-text='proposta.num_proposta'></td>
                                                    <td class="text-start" x-text='proposta.data_proposta'></td>
                                                    <td class="text-center" x-html='proposta.nome_associado'></td>
                                                    <td class="text-center" x-html='proposta.nome_praca'></td>
                                                    <td class="text-center" x-text="formatoValor(proposta.valor_financiado)"></td>
                                                    <td class="text-center" x-text="formatoValor(proposta.valor_liberado)"></td>
                                                    <td class="text-center" class="text-center align-middle">
                                                        <button class="btn btn-sm btn-success" @click="propostaPaga(proposta.id_proposta)">
                                                            <i class="fa-solid fa-check text-white"></i>
                                                            PAGO
                                                        </button>
                                                    </td>
                                                </tr>
                                            </template>

                                        </tbody>
                                    </table>

                                    <div class="p-3">
                                        <button class="btn btn-sm btn-success" type="submit">
                                            <i class="fa-solid fa-list-check text-success mr-1 text-white"></i>
                                            PAGOS
                                        </button>
                                    </div>
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

<script src="/plugins/toastr/toastr.min.js"></script>
<script src="js/pagar/alpinePaga.js?v=<?=filemtime('js/pagar/alpinePaga.js')?>"></script>