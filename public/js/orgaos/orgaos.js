$(document).ready(function () {
  $("#editaOrgao").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var nomeOrgao = button.data("orgao-nome");
    var idOrgao = button.data("id-orgao");
    var codOrgao = button.data("cod-orgao");
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find(".modal-title").text(codOrgao + " - " + nomeOrgao);
    modal.find("#id_orgao").val(idOrgao);
    modal.find("#nome_orgao").val(nomeOrgao);
  });
});
