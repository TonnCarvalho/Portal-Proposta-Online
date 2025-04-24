function validarPrazo() {
  // Cria um objeto Date com o valor do input 'date'
  let data_nascimento = document.getElementById("data_nasc");
  let prazo = document.getElementById("prazo");
  let msgPrazo = document.getElementById("msgPrazo");

  let date = new Date(data_nascimento.value);

  // // Obtém a data atual
  let dataHoje = new Date();

  // Calcula a diferença em meses
  let meses = (dataHoje.getFullYear() - date.getFullYear()) * 12;
  meses -= date.getMonth();
  meses += dataHoje.getMonth();

  // // Soma o prazo aos meses
  let total = parseInt(prazo.value) + meses;

  if (total > 839 || prazo.value.length === 0) {
    prazo.classList.add("is-invalid");
    msgPrazo.classList.remove("d-none");
    prazo.focus();
    return false;
  } else {
    prazo.classList.remove("is-invalid");
    prazo.classList.add("is-valid");
    msgPrazo.classList.add("d-none");
    return true;
  }
}
