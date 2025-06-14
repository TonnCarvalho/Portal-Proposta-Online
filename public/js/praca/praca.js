$(document).ready(function () {
  $("#editaPraca").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var nomePraca = button.data("praca");
    var codLocal = button.data("cod-local");
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find(".modal-title").text(codLocal + " - " + nomePraca);
    modal.find("#praca").val(nomePraca);
    modal.find("#cod_local").val(codLocal);
  });
});
