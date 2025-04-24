$("#usuarioCadastro").validate({
  ignore: ".ignore",
  rules: {
    nome: {
      required: true,
      minlength: 4,
    },
    codigo: {
      required: true,
      minlength: 0,
    },
    senha: {
      required: true,
      minlength: 4,
    },
    confirmaSenha: {
      minlength: 4,
      equalTo: "#senha",
    },
    cpf: {
      required: true,
      minlength: 14,
    },
    celular: {
      required: true,
      minlength: 14,
    },
    email: {
      required: true,
      email: true,
    },
    estado: {
      required: true,
      minlength: 1,
    },
    cidade: {
      required: true,
      minlength: 3,
    },
  },
  messages: {
    nome: {
      required: "Informe o nome do usuario.",
      minlength: "",
    },
    codigo: {
      required: "Informe o código do usuario.",
      minlength: "",
    },
    senha: {
      required: "Minimo são 4 digitos",
      minlength: "",
    },
    confirmaSenha: {
      required: "Confirme a senha",
      equalTo: "Senha incorreta",
      minlength: "",
    },
    cpf: {
      required: "Informe o cpf do usuario.",
      minlength: "",
    },
    celular: {
      required: "Informe o celular do usuario.",
      minlength: "",
    },
    email: {
      required: "Informe o email do usuario.",
      email: "Endereço de email invalido",
    },
    estado: {
      required: "Informe o estado do usuario.",
      minlength: "",
    },
    cidade: {
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