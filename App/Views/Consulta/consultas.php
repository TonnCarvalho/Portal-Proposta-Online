<!-- //TODO usar alpineJS aqui -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Consultas</h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-0">
                    <div class="col-lg-3 col-md-3 py-2">
                        <a href="/consulta-adicionar" class="btn btn-primary btn-block">
                            <i class="fas fa-plus"></i>
                            NOVA CONSULTA
                        </a>
                    </div>
                    <div class="col-12">
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center">
                                                CÓDIGO
                                            </th>
                                            <?php if ($_SESSION['nivel'] > 10): ?>
                                                <th class="text-center">
                                                    CORRETOR
                                                </th>
                                            <?php endif ?>
                                            <th colspan="2" class="text-center">
                                                PRAÇA
                                            </th>
                                            <th class="text-center">
                                                SITUAÇÃO
                                            </th>
                                            <th class="text-center">
                                                DATA
                                            </th>
                                            <th class="text-center">
                                                AÇÃO
                                            </th>
                                            <!-- <?php if ($_SESSION['nivel'] == 10): ?>
                                            <th class="text-center">
                                                EXCLUIR
                                            </th>
                                        <?php endif ?> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($this->view->consulta as $consulta): ?>
                                            <tr onclick="window.location='/consulta?codigo=<?= $consulta['id_consulta'] ?>'" style="cursor: pointer;">
                                                <td class="text-center" colspan="1">
                                                    <?= $consulta['id_consulta'] ?>
                                                </td>

                                                <?php if ($_SESSION['nivel'] > 10): ?>
                                                    <td class="text-center">
                                                        <?= $consulta['cod_corretor'] ?>
                                                    </td>
                                                <?php endif ?>

                                                <td class="text-center" colspan="2">
                                                    <?= $consulta['praca'] ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php if ($consulta['status_consulta'] == 1): ?>
                                                        <span class='badge' style='background-color: #DBEAFE; color: #1E40AF; border: 1px solid #DBEAFE'>
                                                            <i class='fas fa-envelope mr-1'></i>
                                                            ENVIADO
                                                        </span>

                                                    <?php elseif ($consulta['status_consulta'] == 2): ?>
                                                        <span class='badge' style='background-color: #F3E8FF; color: #8613e4; border: 1px solid #F3E8FF'>
                                                            <i class='fas fa-envelope-open-text mr-2' style='font-size: 14px;'></i>
                                                            ABERTO
                                                        </span>

                                                    <?php elseif ($consulta['status_consulta'] == 3): ?>
                                                        <span class='badge' style='background-color: #D1FAE5; color: #065F46; border: 1px solid #D1FAE5'>
                                                            <i class='fas fa-envelope-circle-check mr-2' style='font-size: 14px;'></i>
                                                            RESPONDIDO
                                                        </span>

                                                    <?php endif ?>
                                                </td>

                                                <td class="text-center">
                                                    <?= (new DateTime($consulta['data_criado']))->format('d/m/Y') ?>
                                                    <br>
                                                    <?= (new DateTime($consulta['data_criado']))->format('H:i') ?>
                                                </td>

                                                <td class="text-center">
                                                    <a href="/consulta?codigo=<?= $consulta['id_consulta'] ?>"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="far fa-file-lines mr-1"></i>
                                                        Abrir
                                                    </a>
                                                </td>
                                                <!-- <?php if ($_SESSION['nivel'] == 10): ?>
                                                <td class="text-center">
                                                    <a href="/consulta?codigo=<?= $consulta['id_consulta'] ?>"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Excluir
                                                    </a>
                                                </td>
                                            <?php endif ?> -->
                                            </tr>
                                        <?php endforeach ?>

                                    </tbody>

                                </table>

                                <!-- <nav aria-label="Page navigation">
                                //TODO Paginação, colocar para funcionar 
                                <ul class="pagination justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/toastr/toastr.min.js"></script>