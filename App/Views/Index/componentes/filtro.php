<div class="row py-2 mx-1">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Praças</label>
            <select class="form-control" id="praca" x-model="praca" @change="carregarPropostas">
                <option value="">TODAS PRAÇAS</option>
                <?php foreach ($this->view->pracas as $praca) : ?>
                    <option value="<?= $praca['cod_local'] ?>">
                        <?= $praca['nome'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Pesquisa</label>
            <input type="search" class="form-control" placeholder="NOME | CPF | Nº PROPOSTA" id="pesquisa" x-model="pesquisa" @keyup="carregarPropostas">
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Situação</label>
            <select class="form-control" id="status" x-model="situacao" @change="carregarPropostas">
                <option value="">
                    TODAS SITUAÇÕES
                </option>
                <template x-for="option in optionSituacao">
                    <option x-text="option.titulo" :value="option.value"></option>
                </template>
            </select>
        </div>
    </div>
</div>