$(document).ready(function() {
    $("#recusar").on("show.bs.modal", function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id_proposta = button.data("id-proposta");
        var nomeAssociado = button.data("associado");
        var numProposta = button.data("num-proposta");
        var modal = $(this)
        modal.find("#id_proposta").val(id_proposta);
        modal.find("#associado").val(nomeAssociado);
        modal.find("#num_proposta").val(numProposta);
    });
});