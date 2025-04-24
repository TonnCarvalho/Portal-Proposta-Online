<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Nova Consulta</h1>
        </div>
    </div>
    <div class="content" x-data='alpineConsulta()'>
        <div class="container-fluid">
            <form action="/consulta-enviar" method="POST" onsubmit="return validarInputPraca()">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <?php
                                if (isset($_SESSION['msg'])) {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="callout callout-warning mt-3">
                                <h5>AVISO IMPORTANTE!</h5>
                                <ul>
                                    <li>
                                        Apenas a CONSULTA 1 é <strong>obrigatoria.</strong>
                                    </li>
                                    <li>
                                        A quantidade de parcelas somado a idade do associado, não pode ultrapassar <strong>70 anos.</strong>
                                    </li>
                                    <li>A consulta é realizada por praça.</li>
                                    <li>Informe seu email, <strong>obrigatorio.</strong></li>
                                    <li>Selecione a praça, <strong>obrigatorio.</strong></li>
                                    <li>Informe o nome completo, <strong>obrigatorio.</strong></li>
                                    <li>Informe o CPF, <strong>obrigatorio.</strong></li>
                                    <li>Informe a matrícula, <span class="text-danger">não é obrigatorio.</span></li>
                                    <li>Informe a data de nascimento, <strong>obrigatorio.</strong></li>
                                </ul>

                            </div>
                            <div class="alert alert-danger mt-3 d-none" id="alerta" role="alert"></div>
                        </div>
                        <div class="row">
                            <input type="hidden" class="form-control text-uppercase" id="email" name="email" placeholder="Email" value="<?= $this->view->email ?>">

                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>
                                        Praça
                                        <span class="text-danger"> *</span>
                                    </label>
                                    <select class="form-control border-danger" id="praca" name="praca" x-model='praca'
                                        onchange="return validarInputPraca()">
                                        <option value="" selected disabled>ESCOLHA A PRAÇA</option>
                                        <?php foreach ($this->view->pracas as $praca) : ?>
                                            <option value="<?= $praca['nome'] ?>">
                                                <?= $praca['nome'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 87px;" class="text-center">Consulta</th>
                                        <th>Nome Completo <span class="text-danger"> *</span></th>
                                        <th>CPF <span class="text-danger"> *</span></th>
                                        <th>Matrícula</th>
                                        <th>Data de Nascimento <span class="text-danger"> *</span></th>
                                    </tr>
                                </thead>
                                <template x-for="(consulta, index) in consultas" :key="consulta.index">
                                    <tbody>
                                        <tr>
                                            <td x-text="index +1" class="text-center align-middle">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    :id="'nome' + consulta.index"
                                                    name="nome[]" placeholder="Nome completo"
                                                    value=""
                                                    x-model="consultas[index].nome">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    :id="'cpf' + consulta.index"
                                                    name="cpf[]"
                                                    placeholder="CPF"
                                                    value=""
                                                    x-model="consultas[index].cpf">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    :id="'matricula' + (index + 1)"
                                                    name="matricula[]"
                                                    placeholder="Matrícula"
                                                    value=""
                                                    x-model="consultas[index].matricula">
                                            </td>
                                            <td>
                                                <input type="date" class="form-control"
                                                    :id="'dataNascimento' + consulta.index"
                                                    name="nascimento[]"
                                                    value=""
                                                    x-model="consultas[index].dataNascimento">
                                            </td>
                                        </tr>
                                    </tbody>
                                </template>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success mr-4">
                            FAZER CONSULTA
                        </button>
                        <a href="/consultas" class="btn btn-outline-primary">
                            VOLTA
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/jquery-mask/jquery.mask.min.js"></script>
<script src="/js/consulta/mascaraCPF.js"></script>
<script src="/js/consulta/alpineConsulta.js"></script>
<script src="/js/consulta/validacaoForm.js"></script>
<script src="/plugins/toastr/toastr.min.js"></script>