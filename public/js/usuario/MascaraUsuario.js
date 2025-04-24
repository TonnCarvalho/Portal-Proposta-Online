$(document).ready(function () { 
  $("#cpf").mask("000.000.000-00", {
    reverse: false,
  });

  $("#celular").mask("00 0 0000-0000", {
    reverse: false,
  });
  $("#telefone").mask("00 00000000", {
    reverse: false,
  });

  $("#cpfEditaUsuario").mask("000.000.000-00", {
    reverse: false,
  });

  $("#celularEditaUsuario").mask("00 0 0000-0000", {
    reverse: false,
  });
  $("#telefoneEditaUsuario").mask("00 00000000", {
    reverse: false,
  });
});
