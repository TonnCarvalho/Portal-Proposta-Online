<div class="card">
    <div class="card-header">
        <h3 class="card-title text-primary">
            <i class="fas fa-filter"></i>
            Filtro
        </h3>
    </div>
    <div class="card-body p-0">
        <div class="row py-2 mx-1">
            <div class="col-6">
                <div class="form-group">
                    <label>Pesquisa</label>
                    <input type="search" class="form-control" placeholder="NOME | CPF | Nº PROPOSTA" id="pesquisa" x-model="pesquisa" x-on:keyup="carregarProposta()">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Data proposta</label>
                    <input type="date" class="form-control" placeholder="DATA" id="data" x-model="data" x-on:keyup="carregarProposta()">
                </div>
            </div>
        </div>
    </div>
</div>