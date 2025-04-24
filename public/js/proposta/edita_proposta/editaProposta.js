//Mostra o nome do arquivo dentro do input file
$(function () {
  bsCustomFileInput.init();
});
//Gerar arquivo em PDF
function juntarEmPDF(id_proposta, num_proposta) {
  location.href =
    "/juntar-img-pdf?id_proposta=" +
    id_proposta +
    "&num_proposta=" +
    num_proposta;
}

//Conferido
function conferirProposta(id_proposta) {
  location.href = `/conferir-proposta?id_proposta=${id_proposta}`
}
