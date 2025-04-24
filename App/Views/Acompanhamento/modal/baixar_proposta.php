<!-- Modal Baixar Proposta -->
<div class="modal fade" id="baixarProposta" tabindex="-1" aria-labelledby="exampleBaixarProposta" aria-hidden="true" x-data='alpineAcompanhamento(<?= $_SESSION['id_usuario'] ?>)'>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-uppercase" id="exampleBaixarProposta">
                    Baixar proposta
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-recusar-proposta" method="POST" action="/baixar-documento">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="id_proposta" id="id_proposta" readonly>
                            <h5 class="text-center font-weight-bold">Deseja fazer o download desta proposta?</h5>
                            <div class="form-group">
                                <label class="form-label">Associado:</label>
                                <input class="form-control" type="text" id="associado" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nº Proposta:</label>
                                <input class="form-control" type="text" id="num_proposta" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary px-5" x-on:click="atualizarPagina()">
                        BAIXAR
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">FECHAR</button>
                </div>
            </form>
        </div>
    </div>
</div>