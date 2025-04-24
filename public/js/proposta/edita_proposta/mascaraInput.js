$(document).ready(function () {
  $("#financiado").mask("000.000,00", {
    reverse: true,
  });
  $("#liberado").mask("000.000,00", {
    reverse: true,
  });
  $("#parcela").mask("0.000,00", {
    reverse: true,
  });
  $("#mensalidade").mask("0.000,00", {
    reverse: true,
  });
  $("#iof").mask("0.000,00", {
    reverse: true,
  });
  $("#taxa").mask("0.0", {
    reverse: true,
  });

  $("#cpf").mask("000.000.000-00", {
    reverse: true,
  });

  $("#cel").mask("(00) 00000-0000", {
    reverse: false,
  });
  $("#tel").mask("(00) 0000-0000", {
    reverse: false,
  });
  $("#cep").mask("00000-000", {
    reverse: false,
  });
});
