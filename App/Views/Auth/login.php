<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <img src="assets/img/sua_logo.png" alt="Logo" class="w-100" style="height: 10rem;">
      </div>
      <div class="card-body">
        <form action="/autenticar" method="post">
          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <input type="text" class="form-control" placeholder="Código" name="cod_corretor" autofocus>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <input type="password" class="form-control" placeholder="Senha" name="senha" id="senha">
            <div class="position-absolute btn" id="verSenha" style="right: 0; z-index: 100;" onclick="verSenha()">
              <span class="fas fa-eye-slash" id="iconVerSenha"></span>
            </div>
          </div>
          <div class="row justify-content-center">

            <?php if ($this->view->login) : ?>
              <div class="col-12">
                <div class="alert alert-danger text-center" role="alert">
                  Código ou senha invalidas!
                </div>
              </div>
            <?php endif ?>

            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </div>
          </div>
        </form>
        <div class="mt-2">
          <div class="float-right d-none">
            <a href="/recuperar-senha">Recuperar senha</a>
          </div>

          <div class="float-left">
            <a href="https://web.whatsapp.com/" target="_blank">Quero ser um corretor</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../../plugins/jquery/jquery.min.js"></script>
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../js/adminlte.min.js"></script>

  <script>
    function verSenha() {
      const inputSenha = document.querySelector('#senha');
      const iconVerSenha = document.querySelector('#iconVerSenha')

      if (inputSenha.getAttribute('type') == 'password') {
        inputSenha.setAttribute('type', 'text');
        iconVerSenha.classList.remove('fa-eye-slash')
        iconVerSenha.classList.add('fa-eye')

      } else {
        inputSenha.setAttribute('type', 'password')
        iconVerSenha.classList.remove('fa-eye')
        iconVerSenha.classList.add('fa-eye-slash')
      }
    }
  </script>
</body>

</html>