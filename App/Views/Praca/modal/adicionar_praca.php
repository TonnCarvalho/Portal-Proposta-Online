<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  x-data="alpinePraca()">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADICIONAR PRAÇA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/adicionar-praca" method="POST">
                    <div class="form-group">
                        <label for="tipoPraca">Tipo da praça</label>
                        <select name="tipoPraca" id="tipoPraca" class="custom-select" @change="tipoPraca()">
                            <option value="estado">ESTADO</option>
                            <option value="municipio">MUNICÍPIO</option>
                        </select>
                    </div>

                    <div class="form-group d-none" id="pracaEstadoMunicipio">
                        <label for="selectEstado">Estado da praça</label>
                        <select class="custom-select" id="selectEstado" name="selectEstado">
                            <option selected disabled value="">SELECIONE</option>
                            <option value="AC">ACRE</option>
                            <option value="AL">ALAGOAS</option>
                            <option value="AP">AMAPÁ</option>
                            <option value="AM">AMAZONAS</option>
                            <option value="BA">BAHIA</option>
                            <option value="CE">CEARÁ</option>
                            <option value="DF">DISTRITO FEDERAL</option>
                            <option value="ES">ESPÍRITO SANTOS</option>
                            <option value="GO">GOÍAS</option>
                            <option value="MA">MARANHÃO</option>
                            <option value="MT">MATO GROSSO</option>
                            <option value="MS">MATO GROSSO DO SUL</option>
                            <option value="MG">MINAS GEREAIS</option>
                            <option value="PA">PARÁ</option>
                            <option value="PB">PARAÍBA</option>
                            <option value="PR">PARANÁ</option>
                            <option value="PE">PERNAMBUCO</option>
                            <option value="PI">PIAUÍ</option>
                            <option value="RJ">RIO DE JANEIRO</option>
                            <option value="RN">RIO GRANDE DO NORTE</option>
                            <option value="RS">RIO GRANDE DO SUL</option>
                            <option value="RO">RONDÔNIA</option>
                            <option value="RR">RORAIMA</option>
                            <option value="SC">SANTA CATARINA</option>
                            <option value="SP">SÃO PAULO</option>
                            <option value="SE">SERGIPE</option>
                            <option value="TO">TOCANTINS</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="praca">Praça</label>
                        <input type="text" name="praca" class="form-control text-uppercase" id="praca" placeholder="nome da praça">
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
<script src="/js/Praca/alpinePraca.js"></script>