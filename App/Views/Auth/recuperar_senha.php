<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1>Recuperar senha</h1>
            </div>
            <div class="card-body">
                <form action="/recuperar-senha/enviar-token" method="post">
                    <div class="form-group">
                        <div class="w-100">
                            <?php
                            if (isset($_SESSION['msg'])) {
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                            ?>
                        </div>
                        <label for="email">Email</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <input type="email" class="form-control" placeholder="Email" name="email" autofocus>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                        </div>
                    </div>
                </form>
                <div class="mt-2">
                    <div class="float-left">
                        <a href="/login">Fazer login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>