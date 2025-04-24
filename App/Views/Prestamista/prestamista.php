<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Adicionar Associados FIDC</h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
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
                        <form action="/prestamista-enviar" method="POST" class="col-12" enctype="multipart/form-data">
                            <label for="">Escolha o arquivo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="arquivo" accept=".csv">
                                <label class="custom-file-label" for="exampleInputFile"></label>
                            </div>
                            <button type="submit" class="btn btn-primary px-5 mt-3">ENVIAR</button>
                        </form>
                        <div class="col-12 mt-3">
                            <div class="callout callout-success">
                                <h5>Associados Prestamista</h5>

                                <a href="<?= $this->view->prestamista_download ?>" download>
                                    <button type="submit" class="btn btn-primary px-5 mt-3">
                                        DOWNLOAD
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="callout callout-danger">
                                <h5>Associados Prestamista não encontrados</h5>

                                <a href="<?= $this->view->prestamista_nao_encontrado_download ?>" download>
                                    <button type="submit" class="btn btn-primary px-5 mt-3">
                                        DOWNLOAD
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>