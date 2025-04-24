<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" x-data="alpineOrgaos()">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADICIONAR ÓRGÃO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/adicionar-orgao" method="POST">
                    <div class="form-group">
                        <label for="cod_local">Praça</label>
                        <select name="cod_local" id="cod_local" class="custom-select">
                            <?php foreach ($this->view->pracas as $praca): ?>
                                <option value="<?= $praca['cod_local'] ?>">
                                    <?= $praca['nome'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="possui_codigo">Possiu Código</label>
                        <select name="possui_codigo" id="possui_codigo" class="custom-select" @change="possuiCodigo()">
                            <option value="n">
                                NÃO
                            </option>
                            <option value="s">
                                SIM
                            </option>
                        </select>
                    </div>

                    <div class="form-group d-none" id="orgao_codigo">
                        <label for="codigo">Código do Órgão</label>
                        <input type="number" name="codigo" class="form-control text-uppercase" placeholder="código do órgão"
                        id="codigo">
                    </div>


                    <div class="form-group">
                        <label for="praca">Nome do Órgão</label>
                        <input type="text" name="orgao_nome" class="form-control text-uppercase" id="praca" placeholder="nome do órgão">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">ADICIONAR</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">FECHAR</button>
            </div>
            </form>
        </div>
    </div>
</div>