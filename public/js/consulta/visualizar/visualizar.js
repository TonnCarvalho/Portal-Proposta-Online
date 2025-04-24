const inputResposta = document.querySelectorAll("#resposta");

inputResposta.forEach((input) => {
  input.addEventListener("focusout", () => {
    if (input.value != "") {
      input.classList.remove("border-danger");
      input.classList.add("border-success");
    } else {
      input.classList.add("border-danger");
    }
  });
});

function validarResposta() {
  let validacao = false;
  
  inputResposta.forEach((input) => {
    if (input.value != "") {
      validacao = true;
    } else {
      validacao = false;
    }
  });

  if (!validacao) {
    notificacao.erro("Preencha todas as respostas");
  }

  return validacao;
}
