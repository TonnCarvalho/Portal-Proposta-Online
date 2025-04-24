<div class="modal fade" id="situacao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-mudar-situacao" method="POST" action="/proposta-mudar-situacao">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">

                            <input type="hidden" name="id_proposta" id="id_proposta" >

                            <div class="form-group">
                                <label>Status da proposta</label>
                                <select class="form-control" name="status_proposta" id="status_proposta">
                                    <option value="1">
                                        EM ANDAMENTO
                                    </option>
                                    <option value="2">
                                        EM ANALISE
                                    </option>
                                    <option disabled value="3">
                                        PENDENTE
                                    </option>
                                    <option value="4">
                                        PENDENTE RESOLVIDA
                                    </option>
                                    <option value="5">
                                        CONFERIDO
                                    </option>
                                    <option value="6">
                                        AGUARDANDO ASSINATURA
                                    </option>
                                    <option value="7">
                                        ASSINADO
                                    </option>
                                    <option value="8">
                                        CCB ENVIADA
                                    </option>
                                    <option value="9">
                                        AGUARDANDO PAGAMENTO
                                    </option>
                                    <option value="10">
                                        PAGA
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status recusada</label>
                                <select class="form-control" name="status_recusado" id="status_recusado">
                                    <option value="0">NÃO</option>
                                    <option value="1">SIM</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status da click sign</label>
                                <select class="form-control" name="status_assinatura" id="status_assinatura">
                                    <option value="0">NÃO ENVIADO</option>
                                    <option value="1">AGUARDANDO ENVIO</option>
                                    <option value="2">ENVIADO</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status do refin</label>
                                <select class="form-control" name="status_refin" id="status_refin"> 
                                    <option value="0">SEM REFIN</option>
                                    <option value="1">COM REFIN</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary px-5">MUDAR</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">FECHAR</button>
                </div>
            </form>

        </div>
    </div>
</div>