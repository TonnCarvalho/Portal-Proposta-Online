<div class="card">
    <div class="card-header">
        <h3 class="card-title text-primary">
            <i class="fas fa-filter"></i>
            Filtro
        </h3>
    </div>
    <div class="card-body p-0">
        <div class="row py-2 mx-1">
            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label>Pesquisa</label>
                    <input type="search" class="form-control" placeholder="NOME | CPF | Nº PROPOSTA" id="pesquisa" x-model="pesquisa" @keyup="propostasAcompanhamento()">
                </div>
            </div>

            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label>Situação</label>
                    <select class="form-control" id="status" x-model="situacao" @change="propostasAcompanhamento()">
                        <option value="">Todas Situações</option>
                        <template x-for="situacao in selectSituacao" :key='situacao.value'>
                            <option x-text="situacao.titulo" :value="situacao.value"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="col-sm-12 col-md-4">
                <div class="form-group">
                    <label for="clicksign">Click Sign</label>
                    <select class="form-control" id="clicksign" x-model='clicksign' @change="propostasAcompanhamento()">
                        <option value="">Todos Click Sign</option>
                        <template x-for='clicksign in selectClickSign'>
                            <option x-text='clicksign.titulo' :value='clicksign.value'></option>
                        </template>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>