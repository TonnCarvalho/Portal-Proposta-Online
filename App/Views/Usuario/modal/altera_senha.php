<div class="modal fade" id="alteraSenha" tabindex="-1" aria-labelledby="alteraSenhaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alteraSenhaLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/altera-seha-usuario" method="POST" class="">
                <div class="modal-body">

                    <input type="hidden" id="id_usuario_altera_senha" value="" name="id_usuario">

                    <div class="form-group">
                        <label class="text-uppercase" for="senha">Nova Senha <span class="text-danger">*</span></label>
                        <input type="password" name="senha" class="form-control text-uppercase" placeholder="NOVA SENHA"
                            id="senhaAlteraSenha" value="" required>
                    </div>
                </div>
                <div class="modal-footer col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary px-5">ALTERAR</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">FECHAR</button>
                </div>
            </form>
        </div>
    </div>
</div>