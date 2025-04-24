$(document).ready(function () {
    $("#editaUsuario").on("show.bs.modal", function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var idUsuario = button.data("id");
      var nomeUsuario = button.data("usuario");
      var codCorretor = button.data("cod-corretor");
      var cpf = button.data("cpf");
      var tel = button.data("tel");
      var cel = button.data("cel");
      var email = button.data("email");
      var uf = button.data("uf");
      var cidade = button.data("cidade");
      var nivel = button.data("nivel");

      var modal = $(this);
      modal.find(".modal-title").text(nomeUsuario);
      modal.find("#id_usuario").val(idUsuario);
      modal.find("#nomeEditaUsuario").val(nomeUsuario);
      modal.find("#codigoEditaUsuario").val(codCorretor);
      modal.find("#cpfEditaUsuario").val(cpf);
      modal.find("#cpfEditaUsuarioMaster").val(cpf);
      modal.find("#telefoneEditaUsuario").val(tel);
      modal.find("#celularEditaUsuario").val(cel);
      modal.find("#emailEditaUsuario").val(email);
      modal.find("#estadoEditaUsuario").val(uf);
      modal.find("#cidadeEditaUsuario").val(cidade);
      modal.find("#nivelEditaUsuario").val(nivel);

      if (cpf !== '') {
        modal.find("#cpfEditaUsuario").attr('readonly', true);
    } else {
        modal.find("#cpfEditaUsuario").removeAttr('readonly');
    }
    });
  });
  