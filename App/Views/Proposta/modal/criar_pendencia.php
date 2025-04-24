<!-- Modal -->
<div class="modal fade" id="criarPendenciaModal" tabindex="-1" role="dialog" aria-labelledby="criarPendenciaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/criar-pendencia" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="criarPendenciaModalLabel">
                    <?= $this->view->num_proposta ?> - <?= $this->view->nome ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_proposta" value="<?= $this->view->id_proposta?>" readonly>
                    <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario']?>" readonly>
                    <input type="hidden" name="nome_associado" value="<?= $this->view->nome?>" readonly>
                    <textarea class="w-100 form-control" name="mensagem" id="mensagem" rows="3" placeholder="Digite uma mensagem" required></textarea>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-primary px-5">ENVIAR</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">VOLTA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Modal -->