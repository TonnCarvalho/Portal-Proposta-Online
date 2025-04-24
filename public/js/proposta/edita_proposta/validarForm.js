$("#propostaEdita").validate({
  ignore: ".ignore",
  rules: {
    nome: {
      required: true,
      minlength: 3,
    },
    rg: {
      required: true,
      minlength: 9,
    },
    orgao_exp: {
      required: true,
      minlength: 3,
    },
    email: {
      required: true,
      minlength: 3,
    },
    data_nasc: {
      required: true,
      minlength: 8,
    },
    nat: {
      required: true,
      minlength: 5,
    },
    sexo: {
      required: true,
      minlength: 1,
    },
    cel: {
      required: true,
      minlength: 15,
    },
    nome_mae: {
      required: true,
      minlength: 3,
    },
    estado_civil: {
      required: true,
      minlength: 1,
    },
    mat: {
      required: true,
      minlength: 3,
    },
    cod_orgao: {
      required: true,
      minlength: 1,
    },
    setor: {
      required: true,
      minlength: 3,
    },
    cargo: {
      required: true,
      minlength: 3,
    },
    ocupacao: {
      required: true,
    },
    data_admissao: {
      required: true,
    },
    cep: {
      required: true,
      minlength: 9,
    },
    uf: {
      required: true,
      minlength: 2,
    },
    municipio: {
      required: true,
      minlength: 3,
    },
    bairro: {
      required: true,
      minlength: 3,
    },
    endereco: {
      required: true,
      minlength: 3,
    },
    cod_corretor: {
      required: true,
      minlength: 3,
    },
    cod_local: {
      required: true,
      minlength: 3,
    },
    financiado: {
      required: true,
      minlength: 3,
    },
    tipo_proposta: {
      required: true,
      minlength: 1,
    },
    iof: {
      required: true,
      minlength: 2,
    },
    taxa: {
      required: true,
      minlength: 2,
    },
    banco: {
      required: true,
      minlength: 3,
    },
    conta: {
      required: true,
      minlength: 3,
    },
    agencia: {
      required: true,
      minlength: 3,
    },
    banco_pagamento: {
      required: true,
      minlength: 3,
    },
    conta_pagamento: {
      required: true,
      minlength: 3,
    },
    agencia_pagamento: {
      required: true,
      minlength: 3,
    },
    tipo_bancario: {
      required: true,
      minlength: 1,
    },
  },
  messages: {
    nome: {
      required: "Informe o nome do associado.",
      minlength: "",
    },
    rg: {
      required: "Informe o rg do associado.",
      minlength: "",
    },
    orgao_exp: {
      required: "Informe o órgão expedidor do associado.",
      minlength: "",
    },
    email: {
      required: "Informe o email do associado.",
      minlength: "",
    },
    data_nasc: {
      required: "Informe a data de associado.",
      minlength: "",
    },
    nat: {
      required: "Informe o local de nascimento do associado.",
      minlength: "",
    },
    sexo: {
      required: "Informe o sexo do associado.",
      minlength: "",
    },
    cel: {
      required: "Informe o número do celular do associado.",
      minlength: "",
    },
    nome_mae: {
      required: "Informe o nome da mãe do associado.",
      minlength: "",
    },
    estado_civil: {
      required: "Informe o estado civil do associado.",
      minlength: "",
    },
    mat: {
      required: "Informe a matrícula do associado.",
      minlength: "",
    },
    cod_orgao: {
      required: "Informe o órgão do associado.",
      minlength: "",
    },
    setor: {
      required: "Informe o setor de trabalho do associado.",
      minlength: "",
    },
    cargo: {
      required: "Informe o cargo do associado.",
      minlength: "",
    },
    ocupacao: {
      required: "Informe a ocupação do associado.",
      minlength: "",
    },
    data_admissao: {
      required: "Informe a data de admissão do associado.",
      minlength: "",
    },
    cep: {
      required: "Informe o cep do associado.",
      minlength: "",
    },
    uf: {
      required: "Informe o estado do associado.",
      minlength: "",
    },
    municipio: {
      required: "Informe o município do associado.",
      minlength: "",
    },
    bairro: {
      required: "Informe o bairro do associado.",
      minlength: "",
    },
    endereco: {
      required: "Informe o endereço ou a rua do associado.",
      minlength: "",
    },
    cod_corretor: {
      required: "Informe o código do corretor do associado.",
      minlength: "",
    },
    cod_local: {
      required: "Informe o nome do associado.",
      minlength: " ",
    },
    financiado: {
      required: "Informe o valor desejado.",
      minlength: "",
    },
    prazo: {
      required: "Informe o prazo.",
      minlength: "",
    },
    iof: {
      required: "Informe o iof.",
    },
    taxa: {
      required: "Informe a taxa.",
    },
    tipo_proposta: {
      required: "Informe o tipo da proposta",
      minlength: "",
    },
    banco: {
      required: "campo obrigatório",
      minlength: "",
    },
    conta: {
      required: "campo obrigatório",
      minlength: "",
    },
    agencia: {
      required: "campo obrigatório",
      minlength: "",
    },
    banco_pagamento: {
      required: "campo obrigatório",
      minlength: "",
    },
    conta_pagamento: {
      required: "campo obrigatório",
      minlength: "",
    },
    agencia_pagamento: {
      required: "campo obrigatório",
      minlength: "",
    },
    tipo_bancario: {
      required: "campo obrigatório",
      minlength: "",
    },
  },
  errorElement: "span", //define o tipo a ser criado
  errorPlacement: function (error, element) {
    error.addClass("invalid-feedback"); //adiciona classe ao errorElement
    element.closest(".form-group").append(error); //Remove o errorElement
  },
  highlight: function (element, errorClass, validClass) {
    $(element).addClass("is-invalid").removeClass("is-valid");
  },
  unhighlight: function (element, errorClass, validClass) {
    $(element).removeClass("is-invalid").addClass("is-valid");
  },
});
