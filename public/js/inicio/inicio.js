$(document).ready(function () {
  $("#situacao").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var nomeAssociado = button.data("nome");
    var id_proposta = button.data("id-proposta");
    var statusProposta = button.data("status-proposta");
    var statusRecusado = button.data("status-recusado");
    var statusAssinatura = button.data("status-assinatura");
    var statusRefin = button.data("status-refin");
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find(".modal-title").text(nomeAssociado);
    modal.find("#id_proposta").val(id_proposta);
    modal.find("#status_proposta").val(statusProposta);
    modal.find("#status_assinatura").val(statusAssinatura);
    modal.find("#status_recusado").val(statusRecusado);
    modal.find("#status_refin").val(statusRefin);
  });
});