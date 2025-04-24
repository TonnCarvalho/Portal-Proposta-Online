<div class="modal fade" id="editarRefinModal" tabindex="-1" role="dialog" aria-labelledby="editarRefinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-uppercase" id="editarRefinModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/ClickSign-edita-refin" method="POST" id="refinForm" name="enviar_refin">
                    <input type="hidden" readonly name="id_refin" id="id_refin" value="">
                    <input type="hidden" readonly name="id_associado" id="id_associado" value="">
                    <input type="hidden" readonly name="num_proposta" id="num_proposta" value="">
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="contrato" class="col-form-label">Nº CONTRATO</label>
                            <input type="text" class="form-control"
                                id="num_contrato1"
                                name="num_contrato1">
                        </div>
                        <div class="form-group col-4">
                            <label for="saldo_devedor" class="col-form-label">SALDO DEVEDOR</label>
                            <input type="text" class="form-control"
                                id="saldo_devedor_edite1"
                                name="saldo_devedor1">
                        </div>
                        <div class="form-group col-4">
                            <label for="valor_parcela" class="col-form-label">VALOR PARCELA</label>
                            <input type="text" class="form-control"
                                id="valor_parcela_edite1"
                                name="valor_parcela1">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-4">
                            <label for="contrato" class="col-form-label">Nº CONTRATO</label>
                            <input type="text" class="form-control"
                                id="num_contrato2"
                                name="num_contrato2">
                        </div>
                        <div class="form-group col-4">
                            <label for="saldo_devedor" class="col-form-label">SALDO DEVEDOR</label>
                            <input type="text" class="form-control"
                                id="saldo_devedor_edite2"
                                name="saldo_devedor2">
                        </div>
                        <div class="form-group col-4">
                            <label for="valor_parcela" class="col-form-label">VALOR PARCELA</label>
                            <input type="text" class="form-control"
                                id="valor_parcela_edite2"
                                name="valor_parcela2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-4">
                            <label for="contrato" class="col-form-label">Nº CONTRATO</label>
                            <input type="text" class="form-control"
                                id="num_contrato3"
                                name="num_contrato3">
                        </div>
                        <div class="form-group col-4">
                            <label for="saldo_devedor" class="col-form-label">SALDO DEVEDOR</label>
                            <input type="text" class="form-control"
                                id="saldo_devedor_edite3"
                                name="saldo_devedor3">
                        </div>
                        <div class="form-group col-4">
                            <label for="valor_parcela" class="col-form-label">VALOR PARCELA</label>
                            <input type="text" class="form-control"
                                id="valor_parcela_edite3"
                                name="valor_parcela3">
                        </div>
                    </div>

                    <div class="dropdown-divider"></div>

                    <div class="justify-content-start">
                        <button type="submit" class="btn btn-primary px-5">
                            EDITAR
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">FECHAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>