$(document).ready(function () {
  $("#cpfCadastro").mask("000.000.000-00", {
    reverse: false,
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

  $("#iof").mask("0.000,00", {
    reverse: true,
  });
  $("#taxa").mask("0.0", {
    reverse: true,
  });
});
$("#financiado").priceFormat({
  prefix: "",
  centsSeparator: ",",
  thousandsSeparator: ".",
});
$("#liberado").priceFormat({
  prefix: "",
  centsSeparator: ",",
  thousandsSeparator: ".",
});

$("#parcela").priceFormat({
  prefix: "",
  centsSeparator: ",",
  thousandsSeparator: ".",
});

$("#mensalidade").priceFormat({
  prefix: "",
  centsSeparator: ",",
  thousandsSeparator: ".",
});
$(document).ready(function () {
  $(".select2CpfCadastro").select2({
    placeholder: "ESCOLHA A PRAÇA",
  });
});

$(function () {
  bsCustomFileInput.init();
});
