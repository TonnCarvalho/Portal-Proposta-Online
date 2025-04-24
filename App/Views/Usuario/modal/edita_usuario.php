<div class="modal fade" id="editaUsuario" tabindex="-1" aria-labelledby="editaUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editaUsuarioLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger text-center d-none" id="msgErroCPF" role="alert">
                    CPF invalido!
                </div>
                <form action="/edita-usuario" method="POST" class="row" id="usuarioEdita" name="valida_cpf_edita">
                    <input type="hidden" id="id_usuario" value="" name="id_usuario">
                    <div class="form-group col-sm-12 col-md-6">
                        <label class="text-uppercase" for="nome">Nome <span class="text-danger">*</span></label>
                        <input type="text" name="nome" class="form-control text-uppercase" placeholder="NOME E SOBRENOME"
                            id="nomeEditaUsuario" value="" required>
                    </div>

                    <?php if ($_SESSION['nivel'] <= 90): ?>
                        <div class="form-group col-sm-12 col-md-6">
                            <label class="text-uppercase" for="codigo">Código <span class="text-danger">*</span></label>
                            <input type="number" name="codigo" class="form-control text-uppercase" placeholder="CÓDIGO"
                                id="codigoEditaUsuario" value="" required readonly>
                        </div>
                    <?php endif ?>

                    <?php if ($_SESSION['nivel'] > 90): ?>
                        <div class="form-group col-sm-12 col-md-6">
                            <label class="text-uppercase" for="codigo">Código <span class="text-danger">*</span></label>
                            <input type="number" name="codigo" class="form-control text-uppercase" placeholder="CÓDIGO"
                                id="codigoEditaUsuario" value="" required>
                        </div>
                    <?php endif ?>

                    <?php if ($_SESSION['nivel'] <= 90): ?>
                        <div class="form-group col-sm-12 col-md-6">
                            <label class="text-uppercase" for="cpf">CPF <span class="text-danger">*</span></label>
                            <input type="text" name="cpf" class="form-control text-uppercase" placeholder="CPF"
                                id="cpfEditaUsuario" value="" required>
                        </div>
                    <?php endif ?>
                    <?php if ($_SESSION['nivel'] > 90): ?>
                        <div class="form-group col-sm-12 col-md-6">
                            <label class="text-uppercase" for="cpf">CPF <span class="text-danger">*</span></label>
                            <input type="text" name="cpf" class="form-control text-uppercase" placeholder="CPF"
                                id="cpfEditaUsuarioMaster" value="" required>
                        </div>
                    <?php endif ?>
                    <div class="form-group col-sm-12 col-md-6">
                        <label class="text-uppercase" for="telefone">Telefone</label>
                        <input type="text" name="telefone" class="form-control text-uppercase ignore" placeholder="00 0 0000-0000"
                            id="telefoneEditaUsuario" value="">
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label class="text-uppercase" for="celular">Celular <span class="text-danger">*</span></label>
                        <input type="text" name="celular" class="form-control text-uppercase" placeholder="00 0 0000-0000"
                            id="celularEditaUsuario" value="" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label class="text-uppercase" for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="email@email.com.br"
                            id="emailEditaUsuario" value="" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="text-uppercase" for="estado">Estado <span class="text-danger">*</span></label>
                            <select class="custom-select" id="estadoEditaUsuario" name="estado" placeholder="ESTADO" required>
                                <option selected disabled value="">SELECIONE</option>
                                <option value="AC">
                                    ACRE
                                </option>
                                <option value="AL">
                                    ALAGOAS
                                </option>
                                <option value="AP">
                                    AMAPÁ
                                </option>
                                <option value="AM">
                                    AMAZONAS
                                </option>
                                <option value="BA">
                                    BAHIA
                                </option>
                                <option value="CE">
                                    CEARÁ
                                </option>
                                <option value="DF">
                                    DISTRITO FEDERAL
                                </option>
                                <option value="ES">
                                    ESPÍRITO SANTOS
                                </option>
                                <option value="GO">
                                    GOÍAS
                                </option>
                                <option value="MA">
                                    MARANHÃO
                                </option>
                                <option value="MT">
                                    MATO GROSSO
                                </option>
                                <option value="MS">
                                    MATO GROSSO DO SUL
                                </option>
                                <option value="MG">
                                    MINAS GEREAIS
                                </option>
                                <option value="PA">
                                    PARÁ
                                </option>
                                <option value="PB">
                                    PARAÍBA
                                </option>
                                <option value="PR">
                                    PARANÁ
                                </option>
                                <option value="PE">
                                    PERNAMBUCO
                                </option>
                                <option value="PI">
                                    PIAUÍ
                                </option>
                                <option value="RJ">
                                    RIO DE JANEIRO
                                </option>
                                <option value="RN">
                                    RIO GRANDE DO NORTE
                                </option>
                                <option value="RS">
                                    RIO GRANDE DO SUL
                                </option>
                                <option value="RO">
                                    RONDÔNIA
                                </option>
                                <option value="RR">
                                    RORAIMA
                                </option>
                                <option value="SC">
                                    SANTA CATARINA
                                </option>
                                <option value="SP">
                                    SÃO PAULO
                                </option>
                                <option value="SE">
                                    SERGIPE
                                </option>
                                <option value="TO">
                                    TOCANTINS
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label class="text-uppercase" for="cidade">Cidade <span class="text-danger">*</span></label>
                        <input type="text" name="cidade" class="form-control text-uppercase" placeholder="CIDADE"
                            id="cidadeEditaUsuario" value="" required>
                    </div>

                    <?php if ($_SESSION['nivel'] < 90): ?>
                        <div class="form-group col-sm-12 col-md-6">
                            <label class="text-uppercase" for="cidade">Nivel</label>
                            <select class="custom-select" name="nivel" id="nivelEditaUsuario" required>
                                <option selected disabled value="10">
                                    CORRETOR
                                </option>
                            </select>
                        </div>
                    <?php endif ?>

                    <?php if ($_SESSION['nivel'] >= 90): ?>
                        <div class="form-group col-sm-12 col-md-6">
                            <label class="text-uppercase" for="cidade">Nivel</label>
                            <select class="custom-select" name="nivel" id="nivelEditaUsuario" required>
                                <option value="10">
                                    CORRETOR
                                </option>
                                <option value="20">
                                    ATENDIMENTO
                                </option>
                                <option value="25">
                                    ADM ATENDIMENTO
                                </option>
                                <option value="30">
                                    OPERAÇÃO
                                </option>
                                <option value="35">
                                    ADM OPERAÇÃO
                                </option>
                                <option value="40">
                                    DIGITAÇÃO
                                </option>
                                <option value="45">
                                    ADM DIGITAÇÃO
                                </option>
                                <?php if ($_SESSION['nivel'] == 90): ?>
                                    <option value="90" disabled>
                                        ADMINISTRADOR
                                    </option>
                                    <?php endif?>
                                <?php if ($_SESSION['nivel'] === 100): ?>
                                    <option value="90">
                                        ADMINISTRADOR
                                    </option>
                                    <option value="100">
                                        MASTER
                                    </option>
                                <?php endif ?>
                            </select>
                        </div>
                    <?php endif ?>
                    <div class="modal-footer col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary px-5">EDITAR</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">FECHAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>