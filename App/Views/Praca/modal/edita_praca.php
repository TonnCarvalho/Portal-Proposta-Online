<div class="modal fade" id="editaPraca" tabindex="-1" aria-labelledby="editaPracaLabel" aria-hidden="true"  x-data="alpinePraca()">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editaPracaLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/edita-praca" method="POST">
                    
                    <div class="form-group">
                        <label for="praca">Praça</label>
                        <input type="hidden" name="cod_local" class="form-control text-uppercase" id="cod_local">
                        <input type="text" name="praca" class="form-control text-uppercase" id="praca" placeholder="nome da praça">
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
<script src="/js/Praca/alpinePraca.js"></script>