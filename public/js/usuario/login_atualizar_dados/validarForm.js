$(document).ready(function() {
  // Inicializa o validador
  $("#atualizarUsuarioLogin").validate({
    rules: {
      nome: {
        required: true,
        minlength: 3,
      },
      cpf: {
        required: true,
        minlength: 14,
      },
      celular: {
        required: true,
        minlength: 15,
      },
      email: {
        required: true,
        minlength: 7,
        email: true
      },
      estado: {
        required: true,
        minlength: 1,
      },
      cidade: {
        required: true,
        minlength: 5,
      },
    },
    messages: {
      nome: {
        required: "Informe seu nome.",
        minlength: "O nome deve ter pelo menos 3 caracteres.",
      },
      cpf: {
        required: "Informe seu CPF.",
        minlength: "O CPF deve ter 14 caracteres.",
      },
      celular: {
        required: "Informe seu celular.",
        minlength: "O celular deve ter 15 caracteres.",
      },
      email: {
        required: "Informe email.",
        email: "Email incorreto.",
        minlength: "O email deve ter pelo menos 7 caracteres.",
      },
      estado: {
        required: "Informe estado.",
        minlength: "O estado deve ter pelo menos 1 caractere.",
      },
      cidade: {
        required: "Informe sua cidade.",
        minlength: "A cidade deve ter pelo menos 5 caracteres.",
      },
    },
    errorElement: "span", // define o tipo a ser criado
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback"); // adiciona classe ao errorElement
      element.closest(".form-group").append(error); // Remove o errorElement
    },
    highlight: function (element) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element) {
      $(element).removeClass("is-invalid").addClass("is-valid");
    },
  });

  // Força a validação ao carregar a página
  $("#atualizarUsuarioLogin").valid();
});