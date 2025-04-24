<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADICIONAR USUÁRIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger text-center d-none" id="msgErroCPF" role="alert">
                    CPF invalido!
                </div>
                <form action="/adicionar-usuario" method="POST" class="row" id="usuarioCadastro" name="valida_cpf" onsubmit="return validaCPF()">
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="nome">Nome <span class="text-danger">*</span></label>
                        <input type="text" name="nome" class="form-control text-uppercase" placeholder="NOME E SOBRENOME"
                            id="nome" value="<?= $this->view->usuario['nome'] ?>" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="codigo">Código <span class="text-danger">*</span></label>
                        <input type="number" name="codigo" class="form-control text-uppercase" placeholder="CÓDIGO"
                            id="codigo" value="<?= $this->view->usuario['codigo'] ?>" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="senha">Senha <span class="text-danger">*</span></label>
                        <input type="password" name="senha" class="form-control" placeholder="SENHA"
                            id="senha" value="<?= $this->view->usuario['senha'] ?>" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="confirmaSenha">Confirma senha <span class="text-danger">*</span></label>
                        <input type="password" name="confirmaSenha" class="form-control" placeholder="CONFIRMA SENHA"
                            id="confirmaSenha" value="<?= $this->view->usuario['confirmaSenha'] ?>" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="cpf">CPF <span class="text-danger">*</span></label>
                        <input type="text" name="cpf" class="form-control text-uppercase" placeholder="CPF"
                            id="cpf" value="<?= $this->view->usuario['cpf'] ?>" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="telefone">Telefone</label>
                        <input type="text" name="telefone" class="form-control text-uppercase ignore" placeholder="00 0 0000-0000"
                            id="telefone" value="<?= $this->view->usuario['telefone'] ?>">
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="celular">Celular <span class="text-danger">*</span></label>
                        <input type="text" name="celular" class="form-control text-uppercase" placeholder="00 0 0000-0000"
                            id="celular" value="<?= $this->view->usuario['celular'] ?>" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="email@email.com.br"
                            id="email" value="<?= $this->view->usuario['email'] ?>" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="estado">Estado <span class="text-danger">*</span></label>
                            <select class="custom-select" id="estado" name="estado" placeholder="ESTADO"
                                id="estado" required>
                                <option selected disabled value="">SELECIONE</option>
                                <option value="AC" <?= $this->view->usuario['estado'] == 'AC' ? 'selected' : '' ?>>
                                    ACRE
                                </option>
                                <option value="AL" <?= $this->view->usuario['estado'] == 'AL' ? 'selected' : '' ?>>
                                    ALAGOAS
                                </option>
                                <option value="AP" <?= $this->view->usuario['estado'] == 'AP' ? 'selected' : '' ?>>
                                    AMAPÁ
                                </option>
                                <option value="AM" <?= $this->view->usuario['estado'] == 'AM' ? 'selected' : '' ?>>
                                    AMAZONAS
                                </option>
                                <option value="BA" <?= $this->view->usuario['estado'] == 'BA' ? 'selected' : '' ?>>
                                    BAHIA
                                </option>
                                <option value="CE" <?= $this->view->usuario['estado'] == 'CE' ? 'selected' : '' ?>>
                                    CEARÁ
                                </option>
                                <option value="DF" <?= $this->view->usuario['estado'] == 'DF' ? 'selected' : '' ?>>
                                    DISTRITO FEDERAL
                                </option>
                                <option value="ES" <?= $this->view->usuario['estado'] == 'ES' ? 'selected' : '' ?>>
                                    ESPÍRITO SANTOS
                                </option>
                                <option value="GO" <?= $this->view->usuario['estado'] == 'GO' ? 'selected' : '' ?>>
                                    GOÍAS
                                </option>
                                <option value="MA" <?= $this->view->usuario['estado'] == 'MA' ? 'selected' : '' ?>>
                                    MARANHÃO
                                </option>
                                <option value="MT" <?= $this->view->usuario['estado'] == 'MT' ? 'selected' : '' ?>>
                                    MATO GROSSO
                                </option>
                                <option value="MS" <?= $this->view->usuario['estado'] == 'MS' ? 'selected' : '' ?>>
                                    MATO GROSSO DO SUL
                                </option>
                                <option value="MG" <?= $this->view->usuario['estado'] == 'MG' ? 'selected' : '' ?>>
                                    MINAS GEREAIS
                                </option>
                                <option value="PA" <?= $this->view->usuario['estado'] == 'PA' ? 'selected' : '' ?>>
                                    PARÁ
                                </option>
                                <option value="PB" <?= $this->view->usuario['estado'] == 'PB' ? 'selected' : '' ?>>
                                    PARAÍBA
                                </option>
                                <option value="PR" <?= $this->view->usuario['estado'] == 'PR' ? 'selected' : '' ?>>
                                    PARANÁ
                                </option>
                                <option value="PE" <?= $this->view->usuario['estado'] == 'PE' ? 'selected' : '' ?>>
                                    PERNAMBUCO
                                </option>
                                <option value="PI" <?= $this->view->usuario['estado'] == 'PI' ? 'selected' : '' ?>>
                                    PIAUÍ
                                </option>
                                <option value="RJ" <?= $this->view->usuario['estado'] == 'RJ' ? 'selected' : '' ?>>
                                    RIO DE JANEIRO
                                </option>
                                <option value="RN" <?= $this->view->usuario['estado'] == 'RN' ? 'selected' : '' ?>>
                                    RIO GRANDE DO NORTE
                                </option>
                                <option value="RS" <?= $this->view->usuario['estado'] == 'RS' ? 'selected' : '' ?>>
                                    RIO GRANDE DO SUL
                                </option>
                                <option value="RO" <?= $this->view->usuario['estado'] == 'RO' ? 'selected' : '' ?>>
                                    RONDÔNIA
                                </option>
                                <option value="RR" <?= $this->view->usuario['estado'] == 'RR' ? 'selected' : '' ?>>
                                    RORAIMA
                                </option>
                                <option value="SC" <?= $this->view->usuario['estado'] == 'SC' ? 'selected' : '' ?>>
                                    SANTA CATARINA
                                </option>
                                <option value="SP" <?= $this->view->usuario['estado'] == 'SP' ? 'selected' : '' ?>>
                                    SÃO PAULO
                                </option>
                                <option value="SE" <?= $this->view->usuario['estado'] == 'SE' ? 'selected' : '' ?>>
                                    SERGIPE
                                </option>
                                <option value="TO" <?= $this->view->usuario['estado'] == 'TO' ? 'selected' : '' ?>>
                                    TOCANTINS
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="cidade">Cidade <span class="text-danger">*</span></label>
                        <input type="text" name="cidade" class="form-control text-uppercase" placeholder="CIDADE"
                            id="cidade" value="<?= $this->view->usuario['cidade'] ?>" required>
                    </div>

                    <?php if ($_SESSION['nivel'] < 90): ?>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="cidade">Nivel</label>
                            <select class="custom-select" name="nivel" id="nivel" required>
                                <option selected disabled value="10">
                                    CORRETOR
                                </option>
                            </select>
                        </div>
                    <?php endif ?>

                    <?php if ($_SESSION['nivel'] > 90): ?>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="cidade">Nivel</label>
                            <select class="custom-select" name="nivel" id="nivel" required>
                                <option value="10" <?= $this->view->usuario['nivel'] == '10' ? 'selected' : '' ?>>
                                    CORRETOR
                                </option>
                                <option value="20" <?= $this->view->usuario['nivel'] == '20' ? 'selected' : '' ?>>
                                    ATENDIMENTO
                                </option>
                                <option value="25" <?= $this->view->usuario['nivel'] == '25' ? 'selected' : '' ?>>
                                    ADM ATENDIMENTO
                                </option>
                                <option value="30" <?= $this->view->usuario['nivel'] == '30' ? 'selected' : '' ?>>
                                    OPERAÇÃO
                                </option>
                                <option value="35" <?= $this->view->usuario['nivel'] == '35' ? 'selected' : '' ?>>
                                    ADM OPERAÇÃO
                                </option>
                                <option value="40" <?= $this->view->usuario['nivel'] == '40' ? 'selected' : '' ?>>
                                    DIGITAÇÃO
                                </option>
                                <option value="45" <?= $this->view->usuario['nivel'] == '45' ? 'selected' : '' ?>>
                                    ADM DIGITAÇÃO
                                </option>
                                <?php if ($_SESSION['nivel'] === 100): ?>
                                    <option value="90" <?= $this->view->usuario['nivel'] == '90' ? 'selected' : '' ?>>
                                        ADMINISTRADOR
                                    </option>
                                    <option value="100" <?= $this->view->usuario['nivel'] == '100' ? 'selected' : '' ?>>
                                        MASTER
                                    </option>
                                <?php endif ?>
                            </select>
                        </div>
                    <?php endif ?>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">ADICIONAR</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">FECHAR</button>
            </div>
            </form>
        </div>
    </div>
</div>

