function validarInputPraca() {
    //TODO Precisa validar os inputs nome, cpf, data de nascimento.
  const inputPraca = document.querySelector("#praca");
  if (praca.value != "") {
    inputPraca.classList.remove("border-danger");
    return true;
  } else {
    inputPraca.classList.add("border-danger");
    notificacao.erro("Selecione a praça");
    return false;
  }
}
