$(document).ready(function () {
  $("#alteraSenha").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var idUsuario = button.data("id");
    var nomeUsuario = button.data("usuario");
    var codCorretor = button.data("cod-corretor");

    var modal = $(this);
    modal.find(".modal-title").text(codCorretor + ' - ' + nomeUsuario);
    modal.find("#id_usuario_altera_senha").val(idUsuario);
    modal.find("#nomeEditaUsuario").val(nomeUsuario);
    modal.find("#codigoEditaUsuario").val(codCorretor);
  });
});
