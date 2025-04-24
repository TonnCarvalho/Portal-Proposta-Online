<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1>Adicionar Estoque</h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <form action="/estoque-enviar" method="POST" class="col-12" enctype="multipart/form-data">
                            <label for="">Escolha o arquivo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="arquivo">
                                <label class="custom-file-label" for="exampleInputFile"></label>
                            </div>
                            <button type="submit" class="btn btn-primary px-5 mt-3">ENVIAR</button>
                        </form>
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