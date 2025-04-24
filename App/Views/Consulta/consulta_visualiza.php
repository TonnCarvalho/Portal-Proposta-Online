<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Consulta: <?= $this->view->id_consulta ?></h1>
            <h5>PRAÇA: <?= $this->view->praca_consulta ?></h5>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <form action="/consulta-responder" method="POST" onsubmit="return validarResposta()">
                <input type="hidden" name="id_consulta" value="<?= $this->view->id_consulta ?>">
                <input type="hidden" name="email" value="<?= $this->view->consulta_visualiza[0]['email'] ?>">
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

                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 87px;" class="text-center">Consulta</th>
                                        <th class="text-center">Nome Completo</th>
                                        <th class="text-center">CPF</th>
                                        <th class="text-center">Matrícula</th>
                                        <th class="text-center">Data de Nascimento</th>
                                    </tr>
                                </thead>

                                <?php foreach ($this->view->consulta_visualiza as $index => $consulta): ?>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <?php if (!empty($consulta['nome' . $i]) && !empty($consulta['cpf' . $i])): ?>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td class="align-middle"><?= $i ?></td>
                                                    <td class="text-center align-middle text-uppercase"><?= $consulta['nome' . $i] ?></td>
                                                    <td class="text-center align-middle text-uppercase"><?= $consulta['cpf' . $i] ?></td>
                                                    <td class="text-center align-middle text-uppercase"><?= $consulta['matricula' . $i] ?></td>
                                                    <td class="text-center align-middle text-uppercase"><?= (new DateTime($consulta['data_nasc' . $i]))->format('d/m/Y') ?></td>
                                                </tr>

                                                <?php if (!empty($consulta['resposta' . $i])): ?>
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-1 col-form-label">Resposta:</label>
                                                                <div class="col-sm-11">
                                                                    <input type="text" class="form-control border-primary" value='<?= $consulta['resposta' . $i] ?>' readonly>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif ?>

                                                <?php if ($_SESSION['nivel'] > 10 && $consulta['status_consulta'] < 3): ?>
                                                    <tr>
                                                        <td colspan="1" class="text-center align-middle">Resposta</td>
                                                        <td colspan="4" class="text-uppercase">
                                                            <input type="hidden" value="<?= $index + $i ?>" name="index[]">
                                                            <input type="text" class="form-control border-danger" name="resposta[]" id="resposta" placeholder="Responder consulta <?= $i ?>">
                                                        </td>
                                                    </tr>
                                                <?php endif ?>
                                            </tbody>
                                        <?php endif ?>
                                    <?php endfor ?>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?php if ($this->view->consulta_visualiza[0]['status_consulta'] < 3 && $_SESSION['nivel'] >= 20): ?>
                            <button type="submit" class="btn btn-success">RESPONDER</button>
                            <a type="button" href="/consultas" class="btn btn-outline-primary ml-3">VOLTA</a>

                        <?php else: ?>
                            <a type="button" href="/consultas" class="btn btn-outline-primary px-5">VOLTA</a>
                        <?php endif ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/js/consulta/visualizar/visualizar.js"></script>
<script src="/plugins/toastr/toastr.min.js"></script>