<div class="modal fade" id="editaOrgao" tabindex="-1" aria-labelledby="editaOrgaoLabel" aria-hidden="true" x-data="alpineOrgaos()">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="editaOrgaoLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/edita-orgao" method="POST">

                    <div class="form-group">
                        <label for="nome_orgao">Órgão</label>
                        <input type="hidden" name="id_orgao" class="form-control text-uppercase" id="id_orgao">
                        <input type="text" name="nome_orgao" class="form-control text-uppercase" id="nome_orgao" placeholder="nome do órgão">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary px-4">EDITA</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">FECHAR</button>
            </div>
            </form>
        </div>
    </div>
</div>