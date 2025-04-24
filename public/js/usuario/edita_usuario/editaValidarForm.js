  $("#usuarioEdita").validate({
    ignore: ".ignore",
    rules: {
      nomeEditaUsuario: {
        required: true,
        minlength: 4,
      },
      codigoEditaUsuario: {
        required: true,
        minlength: 0,
      },
      telefoneEditaUsuario: {
        required: true,
        minlength: 14,
      },
      celularEditaUsuario: {
        required: true,
        minlength: 14,
      },
      emailEditaUsuario: {
        required: true,
        email: true,
      },
      estadoEditaUsuario: {
        required: true,
        minlength: 1,
      },
      cidadeEditaUsuario: {
        required: true,
        minlength: 3,
      },
    },
    messages: {
      nomeEditaUsuario: {
        required: "Informe o nome do usuario.",
        minlength: "",
      },
      codigoEditaUsuario: {
        required: "Informe o código do usuario.",
        minlength: "",
      },
      cpfEditaUsuario: {
        required: "Informe o cpf do usuario.",
        minlength: "",
      },
      celularEditaUsuario: {
        required: "Informe o celular do usuario.",
        minlength: "",
      },
      emailEditaUsuario: {
        required: "Informe o email do usuario.",
        email: "Endereço de email invalido",
      },
      estadoEditaUsuario: {
        required: "Informe o estado do usuario.",
        minlength: "",
      },
      cidadeEditaUsuario: {
        required: "Informe o cidade do usuario.",
        minlength: "",
      },
    },
    errorElement: "span", //define o tipo a ser criado
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback"); //adiciona classe ao errorElement
      element.closest(".form-group").append(error); //Remove o errorElement
    },
    highlight: function (element) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element) {
      $(element).removeClass("is-invalid").addClass("is-valid");
    },
  });