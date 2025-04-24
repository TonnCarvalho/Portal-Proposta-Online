<div class="modal fade" id="recusar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-uppercase" id="exampleModalLabel">
                    Recusar proposta
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-recusar-proposta" method="POST" action="/recusar-proposta">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">

                            <input type="hidden" name="id_proposta" id="id_proposta" readonly>

                            <div class="form-group">
                                <label class="form-label">Associado:</label>
                                <input class="form-control" type="text" id="associado" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nº Proposta:</label>
                                <input class="form-control" type="text" id="num_proposta" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Informe o motivo</label>
                                <textarea name="motivo" placeholder="Motivo" class="form-control border-danger" id="motivo"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger px-5">RECUSAR</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">FECHAR</button>
                </div>
            </form>
        </div>
    </div>
</div>